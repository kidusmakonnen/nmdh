<?php
/**
 * User: kidus
 * Date: 3/2/19
 * Time: 4:15 PM
 */

require_once "../Models/Database.php";
require_once "../helpers/subscriptionmanagement.php";

$api_key = $_GET["key"];
$url = $_GET["dataurl"];

header('Content-Type: application/json');
if (validApiKey($api_key, $url)) {
    $db = Database::getInstance();
    $row = $db->fetchData(["collection"=>"nmdh.users", "mongo_query"=>["data.url" => $url], "option" => ["projection" => ["data.data" => 1]]])->toArray();
    echo json_encode($row[0]->data[0]->data);
} else {
    echo "Invalid API Key";
}