<?php
  class Posts extends Controller {
    public function __construct(){
      if(!isLoggedIn()){
        header('Location: ' . URLROOT . '/users/login');
      }
      $this->postModel = $this->model('Post');
    }

    public function index($page = 1){
      // Pagination settings
      $posts_per_page = 5;
      $total_posts = $this->postModel->getTotalPosts();
      $total_pages = ceil($total_posts / $posts_per_page);

      // Ensure page is valid
      $page = filter_var($page, FILTER_VALIDATE_INT);
      $page = ($page === false || $page < 1) ? 1 : $page;
      $page = ($page > $total_pages && $total_pages > 0) ? $total_pages : $page;

      // Calculate offset
      $offset = ($page - 1) * $posts_per_page;

      // Get posts for the current page
      $posts = $this->postModel->getPosts($posts_per_page, $offset);

      $data = [
        'posts' => $posts,
        'current_page' => $page,
        'total_pages' => $total_pages
      ];

      $this->view('posts/index', $data);
    }

    public function add(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST array
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
          'title' => trim($_POST['title']),
          'body' => trim($_POST['body']),
          'user_id' => $_SESSION['user_id'],
          'title_err' => '',
          'body_err' => ''
        ];

        // Validate data
        if(empty($data['title'])){
          $data['title_err'] = 'Please enter title';
        }
        if(empty($data['body'])){
          $data['body_err'] = 'Please enter body text';
        }

        // Make sure no errors
        if(empty($data['title_err']) && empty($data['body_err'])){
          // Validated
          if($this->postModel->addPost($data)){
            flash('post_message', 'Post Added');
            header('Location: ' . URLROOT . '/posts');
          } else {
            die('Something went wrong');
          }
        } else {
          // Load view with errors
          $this->view('posts/add', $data);
        }

      } else {
        $data = [
          'title' => '',
          'body' => ''
        ];

        $this->view('posts/add', $data);
      }
    }

    public function edit($id){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST array
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
          'id' => $id,
          'title' => trim($_POST['title']),
          'body' => trim($_POST['body']),
          'user_id' => $_SESSION['user_id'],
          'title_err' => '',
          'body_err' => ''
        ];

        // Validate data
        if(empty($data['title'])){
          $data['title_err'] = 'Please enter title';
        }
        if(empty($data['body'])){
          $data['body_err'] = 'Please enter body text';
        }

        // Make sure no errors
        if(empty($data['title_err']) && empty($data['body_err'])){
          // Validated
          if($this->postModel->updatePost($data)){
            flash('post_message', 'Post Updated');
            header('Location: ' . URLROOT . '/posts');
          } else {
            die('Something went wrong');
          }
        } else {
          // Load view with errors
          $this->view('posts/edit', $data);
        }

      } else {
        // Get existing post from model
        $post = $this->postModel->getPostById($id);

        // Check for owner
        if($post->user_id != $_SESSION['user_id']){
          header('Location: ' . URLROOT . '/posts');
        }

        $data = [
          'id' => $id,
          'title' => $post->title,
          'body' => $post->body
        ];

        $this->view('posts/edit', $data);
      }
    }

    public function show($id){
      $post = $this->postModel->getPostById($id);
      $data = [
        'post' => $post
      ];
      $this->view('posts/show', $data);
    }

    public function delete($id){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Check for admin role
        if(!isAdmin()){
          header('Location: ' . URLROOT . '/posts');
          return;
        }

        if($this->postModel->deletePost($id)){
          flash('post_message', 'Post Removed');
          header('Location: ' . URLROOT . '/posts');
        } else {
          die('Something went wrong');
        }
      } else {
        header('Location: ' . URLROOT . '/posts');
      }
    }
  }
