-- MySQL dump 10.13  Distrib 5.7.27, for Linux (x86_64)
--
-- Host: localhost    Database: bharyang_infinity
-- ------------------------------------------------------
-- Server version	5.7.27

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
-- Table structure for table `admin_video_images`
--

DROP TABLE IF EXISTS `admin_video_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_video_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_video_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_default` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_video_images`
--

LOCK TABLES `admin_video_images` WRITE;
/*!40000 ALTER TABLE `admin_video_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_video_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_videos`
--

DROP TABLE IF EXISTS `admin_videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_videos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL,
  `video` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trailer_video` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `default_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `banner_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ratings` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reviews` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_approved` int(11) NOT NULL,
  `is_home_slider` int(11) NOT NULL DEFAULT '0',
  `is_banner` int(11) NOT NULL,
  `uploaded_by` enum('admin','moderator','user','other') COLLATE utf8_unicode_ci NOT NULL,
  `publish_time` datetime NOT NULL,
  `duration` time NOT NULL,
  `edited_by` enum('admin','moderator','user','other') COLLATE utf8_unicode_ci NOT NULL,
  `watch_count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `video_type` int(11) NOT NULL,
  `video_upload_type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_videos`
--

LOCK TABLES `admin_videos` WRITE;
/*!40000 ALTER TABLE `admin_videos` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_videos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_activated` int(11) NOT NULL,
  `gender` enum('male','female','others') COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `paypal_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token_expiry` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timezone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` (`id`, `name`, `email`, `password`, `picture`, `description`, `is_activated`, `gender`, `mobile`, `paypal_email`, `address`, `token`, `token_expiry`, `remember_token`, `timezone`, `created_at`, `updated_at`) VALUES (1,'Admin','admin@infinity.com','$2y$10$LFUsKL7gFZf2Gxx89ehRWOnSAwqJ/HRvGtmKYaaFPSaeeQWlI0RS2','https://bharyang.com.np/infinity/uploads/0302d161dbc04be7aae350bd81c440b908cef049.png','',1,'male','9851234196','','Baneshwor','2y10GO14sFaootgxaFxgGNbY3Tc9YT44FYErH1eLUYrVkGR7czWMm2','1567325366','pLXzVMXJWb0TkdOc05N30bg9jHguzPlmJvssOAzhh47qDsm2nxWndt2Lz4jh','Asia/Kathmandu','2017-08-05 04:02:43','2019-08-02 00:09:26'),(2,'Test','test@streamhash.com','$2y$10$h.3BkdXzIqehzpWEtGrTNuur5D1IbrxPhlXjfy8XRe9klI5ZUExQe','http://adminview.streamhash.com/placeholder.png','',0,'male','','','','','',NULL,'','2017-08-05 04:02:43','2017-08-05 04:02:43');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_series` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_approved` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `name`, `picture`, `is_series`, `status`, `is_approved`, `created_by`, `created_at`, `updated_at`) VALUES (1,'Saregama','https://bharyang.com.np/infinity/uploads/2cfba0b3352ba18dfa0bcf0e605226c7201aa5eb.png',0,'1',1,0,'2019-08-01 01:42:57','2019-08-01 01:42:57');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genres`
--

DROP TABLE IF EXISTS `genres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `genres` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `is_approved` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genres`
--

