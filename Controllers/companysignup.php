<?php
/**
 * User: kidus
 * Date: 2/26/19
 * Time: 9:20 AM
 */

require_once "../Models/Company.php";
require_once "../Models/AccountManagement.php";

$company_name = $_POST["company_name"];
$company_username = $_POST["company_username"];
$company_email = $_POST["company_email"];//remove?
$company_password = $_POST["company_password"];
$company_description = $_POST["company_description"];


$company = new Company($company_username, $company_password, $company_name, $company_description);

$res = AccountManagement::createUser($company);

echo var_dump($res);






