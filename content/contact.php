<?php
// define variables and set to empty values
$nameErr = $emailErr = $commentErr = $telError = "";
$name = $email = $comment = $tel = "";
$shown = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$err = 0;
	if (empty($_POST["name"])) {
		$err++;
		$nameErr = getTranslation("Name is required");
	} else {
		$name = test_input($_POST["name"]);
		// check if name only contains letters and whitespace
		if (!preg_match("/^[a-z0-9äöü\s]+$/i",$name)) {
			$err++;
			$nameErr = getTranslation('The name typed in is wrong');
		}
	}

	if (empty($_POST["email"])) {
		$err++;
		$emailErr = getTranslation("E-mail is required");
	} else {
		$email = test_input($_POST["email"]);
		// check if e-mail address is well-formed
		if (!preg_match("/^([a-z0-9äöü]+([-_.]?[a-z0-9])+)@[a-z0-9äöü]+([-_.]?[a-z0-9])+.[a-z]{2,4}$/i", $email)) {
			$err++;
			$emailErr = getTranslation('The e-mail typed in is wrong');
		}
	}

	if (empty($_POST["tel"])) {
		$telError = "";
	} else {
		$tel = test_input($_POST["tel"]);
		// check if tel contains only numbers
		if (!preg_match("/^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$/",$tel)) {
			$err++;
			$telError = getTranslation('The phone number is not correct');
		}
	}


	if (empty($_POST["comment"])) {
		$err++;
		$commentErr = getTranslation("Comment is required");
	} else {
		$comment = test_input($_POST["comment"]);
		if (!preg_match("/^[a-z0-9äöü\s]+$/i",$comment)) {
			$err++;
			$commentErr = getTranslation('Comment text is not correct');
		}

	}
	if ($err > 0) {
		$shown = 'shown';
	}
	if ($err == 0) {
		$headers = 'From: Exozet <info@exozet.com>';
		$email_body = "Name: ".$name."\n\nEmail: ".$email."\n\nTelefon: ".$tel."\n\nInhalt:\n".$comment;
		mail ("info@exozet.com", $email_body, $headers);
		echo "<script>alert('Your email was sent!');</script>";
		$name = $email = $comment = $tel = "";
	}

}
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>