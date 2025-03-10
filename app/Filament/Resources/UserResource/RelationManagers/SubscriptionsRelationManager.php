<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;

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
                ->readOnly()
                // ->reactive()
                // ->afterStateUpdated(function ($state) {
                //     dd($state);
                // })
                    ->required()
                     ,
                DatePicker::make('end_date')
                ->readOnly()
                    ->required()
                     
                    ,
                    

                Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'canceled' => 'Canceled',
                        'expired' => 'Expired',
                    ])
                    ->default('active')
                    ->required()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('plan.name')
            ->columns([
                Tables\Columns\TextColumn::make('plan.name'),
                Tables\Columns\TextColumn::make('price'),
                Tables\Columns\TextColumn::make('start_date'),
                Tables\Columns\TextColumn::make('end_date'),
                Tables\Columns\TextColumn::make('status'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'canceled' => 'Canceled',
                        'expired' => 'Expired',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->visible(fn () => !$this->getOwnerRecord()->subscriptions()->where('status', 'active')->exists()),
            ])
            
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
