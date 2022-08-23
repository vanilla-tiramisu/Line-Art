<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width,initial-scale=1"/>
    <title>Line Art - upload</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="shortcut icon" href="favicon.ico">
</head>
<body>
<script>
    let response;
</script>
<?php
//相当于是行使controller的功能。
require_once '../models/Find.php';

use php\models\Find;

$find = new Find();
try {
    if (isset($_GET['id'])) {
        $found = $find->showItemById($_GET['id']);
        if ($found) {
            $result = json_encode([
                'status' => 'success',
                'msg' => $found
            ], JSON_THROW_ON_ERROR);
            $find->VisitingAnItem($_GET['id']);
        } else {
            $result = json_encode([
                'status' => 'fail',
            ], JSON_THROW_ON_ERROR);
        }
    } else {
        $result = json_encode([
            'status' => 'success',
            'msg'=>'new item'
        ], JSON_THROW_ON_ERROR);
    } ?>
    <script>response = (<?php echo $result;?>)</script>
<?php
} catch (Exception $exception) {
try {
$result = json_encode([
    'status' => 'fail',
    'msg' => $exception->getMessage(),
], JSON_THROW_ON_ERROR);
?>
    <script>response = (<?php echo $result;?>)</script>
<?php
} catch (JsonException $e) {
$result = $e; ?>
    <script>response = (<?php echo $result;?>)</script>
    <?php
}
}
?>
<script>console.log(response)</script>
<nav>
    <img src="../shared/icons/icon-hamburger.svg" alt="hamburger" class="__hamburger --display">
    <img src="../shared/icons/icon-close.svg" alt="close" class="__close">
    <ul class="__menu">
        <li class="__self">
            <a href="myspace.html" class="__avatar"></a>
            <a href="myspace.html" class="__username">username</a>
        </li>
        <li class="__home"><a href="index.html" >home</a></li>
        <li class="__search"><a href="search.html" >search</a></li>
        <li class="__items"><a href="items.html" >items</a></li>
        <li class="__login"><span >login</span></li>
        <li class="__register"><a href="register.html" >register</a></li>
        <li class="__cart"><a href="cart.html" >cart</a></li>
        <li class="__upload"><a href="upload.php" >upload</a></li>
        <li class="__logout"><span >logout</span></li>
    </ul>
</nav>

<form method="post" class="upload" enctype="multipart/form-data">
    <h1>UPLOAD</h1>
    <fieldset>
        <section class="__pic">
            <label for="picfile">
                <img src="../shared/img/pic.png" alt="upload pic">
            </label>
            <br>
                <input type="file" name="picfile" id="picfile" accept="image/*" required>
        </section>
        <section>
            <label for="title">Title<span class="__star">*</span></label>
            <input type="text" name="title" id="title" placeholder="untitled"
                   required maxlength="128">
            <p class="__message"></p>
            <p class="__tips">Supports input of up to 128 characters</p>
        </section>
        <section>
            <label for="artist">Artist</label>
            <input type="text" name="artist" id="artist" placeholder="anonymous artist"
                   maxlength="128">
            <p class="__message"></p>
            <p class="__tips">Supports input of up to 128 characters</p>
        </section>
        <section>
            <label for="genre">Genre</label>
            <input type="text" name="genre" id="genre"
                   placeholder="genre" maxlength="50">
            <p class="__message"></p>
            <p class="__tips">Supports input of up to 50 characters</p>

        </section>
        <section>
            <label for="creation">Time of Creation</label>
            <input type="number" name="creation" id="creation" placeholder="unknown"
                    min="0" maxlength="4">
            <label for="BC">(B.C.)</label>
            <input type="checkbox" name="BC" id="BC">
            <p class="__message"></p>
            <p class="__tips">4 bits at most</p>
        </section>
        <section>
            <label for="height">Height</label>
            <input name="height" id="height" placeholder="unknown"
                   maxlength="10" pattern="\d*(\.\d*)?" min="0">
            <p class="__message"></p>
            <label for="width">Width</label>
            <input name="width" id="width" placeholder="unknown"
                   maxlength="10" pattern="\d*(\.\d*)?" min="0">
            <p class="__message"></p>
            <select name="unit" id="length-unit">
                <option value="cm" selected>cm</option>
                <option value="px">px</option>
            </select>
            <p class="__tips">10 bits at most</p>

        </section>

        <section>
            <label for="price">Price<span class="__star">*</span></label>
            <input type="number" name="price" id="price" placeholder="price" required maxlength="10" min="0">
            <p class="__message"></p>
            <p class="__tips">10 bits at most</p>
        </section>
        <section>
            <label for="description">Description</label>
            <textarea  name="description" id="description" placeholder="no description yet"></textarea>
            <p class="__message"></p>
        </section>
        <section>
            <button type="button" value="submit" class="--success">submit</button>
        </section>
    </fieldset>
</form>
<footer>
    <small>
        Copyright © 2020-2024<br>
        <strong>Line Art</strong><br>
        All Rights Reserved.
    </small>
</footer>
<!--dialog boxes-->
<div class="dialog-wrapper">
    <div class="dialog">
        <form action="" method="post" name="login">
            <fieldset>
                <legend><span>LOGIN</span></legend>
                <section>
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="your username here">
                </section>
                <section>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="your password here">
                </section>
                <section>
                    <input type="button" value="login!" class="button --success" name="submit">
                    <input type="button" value="cancel" class="button __close">
                </section>
                <section>
                    <a href="register.html" class="--alternative">Not registered yet? Get an account now!</a>
                </section>
            </fieldset>
        </form>
    </div>
</div>
<div class="notice">sample</div>
<script src="js/cookie.js"></script>
<script src="js/form.js"></script>
<script src="js/navigator.js"></script>
<script src="js/upload.js"></script>
</body>
</html>