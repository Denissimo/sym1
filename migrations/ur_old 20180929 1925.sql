--
-- Скрипт сгенерирован Devart dbForge Studio for MySQL, Версия 8.0.80.0
-- Домашняя страница продукта: http://www.devart.com/ru/dbforge/mysql/studio
-- Дата скрипта: 29.09.2018 19:25:39
-- Версия сервера: 5.5.56-MariaDB
-- Версия клиента: 4.1
--

-- 
-- Отключение внешних ключей
-- 
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

-- 
-- Установить режим SQL (SQL mode)
-- 
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 
-- Установка кодировки, с использованием которой клиент будет посылать запросы на сервер
--
SET NAMES 'utf8';

--
-- Установка базы данных по умолчанию
--
USE kz;

--
-- Удалить таблицу `users_roles`
--
DROP TABLE IF EXISTS users_roles;

--
-- Установка базы данных по умолчанию
--
USE kz;

--
-- Создать таблицу `users_roles`
--
CREATE TABLE users_roles (
  user_id int(11) NOT NULL,
  role_id int(11) NOT NULL,
  PRIMARY KEY (user_id, role_id)
)
ENGINE = INNODB,
AVG_ROW_LENGTH = 390,
CHARACTER SET utf8,
COLLATE utf8_unicode_ci;

--
-- Создать индекс `IDX_51498A8EA76ED395` для объекта типа таблица `users_roles`
--
ALTER TABLE users_roles
ADD INDEX IDX_51498A8EA76ED395 (user_id);

--
-- Создать индекс `IDX_51498A8ED60322AC` для объекта типа таблица `users_roles`
--
ALTER TABLE users_roles
ADD INDEX IDX_51498A8ED60322AC (role_id);

--
-- Создать внешний ключ
--
ALTER TABLE users_roles
ADD CONSTRAINT FK_51498A8EA76ED395 FOREIGN KEY (user_id)
REFERENCES users (id);

--
-- Создать внешний ключ
--
ALTER TABLE users_roles
ADD CONSTRAINT FK_51498A8ED60322AC FOREIGN KEY (role_id)
REFERENCES roles (id);

-- 
-- Вывод данных для таблицы users_roles
--
INSERT INTO users_roles VALUES
(1, 1),
(1, 3),
(2, 1),
(3, 1),
(3, 3),
(4, 1),
(4, 3),
(5, 2),
(5, 3),
(6, 2),
(7, 2),
(7, 3),
(8, 4),
(9, 2),
(9, 3),
(10, 2),
(10, 3),
(11, 2),
(12, 2),
(13, 2),
(13, 3),
(14, 2),
(14, 3),
(23, 1),
(24, 2),
(25, 2),
(25, 3),
(26, 2),
(27, 2),
(27, 3),
(28, 4),
(29, 2),
(30, 3),
(30, 4),
(31, 2),
(31, 3),
(32, 2),
(32, 3),
(33, 1),
(33, 2),
(33, 3),
(33, 4);

-- 
-- Восстановить предыдущий режим SQL (SQL mode)
-- 
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

-- 
-- Включение внешних ключей
-- 
/*!40014 SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS */;