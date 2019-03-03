<?php
/**
 * User: kidus
 * Date: 2/26/19
 * Time: 11:23 AM
 */
require_once "../Models/Database.php";
require_once "../Models/Data.php";
require_once "../Models/DataSource.php";
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}

$db = Database::getInstance();
if(isset($_POST["submit"]))
{
    $company_username = $_SESSION["username"];
    $name = $_POST["data_name"];
    $url = $_POST["data_url"];
    $description = $_POST["data_description"];


    $uploaddir = '/var/www/html/nmdh/uploads';
    $uploadfile = $uploaddir . basename($_FILES["file"]["name"]);
    if (($_FILES["file"]["type"] == "text/csv")){
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $uploadfile))
        {
            $command = "mongoimport --db nmdh --collection tmp --file " . $uploadfile ." --type csv --headerline" ;

            shell_exec($command);
        }

        $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
        $collection = "users";

        $query = new MongoDB\Driver\Query([]);

        $rows = $mng->executeQuery("nmdh.tmp", $query);
        $to_insert = cleanUpImport(json_encode($rows->toArray()));//TODO: remove with projection

        $data = new Data(json_encode($to_insert));
        $data_source = new DataSource(new Company($company_username));
        $data_source->setData($data);
        $data_source->setName($name);
        $data_source->setUrl($url);
        $data_source->setDescription($description);


        DataSourceManagement::addDataSource($data_source);
        cleanUpDB();

    }
    else{
        echo "Please Upload a CSV file Only!";
    }
} else {
    echo "nope";
}

function cleanUpImport($import)
{
    $tmp = json_decode($import, true);
    $ret = array();
    foreach ($tmp as $doc) {
        unset($doc["_id"]);
        $ret[] = $doc;
    }

    return $ret;
}

function cleanUpDB()
{
    $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    $mng->executeCommand('nmdh', new \MongoDB\Driver\Command(["drop" => "tmp"]));
}

header("Location: ../company/viewData.php?dataurl=$url");

?>