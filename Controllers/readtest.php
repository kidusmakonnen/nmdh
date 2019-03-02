<?php
/**
 * User: kidus
 * Date: 2/26/19
 * Time: 9:55 PM
 */
$mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
//$query = new MongoDB\Driver\Query(["username" => "kidusdev", "password" => "asfd"]);

//$rows = $mng->executeQuery("nmdh.users", $query);
//echo empty($rows->toArray());

//echo var_dump($rows);

//write-test-end---
//delete-test-begin

$bulk = new MongoDB\Driver\BulkWrite();

$bulk->update(["username" => "fanabc"], ['$pull'=>["data" => ["url" => "bundesliga"]]]);
//        $bulk->update(["username" => $data_source->getOwner()], ['$push'=>["data" => ["hey" => "wooo"]]]);
$res = $mng->executeBulkWrite("nmdh.users", $bulk);

echo var_dump($res);