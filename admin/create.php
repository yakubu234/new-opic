<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target_dir = "../uploads/";

    // Function to handle file upload
    function upload_file($file_input_name, $target_dir) {
        if (isset($_FILES[$file_input_name]) && $_FILES[$file_input_name]['error'] == 0) {
            $target_file = $target_dir . basename($_FILES[$file_input_name]["name"]);
            if (move_uploaded_file($_FILES[$file_input_name]["tmp_name"], $target_file)) {
                return "uploads/" . basename($_FILES[$file_input_name]["name"]);
            }
        }
        return "";
    }

    $image1 = upload_file('image1', $target_dir);
    $image2 = upload_file('image2', $target_dir);
    $image3 = upload_file('image3', $target_dir);
    $image4 = upload_file('image4', $target_dir);
    $floor_plan_image = upload_file('floor_plan_image', $target_dir);
    $author_image = upload_file('author_image', $target_dir);

    try {
        $stmt = $conn->prepare("INSERT INTO properties (title, location, description, image1, image2, image3, image4, sqft, bedrooms, bathrooms, purpose, parking, interior_highlights, kitchen_essentials, lifestyle_perks, features_amenities, floor_plan_image, floor_plan_description, video_url, author_name, author_image, author_phone, author_email, author_address, author_social_facebook, author_social_twitter, author_social_vimeo, author_social_pinterest, contact_address, contact_phone, contact_email, contact_website) VALUES (:title, :location, :description, :image1, :image2, :image3, :image4, :sqft, :bedrooms, :bathrooms, :purpose, :parking, :interior_highlights, :kitchen_essentials, :lifestyle_perks, :features_amenities, :floor_plan_image, :floor_plan_description, :video_url, :author_name, :author_image, :author_phone, :author_email, :author_address, :author_social_facebook, :author_social_twitter, :author_social_vimeo, :author_social_pinterest, :contact_address, :contact_phone, :contact_email, :contact_website)");

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

        $stmt->execute();
        header("Location: index.php");
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add New Property</title>
</head>
<body>

<h2>Add New Property</h2>

<form action="create.php" method="post" enctype="multipart/form-data">
    <p><label>Title: <input type="text" name="title" required></label></p>
    <p><label>Location: <input type="text" name="location" required></label></p>
    <p><label>Description: <textarea name="description" required></textarea></label></p>
    <p><label>Image 1: <input type="file" name="image1" required></label></p>
    <p><label>Image 2: <input type="file" name="image2" required></label></p>
    <p><label>Image 3: <input type="file" name="image3" required></label></p>
    <p><label>Image 4: <input type="file" name="image4" required></label></p>
    <p><label>Sqft: <input type="text" name="sqft" required></label></p>
    <p><label>Bedrooms: <input type="text" name="bedrooms" required></label></p>
    <p><label>Bathrooms: <input type="text" name="bathrooms" required></label></p>
    <p><label>Purpose: <input type="text" name="purpose" required></label></p>
    <p><label>Parking: <input type="text" name="parking" required></label></p>
    <p><label>Interior Highlights (comma-separated): <textarea name="interior_highlights" required></textarea></label></p>
    <p><label>Kitchen Essentials (comma-separated): <textarea name="kitchen_essentials" required></textarea></label></p>
    <p><label>Lifestyle Perks (comma-separated): <textarea name="lifestyle_perks" required></textarea></label></p>
    <p><label>Features & Amenities (comma-separated): <textarea name="features_amenities" required></textarea></label></p>
    <p><label>Floor Plan Image: <input type="file" name="floor_plan_image" required></label></p>
    <p><label>Floor Plan Description: <textarea name="floor_plan_description" required></textarea></label></p>
    <p><label>Video URL: <input type="text" name="video_url"></label></p>
    <p><label>Author Name: <input type="text" name="author_name" required></label></p>
    <p><label>Author Image: <input type="file" name="author_image" required></label></p>
    <p><label>Author Phone: <input type="text" name="author_phone" required></label></p>
    <p><label>Author Email: <input type="email" name="author_email" required></label></p>
    <p><label>Author Address: <input type="text" name="author_address" required></label></p>
    <p><label>Author Social Facebook: <input type="text" name="author_social_facebook"></label></p>
    <p><label>Author Social Twitter: <input type="text" name="author_social_twitter"></label></p>
    <p><label>Author Social Vimeo: <input type="text" name="author_social_vimeo"></label></p>
    <p><label>Author Social Pinterest: <input type="text" name="author_social_pinterest"></label></p>
    <p><label>Contact Address: <input type="text" name="contact_address" required></label></p>
    <p><label>Contact Phone: <input type="text" name="contact_phone" required></label></p>
    <p><label>Contact Email: <input type="email" name="contact_email" required></label></p>
    <p><label>Contact Website: <input type="text" name="contact_website"></label></p>
    <p><button type="submit">Add Property</button></p>
</form>

</body>
</html>
