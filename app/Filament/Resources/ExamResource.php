<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Exam;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\ExamResource\Pages;
use App\Filament\Resources\ExamResource\RelationManagers;
use Filament\Forms\Components\Repeater;
use App\Enums\Status;

class ExamResource extends Resource
{
    protected static ?string $model = Exam::class;
    protected static ?string $navigationGroup = 'Courses Management';
    protected static ?string $navigationIcon = 'heroicon-o-numbered-list';

    public static function getNavigationLabel(): string
    {
        return 'Exams';
    }
    
    public static function getNavigationGroup(): ?string
    {
        return 'Courses Management';
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
                Forms\Components\Select::make('status')
                    ->options(Status::class)
                    ->required(),
                Forms\Components\Select::make('level_id')
                    ->relationship('level', 'name')
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50),
                Tables\Columns\TextColumn::make('level.name')
                    ->label('Level'),
                Tables\Columns\BadgeColumn::make('status')
                    ->color(fn (Status $state): string => $state->getColor()),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            RelationManagers\SubmissionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExams::route('/'),
            'create' => Pages\CreateExam::route('/create'),
            'edit' => Pages\EditExam::route('/{record}/edit'),
            'view' => Pages\ViewExam::route('/{record}'),
        ];
    }
}
