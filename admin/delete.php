<?php
require_once '../config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Optional: Delete associated images from the uploads folder
        $stmt = $conn->prepare("SELECT image1, image2, image3, image4, floor_plan_image, author_image FROM properties WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $files_to_delete = [
                $row['image1'],
                $row['image2'],
                $row['image3'],
                $row['image4'],
                $row['floor_plan_image'],
                $row['author_image']
            ];

            foreach ($files_to_delete as $file) {
                if ($file && file_exists('../' . $file)) {
                    unlink('../' . $file);
                }
            }
        }

        // Delete the record from the database
        $delete_stmt = $conn->prepare("DELETE FROM properties WHERE id = :id");
        $delete_stmt->bindParam(':id', $id);
        $delete_stmt->execute();

        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    die("No ID specified.");
}
?>
