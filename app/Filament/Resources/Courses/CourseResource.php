<?php

namespace App\Filament\Resources\Courses;

use App\Filament\Resources\Courses\Pages\CreateCourse;
use App\Filament\Resources\Courses\Pages\EditCourse;
use App\Filament\Resources\Courses\Pages\ListCourses;
use App\Filament\Resources\Courses\Pages\ViewCourse;
use App\Filament\Resources\Courses\Schemas\CourseForm;
use App\Filament\Resources\Courses\Tables\CoursesTable;
use App\Models\Course;
use App\Models\User;
use BackedEnum;
use Carbon\CarbonInterval;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return CourseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CoursesTable::configure($table);
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
            'index' => ListCourses::route('/'),
            'create' => CreateCourse::route('/create'),
            'edit' => EditCourse::route('/{record}/edit'),
            'show' => ViewCourse::route('/{record}'),
        ];
    }

    public static function infolist(Schema $schema): Schema
    {
//        note to self: refactor this into a separate class to this clean
        return $schema
            ->schema([
                EditAction::make(),
                Grid::make()->schema([
                    Section::make('Overview')
                        ->schema([
                            TextEntry::make('title')->weight('bold'),

                            TextEntry::make('status')
                                ->badge()
                                ->color(fn (string $state) => $state === 'published' ? 'success' : 'gray'),

                            TextEntry::make('published_at')
                                ->label('Published at')
                                ->dateTime()
                                ->placeholder('—'),

                            TextEntry::make('description')
                                ->markdown()
                                ->placeholder('—'),
                        ]),

                    Section::make('Media')
                        ->schema([
                            ImageEntry::make('thumbnail_path')
                                ->label('Thumbnail')
                                ->imageHeight(180)
                                ->square()
                                ->placeholder('—'),

                            TextEntry::make('intro_video_url')
                                ->label('Intro video')
                                ->url(fn ($state) => $state)
                                ->openUrlInNewTab()
                                ->placeholder('—'),

                            TextEntry::make('duration')
                                ->label('Duration')
                                ->formatStateUsing(function ($state) {
                                    if (! $state) return '—';
                                    return CarbonInterval::minutes($state)->cascade()->forHumans();
                                })
                                ->placeholder('—'),
                        ]),
                ])->columnSpanFull(),

                Section::make('Author & Prerequisites')
                    ->schema([
                        TextEntry::make('created_by')
                            ->formatStateUsing(function ($state) {
                                return User::find($state)->name;
                            })
                            ->label('Author'),
                        TextEntry::make('prerequisites')
                            ->label(fn () => '')
                            ->bulleted()
                    ]),

                Section::make('Moodle Link')
                    ->schema([
                        Grid::make(3)->schema([
                            TextEntry::make('moodle_course_id')
                                ->label('Moodle course ID')
                                ->placeholder('Not linked'),

                            TextEntry::make('moodle_shortname')
                                ->label('Moodle shortname')
                                ->placeholder('—'),

                            IconEntry::make('moodle_course_id')
                                ->label('Linked')
                                ->boolean()
                                ->trueIcon('heroicon-o-check-circle')
                                ->falseIcon('heroicon-o-x-circle'),
                        ]),
                    ]),
            ])->columns(['sm' => 4, 'md' => 3, 'lg' => 2, 'xl' => 1]);
    }
}
