<?php

namespace App\Filament\Widgets;

use Illuminate\Contracts\Support\Htmlable;
use InfinityXTech\FilamentWorldMapWidget\Widgets\WorldMapWidget;

class MapWidget extends WorldMapWidget
{
    protected int | string | array $columnSpan = 3;

    public function stats (): array {
        return [
            'US' => 35000,
            'MA' => 45000
        ];
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
