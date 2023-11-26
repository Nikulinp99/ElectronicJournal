<?php
require_once "db.php";

session_start();
//присваиваем перменной ЛОГИН- _SESSION['log'] , переданная с другой станицы
$login = $_SESSION['log2'];

$stmt = $pdo->prepare("SELECT t2.Ид FROM Авторизация t1 
JOIN ДанныеCпортсмена t2 ON t1.ФИО = t2.ФИО
WHERE Логин = ?");
$stmt->execute([$login]);
$id_user = $stmt->fetchColumn();

//запоминает ид в _SESSION['user_id']
$_SESSION['id_user'] = $id_user;

$idSt = 2;

// запрос на выборку всех записей из таблицы Works
$stmt = $pdo->prepare("SELECT t1.Ид, t1.Оценки AS fio_sp, t4.ФИО AS sport, t2.Название, t3.ФИО AS fio_tr 
FROM Журнал t1 
JOIN ВидCпорта t2 ON t1.ВидCпорта = t2.Ид
JOIN Тренер t3 ON t1.Тренер = t3.Ид
JOIN `ДанныеCпортсмена` t4 ON t1.Спортсмен = t4.Ид
WHERE t1.Спортсмен = ?");
$stmt->execute([$id_user]);
$works2 = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Мои оценкки</title>
    <link rel="stylesheet" href="css/userStyle.css" />
  </head>
  <body>
  <h2><a href="index.php" class="button">Главная</a></h2>
      <h1>Мои оценки</h1>
      <div class="category">
        <h2>Мои оценки </h2>
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
                           
                        </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
    </div>
  </body>
</html>