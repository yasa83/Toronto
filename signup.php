<?php
session_start();
date_default_timezone_set('Asia/Manila');
$errors = array();

if(isset($_GET['action']) && $_GET['action'] == 'rewrite'){
    $_POST['users_name'] = $_SESSION['register']['name'];
    $_POST['users_birthday'] = $_SESSION['register']['birthday'];
    $_POST['users_id'] = $_SESSION['register']['id'];
    $_POST['users_password'] = $_SESSION['register']['password'];

    $errors['rewrite'] = true;
}

if(!empty($_POST)){
    $name = $_POST['users_name'];
    $birthday = $_POST['users_birthday'];
    $id = $_POST['users_id'];
    $password = $_POST['users_password'];

    if($name == ''){
        $errors['name'] = 'blank';
    }

    if($birthday == ''){
        $errors['birthday'] = 'blank';
    }

    if($id == ''){
        $errors['id'] = 'blank';
    }

    $count = strlen($password);
    if($password == ''){
        $errors['password'] = 'blank';
    }elseif ($count<4 || 16 < $count) {
        $errors['password'] = 'length';
    }

    // 画像名を取得
    $file_name = '';
    if(!isset($_GET['action'])){
        $file_name = $_FILES['users_img_name']['name'];
    }
    if(!empty($file_name)){
        $file_type = substr($file_name, -3);
        $file_type = strtolower($file_type);
        if($file_type != 'jpg' && $file_type !='png' && $file_type!='gif'){
            $errors['img_name'] = 'type';
        }
    }else{
        $errors['img_name']= 'blank';
    }

    //エラーがなかった時の処理
    if(empty($errors)){
        $date_str = date('YmdHis');
        $submit_file_name = $date_str . $file_name;

        move_uploaded_file($_FILES['users_img_name']['tmp_name'],'user_profile_image/'.$submit_file_name);

        $_SESSION['register']['name'] = $_POST['users_name'];
        $_SESSION['register']['birthday'] = $_POST['users_birthday'];
        $_SESSION['register']['id'] = $_POST['users_id'];
        $_SESSION['register']['password'] = $_POST['users_password'];

        $_SESSION['register']['img_name'] = $submit_file_name;
        header('Location: check.php');
        exit();
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="images/favicon.png" href="assets/images/favicon.png">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <!-- Website Font style -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/signup.css">
    <title>Present Box</title>

</head>
<body background="assets/images/alcohl.jpg">
    <div class="container">
        <div class="row main">
            <div class="panel-heading">
               <div class="panel-title text-center">
                    <h1 class="title">register</h1>
                </div>
            </div> 
            <div class="main-login main-center">
                <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name" class="cols-sm-2 control-label">Your Name</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" name="users_name" id="name"  placeholder="Enter your Name">
                            </div>
                            <?php if(isset($errors['name']) && $errors['name'] == 'blank'): ?>
                                    <p class="text-danger">Enter your name</p>
                            <?php endif;?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="birthday" class="cols-sm-2 control-label">Your Birthday</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
                                <input type="date" class="form-control" name="users_birthday" id="birthday"  placeholder="Enter your Birthday">
                            </div>
                            <?php if(isset($errors['birthday']) && $errors['birthday'] == 'blank'): ?>
                                    <p class="text-danger">Enter your birthday</p>
                            <?php endif;?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="username" class="cols-sm-2 control-label">User ID</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" name="users_id" id="users_id"  placeholder="Enter your User ID">
                            </div>
                            <?php if(isset($errors['id']) && $errors['id'] == 'blank'): ?>
                                    <p class="text-danger">Enter your id</p>
                            <?php endif;?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="cols-sm-2 control-label">Password</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                                <input type="password" class="form-control" name="users_password" id="password"  placeholder="Enter your Password">
                            </div>
                            <?php if(isset($errors['password']) && $errors['password'] == 'blank'): ?>
                                    <p class="text-danger">Enter your password</p>
                            <?php endif;?>
                            <?php if(isset($errors['password']) && $errors['password'] == 'length'): ?>
                                <p class="text-danger">please enter 4〜16 letters</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm" class="cols-sm-2 control-label">Confirm Password</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                                <input type="password" class="form-control" name="confirm" id="confirm"  placeholder="Confirm your Password" oninput="CheckPassword(this)" >
                            </div>
                            <?php if(isset($errors['password']) && $errors['password'] == 'blank'): ?>
                                    <p class="text-danger">Enter your password</p>
                            <?php endif;?>


                        </div>
                    </div>

                    <div class="form-group">
                        <label for="img_name" class="cols-sm-2 control-label">profile image</label>
                        <div class="cols-sm-10">
                            <input type="file" name="users_img_name" id="img_name" accept="image/*" >
                            <?php if(isset($errors['img_name'])&& $errors['img_name'] == 'blank'): ?>
                                <p class="text-danger">enter your image</p>
                            <?php endif;?>
                            <?php if(isset($errors['img_name'])&& $errors['img_name'] == 'type'): ?>
                                <p class="text-danger">only 'jpg'.'png','gif' type</p>
                            <?php endif;?>

                        </div>
                    </div>

                    <div class="form-group ">
                        <button class="btn btn-primary btn-lg btn-block login-button">Register</button>
                    </div>
                    <div class="back">
                        <a href="index.php" class="btn btn-default"><font color="#F14E95">&laquo;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;back</a></font>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/signup.js"></script>
</body>
</html>