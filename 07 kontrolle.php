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
  
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/scripts.js"></script>
	
	<script type="text/javascript" src="storage.js"></script>
	<script type="text/javascript">
		var liste = storage.getAll();
		var vorgetname = storage.get("vorname");
	</script>
</head>

<body>
<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<h3 class="text-center">
				Kontrollformular:
			</h3>
			<?php
			echo($_POST[vorname]);
			echo($_POST[something]);
			echo($_POST[textarea]);
			echo("---");
			echo(vornme);
			?>
			<h4 class="text-center">
				Bitte überprüfen Sie Ihre angegebenen Daten!
			</h4>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-md-12 column">
			<table border="1" cellpadding="5" cellspacing="0">
				<tr>
					<th>Feldname</th>
					<th>Eintrag</th>
				</tr>
				<script type="text/javascript">
				document.write(vorgetname);
				for (var eigenschaft in liste) {
					document.write(
					  "<tr><td>" + eigenschaft + "</td>" +
					  "<td><code>" + liste[eigenschaft] + "</code></td></tr>"
					);
				}
				</script>
			</table>
			<form role="form" method="get">
				<div class="form-group">
					 <label>Name:</label>
				</div>
				<div class="form-group">
					 <label>Vorname:</label>
				</div>
				<div class="form-group">
					 <label>Straße:</label>
				</div>
				<div class="form-group">
					 <label>Hausnummer:</label>
				</div>
				<div class="form-group">
					 <label>Postleitzahl:</label>
				</div>
				<div class="form-group">
					 <label>Ort:</label>
				</div>
				<div class="form-group">
					 <label>Telefon:</label>
					 <input class="form-control" id="Telefon" type="name">
				</div>
				<div class="form-group">
					 <label>Mobil:</label>
					 <input class="form-control" id="Mobil" type="name">
				</div>
				<div class="form-group">
					 <label >E-Mail:</label>
					 <input class="form-control" id="Email" type="email">
				</div>
				<div class="form-group">
					 <label>Ihre Nachricht:</label>
				</div>
				<div class="form-group">
					 <label>Beschwerdeort:</label>
					 <label>[Karte]</label>
				</div>
			</form>
			<a href="#" class="btn btn-warning" type="button">Bearbeiten</a>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-md-6 column">
		</div>
		<div class="col-md-6 column">
			 <a href="09 vielendank.html" class="btn btn-success btn-lg" type="button" style="float: right;">Weiter (Beschwerde jetzt melden)</a>
		</div>
	</div>
</div>
</body>
</html>
