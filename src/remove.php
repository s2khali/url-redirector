<?php
// In a bigger project, throw this in /api
// Handles POST requests from our form
require("/var/www/includes/vendor/autoload.php");
require("RedirectController.php");

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $redirectController = new RedirectController();
    $postData = json_decode(file_get_contents('php://input'));

    if(!empty($postData->key)) {
        $redirectController->removeRoute($postData->key);
    }
} else {
    http_response_code(404);
}
