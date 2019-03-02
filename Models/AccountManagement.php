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
require_once "Database2.php";//FOR TESTING ONLY !!!
require_once "DataSource.php";
require_once "DataSourceManagement.php";
require_once "DataSourceStatus.php";
require_once "Developer.php";
require_once "User.php";
class AccountManagement
{
    public static function usernameUnique($username)
    {
        return true;//TODO: for test purposes only! REMOVE
        //return boolean
    }

    public static function passwordValid($password)
    {
        //return boolean
    }

    public static function createUser(User $user)
    {
        $db = Database::getInstance();
        $collection = "users";
        $document = $user->__toString();
        return $db->storeData(array("collection" => $collection, "document" => $document));
//        return Database2::storeData(array("collection" => $collection, "document" => $document));

    }

    public static function updateUser(User $user)
    {
        //TODO: add code to update user info to db
    }

    public static function getUser($id): User
    {
        //TODO: make use of Database class to get the user by id
    }
}