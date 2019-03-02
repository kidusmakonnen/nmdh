<?php
/**
 * User: kidus
 * Date: 3/2/19
 * Time: 7:03 PM
 */
require_once "../Models/DataSource.php";

$url = $_GET["dataurl"];


$data = new DataSource(new Company(null));

$data->setUrl($url);

if (isset($_GET["unpublish"])) {
    $res = $data->unpublish();
} else {
    $res = $data->publish();
}

header("Location: ../company/viewData.php?dataurl=$url");
