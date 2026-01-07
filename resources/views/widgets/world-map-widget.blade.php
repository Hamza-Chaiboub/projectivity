@use('Filament\Support\Facades\FilamentAsset')
<x-filament-widgets::widget>
    <div
        x-ignore
        x-load
        x-load-src="{{ FilamentAsset::getAlpineComponentSrc('filament-world-map-widget', 'InfinityXTech/filament-world-map-widget') }}"
        x-data="initWorldMapWidget({
            stats: JSON.parse('{{ json_encode($this->stats()) }}'),
            tooltipText: '{{ $this->tooltip() }}',
            map: '{{ is_string($this->map()) ? $this->map() : $this->map()->value }}',
            color: JSON.parse('{{ json_encode($this->color()) }}'),
            selector: '#map',
            additionalOptions: JSON.parse('{{ json_encode($this->additionalOptions()) }}'),
            customMapUrl: '{{ $this->customMapUrl() }}'
        })"
        x-init="init()">
        <x-filament::section>
            <div class="flex">
                {{-- LEFT: Map --}}
                @if(!empty($this->heading()))
                    <x-filament::section.heading>
                        {{ $this->heading() }}
                    </x-filament::section.heading>
                @endif
                <div wire:ignore>
                    <div id="map" style="height: {{ $this->height() }}"></div>
                </div>

                {{-- RIGHT: Legend --}}
                <div class="lg:col-span-1">
                    <div class="text-sm font-semibold mb-3">
                        Top 10 Countries:
                    </div>

                    <div class="space-y-2 overflow-auto pr-2"
                        style="max-height: {{ $this->height() }};">
                        @foreach ($this->legendItems() as $item)
                            <div class="flex items-center justify-between gap-3">
                                <div class="min-w-0 flex items-center gap-2">
                                    <span class="h-2.5 w-2.5 rounded-sm bg-primary-500"></span>

                                    <span class="truncate text-sm">
                                        {{ $item['name'] }}
                                        <span class="text-xs text-gray-500">({{ $item['code'] }})</span>
                                    </span>
                                </div>

                                <span class="tabular-nums text-sm">
                                    {{ number_format($item['count']) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </x-filament::section>
    </div>
</x-filament-widgets::widget>
