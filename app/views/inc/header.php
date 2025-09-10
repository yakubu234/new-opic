<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME; ?></title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
</head>
<body>
    <script>
        // Pass PHP variables to JavaScript
        const IS_LOGGED_IN = <?php echo isLoggedIn() ? 'true' : 'false'; ?>;
        const URLROOT = '<?php echo URLROOT; ?>';
    </script>
    <header>
        <nav>
            <a href="<?php echo URLROOT; ?>">Home</a>
            <a href="<?php echo URLROOT; ?>/pages/about">About</a>

            <div class="user-links">
                <?php if(isLoggedIn()) : ?>
                    <span>Welcome <?php echo $_SESSION['user_name']; ?></span>
                    <a href="<?php echo URLROOT; ?>/users/logout">Logout</a>
                <?php else : ?>
                    <a href="<?php echo URLROOT; ?>/users/login">Login</a>
                    <a href="<?php echo URLROOT; ?>/users/register">Register</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    <main>
