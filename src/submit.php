<?php
// In a bigger project, throw this in /api
// Handles POST requests from our form
require("/var/www/includes/vendor/autoload.php");
require("RedirectController.php");

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $redirectController = new RedirectController();

    $postData = json_decode(file_get_contents('php://input'));
    if ($postData->{'shorten-type'} === 'custom') {
        if (empty($postData->{'url-long'}) || empty($postData->{'url-short'})) {
            echo json_encode(['result' => 'params']);
            http_response_code(200);
        } elseif ($redirectController->addRoute($postData->{'url-long'}, $postData->{'url-short'})) {
            echo json_encode(['result' => 'success']);
            http_response_code(200);
        } else {
            echo json_encode(['result' => 'exists']);
            http_response_code(200);
        }
    } elseif ($postData->{'shorten-type'} === 'random') {
        if (empty($postData->{'url-long'})) {
            echo json_encode(['result' => 'params']);
            http_response_code(200);
        } elseif ($route = $redirectController->addRandomizedRoute($postData->{'url-long'})) {
            echo json_encode(['result' => 'success', 'route' => $route]);
            http_response_code(200);
        } else {
            echo json_encode(['result' => 'exists']);
            http_response_code(200);
        }
    } else {
        echo json_encode(['result' => 'params']);
        http_response_code(200);
    }
} else {
    http_response_code(404);
}
