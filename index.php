<!DOCTYPE html>
<html>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <link rel="stylesheet" href="css.css">
    <title>Главная страница</title>
</head>

<body>

<!-- СЧЕТЧИК ПОСЕТИТЕЛЕЙ -->
<?php
    // $stranica = substr(basename($_SERVER["PHP_SELF"]), 0 , -4);
    // include("check.php")
?>
<!-- СЧЕТЧИК ПОСЕТИТЕЛЕЙ -->

<!-- ВЫХОД ИЗ АВТОРИЗАЦИИ -->
<?php
session_start();
?>
<!-- ВЫХОД ИЗ АВТОРИЗАЦИИ -->

<table class="main">
<?php include("1stroka.php");?>
        <tr>
            <td colspan= "4">
                <h1>Это главная страница сайта, с нее перейдите в каталог, посмотрите новости, напишите 
                нам в контактах и не забудьте авторизоваться!
            </h1>
            <h2>
                Так же можете посмотреть на новости
            </h2>
                <table style = 'margin: 0 auto; width : 800px; height : 250px'>
                        <tr>
                            <td>Новость</td>
                            <td>Дата</td>
                        </tr>
                            <?php
                            include ("Setup.php");
                            $query = mysqli_query($mysqli, "SELECT * FROM news ORDER BY RAND() LIMIT 5;");
                            while ($result = mysqli_fetch_array($query)) {
                                $date = date("d-m-Y",strtotime($result['date']));
                                echo "<tr>
                                <td>
                                $result[text]
                                </td>
                                <td>
                                $date
                                </td>
                                </tr>";
                            }
                            ?>
                    </table>
            </td>
        </tr>
    </table>


</body>

</html>