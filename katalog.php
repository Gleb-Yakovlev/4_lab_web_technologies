<!DOCTYPE html>
<html>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <link rel="stylesheet" href="css.css">
    <title>Каталог</title>

    <style>
        body{
            background-image: "logo.png";
        }
        th,
td {
    text-align: center;
    border: 1px solid #DDA0DD;
    background: #E2D5C1;
}
    </style>
</head>

<body>

    <!-- ВЫХОД ИЗ АВТОРИЗАЦИИ -->
    <?php
    $nameStr = "Каталог";
    session_start();

    if (isset($_POST['exit'])) {
        $_SESSION['userID'] = NULL;
        $_SESSION['userName'] = NULL;
    }
    ?>
    <!-- ВЫХОД ИЗ АВТОРИЗАЦИИ -->


    <table class="main">
    <?php include("1stroka.php");?>
        <tr>
            <td colspan=4>
                <!-- CONTENT PLACE -->

                <?php
                $array = array();
                function seeTable()
                {
                    include ("Setup.php");
                    ?>

                    <table class='filterTable'>
                        <tr>
                            <td>Поиск по автору</td>
                            <td>
                                <form action='' method='POST'>
                                    <textarea cols=20 rows=1 name='poiskAutorT'></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Поиск по названию</td>
                            <td>
                                    <textarea cols=20 rows=1 name='poiskNameT'></textarea>
                            </td>
                            <!-- <?php echo $_POST['poiskNameT'] ?> -->
                        </tr>
                        <tr>
                            <td>Сортировка по дате</td>
                            <td>
                                    <select name='action' size='1'>
                                        <option value='BEZS'>Без сортировки</option>
                                        <option value='WOZRAST' >Отсортировать по возрастанию дат</option>
                                        <option value='YBIVAN' >Отсортировать по убыванию дат</option>
                                    </select>
                                    <!-- <?php if ($_POST['action'] == 'WOZRAST') {
                                            echo 'selected';
                                        } ?> -->
                                        <!-- <?php if ($_POST['action'] == 'YBIVAN') {
                                            echo 'selected';
                                        } ?> -->
                                    
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button type='submit' class='btn' name='OK' value='ok'>OK</button>
                            </td>
                            <td>
                                <button type='submit' class='btn' name='deleteF'>Убрать фильтр</button>
                                </form>
                            </td>
                        </tr>
                    </table>


                    <table>
                        <tr>
                            <th width=10%>Название</th>
                            <th width=10%>Автор</th>
                            <th width=10%>Описание</th>
                            <th width=10%>Год создания</th>
                            <th width=5%>Цена(руб)</th>
                            <th width=10%>Размеры</th>
                            <th width=40%>Изображение</th>
                            <?php
                            if ($_SESSION['userID'] != NULL) {
                                echo "<th></th>";
                            }
                            ?>
                        </tr>
                        <?php
                        $query = mysqli_query($mysqli, "SELECT * FROM exhibit");
                        if (isset($_POST["OK"])) {
                            if ($_POST['action'] == 'WOZRAST') {
                                $query = mysqli_query($mysqli, "SELECT * FROM exhibit ORDER BY Year_create");
                            }
                            if ($_POST['action'] == 'YBIVAN') {
                                $query = mysqli_query($mysqli, "S
                                ELECT * FROM exhibit ORDER BY Year_create DESC");
                            }
                            if (!empty($_POST['poiskAutorT'])) {
                                $query = mysqli_query($mysqli, "SELECT * FROM exhibit WHERE autor LIKE '%$_POST[poiskAutorT]%'");
                                //echo"SELECT * FROM exhibit WHERE autor LIKE $_POST[poiskAutorT]";
                            }
                            if (!empty($_POST['poiskNameT'])) {
                                $query = mysqli_query($mysqli, "SELECT * FROM `exhibit` WHERE `Name` LIKE '%$_POST[poiskNameT]%'");
                            }
                        }
                        if(isset($_POST['deleteF'])){
                            $query = mysqli_query($mysqli, "SELECT * FROM exhibit");
                        }
                        
                        if(isset($_POST['buyExhibit'])){
                            mysqli_query($mysqli,  "INSERT INTO `korzina` (`idUser`, `idExhibit`, sost, count, idPok) VALUES ($_SESSION[userID], $_POST[buyExhibit], 1, 1, null)");
                           // echo "INSERT INTO `korzina` (`idUser`, `idExhibit`) VALUES ($_SESSION[userID], $_POST[buyExhibit])";
                        }


                        while ($result = mysqli_fetch_array($query)) {
                            $foto = $result["Photo"];
                            $yk = date("d.m.Y", strtotime($result['Year_create']));
                            echo "<tr>
 
                            <td>$result[Name]</td>
                            <td>$result[autor]</td>
                            <td>$result[Description]</td>
                            <td>$yk</td>
                            <td>$result[price]</td>
                            <td>$result[razmer]</td>
                            <td><img width= 100% src = '$foto'></td>";

                            if ($_SESSION['userID'] != NULL) {
                                $q = mysqli_query($mysqli, "SELECT * FROM korzina WHERE idUser = '$_SESSION[userID]' AND idExhibit = '$result[Code_exhibit]' 
                                AND sost = 1");
                                $r = mysqli_fetch_array($q);
                                if ($r == null){
                                echo "
                                <form action='' method='POST'>
                                    <td><button type='submit' class='btn' name='buyExhibit' value=$result[Code_exhibit]>В корзину</button></td>
                                </form>
                                ";
                                }else{
                                    echo "<td>В корзине</td>";
                                }
                            }

                        }
                        echo "</table>";
                }
                seeTable();
                ?>
            </td>
        </tr>
    </table>


</body>

</html>