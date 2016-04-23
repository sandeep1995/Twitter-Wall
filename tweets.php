<?php
session_start();
require 'vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
define('CONSUMER_KEY', 'ipYgCcw269nIeclfri6rtLs21');
define('CONSUMER_SECRET', 'GKfw9dm4BsmgwvmDNK2MCxoUtq6jeFYkS1VWqCzrnCSaD6oTvv');
define('OAUTH_CALLBACK', 'http://127.0.0.1/hack/callback.php');
$access_token = $_SESSION['access_token'];
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
$user = $connection->get("account/verify_credentials");
$tweets = $connection->get('search/tweets', array('q' => '#hackathon', 'result_type'=> 'recent', 'count' =>10));
foreach($tweets->statuses as $key=> $val){
    ?>
        <div style=" border: 1px solid #ccc; box-shadow: 1px 1px 1px #ccc; margin-bottom: 20px; padding: 20px;">
                <h4 style="color: #009381;"><?php echo $val->user->screen_name; ?></h4>
                <p class="lead">
                    <?php $strTweet = preg_replace('/(^|\s)#(\w*[a-zA-Z_]+\w*)/', '\1<a href="http://twitter.com/search?q=%23\2">#\2</a>',  $val->text);
                    echo $strTweet;
                    ?>
                </p>
            </div>
        <?php
    }
?>