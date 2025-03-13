<?php

namespace App\Filament\Resources\LevelResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use App\Enums\Status;
use Filament\Forms\Components\Repeater;

class ExamsRelationManager extends RelationManager
{
    protected static string $relationship = 'exams';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('description')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('status')
                    ->options(Status::class)
                    ->required(),

                Repeater::make('questions')
                    ->relationship('questions')
                    ->label('Questions')
                    ->defaultItems(10)
                    ->columnSpanFull()
                    ->schema([
                        Forms\Components\TextInput::make('question_text')
                            ->required()
                            ->maxLength(255),
                        Repeater::make('choices')
                            ->relationship('choices')
                            ->label('Choices')
                            ->columnSpanFull()
                            ->defaultItems(4)
                            ->schema([
                                Forms\Components\TextInput::make('choice_text')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Select::make('is_correct')
                                    ->options([
                                        'true' => 'True',
                                        'false' => 'False',
                                    ])
                                    ->required(),
                            ]),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('level.name'),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (Status $state): string => $state->getColor()),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
