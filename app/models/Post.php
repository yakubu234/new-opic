<?php
  class Post {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    public function getPosts($limit, $offset){
      $this->db->query('SELECT posts.*, users.name as author_name
                        FROM posts
                        INNER JOIN users ON posts.user_id = users.id
                        ORDER BY posts.created_at DESC
                        LIMIT :limit OFFSET :offset');
      $this->db->bind(':limit', $limit);
      $this->db->bind(':offset', $offset);
      $results = $this->db->resultSet();
      return $results;
    }

    public function getTotalPosts(){
        $this->db->query('SELECT COUNT(*) as count FROM posts');
        $row = $this->db->single();
        return $row->count;
    }

    public function addPost($data){
      $this->db->query('INSERT INTO posts (user_id, title, body) VALUES (:user_id, :title, :body)');
      // Bind values
      $this->db->bind(':user_id', $data['user_id']);
      $this->db->bind(':title', $data['title']);
      $this->db->bind(':body', $data['body']);

      // Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function getPostById($id){
      $this->db->query('SELECT posts.*, users.name as author_name
                        FROM posts
                        INNER JOIN users ON posts.user_id = users.id
                        WHERE posts.id = :id');
      $this->db->bind(':id', $id);

      $row = $this->db->single();
      return $row;
    }

    public function updatePost($data){
      $this->db->query('UPDATE posts SET title = :title, body = :body WHERE id = :id');
      // Bind values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':title', $data['title']);
      $this->db->bind(':body', $data['body']);

      // Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function deletePost($id){
      $this->db->query('DELETE FROM posts WHERE id = :id');
      // Bind values
      $this->db->bind(':id', $id);

      // Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }
  }
