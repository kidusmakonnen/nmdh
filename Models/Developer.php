<?php
/**
 * User: kidus
 * Date: 1/31/19
 * Time: 12:14 PM
 */

require_once "User.php";
require_once "DataSourceManagement.php";

class Developer extends User
{
    private $subscription; //array of datasource

    function __construct($username, $password = NULL)
    {
        parent::__construct($username, $password);
        $this->setUserType(UserType::Developer);
    }

    /**
     * @return mixed
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    public function subscribe($data_source)
    {
//        $this->subscription[] = $data_source;
        $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
        $bulk = new MongoDB\Driver\BulkWrite();

        $bulk->update(["username" => $data_source["company_username"], "data.url" => $data_source["url"] ], ['$push' => ["data.$.subscribers" => $data_source]]);
        $bulk->update(["username" => $data_source["username"]], ['$push' => ["subscriptions" => $data_source]]);
        return $mng->executeBulkWrite("nmdh.users", $bulk);

    }

    public function unsubscribe($data_source)
    {
//        $this->subscription = array_diff($this->subscription, array($data_source,
//        ));
        $db = Database::getInstance();
        $res = $db->removeData(["document" => "users","match" => ["username" => $data_source["company_username"], "data.url" => $data_source["url"]], "remove" => ['$pull'=>["data.$.subscribers" => ["username" => $data_source["username"]]]]]);
        $res = $db->removeData(["document" => "users","match" => ["username" => $data_source["username"]], "remove" => ['$pull'=>["subscriptions" => ["url" => $data_source["url"]]]]]);
        echo var_dump($res);
//        die();
    }

    public function __toString()
    {
        return json_encode(array(
            "username" => $this->getUsername(),
            "password" => $this->getPassword(),
            "user_type" => $this->getUserType(),
            "subscriptions" => []
        ));
    }

    /**
     * @param mixed $subscription
     */
    public function setSubscription($subscription)
    {
        $this->subscription = $subscription;
    }


}