function sichern() {
	localStorage.setItem("nachricht", $('#nachricht').val());
	//localStorage.setItem("Foto", document.forms.form.elements.foto.value);
	localStorage.setItem("schaden_strasse", $('#schaden_strasse').val());
	localStorage.setItem("schaden_hausnr", $('#schaden_hausnr').val());
	localStorage.setItem("schaden_plz", $('#schaden_plz').val());
	localStorage.setItem("schaden_ort", $('#schaden_ort').val());
	localStorage.setItem("latitude", $("#hidden_latitude").html());
	localStorage.setItem("longitude", $("#hidden_longitude").html());
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

var markers = new OpenLayers.Layer.Markers("Markers");

function isSchadenortInLocalStorage () {
	var addr_street = $('#schaden_strasse').val();
	var addr_housenr = $('#schaden_hausnr').val();
	var addr_postalcd = $('#schaden_plz').val();
	var addr_city = $('#schaden_ort').val();
	var combined_address = addr_street + " " + addr_housenr + " " + addr_postalcd + " " + addr_city;

	if ($.trim(combined_address) == "") return false;
	else coordsByAddress();

	return true;
}

function aktivieren() {
	$("#weiter").removeAttr("disabled");
	$("#rueckmeldung").attr("hidden", true);
	$('input[name=schadensort]').parent('div').removeClass("has-error");
}

function deaktivieren(reason) {
	var rueckmeldung = $("#rueckmeldung");
	var showWarning = false;

	if (reason == "nichtDorsten") {
		rueckmeldung.html("Der angegebene Schadensort ist nicht in Dorsten.");
		$('input[name=schadensort]').parent('div').addClass("has-error");
		showWarning = true;
	}

	if (reason == "neuerAufruf") {
		if (!isSchadenortInLocalStorage()) {
			rueckmeldung.html("Bitte geben Sie einen Schadensort an.");
			showWarning = true;
		}
	}

	if (showWarning) {
		rueckmeldung.removeAttr("hidden");
		$("#weiter").attr("disabled", true);
	} else {
		rueckmeldung.attr("hidden", true);
		$("#weiter").attr("disabled", false);
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

	// add #map_attribution so we can change how it looks in CSS w/o overwriting
	// the OpenLayers CSS ID
	$('#OpenLayers_Control_Attribution_9').attr('id','map_attribution');
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
		$('#hidden_latitude').html(lonlat.lat);
		$('#hidden_longitude').html(lonlat.lon);
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

function leeren() { $('input[name=schadensort]').val(""); }

function gpsCheck() { if ($("#schadensort").val() == "") $("#gpsfail").removeAttr("hidden"); }

function init() {
	var mapnik = new OpenLayers.Layer.OSM();
	map.addLayer(mapnik);
	navigator.geolocation.getCurrentPosition(function (position) {
		$('#hidden_latitude').html(position.coords.latitude);
		$('#hidden_longitude').html(position.coords.longitude);
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
	var addr_street = $('#schaden_strasse').val();
	var addr_housenr = $('#schaden_hausnr').val();
	var addr_postalcd = $('#schaden_plz').val();
	var addr_city = $('#schaden_ort').val();

	var combined_address = addr_street + " " + addr_housenr + " " + addr_postalcd + " " + addr_city;

	if (addr_city == "Dorsten (allgemein)") {
		return;
	} else if ($.trim(combined_address) == "") {
		alert('Es wurde keine Adresse angegeben.');
	} else {
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode({'address': combined_address}, function (results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				$('#hidden_latitude').html(results[0].geometry.location.lat());
				$('#hidden_longitude').html(results[0].geometry.location.lng());
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

function addressByCoords(latitude, longitude) {
	$('#hidden_latitude').html(latitude);
	$('#hidden_longitude').html(longitude);
	var geocoder = new google.maps.Geocoder();
	var latlng = new google.maps.LatLng(latitude, longitude);
	geocoder.geocode({'latLng': latlng}, function (results, status) {
		if (results[0]) {
			var result_locality;

			// Get address components fields from results and set the input boxes to the corresponding values
			// fields: https://developers.google.com/maps/documentation/javascript/geocoding#GeocodingAddressTypes
			$.each(results[0].address_components, function(index, value) {
				if (value.types[0] == "street_number") { $('#schaden_hausnr').val(value.long_name); };
				if (value.types[0] == "route") { $('#schaden_strasse').val(value.long_name); };
				if (value.types[0] == "postal_code") { $('#schaden_plz').val(value.long_name); };
				if (value.types[0] == "locality") {
					$('#schaden_ort').val(value.long_name);
					result_locality = value.long_name;
				};
			});

			if (result_locality != "Dorsten") deaktivieren("nichtDorsten");
			else aktivieren();
		}
	});
}

function setDorsten(){
	var latDorstenCenter = 51.66996827834537;
	var lonDorstenCenter = 6.969115639564525;
	$('#hidden_latitude').html(latDorstenCenter);
	$('#hidden_longitude').html(lonDorstenCenter);
	var lonLat = new OpenLayers.LonLat(lonDorstenCenter, latDorstenCenter)
	.transform(
		new OpenLayers.Projection("EPSG:4326"), //transform from WGS 1984
		map.getProjectionObject() //to Spherical Mercator Projection
		);
	map.setCenter(lonLat, 16);
	if (markers) markers.destroy();

	// empty all location fields before overwriting the locality
	leeren();
	$("#schaden_ort").val("Dorsten (allgemein)");
	aktivieren();
}