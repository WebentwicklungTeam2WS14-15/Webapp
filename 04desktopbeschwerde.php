<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Beschwerdemeldung</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

	<!--link rel="stylesheet/less" href="less/bootstrap.less" type="text/css" /-->
	<!--link rel="stylesheet/less" href="less/responsive.less" type="text/css" /-->
	<!--script src="js/less-1.3.3.min.js"></script-->
	<!--append ‘#!watch’ to the browser URL, then refresh the page. -->
	
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="css/dropzone.css" rel="stylesheet">


  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->

  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="img/favicon.png">
  
	
	<script type="text/javascript" src="dropzone.min.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/scripts.js"></script>
	<script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?sensor=false">
    </script>
</head>

<body>
<script type="text/javascript" src="storage.js"></script>
<script type="text/javascript">
function sichern () {
	storage.set("nachricht", document.forms.form.elements.nachricht.value);
	//storage.set("Foto", document.forms.form.elements.foto.value);
	storage.set("schadensort", document.forms.form.elements.schadensort.value);
	storage.set("latitude", document.getElementById("lati").innerHTML);
	storage.set("longitude", document.getElementById("longi").innerHTML);
	location.href = "05kontrolle.html";
}
</script>
<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<h3 class="text-center">
				Bitte füllen Sie alle gekennzeichneten Felder aus!
			</h3>
			<h4 class="text-center">
				*Pflichtfelder
			</h4>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-md-12 column">		
        	
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-md-6 column">
		<form role="form" method="post" name="form" id="form" action="" onsubmit="sichern(); return false;">
				<div class="form-group">
				<br>
				<label>Ihre Nachricht*</label></br>
				<textarea id="nachricht" name="nachricht" placeholder="Ihre Nachricht/ Beschwerde/ Anregung/ Idee eingeben*" cols="50" rows="4" required></textarea>
				</br> 
				</div>
				<p id="feedback"></p>
		<p id="lati" name="lati">Latitude: </p>
		<p id="longi" name="longi">Longitude: </p>

        <script>
            
			
        </script>
		<a href="#" class="btn btn-info btn-lg" onclick="getLocation()" type="button">Aktuellen Standort verwenden (GPS)</a>
		</br></br>
		<label>Oder manuell eingeben:</label>
		</br>
				<div class="form-group">
					 <label>Adresse des Schadenortes</label>
					 <input class="form-control" id="schadensort" name="schadensort" type="name" value="Halterner Straße 5 46282–46286 Dorsten">
					 <input type="button" value="Adresse überprüfen" onclick="coordsByAddress();"></input>
				</div>
				
				<div class="form-group">
					 <label>Foto hochladen</label>
					 
				</div>
				
			</form>
			<form id="my-awesome-dropzone" action="upload.php" class="dropzone">  
        <div class="dropzone-previews"></div>
        <div class="fallback"> <!-- this is the fallback if JS isn't working -->
        <input name="file" type="file" >
		<script>
  // myDropzone is the configuration for the element that has an id attribute
  // with the value my-dropzone (or myDropzone)
  Dropzone.options.myAwesomeDropzone = {
    init: function() {
      this.on("addedfile", function(file) {

        // Create the remove button
        var removeButton = Dropzone.createElement("<button>Remove file</button>");


        // Capture the Dropzone instance as closure.
        var _this = this;

        // Listen to the click event
        removeButton.addEventListener("click", function(e) {
          // Make sure the button click doesn't submit the form:
          e.preventDefault();
          e.stopPropagation();

          // Remove the file preview.
          _this.removeFile(file);
          // If you want to the delete the file on the server as well,
          // you can do the AJAX request here.
        });

        // Add the button to the file preview element.
        file.previewElement.appendChild(removeButton);
      });
    }
  };
