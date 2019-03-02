<?php
/**
 * User: kidus
 * Date: 1/31/19
 * Time: 12:12 PM
 */

require_once "AccountStatus.php";
require_once "Admin.php";
require_once "Company.php";
require_once "Data.php";
require_once "DataSourceStatus.php";
require_once "Database.php";
require_once "Developer.php";
require_once "User.php";

class DataSource
{
    private $url;
    private $data; //from Data class
    private $status;
    private $owner;
    private $subscribers; //array of Developers
    private $name;
    private $description;

    function __construct(Company $owner)
    {
        $this->owner = $owner;
        $this->subscribers = [];
        $this->status = DataSourceStatus::Unpublished;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getDataFromQuery($query)
    {
        //return string after performing query on $this->data
    }

    /**
     * @return Company
     */
    public function getOwner()
    {
        return $this->owner;
    }

    public function publish()
    {
        $this->status = DataSourceStatus::Published;
        $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
        $bulk = new MongoDB\Driver\BulkWrite();

        $bulk->update(["data.url" => $this->getUrl()], ['$set'=>["data.$.published" => $this->status]]);
        return $mng->executeBulkWrite("nmdh.users", $bulk);
    }

    public function unpublish()
    {
        $this->status = DataSourceStatus::Unpublished;
        $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
        $bulk = new MongoDB\Driver\BulkWrite();

        $bulk->update(["data.url" => $this->getUrl()], ['$set'=>["data.$.published" => $this->status]]);
        return $mng->executeBulkWrite("nmdh.users", $bulk);
    }

    public function subscribe(Developer $developer)
    {
        $this->subscribers[] = $developer;
    }

    public function unsubscribe(Developer $developer)
    {
        $this->subscribers = array_diff($this->subscribers, array($developer,
        ));
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }



    public function __toString()
    {
        return json_encode(array(
            "url" => $this->getUrl(),
            "name" => $this->getName(),
            "description" => $this->getDescription(),
            "subscribers" => $this->subscribers,
            "published" => $this->getStatus(),
            "data" => json_decode($this->getData(), true)
        ));
    }


}