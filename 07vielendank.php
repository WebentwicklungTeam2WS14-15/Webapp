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
$description = $_POST['strasse'] . " " . $_POST['hausnummer'] . " " . $_POST['postleitzahl'] . " " . $_POST['ort'];
//TODO Add Telefon cases

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
				Vielen Dank, wir haben Ihre Beschwerde entgegengenommen!
			</h3>
			<h4 class="text-center">
				Falls Sie eine personalisierte Beschwerde gemeldet haben, werden Sie in Kürze eine persönliche Rückmeldung von uns erhalten.
			</h4>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-md-6 column">
		</div>
		<div class="col-md-6 column">
			 <a href="01beschwerdeart.html" class="btn btn-success btn-lg" type="button" style="float: right;">Zurück zur Startseite</a>
		</div>
	</div>
</div>
</body>
</html>
