<?php

$userrow = $database->query("select * from madmin where memail='$useremail'");
$userfetch=$userrow->fetch_assoc();
$userid= $userfetch["mid"];
$username=$userfetch["mname"];

?>