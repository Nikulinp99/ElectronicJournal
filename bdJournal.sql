-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 26 2023 г., 18:38
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `bdJournal`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Авторизация`
--

CREATE TABLE `Авторизация` (
  `Ид` int UNSIGNED NOT NULL,
  `Логин` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Пароль` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Тип` int UNSIGNED DEFAULT NULL,
  `ФИО` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Авторизация`
--

INSERT INTO `Авторизация` (`Ид`, `Логин`, `Пароль`, `Тип`, `ФИО`) VALUES
(12, 'admin', 'admin', 1, 'Петров Иван Иванович'),
(13, 'nikulin', 'nikulin11', 2, 'Никулин Петр Михайлович'),
(42, 'vasa', 'vasa', 3, 'Васильев Василий Васильевич'),
(43, 'kate', 'kate123', 2, 'Меньшикова Екатерина Ивановна');

-- --------------------------------------------------------

--
-- Структура таблицы `ВидCпорта`
--

CREATE TABLE `ВидCпорта` (
  `Ид` int UNSIGNED NOT NULL,
  `Название` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `ВидCпорта`
--

INSERT INTO `ВидCпорта` (`Ид`, `Название`) VALUES
(1, 'Бокс'),
(3, 'Бег'),
(4, 'Плаванье'),
(10, 'Плаванье'),
(11, 'Плаванье');

-- --------------------------------------------------------

--
-- Структура таблицы `ДанныеCпортсмена`
--

CREATE TABLE `ДанныеCпортсмена` (
  `Ид` int UNSIGNED NOT NULL,
  `ФИО` varchar(50) NOT NULL,
  `ВидCпорта` int UNSIGNED NOT NULL,
  `Возраст` int NOT NULL,
  `Тренер` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `ДанныеCпортсмена`
--

INSERT INTO `ДанныеCпортсмена` (`Ид`, `ФИО`, `ВидCпорта`, `Возраст`, `Тренер`) VALUES
(1, 'Ашметов Олег Анатольевич', 1, 20, 2),
(2, 'Петров Петр Петрович', 1, 15, 2),
(3, 'Сидоров Антон Антонович ', 1, 16, 2),
(9, 'Васильев Василий Васильевич', 3, 18, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `Журнал`
--

CREATE TABLE `Журнал` (
  `Ид` int UNSIGNED NOT NULL,
  `Оценки` int NOT NULL,
  `Спортсмен` int UNSIGNED NOT NULL,
  `ВидCпорта` int UNSIGNED NOT NULL,
  `Тренер` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Журнал`
--

INSERT INTO `Журнал` (`Ид`, `Оценки`, `Спортсмен`, `ВидCпорта`, `Тренер`) VALUES
(5, 4, 1, 3, 4),
(11, 4, 2, 1, 3),
(12, 4, 3, 1, 2),
(13, 5, 9, 3, 4),
(14, 5, 2, 1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `Тип`
--

CREATE TABLE `Тип` (
  `Ид` int UNSIGNED NOT NULL,
  `Название` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Тип`
--

INSERT INTO `Тип` (`Ид`, `Название`) VALUES
(1, 'Администратор'),
(2, 'Тренер'),
(3, 'Спортсмен');

-- --------------------------------------------------------

--
-- Структура таблицы `Тренер`
--

CREATE TABLE `Тренер` (
  `Ид` int UNSIGNED NOT NULL,
  `ФИО` varchar(50) NOT NULL,
  `ВидCпорта` int UNSIGNED DEFAULT NULL,
  `Стаж` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Тренер`
--

INSERT INTO `Тренер` (`Ид`, `ФИО`, `ВидCпорта`, `Стаж`) VALUES
(2, 'Никулин Петр Михайлович', 1, '10 лет '),
(3, 'Иванов Иван Иванович ', 3, '7 лет'),
(4, 'Меньшикова Екатерина Ивановна', 3, '10');

-- --------------------------------------------------------

--
-- Структура таблицы `УспеваемостьСпортсменов`
--

CREATE TABLE `УспеваемостьСпортсменов` (
  `Ид` int UNSIGNED NOT NULL,
  `Ид_Спортсмена` int UNSIGNED NOT NULL,
  `ВидСпорта` int UNSIGNED NOT NULL,
  `СреднийБал` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `УспеваемостьСпортсменов`
--

INSERT INTO `УспеваемостьСпортсменов` (`Ид`, `Ид_Спортсмена`, `ВидСпорта`, `СреднийБал`) VALUES
(1, 1, 1, 4);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Авторизация`
--
ALTER TABLE `Авторизация`
  ADD PRIMARY KEY (`Ид`),
  ADD KEY `Тип` (`Тип`);

--
-- Индексы таблицы `ВидCпорта`
--
ALTER TABLE `ВидCпорта`
  ADD PRIMARY KEY (`Ид`);

--
-- Индексы таблицы `ДанныеCпортсмена`
--
ALTER TABLE `ДанныеCпортсмена`
  ADD PRIMARY KEY (`Ид`),
  ADD KEY `Вид спорта` (`ВидCпорта`),
  ADD KEY `Тренер` (`Тренер`);

--
-- Индексы таблицы `Журнал`
--
ALTER TABLE `Журнал`
  ADD PRIMARY KEY (`Ид`),
  ADD KEY `Спортсмен` (`Спортсмен`),
  ADD KEY `ВидCпорта` (`ВидCпорта`),
  ADD KEY `Тренер` (`Тренер`);

--
-- Индексы таблицы `Тип`
--
ALTER TABLE `Тип`
  ADD PRIMARY KEY (`Ид`);

--
-- Индексы таблицы `Тренер`
--
ALTER TABLE `Тренер`
  ADD PRIMARY KEY (`Ид`),
  ADD KEY `Вид спорта` (`ВидCпорта`);

--
-- Индексы таблицы `УспеваемостьСпортсменов`
--
ALTER TABLE `УспеваемостьСпортсменов`
  ADD PRIMARY KEY (`Ид`),
  ADD KEY `ВидСпорта` (`ВидСпорта`),
  ADD KEY `Ид_Спортсмена` (`Ид_Спортсмена`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Авторизация`
--
ALTER TABLE `Авторизация`
  MODIFY `Ид` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT для таблицы `ВидCпорта`
--
ALTER TABLE `ВидCпорта`
  MODIFY `Ид` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `ДанныеCпортсмена`
--
ALTER TABLE `ДанныеCпортсмена`
  MODIFY `Ид` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `Журнал`
--
ALTER TABLE `Журнал`
  MODIFY `Ид` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `Тип`
--
ALTER TABLE `Тип`
  MODIFY `Ид` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `Тренер`
--
ALTER TABLE `Тренер`
  MODIFY `Ид` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `УспеваемостьСпортсменов`
--
ALTER TABLE `УспеваемостьСпортсменов`
  MODIFY `Ид` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `Авторизация`
--
ALTER TABLE `Авторизация`
  ADD CONSTRAINT `авторизация_ibfk_1` FOREIGN KEY (`Тип`) REFERENCES `Тип` (`Ид`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `ДанныеCпортсмена`
--
ALTER TABLE `ДанныеCпортсмена`
  ADD CONSTRAINT `данныеcпортсмена_ibfk_1` FOREIGN KEY (`ВидCпорта`) REFERENCES `ВидCпорта` (`Ид`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `данныеcпортсмена_ibfk_2` FOREIGN KEY (`Тренер`) REFERENCES `Тренер` (`Ид`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `Журнал`
--
ALTER TABLE `Журнал`
  ADD CONSTRAINT `журнал_ibfk_1` FOREIGN KEY (`Спортсмен`) REFERENCES `ДанныеCпортсмена` (`Ид`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `журнал_ibfk_2` FOREIGN KEY (`ВидCпорта`) REFERENCES `ВидCпорта` (`Ид`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `журнал_ibfk_3` FOREIGN KEY (`Тренер`) REFERENCES `Тренер` (`Ид`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `Тренер`
--
ALTER TABLE `Тренер`
  ADD CONSTRAINT `тренер_ibfk_1` FOREIGN KEY (`ВидCпорта`) REFERENCES `ВидCпорта` (`Ид`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `УспеваемостьСпортсменов`
--
ALTER TABLE `УспеваемостьСпортсменов`
  ADD CONSTRAINT `успеваемостьспортсменов_ibfk_1` FOREIGN KEY (`ВидСпорта`) REFERENCES `ВидCпорта` (`Ид`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `успеваемостьспортсменов_ibfk_2` FOREIGN KEY (`Ид_Спортсмена`) REFERENCES `ДанныеCпортсмена` (`Ид`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
