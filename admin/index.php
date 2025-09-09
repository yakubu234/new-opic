<?php
require_once '../config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - All Properties</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>All Properties</h2>

<p><a href="create.php">Add New Property</a></p>

<table>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Location</th>
        <th>Actions</th>
    </tr>
    <?php
    try {
        $stmt = $conn->prepare("SELECT id, title, location FROM properties ORDER BY id DESC");
        $stmt->execute();
        $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($properties as $property) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($property['id']) . "</td>";
            echo "<td>" . htmlspecialchars($property['title']) . "</td>";
            echo "<td>" . htmlspecialchars($property['location']) . "</td>";
            echo "<td>";
            echo "<a href='edit.php?id=" . $property['id'] . "'>Edit</a> | ";
            echo "<a href='delete.php?id=" . $property['id'] . "' onclick='return confirm(\"Are you sure you want to delete this property?\")'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
</table>

</body>
</html>
