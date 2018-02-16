<?php
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://localhost/auth/server.php");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$headers = array('Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWV9.TJVA95OrM7E2cBab30RMHrHDcEfxjoYZgeFONFh7HgQ');
//$headers = array('Authorization: Bearer HolaMundo');
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$salida = curl_exec($ch);

echo $salida;

curl_close($ch);
?>