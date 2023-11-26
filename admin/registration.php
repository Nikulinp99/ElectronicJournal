<?php
// подключение файл db.php
require_once "../db.php";
// проверка что name не пустое
if (!empty($_POST['fio'])) {
    // проверка уникальности логина
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM Авторизация WHERE Логин = ?");
    $stmt->execute([$_POST['log']]);
    $count = $stmt->fetchColumn();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($count > 0) {
            // сохраняем значения полей в сессии
            session_start();
            $_SESSION['fio'] = $_POST['fio'];
            $_SESSION['log'] = $_POST['log'];
            $_SESSION['pass'] = $_POST['pass'];

            echo ' <script>alert("Такой логин уже существует");</script>';

        } else {
            $i = $_POST['type'];
            // echo $_POST['log'];
            // echo $type;
            // echo $_POST['pass'];
            // echo $_POST['fio'];
            if ($i == 1) {

                // запрос на запись в базу и выполнение его
                $stmt = $pdo->prepare("insert into Авторизация (Логин, Пароль, Тип, ФИО) values(?,?,?,?)");
                $stmt->execute([
                    $_POST['log'],
                    $_POST['pass'],
                    $_POST['type'],
                    $_POST['fio']
                ]);
                // перенаправление на главную страницу
            } else if ($i == 2) {
                echo $_POST['fio'];
                echo $_POST['sta'];
                echo $_POST['sport'];

                $stmt = $pdo->prepare("insert into Авторизация (Логин, Пароль, Тип, ФИО) values(?,?,?,?)");
                $stmt->execute([
                    $_POST['log'],
                    $_POST['pass'],
                    $_POST['type'],
                    $_POST['fio']
                ]);
                // запрос на запись в базу и выполнение его
                $stmt = $pdo->prepare("INSERT INTO Тренер (ФИО, ВидCпорта, Стаж) VALUES (?, ?, ?)");
                $stmt->execute([
                    $_POST['fio'],
                    $_POST['sport'],
                    $_POST['sta']
                ]);
            } else if ($i == 3) {

                echo $_POST['fio'];
                echo $_POST['sport1'];
                echo $_POST['year'];
                echo $_POST['trainer'];
                // Проверка существования выбранного вида спорта
                $selectedSportId = $_POST['sport1'];
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM ВидCпорта WHERE Ид = ?");
                $stmt->execute([$selectedSportId]);
                $count = $stmt->fetchColumn();

                if ($count > 0) {
                    $stmt = $pdo->prepare("insert into Авторизация (Логин, Пароль, Тип, ФИО) values(?,?,?,?)");
                    $stmt->execute([
                        $_POST['log'],
                        $_POST['pass'],
                        $_POST['type'],
                        $_POST['fio']
                    ]);
                    // Выбранный вид спорта существует в таблице "ВидCпорта", выполняем оператор INSERT
                    $stmt2 = $pdo->prepare("INSERT INTO ДанныеCпортсмена (ФИО, ВидCпорта, Возраст, Тренер) VALUES (?,?,?,?)");
                    $stmt2->execute([
                        $_POST['fio'],
                        $selectedSportId,
                        $_POST['year'],
                        $_POST['trainer']
                    ]);

                    // Ваши дополнительные действия после успешной вставки
                } else {
                    // Выбранный вид спорта не существует в таблице "ВидCпорта"
                    // Обработка ошибки или другие действия
                }
            }
            // перенаправление на главную страницу
            // header("Location:index.php");
        }
    }

}

// Запрос на выборку данных из таблицы ВидCпорта
$stmt = $pdo->query("SELECT * FROM ВидCпорта");
$sports = $stmt->fetchAll();

// Запрос на выборку данных из таблицы Тренер
$stmt = $pdo->query("SELECT * FROM Тренер");
$trainers = $stmt->fetchAll();

$stmt = $pdo->query("SELECT * FROM Тип");
$types = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/MyStyle.css">
    <title>Регистрация</title>

</head>

<body>
    <form method="POST" action="">
        <div class="reg-window" actionp>
            <h1>Добавить нового пользователя</h1>
            <div class="reg-input">
                <label class="fio" for="">ФИО:</label>
                <input required name="fio" type="text" class="fio" placeholder="Введите ФИО">
                <label class="log" for="">Логин:</label>
                <input required name="log" type="text" class="log" placeholder="Введите логин">
                <label class="pass" for="">Пароль:</label>
                <input id="pass" required name="pass" type="text" class="pass" placeholder="Введите пароль">


                <select name="type" onchange="toggleTrainerDiv()">
                    <?php foreach ($types as $type): ?>
                        <option value="<?= $type['Ид'] ?>"><?= $type['Название'] ?></option>
                    <?php endforeach; ?>
                </select>

                <!-- <select name="type" onchange="toggleTrainerDiv()">
                    <?php
                    // Запрос на выборку данных из таблицы "Тип"
                    $stmt = $pdo->query("SELECT * FROM Тип");
                    $types = $stmt->fetchAll();

                    // Вывод опций комбо-бокса
                    foreach ($types as $type) {
                        $selected = ($type['Ид'] == $types1['type']) ? "selected" : "";
                        echo "<option value=\"" . $type['Ид'] . "\" $selected>" . $type['Название'] . "</option>";
                    }
                    ?>
                </select> -->

                <div class="trainer" style="display: none;">
                    <label class="sta" for="">Стаж:</label>
                    <input id="pass" name="sta" type="text">

                    <label for="sport">Вид спорта:</label>
                    <select name="sport" id="sport">
                        <?php foreach ($sports as $sport): ?>
                            <option value="<?= $sport['Ид'] ?>"><?= $sport['Название'] ?></option>
                        <?php endforeach; ?>
                    </select>

                </div>
                <div class="sportsman" style="display: none;">
                    <label class="sta" for="">Тренер:</label>
                    <select name="trainer">
                        <?php foreach ($trainers as $trainer): ?>
                            <option value="<?= $trainer['Ид'] ?>"><?= $trainer['ФИО'] ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label for="spor1">Вид спорта:</label>
                    <select name="sport1" id="sport1">
                        <?php foreach ($sports as $sport): ?>
                            <option value="<?= $sport['Ид'] ?>"><?= $sport['Название'] ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label class="year" for="">Возраст:</label>
                    <input id="pass" name="year" type="text">
                </div>
                <input type="submit" class="btn-reg" value="Зарегистрировать">
                <button onclick="document.location='index.php'" class="btn-back">Назад</button>
            </div>
        </div>
    </form>

    <script>
        function toggleTrainerDiv() {
            var trainerDiv = document.querySelector('.trainer');
            var sportsmanDiv = document.querySelector('.sportsman');
            var typeSelect = document.querySelector('select[name="type"]');
            if (typeSelect.value === '2') {
                trainerDiv.style.display = 'block';
                sportsmanDiv.style.display = 'none';
            } else if (typeSelect.value === '3') {
                sportsmanDiv.style.display = 'block';
                trainerDiv.style.display = 'none';
            } else {
                sportsmanDiv.style.display = 'none';
                trainerDiv.style.display = 'none';
            }
        }
    </script>
</body>

</html>