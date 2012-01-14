<?php

class responses {
 
 // Static methods for uniformity, because sometimes we'll pass args into messages
  
  public static function redirect($url) {
  
    return "!redirect ".$url;
  
  }
  
  public static function resredir($url,$resp) {
  
    return "!resredir [$url] ".$resp;
  
  }
  
  public static function push($view) {
  
    return "!push ".$view;
  
  }
  
  public static function respush($view,$resp) {
  
    return "!respush [$view] ".$resp;
  
  }
  
  public static function append($resp) {
  
    return "!append ".$resp;
  
  }
  
  public static function error() {
  
    return "There was an error. Please try again.";
  
  }
  
  public static function emailError() {
  
    return "There was an error sending an email to your address. Please contact support";
  }
  
  public static function postModelError() {
  
    return "Please send Type, Method, and Args.";
  
  }
  
  public static function registered() {
  
    return "Registration successful! ";
  
  }
  
  public static function activationEmailSent() {
  
    return "We have sent you a confirmation email with a link to activate your account.";
  
  }
  
  public static function activationSuccess() {
  
    return "You have successfully activated your account! <a href=\"\" class=\"loadView\" data-view=\"login\">Login</a>";
  
  }
  
  public static function notActivated() {
  
    return "This account must be activated before proceeding. Please follow the link in your activation email.";
  
  }
  
  public static function alreadyActivated() {
  
    return "This account has already been activated.";
  
  }
 
  public static function loginFalse() {
  
    return "The email or password you have entered is incorrect.";
  
  }
  
  public static function userExists($email) {
  
    return "A user with email '$email' already exists. Please try a different email.";
  
  }
  
  public static function forgotPass() {
  
    return "We have sent you an email with a link to change your password.";
  
  }
  
  public static function passNotMatching() {
  
    return "The passwords you entered do not match. Please try again.";
  
  }
  
  public static function passUpdated() {
  
    return "Your password has been successfully updated! <a href=\"\" class=\"loadView\" data-view=\"login\">Login</a>";
  
  }
  
  public static function passInvalid() {
  
    return "Invalid password! Please make sure it's at least 7 characters long and has no spaces.";
  
  }
  
  public static function passCodeExpired() {
  
    return "Error. The link you used has expired.";
  
  }
 
 }

?>
