# PHP MVC Framework

This is a lightweight, custom-built MVC framework in PHP.

---

## How to Signify an AJAX Request

This is a great question about how the client (your JavaScript) and the server (your PHP controller) communicate. The key is a special HTTP header.

### On the Client-Side (JavaScript)
When we use the fetch API in `public/js/main.js` to delete a post, we add a specific header to the request:

```javascript
fetch(url, {
    method: 'POST',
    headers: {
        'X-Requested-With': 'XMLHttpRequest', // This is the magic line!
        'Content-Type': 'application/json'
    }
})
```
The `'X-Requested-With': 'XMLHttpRequest'` header is a standard, though unofficial, way for JavaScript libraries and frameworks to tell the server, "Hey, I'm an AJAX request, not a regular form submission."

### On the Server-Side (PHP)
In the `delete()` method of our `app/controllers/Posts.php` controller, we check for the presence of that exact header:

```php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
```
The `$_SERVER` superglobal in PHP contains all the information about the incoming request, including the headers. If that specific header is set, our `$isAjax` variable becomes `true`, and the controller knows to return a JSON response instead of redirecting. This is how the server can distinguish between the two types of requests.
