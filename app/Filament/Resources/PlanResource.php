<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Plan;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\Status;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PlanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PlanResource\RelationManagers;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Subscriptions Management';
    public static function getNavigationLabel(): string
    {
        return __('dashboard.sidebar.plans');
    }
    public static function getNavigationGroup(): ?string
    {
        return __('dashboard.sidebar.subscriptions-management');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->minValue(0),

                Forms\Components\TextInput::make('duration')
                    ->required()
                    ->numeric()
                    ->minValue(0),
                Forms\Components\Select::make('status')
                    ->options(Status::class)
                    ->required()
                    ->default(Status::ACTIVE->value),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('description')
                ->limit(50)
                ,
                TextColumn::make('price')
                    ->numeric(decimalPlaces: 2)
                    ->prefix('$ '),
                TextColumn::make('duration')
                    ->numeric()
                    ->suffix(' days'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (Status $state): string => $state->getColor()),
                   
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'edit' => Pages\EditPlan::route('/{record}/edit'),
        ];
    }
}
