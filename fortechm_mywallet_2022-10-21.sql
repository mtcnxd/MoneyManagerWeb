# ************************************************************
# Sequel Ace SQL dump
# Versión 20035
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Equipo: 65.99.205.80 (MySQL 5.7.39-log-cll-lve)
# Base de datos: fortechm_mywallet
# Tiempo de generación: 2022-10-21 10:28:51 p.m. +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Volcado de tabla wallet_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wallet_category`;

CREATE TABLE `wallet_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `category` varchar(30) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `icon` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `wallet_category` WRITE;
/*!40000 ALTER TABLE `wallet_category` DISABLE KEYS */;

INSERT INTO `wallet_category` (`id`, `name`, `type`, `category`, `color`, `icon`)
VALUES
	(1,'Nomina','Ingreso','Nomina','#000000','none.png'),
	(2,'Yotepresto','Inversion','Inversion','#003355','none.png'),
	(3,'Gasolina','Egreso','Gasolina','#550000','none.png'),
	(4,'GBM','Inversion','Inversion','#563d7c','none.png'),
	(5,'Carpinteria','Ingreso','Otros','#563d7c','none.png'),
	(6,'Doopla','Inversion','Inversion','#be38f3','none.png'),
	(7,'Izzi','Egreso','Gastos Fijos','#3a87fe','none.png'),
	(8,'Bitso','Inversion','Inversion','#76bb40','none.png'),
	(9,'Kubo','Inversion','Inversion','#4e7a27','none.png'),
	(10,'Stori Card','Egreso','Tarjetas de Credito','#ff3a2f','none.png'),
	(11,'Intereses','Ingreso','Intereses','#01c7fc','none.png'),
	(20,'Entretenimiento','Egreso',NULL,'#563d7c',NULL),
	(12,'Gastos de Hogar','Egreso','Gastos de Hogar','#e392fe','none.png'),
	(13,'Nu Card','Egreso','Tarjetas de Credito','#ff3a2f','none.png'),
	(14,'Rentas','Inversion','Inversion','#563d7c','none.png'),
	(15,'Mercado Libre','Egreso','Tiendas en Linea','#563d7c','none.png'),
	(16,'AT&T','Egreso','Gastos Fijos','#563d7c','none.png'),
	(17,'Almuerzo','Egreso','Alimentos','#563d7c','none.png'),
	(18,'Otro','Ingreso','Otros','#563d7c','none.png'),
	(19,'Electronica','Egreso','Electronica','#563d7c','none.png');

/*!40000 ALTER TABLE `wallet_category` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla wallet_cron_balances
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wallet_cron_balances`;

CREATE TABLE `wallet_cron_balances` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `concept` varchar(30) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `wallet_cron_balances` WRITE;
/*!40000 ALTER TABLE `wallet_cron_balances` DISABLE KEYS */;

