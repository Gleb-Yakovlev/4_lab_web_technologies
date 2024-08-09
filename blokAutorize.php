<link rel="stylesheet" href="css.css">

<th width=500 height=200>

    <?php

    if (isset($_POST['exit'])) {
        $_SESSION['userName'] = null;
        $_SESSION['userID'] = null;
        $_SESSION['login'] = null;
        $_SESSION['password'] = null;
        header("Location: index.php");
    }
    $topText = "Авторизация";
    if ($_SESSION['userID'] != NULL) {
        echo "<table class='reg'>";
        echo "<tr><td>Здравсвуйте " . $_SESSION['userName'] . "</td></tr>";
        ?>
        <form action='' method='POST'>
            <tr>
                <td><button type='submit' name='exit' class='btn'>Выйти</button></td>
            </tr>
        </form>
        <form action='LK.php'>
            <tr>
                <td><button type='submit' class='btn'>В личный кабинет</button></td>
            </tr>
        </form>
        </table>
        <?php
    } else {

        ?>
        <!-- КОд -->
        <?php
        session_start();
        $displayREG = "none";
        $displayAUTO = "";
        // ПЕРЕКЛЮЧЕНИЕ таблиц
        if (isset($_POST['toAutoriz'])) {
            $_SESSION['tableDisp'] = 'a';
            $topText = "Авторизация";
            //echo "autor";
        }
        if (isset($_POST['toReg'])) {
            $_SESSION['tableDisp'] = 'r';
            $topText = "Регистрация";
            //echo "reg";
        }
        if ($_SESSION['tableDisp'] == 'a') {
            $displayREG = "none";
            $displayAUTO = "";
        }
        if ($_SESSION['tableDisp'] == 'r') {
            $displayREG = "";
            $displayAUTO = "none";
        }
        //
    
        //АВТОРИЗАЦиЯ
        if (isset($_POST['autorization'])) {
            if (empty($_POST['login']) || empty($_POST['password'])) {
                $topText = "Заполните все поля авторизации";
            } else {
                include ("Setup.php");
                $query = mysqli_query($mysqli, "SELECT * FROM user WHERE Login = '$_POST[login]' AND Password = '$_POST[password]'");
                $result = mysqli_fetch_array($query);
                if ($result['Code_user'] == NULL) {
                    $topText = "Ошибка в логине или пароле!";
                } else {
                    $_SESSION['userName'] = $result['Full_name'];
                    $_SESSION['userID'] = $result['Code_user'];
                    $_SESSION['login'] = $result['Login'];
                    $_SESSION['password'] = $result['Password'];
                    header("Location: index.php");
                }
            }
        }


        //РЕГИСТРАЦИЯ
    
        if (isset($_POST['registr'])) {
            if (empty($_POST['login']) || empty($_POST['password']) || empty($_POST['name'])) {
                $topText = "Заполните все поля регистрации";
            } else {
                include ("Setup.php");


                $query = mysqli_query($mysqli, "SELECT COUNT(*) FROM user WHERE Login = '$_POST[login]'");
                $result = mysqli_fetch_array($query);
                if ($result[0] > 0)
                    $topText = "Пользователь уже зарегистрировался";
                if ($result[0] == 0) {
                    //echo "Пользователь еще не зарегистрировался";
                    $query = mysqli_query($mysqli, "INSERT INTO `user` (`Full_name`, `Password`, `Login`, `Code_user`) 
                VALUES ('$_POST[name]', '$_POST[password]', '$_POST[login]', NULL)");
                    $_SESSION['userName'] = $_POST['name'];
                    $_SESSION['password'] = $_POST['password'];
                    $_SESSION['login'] = $_POST['login'];

                    $query = mysqli_query($mysqli, "SELECT Code_user FROM user WHERE Login = '$_POST[login]' AND Password = '$_POST[password]'");
                    $result = mysqli_fetch_array($query);
                    $_SESSION['userID'] = $result['Code_user'];
                    header("Location: index.php");
                }
            }
        }
        ?>




        <!-- Таблица регистрации -->
        <table class="reg" style="display: <?php echo $displayREG ?>">
            <tr>

            <tr>
                <td colspan="3"><?php echo $topText ?></td>
            </tr>

            <tr>
                <td>Введите логин</td>
                <td colspan="2">
                    <form action='' method='POST'>
                        <textarea cols=20 rows=1 name='login'><?php echo $_POST['login'] ?></textarea>
                </td>
            </tr>
            <tr>
                <td>Введите пароль</td>
                <td colspan="2">
                    <textarea cols=20 rows=1 name='password'><?php echo $_POST['password'] ?></textarea>
                </td>
            </tr>

            <tr>
                <td>Введите Имя</td>
                <td colspan="2">
                    <textarea cols=20 rows=1 name='name'><?php echo $_POST['name'] ?></textarea>
                </td>
            </tr>

            <tr>
                <td>
                    <button type='submit' class='btn' name='registr'>Зарегистрироваться</button>
                    </form>
                </td>
                <!-- <td>
                <form action="index.php">
                    <button type='submit' class='btn'>Отмена</button>    
                </form>
            </td> -->

                <form action='' method='POST'>
                    <td colspan="2">
                        <button type='submit' class='btn' name='toAutoriz'>В окно Авторизации</button>
                    </td>
                </form>
            </tr>
        </table>
        <!-- Таблица Авторизации -->
        <table class="reg" style="display: <?php echo $displayAUTO ?>">
            <tr>
                <td colspan="3"><?php echo $topText ?></td>
            </tr>

            <tr>
                <td>Введите логин</td>
                <td colspan="2">
                    <form action='' method='POST'>
                        <textarea cols=20 rows=1 name='login'><?php echo $_POST['login'] ?></textarea>
                </td>
            </tr>
            <tr>
                <td>Введите пароль</td>
                <td colspan="2">
                    <textarea cols=20 rows=1 name='password'><?php echo $_POST['password'] ?></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <button type='submit' class='btn' name='autorization'>Авторизация</button>
                    </form>
                </td>
                <!-- <td>
                <form action="index.php">
                    <button type='submit' class='btn'>Отмена</button>    
                </form>
            </td> -->

                <form action='' method='POST'>
                    <td colspan="2">
                        <button type='submit' class='btn' name='toReg'>В окно Регистрации</button>
                    </td>
                </form>
            </tr>
        </table>
    <?php } ?>

</th>