<?php
// подключение файл db.php
require_once "../db.php";

session_start();
$stmt = $pdo->query("SELECT * FROM ДанныеCпортсмена");
$sportsmans = $stmt->fetchAll();

if (isset($_POST['sportsman'])) {
    $sportsman = $_POST['sportsman'];
} else {
    $sportsman = '';
}


// запрос на выборку всех записей из таблицы Works
$stmt = $pdo->prepare("SELECT t1.Ид, t1.ФИО AS fio_sp, t2.Название AS sport, t1.Возраст, t3.ФИО AS fio_tr 
FROM ДанныеCпортсмена t1 
JOIN ВидCпорта t2 ON t1.ВидCпорта = t2.Ид
JOIN Тренер t3 ON t1.Тренер = t3.Ид");
$stmt->execute();
$works = $stmt->fetchAll();

// запрос на выборку всех записей из таблицы Works
$stmt = $pdo->prepare("SELECT t1.Ид, t1.ФИО AS fio_sp, t2.Название AS sport, t1.Стаж
FROM Тренер t1 
JOIN ВидCпорта t2 ON t1.ВидCпорта = t2.Ид");
$stmt->execute();
$works1 = $stmt->fetchAll();

if (isset($_POST['sportsman'])) {
    $sportsman = $_POST['sportsman'];
    // запрос на выборку всех записей из таблицы Works
    $stmt = $pdo->prepare("SELECT t1.Ид, t1.Оценки AS fio_sp, t4.ФИО AS sport, t2.Название, t3.ФИО AS fio_tr 
    FROM Журнал t1 
    JOIN ВидCпорта t2 ON t1.ВидCпорта = t2.Ид
    JOIN Тренер t3 ON t1.Тренер = t3.Ид
    JOIN `ДанныеCпортсмена` t4 ON t1.Спортсмен = t4.Ид
    WHERE t1.Спортсмен = ?");
    $stmt->execute([$sportsman]);
    $works2 = $stmt->fetchAll();
    echo $sportsmans;
} else {
    $stmt = $pdo->prepare("SELECT t1.Ид, t1.Оценки AS fio_sp, t4.ФИО AS sport, t2.Название, t3.ФИО AS fio_tr 
    FROM Журнал t1 
    JOIN ВидCпорта t2 ON t1.ВидCпорта = t2.Ид
    JOIN Тренер t3 ON t1.Тренер = t3.Ид
    JOIN `ДанныеCпортсмена` t4 ON t1.Спортсмен = t4.Ид");
    $stmt->execute();
    $works2 = $stmt->fetchAll();
}

$stmt = $pdo->prepare("Select * from `ВидCпорта`");
$stmt->execute();
$works3 = $stmt->fetchAll();

// Запрос на выборку данных из таблицы УспеваемостьСпротсменов
$stmt = $pdo->prepare("SELECT t1.Ид, t2.ФИО, t3.Название AS ВидСпорта, t1.СреднийБал
FROM УспеваемостьСпортсменов t1
JOIN ДанныеCпортсмена t2 ON t1.Ид_Спортсмена = t2.Ид
JOIN ВидCпорта t3 ON t2.ВидCпорта = t3.Ид");
$stmt->execute();
$achievements = $stmt->fetchAll();


?>
<!DOCTYPE html>
<html>

<head>
    <title>Панель администратора</title>
    <link rel="stylesheet" type="text/css" href="../css/IndexAdmin.css">
</head>

<body>
    <h2><a href="../index.php" class="button">Главная</a></h2>
    <h1>Панель администратора</h1>
    <h1><a href="registration.php">Добавить нового пользователя</a></h1>

    <div class="category">
        <h2>Данные спортсменов </h2>
        <table>
            <thead>
                <tr>
                    <th>ФИО</th>
                    <th>Вид спорта</th>
                    <th>Возраст</th>
                    <th>Тренер</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($works as $message): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($message['fio_sp']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($message['sport']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($message['Возраст']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($message['fio_tr']) ?>
                        </td>
                        <td>
                            <a href="../trainer/edit.php?id=<?= $message['Ид'] ?>">Изменить</a>
                        </td>
                        <td>
                            <a href="delete.php?id=<?= $message['Ид'] ?>">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="category">
        <h2>Тренерский состав </h2>
        <table>
            <thead>
                <tr>

                    <th>Фио</th>
                    <th>Вид спорта</th>
                    <th>Стаж</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($works1 as $message): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($message['fio_sp']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($message['sport']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($message['Стаж']) ?>
                        </td>

                        <td>
                            <a href="../trainer/editUs.php?id=<?= $message['Ид'] ?>">Изменить</a>
                        </td>
                        <td>
                            <a href="delete.php?id=<?= $message['Ид'] ?>">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="category">
        <h2>Успеваемость спортсменов <a href="addUs.php" class="edit-button">Добавить Оценку</a>
            <select name="sportsman" id="sport">
                <?php foreach ($sportsmans as $sportsman): ?>
                    <option value="<?= $sportsman['Ид'] ?>"><?= $sportsman['ФИО'] ?></option>
                <?php endforeach; ?>
            </select>
        </h2>
        <table>
            <thead>
                <tr>
                    <th>ФИО Спортсмена</th>
                    <th>Тренер</th>
                    <th>Оценка</th>
                    <th>Вид спорта</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($works2 as $message): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($message['sport']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($message['fio_tr']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($message['fio_sp']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($message['Название']) ?>
                        </td>
                        <td>
                            <a href="editSp.php?id=<?= $message['Ид'] ?>">Изменить</a>
                        </td>
                        <td>
                            <a href="delete.php?id=<?= $message['Ид'] ?>">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="category">
        <h2>Виды спорта<a href="addSport.php" class="edit-button">Добавить </a></h2>
        <table>
            <thead>
                <tr>
                    <th>Вид спорта</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($works3 as $message): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($message['Название']) ?>
                        </td>

                        <td>
                            <a href="delete.php?id=<?= $message['Ид'] ?>">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>