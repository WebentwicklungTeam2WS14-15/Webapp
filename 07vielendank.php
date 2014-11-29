<!DOCTYPE html>
<html lang="en">
<?php
// Mantis API URL
define('MANTISCONNECT_URL', 'http://www.patrickdehnel.de/mantis/api/soap/mantisconnect.php');

//Declare data
$projectName;
$category;
$summary;
$geo;
$schadensort;
$adresse;
$reporterName;
$telefon;
$mobil;
$mail;

//Login information
define('USERNAME', 'web_reporter');
define('PASSWORD', 'keeese');

//TODO add input filtering
//TODO Gültigkeitsbereich in PHP? sonst konstanten?
function processUserData() {
  $GLOBALS['projectName'] = "Schadensmeldung";
  $GLOBALS['category'] = "Sonstiges";
  if($_POST['art'] == "Briefkasten Bürgermeister") {
    $GLOBALS['category'] = "Sonstiges";
  } else if($_POST['art'] == "Schaden auf einem Spielplatz") {
    $GLOBALS['category'] = "Spielplatz";
  } else if($_POST['art'] == "Schaden an einem Parkautomaten") {
    $GLOBALS['category'] = "Parkautomat";
  } else if($_POST['art'] == "Schaden an Verkehrsschildern") {
    $GLOBALS['category'] = "Verkehrsschild";
  }
  $GLOBALS['reporterName'] = $_POST['vorname'] . " " . $_POST['nachname'];
  $GLOBALS['summary'] = $_POST['nachricht'];
  $GLOBALS['schadensort'] = $_POST['schadensort'];
  $GLOBALS['geo'] = $_POST['latitude'] . "," . $_POST['longitude'];
  $GLOBALS['adresse'] = $_POST['strasse'] . " " . $_POST['hausnummer'] . " " . $_POST['postleitzahl'] . " " . $_POST['ort'];
  $GLOBALS['telefon'] = $_POST['telefon'];
  $GLOBALS['mobil'] = $_POST['mobil'];
  $GLOBALS['mail'] = $_POST['email'];
}

function addIssueAnon($projectname,$category,$summary,$geo,$schadensort) {
    $function_name = "mc_issue_add";
    $args['issueData']['project']['name'] = $GLOBALS['projectName'];
    $args['issueData']['category'] = $GLOBALS['category'];
    $args['issueData']['summary'] = $GLOBALS['summary'];
    $args['issueData']['custom_fields']=array('field' => array('id'=>'2','name'=>'Geo'),'value'=>$GLOBALS['geo']);
    $args['issueData']['custom_fields']=array('field' => array('id'=>'3','name'=>'Schadensort'),'value'=>$GLOBALS['schadensort']);

    //TODO remove debug
    var_dump($args);

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

function addIssue($projectName,$category,$summary,$geo,$schadensort,$adresse,$reporterName,$telefon,$mobil,$mail) {
    $function_name = "mc_issue_add";
    $args['issueData']['summary'] = $GLOBALS['summary'];
    $args['issueData']['description'] = "submitted by web_reporter";
    $args['issueData']['project'] =  array('id' => '1');
    $args['issueData']['category'] = $GLOBALS['category'];   
    //$args['issueData']['custom_fields']=array(
    //                                     array('field' => array('id'=>'6','name'=>'Adresse'),'value'=>$GLOBALS['adresse']),
    //                                     array('field' => array('id'=>'2','name'=>'Geo'),'value'=>$GLOBALS['geo']),
    //                                     array('field' => array('id'=>'4','name'=>'Name'),'value'=>$GLOBALS['reporterName']),
    //                                     array('field' => array('id'=>'8','name'=>'Mobil'),'value'=>$GLOBALS['mobil']),
    //                                     array('field' => array('id'=>'9','name'=>'Mail'),'value'=>$GLOBALS['mail']),
    //                                     array('field' => array('id'=>'7','name'=>'Telefon'),'value'=>$GLOBALS['telefon']),
    //                                     array('field' => array('id'=>'3','name'=>'Schadensort'),'value'=>$GLOBALS['schadensort']));
    //TODO remove debug
    var_dump($args);
    // //Add login information
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


//do the work!
//TODO distinguish between types
  processUserData();
  addIssue($projectName,$category,$summary,$geo,$schadensort,$adresse,$reporterName,$telefon,$mobil,$mail);
// } else if($_POST['Beschwerdetyp'] == "personalisiert") {
//   processUserData();
//   addIssueAnon($projectname,$category,$summary,$geo,$schadensort);
// }

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
