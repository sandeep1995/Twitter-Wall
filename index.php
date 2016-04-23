<?php
session_start();
require 'vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
define('CONSUMER_KEY', 'ipYgCcw269nIeclfri6rtLs21');
define('CONSUMER_SECRET', 'GKfw9dm4BsmgwvmDNK2MCxoUtq6jeFYkS1VWqCzrnCSaD6oTvv');
define('OAUTH_CALLBACK', 'http://127.0.0.1/hackathon/callback.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="It is a real time twitter wall">
    <meta name="author" content="Sandeep Acharya">
    <title>Twitter Wall</title>
    
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/landing-page.css" rel="stylesheet">

    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
</head>

<body>
    <?php
    session_start();
    if(!isset($_SESSION['access_token'])){
    ?>
    <nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
        <div class="container topnav">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand topnav" href="">Twitter Wall #hackathon</a>
            </div>
        </div>
    </nav>
    <a name="about"></a>
    <div class="intro-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-message">
                        <h1>Twitter Wall</h1>
                        <h3>A wall upon Hashtag <br> #hackathon</h3>
                        <hr class="intro-divider">
                        <ul class="list-inline intro-social-buttons">
                            <li>
                                <a href="http://127.0.0.1/hackathon/help.php" class="btn btn-default btn-lg"><i class="fa fa-twitter fa-fw"></i> <span class="network-name">Login with Twitter</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.intro-header -->

    <!-- Page Content -->
            </div>

        </div>
        <!-- /.container -->

    </div>
    <?php
    }
    else {
        //logged in
        ?>
        <nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
        <div class="container topnav">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand topnav" href="">Twitter Wall</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container" id="tweetboxapp">
        <div class="row">
            <br>
            <div class="col-md-4 user-info">
                <div style="border: 1px solid #ccc; box-shadow: 1px 1px 1px #ccc; margin-bottom: 20px; padding: 20px;">
                <?php
                $access_token = $_SESSION['access_token'];
                $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
                $user = $connection->get("account/verify_credentials");
                ?>
                <br>
                <img class="img-responsive" src="<?php echo $user->profile_image_url; ?>">
                <h3>
                    <?php
                    echo "@".$user->screen_name;
                    ?>
                    <br>
                    <small>
                        <?php
                        echo $user->name;
                        echo "<br>";
                        echo "Status: ".$user->description;
                        ?>
                    </small>
                </h3>
                <div class="row">
						<div class="alert alert-success" id="error-msg" style="display: none;"></div>
						<form class="form-horizontal" method="post" id="status-update-form">
							<div class="form-group">
								<div class="col-sm-8">
									<textarea class="form-control" rows="2" name="status" id="status" placeholder="Use hashtag #hackathon"></textarea>
								</div>
								<div class="col-sm-4">
									<button type="submit" class="btn btn-success" style="padding: 13.4px;">Tweet</button>
								</div>
							</div>
						</form>
            </div>
                <p class="well">
                    New tweets are coming each minute.
                </p>
            </div>
            
            </div>
            
           <div class="col-md-8">
                <div id="tweets">
                </div>
            </div>
        </div>
    </div>
    
    <?php  
    }
    ?>
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    
    <script>
        $('#status-update-form').submit(function(e) {
				e.preventDefault();
				var status = $('#status').val();
				if (status == "") {
					$("#error-msg").html('Hey! Please enter something').slideDown();
					setTimeout(function() {
						$("#error-msg").slideUp();
					}, 1000);
				} else {
                    $('#error-msg').addClass('alert-success').html('Tweeting...').slideDown();
					$.ajax({
						url: 'poststatus.php',
						method: "post",
						data: {
							status: status
						},
						success: function(data) {
							$('#error-msg').removeClass('alert-danger');
							$('#error-msg').addClass('alert-success').html('Successfully Tweeted').slideDown();
							setTimeout(function() {
								$("#error-msg").slideUp();
							}, 1000);
							$('#status').val('');
                            pullPost();
						},
						error: function() {
							$("#error-msg").html('There is some error occured').fadeIn();
							setTimeout(function() {
								$("#error-msg").fadeOut();
							}, 3000);
						},
						complete: function() {
						}
					});
				}
			});

			function pullPost() {
				$("#tweets").html('<img src="loader.gif"> Loading Tweets...');
				$.ajax({
					url: 'tweets.php',
					method: "get",
					success: function(data) {
						setTimeout(function() {
							$("#error-msg").slideUp();
						}, 3000);
						$('#tweets').html(data);
					},
					error: function() {
						$("#error-msg").html('There is some error occured').fadeIn();
						setTimeout(function() {
							$("#error-msg").fadeOut();
						}, 3000);
					}
				});
			}
			window.onload = function() {
				pullPost();
			};
            
            setInterval(function(){
                pullPost();
            }, 60000);
    </script>
</body>

</html>
