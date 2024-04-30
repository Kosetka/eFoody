<?php
//$testingvalue = "SESSION TEST";
//$_SESSION['testing'] = $testingvalue;
// 4 hours in seconds
$inactive = 14400;
if (!isset($_SESSION['expire'])) {
    $_SESSION['expire'] = time() + $inactive;
}
if (time() > $_SESSION['expire']) {
    //$_SESSION['testing'] = '';
    session_unset();
    session_destroy();
    //$_SESSION['testing'] = '2 hours expired'; // test message
}
$_SESSION['expire'] = time() + $inactive; // static expire
