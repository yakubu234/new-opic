<?php
  class Admin extends Controller {
    public function __construct(){
      // Use the new centralized permission check
      if(!Permissions::canViewAdminDashboard()){
        header('Location: ' . URLROOT . '/posts');
        exit();
      }
    }

    public function index(){
      $data = [
        'title' => 'Admin Dashboard'
      ];
      $this->view('admin/index', $data);
    }
  }
