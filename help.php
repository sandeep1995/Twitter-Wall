<?php
session_start();
require 'vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
define('CONSUMER_KEY', 'ipYgCcw269nIeclfri6rtLs21');
define('CONSUMER_SECRET', 'GKfw9dm4BsmgwvmDNK2MCxoUtq6jeFYkS1VWqCzrnCSaD6oTvv');
define('OAUTH_CALLBACK', 'http://127.0.0.1/hackathon/callback.php');
if (!isset($_SESSION['access_token'])) {
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
	$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
	$_SESSION['oauth_token'] = $request_token['oauth_token'];
	$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
	$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
    header("Location: $url");
}
?>