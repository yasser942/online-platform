<?php

namespace App\Filament\Resources\ExamResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class SubmissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'submissions';

    protected static ?string $recordTitleAttribute = 'id';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('score')
                    ->numeric()
                    ->readOnly(),
                Forms\Components\TextInput::make('max_score')
                    ->numeric()
                    ->readOnly(),
                Forms\Components\DateTimePicker::make('completed_at')
                    ->readOnly(),
                Forms\Components\Section::make('Answers')
                    ->columnSpanFull()
                    ->schema([
                        Forms\Components\Placeholder::make('answer_details')
                            ->content(function ($record) {
                                if (!$record || !$record->answers) {
                                    return 'No answers found.';
                                }
                                
                                $answers = $record->answers;
                                $html = '<div class="space-y-4">';
                                
                                // Get the exam related to this submission
                                $exam = $record->exam;
                                
                                // Get all questions for this exam with their choices
                                $questions = $exam->questions()->with('choices')->get();
                                
                                foreach ($questions as $question) {
                                    $questionId = $question->id;
                                    $selectedChoiceId = $answers[$questionId] ?? null;
                                    
                                    $html .= '<div class="border p-4 rounded">';
                                    $html .= '<div class="font-medium text-lg mb-2">' . htmlspecialchars($question->question_text) . '</div>';
                                    
                                    // Find the selected choice
                                    $selectedChoice = null;
                                    $correctChoice = null;
                                    
                                    foreach ($question->choices as $choice) {
                                        if ($choice->id == $selectedChoiceId) {
                                            $selectedChoice = $choice;
                                        }
                                        
                                        if ($choice->is_correct === 'true') {
                                            $correctChoice = $choice;
                                        }
                                    }
                                    
                                    // Show the selected answer
                                    if ($selectedChoice) {
                                        $isCorrect = $selectedChoice->is_correct === 'true';
                                        $colorClass = $isCorrect ? 'text-green-600' : 'text-red-600';
                                        
                                        $html .= '<div class="ml-4 mt-2">';
                                        $html .= '<div class="font-medium">Selected Answer:</div>';
                                        $html .= '<div class="' . $colorClass . '">' . htmlspecialchars($selectedChoice->choice_text) . '</div>';
                                        
                                        // If the answer is wrong, show the correct one
                                        if (!$isCorrect && $correctChoice) {
                                            $html .= '<div class="mt-2 font-medium">Correct Answer:</div>';
                                            $html .= '<div class="text-green-600">' . htmlspecialchars($correctChoice->choice_text) . '</div>';
                                        }
                                        
                                        $html .= '</div>';
                                    } else {
                                        $html .= '<div class="ml-4 mt-2 text-gray-500">No answer selected</div>';
                                    }
                                    
                                    $html .= '</div>';
                                }
                                
                                $html .= '</div>';
                                return new HtmlString($html);
                            })
                    ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('score_percentage')
                    ->label('Percentage')
                    ->getStateUsing(function ($record): string {
                        if ($record->max_score > 0) {
                            $percentage = ($record->score / $record->max_score) * 100;
                            return number_format($percentage, 2) . '%';
                        }
                        return 'N/A';
                    }),
                Tables\Columns\TextColumn::make('completed_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('high_scores')
                    ->label('High Scores (80%+)')
                    ->query(function (Builder $query): Builder {
                        return $query->whereRaw('(score / max_score) * 100 >= 80');
                    }),
                Tables\Filters\Filter::make('low_scores')
                    ->label('Low Scores (Below 50%)')
                    ->query(function (Builder $query): Builder {
                        return $query->whereRaw('(score / max_score) * 100 < 50');
                    }),
            ])
            ->headerActions([
                // No create action as submissions are created by users taking exams
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
