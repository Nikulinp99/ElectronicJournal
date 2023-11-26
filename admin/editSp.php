<?php
require_once "../db.php";

// Получение идентификатора спортсмена из параметра запроса
$id = $_GET['id'];

// Запрос на выборку данных спортсмена по идентификатору
$stmt = $pdo->prepare("SELECT t1.Ид, t1.Оценки AS fio_sp, t4.ФИО AS sport, t2.Название, t3.ФИО AS fio_tr 
FROM Журнал t1 
JOIN ВидCпорта t2 ON t1.ВидCпорта = t2.Ид
JOIN Тренер t3 ON t1.Тренер = t3.Ид
JOIN `ДанныеCпортсмена` t4 ON t1.Спортсмен = t4.Ид");
$stmt->execute([$id]);
$sporstman = $stmt->fetch();

// Проверка, если форма отправлена
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение новых значений полей из формы
    $newFio = $_POST['fio'];
    $newSport = $_POST['sport1'];
    $newAge = $_POST['trainer'];
    $newAge2 = $_POST['fio1'];

    // Запрос на обновление данных спортсмена в базе данных
    $stmt = $pdo->prepare("UPDATE Журнал
        SET Оценки = ?, ВидCпорта = ?, Спортсмен = ?, Тренер = ?
        WHERE Ид = ?");
    $stmt->execute([$newAge2, $newSport, $newFio, $newAge, $id]);

    // Перенаправление на предыдущую страницу
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

// Запрос на выборку данных из таблицы Тренер
$stmt = $pdo->query("SELECT * FROM Тренер");
$trainers = $stmt->fetchAll();
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
    <h1>Редактирование успеваемости</h1>
    <form action="" method="POST">
        <div class="category">
            <h2>Данные успеваемости</h2>
            <table>
                <thead>
                    <!-- ... -->
                </thead>
                <tbody>
                    <tr>

                        <td>
                            <input type="text" name="fio" value="<?= htmlspecialchars($sporstman['sport']) ?>">
                        </td>
                        <td>
                            <div class="form-group">
                                <label for="trainer">Тренер:</label>
                                <select name="trainer" id="trainer" required>
                                    <?php foreach ($trainers as $trainer): ?>
                                        <option value="<?= $trainer['Ид'] ?>"><?= $trainer['ФИО'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </td>
                        <td>
                            <input type="text" name="fio1" value="<?= htmlspecialchars($sporstman['fio_sp']) ?>">
                        </td>
                        <!-- Код для комбо-бокса ВидCпорта -->
                        <td>
                            <select name="sport1">
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

                        <!-- Код для комбо-бокса Тренер -->

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