<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

    unset($_SESSION['sys_role_id']);
    echo "<meta http-equiv=\"refresh\" content=\"0; url=login.php\">";
?>