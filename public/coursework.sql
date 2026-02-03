/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.6.22-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: event_management
-- ------------------------------------------------------
-- Server version	10.6.22-MariaDB-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `time` time DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `capacity` int(11) DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `events_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (6,'Cyber Security Workshop','Hands-on workshop covering OWASP Top 10 and web exploitation basics.','2026-02-01','10:00:00','Kathmandu Tech Hub',0,'6980b8cbe5c76.jpeg',6,'2026-02-01 15:40:11'),(7,'CTF Competition','Beginner-friendly Capture The Flag competition with web and crypto challenges.','2026-02-15','14:30:00','Online',120,'6980dded55a54.jpeg',6,'2026-02-01 15:40:11'),(8,'Bug Bounty Talk','Introduction to bug bounty hunting, platforms, and real-world reports.','2026-02-20','16:00:00','Pokhara IT Center',50,'6980b8bb29fe4.png',6,'2026-02-01 15:40:11'),(9,'Linux Fundamentals','Learn Linux basics for developers and security enthusiasts.','2026-02-25','09:00:00','Biratnagar Training Hall',2,'6980b8ad86800.png',6,'2026-02-01 15:40:11'),(10,'Advanced Web Hacking','Deep dive into SQLi, XSS chaining, CSRF, and logic flaws.','2026-03-01','11:00:00','Online',20,'6980b89523ec9.jpg',6,'2026-02-01 15:40:11'),(11,'Hackastra CTF','This is the biggest CTF event that will ever happen in Nepal. The biggest cash prize in the history of CTF in Nepal along with certifications vouchers.','2026-05-30','12:03:00','Herald College Kathmandu',120,'6980c2e43ef22.jpg',6,'2026-02-01 15:41:17');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participations`
--

DROP TABLE IF EXISTS `participations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `participations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_participation` (`user_id`,`event_id`),
  KEY `event_id` (`event_id`),
  CONSTRAINT `participations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `participations_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participations`
--

LOCK TABLES `participations` WRITE;
/*!40000 ALTER TABLE `participations` DISABLE KEYS */;
INSERT INTO `participations` VALUES (10,3,10,'2026-02-01 15:41:52'),(11,7,10,'2026-02-01 15:42:32'),(12,8,11,'2026-02-02 11:04:31'),(13,8,10,'2026-02-02 11:18:26'),(14,8,9,'2026-02-02 11:18:37'),(16,8,6,'2026-02-02 11:21:39'),(17,7,11,'2026-02-02 16:16:04'),(18,9,11,'2026-02-02 16:37:55'),(19,9,10,'2026-02-02 16:38:00'),(20,9,9,'2026-02-02 16:38:05'),(21,9,7,'2026-02-02 16:38:15'),(22,10,8,'2026-02-02 16:39:48');
/*!40000 ALTER TABLE `participations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'dada','dada@gmail.com','$2y$10$B0yOVz.wp6CqPKAwcIeCg.dIq5Ggh0sQrKvZbBTBmdfOdhq9ne6Yi','user','2026-01-25 13:03:04'),(3,'shyam','shyam@gmail.com','$2y$10$kHJj/CwI41ExXFuw.14BluzQj.zFJjS0qUqcggcRj6L2qGzgJt3GG','user','2026-01-25 13:04:35'),(4,'misaney','misaney@gmail.com','$2y$10$Dy/XP2TyYNLEifzcuLVNVO8nygtQhmtdqTY5L19sgK/zSoPjklqE6','user','2026-01-26 07:03:49'),(5,'jasmine','jasmine@d.c','$2y$10$aJB8UyK8w0SK2LT3f30LUOUq7wXmqxWAYhEL8DJAYnVjTclxMt6CO','user','2026-01-26 08:43:45'),(6,'Administrator','pranjal@gmail.com','$2y$10$9lJU6xDAUFWB2Lv4KhFEg.Odvmz8Xum9OzpnDmn1z9nlY5gq80N6S','admin','2026-02-01 15:36:35'),(7,'hari om','hariom@gmail.com','$2y$10$1Ho2PrmepJq2dJXVeu8u0Ova41B7mU2XJEaaW4aNtj4ZOMrDgnb66','user','2026-02-01 15:42:14'),(8,'s','sajan@gmail.com','$2y$10$4V1iySDNEItVNWI0kMW//uyy/0qeTOsozFEXgckLySRhI7EZQhvOi','user','2026-02-02 11:04:18'),(9,'haribahadur','haribahadur@gmail.com','$2y$10$6mSivOar20ZSEtfnFJHMKOJaeNujXERhwWz34RkR4PMCUWnVbFL2.','user','2026-02-02 16:37:36'),(10,'hari','hari@gmail.com','$2y$10$MNl9BN0D8TKm6O/7T9Z7JOPLgfNXPica8CUPc.V4nZ6szebbxoUki','user','2026-02-02 16:38:48');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-02-02 23:20:32
