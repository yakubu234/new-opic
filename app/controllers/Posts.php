<?php
  class Posts extends Controller {
    public function __construct(){
      // We no longer need a global login check here.
      // We will check permissions on a per-action basis.
      $this->postModel = $this->model('Post');
    }

    public function index($page = 1){
      // Get posts
      $posts_per_page = 5;
      $total_posts = $this->postModel->getTotalPosts();
      $total_pages = ceil($total_posts / $posts_per_page);

      $page = filter_var($page, FILTER_VALIDATE_INT);
      $page = ($page === false || $page < 1) ? 1 : $page;
      $page = ($page > $total_pages && $total_pages > 0) ? $total_pages : $page;

      $offset = ($page - 1) * $posts_per_page;
      $posts = $this->postModel->getPosts($posts_per_page, $offset);

      $data = [
        'posts' => $posts,
        'current_page' => $page,
        'total_pages' => $total_pages
      ];

      $this->view('posts/index', $data);
    }

    public function add(){
      if(!isLoggedIn()){
        header('Location: ' . URLROOT . '/users/login');
        exit();
      }

      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = [
          'title' => trim($_POST['title']),
          'body' => trim($_POST['body']),
          'user_id' => $_SESSION['user_id'],
          'title_err' => '',
          'body_err' => ''
        ];

        if(empty($data['title'])){ $data['title_err'] = 'Please enter title'; }
        if(empty($data['body'])){ $data['body_err'] = 'Please enter body text'; }

        if(empty($data['title_err']) && empty($data['body_err'])){
          if($this->postModel->addPost($data)){
            flash('post_message', 'Post Added');
            header('Location: ' . URLROOT . '/posts');
          } else {
            die('Something went wrong');
          }
        } else {
          $this->view('posts/add', $data);
        }
      } else {
        $data = ['title' => '', 'body' => ''];
        $this->view('posts/add', $data);
      }
    }

    public function edit($id){
      $post = $this->postModel->getPostById($id);

      if(!Permissions::canEditPost($post)){
        header('Location: ' . URLROOT . '/posts');
        exit();
      }

      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = [
          'id' => $id,
          'title' => trim($_POST['title']),
          'body' => trim($_POST['body']),
          'title_err' => '',
          'body_err' => ''
        ];

        if(empty($data['title'])){ $data['title_err'] = 'Please enter title'; }
        if(empty($data['body'])){ $data['body_err'] = 'Please enter body text'; }

        if(empty($data['title_err']) && empty($data['body_err'])){
          if($this->postModel->updatePost($data)){
            flash('post_message', 'Post Updated');
            header('Location: ' . URLROOT . '/posts');
          } else {
            die('Something went wrong');
          }
        } else {
          $this->view('posts/edit', $data);
        }
      } else {
        $data = ['id' => $id, 'title' => $post->title, 'body' => $post->body];
        $this->view('posts/edit', $data);
      }
    }

    public function show($id){
      $post = $this->postModel->getPostById($id);
      $data = ['post' => $post];
      $this->view('posts/show', $data);
    }

    public function delete($id){
      if(!Permissions::canDeletePost()){
        header('Location: ' . URLROOT . '/posts');
        exit();
      }

      // The rest of the delete logic remains the same
      $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if($this->postModel->deletePost($id)){
          if ($isAjax) {
            echo json_encode(['success' => true, 'message' => 'Post Removed']);
            exit;
          }
          flash('post_message', 'Post Removed');
          header('Location: ' . URLROOT . '/posts');
        } else {
          if ($isAjax) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Something went wrong']);
            exit;
          }
          die('Something went wrong');
        }
      } else {
        header('Location: ' . URLROOT . '/posts');
      }
    }
  }
