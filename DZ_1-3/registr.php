<?php
session_start();
header("Content-type: text/html; Charset=utf-8");
$fp=fopen("users.csv","a+");
    $size=filesize("users.csv");
    while (($data = fgetcsv($fp, $size, ";")) != FALSE) {
        $row[]=$data;
    }
if(isset($_POST['submit'])){
    $mass=array();
    $mass['login']= $_SESSION['user']['login']=$_POST['login'];
    $mass['email']=$_SESSION['user']['email']=$_POST['email'];
    $mass['name']=$_SESSION['user']['name']=$_POST['name'];
    $_SESSION['user']['pass']=$_POST['pass'];
    $mass['pass']=md5($_POST['pass']);
    if($_SESSION['user']['login']=='admin' && $_SESSION['user']['pass']=='admin') {
        $mass['role']= $_SESSION['user']['role']='admin';
    }
    else {
        $mass['role']= $_SESSION['user']['role']='user';
    }
    for($i=0;$i<sizeof($row);$i++){
        if($row[$i][0]==$_SESSION['user']['login']) {
            $_SESSION['error'] .="Логин занят!<br>";
        }
        if($row[$i][1]==$_SESSION['user']['email']) {
            $_SESSION['error'] .="Email занят!";
        }
    }
    if(!$_SESSION['error']){
       fputcsv($fp,$mass,';');
       header("Location: http://localhost/home_work/auth.php");
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
            padding: 145px;
			width: 520px;
        }

        input[type="text"], input[type="password"] {
            display: block;
            margin: 5px 0;
        }

        form > a {
            margin-left: 15px;
            color: #666;
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
    <center><h2>Регистрация</h2></center>
    <form method="post">
        <input type="text" name="login" placeholder="Логин" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="text" name="name" placeholder="Имя" required>
        <input type="password" name="pass" placeholder="Пароль" required>
        <input type="submit" name="submit" value="Зарегистрироваться">
    </form>




    <?php
    if($_SESSION['error']){
        ?>
        <div>
            <?=$_SESSION['error']?>
        </div>
    <?php
    }
    unset($_SESSION['error']);
    fclose($fp);

    ?>
</main>



</body>
</html>