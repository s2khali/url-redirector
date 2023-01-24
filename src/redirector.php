<?php
// Would rather see this logic in a lambda function
require("/var/www/includes/vendor/autoload.php");
require("RedirectController.php");

$redirectController = new RedirectController();

if($newRoute = $redirectController->getRedirect($_SERVER['REQUEST_URI'])) {
    // Can do analytics here if we need to
    http_response_code(301); // 301 is best practice for SEO
    header("Location: $newRoute");
} else {
    // Redirect to form?
    http_response_code(404);
}

