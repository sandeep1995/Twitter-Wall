<?php
session_start();
require 'vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
define('CONSUMER_KEY', 'ipYgCcw269nIeclfri6rtLs21');
    define('CONSUMER_SECRET', 'GKfw9dm4BsmgwvmDNK2MCxoUtq6jeFYkS1VWqCzrnCSaD6oTvv');
    define('OAUTH_CALLBACK', 'http://127.0.0.1/hack/callback.php');
if(isset($_POST['status'])){
    $access_token = $_SESSION['access_token'];
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
    $user = $connection->get("account/verify_credentials");
    $tweet_message = $_POST['status'];
    $post = $connection->post('statuses/update', array('status'=> $tweet_message));
    echo "Successfully Tweeted";
}
?>