<?php
/**
 * User: kidus
 * Date: 2/27/19
 * Time: 1:35 PM
 */
require_once "../Models/Developer.php";
require_once "../helpers/subscriptionmanagement.php";


$developer_username = $_GET["developer_username"];
$company_username = $_GET["company_username"];
$data_source_url = $_GET["data_source_url"];

if (!isUserSubscribed($developer_username, $data_source_url)) {

    $api_key = substr(strtolower(md5(microtime() . rand(1024, 9216))), 0, 28);

    $url = "?data=$data_source_url&key=$api_key";

    $subscription_data = ["username" => $developer_username, "apiKey" => $api_key, "company_username" => $company_username, "url" => $data_source_url];

    $developer = new Developer($developer_username);

    $res = $developer->subscribe($subscription_data);
    header("Location: ../developer/");
} else {
    header("Location: ../developer/");
}

