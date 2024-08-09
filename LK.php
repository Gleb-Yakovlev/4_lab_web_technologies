<!DOCTYPE html>
<html>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <link rel="stylesheet" href="css.css">
    <title>Личный кабинет пользователя</title>
</head>

<body>

    <?php $totalCost = 0 ?>

    <!-- ОБНОВЛЕНИЕ ДАННЫХ ПОЛЬЗОВАТЕЛЯ -->
    <?php
    session_start();

    if (isset($_POST['update'])) {
        include ("Setup.php");
        mysqli_query($mysqli, "UPDATE `User` 
        SET `Full_name` = '$_POST[newName]', `Password` = '$_POST[newPassword]', `Login` = '$_POST[newLogin]'
        WHERE `User`.`Code_user` = $_SESSION[userID]");

        $_SESSION['userName'] = $_POST['newName'];
        $_SESSION['password'] = $_POST['newPassword'];
        $_SESSION['login'] = $_POST['newLogin'];
    }
    ?>
    <!-- ОБНОВЛЕНИЕ ДАННЫХ ПОЛЬЗОВАТЕЛЯ -->

    <!-- УДАЛЕНИЕ ИЗ КОРЗИНЫ -->
    <?php
    if (isset($_POST['delete'])) {
        include ("Setup.php");
        mysqli_query($mysqli, "DELETE FROM `korzina` WHERE `korzina`.`idExhibit` = $_POST[delete] AND `korzina`.`idUser` = $_SESSION[userID]");
    }
    ?>
    <!-- УДАЛЕНИЕ ИЗ КОРЗИНЫ -->

    <!-- ПОДТВЕРДИТЬ ПОКУПКУ -->
    <?php
    if (isset($_POST['buy'])) {
        include ("Setup.php");
        mysqli_query($mysqli, "UPDATE `korzina` SET sost = 2 WHERE `idUser` = $_SESSION[userID]");
        // mysqli_query($mysqli, "DELETE FROM `korzina` WHERE `idUser` = $_SESSION[userID]");
    }
    ?>
    <!-- ПОДТВЕРДИТЬ ПОКУПКУ -->

    <!-- ПЕРЕКЛЮЧЕНИЕ КОРЗИНЫ -->
    <?php
    $nowKorz = 1;
        if (isset($_POST['korz'])) {
            $nowKorz = 1;
        }
        if (isset($_POST['old'])) {
            $nowKorz = 0;
        }
    ?>
    <!-- ПЕРЕКЛЮЧЕНИЕ КОРЗИНЫ -->

        <!-- Увеличение Уменьшение Count -->
        <?php
        include ("Setup.php");
        if (isset($_POST['up'])) {
            $str = explode(';', $_POST['up']);
            $cnt = $str[1] + 1;
            mysqli_query($mysqli, "UPDATE `korzina` SET count = $cnt WHERE `idPok` = $str[0]");
        }
        if (isset($_POST['down'])) {
            $str = explode(';', $_POST['down']);
            if ($str[1] > 1){
            $cnt = $str[1] - 1;
            mysqli_query($mysqli, "UPDATE `korzina` SET count = $cnt WHERE `idPok` = $str[0]");
            }
        }
    ?>
    <!-- Увеличение Уменьшение Count -->

    <!-- УДАЛЕНИЕ СТАРОГО ЗАКАЗА -->
    <?php
    if (isset($_POST['deleteOld'])) {
        include ("Setup.php");
        mysqli_query($mysqli, "DELETE FROM `korzina` WHERE `korzina`.`idPok` = $_POST[deleteOld] ");
    }
    ?>
    <!-- УДАЛЕНИЕ СТАРОГО ЗАКАЗА -->

    <table class="main">
        <?php include("1stroka.php");?>




            <td colspan=4>
                <!-- CONTENT PLACE -->
                <table class="lkTable">
                    <tr>
                        <td colspan="4">Личные данные пользователя</td>
                    </tr>
                    <tr>
                        <td>Имя</td>
                        <td>Логин</td>
                        <td>Пароль</td>
                        <td>Изменить</td>
                    </tr>
                    <tr>
                        <form action='' method='POST'>
                            <td><textarea cols=20 rows=1 name='newName'><?php echo $_SESSION['userName'] ?></textarea>
                            </td>
                            <td><textarea cols=20 rows=1 name='newLogin'><?php echo $_SESSION['login'] ?></textarea>
                            </td>
                            <td><textarea cols=20 rows=1
                                    name='newPassword'><?php echo $_SESSION['password'] ?></textarea></td>
                            <td width=30px>
                                <button type='submit' name='update' class='btn'>Изменить</button>
                            </td>
                        </form>
                    </tr>
                </table>
                <form action='' method='POST'>
                    <button type='submit' name='korz' class='btn' style="height: 40px; width: 150px;">Посмотреть корзину</button>
                    <button type='submit' name='old' class='btn' style="height: 40px; width: 150px;">Старые заказы</button>
                </form>
                <table class="lkTable">
                    <tr>
                        <td colspan="5">Корзина</td>
                    </tr>
                    <tr>
                        <td>Название</td>
                        <td>Описание</td>
                        <td>Автор</td>
                        <td>Цена(руб)</td>       
                        <td>Количество</td>
                        <td></td>
                    </tr>
                    <?php
                    if ($nowKorz){
                    include ("Setup.php");
                    $query = mysqli_query($mysqli, "SELECT * FROM view1 WHERE idUser = $_SESSION[userID] AND sost = 1");
                    $pust = true;
                    while ($result = mysqli_fetch_array($query)) {
                        $pust = false;
                        echo "
                            <tr>
                            <td>$result[exhName]</td>
                            <td>$result[Description]</td>
                            <td>$result[autor]</td>
                            <td>$result[price]</td>

                            <td>
                            $result[Cnt]
                            <form action='' method='POST'>
                                <button type='submit' name='down' value='$result[idPok];$result[Cnt];'>-</button>
                                <button type='submit' name='up' value='$result[idPok];$result[Cnt];'>+</button>
                            </form>
                            </td>
                            <form action='' method='POST'>
                                <td><button type='submit' class='btn' name='delete' value=$result[idExhibit]>Удалить</button></td>
                            </form>
                            </tr>
                            
                                ";
                        $totalCost = $totalCost + (int) $result['price']* (int)$result['Cnt'];
                    }
                    if (!$pust) {
                        ?>

                        <tr>
                            <td>Общая цена(руб)</td>
                            <td><?php echo $totalCost ?></td>
                            <td colspan="3">
                                <form action='' method='POST'>
                                    <button type='submit' class='btn' name='buy'>Подтвердить покупку</button>
                                </form>
                            </td>
                        </tr>
                    <?php } else {
                        echo "<tr>
                        <td colspan='6'> Корзина пуста! </td>
                        </tr>";
                    }
                }else{
                    include ("Setup.php");
                    $query = mysqli_query($mysqli, "SELECT * FROM view1 WHERE idUser = $_SESSION[userID] AND sost = 2");
                    $pust = true;
                    while ($result = mysqli_fetch_array($query)) {
                        $pust = false;
                        echo "
                            <tr>
                            <td>$result[exhName]</td>
                            <td>$result[Description]</td>
                            <td>$result[autor]</td>
                            <td>$result[price]</td>
                            <td>$result[Cnt]</td>
                            <form action='' method='POST'>
                            <td><button type='submit' class='btn' name='deleteOld' value=$result[idPok]>Удалить</button></td>
                            </form>
                            </tr>
                                ";
                    }

                }

                    ?>
                </table>
            </td>
        </tr>
    </table>


</body>

</html>