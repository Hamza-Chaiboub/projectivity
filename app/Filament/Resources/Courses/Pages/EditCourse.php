<?php

namespace App\Filament\Resources\Courses\Pages;

use App\Filament\Resources\Courses\CourseResource;
use App\Services\MoodleClient;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditCourse extends EditRecord
{
    protected static string $resource = CourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('createInMoodle')
            ->label('Create In Moodle')
            ->icon('heroicon-o-cloud-arrow-up')
            ->visible(fn () => blank($this->record->moodle_course_id))
            ->requiresConfirmation()
            ->action(function (MoodleClient $moodleClient) {
                try {
                    $shortname = (string) $this->record->slug;
                    $id = $moodleClient->createCourse(
                        fullname: (string) $this->record->title,
                        shortname: $shortname,
                        summary: (string) ($this->record->description ?? ''),
                    );

                    $this->record->update([
                        'moodle_course_id' => $id,
                        'moodle_shortname' => $shortname,
                    ]);

                    Notification::make()
                        ->title("Created and linked Moodle course #{$id}")
                        ->success()
                        ->send();
                } catch (\Throwable $e) {
                    Notification::make()
                        ->title("Failed to create Moodle course")
                        ->body($e->getMessage())
                        ->danger()
                        ->send();
                }
            }),

            Action::make('linkMoodleCourse')
                ->label('Link existing Moodle course')
                ->icon('heroicon-o-link')
                ->visible(fn () => blank($this->record->moodle_course_id))
                ->schema([
                    Radio::make('link_by')
                        ->options([
                            'id' => 'Course ID',
                            'shortname' => 'Shortname'
                        ])
                        ->default('id')
                        ->required(),
                    TextInput::make('value')
                        ->label('Value')
                        ->required()
                ])
                ->action(function (array $data, MoodleClient $moodleClient) {
                    try {
                        $course = null;

                        if (($data['link_by'] ?? 'id') === 'id') {
                            $course = $moodleClient->getCourseById((int) $data['value']);
                        } else  {
                            $course = $moodleClient->getCourseByShortname($data['value']);
                        }

                        if (!$course) {
                            Notification::make()
                                ->title('Moodle course not found')
                                ->danger()
                                ->send();
                            return;
                        }

                        $this->record->update([
                            'moodle_course_id' => (int) $course['id'],
                            'moodle_shortname' => $course['shortname'] ?? null
                        ]);

                        Notification::make()
                            ->title("Linked to Moodle course #{$course['id']}")
                            ->success()
                            ->send();
                    } catch (\Throwable $e) {
                        Notification::make()
                            ->title("Failed to link to Moodle course")
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            DeleteAction::make(),
        ];
    }
}
