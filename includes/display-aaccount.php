<?php

$userrow = $database->query("select * from admin where aemail='$useremail'");
$userfetch=$userrow->fetch_assoc();
$userid= $userfetch["aid"];
$username=$userfetch["aname"];

?>