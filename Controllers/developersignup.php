<?php
/**
 * User: kidus
 * Date: 2/27/19
 * Time: 12:36 AM
 */
require_once "../Models/Company.php";
require_once "../Models/AccountManagement.php";

$developer_username = $_POST["developer_username"];
$developer_password = $_POST["developer_password"];

$developer = new Developer($developer_username, $developer_password);

$res = AccountManagement::createUser($developer);

echo var_dump($res);