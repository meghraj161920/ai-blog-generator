-- MySQL dump 10.13  Distrib 8.0.46, for Linux (x86_64)
--
-- Host: localhost    Database: training_institute
-- ------------------------------------------------------
-- Server version	8.0.46-0ubuntu0.24.04.3

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
-- Table structure for table `auto_generate_logs`
--

DROP TABLE IF EXISTS `auto_generate_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auto_generate_logs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `topic` varchar(255) NOT NULL,
  `blog_id` int DEFAULT NULL,
  `status` varchar(50) DEFAULT 'success',
  `error_message` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auto_generate_logs`
--

LOCK TABLES `auto_generate_logs` WRITE;
/*!40000 ALTER TABLE `auto_generate_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `auto_generate_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_topics`
--

DROP TABLE IF EXISTS `blog_topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blog_topics` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `topic` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT 'General',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_topics`
--

LOCK TABLES `blog_topics` WRITE;
/*!40000 ALTER TABLE `blog_topics` DISABLE KEYS */;
INSERT INTO `blog_topics` VALUES (1,'How to Start a Career in Data Science','Career',1,'2026-07-06 17:17:25'),(2,'Top 10 Python Libraries for Beginners','Programming',1,'2026-07-06 17:17:25'),(3,'Understanding Machine Learning Basics','AI',1,'2026-07-06 17:17:25'),(4,'Web Development Trends in 2026','Web Dev',1,'2026-07-06 17:17:25'),(5,'Cloud Computing Fundamentals','Cloud',1,'2026-07-06 17:17:25'),(6,'Cybersecurity Tips for Small Businesses','Security',1,'2026-07-06 17:17:25'),(7,'Introduction to DevOps Practices','DevOps',1,'2026-07-06 17:17:25'),(8,'Mobile App Development Guide','Mobile',1,'2026-07-06 17:17:25'),(9,'Database Design Best Practices','Database',1,'2026-07-06 17:17:25'),(10,'UI/UX Design Principles for Beginners','Design',1,'2026-07-06 17:17:25'),(11,'How to Start a Career in Data Science','Career',1,'2026-07-06 17:17:44'),(12,'Top 10 Python Libraries for Beginners','Programming',1,'2026-07-06 17:17:44'),(13,'Understanding Machine Learning Basics','AI',1,'2026-07-06 17:17:44'),(14,'Web Development Trends in 2026','Web Dev',1,'2026-07-06 17:17:44'),(15,'Cloud Computing Fundamentals','Cloud',1,'2026-07-06 17:17:44'),(16,'Cybersecurity Tips for Small Businesses','Security',1,'2026-07-06 17:17:44'),(17,'Introduction to DevOps Practices','DevOps',1,'2026-07-06 17:17:44'),(18,'Mobile App Development Guide','Mobile',1,'2026-07-06 17:17:44'),(19,'Database Design Best Practices','Database',1,'2026-07-06 17:17:44'),(20,'UI/UX Design Principles for Beginners','Design',1,'2026-07-06 17:17:44'),(21,'How to Start a Career in Data Science','Career',1,'2026-07-06 17:18:59'),(22,'Top 10 Python Libraries for Beginners','Programming',1,'2026-07-06 17:18:59'),(23,'Understanding Machine Learning Basics','AI',1,'2026-07-06 17:18:59'),(24,'Web Development Trends in 2026','Web Dev',1,'2026-07-06 17:18:59'),(25,'Cloud Computing Fundamentals','Cloud',1,'2026-07-06 17:18:59'),(26,'Cybersecurity Tips for Small Businesses','Security',1,'2026-07-06 17:18:59'),(27,'Introduction to DevOps Practices','DevOps',1,'2026-07-06 17:18:59'),(28,'Mobile App Development Guide','Mobile',1,'2026-07-06 17:18:59'),(29,'Database Design Best Practices','Database',1,'2026-07-06 17:18:59'),(30,'UI/UX Design Principles for Beginners','Design',1,'2026-07-06 17:18:59');
/*!40000 ALTER TABLE `blog_topics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blogs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `meta_description` varchar(500) DEFAULT NULL,
  `meta_keywords` varchar(500) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `topic` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=inactive, 1=active',
  `is_auto_generated` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=generated by AI auto-system',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogs`
--

LOCK TABLES `blogs` WRITE;
/*!40000 ALTER TABLE `blogs` DISABLE KEYS */;
INSERT INTO `blogs` VALUES (1,'Why Do we Learn DJango in 2026 ?','why-do-we-learn-dJango-in-2026','Something about python is Addiction , to be a better developer','','',NULL,'',0,0,'2026-07-06 17:44:31','2026-07-06 17:58:44'),(2,'Deserunt officia ali','blog-2-deserunt-officia-ali','Assumenda rerum et s','Accusantium aperiam numquam eos dolore ut dicta eligendi repellendus Aliquam velit porro excepteur hic ea molestias cupidatat iusto nulla','Aut ut dolorum eaque',NULL,'Nihil libero exercit',0,0,'2026-07-06 17:45:52','2026-07-06 18:04:42'),(3,'Rerum dolorum in con','blog-3-rerum-dolorum-in-con','Animi numquam quos ','Necessitatibus est ipsum at ducimus esse dolore aute cupidatat omnis cumque in tenetur obcaecati sit veritatis quam est tempore','Fuga Ab harum in it',NULL,'Ipsa cupiditate dic',1,0,'2026-07-06 17:46:09','2026-07-06 18:04:42'),(4,'Irure cumque eligend','blog-4-irure-cumque-eligend','Sit elit ea id au','Distinctio Magna rem deleniti delectus consectetur','Fuga Dolores in max',NULL,'Voluptas ut ea volup',0,0,'2026-07-06 17:49:23','2026-07-06 18:04:42'),(5,'Tempor non dolor ame','blog-5-tempor-non-dolor-ame','Temporibus saepe dol','Nulla veniam eos illo explicabo Vero alias quia minima rerum impedit sint recusandae Aliquip optio id amet odio','Quibusdam ut non nos',NULL,'Est elit facilis o',1,0,'2026-07-06 17:52:50','2026-07-06 18:04:42'),(6,'Minim et veniam sim','Praesentium exceptur','Beatae ipsum corpori','Qui libero inventore quis ut aspernatur vel quo reprehenderit corrupti est','Aut quam sunt adipis','uploads/blogs/blog_1783341571.jpg','Sequi reprehenderit ',1,0,'2026-07-06 18:09:31','2026-07-06 18:09:33');
/*!40000 ALTER TABLE `blogs` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-06 18:15:38
