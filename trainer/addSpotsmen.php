<?php
require_once "../db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Обработка данных формы при отправке
    $fio = $_POST['fio'];
    $sport = $_POST['sport'];
    $age = $_POST['age'];
    $trainer = $_POST['trainer'];

    // Вставка новой записи в таблицу ДанныеCпортсмена
    $stmt = $pdo->prepare("INSERT INTO ДанныеCпортсмена (ФИО, ВидCпорта, Возраст, Тренер) VALUES (?, ?, ?, ?)");
    $stmt->execute([$fio, $sport, $age, $trainer]);

    // Перенаправление на страницу со списком спортсменов после добавления
    header("Location: trainer/index.php");
    exit();
}

// Запрос на выборку данных из таблицы Тренер
$stmt = $pdo->query("SELECT * FROM Тренер");
$trainers = $stmt->fetchAll();

// Запрос на выборку данных из таблицы ВидCпорта
$stmt = $pdo->query("SELECT * FROM ВидCпорта");
$sports = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Добавить спортсмена</h1>
    <form action="" method="POST">
        <div class="form-group">
            <label for="fio">Фамилия имя отчество:</label>
            <input type="text" name="fio" id="fio" required>
        </div>
        <div class="form-group">
            <label for="sport">Вид спорта:</label>
            <select name="sport" id="sport" required>
                <?php foreach ($sports as $sport): ?>
                    <option value="<?= $sport['Ид'] ?>"><?= $sport['Название'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="age">Возраст:</label>
            <input type="text" name="age" id="age" required>
        </div>
        <div class="form-group">
            <label for="trainer">Тренер:</label>
            <select name="trainer" id="trainer" required>
                <?php foreach ($trainers as $trainer): ?>
                    <option value="<?= $trainer['Ид'] ?>"><?= $trainer['ФИО'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit">Добавить</button>
    </form>

</body>

</html>