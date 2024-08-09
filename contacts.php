<!DOCTYPE html>
<html>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <link rel="stylesheet" href="css.css">
    <title>О нас</title>
</head>

<body>

    <!-- Посылка письма -->
    <?php
    session_start();
    $nameStr = "Контакты";
    if (isset($_POST['send'])) {
        $name = $_POST['theme'];
        $text = $_POST['mailText'];
        if (mail('openServerTest@yandex.ru', $name, $text)) {
            $nameStr = 'Письмо успешно отправлено';
        } else {
            $nameStr = 'Ошибка';
        }
    }
    include("check.php")
    ?>


    <table class="main">
        <?php include ("1stroka.php"); ?>
        <tr>
            <td colspan=4 >
                <h1>О нас!</h1>
                <h2>Мы продаем копии знаменитых картин, чтобы вы всегда могли украсить свой дом произведением исскуства.
                </h2>
                <h2>У нас есть картины знаменитых хужожников от разных авторов по невысокой цене.</h2>
                <form action='' method='POST'>
                    <table style="margin: 0 auto;" >
                        <tr>
                            <td colspan="2">
                                Посещаемость за <?php echo date('d.m.Y') ?>
                            </td>
                            <td colspan="2">
                                Вы можете написать нам на почту
                            </td>
                        </tr>
                        <tr>
                            <td>Всего</td>
                            <td>За день</td>
                            <td>Тема письма</td>
                            <td><input type="text" name='theme' /></td>
                        </tr>
                        <tr>
                        <td><?php echo $vsego ?></td>
                            <td><?php echo $segodny ?></td>
                            <td>Текст</td>
                            <td> <textarea cols=20 rows=5 name='mailText'></textarea></td>
                        </tr>
                        <tr>                
                             <td colspan="2">Посетителей IP: <?php echo $ipkol ?></td>
                            <td colspan="2"><button type='submit' name='send' class='btn' style="">Отправить</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
    </table>

</body>

</html>