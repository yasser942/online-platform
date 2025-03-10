<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Question;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\QuestionResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\QuestionResource\RelationManagers;
use App\Filament\Resources\QuestionResource\RelationManagers\ChoicesRelationManager;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;
    protected static ?string $navigationGroup = 'Courses Management'; // This will create a tab in the sidebar
    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle'; // Changed the navigation icon to a question mark
    public static function getNavigationLabel(): string
    {
        return __('dashboard.sidebar.questions');
    }
    public static function getNavigationGroup(): ?string
    {
        return __('dashboard.sidebar.courses-management');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('question_text')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('test_id')
                    ->relationship('test', 'name')
                    ->required(),

                Repeater::make('choices')
                    ->relationship('choices')
                    ->label('Choices')
                    ->columnSpanFull()

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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question_text')
                ->limit(10),
                Tables\Columns\TextColumn::make('test.name'),
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
            //ChoicesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}