INSERT INTO `wallet_cron_balances` (`id`, `concept`, `amount`, `date`)
VALUES
	(1,'Bitso',19692,'2022-09-15'),
	(2,'Doopla',8920,'2022-09-15'),
	(3,'GBM',35971,'2022-09-15'),
	(4,'Kubo',35440,'2022-09-15'),
	(5,'Yotepresto',16190.2,'2022-09-15'),
	(6,'Doopla',8933,'2022-09-16'),
	(7,'GBM',35979,'2022-09-16'),
	(8,'Kubo',35491.9,'2022-09-16'),
	(9,'Yotepresto',16197.7,'2022-09-16'),
	(10,'Doopla',8933,'2022-09-17'),
	(11,'GBM',36000,'2022-09-17'),
	(12,'Kubo',35491.9,'2022-09-17'),
	(13,'Yotepresto',16197.7,'2022-09-17'),
	(14,'Doopla',8933,'2022-09-18'),
	(15,'GBM',36000,'2022-09-18'),
	(16,'Kubo',35491.9,'2022-09-18'),
	(17,'Yotepresto',16197.7,'2022-09-18'),
	(18,'Doopla',8933,'2022-09-19'),
	(19,'GBM',36000,'2022-09-19'),
	(20,'Kubo',35491.9,'2022-09-19'),
	(21,'Yotepresto',16197.7,'2022-09-19'),
	(22,'Doopla',8936.23,'2022-09-20'),
	(23,'GBM',36000,'2022-09-20'),
	(24,'Kubo',35526.3,'2022-09-20'),
	(25,'Yotepresto',16201.8,'2022-09-20'),
	(26,'Doopla',8941,'2022-09-21'),
	(27,'GBM',20998,'2022-09-21'),
	(28,'Kubo',35526.3,'2022-09-21'),
	(29,'Rentas',15000,'2022-09-21'),
	(30,'Yotepresto',16230,'2022-09-21'),
	(31,'Doopla',8941,'2022-09-22'),
	(32,'GBM',6208,'2022-09-22'),
	(33,'Kubo',35543,'2022-09-22'),
	(34,'Rentas',30000,'2022-09-22'),
	(35,'Yotepresto',16241,'2022-09-22'),
	(36,'Doopla',8941,'2022-09-23'),
	(37,'GBM',6206,'2022-09-23'),
	(38,'Kubo',35552,'2022-09-23'),
	(39,'Rentas',30000,'2022-09-23'),
	(40,'Yotepresto',16249,'2022-09-23'),
	(41,'Doopla',8941,'2022-09-24'),
	(42,'GBM',6206,'2022-09-24'),
	(43,'Kubo',35552,'2022-09-24'),
	(44,'Rentas',30000,'2022-09-24'),
	(45,'Yotepresto',16261,'2022-09-24'),
	(46,'Doopla',8941,'2022-09-25'),
	(47,'GBM',6206,'2022-09-25'),
	(48,'Kubo',35552,'2022-09-25'),
	(49,'Rentas',30000,'2022-09-25'),
	(50,'Yotepresto',16261,'2022-09-25'),
	(51,'Doopla',8941,'2022-09-26'),
	(52,'GBM',6206,'2022-09-26'),
	(53,'Kubo',35552,'2022-09-26'),
	(54,'Rentas',30000,'2022-09-26'),
	(55,'Yotepresto',16261,'2022-09-26'),
	(56,'Doopla',8943,'2022-09-27'),
	(57,'GBM',6960,'2022-09-27'),
	(58,'Kubo',35586,'2022-09-27'),
	(59,'Rentas',30000,'2022-09-27'),
	(60,'Yotepresto',16264,'2022-09-27'),
	(61,'Doopla',8943,'2022-09-28'),
	(62,'GBM',6960,'2022-09-28'),
	(63,'Kubo',35586,'2022-09-28'),
	(64,'Rentas',31000,'2022-09-28'),
	(65,'Yotepresto',16266,'2022-09-28'),
	(66,'Doopla',8946,'2022-09-29'),
	(67,'GBM',6960,'2022-09-29'),
	(68,'Kubo',35603,'2022-09-29'),
	(69,'Rentas',32000,'2022-09-29'),
	(70,'Yotepresto',16302,'2022-09-29'),
	(71,'Doopla',8958,'2022-09-30'),
	(72,'GBM',6960,'2022-09-30'),
	(73,'Kubo',35612,'2022-09-30'),
	(74,'Rentas',33000,'2022-09-30'),
	(75,'Yotepresto',16335,'2022-09-30'),
	(76,'Doopla',8968,'2022-10-01'),
	(77,'GBM',6933,'2022-10-01'),
	(78,'Kubo',35612,'2022-10-01'),
	(79,'Rentas',35000,'2022-10-01'),
	(80,'Yotepresto',16348,'2022-10-01'),
	(81,'Doopla',8968,'2022-10-02'),
	(82,'GBM',6933,'2022-10-02'),
	(83,'Kubo',35612,'2022-10-02'),
	(84,'Rentas',35000,'2022-10-02'),
	(85,'Yotepresto',16348,'2022-10-02'),
	(86,'Doopla',8968,'2022-10-03'),
	(87,'GBM',6933,'2022-10-03'),
	(88,'Kubo',35612,'2022-10-03'),
	(89,'Rentas',35000,'2022-10-03'),
	(90,'Yotepresto',16348,'2022-10-03'),
	(91,'Doopla',8983,'2022-10-04'),
	(92,'GBM',7621,'2022-10-04'),
	(93,'Kubo',35612,'2022-10-04'),
	(94,'Rentas',36000,'2022-10-04'),
	(95,'Yotepresto',16358,'2022-10-04'),
	(96,'Doopla',8993,'2022-10-05'),
	(97,'GBM',7621,'2022-10-05'),
	(98,'Kubo',35612,'2022-10-05'),
	(99,'Rentas',38000,'2022-10-05'),
	(100,'Yotepresto',16376,'2022-10-05'),
	(101,'Doopla',8993,'2022-10-06'),
	(102,'GBM',7621,'2022-10-06'),
	(103,'Kubo',35663,'2022-10-06'),
	(104,'Rentas',40000,'2022-10-06'),
	(105,'Yotepresto',16376,'2022-10-06'),
	(106,'Doopla',8993,'2022-10-07'),
	(107,'GBM',7650,'2022-10-07'),
	(108,'Kubo',35663,'2022-10-07'),
	(109,'Rentas',40000,'2022-10-07'),
	(110,'Yotepresto',16396,'2022-10-07'),
	(111,'Doopla',8993,'2022-10-08'),
	(112,'GBM',7650,'2022-10-08'),
	(113,'Kubo',35680,'2022-10-08'),
	(114,'Rentas',40000,'2022-10-08'),
	(115,'Yotepresto',16404,'2022-10-08'),
	(116,'Doopla',8993,'2022-10-09'),
	(117,'GBM',7650,'2022-10-09'),
	(118,'Kubo',35680,'2022-10-09'),
	(119,'Rentas',40000,'2022-10-09'),
	(120,'Yotepresto',16404,'2022-10-09'),
	(121,'Doopla',8993,'2022-10-10'),
	(122,'GBM',7650,'2022-10-10'),
	(123,'Kubo',35680,'2022-10-10'),
	(124,'Rentas',40000,'2022-10-10'),
	(125,'Yotepresto',16404,'2022-10-10'),
	(126,'Doopla',9003,'2022-10-11'),
	(127,'GBM',8332,'2022-10-11'),
	(128,'Kubo',35706,'2022-10-11'),
	(129,'Rentas',40000,'2022-10-11'),
	(130,'Yotepresto',16419,'2022-10-11'),
	(131,'Doopla',9003,'2022-10-12'),
	(132,'GBM',8332,'2022-10-12'),
	(133,'Kubo',35706,'2022-10-12'),
	(134,'Rentas',40000,'2022-10-12'),
	(135,'Yotepresto',16433,'2022-10-12'),
	(136,'Doopla',9010,'2022-10-13'),
	(137,'GBM',8347,'2022-10-13'),
	(138,'Kubo',35706,'2022-10-13'),
	(139,'Rentas',40000,'2022-10-13'),
	(140,'Yotepresto',16438,'2022-10-13'),
	(141,'Doopla',9010,'2022-10-14'),
	(142,'GBM',8347,'2022-10-14'),
	(143,'Kubo',35732,'2022-10-14'),
	(144,'Rentas',40000,'2022-10-14'),
	(145,'Yotepresto',16438,'2022-10-14'),
	(146,'Doopla',9057,'2022-10-15'),
	(147,'GBM',8347,'2022-10-15'),
	(148,'Kubo',35732,'2022-10-15'),
	(149,'Rentas',40000,'2022-10-15'),
	(150,'Yotepresto',16451,'2022-10-15'),
	(151,'Doopla',9057,'2022-10-16'),
	(152,'GBM',8347,'2022-10-16'),
	(153,'Kubo',35732,'2022-10-16'),
	(154,'Rentas',40000,'2022-10-16'),
	(155,'Yotepresto',16451,'2022-10-16'),
	(156,'Doopla',9057,'2022-10-17'),
	(157,'GBM',8347,'2022-10-17'),
	(158,'Kubo',35732,'2022-10-17'),
	(159,'Rentas',40000,'2022-10-17'),
	(160,'Yotepresto',16451,'2022-10-17'),
	(161,'Doopla',9071,'2022-10-18'),
	(162,'GBM',8347,'2022-10-18'),
	(163,'Kubo',35732,'2022-10-18'),
	(164,'Rentas',40000,'2022-10-18'),
	(165,'Yotepresto',16458,'2022-10-18'),
	(166,'Doopla',9071,'2022-10-19'),
	(167,'GBM',8353,'2022-10-19'),
	(168,'Kubo',35775,'2022-10-19'),
	(169,'Rentas',40000,'2022-10-19'),
	(170,'Yotepresto',16475,'2022-10-19'),
	(171,'Doopla',9084,'2022-10-20'),
	(172,'GBM',8353,'2022-10-20'),
	(173,'Kubo',35775,'2022-10-20'),
	(174,'Rentas',40000,'2022-10-20'),
	(175,'Yotepresto',16475,'2022-10-20'),
	(176,'Doopla',9084,'2022-10-21'),
	(177,'GBM',8353,'2022-10-21'),
	(178,'Kubo',35792,'2022-10-21'),
	(179,'Rentas',40000,'2022-10-21'),
	(180,'Yotepresto',16492,'2022-10-21');

