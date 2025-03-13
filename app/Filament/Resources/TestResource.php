<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Test;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TestResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TestResource\RelationManagers;
use App\Filament\Resources\TestResource\RelationManagers\QuestionsRelationManager;
use Filament\Forms\Components\Repeater;
use App\Enums\Status;
class TestResource extends Resource
{
    protected static ?string $model = Test::class;
    protected static ?string $navigationGroup = 'Courses Management'; // This will create a tab in the sidebar
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    public static function getNavigationLabel(): string
    {
        
        return __('dashboard.sidebar.tests');
    }
    public static function getNavigationGroup(): ?string
    {
        return __('dashboard.sidebar.courses-management');
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
            Forms\Components\Select::make('lesson_id')
                ->relationship('lesson', 'name')
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
                Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'success' => 'active',
                    'danger' => 'passive',
                ]),
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
            //QuestionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTests::route('/'),
            'create' => Pages\CreateTest::route('/create'),
            'edit' => Pages\EditTest::route('/{record}/edit'),
        ];
    }
}
