-- MySQL dump 10.13  Distrib 5.5.29, for Linux (x86_64)
--
-- Host: localhost    Database: fahmi_usercake
-- ------------------------------------------------------
-- Server version	5.5.29-29.4

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `uc_checklist`
--

DROP TABLE IF EXISTS `uc_checklist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_checklist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `activity` varchar(150) DEFAULT NULL,
  `check` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uc_checklist`
--

LOCK TABLES `uc_checklist` WRITE;
/*!40000 ALTER TABLE `uc_checklist` DISABLE KEYS */;
INSERT INTO `uc_checklist` VALUES (1,14,'bismillah',NULL),(2,13,'sads',NULL),(3,14,'dvdf',NULL),(4,14,'aduhai',NULL),(5,14,'maskd',NULL),(6,14,'best gila',NULL),(7,13,'makan cendol',NULL),(8,13,'beli ubat nyamuk',NULL),(9,11,'Reading',NULL);
/*!40000 ALTER TABLE `uc_checklist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uc_configuration`
--

DROP TABLE IF EXISTS `uc_configuration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `value` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uc_configuration`
--

LOCK TABLES `uc_configuration` WRITE;
/*!40000 ALTER TABLE `uc_configuration` DISABLE KEYS */;
INSERT INTO `uc_configuration` VALUES (1,'website_name','HALUANSiswa Talent Management System'),(2,'website_url','http://fahmi.faizshukri.com/'),(3,'email','faizshukri90@gmail.com'),(4,'activation','false'),(5,'resend_activation_threshold','0'),(6,'language','models/languages/en.php'),(7,'template','models/site-templates/bootstrap-ubuntu.min.css');
/*!40000 ALTER TABLE `uc_configuration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uc_pages`
--

DROP TABLE IF EXISTS `uc_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(150) NOT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uc_pages`
--

LOCK TABLES `uc_pages` WRITE;
/*!40000 ALTER TABLE `uc_pages` DISABLE KEYS */;
INSERT INTO `uc_pages` VALUES (1,'account.php',1),(2,'activate-account.php',0),(3,'admin_configuration.php',1),(4,'admin_page.php',1),(5,'admin_pages.php',1),(6,'admin_permission.php',1),(7,'admin_permissions.php',1),(8,'admin_user.php',1),(9,'admin_users.php',1),(10,'forgot-password.php',0),(11,'index.php',1),(12,'left-nav.php',0),(13,'login.php',0),(14,'logout.php',1),(15,'register.php',1),(16,'resend-activation.php',0),(17,'user_settings.php',1),(18,'example.php',0),(19,'main_menu.php',0),(20,'user_profiles.php',1),(21,'user_biodata.php',1),(22,'user_development.php',0),(23,'user_education.php',1),(24,'user_expertise.php',0),(25,'user_membership.php',0),(26,'mentee.php',0);
/*!40000 ALTER TABLE `uc_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uc_permission_page_matches`
--

DROP TABLE IF EXISTS `uc_permission_page_matches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_permission_page_matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uc_permission_page_matches`
--

LOCK TABLES `uc_permission_page_matches` WRITE;
/*!40000 ALTER TABLE `uc_permission_page_matches` DISABLE KEYS */;
INSERT INTO `uc_permission_page_matches` VALUES (1,1,1),(2,1,14),(3,1,17),(4,2,1),(5,2,3),(6,2,4),(7,2,5),(8,2,6),(9,2,7),(10,2,8),(11,2,9),(12,2,14),(13,2,17),(24,3,1),(25,3,11),(26,3,14),(27,3,17),(29,3,15),(30,2,15),(31,3,9),(32,3,8),(33,1,20),(34,2,20),(35,3,20),(36,1,21),(37,2,21),(38,3,21),(39,1,23),(40,2,23),(41,3,23);
/*!40000 ALTER TABLE `uc_permission_page_matches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uc_permissions`
--

DROP TABLE IF EXISTS `uc_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uc_permissions`
--

LOCK TABLES `uc_permissions` WRITE;
/*!40000 ALTER TABLE `uc_permissions` DISABLE KEYS */;
INSERT INTO `uc_permissions` VALUES (1,'Member'),(2,'Administrator'),(3,'Mentor');
/*!40000 ALTER TABLE `uc_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uc_user_data`
--

DROP TABLE IF EXISTS `uc_user_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_user_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uc_user_data`
--

LOCK TABLES `uc_user_data` WRITE;
/*!40000 ALTER TABLE `uc_user_data` DISABLE KEYS */;
INSERT INTO `uc_user_data` VALUES (1,1,'user_profile','{\"biodata\":\"Fahmi Bin Fuad\",\"education\":\"fdvrfg\",\"expertise\":\"trgtr\",\"development\":\"erger\",\"membership\":\"esok lusa\"}'),(2,1,'user_biodata','{\"fullname\":\"Fahmi Fuad\",\"ic_no\":\"\",\"dob\":\"\",\"email\":\"\",\"no_phone\":\"\",\"address\":\"\",\"city\":\"\",\"state\":\"\"}'),(3,1,'user_education','{\"primary\":{\"sksd\":\"1997\",\"ibn abbas\":\"2000\"},\"secondary\":{\"matri\":\"2003\",\"ibn khaldun\":\"2006\"},\"high\":{\"mmu\":{\"year\":\"2008\",\"course\":\"software\"},\"usm\":{\"year\":\"2014\",\"course\":\"master\"}}}'),(4,1,'user_skills','{\"hard\":[\"1\",\"2\",\"3\"],\"soft\":[\"a\",\"b\",\"c\"]}'),(5,9,'user_biodata','{\"fullname\":\"\",\"ic_no\":\"\",\"dob\":\"\",\"email\":\"xcvxcvxc\",\"no_phone\":\"\",\"address\":\"\",\"city\":\"\",\"state\":\"Johor\"}'),(6,13,'user_biodata','{\"fullname\":\"Radhi Rahman\",\"ic_no\":\"38965\",\"dob\":\"03\\/17\\/1993\",\"email\":\"radhi@khalid.org\",\"no_phone\":\"983465\",\"address\":\"jalan ampang\",\"city\":\"ipoh\",\"state\":\"Perak\"}'),(7,13,'user_education','{\"primary\":{\"gfe\":\"546\"},\"secondary\":{\"fhjyj\":\"5675\"},\"high\":{\"thr\":{\"year\":\"6867\",\"course\":\"tjyujry\"}}}'),(8,13,'user_skills','{\"hard\":[\"trh\",\"ujy\"],\"soft\":[\"he\",\"lioyhn\"]}'),(10,13,'user_reading','[\"budaya membaca\",\"terlihat di sana\",\"bagus sangat2\",\"dvdf\",\"day after tomorrow\"]'),(11,14,'user_reading','[\"membaca\",\"terbaiklah\",\"hurm\"]'),(12,14,'user_event','[\"say you\",\"seriously?\"]'),(13,13,'user_event','[\"skema 2012\"]'),(14,11,'user_reading','[\"Leadership by John C. Maxwell\"]');
/*!40000 ALTER TABLE `uc_user_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uc_user_permission_matches`
--

DROP TABLE IF EXISTS `uc_user_permission_matches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_user_permission_matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uc_user_permission_matches`
--

LOCK TABLES `uc_user_permission_matches` WRITE;
/*!40000 ALTER TABLE `uc_user_permission_matches` DISABLE KEYS */;
INSERT INTO `uc_user_permission_matches` VALUES (1,1,2),(5,2,3),(8,6,3),(9,7,1),(10,8,1),(13,9,1),(14,10,3),(15,11,1),(16,12,3),(17,13,1),(18,14,1);
/*!40000 ALTER TABLE `uc_user_permission_matches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uc_users`
--

DROP TABLE IF EXISTS `uc_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `display_name` varchar(50) NOT NULL,
  `password` varchar(225) NOT NULL,
  `email` varchar(150) NOT NULL,
  `activation_token` varchar(225) NOT NULL,
  `last_activation_request` int(11) NOT NULL,
  `lost_password_request` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `title` varchar(150) NOT NULL,
  `user_parent` int(11) unsigned NOT NULL DEFAULT '0',
  `sign_up_stamp` int(11) NOT NULL,
  `last_sign_in_stamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uc_users`
--

LOCK TABLES `uc_users` WRITE;
/*!40000 ALTER TABLE `uc_users` DISABLE KEYS */;
INSERT INTO `uc_users` VALUES (1,'fahmi','fahmi','a9bca882175d2f4fe8d0412af8d0ca83c9a6d73155e916fbbf5e8f157fb57dbb5','faizshukri90@gmail.com','08207658a0fdb1f63a34f8769be4f1e3',1363172411,0,1,'New Member',0,1363172411,1363564746),(2,'faizshukri','faizshukri','458d33e104443523bbeb60dc38038f79d0104fea09456ae9d237d0d7c485af8c9','faiz@outlook.com','9c981bd4ca0597cd17048e80d8705ff8',1363189142,0,1,'New Member',0,1363189142,0),(6,'sdfsdf','vdfsf','43ab8fc3c0a6456b542e03877670c1343ec0019c6c7bd266a63b92141dce76db2','dsfdsf@sedfef.com','b2878d534fd3bbfdcf83c33cd25be038',1363192641,0,1,'New Member',0,1363192641,1363194385),(7,'dgrger','dgerg','1dc53e51ca1681c04f357b7f35fc16644c386097311f6341df1eeb57706696f27','sade@efew.com','06fa520f46649a9815116b1385b4e32e',1363192665,0,1,'New Member',6,1363192665,0),(8,'doraemon','wefre','e038a1619f62c123eac57c3df27a7b8cf24797aa67a5b4388625624ab226c3312','dvfdv@rferf.com','ad53635db6c61062a9f6ed971f9faf0e',1363193019,0,1,'New Member',6,1363193019,1363223097),(9,'faris','Faris','8a3f078347db99a6d6b5fa9a8a95828d8f3019527af6e45569b99f7114fe10085','faris@gmail.com','ecfa28c42a23fe26cdbf22112e096a25',1363226999,0,1,'New Member',2,1363226999,1363606192),(10,'azizi','Azizi','51c247bdedb746e21b3c0409bbc7011497fdf65596da382b070b11192b3782f27','azizi@gmail.com','ee4441dba40e84e8bfab9ed010fdb80d',1363227030,0,1,'New Member',0,1363227030,1363618500),(11,'zulowari','Zulfaqar','e1c4b29be98ce8b59d7666dca3fd910751c13ea27214109b799bb2b74a8f9d963','zul@gmail.com','5b62b90da4a34c308b5e31f792b5c556',1363227911,0,1,'New Member',10,1363227911,1363574015),(12,'mentor','mentor','3e67a6018feb7de6eb7ce5d62101bccbb6cc7bceef9bda8949cb966ac04606d7f','mentor1@test.com','660ea56cddb27aaf7f5d46e94ac9c7f8',1363281587,0,1,'New Member',0,1363281587,1363534904),(13,'radhi','radhi','968dc5c147ce5b7c4dbb30f29bdf2dd410a0d6463e50f9682a5a16759c6ae50a6','radhi@khalid.org','6ed2e086ede3683e1c9eb2ff56d1f1f1',1363281719,0,1,'New Member',12,1363281719,1363534754),(14,'firdaus','firdaus','6c169ec4e022d502896fb609c28cdfe1ce6ac03757e01f921f9a1f326ac1f5dde','firdaus@terbaik.org','bb952dff54f4f1fd4238cded9d6c3aed',1363284290,0,1,'New Member',12,1363284290,1363284600);
/*!40000 ALTER TABLE `uc_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-03-18 15:33:38
