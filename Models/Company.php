<?php
/**
 * User: kidus
 * Date: 1/31/19
 * Time: 12:19 PM
 */

require_once "User.php";

class Company extends User
{
    private $data_sources;//array of DataSource
    private $name;
    private $description;


    function __construct($username, $password=NULL, $name=NULL, $description=NULL)
    {
        parent::__construct($username, $password);
        $this->name = $name;
        $this->description = $description;
        $this->setUserType(UserType::Company);
    }

    /**
     * @return mixed
     */
    public function getDataSources()
    {
        return $this->data_sources;
    }

    /**
     * @param mixed $data_sources
     */
    public function setDataSources($data_sources)
    {
        $this->data_sources = $data_sources;
    }

    public function getUsageStatistics()
    {
        $subscribers = 0;
        foreach ($this->data_sources as $data_source) {
            $subscribers += count($data_source->getSubscribers());
        }
        return json_encode(array(
            "subscribers" => $subscribers
        ));
    }

    public function __toString()
    {
        return json_encode(array(
            "username" => $this->getUsername(),
            "password" => $this->getPassword(),
            "account_status" => 0,
            "company_name" => $this->name,
            "company_description" => $this->description,
            "data" => [],
            "user_type" => $this->getUserType()
        ));
    }

    /**
     * @return null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param null $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
}