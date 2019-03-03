<?php
/**
 * User: kidus
 * Date: 1/31/19
 * Time: 12:55 PM
 */
require_once "AccountStatus.php";
require_once "Admin.php";
require_once "Company.php";
require_once "Data.php";
require_once "Database.php";
require_once "DataSource.php";
require_once "DataSourceManagement.php";
require_once "DataSourceStatus.php";
require_once "Developer.php";
require_once "User.php";
class AccountManagement
{
    public static function usernameUnique($username)
    {
        $db = Database::getInstance();
        $res = $db->fetchData(["collection" => "nmdh.users", "mongo_query" => ["username" => $username]])->toArray();
        return empty($res);
    }

    public static function passwordValid($username, $password)
    {
        $db = Database::getInstance();
        $res = $db->fetchData(["collection" => "nmdh.users", "mongo_query" => ["username" => $username, "password" => $password]])->toArray();
        return (!empty($res));
    }

    public static function createUser(User $user)
    {
        $db = Database::getInstance();
        $collection = "users";
        $document = $user->__toString();
        return $db->storeData(array("collection" => $collection, "document" => $document));
    }

    public static function updateUser(User $user)
    {
        $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
        $bulk = new MongoDB\Driver\BulkWrite();
        $bulk->update(["username" => $user->getUsername()], ['$set' => ["password" => $user->getPassword()]]);
        return $mng->executeBulkWrite("nmdh.users", $bulk);
    }

    public static function getUser($id): User
    {
        return new User($id, NULL);
    }
}