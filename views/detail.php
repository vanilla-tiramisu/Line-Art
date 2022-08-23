<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width,initial-scale=1"/>
    <title>Line Art - item</title>
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
            'status' => 'fail',
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
<nav>
    <img src="../shared/icons/icon-hamburger.svg" alt="hamburger" class="__hamburger --display">
    <img src="../shared/icons/icon-close.svg" alt="close" class="__close">
    <ul class="__menu">
        <li class="__self">
            <a href="myspace.html" class="__avatar"></a>
            <a href="myspace.html" class="__username">username</a>
        </li>
        <li class="__home"><a href="index.html">home</a></li>
        <li class="__search"><a href="search.html">search</a></li>
        <li class="__items"><a href="items.html">items</a></li>
        <li class="__login"><span>login</span></li>
        <li class="__register"><a href="register.html">register</a></li>
        <li class="__cart"><a href="cart.html">cart</a></li>
        <li class="__upload"><a href="upload.php">upload</a></li>
        <li class="__logout"><span>logout</span></li>
    </ul>
</nav>
<main class="detail">
    <h2>title</h2>
    <div class="__img-wrapper">
        <img src="../shared/img/loading.png" alt="" class="__img">
    </div>
    <div class="__price">
        <span class="__field">price:</span>
        <span class="__value">100000</span>
    </div>
    <div class="detail__attr">
        <p class="__title">
            <span class="__field">title:</span>
            <span class="__value"></span>
        </p>
        <p class="__artist">
            <span class="__field">artist:</span>
            <span class="__value"></span>
        </p>
        <p class="__create">
            <span class="__field">created in:</span>
            <span class="__value"></span>
        </p>
        <p class="__height">
            <span class="__field">height:</span>
            <span class="__value"></span>
            <span class="__unit"></span>
        </p>
        <p class="__width">
            <span class="__field">width:</span>
            <span class="__value"></span>
            <span class="__unit"></span>
        </p>
        <p class="__genre">
            <span class="__field">genre:</span>
            <span class="__value"></span>
        </p>
        <p class="__release">
            <span class="__field">released in:</span>
            <span class="__value"></span>
        </p>
        <p class="__user">
            <span class="__field">released by:</span>
            <span class="__value"></span>
        </p>
        <p class="__visit">
            <span class="__field">visited:</span>
            <span class="__value">0</span>
            <span class="__unit">times</span>
        </p>
        <button class="--cart --success">Add to cart</button>
        <button class="--buy --success">Buy now!</button>
    </div>
    <div class="detail__description">
        There's no description for this item yet.
    </div>
</main>

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
<script src="js/detail.js"></script>
</body>
</html>