/*!40000 ALTER TABLE `wallet_cron_balances` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla wallet_invest
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wallet_invest`;

CREATE TABLE `wallet_invest` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `concept` varchar(30) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `include` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `wallet_invest` WRITE;
/*!40000 ALTER TABLE `wallet_invest` DISABLE KEYS */;

INSERT INTO `wallet_invest` (`id`, `concept`, `amount`, `date`, `include`)
VALUES
	(1,'Yotepresto',16190,'2022-09-16 11:38:19',1),
	(2,'GBM',35971,'2022-09-14 10:37:14',1),
	(3,'Doopla',4902,'2022-09-14 13:54:57',1),
	(4,'Doopla',8933,'2022-09-15 15:32:36',1),
	(5,'Bitso',19692,'2022-09-28 17:04:50',0),
	(6,'Kubo',35440,'2022-09-14 14:26:31',1),
	(7,'GBM',35979,'2022-09-15 09:29:46',1),
	(8,'Yotepresto',16197,'2022-09-17 11:38:27',1),
	(9,'Kubo',35491,'2022-09-18 11:38:12',1),
	(10,'GBM',36000,'2022-09-16 10:30:55',1),
	(11,'Bitso',19558,'2022-10-18 11:37:56',0),
	(12,'Yotepresto',16201,'2022-09-18 11:38:23',1),
	(13,'Kubo',35526,'2022-09-19 11:38:06',1),
	(81,'Doopla',9084,'2022-10-19 15:28:33',1),
	(15,'Doopla',8941,'2022-09-20 09:27:24',1),
	(16,'Bitso',18666,'2022-09-28 17:04:55',0),
	(17,'Yotepresto',16230,'2022-09-20 18:54:07',1),
	(18,'GBM',20998,'2022-09-20 15:00:22',1),
	(19,'Rentas',15000,'2022-09-20 15:00:55',1),
	(20,'Yotepresto',16241,'2022-09-21 09:38:49',1),
	(21,'Kubo',35543,'2022-09-21 09:45:11',1),
	(22,'GBM',6208,'2022-09-21 10:15:46',1),
	(23,'Rentas',30000,'2022-09-21 10:16:56',1),
	(24,'Bitso',18867,'2022-10-18 11:37:59',0),
	(25,'Yotepresto',16249,'2022-09-22 09:47:26',1),
	(26,'GBM',6206,'2022-09-22 11:48:08',1),
	(27,'Kubo',35552,'2022-09-22 15:17:04',1),
	(28,'Yotepresto',16261,'2022-09-23 09:31:38',1),
	(29,'Kubo',35586,'2022-09-26 09:38:04',1),
	(30,'Doopla',8943,'2022-09-26 09:40:00',1),
	(31,'GBM',6960,'2022-09-26 09:54:36',1),
	(32,'Yotepresto',16264,'2022-09-26 12:37:59',1),
	(33,'Yotepresto',16266,'2022-09-27 09:37:52',1),
	(34,'Rentas',31000,'2022-09-27 09:38:26',1),
	(35,'Yotepresto',16302,'2022-09-28 09:29:30',1),
	(36,'Rentas',32000,'2022-09-28 09:29:45',1),
	(37,'Doopla',8946,'2022-09-28 14:46:15',1),
	(38,'Kubo',35603,'2022-09-28 16:45:33',1),
	(39,'Bitso',19546,'2022-09-28 17:04:46',0),
	(40,'Rentas',33000,'2022-09-29 09:28:34',1),
	(41,'Yotepresto',16307,'2022-09-29 09:29:36',1),
	(42,'Doopla',8958,'2022-09-29 14:52:41',1),
	(43,'Kubo',35612,'2022-09-29 14:56:01',1),
	(44,'Yotepresto',16335,'2022-09-29 17:21:11',1),
	(45,'Yotepresto',16348,'2022-09-30 09:32:40',1),
	(46,'Rentas',35000,'2022-09-30 09:33:07',1),
	(47,'Doopla',8968,'2022-09-30 09:35:05',1),
	(48,'GBM',6933,'2022-09-30 09:36:40',1),
	(49,'Doopla',8983,'2022-10-03 09:40:38',1),
	(50,'Rentas',36000,'2022-10-03 09:41:04',1),
	(51,'GBM',7621,'2022-10-03 09:45:20',1),
	(52,'Yotepresto',16358,'2022-10-03 11:33:46',1),
	(53,'Rentas',38000,'2022-10-04 10:06:20',1),
	(54,'Doopla',8993,'2022-10-04 10:07:32',1),
	(55,'Yotepresto',16376,'2022-10-04 15:32:21',1),
	(56,'Rentas',40000,'2022-10-05 09:25:43',1),
	(57,'Kubo',35663,'2022-10-05 09:32:37',1),
	(58,'Yotepresto',16396,'2022-10-06 09:26:49',1),
	(59,'GBM',7650,'2022-10-06 09:27:38',1),
	(60,'Yotepresto',16404,'2022-10-07 11:47:06',1),
	(61,'Kubo',35680,'2022-10-07 11:49:09',1),
	(62,'Bitso',19550,'2022-10-07 14:11:08',1),
	(63,'Yotepresto',16419,'2022-10-10 09:32:03',1),
	(64,'GBM',8332,'2022-10-10 10:03:19',1),
	(65,'Doopla',9003,'2022-10-10 09:50:50',1),
	(66,'Kubo',35706,'2022-10-10 18:26:23',1),
	(67,'Yotepresto',16433,'2022-10-11 12:14:10',1),
	(68,'GBM',8347,'2022-10-12 10:47:37',1),
	(69,'Doopla',9010,'2022-10-12 10:53:54',1),
	(70,'Yotepresto',16438,'2022-10-12 16:05:47',1),
	(71,'Kubo',35732,'2022-10-13 16:24:06',1),
	(72,'Yotepresto',16451,'2022-10-14 17:06:09',1),
	(73,'Doopla',9057,'2022-10-14 17:39:13',1),
	(74,'Yotepresto',16458,'2022-10-17 12:47:25',1),
	(75,'Doopla',9071,'2022-10-17 15:01:59',1),
	(76,'Yotepresto',16475,'2022-10-18 09:38:44',1),
	(77,'Kubo',35775,'2022-10-18 09:42:25',1),
	(78,'Bitso',18466,'2022-10-18 09:43:22',1),
	(79,'Bitso',18466,'2022-10-18 09:55:09',1),
	(80,'GBM',8353,'2022-10-18 11:29:49',1),
	(82,'Bitso',18355,'2022-10-19 15:33:02',1),
	(83,'Yotepresto',16492,'2022-10-20 09:32:10',1),
	(84,'Kubo',35792,'2022-10-20 10:35:36',1),
	(85,'Yotepresto',16524,'2022-10-21 09:52:04',1),
	(86,'GBM',8378,'2022-10-21 09:59:44',1);

