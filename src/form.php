<?php
require("/var/www/includes/vendor/autoload.php");
require("RedirectController.php");

$redirectController = new RedirectController();
$existingRoutes = $redirectController->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="redir-form.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>

<style>
    * {
        font-family: 'Roboto', sans-serif;
    }

    h1 {
        text-align: center;
        margin: 36px auto;
    }

    .form-container {
        display: block;
        margin: 0 auto;
        width: 400px;
        background: #f3f3f3;
        border: 1px solid #c3c3c3;
        border-radius: 3px;
        padding: 36px;
        text-align: center;
    }

    .form-container input {
        display: block;
        margin: 6px auto;
    }

    .divider {
        height: 1px;
        width: 93%;
        background: #c3c3c3;
        margin: 36px auto;
    }

    .existing-urls {
        display: block;
        margin: 0 auto;
        max-width: 800px;
        text-align: center;
    }

    .existing-urls table {
        width: 100%;
        box-sizing: border-box;
        border-collapse: collapse;
    }

    .existing-urls th, td {
        border: 1px solid #c3c3c3;
        margin: 0;
        padding: 4px;
    }

    .remove-row {
        cursor: pointer;
        color: #c34545;
        font-weight: bold;
    }
</style>

<h1>URL Shortener</h1>

<div class="form-container">
    <form class="shortener-form" id="custom-form" method="post" action="/submit.php">
        <p>Custom URL Shortener</p>
        <p class="form-response"></p>
        <input id="url-long" name="url-long" type="text" placeholder="URL to Shorten" />
        <input id="url-short" name="url-short" type="text" placeholder="Shortened URL" />
        <input id="shorten-type" name="shorten-type" type="hidden" value="custom" />
        <input type="submit" name="submit" id="submit-btn" value="Custom Submit" />
    </form>
    <div class="divider"></div>
    <form class="shortener-form" id="random-form" method="post" action="/submit.php">
        <p>Randomized URL Shortener</p>
        <p class="form-response"></p>
        <input id="url-long" name="url-long" type="text" placeholder="URL to Shorten" />
        <input id="shorten-type" name="shorten-type" type="hidden" value="random" />
        <input type="submit" name="submit" id="submit-btn" value="Randomized Submit" />
    </form>
</div>
<div class="existing-urls">
    <h4>Existing URLs</h4>
    <table id="existing-table">
        <tr>
            <th style="width: 45%">Long URL</th>
            <th style="width: 45%">Short URL</th>
            <th>Delete</th>
        </tr>
        <?php foreach($existingRoutes as $short => $long) { ?>
        <tr>
            <td><a href="<?= $long ?>"><?= $long ?></a></td>
            <td><a href="<?= $short ?>"><?= $short ?></a></td>
            <td class="remove-row" data-key="<?= $short ?>">&times;</td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>

