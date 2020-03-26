<!DOCTYPE html>
<html>
  <head>
    <title>Place searches</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
	
    <style>
    html, body{height: 90%; margin-top:-20px;}
	
	#map_canvas{margin-bottom: 50px;height: 90%;}	
	
	.forms{ margin: 0;
    position: absolute;
    left: 50%;
    margin-right: -50%;
    transform: translate(-50%, -50%)}
	
	.drop{ margin: 0;
    position: absolute;
    left: 50%;
    margin-right: -50%;
    transform: translate(-50%, -50%)}
	
	.ui-dialog .ui-dialog-buttonpane .ui-dialog-buttonset {float: none;}

	.ui-dialog .ui-dialog-buttonpane {text-align: center; // left/center/right}

	
    </style>	
	
	<script src="js/jquery-3.2.1.min.js"></script>
  
	<script src="bootstrap-3.3.7/js/bootstrap.min.js"></script>
	
	<script src="bootstrap-3.3.7/js/bootstrap.js"></script>
	
	<link href="css/jQuery-UI1.12.css" rel="stylesheet" >
	
	<script src="js/jquery-3.2.1.js"></script>
  
	<script src="js/jquery-ui-1.12.1.js"></script>
	
	<link href="bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet" media="screen">
	
	<link href="bootstrap-3.3.7/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
	
	<div class="row">
    	<nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapse">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
            </div>
				<div class="collapse navbar-collapse" id="collapse">
              <ul class="nav navbar-nav">
			    <?php
					if (!isset($_SESSION['user_session'])){            
				echo ("<li><a href=index.php>Home</a></li>");            
                echo ("<li><a href=login-form.php>Login</a></li>");
                echo ("<li><a href=register-form.php>Register</a></li>");
                echo ("<li><a href=forgot-form.php>Forgot Password?</a></li>");
				} else {
                echo ("<li><a href=index.php>Home</a></li>");              
                echo ("<li><a href=logout.php>Logout</a></li>"); 
				}?>
                </ul> 
			</div>
						
			</nav> 
    </div>

	<script type="text/javascript" src="js/validation.min.js"></script>
	<link href="css/style2.css" rel="stylesheet" type="text/css" media="screen">

	<script type="text/javascript" src="js/script.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqHHZyTTShJSTgfOyFxA1AAx2l53Vr9xo&libraries=places,geometry"></script>
	
	<!--script src="//maps.googleapis.com/maps/api/js?key=AIzaSyDcUrOYgxhVkUay3EDODDSxT1Og3KW3m5c&signed_in=true&libraries=places,geometry"></script-->
  <link href="//fonts.googleapis.com/css?family=Bree+Serif" rel="stylesheet">

	
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
<style>
@import url(//fonts.googleapis.com/css?family=Roboto:500,100,300,700,400);

div.stars {
  display: inline-block;
}

input.star { display: none; }

label.star {
	float: right;
  padding: 5px;
  font-size: 24px;
  color: #444;
  transition: all .2s;
}

input.star:checked ~ label.star:before {
  content: '\f005';
  color: #FD4;
  transition: all .25s;
}

input.star-5:checked ~ label.star:before {
  color: #FE7;
  text-shadow: 0 0 20px #952;
}

input.star-1:checked ~ label.star:before { color: #F62; }

label.star:hover { transform: rotate(-15deg) scale(1.3); }

label.star:before {
  content: '\f006';
  font-family: FontAwesome;
}
</style>
	
  </head>
  <body style="background-color:#D8D8D8;">
 