<?php
include("inc/config.php");
//Call to get user data from POST-variables and sanitize it
$data = prepareUserData();
//Add new issue
$issueID = addIssue($data);
//Check for attachments, add all found attachments
if($_POST['attachmentCount'] > 0) {
	for($i = 1; $i < $_POST['attachmentCount']+1; $i++) {
		$currentAttachment = $_POST['attachment' . $i];
		//prepare attachment
		list($type, $data) = explode(';', $currentAttachment);
		list(, $data)      = explode(',', $currentAttachment);
		$data = base64_decode($data);
		$type = preg_replace("/data:/", "", $type);
		addAttachment($issueID,$data,$type,$i);
	}
}

function prepareUserData() {
	//Get form data
	$userData['projectName'] = "Schadensmeldung";
	$userData['category'] = getMantisCategory($_POST['art']);
	$userData['summary'] = htmlspecialchars($_POST['nachricht']);
	if($_POST['nachricht'] == "") {
		$userData['summary'] = "[keine Angabe]";
	}
	$userData['reportedPlace'] = htmlspecialchars($_POST['schadensort']);
	$userData['geo'] = htmlspecialchars($_POST['koordinaten']);
	$userData['firstName'] = htmlspecialchars($_POST['vorname']);
	$userData['lastName'] = htmlspecialchars($_POST['nachname']);
	$userData['adress'] = htmlspecialchars($_POST['strasse']) . " " . htmlspecialchars($_POST['hausnummer']) . " " . htmlspecialchars($_POST['postleitzahl']) . " " . htmlspecialchars($_POST['ort']);
	$userData['phone'] = htmlspecialchars($_POST['telefon']);
	$userData['mobile'] = htmlspecialchars($_POST['mobil']);
	$userData['email'] = htmlspecialchars($_POST['email']);
	return $userData;
}

//Takes string from form and converts it into mantis-compatible categories
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

function addIssue($data) {
	//Get data
	$projectName = $data['projectName'];
	$category = $data['category'];
	$summary = $data['summary'];
	$reportedPlace = $data['reportedPlace'];
	$geo = $data['geo'];
	$firstName = $data['firstName'];
	$lastName = $data['lastName'];
	$adress = $data['adress'];
	$phone = $data['phone'];
	$mobile = $data['mobile'];
	$email = $data['email'];
	//Put data in proper mantis form
	$function_name = "mc_issue_add";
	$args['issueData']['project']['name'] = $projectName;
	$args['issueData']['category'] = $category;
	$args['issueData']['description'] = $summary;
	$args['issueData']['summary'] = $lastName . ": " . substr($summary,0,63);
	$args['issueData']['custom_fields']=array(
		array('field' => array('id'=>'3'),'value'=>$reportedPlace),	
		array('field' => array('id'=>'2'),'value'=>$geo),
		array('field' => array('id'=>'4'),'value'=>$firstName),
		array('field' => array('id'=>'10'),'value'=>$lastName),
		array('field' => array('id'=>'6'),'value'=>$adress),
		array('field' => array('id'=>'7'),'value'=>$phone),
		array('field' => array('id'=>'8'),'value'=>$mobile),
		array('field' => array('id'=>'9'),'value'=>$email),
		);

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

function addAttachment($issueID,$filecontent,$type,$count) {
	$function_name = "mc_issue_attachment_add";
	$args['issue_id'] = $issueID;
	$extension = preg_replace("/image\//", "", $type);
	$args['name'] = $issueID . "-ANHANG-" . $count . "." . $extension;
	echo("TYPE: " . $type);
	$args['file_type'] = $type;
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
		var_dump($result);
	}
}

?>
<div class="container jumbotron">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<h3 class="text-center">
				Vielen Dank, wir haben Ihre Anregung entgegengenommen!
			</h3>
			<h4 class="text-center">
				Falls Sie eine personalisierte Anregung gemeldet haben, werden Sie in Kürze eine persönliche Rückmeldung von uns erhalten.
			</h4>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-md-12 column text-center">
			<a href="index.php" class="btn btn-blue" type="button">Zurück zur Startseite</a>
		</div>
	</div></br>
</div>