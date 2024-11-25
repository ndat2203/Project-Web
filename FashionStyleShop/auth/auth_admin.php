<?php
session_start();

require "./utils/utils.php";

checkAccessRole(1);

autoLogoutAfterInactivity(1800, "login.php");
