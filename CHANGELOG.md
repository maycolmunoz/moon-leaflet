# Changelog

## [2.0.0] - 2025-10-06
### Added
- New component `LeafletMap` for displaying multiple points on a map.
- Support  initial positions.

### Changed
- Renamed the field from `Leaflet` to `LeafletField`.  
- ⚠️ Breaking change: existing forms using `Leaflet::make(...)` must be updated to `LeafletField::make(...)`.


## [3.0.0] - 2025-10-07
### Added
- Support for **custom map layers**.

### Changed
- Refactored the component to use a **chainable `items()` method** instead of the constructor for setting map points.  
- ⚠️ **Breaking change:** Items can no longer be passed via the constructor.
- Renamed method **`isDraggable()` → `draggable()`** for a cleaner and more expressive.