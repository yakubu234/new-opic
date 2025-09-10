<?php
  class Admin extends AdminController {
    public function __construct(){
      // First, run the parent constructor to check for admin
      parent::__construct();
    }

    public function index(){
      $data = [
        'title' => 'Admin Dashboard'
      ];
      $this->view('admin/index', $data);
    }
  }
