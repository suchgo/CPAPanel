-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Окт 16 2018 г., 19:05
-- Версия сервера: 5.7.21-20-beget-5.7.21-20-1-log
-- Версия PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `vibrax6t_cpa`
--

-- --------------------------------------------------------

--
-- Структура таблицы `offers`
--
-- Создание: Сен 27 2018 г., 17:08
-- Последнее обновление: Сен 27 2018 г., 17:09
--

DROP TABLE IF EXISTS `offers`;
CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `main_show_time` text,
  `main_impression_interval` text,
  `activity_show_time` text,
  `activity_impression_interval` text,
  `traffic_show_time` text,
  `traffic_impression_interval` text,
  `domain` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `offers`
--

INSERT INTO `offers` (`id`, `name`, `main_show_time`, `main_impression_interval`, `activity_show_time`, `activity_impression_interval`, `traffic_show_time`, `traffic_impression_interval`, `domain`) VALUES
(2, 'CasualClub(FR)_orange_fr', '450-600', '400-800', '560-750', '800-2100', '90-120', '50-150', 'orange.fr'),
(3, 'CasualClub(FR)_free_fr', '450-600', '400-800', '560-750', '800-2100', '90-120', '50-150', 'free.fr'),
(5, 'CasualClub(ES)_bol_com_br', '500-600', '400-800', '600-700', '800-2100', '90-120', '50-150', 'bol.com.br');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--
-- Создание: Сен 19 2018 г., 21:24
-- Последнее обновление: Сен 22 2018 г., 00:13
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `ip` text,
  `joining_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `city` text,
  `latitude` text,
  `longitude` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `ip`, `joining_date`, `city`, `latitude`, `longitude`) VALUES
(1, 'Test', '123', NULL, '2018-09-16 18:27:56', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `user_offers`
--
-- Создание: Сен 25 2018 г., 22:29
-- Последнее обновление: Окт 10 2018 г., 17:02
--

DROP TABLE IF EXISTS `user_offers`;
CREATE TABLE `user_offers` (
  `id` int(11) NOT NULL,
  `source_id` text,
  `status` int(11) NOT NULL DEFAULT '0',
  `offer_name` text NOT NULL,
  `ref_offer` varchar(100) NOT NULL,
  `user_db_path` text,
  `user_log_path` text,
  `jetswap_link_main` text,
  `jetswap_link_traffic` text,
  `jetswap_link_activity` text,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Дамп данных таблицы `user_offers`
--

INSERT INTO `user_offers` (`id`, `source_id`, `status`, `offer_name`, `ref_offer`, `user_db_path`, `user_log_path`, `jetswap_link_main`, `jetswap_link_traffic`, `jetswap_link_activity`, `user_id`) VALUES
(290, '2', 1, 'CasualClub(FR)_orange_fr(first)', 'http://google.com', 'http://cpapanel.vibrax6t.beget.tech/users/Test/offers/CasualClub(FR)_orange_fr(first)/mails.txt', 'http://cpapanel.vibrax6t.beget.tech/users/Test/offers/CasualClub(FR)_orange_fr(first)/log_mails.txt', 'var prskey=\"<get(key)>\"; <dls(http://cpapanel.vibrax6t.beget.tech/users/Test/offers/CasualClub(FR)_orange_fr(first)/CasualClub(FR)_orange_fr.txt?nocache=<rndr(1:999999)>)>', 'var prskey=\"<get(key)>\"; <dls(http://cpapanel.vibrax6t.beget.tech/users/Test/offers/CasualClub(FR)_orange_fr(first)/CasualClub(FR)_orange_fr_traffic.txt?nocache=<rndr(1:999999)>)>', 'var prskey=\"<get(key)>\"; <dls(http://cpapanel.vibrax6t.beget.tech/users/Test/offers/CasualClub(FR)_orange_fr(first)/CasualClub(FR)_orange_fr_activity.txt?nocache=<rndr(1:999999)>)>', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_offers`
--
ALTER TABLE `user_offers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `user_offers`
--
ALTER TABLE `user_offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=291;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
