<!-- Everyone create the same schema and password.. -->
<?php
$conn = oci_connect('GROCEREASE1', 'Sabin@789', 'localhost/XE');

if (!$conn) {
	$e = oci_error();
	echo "Error";
	trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
?>

  