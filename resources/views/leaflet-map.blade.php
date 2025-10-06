<div x-data="map">
    @include('moon-leaflet::partials.leaflet')

	<x-moonshine::heading h="1">
		{{ $label }}
	</x-moonshine::heading>

	<div class="z-0 w-full p-6 text-gray-900 md:w-1/2 h-96 rounded-md" id="map"></div>

	<script>
		document.addEventListener('alpine:init', () => {
			Alpine.data('map', () => ({
				map: '',
				items: @json( $items ?? [] ),
				lat: @js( $initLatitude ),
				lon: @js( $initLongitude ),

				showMap() {
					const { lat, lon} = this;                    

					this.map = L.map('map', {
						worldCopyJump: true,
						zoomAnimation: true,
						minZoom: {{ $minZoom }},
						maxZoom: {{ $maxZoom }},
					}).setView([lat, lon], {{ $zoom }});

					L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
						attribution: '© OpenStreetMap contributors',
					}).addTo(this.map);

					this.items.forEach((item) => {
						L.marker([item.latitude, item.longitude])
							.bindPopup(item.name)
							.addTo(this.map);
					});

					L.featureGroup().addTo(this.map);
				},

				init() {
					if ('geolocation' in navigator) {
						navigator.geolocation.getCurrentPosition(
							(position) => {                                
								this.lat = position.coords.latitude;
								this.lon = position.coords.longitude;

								this.showMap();
							},
							(error) => {
								console.error(`Error getting location: ${error.message}`);
								this.showMap();
							}
						);
					} else {
						alert('Geolocation is not supported by this browser.');
					}
				},
			}));
		});
	</script>
</div>
