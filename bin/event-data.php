<?php
$h = trim($_GET['h']);

if(!ctype_xdigit($h)) {
	echo 'h:Input Error!';
	exit();
}

$t = '';
for($idx=0; $idx<strlen($h); $idx++) {
	$t .= chr(hexdec($h[$idx] . $h[++$idx]));
}

header("Content-type: text/plain");
echo $t;
//echo htmlentities($t);
?>
