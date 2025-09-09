<?php
require_once '../config/db.php';

$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

// Handle form submission for update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target_dir = "../uploads/";

    // Function to handle file upload
    function upload_file($file_input_name, $target_dir, $current_value) {
        if (isset($_FILES[$file_input_name]) && $_FILES[$file_input_name]['error'] == 0) {
            $target_file = $target_dir . basename($_FILES[$file_input_name]["name"]);
            if (move_uploaded_file($_FILES[$file_input_name]["tmp_name"], $target_file)) {
                return "uploads/" . basename($_FILES[$file_input_name]["name"]);
            }
        }
        return $current_value;
    }

    try {
        // Get current images
        $stmt = $conn->prepare("SELECT image1, image2, image3, image4, floor_plan_image, author_image FROM properties WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $image1 = upload_file('image1', $target_dir, $row['image1']);
        $image2 = upload_file('image2', $target_dir, $row['image2']);
        $image3 = upload_file('image3', $target_dir, $row['image3']);
        $image4 = upload_file('image4', $target_dir, $row['image4']);
        $floor_plan_image = upload_file('floor_plan_image', $target_dir, $row['floor_plan_image']);
        $author_image = upload_file('author_image', $target_dir, $row['author_image']);

        $query = "UPDATE properties SET title=:title, location=:location, description=:description, image1=:image1, image2=:image2, image3=:image3, image4=:image4, sqft=:sqft, bedrooms=:bedrooms, bathrooms=:bathrooms, purpose=:purpose, parking=:parking, interior_highlights=:interior_highlights, kitchen_essentials=:kitchen_essentials, lifestyle_perks=:lifestyle_perks, features_amenities=:features_amenities, floor_plan_image=:floor_plan_image, floor_plan_description=:floor_plan_description, video_url=:video_url, author_name=:author_name, author_image=:author_image, author_phone=:author_phone, author_email=:author_email, author_address=:author_address, author_social_facebook=:author_social_facebook, author_social_twitter=:author_social_twitter, author_social_vimeo=:author_social_vimeo, author_social_pinterest=:author_social_pinterest, contact_address=:contact_address, contact_phone=:contact_phone, contact_email=:contact_email, contact_website=:contact_website WHERE id = :id";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(':title', $_POST['title']);
        $stmt->bindParam(':location', $_POST['location']);
        $stmt->bindParam(':description', $_POST['description']);
        $stmt->bindParam(':image1', $image1);
        $stmt->bindParam(':image2', $image2);
        $stmt->bindParam(':image3', $image3);
        $stmt->bindParam(':image4', $image4);
        $stmt->bindParam(':sqft', $_POST['sqft']);
        $stmt->bindParam(':bedrooms', $_POST['bedrooms']);
        $stmt->bindParam(':bathrooms', $_POST['bathrooms']);
        $stmt->bindParam(':purpose', $_POST['purpose']);
        $stmt->bindParam(':parking', $_POST['parking']);
        $stmt->bindParam(':interior_highlights', $_POST['interior_highlights']);
        $stmt->bindParam(':kitchen_essentials', $_POST['kitchen_essentials']);
        $stmt->bindParam(':lifestyle_perks', $_POST['lifestyle_perks']);
        $stmt->bindParam(':features_amenities', $_POST['features_amenities']);
        $stmt->bindParam(':floor_plan_image', $floor_plan_image);
        $stmt->bindParam(':floor_plan_description', $_POST['floor_plan_description']);
        $stmt->bindParam(':video_url', $_POST['video_url']);
        $stmt->bindParam(':author_name', $_POST['author_name']);
        $stmt->bindParam(':author_image', $author_image);
        $stmt->bindParam(':author_phone', $_POST['author_phone']);
        $stmt->bindParam(':author_email', $_POST['author_email']);
        $stmt->bindParam(':author_address', $_POST['author_address']);
        $stmt->bindParam(':author_social_facebook', $_POST['author_social_facebook']);
        $stmt->bindParam(':author_social_twitter', $_POST['author_social_twitter']);
        $stmt->bindParam(':author_social_vimeo', $_POST['author_social_vimeo']);
        $stmt->bindParam(':author_social_pinterest', $_POST['author_social_pinterest']);
        $stmt->bindParam(':contact_address', $_POST['contact_address']);
        $stmt->bindParam(':contact_phone', $_POST['contact_phone']);
        $stmt->bindParam(':contact_email', $_POST['contact_email']);
        $stmt->bindParam(':contact_website', $_POST['contact_website']);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error updating record.";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Fetch existing data
try {
    $stmt = $conn->prepare("SELECT * FROM properties WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $property = $stmt->fetch(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die('ERROR: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Property</title>
</head>
<body>

<h2>Edit Property</h2>

<form action="edit.php?id=<?php echo htmlspecialchars($id); ?>" method="post" enctype="multipart/form-data">
    <p><label>Title: <input type="text" name="title" value="<?php echo htmlspecialchars($property['title']); ?>" required></label></p>
    <p><label>Location: <input type="text" name="location" value="<?php echo htmlspecialchars($property['location']); ?>" required></label></p>
    <p><label>Description: <textarea name="description" required><?php echo htmlspecialchars($property['description']); ?></textarea></label></p>
    <p>
        <label>Image 1: <input type="file" name="image1"></label><br>
        <img src="../<?php echo htmlspecialchars($property['image1']); ?>" width="100">
    </p>
    <p>
        <label>Image 2: <input type="file" name="image2"></label><br>
        <img src="../<?php echo htmlspecialchars($property['image2']); ?>" width="100">
    </p>
    <p>
        <label>Image 3: <input type="file" name="image3"></label><br>
        <img src="../<?php echo htmlspecialchars($property['image3']); ?>" width="100">
    </p>
    <p>
        <label>Image 4: <input type="file" name="image4"></label><br>
        <img src="../<?php echo htmlspecialchars($property['image4']); ?>" width="100">
    </p>
    <p><label>Sqft: <input type="text" name="sqft" value="<?php echo htmlspecialchars($property['sqft']); ?>" required></label></p>
    <p><label>Bedrooms: <input type="text" name="bedrooms" value="<?php echo htmlspecialchars($property['bedrooms']); ?>" required></label></p>
    <p><label>Bathrooms: <input type="text" name="bathrooms" value="<?php echo htmlspecialchars($property['bathrooms']); ?>" required></label></p>
    <p><label>Purpose: <input type="text" name="purpose" value="<?php echo htmlspecialchars($property['purpose']); ?>" required></label></p>
    <p><label>Parking: <input type="text" name="parking" value="<?php echo htmlspecialchars($property['parking']); ?>" required></label></p>
    <p><label>Interior Highlights (comma-separated): <textarea name="interior_highlights" required><?php echo htmlspecialchars($property['interior_highlights']); ?></textarea></label></p>
    <p><label>Kitchen Essentials (comma-separated): <textarea name="kitchen_essentials" required><?php echo htmlspecialchars($property['kitchen_essentials']); ?></textarea></label></p>
    <p><label>Lifestyle Perks (comma-separated): <textarea name="lifestyle_perks" required><?php echo htmlspecialchars($property['lifestyle_perks']); ?></textarea></label></p>
    <p><label>Features & Amenities (comma-separated): <textarea name="features_amenities" required><?php echo htmlspecialchars($property['features_amenities']); ?></textarea></label></p>
    <p>
        <label>Floor Plan Image: <input type="file" name="floor_plan_image"></label><br>
        <img src="../<?php echo htmlspecialchars($property['floor_plan_image']); ?>" width="100">
    </p>
    <p><label>Floor Plan Description: <textarea name="floor_plan_description" required><?php echo htmlspecialchars($property['floor_plan_description']); ?></textarea></label></p>
    <p><label>Video URL: <input type="text" name="video_url" value="<?php echo htmlspecialchars($property['video_url']); ?>"></label></p>
    <p><label>Author Name: <input type="text" name="author_name" value="<?php echo htmlspecialchars($property['author_name']); ?>" required></label></p>
    <p>
        <label>Author Image: <input type="file" name="author_image"></label><br>
        <img src="../<?php echo htmlspecialchars($property['author_image']); ?>" width="100">
    </p>
    <p><label>Author Phone: <input type="text" name="author_phone" value="<?php echo htmlspecialchars($property['author_phone']); ?>" required></label></p>
    <p><label>Author Email: <input type="email" name="author_email" value="<?php echo htmlspecialchars($property['author_email']); ?>" required></label></p>
    <p><label>Author Address: <input type="text" name="author_address" value="<?php echo htmlspecialchars($property['author_address']); ?>" required></label></p>
    <p><label>Author Social Facebook: <input type="text" name="author_social_facebook" value="<?php echo htmlspecialchars($property['author_social_facebook']); ?>"></label></p>
    <p><label>Author Social Twitter: <input type="text" name="author_social_twitter" value="<?php echo htmlspecialchars($property['author_social_twitter']); ?>"></label></p>
    <p><label>Author Social Vimeo: <input type="text" name="author_social_vimeo" value="<?php echo htmlspecialchars($property['author_social_vimeo']); ?>"></label></p>
    <p><label>Author Social Pinterest: <input type="text" name="author_social_pinterest" value="<?php echo htmlspecialchars($property['author_social_pinterest']); ?>"></label></p>
    <p><label>Contact Address: <input type="text" name="contact_address" value="<?php echo htmlspecialchars($property['contact_address']); ?>" required></label></p>
    <p><label>Contact Phone: <input type="text" name="contact_phone" value="<?php echo htmlspecialchars($property['contact_phone']); ?>" required></label></p>
    <p><label>Contact Email: <input type="email" name="contact_email" value="<?php echo htmlspecialchars($property['contact_email']); ?>" required></label></p>
    <p><label>Contact Website: <input type="text" name="contact_website" value="<?php echo htmlspecialchars($property['contact_website']); ?>"></label></p>
    <p><button type="submit">Update Property</button></p>
</form>

</body>
</html>
