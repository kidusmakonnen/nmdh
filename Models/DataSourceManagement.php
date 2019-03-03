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
        $db = Database::getInstance();

//        $res = $db->fetchData(["collection" => "nmdh.users", "mongo_query" => ['$or' => [["username" => "/.*$query*./"],
//            ["company_name" => "/.*$query*./"], ["company_description" => "/.*$query*./"], ["data.$.name" => "/.*$query*./"],
//            ["data.$.description" => "/.*$query*./"]]], "options" => ["projection" => ["company_name" => 1,
//            "data.name" => 1, "data.description" => 1]]])->toArray();
        $data = [];
        $res = $db->fetchData(["collection" => "nmdh.users", "mongo_query" => ['$or' => [["username" => ['$regex' => "$query"]],
            ["company_name" => ['$regex' => "$query"]], ["company_description" => ['$regex' => "$query"]]]], "options"=> ["projection" => ["data.data" => 0]]]);
        foreach ($res as $r) {
            $company = new Company($r->username, NULL, $r->company_name, $r->company_description);
            $data_sources = [];
            foreach ($r->data as $datum) {
                $data_source = new DataSource($company);
                $data_source->setName($datum->name);
                $data_source->setDescription($datum->description);
                $data_source->setUrl($datum->url);
                $data_sources[] = $data_source;
            }
            $data[] = $data_sources;
        }
        return $data;
    }

    public static function addDataSource(DataSource $data_source)
    {
        static::$data_sources[] = $data_source;//idk what this is :DDDD
        $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
        $bulk = new MongoDB\Driver\BulkWrite();

        $bulk->update(["username" => $data_source->getOwner()->getUsername()], ['$push' => ["data" => json_decode($data_source, true)]]);
//        $bulk->update(["username" => $data_source->getOwner()], ['$push'=>["data" => ["hey" => "wooo"]]]);
        $mng->executeBulkWrite("nmdh.users", $bulk);
    }
}