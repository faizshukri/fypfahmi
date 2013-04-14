-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.20-log - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2013-04-14 15:39:02
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for table fyp2013.uc_checklist
DROP TABLE IF EXISTS `uc_checklist`;
CREATE TABLE IF NOT EXISTS `uc_checklist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `activity` varchar(150) DEFAULT NULL,
  `check` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Dumping data for table fyp2013.uc_checklist: ~10 rows (approximately)
/*!40000 ALTER TABLE `uc_checklist` DISABLE KEYS */;
INSERT INTO `uc_checklist` (`id`, `user_id`, `activity`, `check`) VALUES
	(1, 14, 'bismillah', NULL),
	(2, 13, 'sads', NULL),
	(3, 14, 'dvdf', NULL),
	(4, 14, 'aduhai', NULL),
	(5, 14, 'maskd', NULL),
	(6, 14, 'best gila', NULL),
	(7, 13, 'makan cendol', NULL),
	(8, 13, 'beli ubat nyamuk', NULL),
	(10, 11, 'reading', '{"2013":{"3":["4","5","6","13","14"],"4":null}}'),
	(11, 7, 'makan', '{"2013":{"4":["3","10","12"]}}'),
	(12, 8, 'Quran', '{"2013":{"4":["1","9"]}}');
/*!40000 ALTER TABLE `uc_checklist` ENABLE KEYS */;


-- Dumping structure for table fyp2013.uc_configuration
DROP TABLE IF EXISTS `uc_configuration`;
CREATE TABLE IF NOT EXISTS `uc_configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `value` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Dumping data for table fyp2013.uc_configuration: ~7 rows (approximately)
/*!40000 ALTER TABLE `uc_configuration` DISABLE KEYS */;
INSERT INTO `uc_configuration` (`id`, `name`, `value`) VALUES
	(1, 'website_name', 'HALUANSiswa Talent Management System'),
	(2, 'website_url', 'http://localhost/fypfahmi/'),
	(3, 'email', 'mediaXfahmi91@gmail.com'),
	(4, 'activation', 'false'),
	(5, 'resend_activation_threshold', '0'),
	(6, 'language', 'models/languages/en.php'),
	(7, 'template', 'models/site-templates/bootstrap.min.css');
/*!40000 ALTER TABLE `uc_configuration` ENABLE KEYS */;


-- Dumping structure for table fyp2013.uc_ipt
DROP TABLE IF EXISTS `uc_ipt`;
CREATE TABLE IF NOT EXISTS `uc_ipt` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ipt` varchar(255) DEFAULT NULL,
  `state_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- Dumping data for table fyp2013.uc_ipt: ~18 rows (approximately)
/*!40000 ALTER TABLE `uc_ipt` DISABLE KEYS */;
INSERT INTO `uc_ipt` (`id`, `ipt`, `state_id`) VALUES
	(1, 'Universiti Malaysia Perlis', 9),
	(2, 'Universiti Utara Malaysia', 2),
	(3, 'Universiti Sains Malaysia Kampus Induk', 7),
	(4, 'Universiti Teknologi PETRONAS', 8),
	(5, 'Universiti Islam Antarabangsa Malaysia', 10),
	(6, 'Universiti Teknikal Malaysia Melaka', 4),
	(7, 'Universiti Sains Islam Malaysia', 5),
	(8, 'Kolej Teknologi Darulnaim', 3),
	(9, 'Universiti Sultan Zainal Abidin', 11),
	(10, 'Universiti Malaysia Pahang', 6),
	(11, 'Universiti Teknologi Malaysia', 1),
	(12, 'Universiti Tun Hussein Onn Malaysia', 1),
	(14, 'Universiti Malaysia Sarawak', 13),
	(15, 'Universiti Multimedia', 16),
	(16, 'Cyberjaya University College of Medical Sciences', 16),
	(17, 'UniKL MIIT', 14),
	(18, 'Universiti Malaya', 14),
	(19, 'Universiti Malaysia Sabah', 12);
/*!40000 ALTER TABLE `uc_ipt` ENABLE KEYS */;


