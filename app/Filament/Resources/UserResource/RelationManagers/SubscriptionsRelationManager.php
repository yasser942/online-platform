<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use App\Models\Plan;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use App\Enums\SubscriptionStatus;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Exports\SubscriptionExporter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class SubscriptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'subscriptions';
   

    public function form(Form $form): Form
    {
        return $form
            ->schema([
               
                Select::make('plan_id')
                    ->relationship('plan', 'name')
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                      
                        $plan = \App\Models\Plan::find($state);
                        // Set price automatically from selected plan
                        $set('price', $plan->price);

                        // Set start_date to current date if not already set
                        $startDate = now()->format('Y-m-d');
                        $set('start_date', $startDate);

                        // Set end_date based on start_date + plan duration
                        $set('end_date', \Illuminate\Support\Carbon::parse($startDate)->addDays($plan->duration)->format('Y-m-d'));
                    
                    }),

                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->live()
                    ->readOnly()
                    
                    ->prefix('$')
                    ->required(),

                DatePicker::make('start_date')
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    $plan = \App\Models\Plan::find($get('plan_id'));
                    $set('end_date', Carbon::parse($state)->addDays($plan->duration)->format('Y-m-d'));
                })
              
                    ->required()
                     ,
                DatePicker::make('end_date')
                ->readOnly()
                    ->required()
                    ,
                    

                    Select::make('status')
                    ->options(
                        collect(SubscriptionStatus::filteredCases())
                                ->mapWithKeys(fn ($case) => [
                                    $case->value => $case->getLabel()
            ])
            ->toArray()
                    )
                    ->default(SubscriptionStatus::ACTIVE->value) // Default to 'active'
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('plan.name')
            ->columns([
                Tables\Columns\TextColumn::make('plan.name'),
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('user.email'),
                Tables\Columns\TextColumn::make('price'),
                Tables\Columns\TextColumn::make('start_date'),
                Tables\Columns\TextColumn::make('end_date'),
                Tables\Columns\BadgeColumn::make('status')
                ->color(fn (SubscriptionStatus $state): string => $state->getColor()),
               
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(SubscriptionStatus::class),
                    
                    
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->visible(fn () => 
                        $this->getOwnerRecord()->hasRole('panel_user') && 
                        !$this->getRelationship()->where('status', 'active')->exists()
                    ),
                    ExportAction::make()
                ->exporter(SubscriptionExporter::class)
            ])
            
            
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
                    ->exporter(SubscriptionExporter::class),
                    Tables\Actions\ExportBulkAction::make()
                ]),
            ]);

            

    }
    

}
