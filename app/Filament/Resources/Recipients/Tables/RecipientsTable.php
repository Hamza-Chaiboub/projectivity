<?php

namespace App\Filament\Resources\Recipients\Tables;

use App\Filament\Exports\RecipientExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\ExportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;

class RecipientsTable
{
    public static function configure(Table $table): Table
    {
        $recipientCountries = DB::table('recipients')
            ->selectRaw('count(*) as total, country')
            ->groupBy('country')
            ->pluck('total', 'country')
            ->all();

        $formattedCountries = self::getCountries($recipientCountries);

        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('country')
                    ->formatStateUsing(fn ($state) => Countries::getName(strtoupper(trim((string) $state)), app()->getLocale()) ?? $state)
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        $search = trim($search);

                        if ($search === '') {
                            return $query;
                        }

                        $locale = app()->getLocale();

                        // Cache the map: [ 'FR' => 'France', ... ]
                        $countries = Cache::remember("countries_names_$locale", 86400, fn () => Countries::getNames($locale));

                        $needle = mb_strtolower($search);

                        // Find country codes whose localized name matches the search term
                        $matchingCodes = collect($countries)
                            ->filter(fn (string $name) => str_contains(mb_strtolower($name), $needle))
                            ->keys()
                            ->all();

                        return $query->where(function (Builder $q) use ($search, $matchingCodes) {
                            // allow searching by code too (e.g., "FR")
                            $q->where('country', 'like', strtoupper($search) . '%');

                            if (! empty($matchingCodes)) {
                                $q->orWhereIn('country', $matchingCodes);
                            }
                        });
                    }),
            ])
            ->filters([
                SelectFilter::make('country')
                    ->options($formattedCountries),
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(RecipientExporter::class)
            ])
            ->recordUrl(null);
    }

    public static function getCountries(array $countries): array
    {
        arsort($countries); // if you want to sort by count desc

        $locale = app()->getLocale();

        $items = [];
        foreach ($countries as $code => $count) {
            $items[$code] = Countries::getName($code, $locale) ?? $code;
        }

        return $items;
    }
}