</script>
        </div>
		</form>
		<input type="submit" class="btn btn-lg btn-success" name="submit" value="Weiter"></input>
		</div>
		<div class="col-md-6 column">
			<div id="mapholder" name="mapholder">
			<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
				<script type="text/javascript">
				latLong = new google.maps.LatLng(51.668889, 6.967222);
				var lat = 51.668889;
				var lng = 6.967222;
				mapholder = document.getElementById('mapholder');
				mapholder.style.height = '400px';
				mapholder.style.width = '400px';
				var infowindow = new google.maps.InfoWindow(
				  { 
					size: new google.maps.Size(150,50)
				  });
				var myOptions = {
				center:latLong, zoom:12,
				mapTypeId:google.maps.MapTypeId.ROADMAP,
				mapTypeControl:false,
				navigationControlOptions:{style:google.maps.NavigationControlStyle.SMALL}
				}
				var map = new google.maps.Map(document.getElementById("mapholder"), myOptions);
				var marker = null;
				var x = document.getElementById("feedback");
				var lati = document.getElementById("lati");
				var longi = document.getElementById("longi");
				
				function getLocation() {
					if (navigator.geolocation) {
						navigator.geolocation.getCurrentPosition(showPosition,showError);
					} else { 
						x.innerHTML = "Geolocation is not supported by this browser.";
					}
				}
				
				// A function to create the marker and set up the event window function 
				function createMarker(latlng, name, html) {
					var contentString = html;
					var marker = new google.maps.Marker({
						position: latlng,
						map: map,
						zIndex: Math.round(latlng.lat()*-100000)<<5
						});

					google.maps.event.addListener(marker, 'click', function() {
						infowindow.setContent(contentString); 
						infowindow.open(map,marker);
						});
					google.maps.event.trigger(marker, 'click');    
					return marker;
				}
				
				google.maps.event.addListener(map, 'click', function() {
				infowindow.close();
				});
				  google.maps.event.addListener(map, 'click', function(event) {
					//call function to create marker
						 if (marker) {
							marker.setMap(null);
							marker = null;
						 }
					 marker = createMarker(event.latLng, "name", "<b>Schadensort</b>");
					 lat=event.latLng.lat();
					 lng=event.latLng.lng();
					 codeLatLng();
					 lati.innerHTML = "Latitude: " + event.latLng.lat();
					 longi.innerHTML = "Longitude: " + event.latLng.lng();
				  });
				  
				function initialize() {
				  // create the map
				  var myOptions = {
					zoom: 8,
					center: new google.maps.LatLng(43.907787,-79.359741),
					mapTypeControl: true,
					mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
					navigationControl: true,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				  }
				  map = new google.maps.Map(document.getElementById("map_canvas"),
												myOptions);
				}
				
				function showPosition(position) {	
					lat = position.coords.latitude;
					lon = position.coords.longitude;
					var latlon = lat+","+lon;
					lati.innerHTML = "Latitude: " + lat;
					longi.innerHTML = "Longitude: " + lon;
					latLong = new google.maps.LatLng(lat, lon);
					var myOptions = {
					center:latLong, zoom:14,
					mapTypeId:google.maps.MapTypeId.ROADMAP,
					mapTypeControl:false,
					navigationControlOptions:{style:google.maps.NavigationControlStyle.SMALL}
					}
					//call function to create marker
						 if (marker) {
							marker.setMap(null);
							marker = null;
						 }
					map.setCenter(latLong);
					map.setZoom(14);
					marker = new google.maps.Marker({position:latLong,map:map,title:"Schadensort"});
					codeLatLng();
				}	
				
				function showError(error) {
					switch(error.code) {
						case error.PERMISSION_DENIED:
							x.innerHTML = "User denied the request for Geolocation."
							break;
						case error.POSITION_UNAVAILABLE:
							x.innerHTML = "Location information is unavailable."
							break;
						case error.TIMEOUT:
							x.innerHTML = "The request to get user location timed out."
							break;
						case error.UNKNOWN_ERROR:
							x.innerHTML = "An unknown error occurred."
							break;
					}
				}
				
				function coordsByAddress(){
					var geocoder = new google.maps.Geocoder();
					var address = document.getElementById('schadensort').value;
					  geocoder.geocode( { 'address': address}, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
						  map.setCenter(results[0].geometry.location);
						  map.setZoom(14);
						  lati.innerHTML = "Latitude: " + results[0].geometry.location.lat();
						  longi.innerHTML = "Longitude: " + results[0].geometry.location.lng();
						  if (marker) {
							marker.setMap(null);
							marker = null;
						 }
						  marker = new google.maps.Marker({
							  map: map,
							  position: results[0].geometry.location							  
					});
					} else {
					  alert('Geocode was not successful for the following reason: ' + status);
					}
				  });
				}
				
				//Address by current coords
				function codeLatLng() {
					var geocoder = new google.maps.Geocoder();
				    var latlng = new google.maps.LatLng(lat, lng);
				    geocoder.geocode({'latLng': latlng}, function(results, status) {
					  if (results[0]) {
						var address = document.getElementById('schadensort');
						address.value = results[0].formatted_address;
					  } 
					});
				}
				</script>
			</div>
		</div>
	</div>
</div>
</body>
</html>
