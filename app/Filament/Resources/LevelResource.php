<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Level;
use Pages\ListLevels;
use App\Models\Course;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CourseResource\RelationManagers;
use App\Filament\Resources\LevelResource\Pages;


class LevelResource extends Resource
{
    protected static ?string $model = Level::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3-bottom-left';
    protected static ?string $navigationGroup = 'Courses Management'; // This will create a tab in the sidebar
    public static function getNavigationLabel(): string
    {
        return __('dashboard.sidebar.levels');
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
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'active' => 'Active',
                        'passive' => 'Passive',
                    ])
                    ->default('active'),
                    Forms\Components\Select::make('course_id')
                    ->required()
                    ->relationship('course', 'name'),
                    
                    

                    Forms\Components\FileUpload::make('thumbnail')
                    ->required()
                    ->image()
                    ->disk('public')
                    ->directory('levels')

                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail'),
                        
                        
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'active',
                        'danger' => 'passive',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                    
                    
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
            'index' =>Pages\ListLevels::route('/'),
            'create'=> Pages\CreateLevel::route('/create'),
            'edit'=> Pages\EditLevel::route('/{record}/edit'),
        ];
    }
}
