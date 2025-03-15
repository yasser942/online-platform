<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Subscription;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use App\Enums\SubscriptionStatus;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use App\Filament\Resources\SubscriptionResource\Pages;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Subscriptions Management';

    public static function getNavigationLabel(): string
    {
        return __('dashboard.sidebar.subscriptions');
    }
    public static function getNavigationGroup(): ?string
    {
        return __('dashboard.sidebar.subscriptions-management');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name', function ($query) {
                        return $query->whereHas('roles', function ($q) {
                            $q->where('name', 'panel_user');
                        })->whereDoesntHave('subscriptions', function ($q) {
                            $q->where('status', 'active');
                        });
                    })
                    ->searchable()
                    ->required(),

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
                    ->required()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $plan = \App\Models\Plan::find($get('plan_id'));
                        $set('end_date', Carbon::parse($state)->addDays($plan->duration)->format('Y-m-d'));
                    }),
                    
                     
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->sortable()->searchable(),
                TextColumn::make('plan.name')->sortable()->searchable(),
                TextColumn::make('price')->numeric(decimalPlaces: 2)->prefix('$'),
                TextColumn::make('start_date')->date(),
                TextColumn::make('end_date')->date(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (SubscriptionStatus $state): string => $state->getColor()),
                TextColumn::make('created_at')->dateTime('d-m-Y H:i:s'),
                TextColumn::make('updated_at')->dateTime('d-m-Y H:i:s'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(
                        SubscriptionStatus::class
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}
