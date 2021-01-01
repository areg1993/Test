<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= PROJECT_NAME ?></title>
    <link rel="stylesheet" href="<?= CSS_URL . 'bootstrap.min.css' ?>">
    <script src="<?= JS_URL . 'jquery-3.2.1.min.js' ?>"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/0.10.0/lodash.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
    <script src="<?= JS_URL . 'login.js' ?>"></script>
</head>
<body>
<div class='container-fluid'>
    <div class="row justify-content-center">
    <div class="col-5 mt-5">
        <form id="login">
            <div class="form-group">
                <label for="InputName">Name</label>
                <input type="text" name="name" class="form-control"
                       placeholder="Enter name"  id="InputName">
                <small class="form-text text-danger messages"></small>
            </div>
            <div class="form-group">
                <label for="InputPassword">Password</label>
                <input   type="password" name="password" class="form-control" id="InputPassword" placeholder="Password">
                <small class="form-text   text-danger messages"></small>
            </div>
            <button type="submit" class="btn btn-primary">Sign In</button>
        </form>
    </div>
    </div>
</div>
</body>
</html>
