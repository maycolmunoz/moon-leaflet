# 🌍 MoonLeaflet — Leaflet for [MoonShine Laravel Admin Panel](https://moonshine-laravel.com)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/maycolmunoz/moon-leaflet.svg?style=flat-square)](https://packagist.org/packages/maycolmunoz/moon-leaflet)
[![Total Downloads](https://img.shields.io/packagist/dt/maycolmunoz/moon-leaflet.svg?style=flat-square)](https://packagist.org/packages/maycolmunoz/moon-leaflet)
[![License](https://img.shields.io/github/license/maycolmunoz/moon-leaflet.svg?style=flat-square)](https://github.com/maycolmunoz/moon-leaflet/blob/main/LICENSE)

**MoonLeaflet** adds interactive map support to MoonShine. It allows users to select coordinates directly from a map or display multiple locations visually with Leaflet.

- Map field with draggable marker
- Multiple available map layers
- Works in Form, Detail, and Index views
- Component mode with multiple markers
- Optional user geolocation support
- Customizable zoom, drag, and layer

---

## 🧱 Example Previews

| Field                                       | Component                                           |
| ------------------------------------------- | --------------------------------------------------- |
| ![Field Example](./_docs/images/field.webp) | ![Component Example](./_docs/images/component.webp) |

---

### Support MoonShine versions

| MoonShine | MoonLeaflet |
| --------- | ----------- |
| 4.0+      | 4.0         |

## 🧩 Installation

```bash
composer require maycolmunoz/moon-leaflet
```

---

## 🚀 Usage

### Field

```php
use MaycolMunoz\MoonLeaflet\Fields\LeafletField;

LeafletField::make('Location') // label
    ->initialPosition(latitude: 40.7580, longitude: -73.9855) //initial position
    ->columns('latitude', 'longitude') // columns in database
    ->draggable(true) // draggable market (optional) default is true
```

### Component

```php
use MaycolMunoz\MoonLeaflet\Components\LeafletMap;

LeafletMap::make('Business Locations') // label
    ->initialPosition(latitude: 40.7580, longitude: -73.9855) //initial position
    ->items(fn () => Business::all() 
    ->map(function (Business $business) {
        return [
            'name' => $business->name,
            'latitude' => $business->latitude,
            'longitude' => $business->longitude,
        ];
    })->toArray()) // Each item must include name, latitude, and longitude
```

> 💡 The map will attempt to use the user's location if geolocation is enabled.  
> If unavailable, it defaults to coordinates `(0, 0)`.

### 🌍 Options for field and component

```php
    ->layer('OpenStreetMap') // map layer (default: OpenStreetMap)
    ->minZoom(5) // minimum zoom (default: 5)
    ->maxZoom(18) // maximum zoom (default: 18)
    ->zoom(14) // initial zoom (default: 14)
```

### 🌍 Available Map Layers

| Layer Name              |
| ----------------------- |
| **OpenStreetMap**       |
| **OpenTopoMap**         |
| **CartoDB Dark Matter** |
| **CartoDB Positron**    |
| **CartoDB Voyager**     |
| **Esri WorldStreetMap** |
| **Esri Satellite**      |
