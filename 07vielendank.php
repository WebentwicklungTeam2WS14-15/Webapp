<!DOCTYPE html>
<html lang="en">
<?php
// Mantis API URL
define('MANTISCONNECT_URL', 'http://www.patrickdehnel.de/mantis/api/soap/mantisconnect.php');

//Login information
define('USERNAME', 'web_reporter');
define('PASSWORD', 'keeese');

//Project specific values
$projectName = "Schadensmeldung";
$category = "Sonstiges";
$reporterName = $_POST['vorname'] . " " . $_POST['nachname'];
$summary = $_POST['nachricht'];
$description = "Adresse: " . $_POST['strasse'] . " " . $_POST['hausnummer'] . " " . $_POST['postleitzahl'] . " " . $_POST['ort'] . " Telefon: " . $_POST['telefon'] . " Mobil: " . $_POST['mobil'] . " E-Mail: " . $_POST['email'] . " Art: " . $_POST['art'] . " Schadensort: " . $_POST['schadensort'] . " Koordinaten: " . $_POST['koordinaten'];

function addIssue($projectName,$category,$reporterName,$summary,$description) {

    $function_name = "mc_issue_add";
    $args['issueData']['project']['name'] = $projectName;
    $args['issueData']['category'] = $category;
    $args['issueData']['reporter']['name'] = $reporterName;
    $args['issueData']['summary'] = $summary;
    $args['issueData']['description'] = $description;


    //Add login information
    $args = array_merge(
        array(
            'username' => USERNAME,
            'password' => PASSWORD
        ),
        $args
    );

    //connect and do the SOAP call
    try {
        $client = new SoapClient(MANTISCONNECT_URL . '?wsdl');

        $result = $client->__soapCall($function_name, $args);
    } catch (SoapFault $e) {
        $result = array(
            'error' => $e->faultstring
        );
    }
}

addIssue($projectName,$category,$reporterName,$summary,$description);

?>
<head>
  <meta charset="utf-8">
  <title>Beschwerdemeldung</title>
  <link rel="shortcut icon" href="http://www.dorsten.de/favicon.ico" type="image/x-icon" />
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
	
	<h4><a href="http://www.dorsten.de/" id="link"><img alt="" src="img/Logo.gif" id="logo">
	 <b style="color: #BDBDBD">www.</b>dorsten<b style="color: #BDBDBD">.de</b></a></h4>
</head>

<body>
<div class="container jumbotron">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<h3 class="text-center">
				Vielen Dank, wir haben Ihre Anregung entgegengenommen!
			</h3>
			<h4 class="text-center">
				Falls Sie eine personalisierte Anregung gemeldet haben, werden Sie in Kürze eine persönliche Rückmeldung von uns erhalten.
			</h4><p></p>
		</div>
	</div>
		<div class="row clearfix">
		<div class="col-md-12 column text-center">
			 <a href="01beschwerdeart.html" class="btn btn-blue" type="button">Zurück zur Startseite</a>
		</div>
	</div>
	</br>
</div>
<h5 align="center"><a href="http://www.dorsten.de/" id="link">
		<b style="color: #8b8b8b">www.dorsten.de</b></a>
		| <a href="http://www.dorsten.de/Impressum.htm" id="link">
		<b style="color: #8b8b8b">Impressum</b>
		</a>
		</h5>
</div>
</body>
</html>
