<?php
session_start();
header("Content-type: text/html; Charset=utf-8");
unset($_SESSION['auth']);
$fp=fopen("users.csv","a+");
$size=filesize("users.csv");
while (($data = fgetcsv($fp, $size, ";")) != FALSE) {
    $row[]=$data;
}
if(isset($_POST['submit'])) {
    foreach($row as $key=>$item) {
    if ($item[0] == $_POST['login'] && $item[3] == md5($_POST['pass'])) {
        $_SESSION['auth']['login'] = $_POST['login'];
        $_SESSION['auth']['role'] = $item[4];
        unset( $_SESSION['error']);
        break;
    } else {
        $_SESSION['error'] = "Данные не совпадают";
    }
}
    if (!$_SESSION['error']) {
        header("Location: http://localhost/home_work/index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <style>
        body {
            
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
			color: #FFC80D;
			font: 17px Arial;
        }

        main {
            display: table;
           
            margin-left: 255px; 
			margin-top: 121px;
            padding: 170px;
			width: 470px;
        }

        input[type="text"], input[type="password"] {
            display: block;
            margin: 5px 0;
        }

        form > a {
            margin-left: 15px;
            color: #FFC80D;
            text-decoration: none;
            font-size: 12px;
        }

        form {
            margin: 0 auto;
            display: table;
			
        }

        div {
            background: #ff7d98;
            padding: 10px;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<main>
    <center><h2>Добро пожаловать!</h2></center>

    <form method="post">
        <input type="text" name="login" placeholder="Логин" value="<?= $_SESSION['user']['login'] ?>" required>
        <input type="password" name="pass" placeholder="Пароль" value="<?= $_SESSION['user']['pass'] ?>" required>
        <input type="submit" name="submit" value="Войти">
        <a href="registr.php">Зарегистрироваться</a>
    </form>

    <?php
    if ($_SESSION['error']) {
        ?>

        <div>
            <?= $_SESSION['error'] ?>
        </div>
    <?php
    }

?>
</main>

</body>
</html>