-- Dumping structure for table fyp2013.uc_pages
DROP TABLE IF EXISTS `uc_pages`;
CREATE TABLE IF NOT EXISTS `uc_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(150) NOT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

-- Dumping data for table fyp2013.uc_pages: ~42 rows (approximately)
/*!40000 ALTER TABLE `uc_pages` DISABLE KEYS */;
INSERT INTO `uc_pages` (`id`, `page`, `private`) VALUES
	(1, 'account.php', 1),
	(2, 'activate-account.php', 0),
	(3, 'admin_configuration.php', 1),
	(4, 'admin_page.php', 1),
	(5, 'admin_pages.php', 1),
	(6, 'admin_permission.php', 1),
	(7, 'admin_permissions.php', 1),
	(8, 'admin_user.php', 1),
	(9, 'admin_users.php', 1),
	(10, 'forgot-password.php', 0),
	(11, 'index.php', 1),
	(12, 'left-nav.php', 0),
	(13, 'login.php', 0),
	(14, 'logout.php', 1),
	(15, 'register.php', 1),
	(16, 'resend-activation.php', 0),
	(17, 'user_settings.php', 1),
	(18, 'example.php', 0),
	(19, 'main_menu.php', 0),
	(20, 'user_profiles.php', 1),
	(21, 'user_biodata.php', 1),
	(22, 'user_development.php', 0),
	(23, 'user_education.php', 1),
	(24, 'user_expertise.php', 0),
	(25, 'user_membership.php', 0),
	(26, 'mentee.php', 0),
	(27, 'calendar_checklist.php', 0),
	(28, 'development_add.php', 0),
	(29, 'development_add_ajax.php', 0),
	(30, 'development_fetchchecklist.php', 0),
	(31, 'development_monitor.php', 0),
	(32, 'menteelist.php', 0),
	(33, 'mentorlist.php', 0),
	(34, 'circleassign.php', 1),
	(35, 'searchlist.php', 1),
	(36, 'test.php', 0),
	(37, 'searchlist_ajax.php', 0),
	(38, 'searchlist_ajax_table.php', 0),
	(39, 'user_education_ajax.php', 0),
	(40, 'user_expertise_ajax.php', 0),
	(41, 'searchlist_ajax_mentor.php', 0),
	(42, 'searchlist_ajax_save_mentor.php', 0);
/*!40000 ALTER TABLE `uc_pages` ENABLE KEYS */;


-- Dumping structure for table fyp2013.uc_permissions
DROP TABLE IF EXISTS `uc_permissions`;
CREATE TABLE IF NOT EXISTS `uc_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table fyp2013.uc_permissions: ~3 rows (approximately)
/*!40000 ALTER TABLE `uc_permissions` DISABLE KEYS */;
INSERT INTO `uc_permissions` (`id`, `name`) VALUES
	(1, 'Member'),
	(2, 'Administrator'),
	(3, 'Mentor');
/*!40000 ALTER TABLE `uc_permissions` ENABLE KEYS */;


-- Dumping structure for table fyp2013.uc_permission_page_matches
DROP TABLE IF EXISTS `uc_permission_page_matches`;
CREATE TABLE IF NOT EXISTS `uc_permission_page_matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

-- Dumping data for table fyp2013.uc_permission_page_matches: ~34 rows (approximately)
/*!40000 ALTER TABLE `uc_permission_page_matches` DISABLE KEYS */;
INSERT INTO `uc_permission_page_matches` (`id`, `permission_id`, `page_id`) VALUES
	(1, 1, 1),
	(2, 1, 14),
	(3, 1, 17),
	(4, 2, 1),
	(5, 2, 3),
	(6, 2, 4),
	(7, 2, 5),
	(8, 2, 6),
	(9, 2, 7),
	(10, 2, 8),
	(11, 2, 9),
	(12, 2, 14),
	(13, 2, 17),
	(24, 3, 1),
	(25, 3, 11),
	(26, 3, 14),
	(27, 3, 17),
	(29, 3, 15),
	(30, 2, 15),
	(31, 3, 9),
	(32, 3, 8),
	(33, 1, 20),
	(34, 2, 20),
	(35, 3, 20),
	(36, 1, 21),
	(37, 2, 21),
	(38, 3, 21),
	(39, 1, 23),
	(40, 2, 23),
	(41, 3, 23),
	(42, 2, 34),
	(43, 3, 34),
	(44, 2, 35),
	(45, 3, 35);
/*!40000 ALTER TABLE `uc_permission_page_matches` ENABLE KEYS */;


-- Dumping structure for table fyp2013.uc_states
DROP TABLE IF EXISTS `uc_states`;
CREATE TABLE IF NOT EXISTS `uc_states` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `state` varchar(100) DEFAULT NULL,
  `zon_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- Dumping data for table fyp2013.uc_states: ~16 rows (approximately)
