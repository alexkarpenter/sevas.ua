-- MySQL dump 10.13  Distrib 5.5.32, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: spravka_db
-- ------------------------------------------------------
-- Server version	5.5.32-0ubuntu0.12.04.1

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
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcatparent` int(11) DEFAULT NULL,
  `name` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `descr` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `path` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pathfull` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `level` int(11) NOT NULL,
  `weight` int(11) DEFAULT NULL,
  `options` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `root` int(10) unsigned DEFAULT NULL,
  `lft` int(10) unsigned NOT NULL,
  `rgt` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idcatparent_idx` (`idcatparent`),
  KEY `root` (`root`),
  KEY `lft` (`lft`),
  KEY `rgt` (`rgt`),
  KEY `level` (`level`),
  KEY `pathfull` (`pathfull`(255)),
  CONSTRAINT `category_idcatparent_category_idcat` FOREIGN KEY (`idcatparent`) REFERENCES `category` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=297 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `file`
--

DROP TABLE IF EXISTS `file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `title` varchar(256) DEFAULT NULL,
  `descr` varchar(1024) DEFAULT NULL,
  `path` varchar(128) NOT NULL,
  `type` varchar(45) NOT NULL,
  `size` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `newssevas_stat`
--

DROP TABLE IF EXISTS `newssevas_stat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newssevas_stat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video` int(11) NOT NULL DEFAULT '0',
  `picture` int(11) NOT NULL DEFAULT '0',
  `name` varchar(200) NOT NULL DEFAULT '0',
  `name_bread` text NOT NULL,
  `name_h1` text NOT NULL,
  `data` int(11) NOT NULL DEFAULT '0',
  `text_description` text NOT NULL,
  `text` mediumtext NOT NULL,
  `alter_name` varchar(200) NOT NULL,
  `alter_name_category` varchar(255) NOT NULL,
  `title` varchar(200) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  `meta` text NOT NULL,
  `fl_block` int(10) NOT NULL DEFAULT '0',
  `img` text NOT NULL,
  `img_description` varchar(250) NOT NULL,
  `grid` int(11) NOT NULL DEFAULT '0',
  `name_category` varchar(255) NOT NULL,
  `upload_dir` varchar(255) NOT NULL,
  `col_com` int(11) NOT NULL DEFAULT '0',
  `col_veiw` int(11) NOT NULL DEFAULT '0',
  `other_stat` varchar(200) NOT NULL,
  `ordernum` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `coordinates` varchar(150) NOT NULL DEFAULT '',
  `coordinates_title` text,
  `coordinates_zoom` int(11) NOT NULL,
  `template` int(11) NOT NULL,
  `unpublished` int(1) NOT NULL,
  `images_watermarked` text NOT NULL,
  `link_to_other` text NOT NULL,
  `spravka_element` text NOT NULL,
  `not_comment` int(11) NOT NULL DEFAULT '0',
  `no-access` int(11) NOT NULL DEFAULT '0',
  `tomain` int(11) NOT NULL,
  `imgmain` text NOT NULL,
  `golos_up` int(11) NOT NULL,
  `golos_down` int(11) NOT NULL,
  `id_users` text NOT NULL,
  `spravka_link` text NOT NULL,
  `link_to_afisha` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=659 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `org_category`
--

DROP TABLE IF EXISTS `org_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `org_category` (
  `idorg` int(11) NOT NULL DEFAULT '0',
  `idcat` int(11) NOT NULL DEFAULT '0',
  `primaryc` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`idorg`,`idcat`),
  KEY `org_category_idcat_category_idcat` (`idcat`),
  CONSTRAINT `org_category_idcat_category_idcat` FOREIGN KEY (`idcat`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  CONSTRAINT `org_category_idorg_organization_idorg` FOREIGN KEY (`idorg`) REFERENCES `organization` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `org_files`
--

DROP TABLE IF EXISTS `org_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `org_files` (
  `org_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  KEY `fk_org_files_org_idx` (`org_id`),
  KEY `fk_org_files_file_idx` (`file_id`),
  CONSTRAINT `fk_org_files_file` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_org_files_org` FOREIGN KEY (`org_id`) REFERENCES `organization` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `org_tag`
--

DROP TABLE IF EXISTS `org_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `org_tag` (
  `org_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  KEY `fk_org_tag_org_idx` (`org_id`),
  KEY `fk_org_tag_tag_idx` (`tag_id`),
  CONSTRAINT `fk_org_tag_org` FOREIGN KEY (`org_id`) REFERENCES `organization` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_org_tag_tag` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `organization`
--

DROP TABLE IF EXISTS `organization`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `name_h1` varchar(300) NOT NULL,
  `slug` varchar(255) NOT NULL COMMENT 'chpu',
  `address` varchar(256) NOT NULL,
  `phone` varchar(256) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `site` varchar(128) DEFAULT NULL,
  `anonse` varchar(1024) NOT NULL,
  `descr` text NOT NULL,
  `geocoder` tinyint(1) DEFAULT '1',
  `geoexact` tinyint(1) DEFAULT NULL,
  `geolat` double DEFAULT NULL,
  `geolon` double DEFAULT NULL,
  `options` varchar(1024) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `checked` tinyint(1) DEFAULT NULL,
  `id_owner` int(11) DEFAULT NULL,
  `idcatprimary` int(11) DEFAULT NULL,
  `seo_title` varchar(256) DEFAULT NULL,
  `seo_keywords` varchar(256) DEFAULT NULL,
  `seo_description` text,
  `views` int(11) NOT NULL DEFAULT '0',
  `image_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_UNIQUE` (`slug`),
  KEY `fk_organization_file_idx` (`image_id`),
  CONSTRAINT `fk_organization_file` FOREIGN KEY (`image_id`) REFERENCES `file` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22335 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-10-05 23:55:08
