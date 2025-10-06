# Changelog

## [2.0.0] - 2025-10-06
### Added
- New component `LeafletMap` for displaying multiple points on a map.
- Support  initial positions.

### Changed
- Renamed the field from `Leaflet` to `LeafletField`.  
  ⚠️ Breaking change: existing forms using `Leaflet::make(...)` must be updated to `LeafletField::make(...)`.
