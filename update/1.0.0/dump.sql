-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Мар 29 2019 г., 05:00
-- Версия сервера: 5.7.25-0ubuntu0.16.04.2
-- Версия PHP: 5.6.40-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `pddfend`
--

-- --------------------------------------------------------

--
-- Структура таблицы `prefix_questions_answer`
--

CREATE TABLE `prefix_questions_answer` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `text` text COLLATE utf8_bin,
  `question_id` int(11) NOT NULL,
  `date_update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `prefix_questions_question`
--

CREATE TABLE `prefix_questions_question` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `title` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `url` varchar(200) COLLATE utf8_bin NOT NULL,
  `text` text COLLATE utf8_bin,
  `state` varchar(20) COLLATE utf8_bin DEFAULT 'moderate',
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `prefix_questions_question`
--

INSERT INTO `prefix_questions_question` (`id`, `user_id`, `title`, `url`, `text`, `state`, `date_create`, `date_update`) VALUES
(1, 1, 'gdfgdgdfgdfdfg', 'gdfgdgdfgdfdfg', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', '0', '2019-03-23 22:54:22', '2019-03-29 10:28:27');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `prefix_questions_answer`
--
ALTER TABLE `prefix_questions_answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Индексы таблицы `prefix_questions_question`
--
ALTER TABLE `prefix_questions_question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `prefix_questions_answer`
--
ALTER TABLE `prefix_questions_answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `prefix_questions_answer` ADD `state` VARCHAR(20) NOT NULL AFTER `question_id`, ADD INDEX (`state`);
--
-- AUTO_INCREMENT для таблицы `prefix_questions_question`
--
ALTER TABLE `prefix_questions_question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;