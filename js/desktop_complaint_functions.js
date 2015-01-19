function sichern() {
	localStorage.setItem("nachricht", document.forms.form.elements.nachricht.value);
	//localStorage.setItem("Foto", document.forms.form.elements.foto.value);
	localStorage.setItem("schadensort", document.forms.form.elements.schadensort.value);
	localStorage.setItem("latitude", document.getElementById("lati").innerHTML);
	localStorage.setItem("longitude", document.getElementById("longi").innerHTML);
	$("#my-awesome-dropzone").submit();
	location.href = "index.php?inc=kontrolle";
}

function textCounter(field, countfield, maxlimit) {
	countfield.html("Ihre Nachricht (Noch " + (maxlimit - field.val().length) + " Zeichen)");
}

function hilfeAnzeigen() {
	alert("GPS-Akivierung unter Andriod:\nEinstellungen - Standort - Ein \n\nGPS-Akivierung unter iOS:\nEinstellungen - Datenschutz - Ortungsdienst - Ein\n\nGPS-Akivierung unter Windows:\nEinstellungen - Ortung - Ein\n\nGPS-Akivierung unter Amazon:\nEinstellungen - Standortbasierte Dienste - Standortbasierte Dienste aktivieren - Ein\n\nGPS-Akivierung in Google Chrome für Desktop:\nRechts oben auf die drei Striche - Einstellungen - Erweiterte Einstellungen anzeigen - \nInhaltseinstellungen - Standort - Abrufen Ihrers physikalischen Standortes für alle Webseiten zulassen");
}

var latDorsten = 51.668889;
var lonDorsten = 6.967222;

var lati = $('#lati');
var longi = $('#longi');
var markers = new OpenLayers.Layer.Markers("Markers");

function aktivieren() {
	$("#weiter").removeAttr("disabled");
	$("#rueckmeldung").attr("hidden", true);
}

function deaktivieren(reason) {
	$("#weiter").attr("disabled", true);
	var rueckmeldung = $("#rueckmeldung");
	rueckmeldung.removeAttr("hidden");

	if (reason == "change") {
		rueckmeldung.html("Bitte geben Sie einen Schadensort an.");
	}
	if (reason == "nichtDorsten") {
		rueckmeldung.html("Der angegebene Schadensort ist nicht in Dorsten.");
	}
}

// Instantiate map and show it within the defined container
function mapping() {
	map = new OpenLayers.Map("basicMap");
	map.addLayer(new OpenLayers.Layer.OSM());
	var lonLat = new OpenLayers.LonLat(lonDorsten, latDorsten)
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
		lati.html(lonlat.lat);
		longi.html(lonlat.lon);
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
		lati.html(position.coords.latitude);
		longi.html(position.coords.longitude);
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
	var address = $('#schadensort').val();
	if (address == "Dorsten (allgemein)") {
		alert("ok");
	} else{
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode({'address': address}, function (results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				lati.html(results[0].geometry.location.lat());
				longi.html(results[0].geometry.location.lng());
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
	var latDorstenCenter = 51.66996827834537;
	var lonDorstenCenter = 6.969115639564525;
	lati.html(latDorstenCenter);
	longi.html(lonDorstenCenter);
	var lonLat = new OpenLayers.LonLat(lonDorstenCenter, latDorstenCenter)
	.transform(
		new OpenLayers.Projection("EPSG:4326"), //transform from WGS 1984
		map.getProjectionObject() //to Spherical Mercator Projection
		);
	map.setCenter(lonLat, 16);
	if (markers) markers.destroy();
	$("#schadensort").val("Dorsten (allgemein)");
	aktivieren();
}