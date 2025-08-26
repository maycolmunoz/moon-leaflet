# Leaflet field for [MoonShine Laravel admin panel](https://moonshine-laravel.com)

MoonLeaflet adds a map field to your forms, letting users pick their location using a Leaflet map. It's perfect for saving latitude and longitude easily. In table and detail views, it shows an icon that links to Google Maps with the saved coordinates for quick access.

![example](./_docs/images/example.webp)

### Requirements

- MoonShine v3.0+

### Support MoonShine versions

| MoonShine | MoonLeaflet |
| --------- | ----------- |
| 3.0+      | 1.0+        |

## Installation

```shell
composer require maycolmunoz/moon-leaflet
```

## Usage

```php
use MaycolMunoz\MoonLeaflet\Fields\Leaflet;

Leaflet::make('Location') // label
    ->initialPosition(latitude: 40.7580, longitude: -73.9855) //initial position
    ->columns('latitude', 'longitude') // columns in database
    ->isDraggable(true) // default is true
    ->minZoom(5) // min zom
    ->maxZoom(18) // max zoom
    ->zoom(14), // initial zoom
```

Note: The map will attempt to use the user's current location if location services are enabled. If no location is provided, the map will default to coordinates (0, 0).
