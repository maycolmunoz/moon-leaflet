<div x-data="map">
	@include('moon-leaflet::partials.leaflet')

	<div class="z-0 w-full p-6 text-gray-900 md:w-1/2 h-96 rounded-md" id="map"></div>

	<x-moonshine::form.input :attributes="$latAttributes" x-model="lat" />

	<x-moonshine::form.input :attributes="$lonAttributes" x-model="lon" />

	<script>
		document.addEventListener('alpine:init', () => {
			Alpine.data('map', () => ({
				map: '',
				lat: @js( $value['latitude'] ?? $initLatitude ),
				lon: @js( $value['longitude'] ?? $initLongitude ),

				showMap() {
					const { lat, lon } = this;

					this.map = L.map('map', {
							worldCopyJump: true,
							zoomAnimation: true,
							minZoom: {{ $minZoom }},
							maxZoom: {{ $maxZoom }}

						}).setView([lat, lon], {{ $zoom }});

					L.tileLayer(@js( $layer ), { attribution: '© OpenStreetMap contributors' })
						.addTo(this.map);

					L.marker([lat, lon], { draggable: @js( $draggable ? true : false )})
						.bindPopup(@js( $label ))
                        .openPopup()
						.addTo(this.map)
						.on('dragend', (e) => {
							this.lat = e.target.getLatLng().lat;
							this.lon = e.target.getLatLng().lng
						});

					L.featureGroup().addTo(this.map);
				},

				init() {
					if ("geolocation" in navigator) {
						navigator.geolocation.getCurrentPosition((position) => {
							this.lat = @js( $value['latitude'] ?? null ) ?? position.coords.latitude
							this.lon = @js( $value['latitude'] ?? null ) ?? position.coords.longitude

							this.showMap()
						}, (error) => {
							console.error(`Error getting location: ${error.message}`);
							this.showMap()
						});
					} else {
						alert("Geolocation is not supported by this browser.");
					}
				},
			}))
		})
	</script>

</div>
