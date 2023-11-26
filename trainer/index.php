<?php

require_once "../db.php";

session_start();
$login = $_SESSION['log'];

$stmt = $pdo->prepare("SELECT t2.ВидCпорта AS Спорт FROM Авторизация t1
JOIN Тренер t2 ON t1.ФИО = t2.ФИО
WHERE Логин = ?");
$stmt->execute([$login]);
$id_sport = $stmt->fetchColumn();

//запоминает ид в _SESSION['user_id']
$_SESSION['id_user'] = $id_user;

$idSt = 2;  

// запрос на выборку всех записей из таблицы Works
$stmt = $pdo->prepare("SELECT t1.Ид, t1.ФИО AS fio_sp, t2.Название AS sport, t1.Возраст, t3.ФИО AS fio_tr 
FROM ДанныеCпортсмена t1 
JOIN `ВидCпорта` t2 ON t1.ВидCпорта = t2.Ид
JOIN Тренер t3 ON t1.Тренер = t3.Ид
WHERE t1.`ВидCпорта` = ?");
$stmt->execute([$id_sport]);
$works = $stmt->fetchAll();

// запрос на выборку всех записей из таблицы Works
$stmt = $pdo->prepare("SELECT t1.Ид, t1.Оценки AS fio_sp, t4.ФИО AS sport, t2.Название, t3.ФИО AS fio_tr 
FROM Журнал t1 
JOIN `ВидCпорта` t2 ON t1.`ВидCпорта` = t2.Ид
JOIN Тренер t3 ON t1.Тренер = t3.Ид
JOIN `ДанныеCпортсмена` t4 ON t1.Спортсмен = t4.Ид
WHERE t1.`ВидCпорта` = ?");
$stmt->execute([$id_sport]);
$works2 = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Тренер - Управление данными спортсменов</title>
    <link rel="stylesheet" href="../css/userStyle.css" />
</head>

<body>
    <form action="" method="POST">
        <h2><a href="#" class="button">Главная</a></h2>
        <h1>Управление данными спортсменов</h1>
        <div class="category">
            <h2>Данные спортсменов  </h2>
            <table>
                <thead>
                    <tr>
                        <th>Фамилия имя отчество</th>
                        <th>Вид спорта</th>
                        <th>Возраст</th>
                        <th>Тренер</th>
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
                                <a href="edit.php?id=<?= $message['Ид'] ?>">Изменить</a>
                            </td>
                           
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
        <div class="category">
        <h2>Успеваемость спортсменов <a href="../admin/addUs.php" class="edit-button"> Добавить Оценку </a> </h2>
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
                                <a href="edit.php?id=<?= $message['Ид'] ?>">Изменить</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </form>
</body>

</html>