LOCK TABLES `genres` WRITE;
/*!40000 ALTER TABLE `genres` DISABLE KEYS */;
/*!40000 ALTER TABLE `genres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_reserved_reserved_at_index` (`queue`,`reserved`,`reserved_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2015_08_25_172600_create_settings_table',1),('2016_07_25_142335_create_admins_table',1),('2016_07_28_111853_create_categories_table',1),('2016_07_28_111900_create_sub_categories_table',1),('2016_07_28_113237_create_sub_category_images_table',1),('2016_07_30_033554_add_is_series_field_to_categories_table',1),('2016_07_30_040800_create_admin_videos_table',1),('2016_07_30_040833_create_admin_video_images_table',1),('2016_07_30_132812_create_genres_table',1),('2016_07_31_140521_add_genre_id_to_admin_videos_table',1),('2016_08_01_151115_add_status_to_admin_videos_table',1),('2016_08_02_030955_add_is_approved_to_categories_table',1),('2016_08_02_031030_add_is_approved_to_sub_categories_table',1),('2016_08_02_031053_add_is_approved_genres_table',1),('2016_08_02_031301_add_is_approved_admin_videos_table',1),('2016_08_02_134552_create_user_ratings_table',1),('2016_08_02_143110_create_wishlists_table',1),('2016_08_02_144545_create_user_histories_table',1),('2016_08_02_152202_add_default_image_to_admin_videos_table',1),('2016_08_02_154250_add_watch_count_to_admin_videos_table',1),('2016_08_07_122712_create_pages_table',1),('2016_08_08_091037_add_publish_time_to_admin_videos_table',1),('2016_08_13_075844_add_video_type-to_admin_videos_table',1),('2016_08_13_083130_add_video_upload_type-to_admin_videos_table',1),('2016_08_14_042749_add_description_as_text_type',1),('2016_08_16_035007_add_is_moderator_to_users_table',1),('2016_08_19_134019_create_user_payments_table',1),('2016_08_19_182650_add_is_paid_to_users',1),('2016_08_26_065631_add_duration_to_admin_videos',1),('2016_08_29_064138_change_device_type_in_users_table',1),('2016_08_31_194838_change_video_id_in_admin_video_images',1),('2016_09_02_133843_add_is_home_slider_to_admin_videos',1),('2016_09_15_070030_create_jobs_table',1),('2016_09_15_070051_create_failed_jobs_table',1),('2016_09_15_163652_add_is_banner_to_admin_videos_table',1),('2016_09_23_180525_add_push_status_users_table',1),('2016_09_29_103536_change_login_by_users',1),('2017_07_22_124047_added_timezone_field_in_admins',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `heading` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('about','privacy','terms') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` (`id`, `heading`, `description`, `type`, `created_at`, `updated_at`) VALUES (1,'Audition','For audition of Tiktok Star.','','2019-07-25 04:08:42','2019-07-25 04:08:42');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `settings_key_index` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (1,'site_name','Infinity Audition',NULL,'2019-07-25 03:06:16'),(2,'site_logo','http://bharyang.com.np/infinity/uploads/6df140e0e804ddf3d160687221fa23655cbcad1c.png',NULL,'2019-08-01 02:03:01'),(3,'site_icon','http://bharyang.com.np/infinity/uploads/0961791724c1bdcd1eaa9c47129e78d0936f7643.jpg',NULL,'2019-08-01 02:03:01'),(4,'tag_name','',NULL,NULL),(5,'paypal_email','',NULL,NULL),(6,'browser_key','',NULL,NULL),(7,'default_lang','en',NULL,NULL),(8,'currency','$',NULL,NULL),(9,'streaming_url','',NULL,NULL),(10,'admin_take_count','12',NULL,NULL),(11,'installation_process','0',NULL,NULL),(12,'admin_delete_control','0',NULL,NULL),(13,'JWPLAYER_KEY','M2NCefPoiiKsaVB8nTttvMBxfb1J3Xl7PDXSaw==',NULL,NULL),(14,'HLS_STREAMING_URL','',NULL,NULL),(15,'header_scripts','',NULL,NULL),(16,'body_scripts','',NULL,NULL),(17,'demo_admin_email','admin@streamhash.com',NULL,NULL),(18,'demo_admin_password','123456',NULL,NULL),(19,'copyrights_url','',NULL,NULL),(20,'post_max_size','2M',NULL,NULL),(21,'upload_max_size','2M',NULL,NULL);
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_categories`
--

DROP TABLE IF EXISTS `sub_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sub_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_approved` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_categories`
--

LOCK TABLES `sub_categories` WRITE;
/*!40000 ALTER TABLE `sub_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `sub_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_category_images`
--

DROP TABLE IF EXISTS `sub_category_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sub_category_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sub_category_id` int(11) NOT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_category_images`
--

LOCK TABLES `sub_category_images` WRITE;
/*!40000 ALTER TABLE `sub_category_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `sub_category_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_histories`
--

DROP TABLE IF EXISTS `user_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_histories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `admin_video_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_histories`
--

LOCK TABLES `user_histories` WRITE;
/*!40000 ALTER TABLE `user_histories` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_payments`
--

DROP TABLE IF EXISTS `user_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `payment_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` double(8,2) NOT NULL,
  `expiry_date` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_payments`
--

LOCK TABLES `user_payments` WRITE;
/*!40000 ALTER TABLE `user_payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_ratings`
--

DROP TABLE IF EXISTS `user_ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_ratings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `admin_video_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_ratings`
--

LOCK TABLES `user_ratings` WRITE;
/*!40000 ALTER TABLE `user_ratings` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token_expiry` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `device_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `device_type` enum('android','ios','web') COLLATE utf8_unicode_ci NOT NULL,
  `login_by` enum('manual','facebook','twitter','google','linkedin') COLLATE utf8_unicode_ci NOT NULL,
  `social_unique_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fb_lg` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gl_lg` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_activated` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `push_status` int(11) NOT NULL,
  `user_type` int(11) NOT NULL,
  `is_moderator` int(11) NOT NULL,
  `moderator_id` int(11) NOT NULL,
  `gender` enum('male','female','others') COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `latitude` double(15,8) NOT NULL,
  `longitude` double(15,8) NOT NULL,
  `paypal_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `picture`, `token`, `token_expiry`, `device_token`, `device_type`, `login_by`, `social_unique_id`, `fb_lg`, `gl_lg`, `description`, `is_activated`, `status`, `push_status`, `user_type`, `is_moderator`, `moderator_id`, `gender`, `mobile`, `latitude`, `longitude`, `paypal_email`, `address`, `remember_token`, `created_at`, `updated_at`) VALUES (1,'User','user@streamhash.com','$2y$10$WmXVsomXG7aJkyYh38u9jeMkrOjoQNKuiXBNa09R7kE0.ecmi7qxG','http://lite.streamhash.com/placeholder.png','2y106b0pPxgvUJGiQKRMohHMWspa5EpwWEFRvLlk0hC556pHpJ6Bny','1566644232','','android','manual','','','','',1,1,0,1,0,0,'male','9843419254',0.00000000,0.00000000,'','',NULL,'2017-08-05 04:02:43','2019-07-25 02:57:12'),(2,'Test','test@streamhash.com','$2y$10$7flX20oQoh/SRp6rnlD9PeFJTL/QoYSz2yb4FfsfDHveVFpC9Z83C','http://lite.streamhash.com/placeholder.png','','','','android','manual','','','','',0,1,0,1,0,0,'male','',0.00000000,0.00000000,'','',NULL,'2017-08-05 04:02:43','2017-08-05 04:02:43');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishlists`
--

DROP TABLE IF EXISTS `wishlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wishlists` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `admin_video_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlists`
--

LOCK TABLES `wishlists` WRITE;
/*!40000 ALTER TABLE `wishlists` DISABLE KEYS */;
/*!40000 ALTER TABLE `wishlists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'bharyang_infinity'
--

--
-- Dumping routines for database 'bharyang_infinity'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-08-04 14:20:09
