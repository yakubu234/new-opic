<?php

class CreateUsersTable {
    /**
     * Run the migrations.
     *
     * @param \PDO $pdo
     * @return void
     */
    public function up(PDO $pdo) {
        $pdo->exec("
            CREATE TABLE users (
              id INT(11) NOT NULL AUTO_INCREMENT,
              name VARCHAR(255) NOT NULL,
              email VARCHAR(255) NOT NULL,
              password VARCHAR(255) NOT NULL,
              role VARCHAR(255) NOT NULL DEFAULT 'user',
              created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (id)
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
        $pdo->exec("DROP TABLE IF EXISTS users;");
    }
}
