<?php 
// Include header.php
include("header.php");
?>

<div class="forgot-form">

	<div class="container">
     
        
       <form class="form-forgot" method="post" id="forgot-form">
      
        <h2 class="form-signin-heading">Password Recovery.</h2><hr />
        
        <div id="error">
        <!-- error will be shown here ! -->
        </div>
        
        <div class="form-group">
        <input type="email" class="form-control" placeholder="Email address" name="user_email" id="user_email" />
        <span id="check-e"></span>
        </div>
        
        <div class="form-group"> 
		<!-- call script.js on submit -->
            <button type="submit" class="btn btn-default" name="btn-forgot" id="btn-forogt">
    		<span class="glyphicon glyphicon-log-in"></span> &nbsp; Password Revocery
			</button> 
        </div>  
      
      </form>

    </div>
    
</div>

<?php
// Include footer.php
include("footer.php");
?>
