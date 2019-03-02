<?php
/**
 * User: kidus
 * Date: 1/31/19
 * Time: 12:06 PM
 */
require_once "AccountStatus.php";
require_once "AccountManagement.php";
require_once "Company.php";
require_once "Data.php";
require_once "Database.php";
require_once "DataSource.php";
require_once "DataSourceManagement.php";
require_once "DataSourceStatus.php";
require_once "Developer.php";
require_once "User.php";

class Admin extends User
{
    function __construct($username, $password)
    {
        parent::__construct($username, $password);
        $this->setUserType(UserType::Admin);

    }

    public function setAccountStatus(AccountStatus $accountStatus, User $user)
    {
        $user->setAccountStatus($accountStatus);
    }
}