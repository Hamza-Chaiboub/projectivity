<?php

namespace App\Filament\Widgets;

use App\Models\Recipient;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EbookRecipients extends StatsOverviewWidget
{
    protected static ?int $sort = 1;
    protected array|int|string $columnSpan = 3;
    protected function getStats(): array
    {
        $all_recipients = Recipient::count();
        $last_seven_days = Carbon::now()->subDays(7);
        $recipients_this_week = Recipient::where('created_at', '>=', $last_seven_days)->count();
        return [
            Stat::make('Recipients', $all_recipients)
                ->description('Ebook recipients')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make('For 7 days', $recipients_this_week)
                ->description($last_seven_days->format('d-m-Y') . ' - ' . Carbon::now()->format('d-m-Y'))
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            Stat::make('Average time on page', '3:12'),
        ];
    }
}
