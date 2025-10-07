<?php

declare(strict_types=1);

namespace MaycolMunoz\MoonLeaflet\Fields;

use MaycolMunoz\MoonLeaflet\Traits\HasConfig;
use MaycolMunoz\MoonLeaflet\Traits\HasLeaflet;
use MoonShine\UI\Fields\Field;

class LeafletField extends Field
{
    use HasConfig, HasLeaflet;

    protected string $type = 'hidden';

    protected string $view = 'moon-leaflet::leaflet-field';

    protected bool $isGroup = true;

    protected array $propertyAttributes = [
        'type',
    ];

    protected function reformatFilledValue(mixed $data): mixed
    {
        return parent::reformatFilledValue($data);
    }

    protected function viewData(): array
    {
        return [
            'layer' => $this->getLayer(),
            'label' => $this->getLabel(),
            'initLatitude' => $this->getInitialLatitude(),
            'initLongitude' => $this->getInitialLongitude(),
            'zoom' => $this->getZoom(),
            'minZoom' => $this->getMinZoom(),
            'maxZoom' => $this->getMaxZoom(),
            'draggable' => $this->isDraggable(),
            'latAttributes' => $this->getLatitudeAttributes(),
            'lonAttributes' => $this->getLongitudeAttributes(),
        ];
    }
}
