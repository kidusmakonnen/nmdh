<?php
/**
 * User: kidus
 * Date: 3/2/19
 * Time: 1:17 PM
 */
require_once "../Models/Database.php";
function isUserSubscribed($user, $url)
{
    $db = Database::getInstance();
    $rows = $db->fetchData(["collection" => "nmdh.users", "mongo_query" => ["data.url" => $url], "options" => ["projection" => ["data.subscribers" => 1, "_id" => 0]]]);
    $row = $rows->toArray()[0];

    $subscribers = $row->data[0]->subscribers;//check if empty
    $subscribed = false;

    foreach ($subscribers as $subscriber) {
        if (!(strcmp($subscriber->username, $user))) {
            $subscribed = true;
            break;
        }
    }

    return $subscribed;
}

function getApiKey($user, $url)
{
    $db = Database::getInstance();
    $rows = $db->fetchData(["collection" => "nmdh.users", "mongo_query" => ["data.url" => $url], "options" => ["projection" => ["data.subscribers" => 1, "_id" => 0]]]);
    $row = $rows->toArray()[0];

    $subscribers = $row->data[0]->subscribers;

    foreach ($subscribers as $subscriber) {
        if (!(strcmp($subscriber->username, $user))) {
            return $subscriber->apiKey;
        }
    }
    return NULL;
}

function validApiKey($api_key, $url)
{
    $db = Database::getInstance();
    $rows = $db->fetchData(["collection" => "nmdh.users", "mongo_query" => ["data.url" => $url], "options" => ["projection" => ["data.subscribers" => 1, "_id" => 0]]]);
    $row = $rows->toArray()[0];

    $subscribers = $row->data[0]->subscribers;

    foreach ($subscribers as $subscriber) {
        if (!(strcmp($subscriber->apiKey, $api_key))) {
            return true;
        }
    }
    return false;

}