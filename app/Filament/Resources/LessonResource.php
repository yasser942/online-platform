<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Lesson;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\LessonResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LessonResource\RelationManagers;
use App\Filament\Resources\LessonResource\RelationManagers\PdfsRelationManager;
use App\Filament\Resources\LessonResource\RelationManagers\TestsRelationManager;
use App\Filament\Resources\LessonResource\RelationManagers\VideosRelationManager;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Courses Management'; // This will create a tab in the sidebar
    public static function getNavigationLabel(): string
    {
        return __('dashboard.sidebar.lessons');
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
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('unit_id')
                    ->relationship('unit', 'name')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'passive' => 'Passive',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('description')
                ->limit(50),
                Tables\Columns\TextColumn::make('unit.name'),
                Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'success' => 'active',
                    'danger' => 'passive',
                ]),            ])
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
            PdfsRelationManager::class,
            VideosRelationManager::class,
            TestsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLessons::route('/'),
            'create' => Pages\CreateLesson::route('/create'),
            'edit' => Pages\EditLesson::route('/{record}/edit'),
        ];
    }
}
