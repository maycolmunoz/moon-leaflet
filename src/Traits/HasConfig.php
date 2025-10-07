<?php

namespace MaycolMunoz\MoonLeaflet\Traits;

use InvalidArgumentException;

trait HasConfig
{
    protected array $layers = [
        'OpenStreetMap' => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        'OpenTopoMap' => 'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png',
        'CartoDB Dark Matter' => 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}.png',
        'CartoDB Positron' => 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png',
        'CartoDB Voyager' => 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}.png',
        'Esri WorldStreetMap' => 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}',
        'Esri Satellite' => 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
    ];

    protected string $layer = 'OpenStreetMap';

    protected float $initLatitude = 0;

    protected float $initLongitude = 0;

    protected int $zoom = 14;

    protected int $minZoom = 5;

    protected int $maxZoom = 18;

    protected bool $draggable = true;

    public function draggable(bool $draggable): static
    {
        $this->draggable = $draggable;

        return $this;
    }

    public function initialPosition(float $latitude, float $longitude): static
    {
        $this->initLatitude = $latitude;
        $this->initLongitude = $longitude;

        return $this;
    }

    public function zoom(int $zoom): static
    {
        if ($zoom < 1 || $zoom > 20) {
            throw new InvalidArgumentException('Zoom must be between 1 and 20.');
        }

        $this->zoom = $zoom;

        return $this;
    }

    public function minZoom(int $minZoom): static
    {
        if ($minZoom < 1 || $minZoom > 20) {
            throw new InvalidArgumentException('Min zoom must be between 1 and 20.');
        }

        $this->minZoom = $minZoom;

        return $this;
    }

    public function maxZoom(int $maxZoom): static
    {
        if ($maxZoom < 1 || $maxZoom > 20) {
            throw new InvalidArgumentException('Max zoom must be between 1 and 20.');
        }

        $this->maxZoom = $maxZoom;

        return $this;
    }

    public function layer(string $layer): static
    {
        if (! array_key_exists($layer, $this->layers)) {
            throw new InvalidArgumentException("Invalid layer: {$layer}");
        }

        $this->layer = $layer;

        return $this;
    }

    public function getLayer(): string
    {
        return $this->layers[$this->layer] ?? $this->layers['OpenStreetMap'];
    }

    public function getInitialLatitude(): float
    {
        return $this->initLatitude;
    }

    public function getInitialLongitude(): float
    {
        return $this->initLongitude;
    }

    public function getZoom(): int
    {
        return $this->zoom;
    }

    public function getMinZoom(): int
    {
        return $this->minZoom;
    }

    public function getMaxZoom(): int
    {
        return $this->maxZoom;
    }

    public function isDraggable(): bool
    {
        return $this->draggable;
    }
}
