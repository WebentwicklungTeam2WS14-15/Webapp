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
			<h4 class="text-center">
				Bitte überprüfen Sie Ihre angegebenen Daten!
			</h4>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-md-12 column">		
			<form role="form" method="post" action="09 vielendank.html">
				<script type="text/javascript">
					for (var eigenschaft in liste) {
					/*if (storage.getName(eigenschaft) == "Art"){
						document.write(
							"Hier könnte Ihre Art stehen!"
							);
					} else{*/
						document.write(
						  "<div class='form-group'><label>"+
						  eigenschaft+": "+"</label><input value='"+
						  liste[eigenschaft]+"'></input></div>"
						);
					}
				</script>
				<input class="btn btn-success btn-lg" type="submit" style="float: right;" value="Weiter (Beschwerde jetzt melden)"></a>
			</form>
			<a href="#" class="btn btn-warning" type="button">Bearbeiten</a>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-md-6 column">
		</div>
		<div class="col-md-6 column">
			 
		</div>
	</div>
</div>
</body>
</html>
