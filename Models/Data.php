<?php
/**
 * User: kidus
 * Date: 1/31/19
 * Time: 12:10 PM
 */

class Data
{
    private $dataid;//TODO: generate dataid
    private $data_json;

    function __construct($json)
    {
        $this->data_json = $json;
    }

    function __toString()
    {
        return $this->data_json;
    }
}