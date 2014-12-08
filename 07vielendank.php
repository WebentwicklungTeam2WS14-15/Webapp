-<!DOCTYPE html>
<html lang="en">
<?php
// Mantis API URL
define('MANTISCONNECT_URL', 'http://www.patrickdehnel.de/mantis/api/soap/mantisconnect.php');
//TODO Daten in config.php auslagern

//Login information
define('USERNAME', 'web_reporter');
define('PASSWORD', 'keeese');

//Project specific values
$projectName = "Schadensmeldung";
$category = getMantisCategory($_POST['art']);
$summary = htmlspecialchars($_POST['nachricht']);
$geo = htmlspecialchars($_POST['koordinaten']);
$schadensort = htmlspecialchars($_POST['schadensort']);

//Distinguish between anonymous and personalized complaints
if(strcmp($_POST['anonym'],"t") == 0)  {
     $issueID = addIssueAnon($projectName,$category,$summary,$geo,$schadensort);
     //check for attachments, add all found attachments
     if($_POST['attachmentCount'] > 0) {
        for($i = 1; $i < $_POST['attachmentCount']+1; $i++) {
          $currentAttachment = $_POST['attachment' . $i];
          addAttachment($issueID,$currentAttachment,$i);
        }
     }
}
if(strcmp($_POST['anonym'],"f") == 0) {
     $issueID = addIssue($projectName,$category,$summary,$geo,$schadensort);
     //check for attachments, add all found attachments
     if($_POST['attachmentCount'] > 0) {
        for($i = 1; $i < $_POST['attachmentCount']+1; $i++) {
          $currentAttachment = $_POST['attachment' . $i];
          addAttachment($issueID,$currentAttachment,$i);
        }
     }
}

//TODO error handling?
//TODO test nicer way of doing this
//preg_match(pattern, subject)??

function getMantisCategory($formCategory) {
  //default category
  $category = "Sonstiges";
  if(strpos($formCategory, "Spielplatz") == 18) {
    $category = "Spielplatz";
  }
  if(strpos($formCategory,"Parkautomaten") == 17) {
     $category = "Parkautomat";
  }
  if(strpos($formCategory, "Verkehrsschildern") == 11) {
    $category = "Verkehrsschild";
  }
  if($formCategory === "Straßenschaden") {
    $category = "Straßenschaden";
  }
  return $category;
}

function addIssue($projectName,$category,$summary,$geo,$schadensort) {

    $function_name = "mc_issue_add";
    $args['issueData']['project']['name'] = $projectName;
    $args['issueData']['category'] = $category;
    $args['issueData']['description'] = $summary;
    //escape personal data strings
    $reporterName = htmlspecialchars($_POST['vorname']) . " " . htmlspecialchars($_POST['nachname']);
    $adress = htmlspecialchars($_POST['strasse']) . " " . htmlspecialchars($_POST['hausnummer']) . " " . htmlspecialchars($_POST['postleitzahl']) . " " . htmlspecialchars($_POST['ort']);
    $mobile = htmlspecialchars($_POST['mobil']);
    $email = htmlspecialchars($_POST['email']);
    $telefon = htmlspecialchars($_POST['telefon']);
    $args['issueData']['summary'] = $reporterName . ": " . substr($summary,0,63);
    $args['issueData']['custom_fields']=array(
                                         array('field' => array('id'=>'6'),'value'=>$adress),
                                         array('field' => array('id'=>'2'),'value'=>$geo),
                                         array('field' => array('id'=>'4'),'value'=>$reporterName),
                                         array('field' => array('id'=>'8'),'value'=>$mobile),
                                         array('field' => array('id'=>'9'),'value'=>$email),
                                         array('field' => array('id'=>'7'),'value'=>$telefon),
                                         array('field' => array('id'=>'3'),'value'=>$schadensort));


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
        return $result;
    } catch (SoapFault $e) {
        $result = array(
            'error' => $e->faultstring
        );
    }
}

function addIssueAnon($projectname,$category,$summary,$geo,$schadensort) {
    $function_name = "mc_issue_add";
    $args['issueData']['project']['name'] = $projectname;
    $args['issueData']['category'] = $category;
    $args['issueData']['description'] = $summary;
    $args['issueData']['summary'] = "Anonym: " . substr($summary,0,63);
    $args['issueData']['custom_fields']=array(array('field' => array('id'=>'2'),'value'=>$geo),
                                              array('field' => array('id'=>'3'),'value'=>$schadensort));

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
        return $result;
    } catch (SoapFault $e) {
        $result = array(
            'error' => $e->faultstring
        );
    }

}

function addAttachment($issueID,$filecontent,$count) {
    $function_name = "mc_issue_attachment_add";
    $args['issue_id'] = $issueID;
    $args['name'] = $issueID . "-ANHANG-" . $count;
    $args['file_type'] = "image/png";
    $args['content'] = $filecontent;

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
		| <a href="impressum.html" id="link">
		<b style="color: #8b8b8b">Impressum</b>
		</a>
		</h5>
</div>
</body>
</html>
