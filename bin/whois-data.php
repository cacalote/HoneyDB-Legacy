<?php
$i = trim($_GET['i']);
$h = trim($_GET['h']);

if(false == filter_var($i, FILTER_VALIDATE_IP)) {
	echo 'i:Input Error!';
	exit();
}

if(!ctype_xdigit($h)) {
	echo 'h:Input Error!';
	exit();
}

echo '<table width="95%">';
echo '<tr><td>ip info</td><td>request data</td></tr>';
echo '<tr><td align="top" width="50%">';

echo '<iframe width="100%" height="800"  src="https://who.is/whois-ip/ip-address/' . $i . '"></iframe>';

echo '</td><td valign="top">';

$t = '';
for($idx=0; $idx<strlen($h); $idx++) {
	$t .= chr(hexdec($h[$idx] . $h[++$idx]));
}
echo '<pre>' . htmlentities($t) . '</pre>';

echo '</td></tr></table>';
?>
