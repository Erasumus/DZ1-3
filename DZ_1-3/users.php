<?php
session_start();
header("Content-type: text/html; Charset=utf-8");
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

        input[type="text"] {
            display: block;
        }

        input[type="number"] {
            width: 30px;
            margin-left: 10px;
        }

        textarea {
            min-width: 200px;
            max-width: 200px;
            max-height: 100px;
            display: block;
            margin-bottom: 20px;
        }

        div {
            width: 335px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            box-sizing: border-box;
        }

        table {
            margin: 0 auto;
        }

        th,td {
            padding: 5px;
            background: #fff;
            width: 100px;
        }

        ul ,li {
            padding: 0;
            margin: 0;
            list-style-position: inside;
        }

    </style>
</head>
<body>
<?php
if($_SESSION['auth']['role']=='admin') {
    $handle = fopen("users.csv", "r");
    $size=filesize("users.csv");
    while (($data = fgetcsv($handle, $size, ";")) != FALSE) {
        $row[]=$data;
    }
    fclose($handle);
    $rezult=array();
    $rezult=$_POST['roles'];
?>
<form method="post">
<table>
    <tr>
        <th>Имя</th>
        <th>Логин</th>
        <th>Email</th>
        <th>Роль</th>
    </tr>
    <?php
    foreach($row as $item){
        ?>

        <tr>
            <td><?=$item[2]?></td>
            <td><?=$item[0]?></td>
            <td><?=$item[1]?></td>
            <td><select name="roles[]"><option selected value="<?=$item[4]?>"><?=$item[4]?></option><option value="<?php
                    if($item[4]=='admin') echo "user"; else echo 'admin';?>">
                        <?php
                        if($item[4]=='admin') echo "user"; else echo 'admin';
                        ?></option></select></td>
        </tr>


    <?php
    }
    ?>
<tr>
    <td colspan="4" style="text-align: right">   <input type="submit" name="submit" value="Сохранить"></td>
</tr>

</table>
</form>
<div>
    <ul>
        <li><a href="index.php">Перейдем к оформлению заказа</a></li>
        <li><a href="table.php">Перейдем к странице с заказами</a></li>
    </ul>

</div>
<?php
$i=0;
    if(isset($_POST['submit'])){
        $fp = fopen("users.csv", "w+");
        foreach($row as $roles){
            $roles[4]=$rezult[$i];
            $i++;
            fputcsv($fp, $roles, ';');
        }
        fclose($fp);
        ?>
        <script>
            document.location.href="http://localhost/home_work/users.php";
        </script>
        <?php
    }

}
else {
    ?>
    <div style="text-align: center; color: red;">У вас нет прав</div>
<?php
}
?>
</body>
</html>