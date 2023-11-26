<?php
require_once "../db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Обработка данных формы при отправке
    $age = $_POST['age'];
    // Вставка новой записи в таблицу ДанныеCпортсмена
    $stmt = $pdo->prepare("INSERT INTO `ВидCпорта` (Название) VALUES (?)");
    $stmt->execute([$age]);
}


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
    <style>
    body {
        background-color: #ffffff;
        color: #8c7ae6;
        margin: 20px; /* отступ со всех сторон */
        padding: 10px; /* внутренний отступ со всех сторон */
    }
    
    h1 {
        color: #8c7ae6;
        margin-bottom: 20px; /* отступ снизу */
    }
    
    .form-group label {
        color: #8c7ae6;
        margin-bottom: 10px; /* отступ снизу */
    }
    
    select,
    input[type="text"] {
        background-color: #ffffff;
        border: 1px solid #8c7ae6;
        color: #8c7ae6;
        padding: 5px;
        margin-bottom: 10px; /* отступ снизу */
    }
    
    input[type="submit"] {
        background-color: #8c7ae6;
        border: none;
        color: #ffffff;
        padding: 10px 20px;
        cursor: pointer;
        margin-top: 10px; /* отступ сверху */
    }
</style>

</head>

<body>
    <h1>Добавить вид спорта</h1>
    <form action="" method="POST">
        <div class="form-group">
            <label for="sport">Вид спорта:</label>
            <select name="sport" id="sport" required>
                <?php foreach ($sports as $sport): ?>
                    <option value="<?= $sport['Ид'] ?>"><?= $sport['Название'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="age">Оценка:</label>
            <input type="text" name="age" id="age" required>
        </div>
        <input type="submit" value="Сохранить">
    </form>

</body>

</html>