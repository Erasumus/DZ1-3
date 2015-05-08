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

        form {
            padding: 15px;
            display: table;
			margin-left: 230px; 
			margin-top: 121px;
			
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
    ?>

    <table>
        <tr>
            <th>Имя</th>
            <th>Фильм(ы)</th>
            <th>Комментарий</th>
        </tr>
        <?php
        $handle = fopen("test.csv", "r");
        $size = filesize("test.csv");
        while (($data = fgetcsv($handle, $size, ";")) != FALSE) {
            $row[] = $data;
        }
        fclose($handle);
        foreach ($row as $item) {
            ?>

            <tr>
                <td><?= $item[0] ?></td>
                <td><?= $item[1] ?></td>
                <td><?= $item[2] ?></td>
            </tr>


        <?php
        }
        ?>


    </table>

    <div>
        <ul>
            <li><a href="index.php">Перейдем к оформлению заказа</a></li>
            <li><a href="users.php">Перейдем к странице с пользователями</a></li>
        </ul>

    </div>
<?php
}
else {
    ?>
    <div style="text-align: center; color: red;">У вас нет прав</div>
<?php
}
?>

</body>
</html>