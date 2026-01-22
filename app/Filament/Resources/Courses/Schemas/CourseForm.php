<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    TextInput::make('title')
                        ->live(onBlur: true)
                        ->afterStateUpdated(
                            function (Set $set,Get $get, ?string $state) {
                                if (blank($get('slug')) && filled($state)) {
                                    $set('slug', Str::slug($state));
                                }
                            }
                        )
                        ->required(),
                    TextInput::make('slug')
                        ->readOnly()
                        ->required()
                        ->unique(ignoreRecord: true),
                    RichEditor::make('description')
                        ->extraInputAttributes([
                            'style' => 'min-height: 100px',
                        ]),
                    ToggleButtons::make('status')
                        ->options([
                            'draft' => 'Draft',
                            'published' => 'Published',
                        ])
                        ->default('draft'),
                ]),
                Section::make([
                    FileUpload::make('thumbnail_path')
                        ->image()
                        ->imageEditor()
                        ->label('Thumbnail'),
                    FileUpload::make('intro_video_url')
                        ->disk('public')
                        ->directory('courses/intro')
                        ->acceptedFileTypes(['video/mp4', 'video/avi', 'video/webm'])
                        ->maxSize(204800)
                        ->label('Introduction video'),
                    TextInput::make('duration')
                        ->label('Duration (minutes)')
                        ->integer()
                        ->minValue(1)
                        ->nullable(),
                    Repeater::make('prerequisites')
                        ->label('Prerequisites')
                        ->simple(
                            TextInput::make('value')
                                ->required()
                                ->maxLength(255)
                        )
                        ->defaultItems(0)
                        ->addActionLabel('Add prerequisite')
                ]),
            ]);
    }
}
