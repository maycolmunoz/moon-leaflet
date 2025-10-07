<?php

declare(strict_types=1);

namespace MaycolMunoz\MoonLeaflet\Components;

use Closure;
use MaycolMunoz\MoonLeaflet\Traits\HasConfig;
use MoonShine\UI\Components\MoonShineComponent;

/**
 * @method static static make()
 */
final class LeafletMap extends MoonShineComponent
{
    use HasConfig;

    protected string $view = 'moon-leaflet::leaflet-map';

    protected array|Closure $items = [];

    public function __construct(public string $label = '')
    {
        parent::__construct();
    }

    public function items(array|Closure $items): static
    {
        $this->items = $items;

        return $this;
    }

    public function getItems(): array
    {
        if ($this->items instanceof Closure) {
            $resolved = call_user_func($this->items);

            if (! is_array($resolved)) {
                throw new \InvalidArgumentException('The closure passed to items() must return an array.');
            }

            return $resolved;
        }

        return $this->items;
    }

    /*
     * @return array<string, mixed>
     */
    protected function viewData(): array
    {
        return [
            'layer' => $this->getLayer(),
            'items' => $this->getItems(),
            'initLatitude' => $this->getInitialLatitude(),
            'initLongitude' => $this->getInitialLongitude(),
            'zoom' => $this->getZoom(),
            'minZoom' => $this->getMinZoom(),
            'maxZoom' => $this->getMaxZoom(),
        ];
    }
}
