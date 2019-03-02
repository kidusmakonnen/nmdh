<?php
/**
 * Date: 2/26/19
 * Time: 10:43 AM
 */

class Database2
{
    public static function storeData($query)
    {
        $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
        $collection = $query["collection"];
        $document = json_decode($query["document"], true);
        $bulk = new MongoDB\Driver\BulkWrite(['ordered' => false]);

        $bulk->insert($document);
//        return "hey";
        return $mng->executeBulkWrite("nmdh.$collection", $bulk);
    }
}