<?php
/**
 * User: kidus
 * Date: 2/27/19
 * Time: 3:02 AM
 */
session_start();
session_destroy();
header("Location: login.php");