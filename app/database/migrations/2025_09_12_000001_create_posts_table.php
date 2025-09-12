<?php

class CreatePostsTable {
    /**
     * Run the migrations.
     *
     * @param \PDO $pdo
     * @return void
     */
    public function up(PDO $pdo) {
        $pdo->exec("
            CREATE TABLE posts (
              id INT(11) NOT NULL AUTO_INCREMENT,
              user_id INT(11) NOT NULL,
              title VARCHAR(255) NOT NULL,
              body TEXT NOT NULL,
              created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (id),
              FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            );
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @param \PDO $pdo
     * @return void
     */
    public function down(PDO $pdo) {
        $pdo->exec("DROP TABLE IF EXISTS posts;");
    }
}
