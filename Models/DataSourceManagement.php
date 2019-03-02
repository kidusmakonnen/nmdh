<?php
/**
 * User: kidus
 * Date: 1/31/19
 * Time: 12:39 PM
 */
require_once "AccountStatus.php";
require_once "AccountManagement.php";
require_once "Admin.php";
require_once "Company.php";
require_once "Data.php";
require_once "Database.php";
require_once "DataSource.php";
require_once "DataSourceStatus.php";
require_once "Developer.php";
require_once "User.php";

class DataSourceManagement
{
    private static $data_sources;

    public static function search($query)
    {
        //return DataSource
    }

    public static function addDataSource(DataSource $data_source)
    {
        static::$data_sources[] = $data_source;//idk what this is :DDDD
        $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
        $bulk = new MongoDB\Driver\BulkWrite();

        $bulk->update(["username" => $data_source->getOwner()->getUsername()], ['$push'=>["data" => json_decode($data_source, true)]]);
//        $bulk->update(["username" => $data_source->getOwner()], ['$push'=>["data" => ["hey" => "wooo"]]]);
        $mng->executeBulkWrite("nmdh.users", $bulk);
    }
}