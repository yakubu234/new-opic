<?php

class Migrate extends Controller {
    private $pdo;

    public function __construct() {
        // This is a special controller, so we'll handle the DB connection manually.
        // This avoids running this in a production environment by mistake without setup.
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    public function index() {
        echo "Running migrations...\n<br>";

        // 1. Ensure the migrations table exists
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS migrations (
              id INT(11) NOT NULL AUTO_INCREMENT,
              migration VARCHAR(255) NOT NULL,
              batch INT(11) NOT NULL,
              PRIMARY KEY (id)
            );
        ");

        // 2. Get all migrations that have been run
        $stmt = $this->pdo->query("SELECT migration FROM migrations");
        $runMigrations = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // 3. Scan the migrations directory
        $migrationFiles = glob(APPROOT . '/database/migrations/*.php');
        sort($migrationFiles);

        // 4. Determine which migrations to run
        $migrationsToRun = [];
        foreach ($migrationFiles as $file) {
            $migrationName = basename($file, '.php');
            if (!in_array($migrationName, $runMigrations)) {
                $migrationsToRun[] = $file;
            }
        }

        if (empty($migrationsToRun)) {
            echo "No new migrations to run.\n<br>";
            return;
        }

        // 5. Run the new migrations
        $batch = $this->getLatestBatch() + 1;
        foreach ($migrationsToRun as $file) {
            require_once $file;
            $migrationName = basename($file, '.php');
            // Derive class name from filename
            $className = $this->getClassNameFromFileName($migrationName);

            if (class_exists($className)) {
                $migration = new $className();
                $migration->up($this->pdo);

                // 6. Record the migration
                $stmt = $this->pdo->prepare("INSERT INTO migrations (migration, batch) VALUES (:migration, :batch)");
                $stmt->execute(['migration' => $migrationName, 'batch' => $batch]);

                echo "Migrated: $migrationName\n<br>";
            } else {
                echo "Error: Class $className not found in $file\n<br>";
            }
        }

        echo "Migrations completed.\n<br>";
    }

    private function getLatestBatch() {
        $stmt = $this->pdo->query("SELECT MAX(batch) as max_batch FROM migrations");
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->max_batch ?? 0;
    }

    private function getClassNameFromFileName($fileName) {
        // Example: 2025_09_12_000000_create_users_table -> CreateUsersTable
        $parts = explode('_', $fileName);
        // Remove the timestamp parts
        $classNameParts = array_slice($parts, 4);
        return str_replace(' ', '', ucwords(implode(' ', $classNameParts)));
    }
}
