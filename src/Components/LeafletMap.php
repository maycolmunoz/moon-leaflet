<?php

declare(strict_types=1);

namespace MaycolMunoz\MoonLeaflet\Components;

use MaycolMunoz\MoonLeaflet\Traits\HasConfig;
use MoonShine\UI\Components\MoonShineComponent;

/**
 * @method static static make()
 */
final class LeafletMap extends MoonShineComponent
{
    use HasConfig;

    protected string $view = 'moon-leaflet::leaflet-map';

    public function __construct(public string $label = '', public array $items = [])
    {
        parent::__construct();
    }

    /*
     * @return array<string, mixed>
     */
    protected function viewData(): array
    {
        return [
            'initLatitude' => $this->getInitialLatitude(),
            'initLongitude' => $this->getInitialLongitude(),
            'zoom' => $this->getZoom(),
            'minZoom' => $this->getMinZoom(),
            'maxZoom' => $this->getMaxZoom(),
            'draggable' => $this->isMapDraggable(),
        ];
    }
}
