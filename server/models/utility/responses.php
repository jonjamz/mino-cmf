<?php


/*********************************************************************

    The Responses Class

    All content and categorizing of text-based returns from models

*********************************************************************/


class responses {
 
  /*************************************************************************

      Categories for wrapping text that are recognized by the controller

  *************************************************************************/
  
  // Redirect with page load
  public static function redirect($url) {
  
    return "!redirect ".$url;
  
  }
  
  // Show a response and then redirect with page load several seconds later
  public static function resredir($url,$resp) {
  
    return "!resredir [$url] ".$resp;
  
  }
  
  // Change main view without page load
  public static function push($view) {
  
    return "!push ".$view;
  
  }
  
  // Show a response and then change the main view
  public static function respush($view,$resp) {
  
    return "!respush [$view] ".$resp;
  
  }
  
  // Append a non-themed response div and show content
  public static function append($resp) {
  
    return "!append ".$resp;
  
  }
  
    /**************************
    
        Themes for append()
    
    **************************/
  
    public static function appendSuccess($resp) {
    
      return '!append <div class="alert alert-success">'.$resp.'</div>';
    
    }
    
    public static function appendError($resp) {
    
      return '!append <div class="alert alert-error">'.$resp.'</div>';
    
    }

    public static function appendNotice($resp) {
    
      return '!append <div class="alert alert-block">'.$resp.'</div>';
    
    }
    
    
  // Append a non-themed response div and show content
  public static function resappend($resp) {
  
    return "!resappend ".$resp;
  
  }
  
  /****************************************************************************
  
      Response text - usually put through a category above before returning
  
  ****************************************************************************/
  
  public static function error() {
  
    return "<span class=\"label label-important\">Error!</span> There was an error. Please try again.";
  
  }
  
  public static function emailError() {
  
    return "<span class=\"label label-important\">Error!</span> We were unable to send an email to your address. Please verify that it is correct.";
  }
  
  public static function postModelError() {
  
    return "Please send Type, Method, and Args.";
  
  }
  
  public static function registered() {
  
    return "<span class=\"label label-success\">Registration Successful!</span><br>";
  
  }
  
  public static function activationEmailSent() {
  
    return "<span class=\"label label-success\">Ok</span> We have sent you a confirmation email with a link to activate your account.";
  
  }
  
  public static function activationSuccess() {
  
    return "<span class=\"label label-success\">Ok</span> You have successfully activated your account! <a href=\"\" class=\"loadView\" data-view=\"login\">Login</a>";
  
  }
  
  public static function notActivated() {
  
    return "<span class=\"label label-important\">Error!</span> This account must be activated before proceeding. Please follow the link in your activation email.";
  
  }
  
  public static function alreadyActivated() {
  
    return "<span class=\"label label-important\">Error!</span> This account has already been activated.";
  
  }
 
  public static function loginFalse() {
  
    return "<span class=\"label label-important\">Oh no!</span> The email or password you have entered is incorrect.";
  
  }
  
  public static function userExists($email) {
  
    return "A user with email <strong>$email</strong> already exists. Please try a different email.";
  
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
  
    return "<span class=\"label label-important\">Invalid password!</span> Please make sure it's at least 7 characters long and has no spaces.";
  
  }
  
  public static function passCodeExpired() {
  
    return "<span class=\"label label-important\">Error!</span> The link you used has expired.";
  
  }
  
  public static function feedbackSent() {
  
    return "<span class=\"label label-success\">Ok</span> If your message needs a response, we will contact you at your account's email.";
  
  }
 
 }

?>
