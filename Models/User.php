<?php
/**
 * User: kidus
 * Date: 1/31/19
 * Time: 12:00 PM
 */

require_once "AccountStatus.php";
require_once "AccountManagement.php";
require_once "Admin.php";
require_once "Company.php";
require_once "Data.php";
require_once "Database.php";
require_once "DataSource.php";
require_once "DataSourceManagement.php";
require_once "DataSourceStatus.php";
require_once "Developer.php";
require_once "UserType.php";

class User
{
    private $userid;//TODO: make use of $userid
    private $username;
    private $password;
    private $account_status;
    private $user_type;

    /**
     * @return mixed
     */
    public function getUserType()
    {
        return $this->user_type;
    }

    /**
     * @param mixed $user_type
     */
    public function setUserType($user_type)
    {
        $this->user_type = $user_type;
    }

    function __construct($username, $password)
    {
            $this->username = $username;
            $this->password = $password;


//        AccountManagement::createUser($this);
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function validatePassowrd($password)
    {
        return AccountManagement::passwordValid($this->username, $password);
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }



    /**
     * @param mixed $account_status
     */
    public function setAccountStatus(AccountStatus $account_status, User $user)
    {
        $this->account_status = $account_status;
    }

}