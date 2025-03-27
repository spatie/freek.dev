/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `ads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ads` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `display_on_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `starts_at` date NOT NULL,
  `ends_at` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `html` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `comment_notification_subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comment_notification_subscriptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `commentable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commentable_id` bigint unsigned NOT NULL,
  `subscriber_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subscriber_id` bigint unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cn_subscriptions_commentable` (`commentable_type`,`commentable_id`),
  KEY `cn_subscriptions_subscriber` (`subscriber_type`,`subscriber_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `commentator_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commentator_id` bigint unsigned DEFAULT NULL,
  `commentable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commentable_id` bigint unsigned NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `original_text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `extra` json DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `commentator_comments` (`commentator_type`,`commentator_id`),
  KEY `comments_commentable_type_commentable_id_index` (`commentable_type`,`commentable_id`),
  KEY `comments_parent_id_foreign` (`parent_id`),
  CONSTRAINT `comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` text COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `links` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `publish_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `links_user_id_foreign` (`user_id`),
  CONSTRAINT `links_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` bigint unsigned NOT NULL,
  `manipulations` json NOT NULL,
  `custom_properties` json NOT NULL,
  `responsive_images` json NOT NULL,
  `order_column` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conversions_disk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `generated_conversions` json NOT NULL,
  PRIMARY KEY (`id`),
  KEY `media_model_type_model_id_index` (`model_type`,`model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `monitored_scheduled_task_log_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `monitored_scheduled_task_log_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `monitored_scheduled_task_id` bigint unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_scheduled_task_id` (`monitored_scheduled_task_id`),
  CONSTRAINT `fk_scheduled_task_id` FOREIGN KEY (`monitored_scheduled_task_id`) REFERENCES `monitored_scheduled_tasks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `monitored_scheduled_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `monitored_scheduled_tasks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cron_expression` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ping_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_started_at` datetime DEFAULT NULL,
  `last_finished_at` datetime DEFAULT NULL,
  `last_failed_at` datetime DEFAULT NULL,
  `last_skipped_at` datetime DEFAULT NULL,
  `registered_on_oh_dear_at` datetime DEFAULT NULL,
  `last_pinged_at` datetime DEFAULT NULL,
  `grace_time_in_minutes` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci,
  `publish_date` datetime DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `tweet_sent` tinyint(1) NOT NULL DEFAULT '0',
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Freek Van der Herten',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `original_content` tinyint(1) NOT NULL DEFAULT '0',
  `external_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tweet_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submitted_by_user_id` int unsigned DEFAULT NULL,
  `send_automated_tweet` tinyint(1) NOT NULL DEFAULT '1',
  `preview_secret` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `series_slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_twitter_handle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `html` longtext COLLATE utf8mb4_unicode_ci,
  `toot_sent` tinyint(1) NOT NULL DEFAULT '0',
  `posted_on_bluesky` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_submitted_by_user_id_foreign` (`submitted_by_user_id`),
  KEY `posts_series_slug_index` (`series_slug`),
  CONSTRAINT `posts_submitted_by_user_id_foreign` FOREIGN KEY (`submitted_by_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `reactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `commentator_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commentator_id` bigint unsigned DEFAULT NULL,
  `comment_id` bigint unsigned NOT NULL,
  `reaction` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `commentator_reactions` (`commentator_type`,`commentator_id`),
  KEY `reactions_comment_id_foreign` (`comment_id`),
  CONSTRAINT `reactions_comment_id_foreign` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `redirects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `redirects` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `old_url` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `new_url` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `site_search_configs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_search_configs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `crawl_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `index_base_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `driver_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extra` json DEFAULT NULL,
  `index_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pending_index_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crawling_started_at` datetime DEFAULT NULL,
  `crawling_ended_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `number_of_urls_indexed` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `taggables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `taggables` (
  `tag_id` int unsigned NOT NULL,
  `taggable_id` int unsigned NOT NULL,
  `taggable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `taggables_tag_id_foreign` (`tag_id`),
  CONSTRAINT `taggables_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tags` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_column` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `talks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `talks` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `presented_at` timestamp NOT NULL,
  `video_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slides_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `joindin_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `twitter_handle` text COLLATE utf8mb4_unicode_ci,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `videos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `embed` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `html` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `webhook_calls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `webhook_calls` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci,
  `exception` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `external_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `headers` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `webhook_calls_external_id_index` (`external_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'2014_10_12_000000_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'2014_10_12_100000_create_password_resets_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'2017_11_09_230412_create_posts_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'2017_11_09_232031_create_tag_tables',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2017_11_10_122115_create_redirects_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'2017_11_11_100752_create_talks_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'2017_11_18_221009_add_original_content_field',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'2018_01_01_205001_create_ads_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'2018_06_03_112535_add_external_url_field_to_posts_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10,'2018_09_01_070433_make_display_on_url_nullable',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11,'2018_10_07_202438_make_publish_date_nullable',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'2019_05_23_150453_remove_wp_post_name_from_posts_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2019_05_29_091016_create_failed_jobs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14,'2019_06_03_194225_create_videos_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15,'2019_07_08_194206_create_webhook_calls_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16,'2019_07_08_220609_create_webmentions_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17,'2019_07_13_212037_add_twitter_fields_to_posts_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (18,'2019_07_13_223522_remove_medium_field_on_post_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (19,'2019_07_14_000520_add_index_on_webmentions_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (20,'2019_08_03_174519_create_newsletters_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (21,'2019_11_08_091425_create_mailcoach_tables',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (22,'2019_11_08_230505_create_media_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (23,'2019_12_04_224331_drop_newsletters_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (24,'2019_12_14_000001_create_personal_access_tokens_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (25,'2020_01_16_082422_add_admin_field_to_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (26,'2020_01_16_082611_create_links_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (27,'2020_01_16_154148_add_submitted_by_user_id',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (28,'2020_01_16_155225_add_twitter_handle_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (29,'2020_02_05_095017_make_text_fields_optional',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (30,'2020_03_08_225350_update_mailcoach_tables_to_v2',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (31,'2020_03_23_161756_add_send_automated_tweet_field_to_posts_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (32,'2020_03_30_092732_add_structured_html_field_to_mailcoach_templates_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (33,'2020_07_08_201437_create_schedule_monitor_tables',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (34,'2020_08_22_212650_add_preview_secret_to_posts_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (35,'2020_09_09_143704_add_uuid_to_failed_jobs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (36,'2020_09_28_090308_create_job_batches_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (37,'2020_09_28_090330_upgrade_mailcoach_tables_to_v3',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (38,'2020_09_28_115458_add_processed_at_column_to_webhook_calls_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (39,'2020_09_28_135005_add_send_batch_id_to_mailcoach_campaigns_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (40,'2020_09_29_230058_add_timezone_field_to_monitored_scheduled_tasks_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (41,'2020_10_07_220923_upgrade_mediaLibrary_to_v8',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (42,'2020_10_13_082250_add_series_slug_to_posts_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (43,'2020_10_19_215616_drop_unused_posts_fields',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (44,'2020_10_19_220050_add_twitter_handle_to_posts_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (45,'2021_03_10_100727_upgrade_mailcoach_v3_to_v4',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (46,'2021_03_12_111811_add_mailcoach_link_column',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (47,'2021_04_13_142256_add_generated_conversions_field_to_media_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (48,'2021_07_10_170644_add_html_fields',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (49,'2021_10_17_130916_create_site_search_configs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (50,'2021_10_19_105804_add_site_search_field',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (51,'2021_11_26_155055_create_health_tables',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (52,'2021_12_06_195236_drop_health_tables',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (53,'2022_02_10_200107_upgrade_to_mailcoach_v5',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (54,'2022_02_10_202830_update_webhooks_calls_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (55,'2022_02_11_162116_add_headers_column_to_webhook_calls_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (56,'2022_03_08_161156_create_comments_tables',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (57,'2022_05_23_184516_add_email_verified_at_to_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (58,'2022_09_25_104831_drop_local_mailcoach_tables',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (59,'2022_11_11_201128_add_toot_sent_column',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (60,'2023_10_03_222142_drop_webmentions_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (61,'2024_11_29_092342_add_posted_on_bluesky_at_field_to_posts_table',1);
