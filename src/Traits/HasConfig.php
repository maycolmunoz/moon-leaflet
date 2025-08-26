<?php

namespace MaycolMunoz\MoonLeaflet\Traits;

use InvalidArgumentException;

trait HasConfig
{
    protected float $initLatitude = 0;

    protected float $initLongitude = 0;

    protected int $zoom = 14;

    protected int $minZoom = 5;

    protected int $maxZoom = 18;

    protected bool $draggable = true;

    public function isDraggable(bool $draggable): static
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

    public function isMapDraggable(): bool
    {
        return $this->draggable;
    }
}
