<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>ABBA Dorsten</title>
	<link rel="shortcut icon" href="http://www.dorsten.de/favicon.ico" type="image/x-icon" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/dropzone.css" rel="stylesheet">


	<script type="text/javascript" src="js/jquery-2.1.3.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>

	<script type="text/javascript" src="dropzone.js"></script>
	<script type="text/javascript" src="tom.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script src="http://openlayers.org/api/OpenLayers.js"></script>
</head>
<body>
	<header>
		<div class="bl">
			<h4 id="link">
				<a href="http://www.dorsten.de/" title="Zur Dorsten-Homepage">
					<img alt="" src="img/Logo.gif" id="logo">
				</a>
				<span id="bltext">Aktive Bürger Beteiligungs App</span>
			</h4>
		</div>
	</header>

	<?php
	$include_subsite = $_GET['inc'];
	if(isset($include_subsite)) {
		switch ($include_subsite) {
			case 'persdata':
			include('personalisierte_daten.html');
			break;

			case 'desktopcompl':
			include('desktop_beschwerde.html');
			break;

			case 'kontrolle':
			include('kontrolle.html');
			break;

			case 'rwe':
			include('rwe_verlinkung.html');
			break;

			case 'vd':
			include('vielen_dank.php');
			break;

			case 'impressum':
			include('impressum.html');
			break;

			case 'main':
			default:
			include('main.html');
			break;
		}
	} else {
		include('main.html');
	}
	?>

	<footer>
		<h5 align="center">
			<b style="color: #8b8b8b">Version 0.65 | </b>
			<a href="http://www.dorsten.de/" id="link">
				<b style="color: #8b8b8b">www.dorsten.de</b>
			</a>
			| <a href="./index.php?inc=impressum" id="link">
			<b style="color: #8b8b8b">Impressum</b>
		</a>
	</h5>
</footer>
</body>
</html>