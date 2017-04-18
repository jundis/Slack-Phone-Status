<?php
/**
 * Created by PhpStorm.
 * User: jundis
 * Date: 4/18/2017
 * Time: 2:12 PM
 */

ini_set('display_errors', 1); //Display errors in case something occurs

//TODO Variables to move to config.php later probably
$slacktoken = ""; //OAuth token
$authtoken = "ThisIsAuth"; //Random string to auth with from however you call this script
//End

if(empty($_GET['token']) || ($_GET['token'] != $authtoken)) die("Auth token invalid."); //Die if token not provided
if(empty($_GET['first_name']) || empty($_GET['last_name']) || empty($_GET['status'])) die("Missing parameter");

$slackapi = "https://slack.com/api/users.profile.set";
$header = array("Content-Type: application/json");
$emoji = ":question:";
$text = null;

if($_GET['status'] == "phone")
{
    $emoji = ":calling:";
    $text = "Phone";
}
else if($_GET['status'] == "off")
{
    $emoji = "";
    $text = "";
}

$array = array("first_name"=>$_GET['first_name'],"last_name"=>$_GET['last_name'],"status_text"=>$text,"status_emoji"=>$emoji);
$json = json_encode($array);
$encoded = urlencode($json);
$url = $slackapi . "?token=$slacktoken&profile=$encoded";


$ch = curl_init(); //Initiate a curl session

//Create curl array to set the API url, headers, and necessary flags.
$curlOpts = array(
    CURLOPT_URL => $url, //URL to send the curl request to
    CURLOPT_RETURNTRANSFER => true, //Request data returned instead of output
    CURLOPT_HTTPHEADER => $header, //Header to include, mainly for authorization purposes
    CURLOPT_FOLLOWLOCATION => true, //Follow 301/302 redirects
    CURLOPT_HEADER => 1, //Use header
);
curl_setopt_array($ch, $curlOpts); //Set the curl array to $curlOpts

$answerTData = curl_exec($ch); //Set $answerTData to the curl response to the API.
$headerLen = curl_getinfo($ch, CURLINFO_HEADER_SIZE);  //Get the header length of the curl response
$curlBodyTData = substr($answerTData, $headerLen); //Remove header data from the curl string.

// If there was an error, show it
if (curl_error($ch)) {
    die(curl_error($ch));
}
curl_close($ch); //Close the curl connection for cleanup.

$jsonDecode = json_decode($curlBodyTData); //Decode the JSON returned by the CW API.

var_dump($jsonDecode);

if($curlBodyTData == "ok") //Slack catch
{
    return null;
}