-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Мар 23 2019 г., 16:58
-- Версия сервера: 5.7.24-0ubuntu0.16.04.1
-- Версия PHP: 5.6.38-3+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `pdd`
--

-- --------------------------------------------------------

--
-- Структура таблицы `prefix_question`
--

CREATE TABLE `prefix_question` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `url` varchar(200) COLLATE utf8_bin NOT NULL,
  `text` text COLLATE utf8_bin,
  `state` varchar(20) COLLATE utf8_bin DEFAULT 'moderate',
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `prefix_question`
--

INSERT INTO `prefix_question` (`id`, `user_id`, `url`, `text`, `state`, `date_create`, `date_update`) VALUES
(1, 0, '', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', '0', '2019-03-23 22:54:22', '2019-03-23 22:54:22');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `prefix_question`
--
ALTER TABLE `prefix_question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `prefix_question`
--
ALTER TABLE `prefix_question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Мар 28 2019 г., 08:04
-- Версия сервера: 5.7.24-0ubuntu0.16.04.1
-- Версия PHP: 5.6.38-3+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `pdd`
--

-- --------------------------------------------------------

--
-- Структура таблицы `prefix_answer`
--

CREATE TABLE `prefix_answer` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `text` text COLLATE utf8_bin,
  `question_id` int(11) NOT NULL,
  `date_update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `prefix_answer`
--
ALTER TABLE `prefix_answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `question_id` (`question_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `prefix_answer`
--
ALTER TABLE `prefix_answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
