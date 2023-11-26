<?php
require_once "../db.php";

// Получение идентификатора спортсмена из параметра запроса
$id = $_GET['id'];

// Запрос на выборку данных спортсмена по идентификатору
$stmt = $pdo->prepare("SELECT t1.Ид, t1.ФИО AS fio_sp, t2.Название AS sport, t1.Стаж
FROM Тренер t1 
JOIN ВидCпорта t2 ON t1.ВидCпорта = t2.Ид
WHERE t1.Ид = ?");
$stmt->execute([$id]);
$sporstman = $stmt->fetch();

// Проверка, если форма отправлена
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение новых значений полей из формы
    $newFio = $_POST['fio'];
    $newSport = $_POST['sport'];
    $newAge = $_POST['age'];

    // Запрос на обновление данных спортсмена в базе данных
    $stmt = $pdo->prepare("UPDATE Тренер
        SET ФИО = ?, ВидCпорта = ?, Стаж = ?
        WHERE Ид = ?");
    $stmt->execute([$newFio, $newSport, $newAge, $id]);

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
    <h1>Редактирование Тренера</h1>
    <form action="" method="POST">
        <div class="category">
            <h2>Данные Тренера</h2>
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
                            <input type="text" name="age" value="<?= htmlspecialchars($sporstman['Стаж']) ?>">
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