/*!40000 ALTER TABLE `wallet_invest` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla wallet_movements
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wallet_movements`;

CREATE TABLE `wallet_movements` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(20) DEFAULT NULL,
  `category` varchar(30) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `amount` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `wallet_movements` WRITE;
/*!40000 ALTER TABLE `wallet_movements` DISABLE KEYS */;

INSERT INTO `wallet_movements` (`id`, `type`, `category`, `description`, `date`, `amount`)
VALUES
	(2,'Ingreso','Nomina','Quincena 15 sep','2022-09-28',8200),
	(5,'Egreso','Gasolina','Gasolina Dominar','2022-09-28',100),
	(6,'Egreso','Gastos de Hogar','Hamburguesas','2022-09-28',150),
	(8,'Egreso','Gasolina','Gasolina Dominar','2022-09-29',100),
	(9,'Egreso','Stori Card','Mensualidad Stori','2022-09-29',2960),
	(7,'Egreso','Gastos de Hogar','Little Caesars','2022-09-28',80),
	(10,'Egreso','Nu Card','Mensualidad Nu','2022-09-29',2780),
	(11,'Egreso','Mercado Libre','AudÃ­fonos Realme','2022-09-29',415),
	(12,'Ingreso','Nomina','Quincena 30 sep','2022-09-30',8300),
	(13,'Egreso','Stori Card','Mensualidad Stori','2022-09-30',2757),
	(14,'Egreso','Mercado Libre','Pago Mercado Libre','2022-09-30',415),
	(15,'Egreso','Izzi','Mensualidad Izzi','2022-09-30',390),
	(16,'Egreso','Mercado Libre','Mensualidad AudÃ­fonos','2022-10-10',415),
	(17,'Egreso','AT&T','Mensualdad 17/30','2022-10-10',460),
	(18,'Egreso','Gasolina','Gasolina Dominar','2022-10-11',70),
	(19,'Egreso','Almuerzo','Torta italiana','2022-10-11',60),
	(20,'Ingreso','Nomina','Nomina 15/10/2022','2022-10-14',8302),
	(21,'Ingreso','Otro','Trabajo Javier','2022-10-14',150),
	(22,'Egreso','Almuerzo','Torta italiana','2022-10-18',60),
	(23,'Egreso','Gasolina','Gasolina Dominar','2022-10-18',100),
	(24,'Egreso','Gasolina','Gasolina Dominar','2022-10-20',100),
	(25,'Egreso','Almuerzo','Subway','2022-10-20',100),
	(26,'Egreso','Almuerzo','Torta italiana','2022-10-21',60),
	(27,'Egreso','Gasolina','Gasolina Dominar','2022-10-21',100),
	(28,'Egreso','Electronica','IPhone Xavier','2022-10-21',1540),
	(29,'Egreso','Entretenimiento','Cervezas','2022-10-21',40);

/*!40000 ALTER TABLE `wallet_movements` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla wallet_saving
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wallet_saving`;

CREATE TABLE `wallet_saving` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `amount` float DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla wallet_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wallet_users`;

CREATE TABLE `wallet_users` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `username` varchar(11) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `wallet_users` WRITE;
/*!40000 ALTER TABLE `wallet_users` DISABLE KEYS */;

INSERT INTO `wallet_users` (`id`, `name`, `username`, `email`, `created_at`)
VALUES
	(1,'Marcos Tzuc Cen','mtcnxd','mtc.nxd@gmail.com','2022-09-30 09:48:19');

/*!40000 ALTER TABLE `wallet_users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