/*!40000 ALTER TABLE `uc_states` DISABLE KEYS */;
INSERT INTO `uc_states` (`id`, `state`, `zon_id`) VALUES
	(1, 'Johor', 4),
	(2, 'Kedah', 1),
	(3, 'Kelantan', 3),
	(4, 'Melaka', 4),
	(5, 'Negeri Sembilan', 4),
	(6, 'Pahang', 3),
	(7, 'Pulau Pinang', 1),
	(8, 'Perak', 1),
	(9, 'Perlis', 1),
	(10, 'Selangor', 2),
	(11, 'Terengganu', 3),
	(12, 'Sabah', 5),
	(13, 'Sarawak', 6),
	(14, 'Kuala Lumpur', 2),
	(15, 'Labuan', 5),
	(16, 'Putrajaya/Cyberjaya', 2);
/*!40000 ALTER TABLE `uc_states` ENABLE KEYS */;


-- Dumping structure for table fyp2013.uc_users
DROP TABLE IF EXISTS `uc_users`;
CREATE TABLE IF NOT EXISTS `uc_users` (
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- Dumping data for table fyp2013.uc_users: ~17 rows (approximately)
/*!40000 ALTER TABLE `uc_users` DISABLE KEYS */;
INSERT INTO `uc_users` (`id`, `user_name`, `display_name`, `password`, `email`, `activation_token`, `last_activation_request`, `lost_password_request`, `active`, `title`, `user_parent`, `sign_up_stamp`, `last_sign_in_stamp`) VALUES
	(1, 'fahmi', 'fahmi', 'a9bca882175d2f4fe8d0412af8d0ca83c9a6d73155e916fbbf5e8f157fb57dbb5', 'faizshukri90@gmail.com', '08207658a0fdb1f63a34f8769be4f1e3', 1363172411, 0, 1, 'New Member', 0, 1363172411, 1363734628),
	(2, 'faizshukri', 'faizshukri', '458d33e104443523bbeb60dc38038f79d0104fea09456ae9d237d0d7c485af8c9', 'faiz@outlook.com', '9c981bd4ca0597cd17048e80d8705ff8', 1363189142, 0, 1, 'New Member', 0, 1363189142, 0),
	(6, 'sdfsdf', 'vdfsf', '43ab8fc3c0a6456b542e03877670c1343ec0019c6c7bd266a63b92141dce76db2', 'dsfdsf@sedfef.com', 'b2878d534fd3bbfdcf83c33cd25be038', 1363192641, 0, 1, 'New Member', 0, 1363192641, 1363194385),
	(7, 'dgrger', 'dgerg', '1dc53e51ca1681c04f357b7f35fc16644c386097311f6341df1eeb57706696f27', 'sade@efew.com', '06fa520f46649a9815116b1385b4e32e', 1363192665, 0, 1, 'New Member', 6, 1363192665, 0),
	(8, 'doraemon', 'member2', 'e038a1619f62c123eac57c3df27a7b8cf24797aa67a5b4388625624ab226c3312', 'dvfdv@rferf.com', 'ad53635db6c61062a9f6ed971f9faf0e', 1363193019, 0, 1, 'New Member', 16, 1363193019, 1363223097),
	(9, 'faris', 'Faris', '8a3f078347db99a6d6b5fa9a8a95828d8f3019527af6e45569b99f7114fe10085', 'faris@gmail.com', 'ecfa28c42a23fe26cdbf22112e096a25', 1363226999, 0, 1, 'New Member', 10, 1363226999, 1365683448),
	(10, 'azizi', 'Azizi', '51c247bdedb746e21b3c0409bbc7011497fdf65596da382b070b11192b3782f27', 'azizi@gmail.com', 'ee4441dba40e84e8bfab9ed010fdb80d', 1363227030, 0, 1, 'New Member', 0, 1363227030, 1365683431),
	(11, 'zulowari', 'Zulfaqar', 'e1c4b29be98ce8b59d7666dca3fd910751c13ea27214109b799bb2b74a8f9d963', 'zul@gmail.com', '5b62b90da4a34c308b5e31f792b5c556', 1363227911, 0, 1, 'New Member', 10, 1363227911, 1365376427),
	(12, 'mentor', 'mentor1', '3e67a6018feb7de6eb7ce5d62101bccbb6cc7bceef9bda8949cb966ac04606d7f', 'mentor1@test.com', '660ea56cddb27aaf7f5d46e94ac9c7f8', 1363281587, 0, 1, 'New Member', 0, 1363281587, 1363534904),
	(13, 'radhi', 'radhi', '968dc5c147ce5b7c4dbb30f29bdf2dd410a0d6463e50f9682a5a16759c6ae50a6', 'radhi@khalid.org', '6ed2e086ede3683e1c9eb2ff56d1f1f1', 1363281719, 0, 1, 'New Member', 12, 1363281719, 1363534754),
	(14, 'firdaus', 'firdaus', '6c169ec4e022d502896fb609c28cdfe1ce6ac03757e01f921f9a1f326ac1f5dde', 'firdaus@terbaik.org', 'bb952dff54f4f1fd4238cded9d6c3aed', 1363284290, 0, 1, 'New Member', 12, 1363284290, 1363284600),
	(15, 'admin123', 'Admin', 'fa5d7615ff01499fafb4ea58962b54d07fc71da2eb40f588bace5f4d029e2cf63', 'admin@gmail.com', '89f8ca916b5163bbcfff1bb1c63216fe', 1363665672, 0, 1, 'New Member', 2, 1363665672, 1365907791),
	(16, 'mentor123', 'Mentor', 'fe3c26796bc0d08d91c8442e2957f0124d25d33377318f80c4a260cec0d2dbadc', 'mentor@gmail.com', '3fc662d27e46a1891637ce937f1703b8', 1363665796, 0, 1, 'New Member', 2, 1363665796, 1365923627),
	(17, 'member123', 'Member', '84f9378fd5bff4503b36e987891f3acea46f489eaf7bba563403dee6443154c37', 'member@gmail.com', 'e12668854bb89890db75f212fcd7f70f', 1363665819, 0, 1, 'New Member', 20, 1363665819, 1365924952),
	(18, 'fahmi1', 'fahmi1', '97e37a63a43012837c9d9069fea43ce50e93ddd9949ccba11a87ced5ecddade73', 'fahmi1@gmail.com', '8af000dc54257cad76238c7ccca15581', 1363761212, 0, 1, 'New Member', 12, 1363761212, 1363761220),
	(19, 'mentor100', 'Mentor100', 'e83c398b2121d99f7ead9f01dab9b4e4d5f91a8968d7d0521ae91e58d3734b41b', 'mentor100@gmail.com', '710b4ab61417bd2494b9049f5317293d', 1365907619, 0, 1, 'New Member', 0, 1365907619, 1365907672),
	(20, 'mentor110', 'Mentor110', 'e70a5b2638696659f03685ed450a35b8807a9f28986e287c019748a5c24644203', 'mentor110@gmail.com', 'd18549036e4fe9ad1a5f76d813833caf', 1365907660, 0, 1, 'New Member', 0, 1365907660, 0),
	(21, 'abuba', 'abubakar', 'ec05bb28872d674a4d6d44fa6e14fc34c6ee8b1d05a4e0304094d106041670a7a', 'abu@gmail.com', '75e1e6cd3df5052d8af5a2796aec15f2', 1365917122, 0, 1, 'New Member', 0, 1365917122, 1365917240);
/*!40000 ALTER TABLE `uc_users` ENABLE KEYS */;


-- Dumping structure for table fyp2013.uc_user_biodata
DROP TABLE IF EXISTS `uc_user_biodata`;
CREATE TABLE IF NOT EXISTS `uc_user_biodata` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `ic_no` varchar(255) DEFAULT NULL,
  `date_birth` datetime DEFAULT NULL,
  `contact` varchar(25) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Dumping data for table fyp2013.uc_user_biodata: ~13 rows (approximately)
/*!40000 ALTER TABLE `uc_user_biodata` DISABLE KEYS */;
INSERT INTO `uc_user_biodata` (`id`, `user_id`, `fullname`, `ic_no`, `date_birth`, `contact`, `address`, `city`, `state_id`) VALUES
	(1, 9, 'Member5', '999', '2013-03-24 05:44:26', '1234', 'yo', NULL, 2),
	(2, 11, 'Member4', '444', '2013-03-24 05:44:35', '2345', 'yo', NULL, 14),
	(3, 17, 'Member', '333', '2013-03-24 05:44:39', '3456', 'yo', NULL, 9),
	(4, 7, 'Member3', '65', '2013-03-24 06:53:23', '5345', 'tt', NULL, 3),
	(5, 8, 'Member2', '234', '2013-03-24 06:53:23', '34534', 'fgdg', NULL, 5),
	(6, 2, 'asdas', NULL, '2013-04-10 17:54:21', NULL, NULL, NULL, 3),
	(7, 6, 'fvf', NULL, '2013-04-10 17:54:23', NULL, NULL, NULL, 3),
	(8, 10, 'we', NULL, '2013-04-09 17:54:25', NULL, NULL, NULL, 4),
	(9, 12, 'wer', NULL, '2013-04-11 17:54:27', NULL, NULL, NULL, 4),
	(10, 19, 'Mentor100', '52526', '2013-04-14 10:49:24', NULL, NULL, NULL, 13),
	(11, 20, 'Mentor110', '435435', '2013-04-14 10:49:25', NULL, NULL, NULL, 9),
	(12, 16, 'Fggrt', '', '2013-04-02 00:00:00', '', '', '', 16),
	(13, 18, 'sdfregrtg', NULL, NULL, NULL, NULL, NULL, NULL),
	(14, 21, 'Abu Bakar', '3465768', '1990-04-10 00:00:00', '56765867', 'dfzbfgbf', 'gfntd', 10);
/*!40000 ALTER TABLE `uc_user_biodata` ENABLE KEYS */;


-- Dumping structure for table fyp2013.uc_user_data
DROP TABLE IF EXISTS `uc_user_data`;
CREATE TABLE IF NOT EXISTS `uc_user_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- Dumping data for table fyp2013.uc_user_data: ~16 rows (approximately)
/*!40000 ALTER TABLE `uc_user_data` DISABLE KEYS */;
INSERT INTO `uc_user_data` (`id`, `user_id`, `type`, `content`) VALUES
	(1, 1, 'user_profile', '{"biodata":"Fahmi Bin Fuad","education":"fdvrfg","expertise":"trgtr","development":"erger","membership":"esok lusa"}'),
	(2, 1, 'user_biodata', '{"fullname":"Fahmi Fuad","ic_no":"","dob":"","email":"","no_phone":"","address":"","city":"","state":""}'),
	(3, 1, 'user_education', '{"primary":{"sksd":"1997","ibn abbas":"2000"},"secondary":{"matri":"2003","ibn khaldun":"2006"},"high":{"mmu":{"year":"2008","course":"software"},"usm":{"year":"2014","course":"master"}}}'),
	(4, 1, 'user_skills', '{"hard":["1","2","3"],"soft":["a","b","c"]}'),
	(5, 9, 'user_biodata', '{"fullname":"","ic_no":"","dob":"","email":"xcvxcvxc","no_phone":"","address":"","city":"","state":"Johor"}'),
	(6, 13, 'user_biodata', '{"fullname":"Radhi Rahman","ic_no":"38965","dob":"03\\/17\\/1993","email":"radhi@khalid.org","no_phone":"983465","address":"jalan ampang","city":"ipoh","state":"Perak"}'),
	(7, 13, 'user_education', '{"primary":{"gfe":"546"},"secondary":{"fhjyj":"5675"},"high":{"thr":{"year":"6867","course":"tjyujry"}}}'),
	(8, 13, 'user_skills', '{"hard":["trh","ujy"],"soft":["he","lioyhn"]}'),
	(10, 13, 'user_reading', '["budaya membaca","terlihat di sana","bagus sangat2","dvdf","day after tomorrow"]'),
	(11, 14, 'user_reading', '["membaca","terbaiklah","hurm"]'),
	(12, 14, 'user_event', '["say you","seriously?"]'),
	(13, 13, 'user_event', '["skema 2012"]'),
	(14, 11, 'user_reading', '["Leadership by John C. Maxwell","Leadership"]'),
	(15, 17, 'user_skills', '{"Hard":{"22":"Videography"},"Soft":{"24":"Facilitating groups"}}'),
	(16, 9, 'user_skills', '{"Hard":{"25":"Graphic Design","26":"Videography"},"Soft":[]}'),
	(17, 9, 'user_event', '["Leadership Camp"]'),
	(18, 21, 'user_biodata', '{"fullname":"Abu Bakar","ic_no":"3465768","dob":"04\\/13\\/1993","email":"abu@gmail.com","no_phone":"23546657","address":"sdfgrdgrtg","city":"Tronoh","state":"Perak"}'),
	(19, 8, 'user_reading', '["Maza Ya\'ni","Milestones"]'),
	(20, 8, 'user_event', '["Baitul Muslim","Baitul Muslim 2"]');
/*!40000 ALTER TABLE `uc_user_data` ENABLE KEYS */;


-- Dumping structure for table fyp2013.uc_user_education
DROP TABLE IF EXISTS `uc_user_education`;
CREATE TABLE IF NOT EXISTS `uc_user_education` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('Primary','Secondary','Higher') DEFAULT NULL,
  `edu_place` varchar(255) DEFAULT NULL,
  `year` int(10) DEFAULT NULL,
  `course` varchar(255) DEFAULT '0',
  `user_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Dumping data for table fyp2013.uc_user_education: ~14 rows (approximately)
/*!40000 ALTER TABLE `uc_user_education` DISABLE KEYS */;
INSERT INTO `uc_user_education` (`id`, `type`, `edu_place`, `year`, `course`, `user_id`) VALUES
	(1, 'Primary', 'SKJ', 2001, '', 9),
	(2, 'Secondary', 'SMKJ', 2007, '', 9),
	(3, 'Higher', '12', 2012, 'ICT', 9),
	(4, 'Primary', 'SKSB', 2001, '', 17),
	(5, 'Secondary', 'SMKSB', 2007, '', 17),
	(6, 'Higher', '17', 2012, 'EE', 17),
	(7, 'Primary', 'SKT', 2002, '0', 11),
	(8, 'Secondary', 'SMKT', 2008, '0', 11),
	(9, 'Higher', '16', 2013, 'Medic', 11),
	(10, 'Higher', '6', 2011, '0', 7),
	(11, 'Higher', '2', 2010, '0', 8),
	(12, 'Higher', '7', 2012, '0', 8),
	(13, 'Primary', 'SK2', 2003, '', 9),
	(14, 'Secondary', 'SMKJ2', 2010, '', 9);
/*!40000 ALTER TABLE `uc_user_education` ENABLE KEYS */;


-- Dumping structure for table fyp2013.uc_user_permission_matches
DROP TABLE IF EXISTS `uc_user_permission_matches`;
CREATE TABLE IF NOT EXISTS `uc_user_permission_matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- Dumping data for table fyp2013.uc_user_permission_matches: ~17 rows (approximately)
/*!40000 ALTER TABLE `uc_user_permission_matches` DISABLE KEYS */;
INSERT INTO `uc_user_permission_matches` (`id`, `user_id`, `permission_id`) VALUES
	(1, 1, 2),
	(5, 2, 3),
	(8, 6, 3),
	(9, 7, 1),
	(10, 8, 1),
	(13, 9, 1),
	(14, 10, 3),
	(15, 11, 1),
	(16, 12, 3),
	(17, 13, 1),
	(18, 14, 1),
	(19, 15, 2),
	(20, 16, 3),
	(21, 17, 1),
	(22, 18, 3),
	(23, 19, 3),
	(24, 20, 3),
	(25, 21, 3);
/*!40000 ALTER TABLE `uc_user_permission_matches` ENABLE KEYS */;


-- Dumping structure for table fyp2013.uc_user_skills
DROP TABLE IF EXISTS `uc_user_skills`;
CREATE TABLE IF NOT EXISTS `uc_user_skills` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `type` enum('Hard','Soft') DEFAULT NULL,
  `skill_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- Dumping data for table fyp2013.uc_user_skills: ~5 rows (approximately)
/*!40000 ALTER TABLE `uc_user_skills` DISABLE KEYS */;
INSERT INTO `uc_user_skills` (`id`, `user_id`, `type`, `skill_name`) VALUES
	(22, 17, 'Hard', 'Videography'),
	(24, 17, 'Soft', 'Facilitating groups'),
	(25, 9, 'Hard', 'Graphic Design'),
	(26, 9, 'Hard', 'Videography'),
	(27, 9, 'Hard', 'Video Editing');
/*!40000 ALTER TABLE `uc_user_skills` ENABLE KEYS */;


-- Dumping structure for table fyp2013.uc_zones
DROP TABLE IF EXISTS `uc_zones`;
CREATE TABLE IF NOT EXISTS `uc_zones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `zone` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table fyp2013.uc_zones: ~6 rows (approximately)
/*!40000 ALTER TABLE `uc_zones` DISABLE KEYS */;
INSERT INTO `uc_zones` (`id`, `zone`) VALUES
	(1, 'Northern'),
	(2, 'Central'),
	(3, 'Eastern'),
	(4, 'Southern'),
	(5, 'Sabah'),
	(6, 'Sarawak');
/*!40000 ALTER TABLE `uc_zones` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
