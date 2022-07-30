<?php $path = '../../../' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../../config/head.php' ?>
    <link rel="stylesheet" href="<?php echo $path; ?>public/css/verification.css?v=<?php echo time(); ?>">
    <title>E Love| Sign-in</title>
</head>

<body>

    <?php include '../layout/header.php'; ?>

    <main class="signin--main">
        <div class="signin--dialog dialog">
            <h2 class="signin__title">Welcome back!</h2>
            <p class="signin__sub-title">Sign into your account</p>
            <form class="signin__form" method="POST">
                <p class="signin__err-msg signin__err-msg--email invalid-input"></p>
                <input class="signin__input" type="text" id="email" name="email" size="25" placeholder="Email Address"><br>
                <p class="signin__err-msg signin__err-msg--password invalid-input"></p>
                <input class="signin__input" type="password" id="password" name="password" size="25" placeholder="Password"><br>
                <p class="signin__err-msg signin__err-msg--invalid-credential invalid-input"></p>
                <button class="signin__btn" type="submit">Sign in</button>
            </form>
            <p class="signin__msg">Don't have an account yet?</p>
            <a class="signup__link" href="signup.php">Create account</a>
        </div>
    </main>

    <?php include '../layout/footer.php'; ?>

    <script src="<?php echo $path; ?>public/js/script.js"></script>
    <script src="<?php echo $path; ?>public/js/verification/signin.js"></script>
</body>

</html>