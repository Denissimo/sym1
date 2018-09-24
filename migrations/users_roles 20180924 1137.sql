--
-- Скрипт сгенерирован Devart dbForge Studio for MySQL, Версия 8.0.80.0
-- Домашняя страница продукта: http://www.devart.com/ru/dbforge/mysql/studio
-- Дата скрипта: 24.09.2018 11:37:11
-- Версия сервера: 5.6.38-log
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
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL,
  role_id int(11) NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB,
AUTO_INCREMENT = 43,
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
(1, 1, 1),
(2, 1, 3),
(3, 2, 1),
(4, 3, 1),
(5, 3, 3),
(6, 4, 1),
(7, 4, 3),
(8, 5, 2),
(9, 5, 3),
(10, 6, 2),
(11, 7, 2),
(12, 7, 3),
(13, 8, 4),
(14, 9, 2),
(15, 9, 3),
(16, 10, 2),
(17, 10, 3),
(18, 11, 2),
(19, 12, 2),
(20, 13, 2),
(21, 13, 3),
(22, 14, 2),
(23, 14, 3),
(24, 23, 1),
(25, 24, 2),
(26, 25, 2),
(27, 25, 3),
(28, 26, 2),
(29, 27, 2),
(30, 27, 3),
(31, 28, 4),
(32, 29, 2),
(33, 30, 3),
(34, 30, 4),
(35, 31, 2),
(36, 31, 3),
(37, 32, 2),
(38, 32, 3),
(39, 33, 1),
(40, 33, 2),
(41, 33, 3),
(42, 33, 4);

-- 
-- Восстановить предыдущий режим SQL (SQL mode)
-- 
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

-- 
-- Включение внешних ключей
-- 
/*!40014 SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS */;