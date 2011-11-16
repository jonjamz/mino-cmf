<?php $type = basename(__FILE__, '.php'); require_once __DIR__.'/../view.wrapper.php'; ?>

<!-- View -->
<div class="landing">

	<div class="rays"></div>
	<div class="getstarted"></div>

	<div data-model="signup"></div>
	
	<nav>
	  <a href="" onclick="return false" class="login" data-view="--DEFAULT/login">Sign In</a>
  </nav>
	
	<div class="clear"></div>
	<div class="logo"></div>
	<div class="subtitle">

		<h1>Charitable Opportunity Engine</h1>

	</div>
<form class="dbForm" data-model="register" data-method="register">
	<div class="signup">

		<a href="" onclick="return false" class="fb_large">

			<div class="f">f</div>
			<div class="text">
				<em>Connect</em> with <em>Facebook</em>
			</div>
			<div class="clear"></div>

		</a>

		<div class="or">
			<p>or</p>
		</div>
		<input type="email" name="email" placeholder="Email Address..." id="email">
		<div class="clear"></div>
		<a href="#" data-reveal-id="password" class="signup_btn">Sign Up</a>
	</div>
<div id="password" class="reveal-modal">
     <h1>Enter password:</h1>
     <p><input type="password" name="password"></p>
     <input type="submit" value="register">
     <a class="close-reveal-modal">&#215;</a>
</div>
</form>
</div>
