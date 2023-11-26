<?php
// подключение файл db.php
require_once "db.php";
$idSt = 2;

// запрос на выборку всех записей из таблицы Works
$stmt = $pdo->prepare("SELECT t1.id, t1.name, t1.description, t1.category, t2.name as category, t1.photo, t1.created_at, t1.photoBefor
FROM applications t1
JOIN category t2 ON t1.category = t2.id
WHERE t1.status = ?");
$stmt->execute([$idSt]);
$works = $stmt->fetchAll();
?>

<!doctype html>
<html lang="en">
<header>
    <title>Электронный журнал</title>
    <link rel="stylesheet" type="text/css" href="css/NewStyle.css">
    <nav>
  <ul>
    <li>
      <a href="#">Главная</a>
    </li>
    <li>
      <a href="#">О нас</a>
    </li>
    <li>
      <a href="#">Контакты</a>
    </li>
    <li style="float: right; right: 55px;">
    <a href="login.php">Авторизоваться</a>
      
      
    </li>
  </ul>
</nav>
</header>
<main>
    <h1>Добро пожаловать!</h1>
    <p>Здесь вы найдете последние новости, результаты и интересные статьи о наших спортсменах!</p>
    <section>
        <h2>Новости</h2>
        <article>
            <h3>Новый рекорд</h3>
            <p>Новый день, новый рекорд! Наша спортивная школа продолжает радовать нас своими достижениями. Недавно наш
                юный талант из команды по легкой атлетике установил новый рекорд в беге на 100 метров, побив предыдущий
                результат на целую секунду! Мы гордимся нашими спортсменами и ждем еще больших побед в будущем.</p>
        </article>
        <article>
            <h3>Травма во время занятия</h3>
            <p>Несмотря на все меры предосторожности, травмы во время занятий спортом иногда неизбежны.
                Важно помнить, что правильная реакция и быстрая помощь могут существенно снизить последствия травмы и
                ускорить процесс
                восстановления. Поэтому, следует всегда быть готовыми к таким ситуациям и иметь базовые знания об
                оказании первой помощи при различных типах травм.</p>
        </article>
    </section>
</main>
<footer>
    <p>Copyright ©
        <script type="text/javascript">document.write(new Date().getFullYear());</script>
        Электронный журнал. Все права защищены.
    </p>
</footer>
</body>