<?php
require_once "db.php";

$login = $_POST['log'] ?? '';
$pas = $_POST['pass'] ?? '';

session_start();

// Сохраняем логин в сессии
$_SESSION['log'] = $login;

// Инициализируем переменную ошибки
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Проверяем, была ли отправлена форма
    $query = $pdo->prepare("SELECT * FROM Авторизация WHERE Логин=? AND Пароль=?");
    $query->execute([$login, $pas]);
    $user = $query->fetch();

    if ($user) {
        // Получаем тип пользователя
        $query2 = $pdo->prepare("SELECT Тип FROM Авторизация WHERE Логин = ?");
        $query2->execute([$login]);
        $user2 = $query2->fetch();

        if ($user2['Тип'] == 3) {
            // Перенаправляем на страницу пользователя, если тип пользователя равен 3
            $_SESSION['log2'] = $login;
            header("Location: user.php");
        } elseif ($user2['Тип'] == 2) {
            // Перенаправляем на страницу тренера, если тип пользователя равен 2
            $_SESSION['log'] = $login;
            header("Location: trainer/index.php");
        } elseif ($user2['Тип'] == 1) {
            // Перенаправляем на страницу администратора, если тип пользователя равен 1
            $_SESSION['log'] = $login;
            header("Location: admin/index.php");
        }
    } else {
        // Если пользователь не найден, устанавливаем сообщение об ошибке
        $error = 'Неверный логин или пароль';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/MyStyle1.css">
    <title>Авторизация</title>
</head>

<body>
    <form action="" method="POST">
        <div class="reg-window">
            <h1>Авторизация</h1>
            <div class="reg-input">
                <label class="log" for=""> Логин: </label>
                <input type="text" name="log" class="log" placeholder="Введите логин">
                <label class="pass" for=""> Пароль: </label>
                <input type="password" id="pass" name="pass" class="pass" placeholder="Введите пароль">
                <?php
            // Вывод сообщения об ошибке, если оно установлено
            if (!empty($error)) {
                echo '<p style="color: red;">' . $error . '</p>';
            }
            ?>
                <input type="submit" class="btn-reg" value="Войти">
                <a class="btn-back" href="index.php">Назад</a>
            </div>
            <div class="checkbox">
                <input onclick="showPassword()" type="checkbox">
                <label for="">Показать пароль</label>
            </div>
          
        </div>
    </form>
    <script>
        function showPassword() {
            var passwordField = document.getElementById("pass");
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>
</body>

</html>
