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
-- Table structure for table `adresse`
--

DROP TABLE IF EXISTS `adresse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `adresse` (
  `adresse_id` int NOT NULL AUTO_INCREMENT,
  `adresse_voie` varchar(255) NOT NULL,
  `fk_ville_id` int DEFAULT NULL,
  PRIMARY KEY (`adresse_id`),
  KEY `fk_ville_id` (`fk_ville_id`),
  CONSTRAINT `adresse_ibfk_1` FOREIGN KEY (`fk_ville_id`) REFERENCES `ville` (`ville_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adresse`
--

LOCK TABLES `adresse` WRITE;
/*!40000 ALTER TABLE `adresse` DISABLE KEYS */;
INSERT INTO `adresse` VALUES (1,'11 rue des plantes',5),(2,'8 avenue du général leclark',1),(3,'1 bis impasse marie curry',1),(4,'38 avenue jules ferry',2),(5,'15 impasse des lilas',5),(6,'23 chemin joly',9);
/*!40000 ALTER TABLE `adresse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorie` (
  `categorie_id` int NOT NULL AUTO_INCREMENT,
  `categorie_nom` varchar(50) NOT NULL,
  PRIMARY KEY (`categorie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorie`
--

LOCK TABLES `categorie` WRITE;
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
/*!40000 ALTER TABLE `categorie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `demande`
--

DROP TABLE IF EXISTS `demande`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `demande` (
  `demande_id` int NOT NULL AUTO_INCREMENT,
  `demande_titre` varchar(40) NOT NULL,
  `demande_quantite` int DEFAULT NULL,
  `demande_description` text,
  `demande_date_publication` date NOT NULL,
  `demande_date_debut` date DEFAULT NULL,
  `demande_date_fin` date DEFAULT NULL,
  `fk_demandeur_id` int DEFAULT NULL,
  `fk_repondant_id` int DEFAULT NULL,
  `fk_categorie_id` int DEFAULT NULL,
  `fk_unite_id` int DEFAULT NULL,
  PRIMARY KEY (`demande_id`),
  KEY `fk_demandeur_id` (`fk_demandeur_id`),
  KEY `fk_repondant_id` (`fk_repondant_id`),
  KEY `fk_categorie_id` (`fk_categorie_id`),
  KEY `fk_unite_id` (`fk_unite_id`),
  CONSTRAINT `demande_ibfk_1` FOREIGN KEY (`fk_demandeur_id`) REFERENCES `utilisateur` (`utilisateur_id`),
  CONSTRAINT `demande_ibfk_2` FOREIGN KEY (`fk_repondant_id`) REFERENCES `utilisateur` (`utilisateur_id`),
  CONSTRAINT `demande_ibfk_3` FOREIGN KEY (`fk_categorie_id`) REFERENCES `categorie` (`categorie_id`),
  CONSTRAINT `demande_ibfk_4` FOREIGN KEY (`fk_unite_id`) REFERENCES `unite` (`unite_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demande`
--

LOCK TABLES `demande` WRITE;
/*!40000 ALTER TABLE `demande` DISABLE KEYS */;
INSERT INTO `demande` VALUES (1,'Besoin de lait',6,'J\'ai besoin de 6L de lait en bouteilles de 1L','2020-10-20',NULL,NULL,1,NULL,NULL,1),(2,'Cherche une tondeuse à gazon',1,'Besoin d\'une tondeuse pour mon gazon pendant 2 jours','2020-10-20',NULL,NULL,2,NULL,NULL,8),(3,'Urgent : oeufs',1,'J\'ai besoin d\'une boîte de 12 oeufs','2020-10-22',NULL,NULL,3,NULL,NULL,7),(4,'Tissu floral',15,'Je recherche du tissus avec des motifs floraux, pour 15 mètres au total','2020-10-24',NULL,NULL,4,NULL,NULL,3),(5,'4 baguettes',4,'Besoin de 4 baguettes de pain','2020-10-24',NULL,NULL,5,NULL,NULL,8),(6,'Une barre de douche',1,'J\'ai besoin d\'une barre de douche, j\'ai cassé la mienne','2020-10-26',NULL,NULL,6,NULL,NULL,8),(7,'Seau',1,'Cherche un seau en fer','2020-10-25',NULL,NULL,7,NULL,NULL,8);
/*!40000 ALTER TABLE `demande` ENABLE KEYS */;
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
-- Table structure for table `unite`
--

DROP TABLE IF EXISTS `unite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `unite` (
  `unite_id` int NOT NULL AUTO_INCREMENT,
  `unite_nom` varchar(20) NOT NULL,
  PRIMARY KEY (`unite_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unite`
--

LOCK TABLES `unite` WRITE;
/*!40000 ALTER TABLE `unite` DISABLE KEYS */;
INSERT INTO `unite` VALUES (1,'litre'),(2,'centilitre'),(3,'mètre'),(4,'centimètre'),(5,'gramme'),(6,'kilogramme'),(7,'boîte/paquet'),(8,'autre');
/*!40000 ALTER TABLE `unite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `utilisateur` (
  `utilisateur_id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_civilite` varchar(20) NOT NULL,
  `utilisateur_nom` varchar(50) NOT NULL,
  `utilisateur_prenom` varchar(255) NOT NULL,
  `utilisateur_telephone` int NOT NULL,
  `utilisateur_email` varchar(50) NOT NULL,
  `fk_adresse_id` int DEFAULT NULL,
  PRIMARY KEY (`utilisateur_id`),
  KEY `fk_adresse_id` (`fk_adresse_id`),
  CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`fk_adresse_id`) REFERENCES `adresse` (`adresse_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilisateur`
--

LOCK TABLES `utilisateur` WRITE;
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT INTO `utilisateur` VALUES (1,'Mme','Martin','Julia',600000000,'julia.m@mail.com',1),(2,'Mr','Martin','Jules',600000000,'jules.m@mail.com',2),(3,'Mr','Vernon','Geatan',600000000,'gaetan.v@mail.com',3),(4,'Mme','Vernon','Brigitte',600000000,'brigitte.v@mail.com',3),(5,'Mme','Blanche','Elodie',600000000,'elodie.b@mail.com',4),(6,'Autre','Heidrik','Zoé',600000000,'zoe.h@mail.com',5),(7,'Mr','Sando','Eric',600000000,'eric.s@mail.com',6);
/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ville`
--

DROP TABLE IF EXISTS `ville`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ville` (
  `ville_id` int NOT NULL AUTO_INCREMENT,
  `ville_nom` varchar(50) NOT NULL,
  `ville_cp` int NOT NULL,
  PRIMARY KEY (`ville_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ville`
--

LOCK TABLES `ville` WRITE;
/*!40000 ALTER TABLE `ville` DISABLE KEYS */;
INSERT INTO `ville` VALUES (1,'Tours',37000),(2,'Joué-lès-Tours',37300),(3,'La Riche',37520),(4,'Chambray-lès-Tours',37170),(5,'Saint-Cyr-sur-Loire',37540),(6,'Fondettes',37230),(7,'Saint-Pierre-des-Corps',37700),(8,'Ballan-Miré',37510),(9,'Saint-Avertin',37550);
/*!40000 ALTER TABLE `ville` ENABLE KEYS */;
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
