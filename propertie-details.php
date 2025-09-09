<?php
require_once 'config/db.php';

$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

try {
    $stmt = $conn->prepare("SELECT * FROM properties WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $property = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$property) {
        die('Property not found.');
    }
} catch(PDOException $e) {
    die('ERROR: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<!-- HEAD SECTION -->
<body>

    <section class="propertie-section fix section-padding">
        <div class="container">
            <div class="propertie-details-wrapper">
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="propertie-details-wrapper">
                            <div class="details-image">
                                <img src="<?php echo htmlspecialchars($property['image1']); ?>" alt="img">
                            </div>
                            <div class="row g-4 mt-3">
                                <div class="col-xl-4 col-lg-6 col-md-6">
                                     <div class="details-image">
                                        <img src="<?php echo htmlspecialchars($property['image2']); ?>" alt="img">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6">
                                     <div class="details-image">
                                        <img src="<?php echo htmlspecialchars($property['image3']); ?>" alt="img">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6">
                                     <div class="details-image">
                                        <img src="<?php echo htmlspecialchars($property['image4']); ?>" alt="img">
                                    </div>
                                </div>
                            </div>
                            <div class="details-content">
                                <span class="location"><i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($property['location']); ?></span>
                                <h2><?php echo htmlspecialchars($property['title']); ?></h2>
                                <p class="mt-3">
                                    <?php echo nl2br(htmlspecialchars($property['description'])); ?>
                                </p>
                                <div class="list-items">
                                    <h3>Property Overview</h3>
                                    <ul>
                                        <li>
                                           <img src="assets/img/home-1/project/full-screen.png" alt="img">
                                           <?php echo htmlspecialchars($property['sqft']); ?> sqft
                                        </li>
                                        <li>
                                           <img src="assets/img/home-1/project/bed.png" alt="img">
                                            Bedroom_ <?php echo htmlspecialchars($property['bedrooms']); ?>
                                        </li>
                                        <li>
                                            <img src="assets/img/home-1/project/user.png" alt="img">
                                           Bath_ <?php echo htmlspecialchars($property['bathrooms']); ?>
                                        </li>
                                        <li>
                                             <img src="assets/img/home-1/project/full-screen.png" alt="img">
                                           Purpose_ <?php echo htmlspecialchars($property['purpose']); ?>
                                        </li>
                                        <li>
                                           <img src="assets/img/home-1/project/bed.png" alt="img">
                                           Parking_ <?php echo htmlspecialchars($property['parking']); ?>
                                        </li>
                                    </ul>
                                </div>
                                <div class="list-items-2">
                                    <h3>Interior Highlights:</h3>
                                    <ul>
                                        <?php
                                        $interior_highlights = explode(',', $property['interior_highlights']);
                                        foreach ($interior_highlights as $highlight) {
                                            echo "<li><i class=\"flaticon-right-arrow\"></i> " . htmlspecialchars(trim($highlight)) . "</li>";
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="list-items-2">
                                    <h3>Kitchen & Dining Essentials:</h3>
                                    <ul>
                                        <?php
                                        $kitchen_essentials = explode(',', $property['kitchen_essentials']);
                                        foreach ($kitchen_essentials as $essential) {
                                            echo "<li><i class=\"flaticon-right-arrow\"></i> " . htmlspecialchars(trim($essential)) . "</li>";
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="list-items-2">
                                    <h3>Lifestyle Perks:</h3>
                                    <ul>
                                        <?php
                                        $lifestyle_perks = explode(',', $property['lifestyle_perks']);
                                        foreach ($lifestyle_perks as $perk) {
                                            echo "<li><i class=\"flaticon-right-arrow\"></i> " . htmlspecialchars(trim($perk)) . "</li>";
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="list-items-3">
                                    <h3>Features & amenities</h3>
                                    <div class="list-wrap">
                                        <ul>
                                        <?php
                                        $features_amenities = explode(',', $property['features_amenities']);
                                        $chunks = array_chunk($features_amenities, 2);
                                        foreach ($chunks as $chunk) {
                                            echo "<ul>";
                                            foreach ($chunk as $item) {
                                                echo "<li><i class=\"flaticon-right-arrow\"></i>" . htmlspecialchars(trim($item)) . "</li>";
                                            }
                                            echo "</ul>";
                                        }
                                        ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="floor-plan-items">
                                    <div class="tab-content">
                                        <div id="Frist" class="tab-pane fade show active">
                                            <div class="row g-4 align-items-center">
                                                <div class="col-lg-5 col-md-6">
                                                    <div class="thumb">
                                                        <img src="<?php echo htmlspecialchars($property['floor_plan_image']); ?>" alt="img">
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 col-md-6">
                                                    <div class="content">
                                                        <h3>Floor Plan</h3>
                                                        <p class="mt-4">
                                                            <?php echo nl2br(htmlspecialchars($property['floor_plan_description'])); ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="video-items">
                                        <h3>Property Video</h3>
                                        <div class="video-image">
                                            <img src="<?php echo htmlspecialchars($property['image1']); ?>" alt="img">
                                            <a href="<?php echo htmlspecialchars($property['video_url']); ?>" class="video-btn video-popup">
                                                PLAY
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="propertie-details-sidebar">
                           <div class="propertie-sidebar-item mt-0">
                                <h3>Author Info</h3>
                                <div class="info-area-item">
                                    <div class="info-items">
                                        <img src="<?php echo htmlspecialchars($property['author_image']); ?>" alt="img">
                                        <div class="info-cont">
                                            <h4><?php echo htmlspecialchars($property['author_name']); ?></h4>
                                        </div>
                                    </div>
                                     <ul class="info-list">
                                        <li>
                                            <i class="fa-solid fa-phone"></i>
                                            <a href="tel:<?php echo htmlspecialchars($property['author_phone']); ?>"><?php echo htmlspecialchars($property['author_phone']); ?></a>
                                        </li>
                                        <li>
                                            <i class="fa-solid fa-envelopes"></i>
                                            <a href="mailto:<?php echo htmlspecialchars($property['author_email']); ?>"><?php echo htmlspecialchars($property['author_email']); ?></a>
                                        </li>
                                        <li>
                                            <i class="fa-solid fa-location-dot"></i>
                                            <?php echo htmlspecialchars($property['author_address']); ?>
                                        </li>
                                    </ul>
                                    <div class="social-icon d-flex align-items-center">
                                        <span>Social Icon:</span>
                                        <a href="<?php echo htmlspecialchars($property['author_social_facebook']); ?>"><i class="fab fa-facebook-f"></i></a>
                                        <a href="<?php echo htmlspecialchars($property['author_social_twitter']); ?>"><i class="fab fa-twitter"></i></a>
                                        <a href="<?php echo htmlspecialchars($property['author_social_vimeo']); ?>"><i class="fab fa-vimeo-v"></i></a>
                                        <a href="<?php echo htmlspecialchars($property['author_social_pinterest']); ?>"><i class="fab fa-pinterest-p"></i></a>
                                    </div>
                                </div>
                           </div>
                           <div class="propertie-sidebar-item">
                                <h3>Property Contact</h3>
                                <ul class="contact-list">
                                    <li>
                                        <div class="icon">
                                            <i class="fa-solid fa-location-dot"></i>
                                        </div>
                                        <div class="content">
                                            <span>Address</span>
                                            <h4><?php echo htmlspecialchars($property['contact_address']); ?></h4>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="icon">
                                            <i class="fa-solid fa-phone"></i>
                                        </div>
                                        <div class="content">
                                            <span>Phone</span>
                                            <h4><a href="tel:<?php echo htmlspecialchars($property['contact_phone']); ?>"><?php echo htmlspecialchars($property['contact_phone']); ?></a></h4>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="icon">
                                            <i class="fa-solid fa-envelopes"></i>
                                        </div>
                                        <div class="content">
                                            <span>Email</span>
                                            <h4><a href="mailto:<?php echo htmlspecialchars($property['contact_email']); ?>"><?php echo htmlspecialchars($property['contact_email']); ?></a></h4>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="icon">
                                           <i class="fa-solid fa-globe"></i>
                                        </div>
                                        <div class="content">
                                            <span>Website</span>
                                            <h4><a href="<?php echo htmlspecialchars($property['contact_website']); ?>"><?php echo htmlspecialchars($property['contact_website']); ?></a></h4>
                                        </div>
                                    </li>
                                </ul>
                           </div>
                           <div class="propertie-sidebar-item">
                                <h3>Contact Listing Owner</h3>
                                <form action="#" method="POST">
                                    <div class="row g-4">
                                        <div class="col-sm-12">
                                            <div class="form-clt">
                                                <input type="text" name="name" id="name" placeholder="Full Name">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-clt">
                                                <input type="text" name="email" id="email" placeholder="Email address">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-clt">
                                                <textarea name="message" id="message" placeholder="Message Here*"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <button class="theme-btn" type="submit">
                                                SUBMIT NOW
                                            </button>
                                        </div>
                                    </div>
                                </form>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
</html>
