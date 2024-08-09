<!DOCTYPE html>
<html>

<head>

<?php
    $db_host = 'localhost';
    $db_user = 'root';
    $db_password = '';
    $db_name = 'museum';
    $mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);
    if ($mysqli->connect_error) {
    die('Ошибка подключения (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }
    $db_selected = mysqli_select_db($mysqli, $db_name);

?>

</body>

</html>