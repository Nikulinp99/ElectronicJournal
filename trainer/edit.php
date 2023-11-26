<?php
require_once "../db.php";

// Получение идентификатора спортсмена из параметра запроса
$id = $_GET['id'];

// Запрос на выборку данных спортсмена по идентификатору
$stmt = $pdo->prepare("SELECT t1.Ид, t1.ФИО AS fio_sp, t2.Название AS sport, t1.Возраст, t3.ФИО AS fio_tr 
FROM ДанныеCпортсмена t1 
JOIN ВидCпорта t2 ON t1.ВидCпорта = t2.Ид
JOIN Тренер t3 ON t1.Тренер = t3.Ид
WHERE t1.Ид = ?");
$stmt->execute([$id]);
$sporstman = $stmt->fetch();

// Проверка, если форма отправлена
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение новых значений полей из формы
    $newFio = $_POST['fio'];
    $newSport = $_POST['sport'];
    $newAge = $_POST['age'];
    $newTrainer = $_POST['trainer'];

    // Запрос на обновление данных спортсмена в базе данных
    $stmt = $pdo->prepare("UPDATE ДанныеCпортсмена
        SET ФИО = ?, ВидCпорта = ?, Возраст = ?, Тренер = ?
        WHERE Ид = ?");
    $stmt->execute([$newFio, $newSport, $newAge, $newTrainer, $id]);

    // Перенаправление на предыдущую страницу
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/edit.css">
</head>

<body>
    <h1>Редактирование спортсмена</h1>
    <form action="" method="POST">
        <div class="category">
            <h2>Данные спортсмена</h2>
            <table>
                <thead>
                    <!-- ... -->
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="text" name="fio" value="<?= htmlspecialchars($sporstman['fio_sp']) ?>">
                        </td>
                        <!-- Код для комбо-бокса ВидCпорта -->
                        <td>
                            <select name="sport">
                                <?php
                                // Запрос на выборку данных из таблицы ВидCпорта
                                $stmt = $pdo->query("SELECT * FROM ВидCпорта");
                                $sports = $stmt->fetchAll();

                                // Вывод опций комбо-бокса
                                foreach ($sports as $sport) {
                                    $selected = ($sport['Ид'] == $sporstmanccc['sport']) ? "selected" : "";
                                    echo "<option value=\"" . $sport['Ид'] . "\" $selected>" . $sport['Название'] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="age" value="<?= htmlspecialchars($sporstman['Возраст']) ?>">
                        </td>
                        <!-- Код для комбо-бокса Тренер -->
                        <td>
                            <select name="trainer">
                                <?php
                                // Запрос на выборку данных из таблицы Тренер
                                $stmt = $pdo->query("SELECT * FROM Тренер");
                                $trainers = $stmt->fetchAll();

                                // Вывод опций комбо-бокса
                                foreach ($trainers as $trainer) {
                                    $selected = ($trainer['Ид'] == $sporstman['fio_tr']) ? "selected" : "";
                                    echo "<option value=\"" . $trainer['Ид'] . "\" $selected>" . $trainer['ФИО'] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- ... -->
        <input type="submit" value="Сохранить">
        <input type="submit" value="назад">
    </form>
   
</body>

</html>