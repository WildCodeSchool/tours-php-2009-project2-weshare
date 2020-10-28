-- MySQL dump 10.13  Distrib 8.0.21, for Linux (x86_64)
--
-- Host: localhost    Database: we_share
-- ------------------------------------------------------
-- Server version	8.0.21-0ubuntu0.20.04.4

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `adress`
--

DROP TABLE IF EXISTS `adress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `adress` (
  `adress_id` int NOT NULL AUTO_INCREMENT,
  `adress_street` varchar(255) NOT NULL,
  `fk_town_id` int DEFAULT NULL,
  PRIMARY KEY (`adress_id`),
  KEY `fk_town_id` (`fk_town_id`),
  CONSTRAINT `adress_ibfk_1` FOREIGN KEY (`fk_town_id`) REFERENCES `town` (`town_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adress`
--

LOCK TABLES `adress` WRITE;
/*!40000 ALTER TABLE `adress` DISABLE KEYS */;
INSERT INTO `adress` VALUES (1,'11 rue des plantes',5),(2,'8 avenue du général leclark',1),(3,'1 bis impasse marie curry',1),(4,'38 avenue jules ferry',2),(5,'15 impasse des lilas',5),(6,'23 chemin joly',9);
/*!40000 ALTER TABLE `adress` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `request`
--

DROP TABLE IF EXISTS `request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `request` (
  `request_id` int NOT NULL AUTO_INCREMENT,
  `request_title` varchar(40) NOT NULL,
  `request_quantity` int DEFAULT NULL,
  `request_description` text,
  `request_date_publication` date NOT NULL,
  `request_date_start` date DEFAULT NULL,
  `request_date_end` date DEFAULT NULL,
  `fk_requester_id` int DEFAULT NULL,
  `fk_answerer_id` int DEFAULT NULL,
  `fk_category_id` int DEFAULT NULL,
  `fk_measurement_id` int DEFAULT NULL,
  PRIMARY KEY (`request_id`),
  KEY `fk_requester_id` (`fk_requester_id`),
  KEY `fk_answerer_id` (`fk_answerer_id`),
  KEY `fk_category_id` (`fk_category_id`),
  KEY `fk_measurement_id` (`fk_measurement_id`),
  CONSTRAINT `request_ibfk_1` FOREIGN KEY (`fk_requester_id`) REFERENCES `user` (`user_id`),
  CONSTRAINT `request_ibfk_2` FOREIGN KEY (`fk_answerer_id`) REFERENCES `user` (`user_id`),
  CONSTRAINT `request_ibfk_3` FOREIGN KEY (`fk_category_id`) REFERENCES `category` (`category_id`),
  CONSTRAINT `request_ibfk_4` FOREIGN KEY (`fk_measurement_id`) REFERENCES `measurement` (`measurement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `request`
--

LOCK TABLES `request` WRITE;
/*!40000 ALTER TABLE `request` DISABLE KEYS */;
INSERT INTO `request` VALUES (1,'Besoin de lait',6,"J\'ai besoin de 6L de lait en bouteilles de 1L",'2020-10-20',NULL,NULL,1,NULL,NULL,1),(2,'Cherche une tondeuse à gazon',1,'Besoin d\'une tondeuse pour mon gazon pendant 2 jours','2020-10-20',NULL,NULL,2,NULL,NULL,8),(3,'Urgent : oeufs',1,'J\'ai besoin d\'une boîte de 12 oeufs','2020-10-22',NULL,NULL,3,NULL,NULL,7),(4,'Tissu floral',15,'Je recherche du tissus avec des motifs floraux, pour 15 mètres au total','2020-10-24',NULL,NULL,4,NULL,NULL,3),(5,'4 baguettes',4,'Besoin de 4 baguettes de pain','2020-10-24',NULL,NULL,5,NULL,NULL,8),(6,'Une barre de douche',1,'J\'ai besoin d\'une barre de douche, j\'ai cassé la mienne','2020-10-26',NULL,NULL,6,NULL,NULL,8),(7,'Seau',1,'Cherche un seau en fer','2020-10-25',NULL,NULL,7,NULL,NULL,8);
/*!40000 ALTER TABLE `request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `item` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` VALUES (1,'Stuff'),(2,'Doodads'),(3,'this');
/*!40000 ALTER TABLE `item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `measurement`
--

DROP TABLE IF EXISTS `measurement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `measurement` (
  `measurement_id` int NOT NULL AUTO_INCREMENT,
  `measurement_name` varchar(20) NOT NULL,
  PRIMARY KEY (`measurement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `measurement`
--

LOCK TABLES `measurement` WRITE;
/*!40000 ALTER TABLE `measurement` DISABLE KEYS */;
INSERT INTO `measurement` VALUES (1,'litre'),(2,'centilitre'),(3,'mètre'),(4,'centimètre'),(5,'gramme'),(6,'kilogramme'),(7,'boîte/paquet'),(8,'autre');
/*!40000 ALTER TABLE `measurement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_civility` varchar(20) NOT NULL,
  `user_lastname` varchar(50) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_phone` int NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `fk_adress_id` int DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `fk_adress_id` (`fk_adress_id`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`fk_adress_id`) REFERENCES `adress` (`adress_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Mme','Martin','Julia',600000000,'julia.m@mail.com',1),(2,'Mr','Martin','Jules',600000000,'jules.m@mail.com',2),(3,'Mr','Vernon','Geatan',600000000,'gaetan.v@mail.com',3),(4,'Mme','Vernon','Brigitte',600000000,'brigitte.v@mail.com',3),(5,'Mme','Blanche','Elodie',600000000,'elodie.b@mail.com',4),(6,'Autre','Heidrik','Zoé',600000000,'zoe.h@mail.com',5),(7,'Mr','Sando','Eric',600000000,'eric.s@mail.com',6);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `town`
--

DROP TABLE IF EXISTS `town`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `town` (
  `town_id` int NOT NULL AUTO_INCREMENT,
  `town_name` varchar(50) NOT NULL,
  `town_postal_code` int NOT NULL,
  PRIMARY KEY (`town_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `town`
--

LOCK TABLES `town` WRITE;
/*!40000 ALTER TABLE `town` DISABLE KEYS */;
INSERT INTO `town` VALUES (1,'Tours',37000),(2,'Joué-lès-Tours',37300),(3,'La Riche',37520),(4,'Chambray-lès-Tours',37170),(5,'Saint-Cyr-sur-Loire',37540),(6,'Fondettes',37230),(7,'Saint-Pierre-des-Corps',37700),(8,'Ballan-Miré',37510),(9,'Saint-Avertin',37550);
/*!40000 ALTER TABLE `town` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'we_share'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-10-27 16:26:55
