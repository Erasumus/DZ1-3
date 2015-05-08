<?php
session_start();
header("Content-type: text/html; Charset=utf-8");
if($_POST['exit']==1){
    session_destroy();
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

        form {
            padding: 15px;
            display: table;
			margin-left: 250px; 
			margin-top: 121px;
			
			width: 775px;
        }

        input[type="text"] {
            display: block;
			margin-left: 10px;
			margin-top: 50px;
			margin-bottom: 20px;
        }

        input[type="number"] {
            width: 40px;
            margin-right: 290px;
        }

        textarea {
            min-width: 200px;
            max-width: 200px;
            max-height: 100px;
            display: block;
            margin-bottom: 30px;
        }
		
		.reale {
		float: left;
		}
        
		div {
            width: 700px;
            margin-left: 253px;
			margin-top: 0px;
            padding: 50px;
			background: url(fon2.png) center center no-repeat fixed;
        }
		
		input[type="submit"]{
		margin: 0px 0 0 100px;
		}

        .redirect {
            color: #666;
            float: right;
            text-decoration: none;;
			margin-left: -200px;
        }

        .redirect:hover {
            text-decoration: underline;

        }

        #exit {
            display: table;
            color: #666;
            text-decoration: none;
            margin-top: 5px;
            font-size: 14px;
			float:right;
			margin-left: -200px;
        }
		
		 .clr {
		clear:both}

        div > a {
            display: block;
        }

    </style>
</head>
<body>
<?php
if(isset($_SESSION['auth'])){
    ?>
<form method="post">
    <input type="text" name="name" placeholder="Введите ваш логин" value="<?= $_SESSION['auth']['login'] ?>" required>

    <p>Игры</p>

    <p><label><input type="checkbox" name="film[]" value="Интерстеллар">Call of Duty</label> - 2290руб <label>|
            Количество<input type="number" name="Int" value="1" min="1" max="5"></label></p>

    <p><label><input type="checkbox" name="film[]" value="Город героев">Assasin's Creed</label> - 1500руб <label>|
            Количество<input type="number" name="GG" value="1" min="1" max="5"></label></p>

    <p><label><input type="checkbox" name="film[]" value="Ярость">GTA V</label> - 2000руб
        <label>| Количество<input type="number" name="Jar" value="1" min="1" max="5"></label></p>


    <label>Коментарии:<textarea name="comment"></textarea></label>
    <input type="submit" name="submit" value="Отправить">
    <?php
    if ($_SESSION['auth']['role'] == 'admin') {
        ?>
        <a href="table.php" class="redirect">Таблица заказов</a>
		<div class="clr"></div>
        <a href="auth.php?exit=1" id="exit">Выйти из профиля</a>
    <?php
    } else {
        ?>
        <a href="auth.php?exit=1" class="redirect">Выйти из профиля</a>
    <?php
    }
    ?>

</form>

<?php

if (isset($_POST['submit'])) {
    $mass['name'] = $_POST['name'];
    ?>
    <div>
        <p>Здравствуйте,<?= $_POST['name'] ?></p>

        <p>Ваш заказ:</p>
        <ul>
            <?php
            if (isset($_POST['film'])) {
                $mass['film'] = $_POST['film'];
                $mass['film'] = implode(" | ", $mass['film']);
                foreach ($_POST['film'] as $item) {
                    ?>
                    <li><?= $item ?></li>
                <?php
                }
            } else echo "<p style='color: red;'>Ничего</p>";


            ?>
        </ul>

        <?php
        if (!empty($_POST['comment'])) {
            ?>

            <p>Комментарий:</p>
            <p><?= $_POST['comment'] ?></p>
            <?php
            $mass['comment'] = $_POST['comment'];
        }
        ?>
        <p>Общая цена:</p>
        <?php
        $all_price = 0;
        if (isset($_POST['film']))
            foreach ($_POST['film'] as $price)
                switch ($price) {
                    case('Call of Duty'):
                        $all_price += 2290 * $_POST['Int'];
                        break;

                    case('Assasin's Creed'):
                        $all_price +=  1500 * $_POST['GG'];
                        break;

                    case('GTA V'):
                        $all_price += 2000 * $_POST['Jar'];
                        break;

                }
        ?>
        <p><?= $all_price ?></p>
    </div>
    <?php
    $fp = fopen("test.csv", "a+");
    fputcsv($fp, $mass, ';');
    fclose($fp);
}
}

else {
    ?>

    <div style="text-align: center; color: red;">
        Вы не авторизованы
    <a href="auth.php">Авторизация</a>
    </div>

<?php
}



?>

</body>
</html>