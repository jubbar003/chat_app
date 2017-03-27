<?php
$name = "Hello2world";
echo $name . "<br/>";
$hash_pass = password_hash($name, PASSWORD_BCRYPT);

echo $hash_pass  . "<br/>";

echo password_verify("Hello2world", $hash_pass);
?>