<?php

namespace App\Filament\Resources\LessonResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Hugomyb\FilamentMediaAction\Tables\Actions\MediaAction;

use Filament\Resources\RelationManagers\RelationManager;


class PdfsRelationManager extends RelationManager
{
    protected static string $relationship = 'pdfs';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('url')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'passive' => 'Passive',
                    ])
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('url')
                ->icon('heroicon-o-link')
                ->limit(10),
                
                
                Tables\Columns\TextColumn::make('description')->limit(50),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'active',
                        'danger' => 'passive',
                    ]),
                    
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
                MediaAction::make()
                    ->media(fn($record) => $record->url)
                    ->modalHeading(fn($record) => $record->name)
                    ->icon('heroicon-o-document')
                   
                    
                ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
