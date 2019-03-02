<?php
/**
 * User: kidus
 * Date: 2/27/19
 * Time: 8:11 AM
 */
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}

require_once "../Models/Database.php";
$username = $_SESSION["username"];
$url = $_GET["dataurl"];

$db = Database::getInstance();
$rows = $db->fetchData(["collection" => "nmdh.users", "mongo_query" => ["username" => $username, "data.url" => $url], "options" => ["projection" => ["data.data"=>1]]]);

$res = $db->removeData(["document" => "users","match" => ["username" => $username], "remove" => ['$pull'=>["data" => ["url" => $url]]]]);
echo var_dump($res);