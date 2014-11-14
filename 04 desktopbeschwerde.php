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
</head>

<body>
<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<h3 class="text-center">
				Bitte füllen Sie alle gekennzeichneten Felder aus!
			</h3>
			<?php
			echo($_POST[vorname]);
			echo("test");
			?>
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
		[Karte]
		</div>
		<div class="col-md-6 column">
			<form role="form" method="post" action="07 kontrolle.php">
				<div class="form-group">
				<br>
				<textarea id="text" name="textarea" placeholder="Ihre Nachricht/ Beschwerde/ Anregung/ Idee eingeben*" cols="50" rows="4" required></textarea>
				</br> 
				</div>
				<div class="form-group">
					 <label for="exampleInputEmail1">Straße, Hausnummer</label><input class="form-control" id="Schadensort" type="name">
				</div>
				<div class="form-group">
					 <label for="exampleInputFile">Foto hochladen</label><input id="Foto" type="file">
				</div>
				<input type="submit" class="btn btn-lg btn-success" name="submit" value="Weiter"></input>
			</form>
			<script type="text/javascript">
				$("#form").submit( function(eventObj) {
					$('<input />').attr('type', 'hidden')
						.attr('name', "something")
						.attr('value', "something")
						.appendTo('#form');
					return true;
				});
			</script>
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
