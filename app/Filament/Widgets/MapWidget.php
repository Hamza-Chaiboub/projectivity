<?php

namespace App\Filament\Widgets;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;
use InfinityXTech\FilamentWorldMapWidget\Widgets\WorldMapWidget;
use Symfony\Component\Intl\Countries;

class MapWidget extends WorldMapWidget
{
    protected int | string | array $columnSpan = 3;

    protected string $view = 'widgets.world-map-widget';

    public function legendItems(): array
    {
        $stats = $this->stats();
        arsort($stats);

        $locale = app()->getLocale();

        $items = [];
        foreach ($stats as $code => $count) {
            $items[$code] = [
                'code'  => $code,
                'name'  => Countries::getName($code, $locale) ?? $code,
                'count' => $count,
            ];
        }

        return $items;
    }

    public function stats (): array {
        $all_recipients = DB::table('recipients')
                        ->select(DB::raw('count(*) as total, country'))
                        ->groupBy('country')
                        ->pluck('total', 'country')
                        ->all();
        return $all_recipients;
    }

    public function heading(): string|Htmlable|null
    {
        return 'Ebook Downloaded From:';
    }

    public function color(): array
    {
        return [118, 120, 215];
    }
}
