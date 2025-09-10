<?php
  /**
   * Base Admin Controller
   * This is loaded by any controller that requires admin access.
   */
  class AdminController extends Controller {
    public function __construct(){
      if(!isAdmin()){
        header('Location: ' . URLROOT . '/posts');
        exit();
      }
    }
  }
