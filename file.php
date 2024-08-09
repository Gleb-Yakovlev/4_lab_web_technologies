<!DOCTYPE html>
<html>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <link rel="stylesheet" href="css.css">
    <title>Первое задание</title>

    <style>
        table {
            margin: 0 auto;

        }

        th,
        td {
            text-align: center;
            border: 1px solid #cdc513;

        }

        img {
            float: center;
        }
    </style>
</head>

<table>
    <form action='' method='GET'>
        <tr>
            <th width=20%><button type='submit' class="btn" name='POKAZAT'>Вывести таблицу экспонаты</button></th>
            <th width=20%><button type='submit' class="btn" name='NEWDATA'>Создать новую запись</button></th>
        </tr>
    </form>
</table>

<?php
$array = array();
function seeTable()
{
    include ("Setup.php");
    if (isset ($_POST['DELETE'])) {
        $query = mysqli_query($mysqli, "DELETE FROM `exhibit` WHERE `exhibit`.`Code_exhibit` = $_POST[DELETE]");

    }

    if (isset ($_POST['UPDATEDATA'])) { 
        $query = mysqli_query($mysqli, "UPDATE `exhibit` 
        SET `Name` = '$_POST[name]',`Description` = '$_POST[textK]', `Photo` = '$_POST[photo]', `Year_create` = '$_POST[data] '
     WHERE `exhibit`.`Code_exhibit` = $_POST[UPDATEDATA]");
    }
    ?>

    <table>
        <form action='' method='POST'>
            <select name='action' size='1'>
                <option value='BEZS'>Без сортировки</option>
                <option value='WOZRAST' <?php if ($_POST['action'] == 'WOZRAST') {
                    echo 'selected';
                } ?>>Отсортировать по
                    возрастанию дат</option>
                <option value='YBIVAN' <?php if ($_POST['action'] == 'YBIVAN') {
                    echo 'selected';
                } ?>>Отсортировать по
                    убыванию
                    дат</option>
            </select><BR>
            <button type='submit' class="btn" name='OK' value='ok'>OK</button>
        </form>
    </table>


    <table>
        <tr>
            <th width=10%>Удаление</th>
            <th width=5%>Код экспоната</th>
            <th width=10%>Название</th>
            <th width=25%>Описание</th>
            <th width=10%>Год создания</th>
            <th width=10%>Имя изображения</th>
            <th width=40%>Изображение</th>
        </tr>
        <?php
        $query = mysqli_query($mysqli, "SELECT Code_exhibit, Name, Description, Photo, Year_create, Code_hall
    FROM exhibit");
        if (isset ($_POST["OK"])) {
            if ($_POST['action'] == 'WOZRAST') {
                $query = mysqli_query($mysqli, "SELECT Code_exhibit, Name, Description, Photo, Year_create, Code_hall
    FROM exhibit ORDER BY Year_create");
            }
            if ($_POST['action'] == 'YBIVAN') {
                $query = mysqli_query($mysqli, "SELECT Code_exhibit, Name, Description, Photo, Year_create, Code_hall
    FROM exhibit ORDER BY Year_create DESC");
            }
        }


        while ($result = mysqli_fetch_array($query)) {
            $foto = $result["Photo"];
            echo "<tr>
        <td>


        <form action='' method='post'>
        <button type='submit' name='DELETE' class='btn' value=$result[Code_exhibit]>Удалить</button>
        </form>
        

        <form action='' method='post'>
        <button type='submit' name='UPDATEDATA' class='btn' value=$result[Code_exhibit]>Подтвердить изменения</button>
        </td>
        <td>" . $result['Code_exhibit'] . "</td>
        <td><textarea cols=20 rows=8 name='name'>$result[Name]</textarea></td>
        <td><textarea cols=30 rows=8 name='textK'>$result[Description]</textarea></td>
        <td><INPUT TYPE='date' NAME='data' value=$result[Year_create]></td>
        <td><textarea cols=20 rows=8 name='photo'>$result[Photo]</textarea></td>
        <td><img width= 100% src = '$foto'></td>
        
        </form>
";
        }
        echo "</table>";
}

if (isset ($_GET['POKAZAT'])) {
    seeTable();
}
?>

    <?php
    if (isset ($_GET['NEWDATA'])) {
        ?>

        <h1>Ввод новых данных</h1>
        <table>
            <tr>
                <th width=15%>Название</th>
                <th width=30%>Описание</th>
                <th width=10%>Год создания</th>
                <th width=45%>Название изображения</th>
            </tr>
            <tr>
                <form action='' method='post'>
                    <th><textarea cols=20 rows=8 name='name'></textarea></th>
                    <th><textarea cols=20 rows=8 name='textK'></textarea></th>
                    <th><INPUT TYPE='date' NAME='data' value="<?php echo date('d-m-Y'); ?>"></th>
                    <th><INPUT TYPE='file' NAME='photo'></th>
                    <!-- <th><textarea cols=20 rows=8 name='photo'></textarea></th> -->
            </tr>
        </table>
        <button type='submit' name='add' class='btn' value='add'>Добавить</button>
        </form>

        <?php
        include ("Setup.php");
        if (isset ($_POST['add']) and !empty ($_POST['name']) and !empty ($_POST['textK']) and !empty ($_POST['data']) and !empty ($_POST['photo'])) {
            $query = mysqli_query($mysqli, "INSERT INTO `exhibit` 
        (`Name`, `Description`, `Photo`, `Code_exhibit`, `Year_create`, `Code_hall`) 
        VALUES ('$_POST[name]', ' $_POST[textK]', '$_POST[photo]', NULL, '$_POST[data]', NULL)");
        } elseif (isset ($_POST['add'])) {
            echo "Введите все данные";
        }
    }
    ?>

    </body>

</html>