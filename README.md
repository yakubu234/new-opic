# PHP MVC Framework

A lightweight, custom-built MVC framework in PHP designed to be simple, modern, and easy to understand. It includes a variety of features commonly found in professional frameworks.

---

## Features

*   **MVC Architecture:** A clean separation of concerns between Models (database logic), Views (presentation), and Controllers (application logic).
*   **Front Controller:** All requests are routed through a single entry point (`public/index.php`) for centralized control.
*   **Clean URLs:** Uses a `.htaccess` file for URL rewriting, providing clean, user-friendly URLs (e.g., `/posts/show/1`).
*   **CRUD Example:** A complete "Posts" management feature demonstrates Create, Read, Update, and Delete operations.
*   **User Authentication:** A full authentication system allows users to register, log in, and log out, with secure password hashing.
*   **Roles & Permissions:** A centralized permission system to distinguish between user roles (e.g., 'user' vs. 'admin') and control access to actions.
*   **Database Migrations:** A simple migration system to manage and version-control your database schema.
*   **CLI Tool:** A command-line helper script (`craft`) to automate tasks like creating new migration files.
*   **AJAX Support:** The framework is configured to handle AJAX requests, with an example for post deletion.
*   **Auto-Logout:** A dual-layer system (server-side and client-side) automatically logs out inactive users for enhanced security.
*   **Error Handling:** A custom error and exception handling system that logs errors to a file and displays user-friendly error pages.

---

## Setup Instructions

To set up the project on a new machine, follow these steps:

1.  **Create a Database:** Create a new, empty database in your MySQL environment (e.g., via phpMyAdmin).

2.  **Configure the Framework:**
    *   Open the `app/config/config.php` file.
    *   Update the `DB_HOST`, `DB_USER`, `DB_PASS`, and `DB_NAME` constants with your database credentials.
    *   Update the `URLROOT` constant to the root URL of your project (e.g., `http://localhost/my-mvc-app`).
    *   Update the `SITENAME` constant to your website's name.

3.  **Run Database Migrations:**
    *   Open your browser and navigate to the migration runner URL: `http://<your-url-root>/migrate`.
    *   This will automatically create the `migrations` table and then run all the necessary migrations (`users`, `posts`) to build your database schema. You do not need to run any SQL queries manually.

4.  **Ready!** Your application should now be running.

---

## How to Use

### Routing
The router (`app/libraries/Core.php`) maps URLs to controller methods. The format is:
`/controller/method/param1/param2`
- **Default Controller:** `Pages`
- **Default Method:** `index`

### Controllers
-   Controllers are stored in `app/controllers/`.
-   They should extend the base `Controller` class.
-   They handle application logic, load models, and pass data to views.

### Models
-   Models are stored in `app/models/`.
-   They handle all database interactions using the `Database` library.

### Views
-   Views are stored in `app/views/`.
-   They handle the presentation logic. Data is passed from the controller in a `$data` array.
-   Use the header and footer includes (`app/views/inc/`) to maintain a consistent layout.

### CLI Tool (`craft`)
A command-line tool is available for automating tasks.

*   **Create a Migration:**
    ```bash
    # Make the script executable (only need to do this once)
    chmod +x craft

    # Run the command
    ./craft make:migration <name_of_migration>
    ```
    Example: `./craft make:migration create_products_table`

### Permission System
The framework has a centralized permission system located in `app/helpers/permission_helper.php`.

*   **How it Works:** The `Permissions` class contains static methods (e.g., `canEditPost()`, `canDeletePost()`) that return `true` or `false`. These methods contain all the logic for who is allowed to do what.
*   **Usage:** In your controllers or views, you can call these methods to check permissions before performing an action or displaying a button.
    ```php
    // In a controller:
    if (!Permissions::canEditPost($post)) {
        // redirect away...
    }

    // In a view:
    <?php if(Permissions::canDeletePost()) : ?>
        <button>Delete</button>
    <?php endif; ?>
    ```

### How to Signify an AJAX Request
The key to distinguishing an AJAX request from a regular form submission is a special HTTP header.

*   **Client-Side (JavaScript):**
    When using `fetch` in `public/js/main.js`, add the `X-Requested-With` header:
    ```javascript
    fetch(url, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    ```

*   **Server-Side (PHP):**
    In your controller, check for this header in the `$_SERVER` superglobal:
    ```php
    $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    if ($isAjax) {
        // Return JSON
    } else {
        // Redirect
    }
    ```
