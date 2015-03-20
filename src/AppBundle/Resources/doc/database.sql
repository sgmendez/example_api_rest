-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.39-MariaDB - MariaDB Server
-- Server OS:                    Linux
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2014-12-16 20:32:12
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for table database.albumes
DROP TABLE IF EXISTS `albumes`;
CREATE TABLE IF NOT EXISTS `albumes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) NOT NULL,
  `fecha_publicacion` date NOT NULL,
  `create_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table database.albumes: ~1 rows (approximately)
DELETE FROM `albumes`;
/*!40000 ALTER TABLE `albumes` DISABLE KEYS */;
INSERT INTO `albumes` (`id`, `titulo`, `fecha_publicacion`, `create_at`) VALUES
	(1, '28.000 puñaladas', '2004-05-01', '2014-12-15 20:23:46'),
	(2, 'En mi hambre mando yo', '2011-12-18', '2014-12-16 10:08:21');
/*!40000 ALTER TABLE `albumes` ENABLE KEYS */;


-- Dumping structure for table database.artistas
DROP TABLE IF EXISTS `artistas`;
CREATE TABLE IF NOT EXISTS `artistas` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `rol` varchar(50) NOT NULL,
  `create_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- Dumping data for table database.artistas: ~1 rows (approximately)
DELETE FROM `artistas`;
/*!40000 ALTER TABLE `artistas` DISABLE KEYS */;
INSERT INTO `artistas` (`id`, `nombre`, `rol`, `create_at`) VALUES
	(1, 'Kutxi Romero', 'voz', '2014-12-10 00:00:00'),
	(2, 'David Díaz', 'guitarra', '2014-12-11 10:26:18'),
	(3, 'Eduardo Beaumont', 'bajo', '2014-12-16 11:06:11');
/*!40000 ALTER TABLE `artistas` ENABLE KEYS */;


-- Dumping structure for table database.artistas_albumes
DROP TABLE IF EXISTS `artistas_albumes`;
CREATE TABLE IF NOT EXISTS `artistas_albumes` (
  `artistas_id` bigint(20) NOT NULL,
  `albumes_id` bigint(20) NOT NULL,
  KEY `FK_artistas_albumes_artistas` (`artistas_id`),
  KEY `FK_artistas_albumes_albumes` (`albumes_id`),
  CONSTRAINT `FK_artistas_albumes_albumes` FOREIGN KEY (`albumes_id`) REFERENCES `albumes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_artistas_albumes_artistas` FOREIGN KEY (`artistas_id`) REFERENCES `artistas` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table database.artistas_albumes: ~1 rows (approximately)
DELETE FROM `artistas_albumes`;
/*!40000 ALTER TABLE `artistas_albumes` DISABLE KEYS */;
INSERT INTO `artistas_albumes` (`artistas_id`, `albumes_id`) VALUES
	(1, 1),
	(1, 2),
	(3, 1),
	(2, 1),
	(1, 2);
/*!40000 ALTER TABLE `artistas_albumes` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

