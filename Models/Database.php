<?php
/**
 * User: kidus
 * Date: 1/31/19
 * Time: 12:30 PM
 */

class Database
{
    private static $instance;
    private static $mng;


    private function __construct()
    {
        //db connection stuff
        $db_host = "localhost";
        static::$mng = new MongoDB\Driver\Manager("mongodb://$db_host:27017");
    }

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    //consider moving to a different class
    public function fetchData($query)
    {
        $collection = $query["collection"];
        $mongo_query = $query["mongo_query"];
        $options = isset($query["options"]) ? $query["options"] : NULL;
        $q = new MongoDB\Driver\Query($mongo_query, $options);
        return static::$mng->executeQuery($collection, $q);

    }

    //consider moving to a different class
    public function storeData($query)
    {
        try {
            $collection = $query["collection"];
            $document = json_decode($query["document"], true);
            $bulk = new MongoDB\Driver\BulkWrite(['ordered' => false]);

            $bulk->insert($document);

            static::$mng->executeBulkWrite("nmdh.$collection", $bulk);
            return true;
        } catch (MongoDB\Driver\Exception\Exception $e) {
            return false;

        }
    }

    public function removeData($query)
    {
        try {
            $document = $query["document"];
            $match = $query["match"];
            $remove = $query["remove"];
            $bulk = new MongoDB\Driver\BulkWrite();

            $bulk->update($match, $remove);

            static::$mng->executeBulkWrite("nmdh.$document", $bulk);
            return true;
        } catch (MongoDB\Driver\Exception\Exception $e) {
            return false;

        }
    }

}