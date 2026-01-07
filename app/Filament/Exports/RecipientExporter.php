<?php

namespace App\Filament\Exports;

use App\Models\Recipient;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;
use Symfony\Component\Intl\Countries;

class RecipientExporter extends Exporter
{
    protected static ?string $model = Recipient::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name'),
            ExportColumn::make('email'),
            ExportColumn::make('country')
                ->getStateUsing(fn ($record) => Countries::getName(
                    strtoupper(trim((string) $record->country)),
                    app()->getLocale()
                ) ?? $record->country),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your recipient export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
