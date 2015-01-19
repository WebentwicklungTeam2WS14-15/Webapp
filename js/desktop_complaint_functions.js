function textCounter(field, countfield, maxlimit) {
	countfield.html("Ihre Nachricht (Noch " + (maxlimit - field.val().length) + " Zeichen)");
}

$('#nachricht').on('keydown keyup', function() {
	textCounter($('#nachricht'), $('#zeichen'), 1024);
});

var lati = $('#lati');
var longi = $('#longi');
var markers = new OpenLayers.Layer.Markers("Markers");

// Instantiate map and show it within the defined container
function mapping() {
	map = new OpenLayers.Map("basicMap");
	map.addLayer(new OpenLayers.Layer.OSM());
	var lonLat = new OpenLayers.LonLat(6.967222, 51.668889)
	.transform(
		new OpenLayers.Projection("EPSG:4326"), //transform from WGS 1984
		map.getProjectionObject() //to Spherical Mercator Projection
	);
	map.setCenter(lonLat, 13);
	var click = new OpenLayers.Control.Click();
	map.addControl(click);
	click.activate();
};

OpenLayers.Control.Click = OpenLayers.Class(OpenLayers.Control, {
	defaultHandlerOptions: {
		'single': true,
		'double': false,
		'pixelTolerance': 8,
		'stopSingle': false,
		'stopDouble': false
	}, initialize: function (options) {
		this.handlerOptions = OpenLayers.Util.extend(
			{}, this.defaultHandlerOptions
			);
		OpenLayers.Control.prototype.initialize.apply(
			this, arguments
			);
		this.handler = new OpenLayers.Handler.Click(
			this, {
				'click': this.trigger
			}, this.handlerOptions
			);
	}, trigger: function (e) {
		var lonlat = map.getLonLatFromViewPortPx(e.xy)
		lonlat.transform(
			new OpenLayers.Projection("EPSG:900913"),
			new OpenLayers.Projection("EPSG:4326")
			);
		lati.innerHTML = lonlat.lat;
		longi.innerHTML = lonlat.lon;
		addressByCoords(lonlat.lat, lonlat.lon);
		lonLat = new OpenLayers.LonLat(lonlat.lon, lonlat.lat)
		.transform(
			new OpenLayers.Projection("EPSG:4326"),
			map.getProjectionObject()
			);
		if (markers) {
			markers.destroy();
			markers = new OpenLayers.Layer.Markers("Markers");
		}
		markers.addMarker(new OpenLayers.Marker(lonLat));
		map.addLayer(markers);
	}
});

function leeren() { $("#schadensort").val(""); }

function gpsCheck() { if ($("#schadensort").val() == "") $("#gpsfail").removeAttr("hidden"); }

function init() {
	var mapnik = new OpenLayers.Layer.OSM();
	map.addLayer(mapnik);
	navigator.geolocation.getCurrentPosition(function (position) {
		lati.innerHTML = position.coords.latitude;
		longi.innerHTML = position.coords.longitude;
		addressByCoords(position.coords.latitude, position.coords.longitude);
		lonLat = new OpenLayers.LonLat(position.coords.longitude, position.coords.latitude)
		.transform(
			new OpenLayers.Projection("EPSG:4326"), //transform from WGS 1984
			map.getProjectionObject() //to Spherical Mercator Projection
			);
		if (markers) {
			markers.destroy();
			markers = new OpenLayers.Layer.Markers("Markers");
		}
		markers.addMarker(new OpenLayers.Marker(lonLat));
		map.setCenter(lonLat, 16);
		map.addLayer(markers);
		$("#gpsfail").attr('hidden', true);
	});
}

function coordsByAddress() {
	var address = document.getElementById('schadensort').value;
	if (address=="Dorsten (allgemein)"){
		alert("ok");
	} else{
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode({'address': address}, function (results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				lati.innerHTML = results[0].geometry.location.lat();
				longi.innerHTML = results[0].geometry.location.lng();
				addressByCoords(results[0].geometry.location.lat(), results[0].geometry.location.lng());
				lonLat = new OpenLayers.LonLat(results[0].geometry.location.lng(), results[0].geometry.location.lat())
				.transform(
					new OpenLayers.Projection("EPSG:4326"), //transform from WGS 1984
					map.getProjectionObject() //to Spherical Mercator Projection
					);
				map.setCenter(lonLat, 16);
				if (markers) {
					markers.destroy();
					markers = new OpenLayers.Layer.Markers("Markers");
				}
				markers.addMarker(new OpenLayers.Marker(lonLat));
				map.addLayer(markers);
			} else {
				alert('Die Adresse konnte leider nicht gefunden werden.');
			}
		});
	}
}

function addressByCoords(eins, zwei) {
	var geocoder = new google.maps.Geocoder();
	var latlng = new google.maps.LatLng(eins, zwei);
	geocoder.geocode({'latLng': latlng}, function (results, status) {
		if (results[0]) {
			addressResult = results[0].formatted_address;
			if (addressResult.indexOf(" Dorsten, Deutschland") == -1 && addressResult.indexOf(" Dorsten, Germany") == -1) {
				deaktivieren("nichtDorsten");
			} else {
				aktivieren();
			}

			if (addressResult.indexOf(', Germany') != -1) {
				addressResult = addressResult.replace(', Germany', '');
			}

			if (addressResult.indexOf(', Deutschland') != -1) {
				addressResult = addressResult.replace(', Deutschland', '');
			}

			$('#schadensort').val(addressResult);
		}
	});
}

function setDorsten(){
	lati.innerHTML = 51.66996827834537;
	longi.innerHTML = 6.969115639564525;
	lonLat = new OpenLayers.LonLat(longi, lati)
	.transform(
		new OpenLayers.Projection("EPSG:4326"), //transform from WGS 1984
		map.getProjectionObject() //to Spherical Mercator Projection
		);
	map.setCenter(lonLat, 11);
	if (markers) {
		markers.destroy();
		markers = new OpenLayers.Layer.Markers("Markers");
	}
	markers.addMarker(new OpenLayers.Marker(lonLat));
	map.addLayer(markers);
	document.getElementById("schadensort").value="Dorsten (allgemein)";
	aktivieren();
}