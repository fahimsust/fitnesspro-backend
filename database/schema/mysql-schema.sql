/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `accessories_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accessories_fields` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=select menu, 2=radio options, 3=checkboxes',
  `required` tinyint(1) NOT NULL,
  `select_display` varchar(65) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'select menu default display before option is selected',
  `select_auto` tinyint(1) NOT NULL COMMENT 'should the first option be auto selected',
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `accessories_fields_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accessories_fields_products` (
  `accessories_fields_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rank` int NOT NULL,
  `price_adjust_type` tinyint(1) NOT NULL COMMENT '1=adjust this price, 2=adjust parent price',
  `price_adjust_calc` tinyint(1) NOT NULL COMMENT '1=flat amount, 2=percentage',
  `price_adjust_amount` decimal(8,2) NOT NULL,
  UNIQUE KEY `accessories_fields_id_2` (`accessories_fields_id`,`product_id`),
  KEY `accessories_fields_id` (`accessories_fields_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `accessories_fields_products_accessories_fields_id_foreign` FOREIGN KEY (`accessories_fields_id`) REFERENCES `accessories_fields` (`id`),
  CONSTRAINT `accessories_fields_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `account_ads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `account_ads` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `account_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `clicks` int NOT NULL,
  `shown` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `maa_account_id` (`account_id`),
  CONSTRAINT `mods_account_ads_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `account_ads_campaigns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `account_ads_campaigns` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lastshown_ad` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `account_ads_clicks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `account_ads_clicks` (
  `ad_id` bigint unsigned DEFAULT NULL,
  `clicked` datetime NOT NULL,
  KEY `maac_ad_id` (`ad_id`),
  CONSTRAINT `mods_account_ads_clicks_ad_id_foreign` FOREIGN KEY (`ad_id`) REFERENCES `account_ads` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `account_certifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `account_certifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `account_id` bigint unsigned DEFAULT NULL,
  `cert_num` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cert_exp` date DEFAULT NULL,
  `cert_type` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cert_org` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approval_status` tinyint(1) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id_2` (`account_id`,`approval_status`),
  KEY `mac_account_id` (`account_id`),
  CONSTRAINT `mods_account_certifications_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `account_certifications_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `account_certifications_files` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `certification_id` bigint unsigned NOT NULL,
  `filename` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uploaded` datetime DEFAULT NULL,
  `approval_status` tinyint(1) NOT NULL,
  `site_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `certification_id_2` (`certification_id`,`approval_status`),
  KEY `certification_id` (`certification_id`),
  KEY `mods_account_certifications_files_site_id_foreign` (`site_id`),
  CONSTRAINT `mods_account_certifications_files_certification_id_foreign` FOREIGN KEY (`certification_id`) REFERENCES `account_certifications` (`id`),
  CONSTRAINT `mods_account_certifications_files_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `account_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `account_files` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `account_id` bigint unsigned NOT NULL,
  `filename` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uploaded` datetime NOT NULL,
  `site_id` bigint unsigned NOT NULL,
  `approval_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mods_account_files_account_id_foreign` (`account_id`),
  KEY `mods_account_files_site_id_foreign` (`site_id`),
  CONSTRAINT `mods_account_files_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `mods_account_files_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `lastlogin_at` timestamp NULL DEFAULT NULL,
  `status_id` bigint unsigned NOT NULL,
  `type_id` bigint unsigned NOT NULL DEFAULT '1',
  `default_billing_id` bigint unsigned DEFAULT NULL,
  `default_shipping_id` bigint unsigned DEFAULT NULL,
  `affiliate_id` bigint unsigned DEFAULT NULL,
  `cim_profile_id` bigint unsigned DEFAULT NULL,
  `first_name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `photo_id` bigint unsigned DEFAULT NULL,
  `site_id` bigint unsigned DEFAULT NULL,
  `loyaltypoints_id` bigint unsigned DEFAULT NULL,
  `profile_public` tinyint(1) NOT NULL DEFAULT '1',
  `send_verify_email` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = allow, 1=disallow',
  `last_verify_attempt_date` date DEFAULT NULL,
  `membership_status` tinyint(1) NOT NULL DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `account_status_id` (`status_id`),
  KEY `accounts_affiliate_id_foreign` (`affiliate_id`),
  KEY `accounts_cim_profile_id_foreign` (`cim_profile_id`),
  KEY `accounts_photo_id_foreign` (`photo_id`),
  KEY `accounts_site_id_foreign` (`site_id`),
  KEY `accounts_loyaltypoints_id_foreign` (`loyaltypoints_id`),
  KEY `accounts_default_billing_id_foreign` (`default_billing_id`),
  KEY `accounts_default_shipping_id_foreign` (`default_shipping_id`),
  CONSTRAINT `accounts_affiliate_id_foreign` FOREIGN KEY (`affiliate_id`) REFERENCES `affiliates` (`id`),
  CONSTRAINT `accounts_cim_profile_id_foreign` FOREIGN KEY (`cim_profile_id`) REFERENCES `cim_profile` (`id`),
  CONSTRAINT `accounts_default_billing_id_foreign` FOREIGN KEY (`default_billing_id`) REFERENCES `accounts_addressbook` (`id`),
  CONSTRAINT `accounts_default_shipping_id_foreign` FOREIGN KEY (`default_shipping_id`) REFERENCES `accounts_addressbook` (`id`),
  CONSTRAINT `accounts_loyaltypoints_id_foreign` FOREIGN KEY (`loyaltypoints_id`) REFERENCES `loyaltypoints` (`id`),
  CONSTRAINT `accounts_photo_id_foreign` FOREIGN KEY (`photo_id`) REFERENCES `photos` (`id`),
  CONSTRAINT `accounts_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `accounts_addressbook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts_addressbook` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `account_id` bigint unsigned DEFAULT NULL,
  `is_billing` tinyint(1) NOT NULL,
  `is_shipping` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `address_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `accounts_addressbook_address_id_foreign` (`address_id`),
  CONSTRAINT `accounts_addressbook_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `accounts_addressbook_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `accounts_addtl_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts_addtl_fields` (
  `account_id` bigint unsigned DEFAULT NULL,
  `form_id` bigint unsigned DEFAULT NULL,
  `section_id` bigint unsigned DEFAULT NULL,
  `field_id` bigint unsigned NOT NULL,
  `field_value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  UNIQUE KEY `aaf_account_id_2` (`account_id`,`form_id`,`section_id`,`field_id`),
  KEY `aaf_account_id` (`account_id`),
  KEY `accounts_addtl_fields_field_id_foreign` (`field_id`),
  KEY `accounts_addtl_fields_section_id_foreign` (`section_id`),
  KEY `accounts_addtl_fields_form_id_foreign` (`form_id`),
  CONSTRAINT `accounts_addtl_fields_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `accounts_addtl_fields_field_id_foreign` FOREIGN KEY (`field_id`) REFERENCES `custom_fields` (`id`),
  CONSTRAINT `accounts_addtl_fields_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `custom_forms` (`id`),
  CONSTRAINT `accounts_addtl_fields_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `custom_forms_sections` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `accounts_cims`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts_cims` (
  `account_id` bigint unsigned DEFAULT NULL,
  `cim_profile_id` bigint unsigned DEFAULT NULL,
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `acim_account_id` (`account_id`),
  KEY `accounts_cims_cim_profile_id_foreign` (`cim_profile_id`),
  CONSTRAINT `accounts_cims_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `accounts_cims_cim_profile_id_foreign` FOREIGN KEY (`cim_profile_id`) REFERENCES `cim_profile` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `accounts_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts_comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `account_id` bigint unsigned DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `beenread` tinyint(1) NOT NULL DEFAULT '0',
  `replyto_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `acomm_account_id` (`account_id`),
  KEY `replyto_id` (`replyto_id`),
  CONSTRAINT `accounts_comments_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `accounts_comments_replyto_id_foreign` FOREIGN KEY (`replyto_id`) REFERENCES `accounts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `accounts_discounts_used`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts_discounts_used` (
  `account_id` bigint unsigned DEFAULT NULL,
  `discount_id` bigint unsigned DEFAULT NULL,
  `order_id` bigint unsigned NOT NULL,
  `times_used` int NOT NULL,
  `used` datetime NOT NULL,
  KEY `adisc_account_id` (`account_id`),
  KEY `adisc_discount_id` (`discount_id`),
  KEY `adisc_order_id` (`order_id`),
  CONSTRAINT `accounts_discounts_used_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `accounts_discounts_used_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discount` (`id`),
  CONSTRAINT `accounts_discounts_used_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `accounts_loyaltypoints`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts_loyaltypoints` (
  `account_id` bigint unsigned NOT NULL,
  `loyaltypoints_level_id` bigint unsigned NOT NULL,
  `points_available` int NOT NULL,
  UNIQUE KEY `aloyp_account_id_2` (`account_id`,`loyaltypoints_level_id`),
  KEY `aloyp_account_id` (`account_id`),
  KEY `accounts_loyaltypoints_loyaltypoints_level_id_foreign` (`loyaltypoints_level_id`),
  CONSTRAINT `accounts_loyaltypoints_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `accounts_loyaltypoints_loyaltypoints_level_id_foreign` FOREIGN KEY (`loyaltypoints_level_id`) REFERENCES `loyaltypoints_levels` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `accounts_loyaltypoints_credits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts_loyaltypoints_credits` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `account_id` bigint unsigned NOT NULL,
  `loyaltypoints_level_id` bigint unsigned NOT NULL,
  `shipment_id` bigint unsigned NOT NULL,
  `points_awarded` int NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0=pending, 1=credited',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `aloy_account_id` (`account_id`),
  KEY `aloy_shipment_id` (`shipment_id`),
  KEY `accounts_loyaltypoints_credits_loyaltypoints_level_id_foreign` (`loyaltypoints_level_id`),
  CONSTRAINT `accounts_loyaltypoints_credits_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `accounts_loyaltypoints_credits_loyaltypoints_level_id_foreign` FOREIGN KEY (`loyaltypoints_level_id`) REFERENCES `loyaltypoints_levels` (`id`),
  CONSTRAINT `accounts_loyaltypoints_credits_shipment_id_foreign` FOREIGN KEY (`shipment_id`) REFERENCES `orders_shipments` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `accounts_loyaltypoints_debits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts_loyaltypoints_debits` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `account_id` bigint unsigned NOT NULL,
  `loyaltypoints_level_id` bigint unsigned NOT NULL,
  `order_id` bigint unsigned NOT NULL,
  `points_used` int NOT NULL,
  `created` datetime NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aloyd_account_id_2` (`account_id`,`loyaltypoints_level_id`,`order_id`),
  KEY `aloyd_account_id` (`account_id`),
  KEY `aloyd_order_id` (`order_id`),
  KEY `accounts_loyaltypoints_debits_loyaltypoints_level_id_foreign` (`loyaltypoints_level_id`),
  CONSTRAINT `accounts_loyaltypoints_debits_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `accounts_loyaltypoints_debits_loyaltypoints_level_id_foreign` FOREIGN KEY (`loyaltypoints_level_id`) REFERENCES `loyaltypoints_levels` (`id`),
  CONSTRAINT `accounts_loyaltypoints_debits_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `accounts_message_keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts_message_keys` (
  `key_id` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key_var` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`key_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `accounts_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts_messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `header_id` bigint unsigned DEFAULT NULL,
  `replied_id` bigint unsigned DEFAULT NULL,
  `to_id` bigint unsigned DEFAULT NULL,
  `from_id` bigint unsigned DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sent` datetime DEFAULT NULL,
  `readdate` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=deleted, 2=spam, 3=saved',
  `beenseen` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `accounts_messages_replied_id_foreign` (`replied_id`),
  KEY `accounts_messages_to_id_foreign` (`to_id`),
  KEY `accounts_messages_from_id_foreign` (`from_id`),
  KEY `accounts_messages_header_id_foreign` (`header_id`),
  CONSTRAINT `accounts_messages_from_id_foreign` FOREIGN KEY (`from_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `accounts_messages_header_id_foreign` FOREIGN KEY (`header_id`) REFERENCES `accounts_messages_headers` (`id`),
  CONSTRAINT `accounts_messages_replied_id_foreign` FOREIGN KEY (`replied_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `accounts_messages_to_id_foreign` FOREIGN KEY (`to_id`) REFERENCES `accounts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `accounts_messages_headers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts_messages_headers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `accounts_onmind`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts_onmind` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `account_id` bigint unsigned DEFAULT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `posted` datetime NOT NULL,
  `like_count` int NOT NULL DEFAULT '0',
  `dislike_count` int NOT NULL DEFAULT '0',
  `comment_count` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `aon_account_id` (`account_id`),
  CONSTRAINT `accounts_onmind_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `accounts_onmind_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts_onmind_comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `onmind_id` bigint unsigned DEFAULT NULL,
  `comment_id` int NOT NULL,
  `account_id` bigint unsigned DEFAULT NULL,
  `text` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `posted` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `onmind_id` (`onmind_id`,`comment_id`,`account_id`),
  KEY `accounts_onmind_comments_account_id_foreign` (`account_id`),
  CONSTRAINT `accounts_onmind_comments_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `accounts_onmind_comments_onmind_id_foreign` FOREIGN KEY (`onmind_id`) REFERENCES `accounts_onmind` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `accounts_onmind_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts_onmind_likes` (
  `onmind_id` bigint unsigned DEFAULT NULL,
  `account_id` bigint unsigned DEFAULT NULL,
  `type_id` tinyint(1) NOT NULL,
  KEY `aon_onmind_id` (`onmind_id`,`account_id`),
  KEY `accounts_onmind_likes_account_id_foreign` (`account_id`),
  CONSTRAINT `accounts_onmind_likes_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `accounts_onmind_likes_onmind_id_foreign` FOREIGN KEY (`onmind_id`) REFERENCES `accounts_onmind` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `accounts_specialties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts_specialties` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `account_id` bigint unsigned DEFAULT NULL,
  `specialty_id` bigint unsigned DEFAULT NULL,
  `approved` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `acsp_account_id_2` (`account_id`,`specialty_id`),
  KEY `acsp_account_id` (`account_id`),
  KEY `accounts_specialties_specialty_id_foreign` (`specialty_id`),
  CONSTRAINT `accounts_specialties_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `accounts_specialties_specialty_id_foreign` FOREIGN KEY (`specialty_id`) REFERENCES `specialties` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `accounts_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts_statuses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `accounts_templates_sent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts_templates_sent` (
  `account_id` bigint unsigned DEFAULT NULL,
  `template_id` bigint unsigned DEFAULT NULL,
  `sent` datetime NOT NULL,
  KEY `atemps_account_id` (`account_id`),
  KEY `accounts_templates_sent_template_id_foreign` (`template_id`),
  CONSTRAINT `accounts_templates_sent_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `accounts_templates_sent_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `message_templates` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `accounts_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_account_status` bigint unsigned NOT NULL,
  `custom_form_id` bigint unsigned DEFAULT NULL,
  `email_template_id_creation_admin` int NOT NULL,
  `email_template_id_creation_user` int NOT NULL,
  `email_template_id_activate_user` int NOT NULL,
  `discount_level_id` bigint unsigned DEFAULT NULL,
  `verify_user_email` tinyint NOT NULL DEFAULT '0',
  `filter_products` tinyint(1) NOT NULL COMMENT '0=no, 1=show select, 2= hide selected',
  `filter_categories` tinyint(1) NOT NULL COMMENT '0=no, 1=show select, 2= hide selected',
  `loyaltypoints_id` bigint unsigned DEFAULT NULL,
  `use_specialties` tinyint(1) NOT NULL,
  `membership_level_id` bigint unsigned DEFAULT NULL,
  `email_template_id_verify_email` int NOT NULL,
  `affiliate_level_id` bigint unsigned DEFAULT NULL,
  `is_trial` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `accounts_types_discount_level_id_foreign` (`discount_level_id`),
  KEY `accounts_types_loyaltypoints_id_foreign` (`loyaltypoints_id`),
  KEY `accounts_types_membership_level_id_foreign` (`membership_level_id`),
  KEY `accounts_types_affiliate_level_id_foreign` (`affiliate_level_id`),
  KEY `accounts_types_custom_form_id_foreign` (`custom_form_id`),
  CONSTRAINT `accounts_types_affiliate_level_id_foreign` FOREIGN KEY (`affiliate_level_id`) REFERENCES `affiliates_levels` (`id`),
  CONSTRAINT `accounts_types_custom_form_id_foreign` FOREIGN KEY (`custom_form_id`) REFERENCES `custom_forms` (`id`),
  CONSTRAINT `accounts_types_discount_level_id_foreign` FOREIGN KEY (`discount_level_id`) REFERENCES `discounts_levels` (`id`),
  CONSTRAINT `accounts_types_loyaltypoints_id_foreign` FOREIGN KEY (`loyaltypoints_id`) REFERENCES `loyaltypoints` (`id`),
  CONSTRAINT `accounts_types_membership_level_id_foreign` FOREIGN KEY (`membership_level_id`) REFERENCES `membership_levels` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `accounts_views`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts_views` (
  `account_id` bigint unsigned DEFAULT NULL COMMENT 'viewers id',
  `viewed_date` date NOT NULL,
  `viewed_time` time NOT NULL,
  KEY `aviews_account_id` (`account_id`),
  CONSTRAINT `accounts_views_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `addresses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `label` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_1` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_2` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` bigint unsigned DEFAULT NULL,
  `country_id` bigint unsigned DEFAULT NULL,
  `postal_code` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(85) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_residential` tinyint(1) NOT NULL DEFAULT '0',
  `resource_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resource_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `addresses_state_id_foreign` (`state_id`),
  KEY `addresses_country_id_foreign` (`country_id`),
  KEY `from_resource` (`resource_type`,`resource_id`),
  CONSTRAINT `addresses_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  CONSTRAINT `addresses_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `admin_emails_sent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_emails_sent` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `account_id` bigint unsigned DEFAULT NULL,
  `template_id` bigint unsigned DEFAULT NULL,
  `sent_to` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sent_date` datetime NOT NULL,
  `sent_by` bigint unsigned NOT NULL,
  `order_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `adems_account_id` (`account_id`),
  KEY `adems_order_id` (`order_id`),
  KEY `admin_emails_sent_template_id_foreign` (`template_id`),
  CONSTRAINT `admin_emails_sent_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `admin_emails_sent_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `admin_emails_sent_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `message_templates` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `admin_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_levels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `admin_levels_menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_levels_menus` (
  `level_id` bigint unsigned NOT NULL,
  `menu_id` bigint unsigned NOT NULL,
  KEY `adlev_level_id` (`level_id`),
  KEY `admin_levels_menus_menu_id_foreign` (`menu_id`),
  CONSTRAINT `admin_levels_menus_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `admin_levels` (`id`),
  CONSTRAINT `admin_levels_menus_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `admin_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(65) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `level_id` bigint unsigned DEFAULT NULL,
  `filter_orders` tinyint(1) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`),
  KEY `admin_users_level_id_foreign` (`level_id`),
  KEY `admin_users_account_id_foreign` (`account_id`),
  CONSTRAINT `admin_users_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `admin_users_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `admin_levels` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `admin_users_distributors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_users_distributors` (
  `user_id` bigint unsigned NOT NULL,
  `distributor_id` bigint unsigned NOT NULL,
  UNIQUE KEY `user_id` (`user_id`,`distributor_id`),
  KEY `admin_users_distributors_distributor_id_foreign` (`distributor_id`),
  CONSTRAINT `admin_users_distributors_distributor_id_foreign` FOREIGN KEY (`distributor_id`) REFERENCES `distributors` (`id`),
  CONSTRAINT `admin_users_distributors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `admin_users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `affiliates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `affiliates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `affiliate_level_id` bigint unsigned DEFAULT '100',
  `account_id` bigint unsigned DEFAULT NULL COMMENT 'if linking account to affiliate',
  `address_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `affiliates_account_id_foreign` (`account_id`),
  KEY `affiliates_affiliate_level_id_foreign` (`affiliate_level_id`),
  KEY `affiliates_address_id_foreign` (`address_id`),
  CONSTRAINT `affiliates_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `affiliates_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`),
  CONSTRAINT `affiliates_affiliate_level_id_foreign` FOREIGN KEY (`affiliate_level_id`) REFERENCES `affiliates_levels` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `affiliates_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `affiliates_levels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_rate` decimal(6,2) NOT NULL,
  `subscription_rate` decimal(6,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `affiliates_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `affiliates_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `affiliate_id` bigint unsigned NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `affiliate_id` (`affiliate_id`),
  CONSTRAINT `affiliates_payments_affiliate_id_foreign` FOREIGN KEY (`affiliate_id`) REFERENCES `affiliates` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `affiliates_payments_referrals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `affiliates_payments_referrals` (
  `payment_id` bigint unsigned NOT NULL,
  `referral_id` bigint unsigned NOT NULL,
  KEY `referral_id` (`referral_id`),
  KEY `affiliates_payments_referrals_payment_id_foreign` (`payment_id`),
  CONSTRAINT `affiliates_payments_referrals_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `affiliates_payments` (`id`),
  CONSTRAINT `affiliates_payments_referrals_referral_id_foreign` FOREIGN KEY (`referral_id`) REFERENCES `affiliates_referrals` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `affiliates_referrals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `affiliates_referrals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `affiliate_id` bigint unsigned NOT NULL,
  `order_id` bigint unsigned DEFAULT NULL,
  `status_id` bigint unsigned NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `type_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `aref_ordertype_id` (`order_id`,`type_id`),
  KEY `aref_affiliate_id` (`affiliate_id`),
  KEY `aref_order_id` (`order_id`),
  KEY `aref_type_id` (`type_id`),
  KEY `affiliates_referrals_status_id_foreign` (`status_id`),
  CONSTRAINT `affiliates_referrals_affiliate_id_foreign` FOREIGN KEY (`affiliate_id`) REFERENCES `affiliates` (`id`),
  CONSTRAINT `affiliates_referrals_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `affiliates_referrals_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `affiliates_referrals_statuses` (`id`),
  CONSTRAINT `affiliates_referrals_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `affiliates_referrals_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `affiliates_referrals_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `affiliates_referrals_statuses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `affiliates_referrals_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `affiliates_referrals_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `airports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `airports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `attribute_option_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attribute_option_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `option_id` bigint unsigned NOT NULL,
  `language_id` bigint unsigned NOT NULL,
  `display` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `attribute_option_translations_option_id_language_id_unique` (`option_id`,`language_id`),
  KEY `attribute_option_translations_language_id_foreign` (`language_id`),
  CONSTRAINT `attribute_option_translations_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attribute_option_translations_option_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `attributes_options` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `attribute_set_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attribute_set_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `set_id` bigint unsigned NOT NULL,
  `language_id` bigint unsigned NOT NULL,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `attribute_set_translations_set_id_language_id_unique` (`set_id`,`language_id`),
  KEY `attribute_set_translations_language_id_foreign` (`language_id`),
  CONSTRAINT `attribute_set_translations_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attribute_set_translations_set_id_foreign` FOREIGN KEY (`set_id`) REFERENCES `attributes_sets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `attribute_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attribute_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `attribute_id` bigint unsigned NOT NULL,
  `language_id` bigint unsigned NOT NULL,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `attribute_translations_attribute_id_language_id_unique` (`attribute_id`,`language_id`),
  KEY `attribute_translations_language_id_foreign` (`language_id`),
  CONSTRAINT `attribute_translations_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attribute_translations_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attributes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_id` bigint unsigned NOT NULL,
  `show_in_details` tinyint(1) NOT NULL,
  `show_in_search` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `attributes_type_id_foreign` (`type_id`),
  CONSTRAINT `attributes_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `attributes_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `attributes_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attributes_options` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `attribute_id` bigint unsigned NOT NULL,
  `display` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rank` int DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `attribute_id` (`attribute_id`),
  CONSTRAINT `attributes_options_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `attributes_sets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attributes_sets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `attributes_sets_attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attributes_sets_attributes` (
  `set_id` bigint unsigned NOT NULL,
  `attribute_id` bigint unsigned NOT NULL,
  KEY `set_id` (`set_id`),
  KEY `attributes_sets_attributes_attribute_id_foreign` (`attribute_id`),
  CONSTRAINT `attributes_sets_attributes_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`),
  CONSTRAINT `attributes_sets_attributes_set_id_foreign` FOREIGN KEY (`set_id`) REFERENCES `attributes_sets` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `attributes_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attributes_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `automated_emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `automated_emails` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message_template_id` bigint unsigned NOT NULL,
  `status` tinyint(1) NOT NULL,
  `send_on` tinyint NOT NULL COMMENT '0=status change, 1=days after order, 2=days after shipped, 3= days after delivered',
  `send_on_status` int NOT NULL,
  `send_on_daysafter` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `message_template_id` (`message_template_id`),
  CONSTRAINT `automated_emails_message_template_id_foreign` FOREIGN KEY (`message_template_id`) REFERENCES `message_templates` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `automated_emails_accounttypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `automated_emails_accounttypes` (
  `automated_email_id` bigint unsigned NOT NULL,
  `account_type_id` bigint unsigned NOT NULL,
  UNIQUE KEY `automated_email_id_2` (`automated_email_id`,`account_type_id`),
  KEY `automated_email_id` (`automated_email_id`),
  KEY `account_type_id` (`account_type_id`),
  CONSTRAINT `automated_emails_accounttypes_account_type_id_foreign` FOREIGN KEY (`account_type_id`) REFERENCES `accounts_types` (`id`),
  CONSTRAINT `automated_emails_accounttypes_automated_email_id_foreign` FOREIGN KEY (`automated_email_id`) REFERENCES `automated_emails` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `automated_emails_sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `automated_emails_sites` (
  `automated_email_id` bigint unsigned NOT NULL,
  `site_id` bigint unsigned NOT NULL,
  UNIQUE KEY `aues_automated_email_id_2` (`automated_email_id`,`site_id`),
  KEY `aues_automated_email_id` (`automated_email_id`),
  KEY `aues_site_id` (`site_id`),
  CONSTRAINT `automated_emails_sites_automated_email_id_foreign` FOREIGN KEY (`automated_email_id`) REFERENCES `automated_emails` (`id`),
  CONSTRAINT `automated_emails_sites_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bookingas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bookingas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(555) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bookingas_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bookingas_options` (
  `bookingas_id` bigint unsigned NOT NULL,
  `options` text COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `bookingas_id` (`bookingas_id`),
  CONSTRAINT `bookingas_options_bookingas_id_foreign` FOREIGN KEY (`bookingas_id`) REFERENCES `bookingas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bookingas_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bookingas_products` (
  `bookingas_id` bigint unsigned NOT NULL,
  `product` bigint unsigned NOT NULL,
  KEY `bopr_bookingas_id` (`bookingas_id`),
  KEY `bookingas_products_product_foreign` (`product`),
  CONSTRAINT `bookingas_products_bookingas_id_foreign` FOREIGN KEY (`bookingas_id`) REFERENCES `bookingas` (`id`),
  CONSTRAINT `bookingas_products_product_foreign` FOREIGN KEY (`product`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brands` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `brands_name_unique` (`name`),
  KEY `brands_index_1` (`id`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bulkedit_change`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bulkedit_change` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `action_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_changeto` json NOT NULL,
  `products_edited` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bulkedit_change_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bulkedit_change_products` (
  `change_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `changed_from` text COLLATE utf8mb4_unicode_ci NOT NULL,
  UNIQUE KEY `change_id` (`change_id`,`product_id`),
  KEY `bulkedit_change_products_product_id_foreign` (`product_id`),
  CONSTRAINT `bulkedit_change_products_change_id_foreign` FOREIGN KEY (`change_id`) REFERENCES `bulkedit_change` (`id`),
  CONSTRAINT `bulkedit_change_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `account_id` bigint unsigned DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `site_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `saca_account_id` (`account_id`),
  KEY `cart_site_id_foreign` (`site_id`),
  CONSTRAINT `cart_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`),
  CONSTRAINT `saved_cart_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cart_discount_advantages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart_discount_advantages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `advantage_id` bigint unsigned NOT NULL,
  `amount` bigint unsigned DEFAULT NULL,
  `cart_discount_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cartdiscount_advantage` (`cart_discount_id`,`advantage_id`),
  KEY `cart_discount_advantages_advantage_id_foreign` (`advantage_id`),
  CONSTRAINT `cart_discount_advantages_advantage_id_foreign` FOREIGN KEY (`advantage_id`) REFERENCES `discount_advantage` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_discount_advantages_cart_discount_id_foreign` FOREIGN KEY (`cart_discount_id`) REFERENCES `cart_discounts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cart_discount_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart_discount_codes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `condition_id` bigint unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cart_discount_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cart_code_unq` (`condition_id`,`code`),
  KEY `cart_discount_codes_cart_discount_id_foreign` (`cart_discount_id`),
  CONSTRAINT `cart_discount_codes_cart_discount_id_foreign` FOREIGN KEY (`cart_discount_id`) REFERENCES `cart_discounts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_discount_codes_condition_id_foreign` FOREIGN KEY (`condition_id`) REFERENCES `discount_rule_condition` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cart_discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart_discounts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cart_id` bigint unsigned NOT NULL,
  `discount_id` bigint unsigned NOT NULL,
  `applied` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `cart_discounts_cart_id_foreign` (`cart_id`),
  KEY `cart_discounts_discount_id_foreign` (`discount_id`),
  CONSTRAINT `cart_discounts_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_discounts_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discount` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cart_item_customfields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart_item_customfields` (
  `item_id` bigint unsigned NOT NULL,
  `form_id` bigint unsigned DEFAULT NULL,
  `section_id` bigint unsigned DEFAULT NULL,
  `field_id` bigint unsigned DEFAULT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  UNIQUE KEY `saved_cart_item_id` (`item_id`,`form_id`,`section_id`,`field_id`),
  KEY `saved_cart_items_customfields_field_id_foreign` (`field_id`),
  KEY `saved_cart_items_customfields_section_id_foreign` (`section_id`),
  KEY `saved_cart_items_customfields_form_id_foreign` (`form_id`),
  CONSTRAINT `saved_cart_items_customfields_field_id_foreign` FOREIGN KEY (`field_id`) REFERENCES `custom_fields` (`id`),
  CONSTRAINT `saved_cart_items_customfields_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `custom_forms` (`id`),
  CONSTRAINT `saved_cart_items_customfields_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `custom_forms_sections` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cart_item_discount_advantages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart_item_discount_advantages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `item_id` bigint unsigned NOT NULL,
  `advantage_id` bigint unsigned NOT NULL,
  `qty` int NOT NULL DEFAULT '1',
  `amount` bigint unsigned DEFAULT NULL,
  `cart_discount_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_item_discount_advantages_item_id_foreign` (`item_id`),
  KEY `cart_item_discount_advantages_advantage_id_foreign` (`advantage_id`),
  KEY `cart_item_discount_advantages_cart_discount_id_foreign` (`cart_discount_id`),
  CONSTRAINT `cart_item_discount_advantages_advantage_id_foreign` FOREIGN KEY (`advantage_id`) REFERENCES `discount_advantage` (`id`),
  CONSTRAINT `cart_item_discount_advantages_cart_discount_id_foreign` FOREIGN KEY (`cart_discount_id`) REFERENCES `cart_discounts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_item_discount_advantages_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `cart_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cart_item_discount_conditions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart_item_discount_conditions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `item_id` bigint unsigned NOT NULL,
  `condition_id` bigint unsigned NOT NULL,
  `qty` int NOT NULL DEFAULT '1',
  `cart_discount_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_item_discount_conditions_item_id_foreign` (`item_id`),
  KEY `cart_item_discount_conditions_condition_id_foreign` (`condition_id`),
  KEY `cart_item_discount_conditions_cart_discount_id_foreign` (`cart_discount_id`),
  CONSTRAINT `cart_item_discount_conditions_cart_discount_id_foreign` FOREIGN KEY (`cart_discount_id`) REFERENCES `cart_discounts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_item_discount_conditions_condition_id_foreign` FOREIGN KEY (`condition_id`) REFERENCES `discount_rule_condition` (`id`),
  CONSTRAINT `cart_item_discount_conditions_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `cart_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cart_item_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart_item_options` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `item_id` bigint unsigned NOT NULL,
  `option_value_id` bigint unsigned NOT NULL,
  `custom_value` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `item_option_value` (`item_id`,`option_value_id`),
  KEY `cart_item_options_option_value_id_foreign` (`option_value_id`),
  CONSTRAINT `cart_item_options_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `cart_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_item_options_option_value_id_foreign` FOREIGN KEY (`option_value_id`) REFERENCES `products_options_values` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cart_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `parent_product` bigint unsigned DEFAULT NULL,
  `parent_cart_item_id` bigint unsigned DEFAULT NULL,
  `required` bigint unsigned DEFAULT NULL,
  `qty` int NOT NULL,
  `price_reg` decimal(8,2) NOT NULL,
  `price_sale` decimal(8,2) NOT NULL,
  `onsale` tinyint(1) NOT NULL,
  `product_label` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registry_item_id` bigint unsigned DEFAULT NULL,
  `accessory_field_id` bigint unsigned DEFAULT NULL,
  `distributor_id` bigint unsigned DEFAULT NULL,
  `accessory_link_actions` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `saved_cart_id` (`cart_id`),
  KEY `saved_cart_items_product_id_foreign` (`product_id`),
  KEY `saved_cart_items_parent_product_foreign` (`parent_product`),
  KEY `saved_cart_items_registry_item_id_foreign` (`registry_item_id`),
  KEY `saved_cart_items_accessory_field_id_foreign` (`accessory_field_id`),
  KEY `saved_cart_items_distributor_id_foreign` (`distributor_id`),
  KEY `cart_items_parent_cart_item_id_foreign` (`parent_cart_item_id`),
  KEY `cart_items_required_foreign` (`required`),
  KEY `cart_items_accessory_link_actions_foreign` (`accessory_link_actions`),
  CONSTRAINT `cart_items_accessory_link_actions_foreign` FOREIGN KEY (`accessory_link_actions`) REFERENCES `cart_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_parent_cart_item_id_foreign` FOREIGN KEY (`parent_cart_item_id`) REFERENCES `cart_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_required_foreign` FOREIGN KEY (`required`) REFERENCES `cart_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `saved_cart_items_accessory_field_id_foreign` FOREIGN KEY (`accessory_field_id`) REFERENCES `accessories_fields` (`id`),
  CONSTRAINT `saved_cart_items_distributor_id_foreign` FOREIGN KEY (`distributor_id`) REFERENCES `distributors` (`id`),
  CONSTRAINT `saved_cart_items_parent_product_foreign` FOREIGN KEY (`parent_product`) REFERENCES `products` (`id`),
  CONSTRAINT `saved_cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `saved_cart_items_registry_item_id_foreign` FOREIGN KEY (`registry_item_id`) REFERENCES `giftregistry_items` (`id`),
  CONSTRAINT `saved_cart_items_saved_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cart_items_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart_items_options` (
  `cart_item_id` bigint unsigned NOT NULL,
  `options_json` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`cart_item_id`),
  CONSTRAINT `saved_cart_items_options_saved_cart_item_id_foreign` FOREIGN KEY (`cart_item_id`) REFERENCES `cart_items` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cart_items_options_customvalues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart_items_options_customvalues` (
  `cart_item_id` bigint unsigned NOT NULL,
  `option_id` bigint unsigned NOT NULL,
  `custom_value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  UNIQUE KEY `cartitem_option` (`cart_item_id`,`option_id`),
  KEY `saved_cart_items_options_customvalues_option_id_foreign` (`option_id`),
  CONSTRAINT `saved_cart_items_options_customvalues_option_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `products_options_values` (`id`),
  CONSTRAINT `saved_cart_items_options_customvalues_saved_cart_item_id_foreign` FOREIGN KEY (`cart_item_id`) REFERENCES `cart_items` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `catalog_updates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `catalog_updates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '0=product, 1=category, 2=new image size, 5-5.99=datafeed, 6=sitemap, 7=notify backinstock',
  `item_id` bigint unsigned NOT NULL,
  `processing` tinyint(1) NOT NULL,
  `start` int NOT NULL,
  `info` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image_id` bigint unsigned DEFAULT NULL,
  `rank` int NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `url_name` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `show_sale` tinyint(1) NOT NULL DEFAULT '0',
  `limit_min_price` tinyint(1) NOT NULL DEFAULT '0',
  `min_price` decimal(10,2) DEFAULT NULL,
  `limit_max_price` tinyint(1) NOT NULL DEFAULT '0',
  `max_price` decimal(10,2) DEFAULT NULL,
  `show_in_list` tinyint(1) NOT NULL DEFAULT '1',
  `limit_days` int DEFAULT NULL,
  `meta_title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_types` tinyint(1) NOT NULL DEFAULT '1',
  `show_brands` tinyint(1) NOT NULL DEFAULT '1',
  `rules_match_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=any, 1=all',
  `inventory_id` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_class` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cats_parent_id` (`parent_id`),
  KEY `cats_inventory_id` (`inventory_id`),
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `categories_brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories_brands` (
  `category_id` bigint unsigned NOT NULL,
  `brand_id` bigint unsigned NOT NULL,
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `cabr_category_id` (`category_id`),
  KEY `categories_brands_brand_id_foreign` (`brand_id`),
  CONSTRAINT `categories_brands_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  CONSTRAINT `categories_brands_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `categories_featured`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories_featured` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned DEFAULT NULL,
  `product_id` bigint unsigned NOT NULL,
  `rank` int DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `cafe_category_id_2` (`category_id`,`product_id`),
  KEY `cafe_category_id` (`category_id`),
  KEY `cafe_product_id` (`product_id`),
  CONSTRAINT `categories_featured_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `categories_featured_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `categories_products_assn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories_products_assn` (
  `category_id` bigint unsigned DEFAULT NULL,
  `product_id` bigint unsigned NOT NULL,
  `manual` tinyint(1) NOT NULL,
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `rank` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `capras_category_id` (`category_id`),
  KEY `categories_products_assn_product_id_foreign` (`product_id`),
  CONSTRAINT `categories_products_assn_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `categories_products_assn_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `categories_products_hide`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories_products_hide` (
  `category_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  UNIQUE KEY `caprhi_catproduct` (`category_id`,`product_id`),
  KEY `caprhi_categories_products_hide_index_1` (`product_id`,`category_id`),
  KEY `caprhi_category_id` (`category_id`),
  CONSTRAINT `categories_products_hide_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `categories_products_hide_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `categories_products_ranks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories_products_ranks` (
  `category_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `rank` int NOT NULL,
  UNIQUE KEY `caprra_catproductmanual` (`category_id`,`product_id`),
  KEY `caprra_categories_products_ranks_index_1` (`category_id`,`product_id`),
  KEY `caprra_category_id` (`category_id`),
  KEY `categories_products_ranks_product_id_foreign` (`product_id`),
  CONSTRAINT `categories_products_ranks_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `categories_products_ranks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `categories_products_sorts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories_products_sorts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `sort_id` bigint unsigned NOT NULL,
  `rank` int NOT NULL,
  `isdefault` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `caprso_category_id_2` (`category_id`,`sort_id`),
  KEY `caprso_category_id` (`category_id`),
  CONSTRAINT `categories_products_sorts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `categories_rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories_rules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned DEFAULT NULL,
  `temp_id` bigint unsigned NOT NULL,
  `match_type` tinyint(1) NOT NULL COMMENT '0=any, 1=all',
  PRIMARY KEY (`id`),
  KEY `categories_rules_category_id_foreign` (`category_id`),
  CONSTRAINT `categories_rules_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `categories_rules_attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories_rules_attributes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `rule_id` bigint unsigned DEFAULT NULL,
  `value_id` bigint unsigned DEFAULT NULL,
  `set_id` bigint unsigned NOT NULL,
  `match_type` tinyint NOT NULL COMMENT '0=matches, 1=doesn''t match',
  PRIMARY KEY (`id`),
  KEY `rule_id` (`rule_id`),
  KEY `categories_rules_attributes_value_id_foreign` (`value_id`),
  CONSTRAINT `categories_rules_attributes_rule_id_foreign` FOREIGN KEY (`rule_id`) REFERENCES `categories_rules` (`id`),
  CONSTRAINT `categories_rules_attributes_value_id_foreign` FOREIGN KEY (`value_id`) REFERENCES `attributes_options` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `categories_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories_settings` (
  `category_id` bigint unsigned NOT NULL,
  `settings_template_id` bigint unsigned DEFAULT NULL,
  `use_default_category` tinyint(1) NOT NULL DEFAULT '1',
  `use_default_feature` tinyint(1) NOT NULL DEFAULT '1',
  `use_default_product` tinyint(1) NOT NULL DEFAULT '1',
  `category_thumbnail_template` int DEFAULT NULL,
  `product_thumbnail_template` int DEFAULT NULL,
  `product_thumbnail_count` int NOT NULL DEFAULT '0',
  `feature_thumbnail_template` int DEFAULT NULL,
  `feature_thumbnail_count` int NOT NULL DEFAULT '0',
  `feature_showsort` tinyint(1) NOT NULL DEFAULT '0',
  `product_thumbnail_showsort` tinyint(1) NOT NULL DEFAULT '0',
  `product_thumbnail_showmessage` tinyint(1) NOT NULL DEFAULT '0',
  `feature_showmessage` tinyint(1) NOT NULL DEFAULT '0',
  `show_categories_in_body` tinyint(1) NOT NULL DEFAULT '0',
  `show_products` tinyint(1) NOT NULL DEFAULT '0',
  `show_featured` tinyint(1) NOT NULL DEFAULT '0',
  `layout_id` bigint unsigned DEFAULT NULL,
  `module_template_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`category_id`),
  KEY `categories_settings_settings_template_id_foreign` (`settings_template_id`),
  KEY `categories_settings_layout_id_foreign` (`layout_id`),
  KEY `categories_settings_module_template_id_foreign` (`module_template_id`),
  CONSTRAINT `categories_settings_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `categories_settings_layout_id_foreign` FOREIGN KEY (`layout_id`) REFERENCES `display_layouts` (`id`),
  CONSTRAINT `categories_settings_module_template_id_foreign` FOREIGN KEY (`module_template_id`) REFERENCES `modules_templates` (`id`),
  CONSTRAINT `categories_settings_settings_template_id_foreign` FOREIGN KEY (`settings_template_id`) REFERENCES `categories_settings_templates` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `categories_settings_sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories_settings_sites` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `site_id` bigint unsigned DEFAULT NULL,
  `settings_template_id` bigint unsigned DEFAULT NULL,
  `category_thumbnail_template` int DEFAULT NULL,
  `product_thumbnail_template` int DEFAULT NULL,
  `product_thumbnail_count` int DEFAULT NULL,
  `feature_thumbnail_template` int DEFAULT NULL,
  `feature_thumbnail_count` int DEFAULT NULL,
  `feature_showsort` tinyint(1) DEFAULT NULL,
  `feature_defaultsort` tinyint DEFAULT NULL,
  `product_thumbnail_showsort` tinyint(1) DEFAULT NULL,
  `product_thumbnail_defaultsort` tinyint DEFAULT NULL,
  `product_thumbnail_customsort` tinyint(1) DEFAULT NULL,
  `product_thumbnail_showmessage` tinyint(1) DEFAULT NULL,
  `feature_showmessage` tinyint(1) DEFAULT NULL,
  `show_categories_in_body` tinyint(1) DEFAULT NULL,
  `show_products` tinyint(1) DEFAULT NULL,
  `show_featured` tinyint(1) DEFAULT NULL,
  `layout_id` bigint unsigned DEFAULT NULL,
  `module_template_id` bigint unsigned DEFAULT NULL,
  `search_form_id` bigint unsigned DEFAULT NULL,
  `settings_template_id_default` int DEFAULT NULL,
  `module_template_id_default` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `casesi_category_id` (`category_id`,`site_id`),
  KEY `categories_settings_sites_site_id_foreign` (`site_id`),
  KEY `categories_settings_sites_settings_template_id_foreign` (`settings_template_id`),
  KEY `categories_settings_sites_layout_id_foreign` (`layout_id`),
  KEY `categories_settings_sites_module_template_id_foreign` (`module_template_id`),
  KEY `categories_settings_sites_search_form_id_foreign` (`search_form_id`),
  CONSTRAINT `categories_settings_sites_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `categories_settings_sites_layout_id_foreign` FOREIGN KEY (`layout_id`) REFERENCES `display_layouts` (`id`),
  CONSTRAINT `categories_settings_sites_module_template_id_foreign` FOREIGN KEY (`module_template_id`) REFERENCES `modules_templates` (`id`),
  CONSTRAINT `categories_settings_sites_search_form_id_foreign` FOREIGN KEY (`search_form_id`) REFERENCES `search_forms` (`id`),
  CONSTRAINT `categories_settings_sites_settings_template_id_foreign` FOREIGN KEY (`settings_template_id`) REFERENCES `categories_settings_templates` (`id`),
  CONSTRAINT `categories_settings_sites_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `categories_settings_sites_modulevalues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories_settings_sites_modulevalues` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned DEFAULT NULL,
  `site_id` bigint unsigned DEFAULT NULL,
  `section_id` bigint unsigned NOT NULL,
  `module_id` bigint unsigned NOT NULL,
  `field_id` bigint unsigned NOT NULL,
  `custom_value` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `casesimo_product_id_3` (`category_id`,`site_id`,`section_id`,`module_id`,`field_id`),
  KEY `casesimo_product_id_2` (`category_id`,`site_id`),
  KEY `casesimo_product_id` (`category_id`),
  KEY `categories_settings_sites_modulevalues_site_id_foreign` (`site_id`),
  KEY `categories_settings_sites_modulevalues_section_id_foreign` (`section_id`),
  KEY `categories_settings_sites_modulevalues_module_id_foreign` (`module_id`),
  KEY `categories_settings_sites_modulevalues_field_id_foreign` (`field_id`),
  CONSTRAINT `categories_settings_sites_modulevalues_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `categories_settings_sites_modulevalues_field_id_foreign` FOREIGN KEY (`field_id`) REFERENCES `modules_fields` (`id`),
  CONSTRAINT `categories_settings_sites_modulevalues_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`),
  CONSTRAINT `categories_settings_sites_modulevalues_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `display_sections` (`id`),
  CONSTRAINT `categories_settings_sites_modulevalues_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `categories_settings_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories_settings_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `settings_template_id` bigint unsigned DEFAULT NULL,
  `use_default_category` tinyint(1) DEFAULT NULL,
  `use_default_feature` tinyint(1) DEFAULT NULL,
  `use_default_product` tinyint(1) DEFAULT NULL,
  `category_thumbnail_template` int DEFAULT NULL,
  `product_thumbnail_template` int DEFAULT NULL,
  `product_thumbnail_count` int DEFAULT NULL,
  `feature_thumbnail_template` int DEFAULT NULL,
  `feature_thumbnail_count` int DEFAULT NULL,
  `feature_showsort` tinyint(1) DEFAULT NULL,
  `feature_defaultsort` tinyint DEFAULT NULL,
  `product_thumbnail_showsort` tinyint(1) DEFAULT NULL,
  `product_thumbnail_defaultsort` tinyint DEFAULT NULL,
  `product_thumbnail_customsort` tinyint(1) DEFAULT NULL,
  `product_thumbnail_showmessage` tinyint(1) DEFAULT NULL,
  `feature_showmessage` tinyint(1) DEFAULT NULL,
  `show_categories_in_body` tinyint(1) DEFAULT NULL,
  `show_products` tinyint(1) DEFAULT NULL,
  `show_featured` tinyint(1) DEFAULT NULL,
  `layout_id` bigint unsigned DEFAULT NULL,
  `module_template_id` bigint unsigned DEFAULT NULL,
  `module_custom_values` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `search_form_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_settings_templates_settings_template_id_foreign` (`settings_template_id`),
  KEY `categories_settings_templates_layout_id_foreign` (`layout_id`),
  KEY `categories_settings_templates_module_template_id_foreign` (`module_template_id`),
  KEY `categories_settings_templates_search_form_id_foreign` (`search_form_id`),
  CONSTRAINT `categories_settings_templates_layout_id_foreign` FOREIGN KEY (`layout_id`) REFERENCES `display_layouts` (`id`),
  CONSTRAINT `categories_settings_templates_module_template_id_foreign` FOREIGN KEY (`module_template_id`) REFERENCES `modules_templates` (`id`),
  CONSTRAINT `categories_settings_templates_search_form_id_foreign` FOREIGN KEY (`search_form_id`) REFERENCES `search_forms` (`id`),
  CONSTRAINT `categories_settings_templates_settings_template_id_foreign` FOREIGN KEY (`settings_template_id`) REFERENCES `categories_settings_templates` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `categories_settings_templates_modulevalues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories_settings_templates_modulevalues` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `settings_template_id` bigint unsigned NOT NULL,
  `section_id` bigint unsigned NOT NULL,
  `module_id` bigint unsigned NOT NULL,
  `field_id` bigint unsigned NOT NULL,
  `custom_value` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `settings_template_id` (`settings_template_id`),
  KEY `categories_settings_templates_modulevalues_section_id_foreign` (`section_id`),
  KEY `categories_settings_templates_modulevalues_module_id_foreign` (`module_id`),
  KEY `categories_settings_templates_modulevalues_field_id_foreign` (`field_id`),
  CONSTRAINT `categories_settings_templates_modulevalues_field_id_foreign` FOREIGN KEY (`field_id`) REFERENCES `modules_fields` (`id`),
  CONSTRAINT `categories_settings_templates_modulevalues_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`),
  CONSTRAINT `categories_settings_templates_modulevalues_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `display_sections` (`id`),
  CONSTRAINT `set_tmp_id` FOREIGN KEY (`settings_template_id`) REFERENCES `categories_settings_templates` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `categories_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories_types` (
  `category_id` bigint unsigned NOT NULL,
  `type_id` bigint unsigned NOT NULL,
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `caty_category_id` (`category_id`),
  KEY `categories_types_type_id_foreign` (`type_id`),
  CONSTRAINT `categories_types_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `categories_types_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `products_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `category_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `language_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_name` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_translations_category_id_language_id_unique` (`category_id`,`language_id`),
  KEY `category_translations_language_id_foreign` (`language_id`),
  CONSTRAINT `category_translations_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `category_translations_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cim_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cim_profile` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `authnet_profile_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gateway_account_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cim_profile_gateway_account_id_foreign` (`gateway_account_id`),
  CONSTRAINT `cim_profile_gateway_account_id_foreign` FOREIGN KEY (`gateway_account_id`) REFERENCES `payment_gateways_accounts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cim_profile_paymentprofile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cim_profile_paymentprofile` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `profile_id` bigint unsigned DEFAULT NULL,
  `first_cc_number` int NOT NULL,
  `cc_number` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cc_exp` date NOT NULL,
  `zipcode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `authnet_payment_profile_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `profile_id` (`profile_id`),
  CONSTRAINT `cim_profile_paymentprofile_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `cim_profile` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `countries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abbreviation` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rank` int NOT NULL,
  `iso_code` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `countries_iso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `countries_iso` (
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `countries_regions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `countries_regions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `country_id` bigint unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rank` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  CONSTRAINT `countries_regions_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `currencies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `exchange_rate` decimal(12,5) NOT NULL,
  `exchange_api` tinyint(1) NOT NULL,
  `base` tinyint(1) NOT NULL,
  `decimal_places` tinyint(1) NOT NULL,
  `decimal_separator` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '.',
  `locale_code` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `format` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symbol` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `custom_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `custom_fields` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `display` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint NOT NULL COMMENT '0=text, 1=textarea, 2=checkbox, 3=radio, 4=select, 5=selectmultiple, 6=button',
  `required` tinyint(1) NOT NULL DEFAULT '1',
  `rank` int NOT NULL,
  `cssclass` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `specs` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `custom_forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `custom_forms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `custom_forms_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `custom_forms_sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `form_id` bigint unsigned NOT NULL,
  `title` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rank` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `form_id` (`form_id`),
  CONSTRAINT `custom_forms_sections_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `custom_forms` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `custom_forms_sections_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `custom_forms_sections_fields` (
  `section_id` bigint unsigned NOT NULL,
  `field_id` bigint unsigned NOT NULL,
  `required` tinyint(1) NOT NULL,
  `rank` int NOT NULL,
  `new_row` tinyint(1) NOT NULL,
  KEY `section_id` (`section_id`),
  KEY `custom_forms_sections_fields_field_id_foreign` (`field_id`),
  CONSTRAINT `custom_forms_sections_fields_field_id_foreign` FOREIGN KEY (`field_id`) REFERENCES `custom_fields` (`id`),
  CONSTRAINT `custom_forms_sections_fields_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `custom_forms_sections` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `custom_forms_show`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `custom_forms_show` (
  `form_id` bigint unsigned NOT NULL,
  `show_on` tinyint NOT NULL COMMENT '0=checkout, 1=product details',
  `show_for` tinyint NOT NULL COMMENT '0=all, 1=product types, 2=product id',
  `show_count` tinyint NOT NULL COMMENT '0=once, 1=per product, 2=per product qty, 3=per type in cart',
  `rank` int NOT NULL,
  KEY `cufosh_form_id` (`form_id`),
  CONSTRAINT `custom_forms_show_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `custom_forms` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `custom_forms_show_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `custom_forms_show_products` (
  `form_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `rank` tinyint(1) DEFAULT NULL,
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `cufoshpr_form_id` (`form_id`),
  KEY `custom_forms_show_products_product_id_foreign` (`product_id`),
  CONSTRAINT `custom_forms_show_products_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `custom_forms` (`id`),
  CONSTRAINT `custom_forms_show_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `custom_forms_show_producttypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `custom_forms_show_producttypes` (
  `form_id` bigint unsigned NOT NULL,
  `product_type_id` bigint unsigned NOT NULL,
  KEY `cufoshprt_form_id` (`form_id`),
  KEY `custom_forms_show_producttypes_product_type_id_foreign` (`product_type_id`),
  CONSTRAINT `custom_forms_show_producttypes_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `custom_forms` (`id`),
  CONSTRAINT `custom_forms_show_producttypes_product_type_id_foreign` FOREIGN KEY (`product_type_id`) REFERENCES `products_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `dates_auto_orderrules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dates_auto_orderrules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `dates_auto_orderrules_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dates_auto_orderrules_action` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `dao_id` bigint unsigned NOT NULL,
  `criteria_startdatewithindays` int NOT NULL,
  `criteria_orderingruleid` bigint unsigned DEFAULT NULL,
  `criteria_siteid` bigint unsigned DEFAULT NULL,
  `changeto_orderingruleid` bigint unsigned NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `dao_id` (`dao_id`),
  KEY `criteria_site_id` (`criteria_siteid`),
  KEY `criteria_order_rule_id` (`criteria_orderingruleid`),
  KEY `changeto_order_rule_id` (`changeto_orderingruleid`),
  CONSTRAINT `changeto_order_rule_id` FOREIGN KEY (`changeto_orderingruleid`) REFERENCES `products_rules_ordering` (`id`) ON DELETE CASCADE,
  CONSTRAINT `criteria_order_rule_id` FOREIGN KEY (`criteria_orderingruleid`) REFERENCES `products_rules_ordering` (`id`) ON DELETE CASCADE,
  CONSTRAINT `criteria_site_id` FOREIGN KEY (`criteria_siteid`) REFERENCES `sites` (`id`),
  CONSTRAINT `mods_dates_auto_orderrules_action_dao_id_foreign` FOREIGN KEY (`dao_id`) REFERENCES `dates_auto_orderrules` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `dates_auto_orderrules_excludes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dates_auto_orderrules_excludes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `dao_id` bigint unsigned DEFAULT NULL,
  `product_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_dao` (`product_id`,`dao_id`),
  KEY `mods_dates_auto_orderrules_excludes_dao_id_foreign` (`dao_id`),
  CONSTRAINT `mods_dates_auto_orderrules_excludes_dao_id_foreign` FOREIGN KEY (`dao_id`) REFERENCES `dates_auto_orderrules` (`id`),
  CONSTRAINT `mods_dates_auto_orderrules_excludes_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `dates_auto_orderrules_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dates_auto_orderrules_products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `dao_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdaop_product_dao` (`product_id`,`dao_id`),
  KEY `mods_dates_auto_orderrules_products_dao_id_foreign` (`dao_id`),
  CONSTRAINT `mods_dates_auto_orderrules_products_dao_id_foreign` FOREIGN KEY (`dao_id`) REFERENCES `dates_auto_orderrules` (`id`),
  CONSTRAINT `mods_dates_auto_orderrules_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `discount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discount` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `exp_date` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `limit_per_order` int NOT NULL DEFAULT '1',
  `match_anyall` tinyint(1) NOT NULL COMMENT '0=all, 1=any',
  `random_generated` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `limit_uses` int NOT NULL,
  `limit_per_customer` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `discount_advantage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discount_advantage` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `discount_id` bigint unsigned NOT NULL,
  `advantage_type_id` bigint unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `apply_shipping_id` bigint unsigned DEFAULT NULL,
  `apply_shipping_country` int NOT NULL,
  `apply_shipping_distributor` int NOT NULL,
  `applyto_qty_type` tinyint(1) NOT NULL COMMENT '0=combined,1=individual',
  `applyto_qty_combined` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `discount_id` (`discount_id`),
  KEY `discount_advantage_advantage_type_id_foreign` (`advantage_type_id`),
  KEY `discount_advantage_apply_shipping_id_foreign` (`apply_shipping_id`),
  CONSTRAINT `discount_advantage_apply_shipping_id_foreign` FOREIGN KEY (`apply_shipping_id`) REFERENCES `accounts_addressbook` (`id`),
  CONSTRAINT `discount_advantage_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discount` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `discount_advantage_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discount_advantage_products` (
  `advantage_id` bigint unsigned DEFAULT NULL,
  `product_id` bigint unsigned NOT NULL,
  `applyto_qty` int NOT NULL DEFAULT '1',
  KEY `advantage_id` (`advantage_id`),
  KEY `discount_advantage_products_product_id_foreign` (`product_id`),
  CONSTRAINT `discount_advantage_products_advantage_id_foreign` FOREIGN KEY (`advantage_id`) REFERENCES `discount_advantage` (`id`),
  CONSTRAINT `discount_advantage_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `discount_advantage_producttypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discount_advantage_producttypes` (
  `advantage_id` bigint unsigned DEFAULT NULL,
  `producttype_id` bigint unsigned NOT NULL,
  `applyto_qty` int NOT NULL,
  KEY `diadpr_advantage_id` (`advantage_id`),
  KEY `discount_advantage_producttypes_producttype_id_foreign` (`producttype_id`),
  CONSTRAINT `discount_advantage_producttypes_advantage_id_foreign` FOREIGN KEY (`advantage_id`) REFERENCES `discount_advantage` (`id`),
  CONSTRAINT `discount_advantage_producttypes_producttype_id_foreign` FOREIGN KEY (`producttype_id`) REFERENCES `products_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `discount_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discount_rule` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `discount_id` bigint unsigned NOT NULL,
  `match_anyall` tinyint(1) NOT NULL COMMENT '0=all, 1=any',
  `rank` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `diru_discount_id` (`discount_id`),
  CONSTRAINT `discount_rule_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discount` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `discount_rule_condition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discount_rule_condition` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `rule_id` bigint unsigned NOT NULL,
  `condition_type_id` bigint unsigned NOT NULL,
  `required_cart_value` decimal(10,2) NOT NULL,
  `required_code` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `required_qty_type` tinyint(1) NOT NULL,
  `required_qty_combined` int NOT NULL DEFAULT '1',
  `match_anyall` tinyint(1) NOT NULL,
  `rank` int NOT NULL DEFAULT '1',
  `equals_notequals` tinyint(1) NOT NULL,
  `use_with_rules_products` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `discount_rule_condition_rule_id_foreign` (`rule_id`),
  KEY `discount_rule_condition_condition_type_id_foreign` (`condition_type_id`),
  CONSTRAINT `discount_rule_condition_rule_id_foreign` FOREIGN KEY (`rule_id`) REFERENCES `discount_rule` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `discount_rule_condition_accounttypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discount_rule_condition_accounttypes` (
  `condition_id` bigint unsigned NOT NULL,
  `accounttype_id` bigint unsigned NOT NULL,
  UNIQUE KEY `dirucoac_condition_id` (`condition_id`,`accounttype_id`),
  KEY `dirucoac_rule_id` (`condition_id`),
  KEY `dirucoac_accounttype_id` (`accounttype_id`),
  CONSTRAINT `discount_rule_condition_accounttypes_accounttype_id_foreign` FOREIGN KEY (`accounttype_id`) REFERENCES `accounts_types` (`id`),
  CONSTRAINT `discount_rule_condition_accounttypes_condition_id_foreign` FOREIGN KEY (`condition_id`) REFERENCES `discount_rule_condition` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `discount_rule_condition_attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discount_rule_condition_attributes` (
  `condition_id` bigint unsigned NOT NULL,
  `attributevalue_id` bigint unsigned NOT NULL,
  `required_qty` int NOT NULL DEFAULT '1',
  UNIQUE KEY `dirucoat_condition_id` (`condition_id`,`attributevalue_id`),
  KEY `dirucoat_rule_id` (`condition_id`),
  KEY `dirucoat_product_id` (`attributevalue_id`),
  CONSTRAINT `discount_rule_condition_attributes_attributevalue_id_foreign` FOREIGN KEY (`attributevalue_id`) REFERENCES `attributes_options` (`id`),
  CONSTRAINT `discount_rule_condition_attributes_condition_id_foreign` FOREIGN KEY (`condition_id`) REFERENCES `discount_rule_condition` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `discount_rule_condition_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discount_rule_condition_countries` (
  `condition_id` bigint unsigned NOT NULL,
  `country_id` bigint unsigned NOT NULL,
  UNIQUE KEY `dirucoco_condition_id` (`condition_id`,`country_id`),
  KEY `dirucoco_rule_id` (`condition_id`),
  KEY `dirucoco_site_id` (`country_id`),
  CONSTRAINT `discount_rule_condition_countries_condition_id_foreign` FOREIGN KEY (`condition_id`) REFERENCES `discount_rule_condition` (`id`),
  CONSTRAINT `discount_rule_condition_countries_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `discount_rule_condition_distributors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discount_rule_condition_distributors` (
  `condition_id` bigint unsigned NOT NULL,
  `distributor_id` bigint unsigned NOT NULL,
  UNIQUE KEY `dirucodi_condition_id` (`condition_id`,`distributor_id`),
  KEY `dirucodi_rule_id` (`condition_id`),
  KEY `dirucodi_site_id` (`distributor_id`),
  CONSTRAINT `discount_rule_condition_distributors_condition_id_foreign` FOREIGN KEY (`condition_id`) REFERENCES `discount_rule_condition` (`id`),
  CONSTRAINT `discount_rule_condition_distributors_distributor_id_foreign` FOREIGN KEY (`distributor_id`) REFERENCES `distributors` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `discount_rule_condition_membershiplevels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discount_rule_condition_membershiplevels` (
  `condition_id` bigint unsigned DEFAULT NULL,
  `membershiplevel_id` bigint unsigned NOT NULL,
  UNIQUE KEY `dirucome_condition_id` (`condition_id`,`membershiplevel_id`),
  KEY `dirucome_rule_id` (`condition_id`),
  KEY `dirucome_product_id` (`membershiplevel_id`),
  CONSTRAINT `discount_rule_condition_membershiplevels_condition_id_foreign` FOREIGN KEY (`condition_id`) REFERENCES `discount_rule_condition` (`id`),
  CONSTRAINT `memlvl_id` FOREIGN KEY (`membershiplevel_id`) REFERENCES `membership_levels` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `discount_rule_condition_onsalestatuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discount_rule_condition_onsalestatuses` (
  `condition_id` bigint unsigned NOT NULL,
  `onsalestatus_id` bigint unsigned NOT NULL,
  `required_qty` int NOT NULL,
  UNIQUE KEY `dirucoon_condition_id` (`condition_id`,`onsalestatus_id`),
  KEY `dirucoon_rule_id` (`condition_id`),
  KEY `dirucoon_product_id` (`onsalestatus_id`),
  CONSTRAINT `discount_rule_condition_onsalestatuses_condition_id_foreign` FOREIGN KEY (`condition_id`) REFERENCES `discount_rule_condition` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `discount_rule_condition_outofstockstatuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discount_rule_condition_outofstockstatuses` (
  `condition_id` bigint unsigned NOT NULL,
  `outofstockstatus_id` bigint unsigned NOT NULL,
  `required_qty` int NOT NULL,
  UNIQUE KEY `dirucoou_condition_id` (`condition_id`,`outofstockstatus_id`),
  KEY `dirucoou_rule_id` (`condition_id`),
  KEY `dirucoou_product_id` (`outofstockstatus_id`),
  CONSTRAINT `discount_rule_condition_outofstockstatuses_condition_id_foreign` FOREIGN KEY (`condition_id`) REFERENCES `discount_rule_condition` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `discount_rule_condition_productavailabilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discount_rule_condition_productavailabilities` (
  `condition_id` bigint unsigned NOT NULL,
  `availability_id` bigint unsigned NOT NULL,
  `required_qty` int NOT NULL,
  UNIQUE KEY `dirucopr_condition_id` (`condition_id`,`availability_id`),
  KEY `dirucopr_rule_id` (`condition_id`),
  KEY `dirucopr_product_id` (`availability_id`),
  CONSTRAINT `avail_id` FOREIGN KEY (`availability_id`) REFERENCES `products_availability` (`id`),
  CONSTRAINT `con_id` FOREIGN KEY (`condition_id`) REFERENCES `discount_rule_condition` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `discount_rule_condition_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discount_rule_condition_products` (
  `condition_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `required_qty` int NOT NULL,
  UNIQUE KEY `dirucoprocondition_id` (`condition_id`,`product_id`),
  KEY `dirucopro_rule_id` (`condition_id`),
  KEY `dirucoproproduct_id` (`product_id`),
  CONSTRAINT `discount_rule_condition_products_condition_id_foreign` FOREIGN KEY (`condition_id`) REFERENCES `discount_rule_condition` (`id`),
  CONSTRAINT `discount_rule_condition_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `discount_rule_condition_producttypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discount_rule_condition_producttypes` (
  `condition_id` bigint unsigned NOT NULL,
  `producttype_id` bigint unsigned NOT NULL,
  `required_qty` int NOT NULL,
  UNIQUE KEY `dirucoprt_condition_id` (`condition_id`,`producttype_id`),
  KEY `dirucoprt_rule_id` (`condition_id`),
  KEY `dirucoprt_product_id` (`producttype_id`),
  CONSTRAINT `cond_id` FOREIGN KEY (`condition_id`) REFERENCES `discount_rule_condition` (`id`),
  CONSTRAINT `ptype_id` FOREIGN KEY (`producttype_id`) REFERENCES `products_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `discount_rule_condition_sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discount_rule_condition_sites` (
  `condition_id` bigint unsigned NOT NULL,
  `site_id` bigint unsigned NOT NULL,
  UNIQUE KEY `dirucosi_condition_id` (`condition_id`,`site_id`),
  KEY `dirucosi_rule_id` (`condition_id`),
  KEY `dirucosi_site_id` (`site_id`),
  CONSTRAINT `discount_rule_condition_sites_condition_id_foreign` FOREIGN KEY (`condition_id`) REFERENCES `discount_rule_condition` (`id`),
  CONSTRAINT `discount_rule_condition_sites_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `discounts_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discounts_levels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apply_to` tinyint NOT NULL COMMENT '0=all products, 1=selected products, 2=not selected products',
  `action_type` tinyint(1) NOT NULL COMMENT '0=percentage, 1=site pricing',
  `action_percentage` decimal(5,2) NOT NULL,
  `action_sitepricing` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `discounts_levels_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discounts_levels_products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `discount_level_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `discount_level_id` (`discount_level_id`,`product_id`),
  KEY `discounts_levels_products_product_id_foreign` (`product_id`),
  CONSTRAINT `discounts_levels_products_discount_level_id_foreign` FOREIGN KEY (`discount_level_id`) REFERENCES `discounts_levels` (`id`),
  CONSTRAINT `discounts_levels_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `display_layouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `display_layouts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `display_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `display_sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rank` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `display_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `display_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type_id` bigint unsigned NOT NULL,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `include` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_width` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_height` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `display_templates_index_1` (`include`,`image_width`,`image_height`),
  KEY `display_templates_type_id_foreign` (`type_id`),
  CONSTRAINT `display_templates_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `display_templates_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `display_templates_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `display_templates_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `display_themes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `display_themes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `folder` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `distributors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `distributors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `email` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_no` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_dropshipper` tinyint(1) NOT NULL,
  `inventory_account_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `distributors_availabilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `distributors_availabilities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `distributor_id` bigint unsigned NOT NULL,
  `availability_id` bigint unsigned NOT NULL,
  `display` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty_min` decimal(8,2) DEFAULT NULL,
  `qty_max` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `distavail` (`distributor_id`,`availability_id`),
  KEY `distributors_availabilities_availability_id_foreign` (`availability_id`),
  CONSTRAINT `distributors_availabilities_availability_id_foreign` FOREIGN KEY (`availability_id`) REFERENCES `products_availability` (`id`),
  CONSTRAINT `distributors_availabilities_distributor_id_foreign` FOREIGN KEY (`distributor_id`) REFERENCES `distributors` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `distributors_canadapost`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `distributors_canadapost` (
  `distributor_id` bigint unsigned NOT NULL,
  `username` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_number` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contract_id` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fax` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_weight` decimal(5,1) NOT NULL,
  `test` tinyint NOT NULL,
  `discount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `label_creation` tinyint(1) NOT NULL,
  `quote_type` tinyint(1) NOT NULL COMMENT '0=commerical, 1=counter',
  `promo_code` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`distributor_id`),
  KEY `distributors_canadapost_address_id_foreign` (`address_id`),
  CONSTRAINT `distributors_canadapost_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`),
  CONSTRAINT `distributors_canadapost_distributor_id_foreign` FOREIGN KEY (`distributor_id`) REFERENCES `distributors` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `distributors_endicia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `distributors_endicia` (
  `distributor_id` bigint unsigned NOT NULL,
  `requester_id` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_id` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass_phrase` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fax` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Parcel',
  `default_weight` decimal(5,1) NOT NULL,
  `test` tinyint NOT NULL,
  `discount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `label_creation` tinyint(1) NOT NULL,
  `default_label_size` int NOT NULL,
  `default_label_rotate` tinyint(1) NOT NULL,
  `destconfirm_label_size` int NOT NULL,
  `destconfirm_label_rotate` tinyint(1) NOT NULL,
  `certified_label_size` int NOT NULL,
  `certified_label_rotate` tinyint(1) NOT NULL,
  `international_label_size` int NOT NULL,
  `international_label_rotate` tinyint(1) NOT NULL,
  `rate_type` tinyint(1) NOT NULL COMMENT '0=account, 1=list',
  `display_postage` tinyint(1) NOT NULL DEFAULT '0',
  `display_postdate` tinyint(1) NOT NULL,
  `delivery_confirmation` tinyint(1) NOT NULL,
  `signature_confirmation` tinyint(1) NOT NULL,
  `certified_mail` tinyint(1) NOT NULL,
  `restricted_delivery` tinyint(1) NOT NULL,
  `return_receipt` tinyint(1) NOT NULL,
  `electronic_return_receipt` tinyint(1) NOT NULL,
  `hold_for_pickup` tinyint(1) NOT NULL,
  `open_and_distribute` tinyint(1) NOT NULL,
  `cod` tinyint(1) NOT NULL,
  `insured_mail` tinyint(1) NOT NULL,
  `adult_signature` tinyint(1) NOT NULL,
  `registered_mail` tinyint(1) NOT NULL,
  `am_delivery` tinyint(1) NOT NULL,
  `address_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`distributor_id`),
  KEY `distributors_endicia_address_id_foreign` (`address_id`),
  CONSTRAINT `distributors_endicia_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`),
  CONSTRAINT `distributors_endicia_distributor_id_foreign` FOREIGN KEY (`distributor_id`) REFERENCES `distributors` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `distributors_fedex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `distributors_fedex` (
  `distributor_id` bigint unsigned NOT NULL,
  `accountno` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meterno` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fax` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_weight` decimal(5,1) NOT NULL,
  `test` tinyint NOT NULL,
  `discount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `label_creation` tinyint(1) NOT NULL,
  `rate_type` tinyint(1) NOT NULL COMMENT '0=account, 1=list',
  `address_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`distributor_id`),
  KEY `distributors_fedex_address_id_foreign` (`address_id`),
  CONSTRAINT `distributors_fedex_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`),
  CONSTRAINT `distributors_fedex_distributor_id_foreign` FOREIGN KEY (`distributor_id`) REFERENCES `distributors` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `distributors_genericshipping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `distributors_genericshipping` (
  `distributor_id` bigint unsigned NOT NULL,
  `contact_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fax` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`distributor_id`),
  KEY `distributors_genericshipping_address_id_foreign` (`address_id`),
  CONSTRAINT `distributors_genericshipping_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`),
  CONSTRAINT `distributors_genericshipping_distributor_id_foreign` FOREIGN KEY (`distributor_id`) REFERENCES `distributors` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `distributors_shipping_flatrates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `distributors_shipping_flatrates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `distributor_shippingmethod_id` bigint unsigned NOT NULL,
  `start_weight` decimal(8,2) NOT NULL,
  `end_weight` decimal(8,2) NOT NULL,
  `shipto_country` bigint unsigned NOT NULL,
  `status` tinyint(1) NOT NULL,
  `flat_price` decimal(8,2) NOT NULL,
  `handling_fee` decimal(8,2) NOT NULL,
  `call_for_estimate` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `distributor_id` (`distributor_shippingmethod_id`),
  CONSTRAINT `dis_smeth_id` FOREIGN KEY (`distributor_shippingmethod_id`) REFERENCES `distributors_shipping_methods` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `distributors_shipping_gateways`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `distributors_shipping_gateways` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `distributor_id` bigint unsigned NOT NULL,
  `shipping_gateway_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dishga_distship` (`distributor_id`,`shipping_gateway_id`),
  KEY `dishga_distributor_id` (`distributor_id`,`shipping_gateway_id`),
  KEY `distributors_shipping_gateways_shipping_gateway_id_foreign` (`shipping_gateway_id`),
  CONSTRAINT `distributors_shipping_gateways_distributor_id_foreign` FOREIGN KEY (`distributor_id`) REFERENCES `distributors` (`id`),
  CONSTRAINT `distributors_shipping_gateways_shipping_gateway_id_foreign` FOREIGN KEY (`shipping_gateway_id`) REFERENCES `shipping_gateways` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `distributors_shipping_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `distributors_shipping_methods` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `distributor_id` bigint unsigned NOT NULL,
  `shipping_method_id` bigint unsigned NOT NULL,
  `status` tinyint(1) NOT NULL,
  `flat_price` decimal(8,2) NOT NULL,
  `flat_use` tinyint(1) NOT NULL,
  `handling_fee` decimal(8,2) NOT NULL,
  `handling_percentage` decimal(8,2) NOT NULL,
  `call_for_estimate` tinyint(1) NOT NULL,
  `discount_rate` decimal(8,2) NOT NULL,
  `display` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `override_is_international` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dishme_distributor_id` (`distributor_id`,`shipping_method_id`),
  KEY `distributors_shipping_methods_shipping_method_id_foreign` (`shipping_method_id`),
  CONSTRAINT `distributors_shipping_methods_distributor_id_foreign` FOREIGN KEY (`distributor_id`) REFERENCES `distributors` (`id`),
  CONSTRAINT `distributors_shipping_methods_shipping_method_id_foreign` FOREIGN KEY (`shipping_method_id`) REFERENCES `shipping_methods` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `distributors_shipstation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `distributors_shipstation` (
  `distributor_id` bigint unsigned NOT NULL,
  `api_key` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_secret` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_residential` tinyint(1) NOT NULL,
  `fax` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Parcel',
  `default_weight` decimal(5,1) NOT NULL,
  `test` tinyint NOT NULL,
  `discount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `label_creation` tinyint(1) NOT NULL,
  `delivery_confirmation` tinyint(1) NOT NULL,
  `insured_mail` tinyint(1) NOT NULL,
  `storeid` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nondelivery` tinyint(1) NOT NULL,
  `address_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`distributor_id`),
  KEY `distributors_shipstation_address_id_foreign` (`address_id`),
  CONSTRAINT `distributors_shipstation_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`),
  CONSTRAINT `distributors_shipstation_distributor_id_foreign` FOREIGN KEY (`distributor_id`) REFERENCES `distributors` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `distributors_ups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `distributors_ups` (
  `distributor_id` bigint unsigned NOT NULL,
  `account_no` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `license_number` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label_creation` tinyint(1) NOT NULL,
  `address_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`distributor_id`),
  KEY `distributors_ups_address_id_foreign` (`address_id`),
  CONSTRAINT `distributors_ups_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`),
  CONSTRAINT `distributors_ups_distributor_id_foreign` FOREIGN KEY (`distributor_id`) REFERENCES `distributors` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `distributors_usps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `distributors_usps` (
  `distributor_id` bigint unsigned NOT NULL,
  `user_id` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label_creation` tinyint(1) NOT NULL,
  `address_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`distributor_id`),
  KEY `distributors_usps_address_id_foreign` (`address_id`),
  CONSTRAINT `distributors_usps_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`),
  CONSTRAINT `distributors_usps_distributor_id_foreign` FOREIGN KEY (`distributor_id`) REFERENCES `distributors` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `element_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `element_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `element_id` bigint unsigned NOT NULL,
  `language_id` bigint unsigned NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `element_translations_element_id_language_id_unique` (`element_id`,`language_id`),
  KEY `element_translations_language_id_foreign` (`language_id`),
  CONSTRAINT `element_translations_element_id_foreign` FOREIGN KEY (`element_id`) REFERENCES `elements` (`id`) ON DELETE CASCADE,
  CONSTRAINT `element_translations_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `elements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `elements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sdate` datetime NOT NULL,
  `edate` datetime NOT NULL,
  `timezone` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UTC',
  `created` datetime NOT NULL,
  `createdby` bigint unsigned NOT NULL,
  `photo` bigint unsigned DEFAULT NULL,
  `type` tinyint NOT NULL,
  `type_id` bigint unsigned NOT NULL,
  `city` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `webaddress` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(65) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `views` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `events_createdby_foreign` (`createdby`),
  KEY `events_photo_foreign` (`photo`),
  CONSTRAINT `events_createdby_foreign` FOREIGN KEY (`createdby`) REFERENCES `accounts` (`id`),
  CONSTRAINT `events_photo_foreign` FOREIGN KEY (`photo`) REFERENCES `photos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `events_toattend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events_toattend` (
  `userid` bigint unsigned NOT NULL,
  `eventid` bigint unsigned NOT NULL,
  UNIQUE KEY `userid_2` (`userid`,`eventid`),
  KEY `userid` (`userid`),
  KEY `events_toattend_eventid_foreign` (`eventid`),
  CONSTRAINT `events_toattend_eventid_foreign` FOREIGN KEY (`eventid`) REFERENCES `events` (`id`),
  CONSTRAINT `events_toattend_userid_foreign` FOREIGN KEY (`userid`) REFERENCES `accounts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `events_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `events_views`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events_views` (
  `event_id` bigint unsigned NOT NULL,
  `account_id` bigint unsigned NOT NULL,
  `viewed_date` date NOT NULL,
  `viewed_time` time NOT NULL,
  KEY `event_id` (`event_id`,`account_id`),
  KEY `events_views_account_id_foreign` (`account_id`),
  CONSTRAINT `events_views_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `events_views_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`)
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
DROP TABLE IF EXISTS `faq_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faq_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `rank` int NOT NULL,
  `url` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `faqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faqs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `rank` int NOT NULL,
  `url` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `faqs_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faqs_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `faqs_id` bigint unsigned NOT NULL,
  `categories_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `faca_content_id_2` (`faqs_id`,`categories_id`),
  KEY `faca_content_id` (`faqs_id`),
  KEY `faca_language_id` (`categories_id`),
  CONSTRAINT `faqs_categories_categories_id_foreign` FOREIGN KEY (`categories_id`) REFERENCES `faq_categories` (`id`),
  CONSTRAINT `faqs_categories_faqs_id_foreign` FOREIGN KEY (`faqs_id`) REFERENCES `faqs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `faqs_categories_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faqs_categories_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `categories_id` bigint unsigned NOT NULL,
  `language_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_id_2` (`categories_id`,`language_id`),
  KEY `content_id` (`categories_id`),
  KEY `language_id` (`language_id`),
  CONSTRAINT `faqs_categories_translations_categories_id_foreign` FOREIGN KEY (`categories_id`) REFERENCES `faq_categories` (`id`),
  CONSTRAINT `faqs_categories_translations_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `faqs_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faqs_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `faqs_id` bigint unsigned NOT NULL,
  `language_id` bigint unsigned NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fatr_content_id_2` (`faqs_id`,`language_id`),
  KEY `fatr_content_id` (`faqs_id`),
  KEY `fatr_language_id` (`language_id`),
  CONSTRAINT `faqs_translations_faqs_id_foreign` FOREIGN KEY (`faqs_id`) REFERENCES `faqs` (`id`),
  CONSTRAINT `faqs_translations_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `files` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `caption` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filetype` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `filters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `filters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `rank` int NOT NULL,
  `show_in_search` tinyint(1) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '0=avail, 1=price, 2=attributes, 3=brands, 4=product types, 5=option values',
  `field_type` tinyint(1) NOT NULL COMMENT '0=select,1=checkboxes',
  `override_parent` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `filters_attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `filters_attributes` (
  `attribute_id` bigint unsigned NOT NULL,
  `filter_id` bigint unsigned NOT NULL,
  `label` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rank` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  UNIQUE KEY `fiat_attribute_id` (`attribute_id`,`filter_id`),
  KEY `filters_attributes_filter_id_foreign` (`filter_id`),
  CONSTRAINT `filters_attributes_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`),
  CONSTRAINT `filters_attributes_filter_id_foreign` FOREIGN KEY (`filter_id`) REFERENCES `filters` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `filters_availabilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `filters_availabilities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `avail_ids` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filter_id` bigint unsigned NOT NULL,
  `label` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rank` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `filters_availabilities_filter_id_foreign` (`filter_id`),
  CONSTRAINT `filters_availabilities_filter_id_foreign` FOREIGN KEY (`filter_id`) REFERENCES `filters` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `filters_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `filters_categories` (
  `filter_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  UNIQUE KEY `ficat_filter_id` (`filter_id`,`category_id`),
  KEY `ficat_filter_id_2` (`filter_id`),
  KEY `ficat_category_id` (`category_id`),
  CONSTRAINT `filters_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `filters_categories_filter_id_foreign` FOREIGN KEY (`filter_id`) REFERENCES `filters` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `filters_pricing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `filters_pricing` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `filter_id` bigint unsigned NOT NULL,
  `label` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rank` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  `price_min` decimal(8,2) DEFAULT NULL,
  `price_max` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `filter_id` (`filter_id`),
  CONSTRAINT `filters_pricing_filter_id_foreign` FOREIGN KEY (`filter_id`) REFERENCES `filters` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `filters_productoptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `filters_productoptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filter_id` bigint unsigned NOT NULL,
  `label` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rank` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `optionfilter` (`option_name`,`filter_id`),
  KEY `filters_productoptions_filter_id_foreign` (`filter_id`),
  CONSTRAINT `filters_productoptions_filter_id_foreign` FOREIGN KEY (`filter_id`) REFERENCES `filters` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `friend_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `friend_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `account_id` bigint unsigned DEFAULT NULL,
  `friend_id` bigint unsigned DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `frre_userid` (`account_id`),
  KEY `friend_requests_friend_id_foreign` (`friend_id`),
  CONSTRAINT `friend_requests_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `friend_requests_friend_id_foreign` FOREIGN KEY (`friend_id`) REFERENCES `accounts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `friends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `friends` (
  `account_id` bigint unsigned DEFAULT NULL,
  `friend_id` bigint unsigned DEFAULT NULL,
  `rank` int NOT NULL,
  `added` datetime DEFAULT NULL,
  KEY `fr_account_id` (`account_id`),
  KEY `friends_friend_id_foreign` (`friend_id`),
  CONSTRAINT `friends_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `friends_friend_id_foreign` FOREIGN KEY (`friend_id`) REFERENCES `accounts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `friends_updates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `friends_updates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `friend_id` bigint unsigned DEFAULT NULL,
  `type` tinyint NOT NULL,
  `type_id` bigint unsigned NOT NULL,
  `num` int NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `friend_id` (`friend_id`),
  CONSTRAINT `friends_updates_friend_id_foreign` FOREIGN KEY (`friend_id`) REFERENCES `accounts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `friends_updates_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `friends_updates_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `gift_cards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gift_cards` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `card_code` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `card_exp` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `account_id` bigint unsigned NOT NULL,
  `email` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `card_code` (`card_code`,`card_exp`),
  KEY `gift_cards_account_id_foreign` (`account_id`),
  CONSTRAINT `gift_cards_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `gift_cards_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gift_cards_transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `giftcard_id` bigint unsigned NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `action` tinyint(1) NOT NULL COMMENT '0=credit,1=debit',
  `notes` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_user_id` bigint unsigned DEFAULT NULL,
  `order_id` bigint unsigned DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `giftcard_id` (`giftcard_id`),
  KEY `order_id` (`order_id`),
  KEY `gift_cards_transactions_admin_user_id_foreign` (`admin_user_id`),
  CONSTRAINT `gift_cards_transactions_admin_user_id_foreign` FOREIGN KEY (`admin_user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `gift_cards_transactions_giftcard_id_foreign` FOREIGN KEY (`giftcard_id`) REFERENCES `gift_cards` (`id`),
  CONSTRAINT `gift_cards_transactions_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `giftregistry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `giftregistry` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `account_id` bigint unsigned NOT NULL,
  `registry_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registry_type` tinyint NOT NULL,
  `event_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_date` datetime NOT NULL,
  `public_private` tinyint(1) NOT NULL,
  `private_key` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `shipto_id` bigint unsigned NOT NULL,
  `notes_to_friends` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `registrant_name` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coregistrant_name` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `baby_duedate` date NOT NULL,
  `baby_gender` tinyint(1) NOT NULL COMMENT '0=male;1=female',
  `baby_name` char(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `baby_firstchild` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gi_account_id` (`account_id`),
  KEY `giftregistry_shipto_id_foreign` (`shipto_id`),
  CONSTRAINT `giftregistry_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `giftregistry_shipto_id_foreign` FOREIGN KEY (`shipto_id`) REFERENCES `accounts_addressbook` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `giftregistry_genders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `giftregistry_genders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `giftregistry_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `giftregistry_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `registry_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `parent_product` bigint unsigned DEFAULT NULL,
  `added` datetime NOT NULL,
  `qty_wanted` decimal(8,2) NOT NULL,
  `qty_purchased` decimal(8,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `giit_registry_id` (`registry_id`),
  KEY `giftregistry_items_product_id_foreign` (`product_id`),
  KEY `giftregistry_items_parent_product_foreign` (`parent_product`),
  CONSTRAINT `giftregistry_items_parent_product_foreign` FOREIGN KEY (`parent_product`) REFERENCES `products` (`id`),
  CONSTRAINT `giftregistry_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `giftregistry_items_registry_id_foreign` FOREIGN KEY (`registry_id`) REFERENCES `giftregistry` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `giftregistry_items_purchased`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `giftregistry_items_purchased` (
  `registry_item_id` bigint unsigned NOT NULL,
  `account_id` bigint unsigned NOT NULL,
  `qty_purchased` decimal(8,2) NOT NULL,
  `order_id` bigint unsigned NOT NULL,
  `order_product_id` bigint unsigned NOT NULL,
  KEY `registry_id` (`registry_item_id`),
  KEY `giftregistry_items_purchased_account_id_foreign` (`account_id`),
  KEY `giftregistry_items_purchased_order_id_foreign` (`order_id`),
  KEY `giftregistry_items_purchased_order_product_id_foreign` (`order_product_id`),
  CONSTRAINT `giftregistry_items_purchased_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `giftregistry_items_purchased_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `giftregistry_items_purchased_order_product_id_foreign` FOREIGN KEY (`order_product_id`) REFERENCES `orders_products` (`id`),
  CONSTRAINT `giftregistry_items_purchased_registry_item_id_foreign` FOREIGN KEY (`registry_item_id`) REFERENCES `giftregistry_items` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `giftregistry_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `giftregistry_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `help_pops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `help_pops` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_caption` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inventory_image_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `images_index_1` (`id`,`filename`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `images_sizes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `images_sizes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `width` int NOT NULL,
  `height` int NOT NULL,
  `crop` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `inventory_gateways`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventory_gateways` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `loadproductsby` tinyint NOT NULL COMMENT '0=date, 1=id',
  `price_fields` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `inventory_gateways_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventory_gateways_accounts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `gateway_id` bigint unsigned NOT NULL,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transkey` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_load` datetime NOT NULL COMMENT 'Last time grabbed new products from gateway',
  `last_load_id` bigint unsigned NOT NULL,
  `last_update` datetime NOT NULL COMMENT 'Last time updated inventory counts from gateway',
  `frequency_load` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 = every 48hrs, 1 = every 24hrs, 2= every 12hrs, 3= every 6hrs, 4= every 2hrs, 5= every hr, 6=every 30mins, 7 = every 5 mins',
  `frequency_update` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 = every 48hrs, 1 = every 24hrs, 2= every 12hrs, 3= every 6hrs, 4= every 2hrs, 5= every hr, 6=every 30mins, 7 = every 5 mins',
  `last_price_sync` datetime NOT NULL,
  `last_matrix_price_sync` datetime NOT NULL,
  `update_pricing` tinyint(1) NOT NULL,
  `update_status` tinyint(1) NOT NULL,
  `update_cost` tinyint(1) NOT NULL,
  `update_weight` tinyint(1) NOT NULL,
  `create_children` tinyint(1) NOT NULL,
  `regular_price_field` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_price_field` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `onsale_formula` tinyint(1) NOT NULL COMMENT '0=none, 1=sale < reg',
  `use_taxinclusive_pricing` tinyint(1) NOT NULL,
  `custom_fields` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `timezone` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UTC',
  `payment_method` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Web Credit Card|webpayment',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `refresh_token` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `use_parent_inventory_id` tinyint(1) NOT NULL,
  `distributor_id` bigint unsigned NOT NULL,
  `base_currency` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ingaac_distributor_id` (`distributor_id`),
  KEY `inventory_gateways_accounts_gateway_id_foreign` (`gateway_id`),
  KEY `inventory_gateways_accounts_base_currency_foreign` (`base_currency`),
  CONSTRAINT `inventory_gateways_accounts_base_currency_foreign` FOREIGN KEY (`base_currency`) REFERENCES `currencies` (`id`),
  CONSTRAINT `inventory_gateways_accounts_distributor_id_foreign` FOREIGN KEY (`distributor_id`) REFERENCES `distributors` (`id`),
  CONSTRAINT `inventory_gateways_accounts_gateway_id_foreign` FOREIGN KEY (`gateway_id`) REFERENCES `inventory_gateways` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `inventory_gateways_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventory_gateways_fields` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `gateway_id` bigint unsigned NOT NULL,
  `feed_field` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_field` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `displayorvalue` tinyint(1) NOT NULL COMMENT 'display or value of product field: 0=display, 1=value',
  PRIMARY KEY (`id`),
  KEY `gateway_id` (`gateway_id`),
  CONSTRAINT `inventory_gateways_fields_gateway_id_foreign` FOREIGN KEY (`gateway_id`) REFERENCES `inventory_gateways` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `inventory_gateways_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventory_gateways_orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `gateway_account_id` bigint unsigned NOT NULL,
  `gateway_order_id` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipment_id` bigint unsigned NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `shipment_id` (`shipment_id`),
  KEY `inventory_gateways_orders_gateway_account_id_foreign` (`gateway_account_id`),
  CONSTRAINT `inventory_gateways_orders_gateway_account_id_foreign` FOREIGN KEY (`gateway_account_id`) REFERENCES `inventory_gateways_accounts` (`id`),
  CONSTRAINT `inventory_gateways_orders_shipment_id_foreign` FOREIGN KEY (`shipment_id`) REFERENCES `orders_shipments` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `inventory_gateways_scheduledtasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventory_gateways_scheduledtasks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `gateway_account_id` bigint unsigned NOT NULL,
  `task_type` tinyint NOT NULL COMMENT '1=update product prices, 2=update product inventory, 3=load new products',
  `task_start` int NOT NULL,
  `task_startdate` datetime NOT NULL,
  `task_status` tinyint(1) NOT NULL COMMENT '0=waiting, 1=processing',
  `task_modified` int NOT NULL,
  `task_custom_info` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gateway_account_id` (`gateway_account_id`),
  CONSTRAINT `inventory_gateways_scheduledtasks_gateway_account_id_foreign` FOREIGN KEY (`gateway_account_id`) REFERENCES `inventory_gateways_accounts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `inventory_gateways_scheduledtasks_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventory_gateways_scheduledtasks_products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `task_id` bigint unsigned NOT NULL,
  `products_id` bigint unsigned NOT NULL,
  `products_distributors_id` bigint unsigned NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `taskproducts` (`task_id`,`products_id`),
  KEY `taskproductsdist` (`task_id`,`products_distributors_id`),
  KEY `task_id` (`task_id`),
  KEY `products_id` (`products_id`),
  KEY `products_distributors_id` (`products_distributors_id`),
  CONSTRAINT `inventory_gateways_scheduledtasks_products_products_id_foreign` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`),
  CONSTRAINT `inventory_gateways_scheduledtasks_products_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `inventory_gateways_scheduledtasks` (`id`),
  CONSTRAINT `product_distributor_id` FOREIGN KEY (`products_distributors_id`) REFERENCES `distributors` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `inventory_gateways_sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventory_gateways_sites` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `gateway_account_id` bigint unsigned NOT NULL,
  `site_id` bigint unsigned NOT NULL,
  `update_pricing` tinyint(1) NOT NULL,
  `pricing_adjustment` decimal(8,2) NOT NULL,
  `update_status` tinyint(1) NOT NULL,
  `publish_on_import` tinyint(1) NOT NULL DEFAULT '1',
  `regular_price_field` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_price_field` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `onsale_formula` tinyint(1) NOT NULL COMMENT '0=none, 1=sale < reg',
  PRIMARY KEY (`id`),
  KEY `ingasi_site_id` (`site_id`),
  KEY `inventory_gateways_sites_gateway_account_id_foreign` (`gateway_account_id`),
  CONSTRAINT `inventory_gateways_sites_gateway_account_id_foreign` FOREIGN KEY (`gateway_account_id`) REFERENCES `inventory_gateways_accounts` (`id`),
  CONSTRAINT `inventory_gateways_sites_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `inventory_rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventory_rules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `action` tinyint NOT NULL COMMENT '0=hide, 1=change availability',
  `min_stock_qty` int DEFAULT NULL,
  `max_stock_qty` int DEFAULT NULL,
  `availabity_changeto` int NOT NULL,
  `label` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `availabity_changeto` (`availabity_changeto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `languages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `languages_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `languages_content` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `msgid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `msgid` (`msgid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `languages_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `languages_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `content_id` bigint unsigned NOT NULL,
  `language_id` bigint unsigned NOT NULL,
  `msgstr` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `latr_content_id_2` (`content_id`,`language_id`),
  KEY `latr_content_id` (`content_id`),
  KEY `latr_language_id` (`language_id`),
  CONSTRAINT `languages_translations_content_id_foreign` FOREIGN KEY (`content_id`) REFERENCES `languages_content` (`id`),
  CONSTRAINT `languages_translations_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `loyaltypoints`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `loyaltypoints` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `active_level_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `loyaltypoints_active_level_id_foreign` (`active_level_id`),
  CONSTRAINT `loyaltypoints_active_level_id_foreign` FOREIGN KEY (`active_level_id`) REFERENCES `loyaltypoints_levels` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `loyaltypoints_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `loyaltypoints_levels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `loyaltypoints_id` bigint unsigned NOT NULL,
  `points_per_dollar` tinyint NOT NULL DEFAULT '1',
  `value_per_point` decimal(5,2) NOT NULL DEFAULT '0.01',
  PRIMARY KEY (`id`),
  KEY `loyaltypoints_id` (`loyaltypoints_id`),
  CONSTRAINT `loyaltypoints_levels_loyaltypoints_id_foreign` FOREIGN KEY (`loyaltypoints_id`) REFERENCES `loyaltypoints` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `membership_attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `membership_attributes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rank` int NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `section_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `accounts_membership_attributes_section_id_foreign` (`section_id`),
  CONSTRAINT `accounts_membership_attributes_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `membership_attributes_sections` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `membership_attributes_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `membership_attributes_sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rank` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `membership_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `membership_levels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rank` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  `annual_product_id` bigint unsigned NOT NULL,
  `monthly_product_id` bigint unsigned DEFAULT NULL,
  `renewal_discount` decimal(5,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `signupemail_customer` bigint unsigned DEFAULT NULL,
  `renewemail_customer` bigint unsigned DEFAULT NULL,
  `expirationalert1_email` bigint unsigned DEFAULT NULL,
  `expirationalert2_email` bigint unsigned DEFAULT NULL,
  `expiration_email` bigint unsigned DEFAULT NULL,
  `affiliate_level_id` bigint unsigned NOT NULL,
  `is_default` tinyint(1) NOT NULL,
  `signuprenew_option` tinyint(1) NOT NULL DEFAULT '1',
  `auto_renewal_of` bigint unsigned DEFAULT NULL,
  `trial` tinyint(1) NOT NULL DEFAULT '0',
  `paypal_plan_id` varchar(85) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auto_renew_reward` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `accounts_membership_levels_auto_renewal_of_foreign` (`auto_renewal_of`),
  KEY `accounts_membership_levels_annual_product_id_foreign` (`annual_product_id`),
  KEY `accounts_membership_levels_monthly_product_id_foreign` (`monthly_product_id`),
  KEY `accounts_membership_levels_affiliate_level_id_foreign` (`affiliate_level_id`),
  CONSTRAINT `accounts_membership_levels_affiliate_level_id_foreign` FOREIGN KEY (`affiliate_level_id`) REFERENCES `affiliates_levels` (`id`),
  CONSTRAINT `accounts_membership_levels_annual_product_id_foreign` FOREIGN KEY (`annual_product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `accounts_membership_levels_auto_renewal_of_foreign` FOREIGN KEY (`auto_renewal_of`) REFERENCES `membership_levels` (`id`),
  CONSTRAINT `accounts_membership_levels_monthly_product_id_foreign` FOREIGN KEY (`monthly_product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `membership_levels_attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `membership_levels_attributes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `level_id` bigint unsigned NOT NULL,
  `attribute_id` bigint unsigned NOT NULL,
  `attribute_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `level_id` (`level_id`,`attribute_id`),
  KEY `accounts_membership_levels_attributes_attribute_id_foreign` (`attribute_id`),
  CONSTRAINT `accounts_membership_levels_attributes_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `membership_attributes` (`id`),
  CONSTRAINT `accounts_membership_levels_attributes_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `membership_levels` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `membership_levels_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `membership_levels_settings` (
  `level_id` bigint unsigned NOT NULL,
  `badge` int NOT NULL,
  `search_limit` int NOT NULL,
  `event_limit` int NOT NULL,
  `ad_limit` int NOT NULL,
  PRIMARY KEY (`level_id`),
  CONSTRAINT `accounts_membership_levels_settings_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `membership_levels` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `membership_payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `membership_payment_methods` (
  `site_id` bigint unsigned NOT NULL,
  `payment_method_id` bigint unsigned NOT NULL,
  `gateway_account_id` bigint unsigned NOT NULL,
  KEY `site_id` (`site_id`),
  KEY `accounts_memberships_payment_methods_payment_method_id_foreign` (`payment_method_id`),
  KEY `accounts_memberships_payment_methods_gateway_account_id_foreign` (`gateway_account_id`),
  CONSTRAINT `accounts_memberships_payment_methods_gateway_account_id_foreign` FOREIGN KEY (`gateway_account_id`) REFERENCES `payment_gateways_accounts` (`id`),
  CONSTRAINT `accounts_memberships_payment_methods_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`),
  CONSTRAINT `accounts_memberships_payment_methods_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `membership_subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `membership_subscriptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `level_id` bigint unsigned DEFAULT NULL,
  `amount_paid` decimal(8,2) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `account_id` bigint unsigned DEFAULT NULL,
  `order_id` bigint unsigned DEFAULT NULL,
  `subscription_price` decimal(8,2) NOT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `cancelled` datetime DEFAULT NULL,
  `expirealert1_sent` tinyint(1) NOT NULL DEFAULT '0',
  `expirealert2_sent` tinyint(1) NOT NULL DEFAULT '0',
  `expire_sent` tinyint(1) NOT NULL DEFAULT '0',
  `auto_renew` tinyint(1) NOT NULL DEFAULT '0',
  `renew_payment_method` tinyint DEFAULT NULL,
  `renew_payment_profile_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `amem_account_id` (`account_id`),
  KEY `accounts_memberships_level_id_foreign` (`level_id`),
  KEY `accounts_memberships_product_id_foreign` (`product_id`),
  KEY `accounts_memberships_order_id_foreign` (`order_id`),
  CONSTRAINT `accounts_memberships_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `accounts_memberships_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `membership_levels` (`id`),
  CONSTRAINT `accounts_memberships_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `accounts_memberships_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `parent` bigint unsigned DEFAULT NULL,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(65) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rank` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `menu_parent_foreign` (`parent`),
  CONSTRAINT `menu_parent_foreign` FOREIGN KEY (`parent`) REFERENCES `menu` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `menu_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu_links` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `link_type` tinyint(1) NOT NULL COMMENT '1=url, 2=system, 3=javascript',
  `label` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` enum('_blank','_self','_parent','_top') COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_link` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `system_link` int NOT NULL COMMENT '1=home, 2=contact, 3=myaccount, 4=cart, 5=checkout, 6=wishlist',
  `javascript_link` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `menus_catalogcategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menus_catalogcategories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `rank` int NOT NULL,
  `submenu_levels` tinyint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`),
  KEY `menus_catalogcategories_category_id_foreign` (`category_id`),
  CONSTRAINT `menus_catalogcategories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `menus_catalogcategories_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `menus_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menus_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `rank` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `meca_menu_id` (`menu_id`),
  KEY `menus_categories_category_id_foreign` (`category_id`),
  CONSTRAINT `menus_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `menus_categories_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `menus_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menus_links` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` bigint unsigned NOT NULL,
  `links_id` bigint unsigned NOT NULL,
  `rank` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `meli_menu_id` (`menu_id`),
  KEY `menus_links_links_id_foreign` (`links_id`),
  CONSTRAINT `menus_links_links_id_foreign` FOREIGN KEY (`links_id`) REFERENCES `menu_links` (`id`),
  CONSTRAINT `menus_links_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `menus_menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menus_menus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` bigint unsigned NOT NULL,
  `child_menu_id` bigint unsigned NOT NULL,
  `rank` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `meme_menu_id` (`menu_id`),
  KEY `menus_menus_child_menu_id_foreign` (`child_menu_id`),
  CONSTRAINT `menus_menus_child_menu_id_foreign` FOREIGN KEY (`child_menu_id`) REFERENCES `menus` (`id`),
  CONSTRAINT `menus_menus_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `menus_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menus_pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` bigint unsigned NOT NULL,
  `page_id` bigint unsigned NOT NULL,
  `rank` int NOT NULL,
  `target` enum('_blank','_self','_parent','_top') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `sub_pagemenu_id` bigint unsigned NOT NULL,
  `sub_categorymenu_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mepa_menu_id` (`menu_id`),
  KEY `menus_pages_page_id_foreign` (`page_id`),
  CONSTRAINT `menus_pages_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`),
  CONSTRAINT `menus_pages_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `menus_sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menus_sites` (
  `menu_id` bigint unsigned NOT NULL,
  `site_id` bigint unsigned NOT NULL,
  `rank` int NOT NULL,
  KEY `mesi_site_id` (`site_id`),
  KEY `menus_sites_menu_id_foreign` (`menu_id`),
  CONSTRAINT `menus_sites_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`),
  CONSTRAINT `menus_sites_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `message_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `message_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `html_body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `system_id` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `message_templates_system_id_index` (`system_id`)
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
DROP TABLE IF EXISTS `mod_resort_details_amenities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mod_resort_details_amenities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `config_values` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `showinmenu` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `file` (`file`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `modules_admin_controllers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modules_admin_controllers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `module_id` bigint unsigned NOT NULL,
  `controller_section` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module_id` (`module_id`),
  CONSTRAINT `modules_admin_controllers_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `modules_crons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modules_crons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `module_id` bigint unsigned NOT NULL,
  `type` tinyint(1) NOT NULL,
  `function` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_run` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `mocr_module_id` (`module_id`),
  KEY `type` (`type`),
  CONSTRAINT `modules_crons_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `modules_crons_scheduledtasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modules_crons_scheduledtasks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `task_type` int NOT NULL COMMENT '1=update product prices, 2=update product inventory, 3=load new products',
  `task_start` int NOT NULL,
  `task_startdate` datetime NOT NULL,
  `task_status` tinyint(1) NOT NULL COMMENT '0=waiting, 1=processing',
  `task_remaining` int NOT NULL,
  `task_modified` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `modules_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modules_fields` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `module_id` bigint unsigned NOT NULL,
  `field_name` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mofi_module_id` (`module_id`),
  CONSTRAINT `modules_fields_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `modules_site_controllers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modules_site_controllers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `module_id` bigint unsigned NOT NULL,
  `controller_section` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `showinmenu` tinyint(1) NOT NULL,
  `menu_label` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_link` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mosico_module_id` (`module_id`),
  CONSTRAINT `modules_site_controllers_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `modules_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modules_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_template_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `modules_templates_parent_template_id_foreign` (`parent_template_id`),
  CONSTRAINT `modules_templates_parent_template_id_foreign` FOREIGN KEY (`parent_template_id`) REFERENCES `modules_templates` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `modules_templates_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modules_templates_modules` (
  `template_id` bigint unsigned DEFAULT NULL,
  `section_id` bigint unsigned NOT NULL,
  `module_id` bigint unsigned DEFAULT NULL,
  `rank` tinyint NOT NULL,
  `temp_id` bigint unsigned NOT NULL,
  KEY `layout_id` (`template_id`),
  KEY `modules_templates_modules_section_id_foreign` (`section_id`),
  KEY `modules_templates_modules_module_id_foreign` (`module_id`),
  CONSTRAINT `modules_templates_modules_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`),
  CONSTRAINT `modules_templates_modules_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `display_sections` (`id`),
  CONSTRAINT `modules_templates_modules_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `modules_templates` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `modules_templates_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modules_templates_sections` (
  `template_id` bigint unsigned DEFAULT NULL,
  `section_id` bigint unsigned NOT NULL,
  `temp_id` bigint unsigned NOT NULL,
  KEY `motese_layout_id` (`template_id`),
  KEY `modules_templates_sections_section_id_foreign` (`section_id`),
  CONSTRAINT `modules_templates_sections_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `display_sections` (`id`),
  CONSTRAINT `modules_templates_sections_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `modules_templates` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `options_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `options_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `options_templates_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `options_templates_images` (
  `template_id` bigint unsigned NOT NULL,
  `image_id` bigint unsigned NOT NULL,
  KEY `template_id` (`template_id`),
  KEY `options_templates_images_image_id_foreign` (`image_id`),
  CONSTRAINT `options_templates_images_image_id_foreign` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`),
  CONSTRAINT `options_templates_images_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `options_templates` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `options_templates_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `options_templates_options` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_id` bigint unsigned NOT NULL,
  `show_with_thumbnail` tinyint(1) NOT NULL,
  `rank` int NOT NULL,
  `required` tinyint(1) NOT NULL,
  `template_id` bigint unsigned DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `opteop_product_id` (`template_id`),
  CONSTRAINT `options_templates_options_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `options_templates` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `options_templates_options_custom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `options_templates_options_custom` (
  `value_id` bigint unsigned NOT NULL,
  `custom_type` tinyint(1) NOT NULL COMMENT '0=text, 1=textarea, 2=color',
  `custom_charlimit` int NOT NULL,
  `custom_label` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_instruction` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  UNIQUE KEY `value_id` (`value_id`),
  CONSTRAINT `options_templates_options_custom_value_id_foreign` FOREIGN KEY (`value_id`) REFERENCES `options_templates_options_values` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `options_templates_options_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `options_templates_options_values` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `option_id` bigint unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `rank` int NOT NULL,
  `image_id` bigint unsigned NOT NULL,
  `is_custom` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `option_id` (`option_id`),
  KEY `options_templates_options_values_image_id_foreign` (`image_id`),
  CONSTRAINT `options_templates_options_values_image_id_foreign` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`),
  CONSTRAINT `options_templates_options_values_option_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `options_templates_options` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ordering_rule_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ordering_rule_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `rule_id` bigint unsigned NOT NULL,
  `language_id` bigint unsigned NOT NULL,
  `name` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ordering_rule_translations_rule_id_language_id_unique` (`rule_id`,`language_id`),
  KEY `ordering_rule_translations_language_id_foreign` (`language_id`),
  CONSTRAINT `ordering_rule_translations_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ordering_rule_translations_rule_id_foreign` FOREIGN KEY (`rule_id`) REFERENCES `products_rules_ordering` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_no` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_id` bigint unsigned DEFAULT NULL,
  `billing_address_id` bigint unsigned DEFAULT NULL,
  `shipping_address_id` bigint unsigned DEFAULT NULL,
  `order_phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'only use if no account',
  `order_email` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'only use if no account',
  `order_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_method` int NOT NULL,
  `payment_method_fee` decimal(8,4) DEFAULT NULL,
  `addtl_discount` decimal(10,2) NOT NULL,
  `addtl_fee` decimal(10,2) NOT NULL,
  `comments` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_id` bigint unsigned NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0 = active, 1 = archived',
  `inventory_order_id` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_account_id_index` (`account_id`),
  KEY `orders_site_id_foreign` (`site_id`),
  KEY `orders_billing_address_id_foreign` (`billing_address_id`),
  KEY `orders_shipping_address_id_foreign` (`shipping_address_id`),
  CONSTRAINT `orders_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `orders_billing_address_id_foreign` FOREIGN KEY (`billing_address_id`) REFERENCES `addresses` (`id`),
  CONSTRAINT `orders_shipping_address_id_foreign` FOREIGN KEY (`shipping_address_id`) REFERENCES `addresses` (`id`),
  CONSTRAINT `orders_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orders_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_activities` (
  `order_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  KEY `orac_order_id` (`order_id`),
  CONSTRAINT `orders_activities_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orders_customforms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_customforms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `form_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `product_type_id` bigint unsigned DEFAULT NULL,
  `form_count` int NOT NULL,
  `form_values` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orcu_order_id` (`order_id`),
  KEY `orders_customforms_form_id_foreign` (`form_id`),
  KEY `orders_customforms_product_id_foreign` (`product_id`),
  KEY `orders_customforms_product_type_id_foreign` (`product_type_id`),
  CONSTRAINT `orders_customforms_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `custom_forms` (`id`),
  CONSTRAINT `orders_customforms_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `orders_customforms_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `orders_customforms_product_type_id_foreign` FOREIGN KEY (`product_type_id`) REFERENCES `products_types` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orders_discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_discounts` (
  `order_id` bigint unsigned NOT NULL,
  `discount_id` bigint unsigned DEFAULT NULL,
  `amount` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `advantage_id` bigint unsigned DEFAULT NULL,
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `ordi_order_id` (`order_id`),
  KEY `orders_discounts_discount_id_foreign` (`discount_id`),
  KEY `orders_discounts_advantage_id_foreign` (`advantage_id`),
  CONSTRAINT `orders_discounts_advantage_id_foreign` FOREIGN KEY (`advantage_id`) REFERENCES `discount_advantage` (`id`),
  CONSTRAINT `orders_discounts_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discount` (`id`),
  CONSTRAINT `orders_discounts_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orders_message_keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_message_keys` (
  `key_id` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key_var` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`key_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orders_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_notes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `user_id` int NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `orno_order_id` (`order_id`),
  CONSTRAINT `orders_notes_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orders_packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_packages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `shipment_id` bigint unsigned DEFAULT NULL,
  `package_type` int NOT NULL,
  `package_size` int NOT NULL,
  `is_dryice` tinyint(1) NOT NULL,
  `dryice_weight` decimal(5,1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `orpa_shipment_id` (`shipment_id`),
  CONSTRAINT `orders_packages_shipment_id_foreign` FOREIGN KEY (`shipment_id`) REFERENCES `orders_shipments` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orders_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `product_qty` int NOT NULL,
  `product_price` decimal(8,2) NOT NULL,
  `product_notes` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_saleprice` decimal(8,2) NOT NULL,
  `product_onsale` tinyint(1) NOT NULL,
  `actual_product_id` bigint unsigned NOT NULL,
  `package_id` bigint unsigned NOT NULL,
  `parent_product_id` bigint unsigned DEFAULT NULL COMMENT 'If accessory showing as option, id of product that this should show under',
  `product_label` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registry_item_id` bigint unsigned DEFAULT NULL,
  `free_from_discount_advantage` int NOT NULL,
  `cart_item_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orpr_order_id` (`order_id`,`product_id`,`package_id`),
  KEY `orpr_order_id_3` (`order_id`,`product_id`,`actual_product_id`),
  KEY `orpr_order_id_2` (`order_id`),
  KEY `orpr_product_id` (`product_id`),
  KEY `orpr_actual_product_id` (`actual_product_id`),
  KEY `orpr_package_id` (`package_id`),
  KEY `orders_products_registry_item_id_foreign` (`registry_item_id`),
  KEY `orders_products_cart_item_id_foreign` (`cart_item_id`),
  CONSTRAINT `orders_products_actual_product_id_foreign` FOREIGN KEY (`actual_product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `orders_products_cart_item_id_foreign` FOREIGN KEY (`cart_item_id`) REFERENCES `cart_items` (`id`),
  CONSTRAINT `orders_products_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `orders_products_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `orders_packages` (`id`),
  CONSTRAINT `orders_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `orders_products_registry_item_id_foreign` FOREIGN KEY (`registry_item_id`) REFERENCES `giftregistry_items` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orders_products_customfields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_products_customfields` (
  `orders_products_id` bigint unsigned NOT NULL,
  `form_id` bigint unsigned NOT NULL,
  `section_id` bigint unsigned NOT NULL,
  `field_id` bigint unsigned NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  UNIQUE KEY `orprcu_orders_products_id_2` (`orders_products_id`,`form_id`,`section_id`,`field_id`),
  KEY `orprcu_orders_products_id` (`orders_products_id`),
  KEY `orders_products_customfields_form_id_foreign` (`form_id`),
  KEY `orders_products_customfields_section_id_foreign` (`section_id`),
  KEY `orders_products_customfields_field_id_foreign` (`field_id`),
  CONSTRAINT `orders_products_customfields_field_id_foreign` FOREIGN KEY (`field_id`) REFERENCES `custom_fields` (`id`),
  CONSTRAINT `orders_products_customfields_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `custom_forms` (`id`),
  CONSTRAINT `orders_products_customfields_orders_products_id_foreign` FOREIGN KEY (`orders_products_id`) REFERENCES `orders_products` (`id`),
  CONSTRAINT `orders_products_customfields_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `custom_forms_sections` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orders_products_customsinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_products_customsinfo` (
  `orders_products_id` bigint unsigned NOT NULL,
  `customs_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customs_weight` decimal(5,2) NOT NULL,
  `customs_value` decimal(8,2) NOT NULL,
  UNIQUE KEY `orprcuin_orders_products_id` (`orders_products_id`),
  CONSTRAINT `orders_products_customsinfo_orders_products_id_foreign` FOREIGN KEY (`orders_products_id`) REFERENCES `orders_products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orders_products_discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_products_discounts` (
  `orders_products_id` bigint unsigned NOT NULL,
  `discount_id` bigint unsigned DEFAULT NULL,
  `advantage_id` bigint unsigned DEFAULT NULL,
  `amount` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int NOT NULL,
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `orprdi_orders_products_id` (`orders_products_id`),
  KEY `orders_products_discounts_discount_id_foreign` (`discount_id`),
  KEY `orders_products_discounts_advantage_id_foreign` (`advantage_id`),
  CONSTRAINT `orders_products_discounts_advantage_id_foreign` FOREIGN KEY (`advantage_id`) REFERENCES `discount_advantage` (`id`),
  CONSTRAINT `orders_products_discounts_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discount` (`id`),
  CONSTRAINT `orders_products_discounts_orders_products_id_foreign` FOREIGN KEY (`orders_products_id`) REFERENCES `orders_products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orders_products_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_products_options` (
  `orders_products_id` bigint unsigned DEFAULT NULL,
  `value_id` bigint unsigned DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `custom_value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `orders_products_id_3` (`orders_products_id`),
  KEY `orders_products_options_value_id_foreign` (`value_id`),
  CONSTRAINT `orders_products_options_orders_products_id_foreign` FOREIGN KEY (`orders_products_id`) REFERENCES `orders_products` (`id`),
  CONSTRAINT `orders_products_options_value_id_foreign` FOREIGN KEY (`value_id`) REFERENCES `products_options_values` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orders_products_sentemails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_products_sentemails` (
  `orders_products_id` bigint unsigned DEFAULT NULL,
  `email_id` bigint unsigned NOT NULL,
  KEY `op_id` (`orders_products_id`),
  KEY `email_id` (`email_id`),
  CONSTRAINT `orders_products_sentemails_email_id_foreign` FOREIGN KEY (`email_id`) REFERENCES `message_templates` (`id`),
  CONSTRAINT `orders_products_sentemails_op_id_foreign` FOREIGN KEY (`orders_products_id`) REFERENCES `orders_products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orders_shipments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_shipments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `distributor_id` bigint unsigned DEFAULT NULL,
  `ship_method_id` bigint unsigned DEFAULT NULL,
  `order_status_id` bigint unsigned DEFAULT '1',
  `ship_tracking_no` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ship_cost` decimal(8,2) NOT NULL,
  `ship_date` datetime DEFAULT NULL,
  `future_ship_date` datetime DEFAULT NULL,
  `delivery_date` datetime DEFAULT NULL,
  `signed_for_by` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_downloads` tinyint(1) NOT NULL,
  `last_status_update` datetime DEFAULT NULL,
  `saturday_delivery` tinyint(1) NOT NULL,
  `alcohol` tinyint(1) NOT NULL,
  `dangerous_goods` tinyint(1) NOT NULL,
  `dangerous_goods_accessibility` tinyint(1) NOT NULL,
  `hold_at_location` tinyint(1) NOT NULL,
  `hold_at_location_address` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `signature_required` int NOT NULL,
  `cod` tinyint(1) NOT NULL,
  `cod_amount` decimal(10,2) NOT NULL,
  `cod_currency` int NOT NULL,
  `insured` tinyint(1) NOT NULL,
  `insured_value` decimal(10,2) NOT NULL,
  `archived` tinyint(1) NOT NULL COMMENT '0 = active, 1 = archived',
  `inventory_order_id` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registry_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `orsh_order_id` (`order_id`,`ship_method_id`),
  KEY `orsh_distributor_id` (`distributor_id`),
  KEY `archived` (`archived`),
  KEY `orders_shipments_ship_method_id_foreign` (`ship_method_id`),
  KEY `orders_shipments_order_status_id_foreign` (`order_status_id`),
  CONSTRAINT `orders_shipments_distributor_id_foreign` FOREIGN KEY (`distributor_id`) REFERENCES `distributors` (`id`),
  CONSTRAINT `orders_shipments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `orders_shipments_order_status_id_foreign` FOREIGN KEY (`order_status_id`) REFERENCES `orders_statuses` (`id`),
  CONSTRAINT `orders_shipments_ship_method_id_foreign` FOREIGN KEY (`ship_method_id`) REFERENCES `shipping_methods` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orders_shipments_labels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_shipments_labels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `shipment_id` bigint unsigned NOT NULL,
  `package_id` bigint unsigned NOT NULL,
  `filename` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label_size_id` bigint unsigned NOT NULL,
  `gateway_label_id` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tracking_no` varchar(65) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orsila_filename` (`filename`),
  KEY `orsila_shipment_id` (`shipment_id`),
  KEY `orsila_package_id` (`package_id`),
  KEY `orders_shipments_labels_label_size_id_foreign` (`label_size_id`),
  CONSTRAINT `orders_shipments_labels_label_size_id_foreign` FOREIGN KEY (`label_size_id`) REFERENCES `shipping_label_sizes` (`id`),
  CONSTRAINT `orders_shipments_labels_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `orders_packages` (`id`),
  CONSTRAINT `orders_shipments_labels_shipment_id_foreign` FOREIGN KEY (`shipment_id`) REFERENCES `orders_shipments` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orders_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_statuses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rank` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orders_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_tasks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `orta_order_id` (`order_id`),
  CONSTRAINT `orders_tasks_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orders_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned DEFAULT NULL,
  `transaction_no` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `original_amount` decimal(10,2) NOT NULL,
  `cc_no` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cc_exp` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint NOT NULL COMMENT '1 = Authorized, 2 = Captured, 3 = Voided',
  `billing_address_id` bigint unsigned DEFAULT NULL,
  `payment_method_id` bigint unsigned NOT NULL,
  `gateway_account_id` bigint unsigned DEFAULT NULL,
  `created` timestamp NOT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  `cim_payment_profile_id` bigint unsigned DEFAULT NULL,
  `capture_on_shipment` int NOT NULL,
  `voided_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ortr_order_id` (`order_id`),
  KEY `orders_transactions_payment_method_id_foreign` (`payment_method_id`),
  KEY `orders_transactions_cim_payment_profile_id_foreign` (`cim_payment_profile_id`),
  KEY `orders_transactions_billing_address_id_foreign` (`billing_address_id`),
  KEY `orders_transactions_gateway_account_id_foreign` (`gateway_account_id`),
  CONSTRAINT `orders_transactions_billing_address_id_foreign` FOREIGN KEY (`billing_address_id`) REFERENCES `addresses` (`id`),
  CONSTRAINT `orders_transactions_cim_payment_profile_id_foreign` FOREIGN KEY (`cim_payment_profile_id`) REFERENCES `cim_profile_paymentprofile` (`id`),
  CONSTRAINT `orders_transactions_gateway_account_id_foreign` FOREIGN KEY (`gateway_account_id`) REFERENCES `payment_gateways_accounts` (`id`),
  CONSTRAINT `orders_transactions_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `orders_transactions_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orders_transactions_credits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_transactions_credits` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `orders_transactions_id` bigint unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `recorded` datetime NOT NULL,
  `transaction_id` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_transactions_id` (`orders_transactions_id`),
  CONSTRAINT `orders_transactions_credits_orders_transactions_id_foreign` FOREIGN KEY (`orders_transactions_id`) REFERENCES `orders_transactions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orders_transactions_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_transactions_statuses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `page_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `page_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `page_id` bigint unsigned NOT NULL,
  `language_id` bigint unsigned NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_translations_page_id_language_id_unique` (`page_id`,`language_id`),
  KEY `page_translations_language_id_foreign` (`language_id`),
  CONSTRAINT `page_translations_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `page_translations_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `notes` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pages_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_category_id` bigint unsigned DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `pages_categories_parent_category_id_foreign` (`parent_category_id`),
  CONSTRAINT `pages_categories_parent_category_id_foreign` FOREIGN KEY (`parent_category_id`) REFERENCES `pages_categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pages_categories_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages_categories_pages` (
  `category_id` bigint unsigned NOT NULL,
  `page_id` bigint unsigned NOT NULL,
  `rank` int NOT NULL,
  KEY `pacapa_menu_id` (`category_id`),
  KEY `pages_categories_pages_page_id_foreign` (`page_id`),
  CONSTRAINT `pages_categories_pages_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `pages_categories` (`id`),
  CONSTRAINT `pages_categories_pages_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pages_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages_settings` (
  `page_id` bigint unsigned NOT NULL,
  `settings_template_id` bigint unsigned DEFAULT NULL,
  `module_template_id` bigint unsigned DEFAULT NULL,
  `layout_id` bigint unsigned DEFAULT NULL,
  `module_custom_values` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `module_override_values` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`page_id`),
  KEY `pages_settings_settings_template_id_foreign` (`settings_template_id`),
  KEY `pages_settings_module_template_id_foreign` (`module_template_id`),
  KEY `pages_settings_layout_id_foreign` (`layout_id`),
  CONSTRAINT `pages_settings_layout_id_foreign` FOREIGN KEY (`layout_id`) REFERENCES `display_layouts` (`id`),
  CONSTRAINT `pages_settings_module_template_id_foreign` FOREIGN KEY (`module_template_id`) REFERENCES `modules_templates` (`id`),
  CONSTRAINT `pages_settings_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`),
  CONSTRAINT `pages_settings_settings_template_id_foreign` FOREIGN KEY (`settings_template_id`) REFERENCES `pages_settings_templates` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pages_settings_sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages_settings_sites` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `page_id` bigint unsigned DEFAULT NULL,
  `site_id` bigint unsigned DEFAULT NULL,
  `settings_template_id` bigint unsigned DEFAULT NULL,
  `layout_id` bigint unsigned DEFAULT NULL,
  `module_template_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pasesi_product_id_2` (`page_id`,`site_id`),
  KEY `pasesi_product_id` (`page_id`),
  KEY `pages_settings_sites_settings_template_id_foreign` (`settings_template_id`),
  KEY `pages_settings_sites_layout_id_foreign` (`layout_id`),
  KEY `pages_settings_sites_site_id_foreign` (`site_id`),
  KEY `pages_settings_sites_module_template_id_foreign` (`module_template_id`),
  CONSTRAINT `pages_settings_sites_layout_id_foreign` FOREIGN KEY (`layout_id`) REFERENCES `display_layouts` (`id`),
  CONSTRAINT `pages_settings_sites_module_template_id_foreign` FOREIGN KEY (`module_template_id`) REFERENCES `modules_templates` (`id`),
  CONSTRAINT `pages_settings_sites_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`),
  CONSTRAINT `pages_settings_sites_settings_template_id_foreign` FOREIGN KEY (`settings_template_id`) REFERENCES `pages_settings_templates` (`id`),
  CONSTRAINT `pages_settings_sites_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pages_settings_sites_modulevalues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages_settings_sites_modulevalues` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `page_id` bigint unsigned NOT NULL,
  `site_id` bigint unsigned DEFAULT NULL,
  `section_id` bigint unsigned NOT NULL,
  `module_id` bigint unsigned NOT NULL,
  `field_id` bigint unsigned DEFAULT NULL,
  `custom_value` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pasesimo_product_id_3` (`page_id`,`site_id`,`section_id`,`module_id`,`field_id`),
  KEY `pasesimo_product_id_2` (`page_id`,`site_id`),
  KEY `pasesimo_product_id` (`page_id`),
  KEY `pages_settings_sites_modulevalues_section_id_foreign` (`section_id`),
  KEY `pages_settings_sites_modulevalues_field_id_foreign` (`field_id`),
  KEY `pages_settings_sites_modulevalues_site_id_foreign` (`site_id`),
  KEY `pages_settings_sites_modulevalues_module_id_foreign` (`module_id`),
  CONSTRAINT `pages_settings_sites_modulevalues_field_id_foreign` FOREIGN KEY (`field_id`) REFERENCES `modules_fields` (`id`),
  CONSTRAINT `pages_settings_sites_modulevalues_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`),
  CONSTRAINT `pages_settings_sites_modulevalues_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`),
  CONSTRAINT `pages_settings_sites_modulevalues_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `display_sections` (`id`),
  CONSTRAINT `pages_settings_sites_modulevalues_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pages_settings_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages_settings_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `layout_id` bigint unsigned DEFAULT NULL,
  `module_template_id` bigint unsigned DEFAULT NULL,
  `settings_template_id` bigint unsigned DEFAULT NULL,
  `module_custom_values` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pages_settings_templates_settings_template_id_foreign` (`settings_template_id`),
  KEY `pages_settings_templates_module_template_id_foreign` (`module_template_id`),
  KEY `pages_settings_templates_layout_id_foreign` (`layout_id`),
  CONSTRAINT `pages_settings_templates_layout_id_foreign` FOREIGN KEY (`layout_id`) REFERENCES `display_layouts` (`id`),
  CONSTRAINT `pages_settings_templates_module_template_id_foreign` FOREIGN KEY (`module_template_id`) REFERENCES `modules_templates` (`id`),
  CONSTRAINT `pages_settings_templates_settings_template_id_foreign` FOREIGN KEY (`settings_template_id`) REFERENCES `pages_settings_templates` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pages_settings_templates_modulevalues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages_settings_templates_modulevalues` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `settings_template_id` bigint unsigned NOT NULL,
  `section_id` bigint unsigned NOT NULL,
  `module_id` bigint unsigned NOT NULL,
  `field_id` bigint unsigned NOT NULL,
  `custom_value` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `pasetemo_settings_template_id` (`settings_template_id`),
  KEY `fields_id` (`field_id`),
  KEY `sections_id` (`section_id`),
  KEY `modules_id` (`module_id`),
  CONSTRAINT `fields_id` FOREIGN KEY (`field_id`) REFERENCES `modules_fields` (`id`),
  CONSTRAINT `modules_id` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`),
  CONSTRAINT `sections_id` FOREIGN KEY (`section_id`) REFERENCES `display_sections` (`id`),
  CONSTRAINT `setting_template_id` FOREIGN KEY (`settings_template_id`) REFERENCES `pages_settings_templates` (`id`)
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
DROP TABLE IF EXISTS `payment_gateways`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_gateways` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `template` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_creditcard` tinyint(1) NOT NULL DEFAULT '1',
  `classname` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `payment_gateways_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_gateways_accounts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `gateway_id` bigint unsigned NOT NULL,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `use_cvv` tinyint(1) NOT NULL,
  `currency_code` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `use_test` tinyint(1) NOT NULL,
  `custom_fields` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `limitby_country` tinyint(1) NOT NULL COMMENT '0=no,1=billing,2=shipping,3=billing not,4=shipping not',
  PRIMARY KEY (`id`),
  KEY `payment_gateways_accounts_gateway_id_foreign` (`gateway_id`),
  CONSTRAINT `payment_gateways_accounts_gateway_id_foreign` FOREIGN KEY (`gateway_id`) REFERENCES `payment_gateways` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `payment_gateways_accounts_limitcountries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_gateways_accounts_limitcountries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `gateway_account_id` bigint unsigned NOT NULL,
  `country_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pagaacli_gateway_account_id` (`gateway_account_id`,`country_id`),
  KEY `countries_id` (`country_id`),
  CONSTRAINT `countries_id` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  CONSTRAINT `gateways_account_id` FOREIGN KEY (`gateway_account_id`) REFERENCES `payment_gateways_accounts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `payment_gateways_errors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_gateways_errors` (
  `created` datetime NOT NULL,
  `response` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gateway_account_id` bigint unsigned NOT NULL,
  KEY `payment_gateways_errors_gateway_account_id_foreign` (`gateway_account_id`),
  CONSTRAINT `payment_gateways_errors_gateway_account_id_foreign` FOREIGN KEY (`gateway_account_id`) REFERENCES `payment_gateways_accounts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_methods` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gateway_id` bigint unsigned DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `template` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `limitby_country` tinyint(1) NOT NULL COMMENT '0=no,1=billing,2=shipping,3=billing not,4=shipping not',
  `feeby_country` tinyint(1) NOT NULL COMMENT '0=billing, 1=shipping',
  `supports_auto_renewal` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `payment_methods_gateway_id_foreign` (`gateway_id`),
  CONSTRAINT `payment_methods_gateway_id_foreign` FOREIGN KEY (`gateway_id`) REFERENCES `payment_gateways` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `payment_methods_limitcountries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_methods_limitcountries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `payment_method_id` bigint unsigned NOT NULL,
  `country_id` bigint unsigned NOT NULL,
  `fee` decimal(8,4) DEFAULT NULL,
  `limiting` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payment_method_id` (`payment_method_id`,`country_id`),
  KEY `payment_methods_limitcountries_country_id_foreign` (`country_id`),
  CONSTRAINT `payment_methods_limitcountries_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  CONSTRAINT `payment_methods_limitcountries_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `paypal_subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paypal_subscriptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `gateway_account_id` int NOT NULL,
  `paypal_subscription_id` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approval_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL,
  `activated_at` timestamp NULL DEFAULT NULL,
  `order_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
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
DROP TABLE IF EXISTS `photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `photos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `added` datetime NOT NULL,
  `addedby` bigint unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `album` bigint unsigned DEFAULT NULL,
  `approved` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `addedby` (`addedby`),
  KEY `album` (`album`),
  CONSTRAINT `photos_addedby_foreign` FOREIGN KEY (`addedby`) REFERENCES `accounts` (`id`),
  CONSTRAINT `photos_album_foreign` FOREIGN KEY (`album`) REFERENCES `photos_albums` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `photos_albums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `photos_albums` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint NOT NULL,
  `type_id` bigint unsigned NOT NULL,
  `recent_photo_id` bigint unsigned NOT NULL,
  `updated` datetime DEFAULT NULL,
  `photos_count` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `photos_albums_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `photos_albums_type` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `photos_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `photos_comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `photo_id` bigint unsigned NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_id` bigint unsigned DEFAULT NULL,
  `created` datetime NOT NULL,
  `beenread` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `photo_id` (`photo_id`),
  KEY `read` (`beenread`),
  KEY `photos_comments_account_id_foreign` (`account_id`),
  CONSTRAINT `photos_comments_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `photos_comments_photo_id_foreign` FOREIGN KEY (`photo_id`) REFERENCES `photos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `photos_favorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `photos_favorites` (
  `account_id` bigint unsigned DEFAULT NULL,
  `photo_id` bigint unsigned DEFAULT NULL,
  KEY `phfa_user_id` (`account_id`,`photo_id`),
  KEY `photos_favorites_photo_id_foreign` (`photo_id`),
  CONSTRAINT `photos_favorites_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `photos_favorites_photo_id_foreign` FOREIGN KEY (`photo_id`) REFERENCES `photos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `photos_sizes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `photos_sizes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `width` int NOT NULL,
  `height` int NOT NULL,
  `crop` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pricing_rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pricing_rules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pricing_rules_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pricing_rules_levels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `rule_id` bigint unsigned NOT NULL,
  `min_qty` int NOT NULL,
  `max_qty` int NOT NULL,
  `amount_type` tinyint(1) NOT NULL COMMENT '0=percentage, 1=flat amount',
  `amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `prrule_rule_id` (`rule_id`),
  CONSTRAINT `pricing_rules_levels_rule_id_foreign` FOREIGN KEY (`rule_id`) REFERENCES `pricing_rules` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `product_option_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_option_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_option_id` bigint unsigned NOT NULL,
  `language_id` bigint unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `option_language_id` (`product_option_id`,`language_id`),
  KEY `option_language_id_foreign` (`language_id`),
  CONSTRAINT `option_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_option_id_foreign` FOREIGN KEY (`product_option_id`) REFERENCES `products_options` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `product_option_value_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_option_value_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_option_value_id` bigint unsigned NOT NULL,
  `language_id` bigint unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `value_language_id` (`product_option_value_id`,`language_id`),
  KEY `value_language_id_foreign` (`language_id`),
  CONSTRAINT `value_id_foreign` FOREIGN KEY (`product_option_value_id`) REFERENCES `products_options_values` (`id`) ON DELETE CASCADE,
  CONSTRAINT `value_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `product_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `language_id` bigint unsigned NOT NULL,
  `title` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customs_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary` longtext COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_translations_product_id_language_id_unique` (`product_id`,`language_id`),
  UNIQUE KEY `product_translations_url_name_unique` (`url_name`),
  KEY `product_translations_language_id_foreign` (`language_id`),
  CONSTRAINT `product_translations_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_translations_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `parent_product` bigint unsigned DEFAULT NULL,
  `title` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_outofstockstatus_id` bigint unsigned DEFAULT NULL,
  `details_img_id` bigint unsigned DEFAULT NULL,
  `category_img_id` bigint unsigned DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `product_no` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `combined_stock_qty` decimal(8,2) DEFAULT '1.00',
  `default_cost` decimal(10,4) DEFAULT '0.0000',
  `weight` decimal(5,2) DEFAULT '0.00',
  `created` datetime NOT NULL,
  `default_distributor_id` bigint unsigned DEFAULT NULL,
  `fulfillment_rule_id` bigint unsigned DEFAULT NULL,
  `url_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inventory_id` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customs_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tariff_number` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_origin` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inventoried` tinyint(1) NOT NULL DEFAULT '1',
  `shared_inventory_id` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `addtocart_setting` enum('0','1','2') COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `addtocart_external_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `addtocart_external_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `has_children` tinyint(1) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url_name` (`url_name`),
  KEY `titleurl` (`url_name`,`title`),
  KEY `products_index_1` (`status`,`parent_product`,`has_children`,`inventoried`,`id`,`default_outofstockstatus_id`),
  KEY `parent_product_2` (`parent_product`,`status`),
  KEY `parent_product` (`parent_product`),
  KEY `title` (`title`),
  KEY `subtitle` (`subtitle`),
  KEY `category_img_id` (`category_img_id`),
  KEY `prods_status` (`status`),
  KEY `product_no` (`product_no`),
  KEY `combined_stock_qty` (`combined_stock_qty`),
  KEY `fulfillment_rule_id` (`fulfillment_rule_id`),
  KEY `meta_keywords` (`meta_keywords`),
  KEY `inventory_id` (`inventory_id`),
  KEY `shared_inv` (`shared_inventory_id`),
  KEY `has_children` (`has_children`),
  KEY `products_details_img_id_foreign` (`details_img_id`),
  KEY `products_default_distributor_id_foreign` (`default_distributor_id`),
  KEY `products_default_outofstockstatus_id_foreign` (`default_outofstockstatus_id`),
  CONSTRAINT `products_category_img_id_foreign` FOREIGN KEY (`category_img_id`) REFERENCES `images` (`id`),
  CONSTRAINT `products_default_distributor_id_foreign` FOREIGN KEY (`default_distributor_id`) REFERENCES `distributors` (`id`),
  CONSTRAINT `products_default_outofstockstatus_id_foreign` FOREIGN KEY (`default_outofstockstatus_id`) REFERENCES `products_availability` (`id`),
  CONSTRAINT `products_details_img_id_foreign` FOREIGN KEY (`details_img_id`) REFERENCES `images` (`id`),
  CONSTRAINT `products_parent_product_foreign` FOREIGN KEY (`parent_product`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_accessories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_accessories` (
  `product_id` bigint unsigned NOT NULL,
  `accessory_id` bigint unsigned NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `show_as_option` tinyint(1) NOT NULL DEFAULT '0',
  `discount_percentage` tinyint(1) DEFAULT '0',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_actions` tinyint(1) DEFAULT '0',
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `prac_product_id` (`product_id`),
  KEY `products_accessories_accessory_id_foreign` (`accessory_id`),
  CONSTRAINT `products_accessories_accessory_id_foreign` FOREIGN KEY (`accessory_id`) REFERENCES `products` (`id`),
  CONSTRAINT `products_accessories_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_accessories_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_accessories_fields` (
  `product_id` bigint unsigned NOT NULL,
  `accessories_fields_id` bigint unsigned NOT NULL,
  `rank` int NOT NULL,
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `pracfi_product_id` (`product_id`),
  KEY `products_accessories_fields_accessories_fields_id_foreign` (`accessories_fields_id`),
  CONSTRAINT `products_accessories_fields_accessories_fields_id_foreign` FOREIGN KEY (`accessories_fields_id`) REFERENCES `accessories_fields` (`id`),
  CONSTRAINT `products_accessories_fields_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_attributes` (
  `product_id` bigint unsigned NOT NULL,
  `option_id` bigint unsigned DEFAULT NULL,
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `prat_product_id_2` (`product_id`,`option_id`),
  KEY `prat_product_id` (`product_id`),
  KEY `products_attributes_option_id_foreign` (`option_id`),
  CONSTRAINT `products_attributes_option_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `attributes_options` (`id`),
  CONSTRAINT `products_attributes_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_availability`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_availability` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty_min` decimal(8,2) DEFAULT NULL,
  `qty_max` decimal(8,2) DEFAULT NULL,
  `auto_adjust` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `products-availability_index_1` (`auto_adjust`,`id`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_children_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_children_options` (
  `product_id` bigint unsigned NOT NULL,
  `option_id` bigint unsigned NOT NULL,
  UNIQUE KEY `prchop_product_id_2` (`product_id`,`option_id`),
  KEY `prchop_product_id` (`product_id`),
  KEY `prchop_option_id` (`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_details` (
  `product_id` bigint unsigned NOT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_attributes` text COLLATE utf8mb4_unicode_ci,
  `type_id` bigint unsigned DEFAULT NULL,
  `brand_id` bigint unsigned DEFAULT NULL,
  `rating` decimal(4,1) NOT NULL DEFAULT '0.0',
  `views_30days` int NOT NULL DEFAULT '0',
  `views_90days` int NOT NULL DEFAULT '0',
  `views_180days` int NOT NULL DEFAULT '0',
  `views_1year` int NOT NULL DEFAULT '0',
  `views_all` int NOT NULL DEFAULT '0',
  `orders_30days` int NOT NULL DEFAULT '0',
  `orders_90days` int NOT NULL DEFAULT '0',
  `orders_180days` int NOT NULL DEFAULT '0',
  `orders_1year` int NOT NULL DEFAULT '0',
  `orders_all` int NOT NULL DEFAULT '0',
  `downloadable` tinyint(1) NOT NULL DEFAULT '0',
  `downloadable_file` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_category_id` bigint unsigned DEFAULT NULL,
  `orders_updated` datetime DEFAULT NULL,
  `views_updated` datetime DEFAULT NULL,
  `create_children_auto` tinyint(1) NOT NULL DEFAULT '0',
  `display_children_grid` tinyint(1) NOT NULL DEFAULT '0',
  `override_parent_description` tinyint(1) NOT NULL DEFAULT '0',
  `allow_pricing_discount` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`product_id`),
  KEY `brand_id` (`brand_id`),
  KEY `products_details_type_id_foreign` (`type_id`),
  KEY `products_details_default_category_id_foreign` (`default_category_id`),
  CONSTRAINT `products_details_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  CONSTRAINT `products_details_default_category_id_foreign` FOREIGN KEY (`default_category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `products_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `products_details_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `products_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_distributors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_distributors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `distributor_id` bigint unsigned DEFAULT NULL,
  `stock_qty` decimal(8,2) NOT NULL,
  `outofstockstatus_id` bigint unsigned DEFAULT NULL,
  `cost` decimal(12,4) DEFAULT NULL,
  `inventory_id` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `prdi_product_id_2` (`product_id`,`distributor_id`,`inventory_id`),
  KEY `prdi_proddist` (`product_id`,`distributor_id`),
  KEY `prdi_product_id` (`product_id`),
  KEY `prdi_inventory_id` (`inventory_id`),
  KEY `products_distributors_distributor_id_foreign` (`distributor_id`),
  CONSTRAINT `products_distributors_distributor_id_foreign` FOREIGN KEY (`distributor_id`) REFERENCES `distributors` (`id`),
  CONSTRAINT `products_distributors_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_images` (
  `product_id` bigint unsigned NOT NULL,
  `image_id` bigint unsigned NOT NULL,
  `caption` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rank` tinyint(1) DEFAULT NULL,
  `show_in_gallery` tinyint(1) DEFAULT '0',
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `prim_prodimage` (`product_id`,`image_id`),
  KEY `prim_product_id` (`product_id`),
  KEY `prim_image_id` (`image_id`),
  CONSTRAINT `products_images_image_id_foreign` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`),
  CONSTRAINT `products_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_log` (
  `product_id` bigint unsigned DEFAULT NULL,
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `productdistributor_id` bigint unsigned NOT NULL,
  `action_type` tinyint NOT NULL COMMENT '0=stock qty change',
  `changed_from` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `changed_to` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logged` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `prlo_product_id` (`product_id`),
  KEY `prlo_productdistributor_id` (`productdistributor_id`),
  CONSTRAINT `products_log_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `products_log_productdistributor_id_foreign` FOREIGN KEY (`productdistributor_id`) REFERENCES `products_distributors` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_needschildren`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_needschildren` (
  `product_id` bigint unsigned NOT NULL,
  `option_id` bigint unsigned NOT NULL,
  `qty` int NOT NULL,
  `account_level` text COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `prne_product_id` (`product_id`),
  KEY `products_needschildren_option_id_foreign` (`option_id`),
  CONSTRAINT `products_needschildren_option_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `products_options` (`id`),
  CONSTRAINT `products_needschildren_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_options` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_id` bigint unsigned NOT NULL,
  `show_with_thumbnail` tinyint(1) NOT NULL DEFAULT '0',
  `rank` int NOT NULL DEFAULT '0',
  `required` tinyint(1) NOT NULL DEFAULT '1',
  `product_id` bigint unsigned DEFAULT NULL,
  `is_template` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `prop_nametypeidstatus` (`name`,`type_id`,`product_id`,`status`),
  KEY `prop_products_options_index_1` (`status`,`product_id`),
  KEY `prop_product_id` (`product_id`),
  KEY `products_options_type_id_foreign` (`type_id`),
  CONSTRAINT `products_options_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `products_options_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `products_options_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_options_custom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_options_custom` (
  `value_id` bigint unsigned NOT NULL,
  `custom_type` tinyint(1) NOT NULL COMMENT '0=text, 1=textarea, 2=color',
  `custom_charlimit` int NOT NULL,
  `custom_label` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_instruction` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  UNIQUE KEY `propcu_value_id` (`value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_options_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_options_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_options_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_options_values` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `option_id` bigint unsigned DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `rank` int NOT NULL DEFAULT '0',
  `image_id` bigint unsigned DEFAULT NULL,
  `is_custom` tinyint(1) NOT NULL DEFAULT '0',
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `propva_option_id` (`option_id`),
  KEY `propva_status` (`status`),
  KEY `products_options_values_image_id_foreign` (`image_id`),
  CONSTRAINT `products_options_values_image_id_foreign` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`),
  CONSTRAINT `products_options_values_option_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `products_options` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_pricing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_pricing` (
  `product_id` bigint unsigned NOT NULL,
  `site_id` bigint unsigned DEFAULT NULL,
  `price_reg` decimal(10,4) NOT NULL,
  `price_sale` decimal(10,4) DEFAULT NULL,
  `onsale` tinyint(1) NOT NULL DEFAULT '0',
  `min_qty` int DEFAULT '1',
  `max_qty` int DEFAULT NULL,
  `feature` tinyint(1) NOT NULL DEFAULT '0',
  `pricing_rule_id` bigint unsigned DEFAULT NULL,
  `ordering_rule_id` bigint unsigned DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `published_date` datetime DEFAULT NULL,
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `prodsite` (`product_id`,`site_id`),
  KEY `products_pricing_index_1` (`status`,`site_id`,`product_id`,`ordering_rule_id`),
  KEY `status` (`status`),
  KEY `products_pricing_site_id_foreign` (`site_id`),
  KEY `products_pricing_pricing_rule_id_foreign` (`pricing_rule_id`),
  KEY `products_pricing_ordering_rule_id_foreign` (`ordering_rule_id`),
  CONSTRAINT `products_pricing_ordering_rule_id_foreign` FOREIGN KEY (`ordering_rule_id`) REFERENCES `products_rules_ordering` (`id`),
  CONSTRAINT `products_pricing_pricing_rule_id_foreign` FOREIGN KEY (`pricing_rule_id`) REFERENCES `pricing_rules` (`id`),
  CONSTRAINT `products_pricing_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `products_pricing_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_pricing_temp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_pricing_temp` (
  `product_id` bigint unsigned NOT NULL,
  `site_id` bigint unsigned DEFAULT NULL,
  `price_reg` decimal(8,2) NOT NULL,
  `price_sale` decimal(8,2) NOT NULL,
  `onsale` tinyint(1) NOT NULL,
  `min_qty` int NOT NULL DEFAULT '1',
  `max_qty` int NOT NULL DEFAULT '0',
  `feature` tinyint(1) NOT NULL,
  `pricing_rule_id` bigint unsigned DEFAULT NULL,
  `ordering_rule_id` bigint unsigned DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  KEY `prprte_product_id` (`product_id`,`site_id`),
  KEY `products_pricing_temp_site_id_foreign` (`site_id`),
  KEY `products_pricing_temp_pricing_rule_id_foreign` (`pricing_rule_id`),
  KEY `products_pricing_temp_ordering_rule_id_foreign` (`ordering_rule_id`),
  CONSTRAINT `products_pricing_temp_ordering_rule_id_foreign` FOREIGN KEY (`ordering_rule_id`) REFERENCES `products_rules_ordering` (`id`),
  CONSTRAINT `products_pricing_temp_pricing_rule_id_foreign` FOREIGN KEY (`pricing_rule_id`) REFERENCES `pricing_rules` (`id`),
  CONSTRAINT `products_pricing_temp_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `products_pricing_temp_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_related`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_related` (
  `product_id` bigint unsigned NOT NULL,
  `related_id` bigint unsigned NOT NULL,
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `prre_product_id` (`product_id`),
  KEY `prre_related_id` (`related_id`),
  CONSTRAINT `products_related_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `products_related_related_id_foreign` FOREIGN KEY (`related_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_resort`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_resort` (
  `product_id` bigint unsigned NOT NULL,
  `resort_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`product_id`),
  CONSTRAINT `products_resort_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `item_type` tinyint(1) NOT NULL,
  `item_id` bigint unsigned NOT NULL COMMENT 'product or attribute id',
  `name` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `prrev_item_type` (`item_type`,`item_id`),
  KEY `prrev_product_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_rules_fulfillment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_rules_fulfillment` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `any_all` enum('any','all') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_rules_fulfillment_conditions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_rules_fulfillment_conditions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `rule_id` bigint unsigned NOT NULL,
  `type` enum('has_stock','logged_in','account_type','shipping_country','shipping_state','shipping_zipcode','stock_greaterthan_qtyordering','has_most_stock') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `any_all` enum('all','any') COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_distributor` int NOT NULL,
  `score` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `prrufuco_rule_id` (`rule_id`),
  KEY `prrufuco_type` (`type`),
  KEY `prrufuco_status` (`status`),
  CONSTRAINT `products_rules_fulfillment_conditions_rule_id_foreign` FOREIGN KEY (`rule_id`) REFERENCES `products_rules_fulfillment` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_rules_fulfillment_conditions_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_rules_fulfillment_conditions_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `condition_id` bigint unsigned NOT NULL,
  `item_id` bigint unsigned NOT NULL,
  `value` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `condition_id` (`condition_id`),
  CONSTRAINT `products_rules_fulfillment_conditions_items_condition_id_foreign` FOREIGN KEY (`condition_id`) REFERENCES `products_rules_fulfillment_conditions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_rules_fulfillment_distributors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_rules_fulfillment_distributors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `rule_id` bigint unsigned NOT NULL,
  `distributor_id` bigint unsigned NOT NULL,
  `rank` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `prrufudi_parent_rule_id` (`rule_id`,`distributor_id`),
  KEY `prrufudi_rule_id` (`rule_id`),
  KEY `prrufudi_child_rule_id` (`distributor_id`),
  CONSTRAINT `products_rules_fulfillment_distributors_distributor_id_foreign` FOREIGN KEY (`distributor_id`) REFERENCES `distributors` (`id`),
  CONSTRAINT `products_rules_fulfillment_distributors_rule_id_foreign` FOREIGN KEY (`rule_id`) REFERENCES `products_rules_fulfillment` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_rules_fulfillment_rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_rules_fulfillment_rules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `parent_rule_id` bigint unsigned DEFAULT NULL,
  `child_rule_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `prrufuru_parent_rule_id` (`parent_rule_id`,`child_rule_id`),
  KEY `prrufuru_rule_id` (`parent_rule_id`),
  KEY `prrufuru_child_rule_id` (`child_rule_id`),
  CONSTRAINT `products_rules_fulfillment_rules_child_rule_id_foreign` FOREIGN KEY (`child_rule_id`) REFERENCES `products_rules_fulfillment` (`id`),
  CONSTRAINT `products_rules_fulfillment_rules_parent_rule_id_foreign` FOREIGN KEY (`parent_rule_id`) REFERENCES `products_rules_fulfillment` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_rules_ordering`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_rules_ordering` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `any_all` enum('any','all') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `products-rules-ordering_index_1` (`status`,`id`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_rules_ordering_conditions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_rules_ordering_conditions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `rule_id` bigint unsigned DEFAULT NULL,
  `type` enum('required_account','required_account_type','required_account_specialty') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `any_all` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prruorco_rule_id` (`rule_id`),
  KEY `prruorco_type` (`type`),
  KEY `prruorco_status` (`status`),
  CONSTRAINT `products_rules_ordering_conditions_rule_id_foreign` FOREIGN KEY (`rule_id`) REFERENCES `products_rules_ordering` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_rules_ordering_conditions_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_rules_ordering_conditions_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `condition_id` bigint unsigned NOT NULL,
  `item_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `prruorcoit_condition_id` (`condition_id`),
  KEY `products_rules_ordering_conditions_items_item_id_foreign` (`item_id`),
  CONSTRAINT `products_rules_ordering_conditions_items_condition_id_foreign` FOREIGN KEY (`condition_id`) REFERENCES `products_rules_ordering_conditions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_rules_ordering_rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_rules_ordering_rules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `parent_rule_id` bigint unsigned DEFAULT NULL,
  `child_rule_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `prruorrul_parent_rule_id` (`parent_rule_id`,`child_rule_id`),
  KEY `prruorrul_rule_id` (`parent_rule_id`),
  KEY `prruorrul_child_rule_id` (`child_rule_id`),
  CONSTRAINT `products_rules_ordering_rules_child_rule_id_foreign` FOREIGN KEY (`child_rule_id`) REFERENCES `products_rules_ordering` (`id`),
  CONSTRAINT `products_rules_ordering_rules_parent_rule_id_foreign` FOREIGN KEY (`parent_rule_id`) REFERENCES `products_rules_ordering` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_settings` (
  `product_id` bigint unsigned NOT NULL,
  `settings_template_id` bigint unsigned DEFAULT NULL,
  `product_detail_template` int DEFAULT NULL,
  `product_thumbnail_template` int DEFAULT NULL,
  `product_zoom_template` int DEFAULT NULL,
  `product_related_count` int NOT NULL DEFAULT '0',
  `product_brands_count` int NOT NULL DEFAULT '0',
  `product_related_template` int DEFAULT NULL,
  `product_brands_template` int DEFAULT NULL,
  `show_brands_products` tinyint(1) NOT NULL DEFAULT '0',
  `show_related_products` tinyint(1) NOT NULL DEFAULT '0',
  `show_specs` tinyint(1) NOT NULL DEFAULT '0',
  `show_reviews` tinyint(1) NOT NULL DEFAULT '0',
  `layout_id` bigint unsigned DEFAULT NULL,
  `module_template_id` bigint unsigned DEFAULT NULL,
  `module_custom_values` text COLLATE utf8mb4_unicode_ci,
  `module_override_values` text COLLATE utf8mb4_unicode_ci,
  `use_default_related` tinyint(1) NOT NULL DEFAULT '1',
  `use_default_brand` tinyint(1) NOT NULL DEFAULT '1',
  `use_default_specs` tinyint(1) NOT NULL DEFAULT '1',
  `use_default_reviews` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`product_id`),
  KEY `products_settings_settings_template_id_foreign` (`settings_template_id`),
  KEY `products_settings_layout_id_foreign` (`layout_id`),
  KEY `products_settings_module_template_id_foreign` (`module_template_id`),
  CONSTRAINT `products_settings_layout_id_foreign` FOREIGN KEY (`layout_id`) REFERENCES `display_layouts` (`id`),
  CONSTRAINT `products_settings_module_template_id_foreign` FOREIGN KEY (`module_template_id`) REFERENCES `modules_templates` (`id`),
  CONSTRAINT `products_settings_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `products_settings_settings_template_id_foreign` FOREIGN KEY (`settings_template_id`) REFERENCES `products_settings_templates` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_settings_sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_settings_sites` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `site_id` bigint unsigned DEFAULT NULL,
  `settings_template_id` bigint unsigned DEFAULT NULL,
  `product_detail_template` int DEFAULT NULL,
  `product_thumbnail_template` int DEFAULT NULL,
  `product_zoom_template` int DEFAULT NULL,
  `layout_id` bigint unsigned DEFAULT NULL,
  `module_template_id` bigint unsigned DEFAULT NULL,
  `settings_template_id_default` int DEFAULT NULL,
  `layout_id_default` int DEFAULT NULL,
  `module_template_id_default` int DEFAULT NULL,
  `product_detail_template_default` int DEFAULT NULL,
  `product_thumbnail_template_default` int DEFAULT NULL,
  `product_zoom_template_default` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `prsesi_product_id_2` (`product_id`,`site_id`),
  KEY `prsesi_product_id` (`product_id`),
  KEY `prsesi_site_id` (`site_id`),
  KEY `products_settings_sites_settings_template_id_foreign` (`settings_template_id`),
  KEY `products_settings_sites_layout_id_foreign` (`layout_id`),
  KEY `products_settings_sites_module_template_id_foreign` (`module_template_id`),
  CONSTRAINT `products_settings_sites_layout_id_foreign` FOREIGN KEY (`layout_id`) REFERENCES `display_layouts` (`id`),
  CONSTRAINT `products_settings_sites_module_template_id_foreign` FOREIGN KEY (`module_template_id`) REFERENCES `modules_templates` (`id`),
  CONSTRAINT `products_settings_sites_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `products_settings_sites_settings_template_id_foreign` FOREIGN KEY (`settings_template_id`) REFERENCES `products_settings_templates` (`id`),
  CONSTRAINT `products_settings_sites_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_settings_sites_modulevalues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_settings_sites_modulevalues` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `site_id` bigint unsigned DEFAULT NULL,
  `section_id` bigint unsigned NOT NULL,
  `module_id` bigint unsigned NOT NULL,
  `field_id` bigint unsigned DEFAULT NULL,
  `custom_value` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `prsesimo_product_id_3` (`product_id`,`site_id`,`section_id`,`module_id`,`field_id`),
  KEY `prsesimo_product_id_2` (`product_id`,`site_id`),
  KEY `prsesimo_product_id` (`product_id`),
  KEY `products_settings_sites_modulevalues_section_id_foreign` (`section_id`),
  KEY `products_settings_sites_modulevalues_module_id_foreign` (`module_id`),
  KEY `products_settings_sites_modulevalues_field_id_foreign` (`field_id`),
  KEY `products_settings_sites_modulevalues_site_id_foreign` (`site_id`),
  CONSTRAINT `products_settings_sites_modulevalues_field_id_foreign` FOREIGN KEY (`field_id`) REFERENCES `modules_fields` (`id`),
  CONSTRAINT `products_settings_sites_modulevalues_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`),
  CONSTRAINT `products_settings_sites_modulevalues_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `products_settings_sites_modulevalues_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `display_sections` (`id`),
  CONSTRAINT `products_settings_sites_modulevalues_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_settings_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_settings_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `settings_template_id` bigint unsigned DEFAULT NULL,
  `product_detail_template` int DEFAULT NULL,
  `product_thumbnail_template` int DEFAULT NULL,
  `product_zoom_template` int DEFAULT NULL,
  `layout_id` bigint unsigned DEFAULT NULL,
  `module_template_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_settings_templates_settings_template_id_foreign` (`settings_template_id`),
  KEY `products_settings_templates_layout_id_foreign` (`layout_id`),
  KEY `products_settings_templates_module_template_id_foreign` (`module_template_id`),
  CONSTRAINT `products_settings_templates_layout_id_foreign` FOREIGN KEY (`layout_id`) REFERENCES `display_layouts` (`id`),
  CONSTRAINT `products_settings_templates_module_template_id_foreign` FOREIGN KEY (`module_template_id`) REFERENCES `modules_templates` (`id`),
  CONSTRAINT `products_settings_templates_settings_template_id_foreign` FOREIGN KEY (`settings_template_id`) REFERENCES `products_settings_templates` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_settings_templates_modulevalues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_settings_templates_modulevalues` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `settings_template_id` bigint unsigned NOT NULL,
  `section_id` bigint unsigned NOT NULL,
  `module_id` bigint unsigned NOT NULL,
  `field_id` bigint unsigned DEFAULT NULL,
  `custom_value` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `prsetemo_settings_template_id` (`settings_template_id`),
  KEY `products_settings_templates_modulevalues_section_id_foreign` (`section_id`),
  KEY `products_settings_templates_modulevalues_module_id_foreign` (`module_id`),
  KEY `products_settings_templates_modulevalues_field_id_foreign` (`field_id`),
  CONSTRAINT `category_setting_template_id` FOREIGN KEY (`settings_template_id`) REFERENCES `categories_settings_templates` (`id`),
  CONSTRAINT `products_settings_templates_modulevalues_field_id_foreign` FOREIGN KEY (`field_id`) REFERENCES `modules_fields` (`id`),
  CONSTRAINT `products_settings_templates_modulevalues_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`),
  CONSTRAINT `products_settings_templates_modulevalues_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `display_sections` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_sorts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_sorts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orderby` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sortby` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `rank` int NOT NULL,
  `isdefault` tinyint(1) NOT NULL,
  `display` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `categories_only` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_specialties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_specialties` (
  `product_id` bigint unsigned NOT NULL,
  `specialty_id` bigint unsigned NOT NULL,
  KEY `prspec_product_id` (`product_id`),
  KEY `products_specialties_specialty_id_foreign` (`specialty_id`),
  CONSTRAINT `products_specialties_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `products_specialties_specialty_id_foreign` FOREIGN KEY (`specialty_id`) REFERENCES `specialties` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_specialties_check`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_specialties_check` (
  `product_id` bigint unsigned NOT NULL,
  `specialties` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `prspch_product_id` (`product_id`),
  CONSTRAINT `products_specialties_check_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_specialtiesaccountsrules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_specialtiesaccountsrules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `accounts` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `specialties` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rule_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `prspacru_accounts` (`accounts`,`specialties`),
  KEY `prspacru_product_id` (`accounts`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_tasks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `prta_product_id` (`product_id`),
  CONSTRAINT `products_tasks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_types_attributes_sets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_types_attributes_sets` (
  `type_id` bigint unsigned NOT NULL,
  `set_id` bigint unsigned DEFAULT NULL,
  UNIQUE KEY `products_types_attributes_sets_type_id_set_id_unique` (`type_id`,`set_id`),
  KEY `type_id` (`type_id`,`set_id`),
  KEY `products_types_attributes_sets_set_id_foreign` (`set_id`),
  CONSTRAINT `products_types_attributes_sets_set_id_foreign` FOREIGN KEY (`set_id`) REFERENCES `attributes_sets` (`id`),
  CONSTRAINT `products_types_attributes_sets_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `products_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_viewed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_viewed` (
  `product_id` bigint unsigned NOT NULL,
  `viewed` datetime NOT NULL,
  KEY `prvi_product_id` (`product_id`),
  CONSTRAINT `products_viewed_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `registration_discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registration_discounts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `registration_id` bigint unsigned NOT NULL,
  `discount_id` bigint unsigned NOT NULL,
  `advantage_id` bigint unsigned NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `registration_discounts_registration_id_foreign` (`registration_id`),
  KEY `registration_discounts_discount_id_foreign` (`discount_id`),
  KEY `registration_discounts_advantage_id_foreign` (`advantage_id`),
  CONSTRAINT `registration_discounts_advantage_id_foreign` FOREIGN KEY (`advantage_id`) REFERENCES `discount_advantage` (`id`),
  CONSTRAINT `registration_discounts_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discount` (`id`),
  CONSTRAINT `registration_discounts_registration_id_foreign` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `registrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `account_id` bigint unsigned NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `recovery_hash` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level_id` bigint unsigned DEFAULT NULL,
  `payment_method_id` bigint unsigned DEFAULT NULL,
  `affiliate_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `registrations_account_id_foreign` (`account_id`),
  KEY `registrations_level_id_foreign` (`level_id`),
  KEY `registrations_payment_method_id_foreign` (`payment_method_id`),
  KEY `registrations_affiliate_id_foreign` (`affiliate_id`),
  CONSTRAINT `registrations_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `registrations_affiliate_id_foreign` FOREIGN KEY (`affiliate_id`) REFERENCES `affiliates` (`id`),
  CONSTRAINT `registrations_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `membership_levels` (`id`),
  CONSTRAINT `registrations_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `criteria` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_id` tinyint NOT NULL,
  `ready` tinyint(1) NOT NULL,
  `from_date` datetime DEFAULT NULL,
  `to_date` datetime DEFAULT NULL,
  `breakdown` tinyint NOT NULL,
  `restart` int NOT NULL,
  `variables` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `reports_breakdowns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reports_breakdowns` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `reports_products_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reports_products_fields` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `reports_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reports_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `resorts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `resorts` (
  `attribute_option_id` bigint unsigned NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comments` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `fax` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `contact_addr` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `contact_city` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `contact_state_id` bigint unsigned NOT NULL,
  `contact_zip` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `contact_country_id` bigint unsigned NOT NULL,
  `mgr_lname` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mgr_fname` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mgr_phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mgr_email` varchar(65) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mgr_fax` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `notes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `transfer_info` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` blob,
  `schedule_info` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `suz_comments` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_resort` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `concierge_name` varchar(65) COLLATE utf8mb4_unicode_ci NOT NULL,
  `concierge_email` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `facebook_fanpage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `giftfund_info` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `resort_type` int NOT NULL,
  `region_id` bigint unsigned NOT NULL,
  `airport_id` bigint unsigned NOT NULL,
  `fpt_manager_id` bigint unsigned DEFAULT NULL,
  `mobile_background_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fee_entertainment` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fee_admin` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fee_gift` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fee_airtravel` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fee_transfers` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fee_companion` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fee_entertainment_toggle` tinyint(1) NOT NULL DEFAULT '1',
  `fee_total` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`attribute_option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `resorts_amenities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `resorts_amenities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `resort_details_id` bigint unsigned NOT NULL,
  `amenity_id` bigint unsigned DEFAULT NULL,
  `details` tinyint NOT NULL COMMENT '1=included, 2=addtl cost, 3=available, 4=not available, 5=other',
  PRIMARY KEY (`id`),
  UNIQUE KEY `rmoredeam_resort_amenity` (`resort_details_id`,`amenity_id`),
  KEY `rmoredeam_esort_id` (`resort_details_id`),
  KEY `mods_resort_details_amenities_amenity_id_foreign` (`amenity_id`),
  CONSTRAINT `mods_resort_details_amenities_amenity_id_foreign` FOREIGN KEY (`amenity_id`) REFERENCES `mod_resort_details_amenities` (`id`),
  CONSTRAINT `mods_resort_details_amenities_resort_details_id_foreign` FOREIGN KEY (`resort_details_id`) REFERENCES `resorts` (`attribute_option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `saved_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `saved_order` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_id` bigint unsigned NOT NULL,
  `cart_id` bigint unsigned NOT NULL,
  `created` datetime NOT NULL,
  `site_id` bigint unsigned NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `saor_unique_id` (`unique_id`),
  KEY `saor_account_id` (`account_id`),
  KEY `saor_saved_cart_id` (`cart_id`),
  KEY `saved_order_site_id_foreign` (`site_id`),
  CONSTRAINT `saved_order_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `saved_order_saved_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`),
  CONSTRAINT `saved_order_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `saved_order_discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `saved_order_discounts` (
  `order_id` bigint unsigned NOT NULL,
  `discount_id` bigint unsigned NOT NULL,
  `discount_code` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `saordi_order_id` (`order_id`),
  KEY `saved_order_discounts_discount_id_foreign` (`discount_id`),
  CONSTRAINT `saved_order_discounts_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discount` (`id`),
  CONSTRAINT `saved_order_discounts_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `saved_order_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `saved_order_information` (
  `order_id` bigint unsigned NOT NULL,
  `order_email` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_billing_id` bigint unsigned DEFAULT NULL,
  `account_shipping_id` bigint unsigned DEFAULT NULL,
  `bill_first_name` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bill_last_name` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bill_address_1` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bill_address_2` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bill_city` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bill_state_id` bigint unsigned DEFAULT NULL,
  `bill_postal_code` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bill_country_id` bigint unsigned DEFAULT NULL,
  `bill_phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_residential` tinyint(1) NOT NULL,
  `ship_company` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ship_first_name` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ship_last_name` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ship_address_1` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ship_address_2` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ship_city` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ship_state_id` bigint unsigned DEFAULT NULL,
  `ship_postal_code` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ship_country_id` bigint unsigned DEFAULT NULL,
  `ship_email` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method_id` bigint unsigned DEFAULT NULL,
  `shipping_method_id` bigint unsigned DEFAULT NULL,
  `step` tinyint NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `saved_order_information_account_billing_id_foreign` (`account_billing_id`),
  KEY `saved_order_information_account_shipping_id_foreign` (`account_shipping_id`),
  KEY `saved_order_information_bill_state_id_foreign` (`bill_state_id`),
  KEY `saved_order_information_bill_country_id_foreign` (`bill_country_id`),
  KEY `saved_order_information_ship_state_id_foreign` (`ship_state_id`),
  KEY `saved_order_information_ship_country_id_foreign` (`ship_country_id`),
  KEY `saved_order_information_payment_method_id_foreign` (`payment_method_id`),
  KEY `saved_order_information_shipping_method_id_foreign` (`shipping_method_id`),
  CONSTRAINT `saved_order_information_account_billing_id_foreign` FOREIGN KEY (`account_billing_id`) REFERENCES `accounts_addressbook` (`id`),
  CONSTRAINT `saved_order_information_account_shipping_id_foreign` FOREIGN KEY (`account_shipping_id`) REFERENCES `accounts_addressbook` (`id`),
  CONSTRAINT `saved_order_information_bill_country_id_foreign` FOREIGN KEY (`bill_country_id`) REFERENCES `countries` (`id`),
  CONSTRAINT `saved_order_information_bill_state_id_foreign` FOREIGN KEY (`bill_state_id`) REFERENCES `states` (`id`),
  CONSTRAINT `saved_order_information_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `saved_order_information_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`),
  CONSTRAINT `saved_order_information_ship_country_id_foreign` FOREIGN KEY (`ship_country_id`) REFERENCES `countries` (`id`),
  CONSTRAINT `saved_order_information_ship_state_id_foreign` FOREIGN KEY (`ship_state_id`) REFERENCES `states` (`id`),
  CONSTRAINT `saved_order_information_shipping_method_id_foreign` FOREIGN KEY (`shipping_method_id`) REFERENCES `payment_methods` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `search_forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `search_forms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `search_forms_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `search_forms_fields` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `display` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint NOT NULL COMMENT '0=text, 1=textarea, 2=checkbox, 3=radio, 4=select, 5=selectmultiple, 6=button',
  `search_type` tinyint(1) NOT NULL COMMENT '0=attribute, 1=producttype, 2=membershiplevel',
  `search_id` bigint unsigned DEFAULT NULL,
  `rank` int NOT NULL,
  `cssclass` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `help_element_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `search_forms_fields_search_id_foreign` (`search_id`),
  KEY `search_forms_fields_help_element_id_foreign` (`help_element_id`),
  CONSTRAINT `search_forms_fields_help_element_id_foreign` FOREIGN KEY (`help_element_id`) REFERENCES `elements` (`id`),
  CONSTRAINT `search_forms_fields_search_id_foreign` FOREIGN KEY (`search_id`) REFERENCES `search_forms` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `search_forms_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `search_forms_sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `form_id` bigint unsigned NOT NULL,
  `title` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rank` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sefose_form_id` (`form_id`),
  CONSTRAINT `search_forms_sections_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `search_forms` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `search_forms_sections_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `search_forms_sections_fields` (
  `section_id` bigint unsigned NOT NULL,
  `field_id` bigint unsigned NOT NULL,
  `rank` int NOT NULL,
  `new_row` tinyint(1) NOT NULL,
  KEY `sefosefi_section_id` (`section_id`),
  KEY `search_forms_sections_fields_field_id_foreign` (`field_id`),
  CONSTRAINT `search_forms_sections_fields_field_id_foreign` FOREIGN KEY (`field_id`) REFERENCES `search_forms_fields` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `search_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `search_history` (
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  KEY `keywords` (`keywords`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `shipping_carriers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shipping_carriers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `gateway_id` bigint unsigned DEFAULT NULL,
  `name` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `classname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `multipackage_support` tinyint(1) NOT NULL DEFAULT '1',
  `carrier_code` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `limit_shipto` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `shca_gateway_id` (`gateway_id`),
  CONSTRAINT `shipping_carriers_gateway_id_foreign` FOREIGN KEY (`gateway_id`) REFERENCES `shipping_gateways` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `shipping_carriers_shipto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shipping_carriers_shipto` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `shipping_carriers_id` bigint unsigned NOT NULL,
  `country_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `shipping_carriers_id_2` (`shipping_carriers_id`,`country_id`),
  KEY `shipping_carriers_id` (`shipping_carriers_id`),
  KEY `shipping_carriers_shipto_country_id_foreign` (`country_id`),
  CONSTRAINT `shipping_carriers_shipto_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  CONSTRAINT `shipping_carriers_shipto_shipping_carriers_id_foreign` FOREIGN KEY (`shipping_carriers_id`) REFERENCES `shipping_carriers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `shipping_gateways`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shipping_gateways` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `classname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `multipackage_support` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `shipping_label_sizes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shipping_label_sizes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gateway_id` bigint unsigned NOT NULL,
  `carrier_code` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `label_template` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `shipping_label_sizes_gateway_id_foreign` (`gateway_id`),
  CONSTRAINT `shipping_label_sizes_gateway_id_foreign` FOREIGN KEY (`gateway_id`) REFERENCES `shipping_gateways` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `shipping_label_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shipping_label_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `required_js` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `required_css` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `shipping_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shipping_methods` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `display` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refname` char(85) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `carriercode` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `rank` tinyint NOT NULL DEFAULT '0',
  `ships_residential` tinyint NOT NULL COMMENT '0 = ships both, 1= residential only, 2=commercial only',
  `carrier_id` bigint unsigned NOT NULL,
  `weight_limit` decimal(6,2) NOT NULL,
  `weight_min` decimal(6,2) NOT NULL,
  `is_international` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `shme_name` (`name`),
  KEY `shipping_methods_carrier_id_foreign` (`carrier_id`),
  CONSTRAINT `shipping_methods_carrier_id_foreign` FOREIGN KEY (`carrier_id`) REFERENCES `shipping_carriers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `shipping_package_sizes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shipping_package_sizes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `length` int NOT NULL,
  `width` int NOT NULL,
  `height` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `shipping_package_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shipping_package_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `carrier_id` bigint unsigned NOT NULL,
  `carrier_reference` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default` tinyint(1) NOT NULL,
  `is_international` tinyint NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`),
  KEY `carrier_id` (`carrier_id`),
  CONSTRAINT `shipping_package_types_carrier_id_foreign` FOREIGN KEY (`carrier_id`) REFERENCES `shipping_carriers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `shipping_signature_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shipping_signature_options` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `carrier_id` bigint unsigned NOT NULL,
  `carrier_reference` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `shipping_signature_options_carrier_id_foreign` (`carrier_id`),
  CONSTRAINT `shipping_signature_options_carrier_id_foreign` FOREIGN KEY (`carrier_id`) REFERENCES `shipping_carriers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `site_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `site_id` bigint unsigned NOT NULL,
  `language_id` bigint unsigned NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_desc` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `offline_message` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_translations_site_id_language_id_unique` (`site_id`,`language_id`),
  KEY `site_translations_language_id_foreign` (`language_id`),
  CONSTRAINT `site_translations_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `site_translations_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sites` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `domain` varchar(65) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `offline_message` text COLLATE utf8mb4_unicode_ci,
  `offline_key` int DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_keywords` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_type_id` bigint DEFAULT NULL,
  `require_login` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=no, 1=for site, 2=for catalog',
  `required_account_types` json DEFAULT NULL,
  `version` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template_set` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `theme_id` bigint DEFAULT NULL,
  `apply_updates` tinyint(1) NOT NULL DEFAULT '1',
  `logo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sites_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sites_categories` (
  `site_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  UNIQUE KEY `sica_site_id_2` (`site_id`,`category_id`),
  KEY `sica_site_id` (`site_id`),
  KEY `sica_category_id` (`category_id`),
  CONSTRAINT `sites_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sites_categories_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sites_currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sites_currencies` (
  `site_id` bigint unsigned NOT NULL,
  `currency_id` bigint unsigned NOT NULL,
  `rank` tinyint NOT NULL,
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sitecurr` (`site_id`,`currency_id`),
  KEY `sites_currencies_currency_id_foreign` (`currency_id`),
  CONSTRAINT `sites_currencies_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `sites_currencies_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sites_inventory_rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sites_inventory_rules` (
  `site_id` bigint unsigned NOT NULL,
  `rule_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`site_id`),
  KEY `siinru_rule_id` (`rule_id`),
  CONSTRAINT `sites_inventory_rules_rule_id_foreign` FOREIGN KEY (`rule_id`) REFERENCES `inventory_rules` (`id`),
  CONSTRAINT `sites_inventory_rules_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sites_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sites_languages` (
  `site_id` bigint unsigned NOT NULL,
  `language_id` bigint unsigned NOT NULL,
  `rank` tinyint NOT NULL,
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sitelang` (`site_id`,`language_id`),
  KEY `sites_languages_language_id_foreign` (`language_id`),
  CONSTRAINT `sites_languages_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`),
  CONSTRAINT `sites_languages_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sites_message_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sites_message_templates` (
  `site_id` bigint unsigned NOT NULL,
  `html` text COLLATE utf8mb4_unicode_ci,
  `alt` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`site_id`),
  CONSTRAINT `sites_message_templates_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sites_packingslip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sites_packingslip` (
  `site_id` bigint unsigned NOT NULL,
  `packingslip_appendix_elementid` bigint unsigned DEFAULT NULL,
  `packingslip_showlogo` tinyint(1) NOT NULL,
  PRIMARY KEY (`site_id`),
  KEY `sites_packingslip_packingslip_appendix_elementid_foreign` (`packingslip_appendix_elementid`),
  CONSTRAINT `sites_packingslip_packingslip_appendix_elementid_foreign` FOREIGN KEY (`packingslip_appendix_elementid`) REFERENCES `elements` (`id`),
  CONSTRAINT `sites_packingslip_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sites_payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sites_payment_methods` (
  `site_id` bigint unsigned NOT NULL,
  `payment_method_id` bigint unsigned NOT NULL,
  `gateway_account_id` bigint unsigned DEFAULT NULL,
  `fee` decimal(8,4) DEFAULT NULL,
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sipame_sitepaygate` (`site_id`,`payment_method_id`,`gateway_account_id`),
  KEY `sipame_site_id` (`site_id`),
  KEY `sites_payment_methods_payment_method_id_foreign` (`payment_method_id`),
  KEY `sites_payment_methods_gateway_account_id_foreign` (`gateway_account_id`),
  CONSTRAINT `sites_payment_methods_gateway_account_id_foreign` FOREIGN KEY (`gateway_account_id`) REFERENCES `payment_gateways_accounts` (`id`),
  CONSTRAINT `sites_payment_methods_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`),
  CONSTRAINT `sites_payment_methods_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sites_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sites_settings` (
  `site_id` bigint unsigned NOT NULL,
  `default_layout_id` bigint unsigned DEFAULT NULL,
  `default_category_thumbnail_template` int DEFAULT NULL,
  `default_product_thumbnail_template` int DEFAULT NULL,
  `default_product_detail_template` int DEFAULT NULL,
  `default_product_zoom_template` int DEFAULT NULL,
  `default_feature_thumbnail_template` int DEFAULT NULL,
  `default_feature_count` int DEFAULT NULL,
  `default_product_thumbnail_count` int DEFAULT NULL,
  `default_show_categories_in_body` tinyint(1) NOT NULL DEFAULT '1',
  `search_layout_id` bigint unsigned DEFAULT NULL,
  `search_thumbnail_template` int DEFAULT NULL,
  `search_thumbnail_count` int DEFAULT NULL,
  `home_feature_count` int DEFAULT NULL,
  `home_feature_thumbnail_template` int DEFAULT NULL,
  `home_feature_show` tinyint(1) NOT NULL DEFAULT '1',
  `home_feature_showsort` tinyint(1) NOT NULL DEFAULT '1',
  `home_feature_showmessage` tinyint(1) NOT NULL DEFAULT '1',
  `home_show_categories_in_body` tinyint(1) NOT NULL DEFAULT '1',
  `home_layout_id` bigint unsigned DEFAULT NULL,
  `default_product_related_count` int DEFAULT NULL,
  `default_product_brands_count` int DEFAULT NULL,
  `default_feature_showsort` tinyint(1) NOT NULL DEFAULT '1',
  `default_product_thumbnail_showsort` tinyint(1) NOT NULL DEFAULT '1',
  `default_product_thumbnail_showmessage` tinyint(1) NOT NULL DEFAULT '1',
  `default_feature_showmessage` tinyint(1) NOT NULL DEFAULT '1',
  `default_product_related_template` int DEFAULT NULL,
  `default_product_brands_template` int DEFAULT NULL,
  `require_customer_account` tinyint(1) NOT NULL DEFAULT '1',
  `default_category_layout_id` bigint unsigned DEFAULT NULL,
  `default_product_layout_id` bigint unsigned DEFAULT NULL,
  `account_layout_id` bigint unsigned DEFAULT NULL,
  `cart_layout_id` bigint unsigned DEFAULT NULL,
  `checkout_layout_id` bigint unsigned DEFAULT NULL,
  `page_layout_id` bigint unsigned DEFAULT NULL,
  `affiliate_layout_id` bigint unsigned DEFAULT NULL,
  `wishlist_layout_id` bigint unsigned DEFAULT NULL,
  `default_module_template_id` bigint unsigned DEFAULT NULL,
  `default_module_custom_values` text COLLATE utf8mb4_unicode_ci,
  `default_category_module_template_id` bigint unsigned DEFAULT NULL,
  `default_category_module_custom_values` text COLLATE utf8mb4_unicode_ci,
  `default_product_module_template_id` bigint unsigned DEFAULT NULL,
  `default_product_module_custom_values` text COLLATE utf8mb4_unicode_ci,
  `home_module_template_id` bigint unsigned DEFAULT NULL,
  `home_module_custom_values` text COLLATE utf8mb4_unicode_ci,
  `account_module_template_id` bigint unsigned DEFAULT NULL,
  `account_module_custom_values` text COLLATE utf8mb4_unicode_ci,
  `search_module_template_id` bigint unsigned DEFAULT NULL,
  `search_module_custom_values` text COLLATE utf8mb4_unicode_ci,
  `cart_module_template_id` bigint unsigned DEFAULT NULL,
  `cart_module_custom_values` text COLLATE utf8mb4_unicode_ci,
  `checkout_module_template_id` bigint unsigned DEFAULT NULL,
  `checkout_module_custom_values` text COLLATE utf8mb4_unicode_ci,
  `page_module_template_id` bigint unsigned DEFAULT NULL,
  `page_module_custom_values` text COLLATE utf8mb4_unicode_ci,
  `affiliate_module_template_id` bigint unsigned DEFAULT NULL,
  `affiliate_module_custom_values` text COLLATE utf8mb4_unicode_ci,
  `wishlist_module_template_id` bigint unsigned DEFAULT NULL,
  `wishlist_module_custom_values` text COLLATE utf8mb4_unicode_ci,
  `catalog_layout_id` bigint unsigned DEFAULT NULL,
  `catalog_module_template_id` bigint unsigned DEFAULT NULL,
  `catalog_module_custom_values` text COLLATE utf8mb4_unicode_ci,
  `catalog_show_products` tinyint(1) NOT NULL DEFAULT '1',
  `catalog_feature_show` tinyint(1) NOT NULL DEFAULT '1',
  `catalog_show_categories_in_body` tinyint(1) NOT NULL DEFAULT '1',
  `catalog_feature_count` int DEFAULT NULL,
  `catalog_feature_thumbnail_template` int DEFAULT NULL,
  `catalog_feature_showsort` tinyint(1) NOT NULL DEFAULT '1',
  `catalog_feature_showmessage` tinyint(1) NOT NULL DEFAULT '1',
  `cart_addtoaction` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=forward to cart, 1=show popup',
  `cart_orderonlyavailableqty` tinyint(1) NOT NULL DEFAULT '1',
  `checkout_process` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=5step,1=singlepage',
  `offline_layout_id` bigint unsigned DEFAULT NULL,
  `cart_allowavailability` json NOT NULL COMMENT 'any, instock, lowstock, outofstock, onorder, discontinued',
  `filter_categories` tinyint(1) NOT NULL DEFAULT '1',
  `default_category_search_form_id` bigint unsigned DEFAULT NULL,
  `recaptcha_key` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recaptcha_secret` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`site_id`),
  KEY `sites_settings_index_1` (`site_id`,`default_product_thumbnail_template`),
  KEY `sites_settings_default_layout_id_foreign` (`default_layout_id`),
  KEY `sites_settings_search_layout_id_foreign` (`search_layout_id`),
  KEY `sites_settings_home_layout_id_foreign` (`home_layout_id`),
  KEY `sites_settings_default_category_layout_id_foreign` (`default_category_layout_id`),
  KEY `sites_settings_default_product_layout_id_foreign` (`default_product_layout_id`),
  KEY `sites_settings_account_layout_id_foreign` (`account_layout_id`),
  KEY `sites_settings_cart_layout_id_foreign` (`cart_layout_id`),
  KEY `sites_settings_checkout_layout_id_foreign` (`checkout_layout_id`),
  KEY `sites_settings_page_layout_id_foreign` (`page_layout_id`),
  KEY `sites_settings_affiliate_layout_id_foreign` (`affiliate_layout_id`),
  KEY `sites_settings_wishlist_layout_id_foreign` (`wishlist_layout_id`),
  KEY `sites_settings_default_module_template_id_foreign` (`default_module_template_id`),
  KEY `sites_settings_default_category_module_template_id_foreign` (`default_category_module_template_id`),
  KEY `sites_settings_default_product_module_template_id_foreign` (`default_product_module_template_id`),
  KEY `sites_settings_home_module_template_id_foreign` (`home_module_template_id`),
  KEY `sites_settings_account_module_template_id_foreign` (`account_module_template_id`),
  KEY `sites_settings_search_module_template_id_foreign` (`search_module_template_id`),
  KEY `sites_settings_cart_module_template_id_foreign` (`cart_module_template_id`),
  KEY `sites_settings_checkout_module_template_id_foreign` (`checkout_module_template_id`),
  KEY `sites_settings_page_module_template_id_foreign` (`page_module_template_id`),
  KEY `sites_settings_affiliate_module_template_id_foreign` (`affiliate_module_template_id`),
  KEY `sites_settings_wishlist_module_template_id_foreign` (`wishlist_module_template_id`),
  KEY `sites_settings_catalog_layout_id_foreign` (`catalog_layout_id`),
  KEY `sites_settings_catalog_module_template_id_foreign` (`catalog_module_template_id`),
  KEY `sites_settings_offline_layout_id_foreign` (`offline_layout_id`),
  KEY `sites_settings_default_category_search_form_id_foreign` (`default_category_search_form_id`),
  CONSTRAINT `sites_settings_account_layout_id_foreign` FOREIGN KEY (`account_layout_id`) REFERENCES `display_layouts` (`id`),
  CONSTRAINT `sites_settings_account_module_template_id_foreign` FOREIGN KEY (`account_module_template_id`) REFERENCES `modules_templates` (`id`),
  CONSTRAINT `sites_settings_affiliate_layout_id_foreign` FOREIGN KEY (`affiliate_layout_id`) REFERENCES `display_layouts` (`id`),
  CONSTRAINT `sites_settings_affiliate_module_template_id_foreign` FOREIGN KEY (`affiliate_module_template_id`) REFERENCES `modules_templates` (`id`),
  CONSTRAINT `sites_settings_cart_layout_id_foreign` FOREIGN KEY (`cart_layout_id`) REFERENCES `display_layouts` (`id`),
  CONSTRAINT `sites_settings_cart_module_template_id_foreign` FOREIGN KEY (`cart_module_template_id`) REFERENCES `modules_templates` (`id`),
  CONSTRAINT `sites_settings_catalog_layout_id_foreign` FOREIGN KEY (`catalog_layout_id`) REFERENCES `display_layouts` (`id`),
  CONSTRAINT `sites_settings_catalog_module_template_id_foreign` FOREIGN KEY (`catalog_module_template_id`) REFERENCES `modules_templates` (`id`),
  CONSTRAINT `sites_settings_checkout_layout_id_foreign` FOREIGN KEY (`checkout_layout_id`) REFERENCES `display_layouts` (`id`),
  CONSTRAINT `sites_settings_checkout_module_template_id_foreign` FOREIGN KEY (`checkout_module_template_id`) REFERENCES `modules_templates` (`id`),
  CONSTRAINT `sites_settings_default_category_layout_id_foreign` FOREIGN KEY (`default_category_layout_id`) REFERENCES `display_layouts` (`id`),
  CONSTRAINT `sites_settings_default_category_module_template_id_foreign` FOREIGN KEY (`default_category_module_template_id`) REFERENCES `modules_templates` (`id`),
  CONSTRAINT `sites_settings_default_category_search_form_id_foreign` FOREIGN KEY (`default_category_search_form_id`) REFERENCES `search_forms` (`id`),
  CONSTRAINT `sites_settings_default_layout_id_foreign` FOREIGN KEY (`default_layout_id`) REFERENCES `display_layouts` (`id`),
  CONSTRAINT `sites_settings_default_module_template_id_foreign` FOREIGN KEY (`default_module_template_id`) REFERENCES `modules_templates` (`id`),
  CONSTRAINT `sites_settings_default_product_layout_id_foreign` FOREIGN KEY (`default_product_layout_id`) REFERENCES `display_layouts` (`id`),
  CONSTRAINT `sites_settings_default_product_module_template_id_foreign` FOREIGN KEY (`default_product_module_template_id`) REFERENCES `modules_templates` (`id`),
  CONSTRAINT `sites_settings_home_layout_id_foreign` FOREIGN KEY (`home_layout_id`) REFERENCES `display_layouts` (`id`),
  CONSTRAINT `sites_settings_home_module_template_id_foreign` FOREIGN KEY (`home_module_template_id`) REFERENCES `modules_templates` (`id`),
  CONSTRAINT `sites_settings_offline_layout_id_foreign` FOREIGN KEY (`offline_layout_id`) REFERENCES `display_layouts` (`id`),
  CONSTRAINT `sites_settings_page_layout_id_foreign` FOREIGN KEY (`page_layout_id`) REFERENCES `display_layouts` (`id`),
  CONSTRAINT `sites_settings_page_module_template_id_foreign` FOREIGN KEY (`page_module_template_id`) REFERENCES `modules_templates` (`id`),
  CONSTRAINT `sites_settings_search_layout_id_foreign` FOREIGN KEY (`search_layout_id`) REFERENCES `display_layouts` (`id`),
  CONSTRAINT `sites_settings_search_module_template_id_foreign` FOREIGN KEY (`search_module_template_id`) REFERENCES `modules_templates` (`id`),
  CONSTRAINT `sites_settings_wishlist_layout_id_foreign` FOREIGN KEY (`wishlist_layout_id`) REFERENCES `display_layouts` (`id`),
  CONSTRAINT `sites_settings_wishlist_module_template_id_foreign` FOREIGN KEY (`wishlist_module_template_id`) REFERENCES `modules_templates` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sites_settings_modulevalues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sites_settings_modulevalues` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `section` enum('default','home','search','checkout','catalog','cart','product','category','page','wishlist','account','affiliate') COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_id` bigint unsigned NOT NULL,
  `section_id` bigint unsigned NOT NULL,
  `module_id` bigint unsigned NOT NULL,
  `field_id` bigint unsigned DEFAULT NULL,
  `custom_value` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sisemo_section` (`section`,`site_id`,`section_id`,`module_id`,`field_id`),
  KEY `sisemo_product_id_2` (`section`,`site_id`),
  KEY `sisemo_site_id` (`site_id`),
  KEY `sites_settings_modulevalues_section_id_foreign` (`section_id`),
  KEY `sites_settings_modulevalues_module_id_foreign` (`module_id`),
  KEY `sites_settings_modulevalues_field_id_foreign` (`field_id`),
  CONSTRAINT `sites_settings_modulevalues_field_id_foreign` FOREIGN KEY (`field_id`) REFERENCES `modules_fields` (`id`),
  CONSTRAINT `sites_settings_modulevalues_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`),
  CONSTRAINT `sites_settings_modulevalues_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `display_sections` (`id`),
  CONSTRAINT `sites_settings_modulevalues_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sites_tax_rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sites_tax_rules` (
  `site_id` bigint unsigned NOT NULL,
  `tax_rule_id` bigint unsigned DEFAULT NULL,
  UNIQUE KEY `sitaru_id` (`site_id`,`tax_rule_id`),
  KEY `sitaru_site_id` (`site_id`),
  KEY `sites_tax_rules_tax_rule_id_foreign` (`tax_rule_id`),
  CONSTRAINT `sites_tax_rules_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`),
  CONSTRAINT `sites_tax_rules_tax_rule_id_foreign` FOREIGN KEY (`tax_rule_id`) REFERENCES `tax_rules` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sites_themes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sites_themes` (
  `site_id` bigint unsigned DEFAULT NULL,
  `theme_id` bigint unsigned NOT NULL,
  `theme_values` text COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `sith_site_id` (`site_id`),
  KEY `sites_themes_theme_id_foreign` (`theme_id`),
  CONSTRAINT `sites_themes_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`),
  CONSTRAINT `sites_themes_theme_id_foreign` FOREIGN KEY (`theme_id`) REFERENCES `display_themes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `specialties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `specialties` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint unsigned DEFAULT NULL,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rank` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `accounts_specialties_parent_id_index` (`parent_id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `account_specialties_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `specialties` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `states` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abbreviation` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` bigint unsigned NOT NULL,
  `tax_rate` decimal(3,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `support_departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `support_departments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `support_departments_name_unique` (`name`),
  UNIQUE KEY `support_departments_subject_unique` (`subject`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system` (
  `id` int NOT NULL DEFAULT '1',
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `use_cim` tinyint(1) NOT NULL,
  `charge_action` tinyint NOT NULL DEFAULT '1' COMMENT '1 = auth & capture, 2 = auth only',
  `split_charges_by_shipment` tinyint(1) NOT NULL,
  `auto_archive_completed` tinyint(1) NOT NULL,
  `auto_archive_canceled` tinyint(1) NOT NULL,
  `use_fedex` tinyint(1) NOT NULL,
  `use_ups` tinyint(1) NOT NULL,
  `use_usps` tinyint(1) NOT NULL,
  `catalog_img_url` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '//domain.com/',
  `system_admin_url` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'https://domain.com/admin/',
  `system_name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Advision Ecommerce',
  `version` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1.0.0',
  `version_updated` datetime NOT NULL,
  `master_account_pass` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin_secure` tinyint(1) NOT NULL,
  `system_admin_cookie` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `smtp_use` tinyint(1) NOT NULL,
  `smtp_host` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `smtp_auth` tinyint(1) NOT NULL,
  `smtp_secure` tinyint NOT NULL,
  `smtp_port` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `smtp_username` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `smtp_password` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cart_expiration` int NOT NULL DEFAULT '30' COMMENT 'number of days before cookie expires',
  `cart_removestatus` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cart_updateprices` tinyint(1) NOT NULL DEFAULT '1',
  `cart_savediscounts` tinyint(1) NOT NULL DEFAULT '1',
  `feature_toggle` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `check_for_shipped` tinyint(1) NOT NULL,
  `check_for_delivered` tinyint(1) NOT NULL,
  `orderplaced_defaultstatus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '{"default":1, "label":2, "download":1, "dropship":4, "unpaid":9}',
  `validate_addresses` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '0=no validation; >0=distributor.carrier_id to validate with',
  `giftcard_template_id` bigint unsigned NOT NULL,
  `giftcard_waccount_template_id` bigint unsigned NOT NULL,
  `packingslip_showinternalnotes` tinyint(1) NOT NULL,
  `packingslip_showavail` tinyint(1) NOT NULL,
  `packingslip_showshipmethod` tinyint(1) NOT NULL,
  `packingslip_showbillingaddress` tinyint(1) NOT NULL,
  `ordersummaryemail_showavail` tinyint(1) NOT NULL,
  `require_agreetoterms` tinyint(1) NOT NULL,
  `profile_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `timezone` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UTC',
  `addtocart_external_label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Order from Affiliate',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_membership`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_membership` (
  `id` int NOT NULL DEFAULT '1',
  `signupemail_customer` int NOT NULL,
  `signupemail_admin` int NOT NULL,
  `renewemail_customer` int NOT NULL,
  `renewemail_admin` int NOT NULL,
  `expirationalert1_days` int NOT NULL,
  `expirationalert2_days` int NOT NULL,
  `expirationalert1_email` int NOT NULL,
  `expirationalert2_email` int NOT NULL,
  `expiration_email` int NOT NULL,
  `downgrade_restriction_days` int NOT NULL COMMENT 'must be within certain number of days of expiration in order to downgrade',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tax_rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tax_rules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` decimal(8,2) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '0=all,1=location specific',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tax_rules_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tax_rules_locations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tax_rule_id` bigint unsigned DEFAULT NULL,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '0=country, 1=state/province, 2=zipcode',
  `country_id` bigint unsigned DEFAULT NULL,
  `state_id` bigint unsigned NOT NULL,
  `zipcode` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tax_rule_id` (`tax_rule_id`),
  KEY `tax_rules_locations_country_id_foreign` (`country_id`),
  KEY `tax_rules_locations_state_id_foreign` (`state_id`),
  CONSTRAINT `tax_rules_locations_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  CONSTRAINT `tax_rules_locations_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`),
  CONSTRAINT `tax_rules_locations_tax_rule_id_foreign` FOREIGN KEY (`tax_rule_id`) REFERENCES `tax_rules` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tax_rules_product_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tax_rules_product_types` (
  `tax_rule_id` bigint unsigned DEFAULT NULL,
  `type_id` bigint unsigned NOT NULL,
  UNIQUE KEY `taruprty_id` (`tax_rule_id`,`type_id`),
  UNIQUE KEY `tax_rules_product_types_type_id_tax_rule_id_unique` (`type_id`,`tax_rule_id`),
  KEY `taruprty_type_id` (`type_id`),
  CONSTRAINT `tax_rules_product_types_tax_rule_id_foreign` FOREIGN KEY (`tax_rule_id`) REFERENCES `tax_rules` (`id`),
  CONSTRAINT `tax_rules_product_types_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `products_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tmp_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tmp_files` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `trip_flyers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trip_flyers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `orders_products_id` bigint unsigned DEFAULT NULL,
  `position` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(85) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `name` varchar(85) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approval_status` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `photo_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_products_id` (`orders_products_id`),
  KEY `mods_trip_flyers_photo_id_foreign` (`photo_id`),
  CONSTRAINT `mods_trip_flyers_orders_products_id_foreign` FOREIGN KEY (`orders_products_id`) REFERENCES `orders_products` (`id`),
  CONSTRAINT `mods_trip_flyers_photo_id_foreign` FOREIGN KEY (`photo_id`) REFERENCES `photos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `trip_flyers_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trip_flyers_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `account_id` bigint unsigned NOT NULL,
  `photo_id` bigint unsigned DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `motrflse_account_id` (`account_id`),
  KEY `mods_trip_flyers_settings_photo_id_foreign` (`photo_id`),
  CONSTRAINT `mods_trip_flyers_settings_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `mods_trip_flyers_settings_photo_id_foreign` FOREIGN KEY (`photo_id`) REFERENCES `photos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `wishlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wishlists` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `account_id` bigint unsigned NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wi_account_id` (`account_id`),
  CONSTRAINT `wishlists_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `wishlists_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wishlists_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `wishlist_id` bigint unsigned DEFAULT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `parent_product` bigint unsigned DEFAULT NULL,
  `added` datetime NOT NULL,
  `parent_wishlists_items_id` bigint unsigned DEFAULT NULL,
  `is_accessory` tinyint(1) NOT NULL COMMENT '0=no,1=yes,2=as option',
  `accessory_required` tinyint(1) NOT NULL,
  `accessory_field_id` bigint unsigned DEFAULT NULL,
  `notify_backinstock` tinyint(1) NOT NULL COMMENT '0=no, 1=yes, 2=notified',
  `notify_backinstock_attempted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wlprod_id` (`wishlist_id`,`product_id`),
  KEY `wishlist_id` (`wishlist_id`),
  KEY `wishlists_items_product_id_foreign` (`product_id`),
  KEY `wishlists_items_parent_product_foreign` (`parent_product`),
  KEY `wishlists_items_parent_wishlists_items_id_foreign` (`parent_wishlists_items_id`),
  KEY `wishlists_items_accessory_field_id_foreign` (`accessory_field_id`),
  CONSTRAINT `wishlists_items_accessory_field_id_foreign` FOREIGN KEY (`accessory_field_id`) REFERENCES `accessories_fields` (`id`),
  CONSTRAINT `wishlists_items_parent_product_foreign` FOREIGN KEY (`parent_product`) REFERENCES `products` (`id`),
  CONSTRAINT `wishlists_items_parent_wishlists_items_id_foreign` FOREIGN KEY (`parent_wishlists_items_id`) REFERENCES `wishlists_items` (`id`),
  CONSTRAINT `wishlists_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `wishlists_items_wishlist_id_foreign` FOREIGN KEY (`wishlist_id`) REFERENCES `wishlists` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `wishlists_items_customfields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wishlists_items_customfields` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `wishlists_item_id` bigint unsigned NOT NULL,
  `form_id` bigint unsigned NOT NULL,
  `section_id` bigint unsigned NOT NULL,
  `field_id` bigint unsigned NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wiitcu_saved_cart_item_id` (`wishlists_item_id`,`form_id`,`section_id`,`field_id`),
  KEY `wishlists_items_customfields_form_id_foreign` (`form_id`),
  KEY `wishlists_items_customfields_section_id_foreign` (`section_id`),
  KEY `wishlists_items_customfields_field_id_foreign` (`field_id`),
  CONSTRAINT `wishlists_items_customfields_field_id_foreign` FOREIGN KEY (`field_id`) REFERENCES `custom_fields` (`id`),
  CONSTRAINT `wishlists_items_customfields_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `custom_forms` (`id`),
  CONSTRAINT `wishlists_items_customfields_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `custom_forms_sections` (`id`),
  CONSTRAINT `wishlists_items_customfields_wishlists_item_id_foreign` FOREIGN KEY (`wishlists_item_id`) REFERENCES `wishlists_items` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `wishlists_items_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wishlists_items_options` (
  `wishlists_item_id` bigint unsigned NOT NULL,
  `options_json` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`wishlists_item_id`),
  CONSTRAINT `wishlists_items_options_wishlists_item_id_foreign` FOREIGN KEY (`wishlists_item_id`) REFERENCES `wishlists_items` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `wishlists_items_options_customvalues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wishlists_items_options_customvalues` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `wishlists_item_id` bigint unsigned NOT NULL,
  `option_id` bigint unsigned NOT NULL,
  `custom_value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wiitopcu_cartitem_option` (`wishlists_item_id`,`option_id`),
  UNIQUE KEY `wiitopcu_saved_cart_item_id` (`wishlists_item_id`,`option_id`),
  KEY `wishlists_items_options_customvalues_option_id_foreign` (`option_id`),
  CONSTRAINT `wishlists_items_options_customvalues_option_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `products_options_values` (`id`),
  CONSTRAINT `wishlists_items_options_customvalues_wishlists_item_id_foreign` FOREIGN KEY (`wishlists_item_id`) REFERENCES `wishlists_items` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1);
INSERT INTO `migrations` VALUES (2,'2014_10_12_100000_create_password_resets_table',1);
INSERT INTO `migrations` VALUES (3,'2019_03_06_011704_create_accessories_fields_products_table',1);
INSERT INTO `migrations` VALUES (4,'2019_03_07_022100_create_message_templates_table',1);
INSERT INTO `migrations` VALUES (5,'2019_03_07_042949_create_sites_table',1);
INSERT INTO `migrations` VALUES (6,'2019_03_07_052204_create_account_message_keys_table',1);
INSERT INTO `migrations` VALUES (7,'2019_03_07_052204_create_order_message_keys_table',1);
INSERT INTO `migrations` VALUES (8,'2019_03_07_222746_create_orders_table',1);
INSERT INTO `migrations` VALUES (9,'2019_03_08_011704_create_accessories_fields_table',1);
INSERT INTO `migrations` VALUES (10,'2019_03_08_011704_create_accounts_addressbook_table',1);
INSERT INTO `migrations` VALUES (11,'2019_03_08_011704_create_accounts_addtl_fields_table',1);
INSERT INTO `migrations` VALUES (12,'2019_03_08_011704_create_accounts_advertising_campaigns_table',1);
INSERT INTO `migrations` VALUES (13,'2019_03_08_011704_create_accounts_advertising_clicks_table',1);
INSERT INTO `migrations` VALUES (14,'2019_03_08_011704_create_accounts_advertising_table',1);
INSERT INTO `migrations` VALUES (15,'2019_03_08_011704_create_accounts_bulletins_table',1);
INSERT INTO `migrations` VALUES (16,'2019_03_08_011704_create_accounts_cims_table',1);
INSERT INTO `migrations` VALUES (17,'2019_03_08_011704_create_accounts_comments_table',1);
INSERT INTO `migrations` VALUES (18,'2019_03_08_011704_create_accounts_dash_specialties_table',1);
INSERT INTO `migrations` VALUES (19,'2019_03_08_011704_create_accounts_discounts_used_table',1);
INSERT INTO `migrations` VALUES (20,'2019_03_08_011704_create_accounts_loyaltypoints_credits_table',1);
INSERT INTO `migrations` VALUES (21,'2019_03_08_011704_create_accounts_loyaltypoints_debits_table',1);
INSERT INTO `migrations` VALUES (22,'2019_03_08_011704_create_accounts_loyaltypoints_table',1);
INSERT INTO `migrations` VALUES (23,'2019_03_08_011704_create_accounts_membership_attributes_sections_table',1);
INSERT INTO `migrations` VALUES (24,'2019_03_08_011704_create_accounts_membership_attributes_table',1);
INSERT INTO `migrations` VALUES (25,'2019_03_08_011704_create_accounts_membership_levels_attributes_table',1);
INSERT INTO `migrations` VALUES (26,'2019_03_08_011704_create_accounts_membership_levels_settings_table',1);
INSERT INTO `migrations` VALUES (27,'2019_03_08_011704_create_accounts_membership_levels_table',1);
INSERT INTO `migrations` VALUES (28,'2019_03_08_011704_create_accounts_memberships_payment_methods_table',1);
INSERT INTO `migrations` VALUES (29,'2019_03_08_011704_create_accounts_memberships_table',1);
INSERT INTO `migrations` VALUES (30,'2019_03_08_011704_create_accounts_messages_headers_table',1);
INSERT INTO `migrations` VALUES (31,'2019_03_08_011704_create_accounts_messages_table',1);
INSERT INTO `migrations` VALUES (32,'2019_03_08_011704_create_accounts_onmind_comments_table',1);
INSERT INTO `migrations` VALUES (33,'2019_03_08_011704_create_accounts_onmind_likes_table',1);
INSERT INTO `migrations` VALUES (34,'2019_03_08_011704_create_accounts_onmind_table',1);
INSERT INTO `migrations` VALUES (35,'2019_03_08_011704_create_accounts_programs_accounts_table',1);
INSERT INTO `migrations` VALUES (36,'2019_03_08_011704_create_accounts_programs_table',1);
INSERT INTO `migrations` VALUES (37,'2019_03_08_011704_create_accounts_resourcebox_table',1);
INSERT INTO `migrations` VALUES (38,'2019_03_08_011704_create_accounts_specialties_products_table',1);
INSERT INTO `migrations` VALUES (39,'2019_03_08_011704_create_accounts_statuses_table',1);
INSERT INTO `migrations` VALUES (40,'2019_03_08_011704_create_accounts_table',1);
INSERT INTO `migrations` VALUES (41,'2019_03_08_011704_create_accounts_templates_sent_table',1);
INSERT INTO `migrations` VALUES (42,'2019_03_08_011704_create_accounts_transactions_table',1);
INSERT INTO `migrations` VALUES (43,'2019_03_08_011704_create_accounts_types_categories_table',1);
INSERT INTO `migrations` VALUES (44,'2019_03_08_011704_create_accounts_types_products_table',1);
INSERT INTO `migrations` VALUES (45,'2019_03_08_011704_create_accounts_types_restrictordering_table',1);
INSERT INTO `migrations` VALUES (46,'2019_03_08_011704_create_accounts_types_table',1);
INSERT INTO `migrations` VALUES (47,'2019_03_08_011704_create_accounts_updates_table',1);
INSERT INTO `migrations` VALUES (48,'2019_03_08_011704_create_accounts_views_table',1);
INSERT INTO `migrations` VALUES (49,'2019_03_08_011704_create_admin_emails_sent_table',1);
INSERT INTO `migrations` VALUES (50,'2019_03_08_011704_create_admin_levels_menus_table',1);
INSERT INTO `migrations` VALUES (51,'2019_03_08_011704_create_admin_levels_table',1);
INSERT INTO `migrations` VALUES (52,'2019_03_08_011704_create_admin_users_distributors_table',1);
INSERT INTO `migrations` VALUES (53,'2019_03_08_011704_create_admin_users_table',1);
INSERT INTO `migrations` VALUES (54,'2019_03_08_011704_create_affiliates_levels_table',1);
INSERT INTO `migrations` VALUES (55,'2019_03_08_011704_create_affiliates_payments_referrals_table',1);
INSERT INTO `migrations` VALUES (56,'2019_03_08_011704_create_affiliates_payments_table',1);
INSERT INTO `migrations` VALUES (57,'2019_03_08_011704_create_affiliates_referrals_statuses_table',1);
INSERT INTO `migrations` VALUES (58,'2019_03_08_011704_create_affiliates_referrals_table',1);
INSERT INTO `migrations` VALUES (59,'2019_03_08_011704_create_affiliates_referrals_types_table',1);
INSERT INTO `migrations` VALUES (60,'2019_03_08_011704_create_affiliates_table',1);
INSERT INTO `migrations` VALUES (61,'2019_03_08_011704_create_airports_table',1);
INSERT INTO `migrations` VALUES (62,'2019_03_08_011704_create_articles_categories_table',1);
INSERT INTO `migrations` VALUES (63,'2019_03_08_011704_create_articles_comments_table',1);
INSERT INTO `migrations` VALUES (64,'2019_03_08_011704_create_articles_resources_table',1);
INSERT INTO `migrations` VALUES (65,'2019_03_08_011704_create_articles_table',1);
INSERT INTO `migrations` VALUES (66,'2019_03_08_011704_create_articles_views_table',1);
INSERT INTO `migrations` VALUES (67,'2019_03_08_011704_create_attributes_options_table',1);
INSERT INTO `migrations` VALUES (68,'2019_03_08_011704_create_attributes_packages_sets_table',1);
INSERT INTO `migrations` VALUES (69,'2019_03_08_011704_create_attributes_packages_table',1);
INSERT INTO `migrations` VALUES (70,'2019_03_08_011704_create_attributes_sets_attributes_table',1);
INSERT INTO `migrations` VALUES (71,'2019_03_08_011704_create_attributes_sets_table',1);
INSERT INTO `migrations` VALUES (72,'2019_03_08_011704_create_attributes_table',1);
INSERT INTO `migrations` VALUES (73,'2019_03_08_011704_create_attributes_types_table',1);
INSERT INTO `migrations` VALUES (74,'2019_03_08_011704_create_automated_emails_accounttypes_table',1);
INSERT INTO `migrations` VALUES (75,'2019_03_08_011704_create_automated_emails_sites_table',1);
INSERT INTO `migrations` VALUES (76,'2019_03_08_011704_create_automated_emails_table',1);
INSERT INTO `migrations` VALUES (77,'2019_03_08_011704_create_banners_campaigns_table',1);
INSERT INTO `migrations` VALUES (78,'2019_03_08_011704_create_banners_clicks_table',1);
INSERT INTO `migrations` VALUES (79,'2019_03_08_011704_create_banners_images_table',1);
INSERT INTO `migrations` VALUES (80,'2019_03_08_011704_create_banners_shown_table',1);
INSERT INTO `migrations` VALUES (81,'2019_03_08_011704_create_blog_entry_comments_table',1);
INSERT INTO `migrations` VALUES (82,'2019_03_08_011704_create_blog_entry_table',1);
INSERT INTO `migrations` VALUES (83,'2019_03_08_011704_create_blog_entry_views_table',1);
INSERT INTO `migrations` VALUES (84,'2019_03_08_011704_create_blogs_table',1);
INSERT INTO `migrations` VALUES (85,'2019_03_08_011704_create_blogs_views_table',1);
INSERT INTO `migrations` VALUES (86,'2019_03_08_011704_create_board_categories_table',1);
INSERT INTO `migrations` VALUES (87,'2019_03_08_011704_create_board_thread_entry_table',1);
INSERT INTO `migrations` VALUES (88,'2019_03_08_011704_create_board_threads_details_table',1);
INSERT INTO `migrations` VALUES (89,'2019_03_08_011704_create_board_threads_table',1);
INSERT INTO `migrations` VALUES (90,'2019_03_08_011704_create_board_type_table',1);
INSERT INTO `migrations` VALUES (91,'2019_03_08_011704_create_boards_table',1);
INSERT INTO `migrations` VALUES (92,'2019_03_08_011704_create_bookingas_options_table',1);
INSERT INTO `migrations` VALUES (93,'2019_03_08_011704_create_bookingas_products_table',1);
INSERT INTO `migrations` VALUES (94,'2019_03_08_011704_create_bookingas_table',1);
INSERT INTO `migrations` VALUES (95,'2019_03_08_011704_create_brands_table',1);
INSERT INTO `migrations` VALUES (96,'2019_03_08_011704_create_bulkedit_change_products_table',1);
INSERT INTO `migrations` VALUES (97,'2019_03_08_011704_create_bulkedit_change_table',1);
INSERT INTO `migrations` VALUES (98,'2019_03_08_011704_create_catalog_updates_table',1);
INSERT INTO `migrations` VALUES (99,'2019_03_08_011704_create_categories_brands_table',1);
INSERT INTO `migrations` VALUES (100,'2019_03_08_011704_create_categories_featured_table',1);
INSERT INTO `migrations` VALUES (101,'2019_03_08_011704_create_categories_products_assn_table',1);
INSERT INTO `migrations` VALUES (102,'2019_03_08_011704_create_categories_products_hide_table',1);
INSERT INTO `migrations` VALUES (103,'2019_03_08_011704_create_categories_products_ranks_table',1);
INSERT INTO `migrations` VALUES (104,'2019_03_08_011704_create_categories_products_sorts_table',1);
INSERT INTO `migrations` VALUES (105,'2019_03_08_011704_create_categories_rules_attributes_table',1);
INSERT INTO `migrations` VALUES (106,'2019_03_08_011704_create_categories_rules_table',1);
INSERT INTO `migrations` VALUES (107,'2019_03_08_011704_create_categories_settings_sites_modulevalues_table',1);
INSERT INTO `migrations` VALUES (108,'2019_03_08_011704_create_categories_settings_sites_table',1);
INSERT INTO `migrations` VALUES (109,'2019_03_08_011704_create_categories_settings_table',1);
INSERT INTO `migrations` VALUES (110,'2019_03_08_011704_create_categories_settings_templates_modulevalues_table',1);
INSERT INTO `migrations` VALUES (111,'2019_03_08_011704_create_categories_settings_templates_table',1);
INSERT INTO `migrations` VALUES (112,'2019_03_08_011704_create_categories_table',1);
INSERT INTO `migrations` VALUES (113,'2019_03_08_011704_create_categories_types_table',1);
INSERT INTO `migrations` VALUES (114,'2019_03_08_011704_create_cim_profile_paymentprofile_table',1);
INSERT INTO `migrations` VALUES (115,'2019_03_08_011704_create_cim_profile_table',1);
INSERT INTO `migrations` VALUES (116,'2019_03_08_011704_create_countries_iso_table',1);
INSERT INTO `migrations` VALUES (117,'2019_03_08_011704_create_countries_regions_table',1);
INSERT INTO `migrations` VALUES (118,'2019_03_08_011704_create_countries_table',1);
INSERT INTO `migrations` VALUES (119,'2019_03_08_011704_create_currencies_table',1);
INSERT INTO `migrations` VALUES (120,'2019_03_08_011704_create_custom_fields_table',1);
INSERT INTO `migrations` VALUES (121,'2019_03_08_011704_create_custom_forms_sections_fields_table',1);
INSERT INTO `migrations` VALUES (122,'2019_03_08_011704_create_custom_forms_sections_table',1);
INSERT INTO `migrations` VALUES (123,'2019_03_08_011704_create_custom_forms_show_products_table',1);
INSERT INTO `migrations` VALUES (124,'2019_03_08_011704_create_custom_forms_show_producttypes_table',1);
INSERT INTO `migrations` VALUES (125,'2019_03_08_011704_create_custom_forms_show_table',1);
INSERT INTO `migrations` VALUES (126,'2019_03_08_011704_create_custom_forms_table',1);
INSERT INTO `migrations` VALUES (127,'2019_03_08_011704_create_discount_advantage_products_table',1);
INSERT INTO `migrations` VALUES (128,'2019_03_08_011704_create_discount_advantage_producttypes_table',1);
INSERT INTO `migrations` VALUES (129,'2019_03_08_011704_create_discount_advantage_table',1);
INSERT INTO `migrations` VALUES (130,'2019_03_08_011704_create_discount_advantage_types_table',1);
INSERT INTO `migrations` VALUES (131,'2019_03_08_011704_create_discount_rule_condition_accounttypes_table',1);
INSERT INTO `migrations` VALUES (132,'2019_03_08_011704_create_discount_rule_condition_attributes_table',1);
INSERT INTO `migrations` VALUES (133,'2019_03_08_011704_create_discount_rule_condition_countries_table',1);
INSERT INTO `migrations` VALUES (134,'2019_03_08_011704_create_discount_rule_condition_distributors_table',1);
INSERT INTO `migrations` VALUES (135,'2019_03_08_011704_create_discount_rule_condition_membershiplevels_table',1);
INSERT INTO `migrations` VALUES (136,'2019_03_08_011704_create_discount_rule_condition_onsalestatuses_table',1);
INSERT INTO `migrations` VALUES (137,'2019_03_08_011704_create_discount_rule_condition_outofstockstatuses_table',1);
INSERT INTO `migrations` VALUES (138,'2019_03_08_011704_create_discount_rule_condition_productavailabilities_table',1);
INSERT INTO `migrations` VALUES (139,'2019_03_08_011704_create_discount_rule_condition_products_table',1);
INSERT INTO `migrations` VALUES (140,'2019_03_08_011704_create_discount_rule_condition_producttypes_table',1);
INSERT INTO `migrations` VALUES (141,'2019_03_08_011704_create_discount_rule_condition_sites_table',1);
INSERT INTO `migrations` VALUES (142,'2019_03_08_011704_create_discount_rule_condition_table',1);
INSERT INTO `migrations` VALUES (143,'2019_03_08_011704_create_discount_rule_condition_types_table',1);
INSERT INTO `migrations` VALUES (144,'2019_03_08_011704_create_discount_rule_table',1);
INSERT INTO `migrations` VALUES (145,'2019_03_08_011704_create_discount_table',1);
INSERT INTO `migrations` VALUES (146,'2019_03_08_011704_create_discounts_advantages_products_table',1);
INSERT INTO `migrations` VALUES (147,'2019_03_08_011704_create_discounts_advantages_table',1);
INSERT INTO `migrations` VALUES (148,'2019_03_08_011704_create_discounts_levels_products_table',1);
INSERT INTO `migrations` VALUES (149,'2019_03_08_011704_create_discounts_levels_table',1);
INSERT INTO `migrations` VALUES (150,'2019_03_08_011704_create_discounts_rules_products_table',1);
INSERT INTO `migrations` VALUES (151,'2019_03_08_011704_create_discounts_rules_table',1);
INSERT INTO `migrations` VALUES (152,'2019_03_08_011704_create_discounts_table',1);
INSERT INTO `migrations` VALUES (153,'2019_03_08_011704_create_display_layouts_table',1);
INSERT INTO `migrations` VALUES (154,'2019_03_08_011704_create_display_sections_table',1);
INSERT INTO `migrations` VALUES (155,'2019_03_08_011704_create_display_templates_table',1);
INSERT INTO `migrations` VALUES (156,'2019_03_08_011704_create_display_templates_types_table',1);
INSERT INTO `migrations` VALUES (157,'2019_03_08_011704_create_display_themes_table',1);
INSERT INTO `migrations` VALUES (158,'2019_03_08_011704_create_distributors_availabilities_table',1);
INSERT INTO `migrations` VALUES (159,'2019_03_08_011704_create_distributors_canadapost_table',1);
INSERT INTO `migrations` VALUES (160,'2019_03_08_011704_create_distributors_endicia_table',1);
INSERT INTO `migrations` VALUES (161,'2019_03_08_011704_create_distributors_fedex_table',1);
INSERT INTO `migrations` VALUES (162,'2019_03_08_011704_create_distributors_genericshipping_table',1);
INSERT INTO `migrations` VALUES (163,'2019_03_08_011704_create_distributors_shipping_flatrates_table',1);
INSERT INTO `migrations` VALUES (164,'2019_03_08_011704_create_distributors_shipping_gateways_table',1);
INSERT INTO `migrations` VALUES (165,'2019_03_08_011704_create_distributors_shipping_methods_table',1);
INSERT INTO `migrations` VALUES (166,'2019_03_08_011704_create_distributors_shipstation_table',1);
INSERT INTO `migrations` VALUES (167,'2019_03_08_011704_create_distributors_table',1);
INSERT INTO `migrations` VALUES (168,'2019_03_08_011704_create_distributors_ups_table',1);
INSERT INTO `migrations` VALUES (169,'2019_03_08_011704_create_distributors_usps_table',1);
INSERT INTO `migrations` VALUES (170,'2019_03_08_011704_create_elements_table',1);
INSERT INTO `migrations` VALUES (171,'2019_03_08_011704_create_events_table',1);
INSERT INTO `migrations` VALUES (172,'2019_03_08_011704_create_events_toattend_table',1);
INSERT INTO `migrations` VALUES (173,'2019_03_08_011704_create_events_types_table',1);
INSERT INTO `migrations` VALUES (174,'2019_03_08_011704_create_events_views_table',1);
INSERT INTO `migrations` VALUES (175,'2019_03_08_011704_create_faqs_categories_translations_table',1);
INSERT INTO `migrations` VALUES (176,'2019_03_08_011704_create_faqs_dash_categories_table',1);
INSERT INTO `migrations` VALUES (177,'2019_03_08_011704_create_faqs_table',1);
INSERT INTO `migrations` VALUES (178,'2019_03_08_011704_create_faqs_translations_table',1);
INSERT INTO `migrations` VALUES (179,'2019_03_08_011704_create_files_table',1);
INSERT INTO `migrations` VALUES (180,'2019_03_08_011704_create_filters_attributes_table',1);
INSERT INTO `migrations` VALUES (181,'2019_03_08_011704_create_filters_availabilities_table',1);
INSERT INTO `migrations` VALUES (182,'2019_03_08_011704_create_filters_categories_table',1);
INSERT INTO `migrations` VALUES (183,'2019_03_08_011704_create_filters_pricing_table',1);
INSERT INTO `migrations` VALUES (184,'2019_03_08_011704_create_filters_productoptions_table',1);
INSERT INTO `migrations` VALUES (185,'2019_03_08_011704_create_filters_table',1);
INSERT INTO `migrations` VALUES (186,'2019_03_08_011704_create_friend_requests_table',1);
INSERT INTO `migrations` VALUES (187,'2019_03_08_011704_create_friends_table',1);
INSERT INTO `migrations` VALUES (188,'2019_03_08_011704_create_friends_updates_table',1);
INSERT INTO `migrations` VALUES (189,'2019_03_08_011704_create_friends_updates_types_table',1);
INSERT INTO `migrations` VALUES (190,'2019_03_08_011704_create_gift_cards_table',1);
INSERT INTO `migrations` VALUES (191,'2019_03_08_011704_create_gift_cards_transactions_table',1);
INSERT INTO `migrations` VALUES (192,'2019_03_08_011704_create_giftregistry_genders_table',1);
INSERT INTO `migrations` VALUES (193,'2019_03_08_011704_create_giftregistry_items_purchased_table',1);
INSERT INTO `migrations` VALUES (194,'2019_03_08_011704_create_giftregistry_items_table',1);
INSERT INTO `migrations` VALUES (195,'2019_03_08_011704_create_giftregistry_table',1);
INSERT INTO `migrations` VALUES (196,'2019_03_08_011704_create_giftregistry_types_table',1);
INSERT INTO `migrations` VALUES (197,'2019_03_08_011704_create_group_bulletins_table',1);
INSERT INTO `migrations` VALUES (198,'2019_03_08_011704_create_group_requests_table',1);
INSERT INTO `migrations` VALUES (199,'2019_03_08_011704_create_group_updates_table',1);
INSERT INTO `migrations` VALUES (200,'2019_03_08_011704_create_group_users_table',1);
INSERT INTO `migrations` VALUES (201,'2019_03_08_011704_create_group_views_table',1);
INSERT INTO `migrations` VALUES (202,'2019_03_08_011704_create_groups_table',1);
INSERT INTO `migrations` VALUES (203,'2019_03_08_011704_create_help_pops_table',1);
INSERT INTO `migrations` VALUES (204,'2019_03_08_011704_create_images_sizes_table',1);
INSERT INTO `migrations` VALUES (205,'2019_03_08_011704_create_images_table',1);
INSERT INTO `migrations` VALUES (206,'2019_03_08_011704_create_instructors_certfiles_table',1);
INSERT INTO `migrations` VALUES (207,'2019_03_08_011704_create_inventory_gateways_accounts_table',1);
INSERT INTO `migrations` VALUES (208,'2019_03_08_011704_create_inventory_gateways_fields_table',1);
INSERT INTO `migrations` VALUES (209,'2019_03_08_011704_create_inventory_gateways_orders_table',1);
INSERT INTO `migrations` VALUES (210,'2019_03_08_011704_create_inventory_gateways_scheduledtasks_products_table',1);
INSERT INTO `migrations` VALUES (211,'2019_03_08_011704_create_inventory_gateways_scheduledtasks_table',1);
INSERT INTO `migrations` VALUES (212,'2019_03_08_011704_create_inventory_gateways_sites_table',1);
INSERT INTO `migrations` VALUES (213,'2019_03_08_011704_create_inventory_gateways_table',1);
INSERT INTO `migrations` VALUES (214,'2019_03_08_011704_create_inventory_rules_table',1);
INSERT INTO `migrations` VALUES (215,'2019_03_08_011704_create_languages_content_table',1);
INSERT INTO `migrations` VALUES (216,'2019_03_08_011704_create_languages_table',1);
INSERT INTO `migrations` VALUES (217,'2019_03_08_011704_create_languages_translations_table',1);
INSERT INTO `migrations` VALUES (218,'2019_03_08_011704_create_loyaltypoints_levels_table',1);
INSERT INTO `migrations` VALUES (219,'2019_03_08_011704_create_loyaltypoints_table',1);
INSERT INTO `migrations` VALUES (220,'2019_03_08_011704_create_menu_table',1);
INSERT INTO `migrations` VALUES (221,'2019_03_08_011704_create_menus_catalogcategories_table',1);
INSERT INTO `migrations` VALUES (222,'2019_03_08_011704_create_menus_categories_table',1);
INSERT INTO `migrations` VALUES (223,'2019_03_08_011704_create_menus_dash_links_table',1);
INSERT INTO `migrations` VALUES (224,'2019_03_08_011704_create_menus_menus_table',1);
INSERT INTO `migrations` VALUES (225,'2019_03_08_011704_create_menus_pages_table',1);
INSERT INTO `migrations` VALUES (226,'2019_03_08_011704_create_menus_sites_table',1);
INSERT INTO `migrations` VALUES (227,'2019_03_08_011704_create_menus_table',1);
INSERT INTO `migrations` VALUES (228,'2019_03_08_011704_create_message_templates_new_table',1);
INSERT INTO `migrations` VALUES (229,'2019_03_08_011704_create_mods_account_ads_campaigns_table',1);
INSERT INTO `migrations` VALUES (230,'2019_03_08_011704_create_mods_account_ads_clicks_table',1);
INSERT INTO `migrations` VALUES (231,'2019_03_08_011704_create_mods_account_ads_table',1);
INSERT INTO `migrations` VALUES (232,'2019_03_08_011704_create_mods_account_certifications_files_table',1);
INSERT INTO `migrations` VALUES (233,'2019_03_08_011704_create_mods_account_certifications_table',1);
INSERT INTO `migrations` VALUES (234,'2019_03_08_011704_create_mods_account_files_table',1);
INSERT INTO `migrations` VALUES (235,'2019_03_08_011704_create_mods_dates_auto_orderrules_action_table',1);
INSERT INTO `migrations` VALUES (236,'2019_03_08_011704_create_mods_dates_auto_orderrules_excludes_table',1);
INSERT INTO `migrations` VALUES (237,'2019_03_08_011704_create_mods_dates_auto_orderrules_products_table',1);
INSERT INTO `migrations` VALUES (238,'2019_03_08_011704_create_mods_dates_auto_orderrules_table',1);
INSERT INTO `migrations` VALUES (239,'2019_03_08_011704_create_mods_lookbooks_areas_images_table',1);
INSERT INTO `migrations` VALUES (240,'2019_03_08_011704_create_mods_lookbooks_areas_table',1);
INSERT INTO `migrations` VALUES (241,'2019_03_08_011704_create_mods_lookbooks_images_maps_table',1);
INSERT INTO `migrations` VALUES (242,'2019_03_08_011704_create_mods_lookbooks_images_table',1);
INSERT INTO `migrations` VALUES (243,'2019_03_08_011704_create_mods_lookbooks_table',1);
INSERT INTO `migrations` VALUES (244,'2019_03_08_011704_create_mods_pages_viewed_table',1);
INSERT INTO `migrations` VALUES (245,'2019_03_08_011704_create_mods_resort_details_dash_amenities_table',1);
INSERT INTO `migrations` VALUES (246,'2019_03_08_011704_create_mods_resort_details_table',1);
INSERT INTO `migrations` VALUES (247,'2019_03_08_011704_create_mods_trip_flyers_settings_table',1);
INSERT INTO `migrations` VALUES (248,'2019_03_08_011704_create_mods_trip_flyers_table',1);
INSERT INTO `migrations` VALUES (249,'2019_03_08_011704_create_modules_admin_controllers_table',1);
INSERT INTO `migrations` VALUES (250,'2019_03_08_011704_create_modules_crons_scheduledtasks_table',1);
INSERT INTO `migrations` VALUES (251,'2019_03_08_011704_create_modules_crons_table',1);
INSERT INTO `migrations` VALUES (252,'2019_03_08_011704_create_modules_fields_table',1);
INSERT INTO `migrations` VALUES (253,'2019_03_08_011704_create_modules_site_controllers_table',1);
INSERT INTO `migrations` VALUES (254,'2019_03_08_011704_create_modules_table',1);
INSERT INTO `migrations` VALUES (255,'2019_03_08_011704_create_modules_templates_modules_table',1);
INSERT INTO `migrations` VALUES (256,'2019_03_08_011704_create_modules_templates_sections_table',1);
INSERT INTO `migrations` VALUES (257,'2019_03_08_011704_create_modules_templates_table',1);
INSERT INTO `migrations` VALUES (258,'2019_03_08_011704_create_newsletters_history_table',1);
INSERT INTO `migrations` VALUES (259,'2019_03_08_011704_create_newsletters_sites_table',1);
INSERT INTO `migrations` VALUES (260,'2019_03_08_011704_create_newsletters_subscribers_table',1);
INSERT INTO `migrations` VALUES (261,'2019_03_08_011704_create_newsletters_table',1);
INSERT INTO `migrations` VALUES (262,'2019_03_08_011704_create_options_templates_images_table',1);
INSERT INTO `migrations` VALUES (263,'2019_03_08_011704_create_options_templates_options_custom_table',1);
INSERT INTO `migrations` VALUES (264,'2019_03_08_011704_create_options_templates_options_table',1);
INSERT INTO `migrations` VALUES (265,'2019_03_08_011704_create_options_templates_options_values_table',1);
INSERT INTO `migrations` VALUES (266,'2019_03_08_011704_create_options_templates_table',1);
INSERT INTO `migrations` VALUES (267,'2019_03_08_011704_create_orders_activities_table',1);
INSERT INTO `migrations` VALUES (268,'2019_03_08_011704_create_orders_billing_table',1);
INSERT INTO `migrations` VALUES (269,'2019_03_08_011704_create_orders_customforms_table',1);
INSERT INTO `migrations` VALUES (270,'2019_03_08_011704_create_orders_discounts_table',1);
INSERT INTO `migrations` VALUES (271,'2019_03_08_011704_create_orders_notes_table',1);
INSERT INTO `migrations` VALUES (272,'2019_03_08_011704_create_orders_packages_table',1);
INSERT INTO `migrations` VALUES (273,'2019_03_08_011704_create_orders_products_customfields_table',1);
INSERT INTO `migrations` VALUES (274,'2019_03_08_011704_create_orders_products_customsinfo_table',1);
INSERT INTO `migrations` VALUES (275,'2019_03_08_011704_create_orders_products_discounts_table',1);
INSERT INTO `migrations` VALUES (276,'2019_03_08_011704_create_orders_products_options_table',1);
INSERT INTO `migrations` VALUES (277,'2019_03_08_011704_create_orders_products_sentemails_table',1);
INSERT INTO `migrations` VALUES (278,'2019_03_08_011704_create_orders_products_table',1);
INSERT INTO `migrations` VALUES (279,'2019_03_08_011704_create_orders_shipments_labels_table',1);
INSERT INTO `migrations` VALUES (280,'2019_03_08_011704_create_orders_shipments_table',1);
INSERT INTO `migrations` VALUES (281,'2019_03_08_011704_create_orders_shipping_table',1);
INSERT INTO `migrations` VALUES (282,'2019_03_08_011704_create_orders_statuses_table',1);
INSERT INTO `migrations` VALUES (283,'2019_03_08_011704_create_orders_tasks_table',1);
INSERT INTO `migrations` VALUES (284,'2019_03_08_011704_create_orders_transactions_billing_table',1);
INSERT INTO `migrations` VALUES (285,'2019_03_08_011704_create_orders_transactions_credits_table',1);
INSERT INTO `migrations` VALUES (286,'2019_03_08_011704_create_orders_transactions_statuses_table',1);
INSERT INTO `migrations` VALUES (287,'2019_03_08_011704_create_orders_transactions_table',1);
INSERT INTO `migrations` VALUES (288,'2019_03_08_011704_create_pages_categories_pages_table',1);
INSERT INTO `migrations` VALUES (289,'2019_03_08_011704_create_pages_categories_table',1);
INSERT INTO `migrations` VALUES (290,'2019_03_08_011704_create_pages_settings_sites_modulevalues_table',1);
INSERT INTO `migrations` VALUES (291,'2019_03_08_011704_create_pages_settings_sites_table',1);
INSERT INTO `migrations` VALUES (292,'2019_03_08_011704_create_pages_settings_table',1);
INSERT INTO `migrations` VALUES (293,'2019_03_08_011704_create_pages_settings_templates_modulevalues_table',1);
INSERT INTO `migrations` VALUES (294,'2019_03_08_011704_create_pages_settings_templates_table',1);
INSERT INTO `migrations` VALUES (295,'2019_03_08_011704_create_pages_table',1);
INSERT INTO `migrations` VALUES (296,'2019_03_08_011704_create_payment_gateways_accounts_limitcountries_table',1);
INSERT INTO `migrations` VALUES (297,'2019_03_08_011704_create_payment_gateways_accounts_table',1);
INSERT INTO `migrations` VALUES (298,'2019_03_08_011704_create_payment_gateways_errors_table',1);
INSERT INTO `migrations` VALUES (299,'2019_03_08_011704_create_payment_gateways_table',1);
INSERT INTO `migrations` VALUES (300,'2019_03_08_011704_create_payment_methods_limitcountries_table',1);
INSERT INTO `migrations` VALUES (301,'2019_03_08_011704_create_payment_methods_table',1);
INSERT INTO `migrations` VALUES (302,'2019_03_08_011704_create_photos_albums_table',1);
INSERT INTO `migrations` VALUES (303,'2019_03_08_011704_create_photos_albums_type_table',1);
INSERT INTO `migrations` VALUES (304,'2019_03_08_011704_create_photos_comments_table',1);
INSERT INTO `migrations` VALUES (305,'2019_03_08_011704_create_photos_favorites_table',1);
INSERT INTO `migrations` VALUES (306,'2019_03_08_011704_create_photos_sizes_table',1);
INSERT INTO `migrations` VALUES (307,'2019_03_08_011704_create_photos_table',1);
INSERT INTO `migrations` VALUES (308,'2019_03_08_011704_create_pricing_rules_levels_table',1);
INSERT INTO `migrations` VALUES (309,'2019_03_08_011704_create_pricing_rules_table',1);
INSERT INTO `migrations` VALUES (310,'2019_03_08_011704_create_products_accessories_fields_table',1);
INSERT INTO `migrations` VALUES (311,'2019_03_08_011704_create_products_accessories_table',1);
INSERT INTO `migrations` VALUES (312,'2019_03_08_011704_create_products_attributes_table',1);
INSERT INTO `migrations` VALUES (313,'2019_03_08_011704_create_products_availability_table',1);
INSERT INTO `migrations` VALUES (314,'2019_03_08_011704_create_products_children_options_table',1);
INSERT INTO `migrations` VALUES (315,'2019_03_08_011704_create_products_details_table',1);
INSERT INTO `migrations` VALUES (316,'2019_03_08_011704_create_products_distributors_table',1);
INSERT INTO `migrations` VALUES (317,'2019_03_08_011704_create_products_images_table',1);
INSERT INTO `migrations` VALUES (318,'2019_03_08_011704_create_products_log_table',1);
INSERT INTO `migrations` VALUES (319,'2019_03_08_011704_create_products_needschildren_table',1);
INSERT INTO `migrations` VALUES (320,'2019_03_08_011704_create_products_options_custom_table',1);
INSERT INTO `migrations` VALUES (321,'2019_03_08_011704_create_products_options_table',1);
INSERT INTO `migrations` VALUES (322,'2019_03_08_011704_create_products_options_types_table',1);
INSERT INTO `migrations` VALUES (323,'2019_03_08_011704_create_products_options_values_table',1);
INSERT INTO `migrations` VALUES (324,'2019_03_08_011704_create_products_pricing_table',1);
INSERT INTO `migrations` VALUES (325,'2019_03_08_011704_create_products_pricing_temp_table',1);
INSERT INTO `migrations` VALUES (326,'2019_03_08_011704_create_products_related_table',1);
INSERT INTO `migrations` VALUES (327,'2019_03_08_011704_create_products_resort_table',1);
INSERT INTO `migrations` VALUES (328,'2019_03_08_011704_create_products_reviews_table',1);
INSERT INTO `migrations` VALUES (329,'2019_03_08_011704_create_products_rules_fulfillment_conditions_items_table',1);
INSERT INTO `migrations` VALUES (330,'2019_03_08_011704_create_products_rules_fulfillment_conditions_table',1);
INSERT INTO `migrations` VALUES (331,'2019_03_08_011704_create_products_rules_fulfillment_distributors_table',1);
INSERT INTO `migrations` VALUES (332,'2019_03_08_011704_create_products_rules_fulfillment_rules_table',1);
INSERT INTO `migrations` VALUES (333,'2019_03_08_011704_create_products_rules_fulfillment_table',1);
INSERT INTO `migrations` VALUES (334,'2019_03_08_011704_create_products_rules_ordering_conditions_items_table',1);
INSERT INTO `migrations` VALUES (335,'2019_03_08_011704_create_products_rules_ordering_conditions_table',1);
INSERT INTO `migrations` VALUES (336,'2019_03_08_011704_create_products_rules_ordering_rules_table',1);
INSERT INTO `migrations` VALUES (337,'2019_03_08_011704_create_products_rules_ordering_table',1);
INSERT INTO `migrations` VALUES (338,'2019_03_08_011704_create_products_settings_sites_modulevalues_table',1);
INSERT INTO `migrations` VALUES (339,'2019_03_08_011704_create_products_settings_sites_table',1);
INSERT INTO `migrations` VALUES (340,'2019_03_08_011704_create_products_settings_table',1);
INSERT INTO `migrations` VALUES (341,'2019_03_08_011704_create_products_settings_templates_modulevalues_table',1);
INSERT INTO `migrations` VALUES (342,'2019_03_08_011704_create_products_settings_templates_table',1);
INSERT INTO `migrations` VALUES (343,'2019_03_08_011704_create_products_sorts_table',1);
INSERT INTO `migrations` VALUES (344,'2019_03_08_011704_create_products_specialties_check_table',1);
INSERT INTO `migrations` VALUES (345,'2019_03_08_011704_create_products_specialties_table',1);
INSERT INTO `migrations` VALUES (346,'2019_03_08_011704_create_products_specialtiesaccountsrules_table',1);
INSERT INTO `migrations` VALUES (347,'2019_03_08_011704_create_products_table',1);
INSERT INTO `migrations` VALUES (348,'2019_03_08_011704_create_products_tasks_table',1);
INSERT INTO `migrations` VALUES (349,'2019_03_08_011704_create_products_types_attributes_sets_table',1);
INSERT INTO `migrations` VALUES (350,'2019_03_08_011704_create_products_types_table',1);
INSERT INTO `migrations` VALUES (351,'2019_03_08_011704_create_products_viewed_table',1);
INSERT INTO `migrations` VALUES (352,'2019_03_08_011704_create_reports_breakdowns_table',1);
INSERT INTO `migrations` VALUES (353,'2019_03_08_011704_create_reports_products_fields_table',1);
INSERT INTO `migrations` VALUES (354,'2019_03_08_011704_create_reports_table',1);
INSERT INTO `migrations` VALUES (355,'2019_03_08_011704_create_reports_types_table',1);
INSERT INTO `migrations` VALUES (356,'2019_03_08_011704_create_resorts_amenities_table',1);
INSERT INTO `migrations` VALUES (357,'2019_03_08_011704_create_saved_cart_discounts_table',1);
INSERT INTO `migrations` VALUES (358,'2019_03_08_011704_create_saved_cart_items_customfields_table',1);
INSERT INTO `migrations` VALUES (359,'2019_03_08_011704_create_saved_cart_items_options_customvalues_table',1);
INSERT INTO `migrations` VALUES (360,'2019_03_08_011704_create_saved_cart_items_options_table',1);
INSERT INTO `migrations` VALUES (361,'2019_03_08_011704_create_saved_cart_items_table',1);
INSERT INTO `migrations` VALUES (362,'2019_03_08_011704_create_saved_cart_table',1);
INSERT INTO `migrations` VALUES (363,'2019_03_08_011704_create_saved_order_discounts_table',1);
INSERT INTO `migrations` VALUES (364,'2019_03_08_011704_create_saved_order_information_table',1);
INSERT INTO `migrations` VALUES (365,'2019_03_08_011704_create_saved_order_table',1);
INSERT INTO `migrations` VALUES (366,'2019_03_08_011704_create_search_forms_fields_table',1);
INSERT INTO `migrations` VALUES (367,'2019_03_08_011704_create_search_forms_sections_fields_table',1);
INSERT INTO `migrations` VALUES (368,'2019_03_08_011704_create_search_forms_sections_table',1);
INSERT INTO `migrations` VALUES (369,'2019_03_08_011704_create_search_forms_table',1);
INSERT INTO `migrations` VALUES (370,'2019_03_08_011704_create_search_history_table',1);
INSERT INTO `migrations` VALUES (371,'2019_03_08_011704_create_shipping_carriers_shipto_table',1);
INSERT INTO `migrations` VALUES (372,'2019_03_08_011704_create_shipping_carriers_table',1);
INSERT INTO `migrations` VALUES (373,'2019_03_08_011704_create_shipping_gateways_table',1);
INSERT INTO `migrations` VALUES (374,'2019_03_08_011704_create_shipping_label_sizes_table',1);
INSERT INTO `migrations` VALUES (375,'2019_03_08_011704_create_shipping_label_templates_table',1);
INSERT INTO `migrations` VALUES (376,'2019_03_08_011704_create_shipping_methods_table',1);
INSERT INTO `migrations` VALUES (377,'2019_03_08_011704_create_shipping_package_sizes_table',1);
INSERT INTO `migrations` VALUES (378,'2019_03_08_011704_create_shipping_package_types_table',1);
INSERT INTO `migrations` VALUES (379,'2019_03_08_011704_create_shipping_signature_options_table',1);
INSERT INTO `migrations` VALUES (380,'2019_03_08_011704_create_sites_categories_table',1);
INSERT INTO `migrations` VALUES (381,'2019_03_08_011704_create_sites_currencies_table',1);
INSERT INTO `migrations` VALUES (382,'2019_03_08_011704_create_sites_datafeeds_table',1);
INSERT INTO `migrations` VALUES (383,'2019_03_08_011704_create_sites_inventory_rules_table',1);
INSERT INTO `migrations` VALUES (384,'2019_03_08_011704_create_sites_languages_table',1);
INSERT INTO `migrations` VALUES (385,'2019_03_08_011704_create_sites_message_templates_table',1);
INSERT INTO `migrations` VALUES (386,'2019_03_08_011704_create_sites_packingslip_table',1);
INSERT INTO `migrations` VALUES (387,'2019_03_08_011704_create_sites_payment_methods_table',1);
INSERT INTO `migrations` VALUES (388,'2019_03_08_011704_create_sites_settings_modulevalues_table',1);
INSERT INTO `migrations` VALUES (389,'2019_03_08_011704_create_sites_settings_table',1);
INSERT INTO `migrations` VALUES (390,'2019_03_08_011704_create_sites_tax_rules_table',1);
INSERT INTO `migrations` VALUES (391,'2019_03_08_011704_create_sites_themes_table',1);
INSERT INTO `migrations` VALUES (392,'2019_03_08_011704_create_states_table',1);
INSERT INTO `migrations` VALUES (393,'2019_03_08_011704_create_system_alerts_table',1);
INSERT INTO `migrations` VALUES (394,'2019_03_08_011704_create_system_errors_table',1);
INSERT INTO `migrations` VALUES (395,'2019_03_08_011704_create_system_logs_table',1);
INSERT INTO `migrations` VALUES (396,'2019_03_08_011704_create_system_membership_table',1);
INSERT INTO `migrations` VALUES (397,'2019_03_08_011704_create_system_messages_table',1);
INSERT INTO `migrations` VALUES (398,'2019_03_08_011704_create_system_table',1);
INSERT INTO `migrations` VALUES (399,'2019_03_08_011704_create_system_tasks_table',1);
INSERT INTO `migrations` VALUES (400,'2019_03_08_011704_create_system_updates_table',1);
INSERT INTO `migrations` VALUES (401,'2019_03_08_011704_create_tax_rules_locations_table',1);
INSERT INTO `migrations` VALUES (402,'2019_03_08_011704_create_tax_rules_product_types_table',1);
INSERT INTO `migrations` VALUES (403,'2019_03_08_011704_create_tax_rules_table',1);
INSERT INTO `migrations` VALUES (404,'2019_03_08_011704_create_wishlists_items_customfields_table',1);
INSERT INTO `migrations` VALUES (405,'2019_03_08_011704_create_wishlists_items_options_customvalues_table',1);
INSERT INTO `migrations` VALUES (406,'2019_03_08_011704_create_wishlists_items_options_table',1);
INSERT INTO `migrations` VALUES (407,'2019_03_08_011704_create_wishlists_items_table',1);
INSERT INTO `migrations` VALUES (408,'2019_03_08_011704_create_wishlists_table',1);
INSERT INTO `migrations` VALUES (409,'2019_03_08_012505_create_faqs_categories_table',1);
INSERT INTO `migrations` VALUES (410,'2019_03_08_012505_create_menus_links_table',1);
INSERT INTO `migrations` VALUES (411,'2019_03_08_012505_create_mods_resort_details_amenities_table',1);
INSERT INTO `migrations` VALUES (412,'2019_03_08_012808_create_accounts_specialties_table',1);
INSERT INTO `migrations` VALUES (413,'2019_07_18_185030_add_name_phone_to_admin_users_table',1);
INSERT INTO `migrations` VALUES (414,'2019_07_18_190654_add_fpt_manager_id_to_mods_resort_details_table',1);
INSERT INTO `migrations` VALUES (415,'2019_08_19_000000_create_failed_jobs_table',1);
INSERT INTO `migrations` VALUES (416,'2019_11_09_010627_add_mobile_bg_image_to_mods_resort_details_table',1);
INSERT INTO `migrations` VALUES (417,'2019_12_12_173806_add_account_id_to_admin_users_table',1);
INSERT INTO `migrations` VALUES (418,'2019_12_14_000001_create_personal_access_tokens_table',1);
INSERT INTO `migrations` VALUES (419,'2019_12_15_015843_add_new_fields_to_resort_table',1);
INSERT INTO `migrations` VALUES (420,'2020_01_23_170902_add_fee_entertainment_toggle_to_resort_details_table',1);
INSERT INTO `migrations` VALUES (421,'2020_02_06_164301_add_fee_total_to_resort_details_table',1);
INSERT INTO `migrations` VALUES (422,'2020_03_21_032251_membership_tweaks',1);
INSERT INTO `migrations` VALUES (423,'2020_03_21_040954_create_paypal_subscriptions_table',1);
INSERT INTO `migrations` VALUES (424,'2020_03_25_230310_add_supports_auto_renewal_to_payment_methods',1);
INSERT INTO `migrations` VALUES (425,'2020_03_26_010949_increase_size_of_payment_account_fields',1);
INSERT INTO `migrations` VALUES (426,'2020_03_27_001617_update_paypal_subscription_id',1);
INSERT INTO `migrations` VALUES (427,'2020_03_28_222842_add_trial_flag_to_account_types',1);
INSERT INTO `migrations` VALUES (428,'2020_03_29_230758_increase_size_of_message_template_system_id_field',1);
INSERT INTO `migrations` VALUES (429,'2020_03_30_230413_add_auto_renew_reward_to_membership_levels',1);
INSERT INTO `migrations` VALUES (430,'2020_08_24_141446_change_for_data_correction',1);
INSERT INTO `migrations` VALUES (431,'2022_06_12_164004_update_resort_type_column',1);
INSERT INTO `migrations` VALUES (432,'2022_06_16_014038_update_accounts_email_pass_fields',1);
INSERT INTO `migrations` VALUES (433,'2022_06_22_095219_change_table_name_dash_to_underscore',1);
INSERT INTO `migrations` VALUES (434,'2022_06_22_145321_int_to_bigint_1',1);
INSERT INTO `migrations` VALUES (435,'2022_06_22_182419_int_to_bigint_2',1);
INSERT INTO `migrations` VALUES (436,'2022_06_22_191930_int_to_bigint_3',1);
INSERT INTO `migrations` VALUES (437,'2022_07_10_151939_update_accounts_defaults',1);
INSERT INTO `migrations` VALUES (438,'2022_07_13_152653_add_foreign_key',1);
INSERT INTO `migrations` VALUES (439,'2022_08_02_134211_drop_and_rename_table',1);
INSERT INTO `migrations` VALUES (440,'2022_09_10_025206_distributor_inv_account_can_be_null',1);
INSERT INTO `migrations` VALUES (441,'2022_09_23_114323_change_field_length',1);
INSERT INTO `migrations` VALUES (442,'2022_09_24_144650_create_registrations_table',1);
INSERT INTO `migrations` VALUES (443,'2022_09_27_023910_create_addresses_table',1);
INSERT INTO `migrations` VALUES (444,'2022_10_01_193126_remove_unneeded_address_fields',1);
INSERT INTO `migrations` VALUES (445,'2022_10_03_015052_update_order_transactions_table',1);
INSERT INTO `migrations` VALUES (446,'2022_10_04_143657_create_regsitration_discounts',1);
INSERT INTO `migrations` VALUES (447,'2022_10_08_022423_remove_discount_condition_and_advantage_types',1);
INSERT INTO `migrations` VALUES (448,'2022_10_09_010336_update_cart_tables',1);
INSERT INTO `migrations` VALUES (449,'2022_10_09_191744_create_cart_discount_codes_table',1);
INSERT INTO `migrations` VALUES (450,'2022_10_09_192201_create_cart_discount_advantages_table',1);
INSERT INTO `migrations` VALUES (451,'2022_10_09_200007_create_cart_item_options_table',1);
INSERT INTO `migrations` VALUES (452,'2022_10_09_200848_create_cart_item_option_custom_values_table',1);
INSERT INTO `migrations` VALUES (453,'2022_10_15_154918_create_cart_item_discount_advantages_table',1);
INSERT INTO `migrations` VALUES (454,'2022_10_15_155054_create_cart_item_discount_conditions_table',1);
INSERT INTO `migrations` VALUES (455,'2022_10_16_031557_update_default_account_status_field',1);
INSERT INTO `migrations` VALUES (456,'2022_10_19_164957_create_support_department_table',1);
INSERT INTO `migrations` VALUES (457,'2022_10_23_115929_update_category_table',1);
INSERT INTO `migrations` VALUES (458,'2022_10_23_170202_update_product_indexes',1);
INSERT INTO `migrations` VALUES (459,'2022_10_23_172406_update_site_table',1);
INSERT INTO `migrations` VALUES (460,'2022_10_23_204847_create_cart_discounts_table',1);
INSERT INTO `migrations` VALUES (461,'2022_10_28_070530_update_site_setting_default_value',1);
INSERT INTO `migrations` VALUES (462,'2022_10_28_072014_update_site_template_default_value',1);
INSERT INTO `migrations` VALUES (463,'2022_10_30_205855_add_pk_to_products_pricing',1);
INSERT INTO `migrations` VALUES (464,'2022_11_01_014354_consolidate_cart_item_option_custom_value',1);
INSERT INTO `migrations` VALUES (465,'2022_11_05_162131_add_site_id_to_cart_table',1);
INSERT INTO `migrations` VALUES (466,'2022_11_06_132436_update_category_settings_default',1);
INSERT INTO `migrations` VALUES (467,'2022_11_08_081302_product_and_related_table_default_value',1);
INSERT INTO `migrations` VALUES (468,'2022_11_09_133737_products_accessories_table_default_value',1);
INSERT INTO `migrations` VALUES (469,'2022_11_10_152952_add_auto_increment_to_product_related_table',1);
INSERT INTO `migrations` VALUES (470,'2022_11_10_154920_add_auto_increment_id_to_product_image',1);
INSERT INTO `migrations` VALUES (471,'2022_11_16_022915_fix_order_condition_f_k',1);
INSERT INTO `migrations` VALUES (472,'2022_11_17_105640_custome_from_product_table_rank_default',1);
INSERT INTO `migrations` VALUES (473,'2022_11_19_181215_attribute_option_value_default',1);
INSERT INTO `migrations` VALUES (474,'2022_11_20_092139_category_relational_table_delete_cascade',1);
INSERT INTO `migrations` VALUES (475,'2022_11_24_103108_page_table_nullable',1);
INSERT INTO `migrations` VALUES (476,'2022_11_24_185253_element_table_default',1);
INSERT INTO `migrations` VALUES (477,'2022_11_25_141410_product_review_table_remove_foreign_key',1);
INSERT INTO `migrations` VALUES (478,'2022_11_27_105946_brand_table_foreign_key_cascade',1);
INSERT INTO `migrations` VALUES (479,'2022_11_27_113324_ordering_rule_default',1);
INSERT INTO `migrations` VALUES (480,'2022_11_28_174211_cascade_delete_for_product_type',1);
INSERT INTO `migrations` VALUES (481,'2022_12_03_185323_element_foreign_key',1);
INSERT INTO `migrations` VALUES (482,'2022_12_05_185430_cascade_delete_for_ordering_rule',1);
INSERT INTO `migrations` VALUES (483,'2022_12_08_131842_ordering_condition_default_value',1);
INSERT INTO `migrations` VALUES (484,'2022_12_10_223728_change_decimal_to_int_for_price_rule_level',1);
INSERT INTO `migrations` VALUES (485,'2022_12_11_175939_decimal_to_big_int_others_table',1);
INSERT INTO `migrations` VALUES (486,'2022_12_15_192246_product_option_default_value',1);
INSERT INTO `migrations` VALUES (487,'2022_12_16_120018_product_option_value_default',1);
INSERT INTO `migrations` VALUES (488,'2023_01_07_135027_affiliate_status_field_default',1);
INSERT INTO `migrations` VALUES (489,'2023_01_24_150654_default_value_product_details',1);
INSERT INTO `migrations` VALUES (490,'2023_01_28_140000_image_table_default_null',1);
INSERT INTO `migrations` VALUES (491,'2023_02_19_105208_product_accessories_default',1);
INSERT INTO `migrations` VALUES (492,'2023_02_28_063104_product_site_settings_default_field',1);
INSERT INTO `migrations` VALUES (493,'2023_03_05_122032_create_tmp_files',1);
INSERT INTO `migrations` VALUES (494,'2023_03_19_142448_category_site_setting_default_field',1);
INSERT INTO `migrations` VALUES (495,'2023_03_31_085854_create_rank_field_for_feature_and_show_category_product',1);
INSERT INTO `migrations` VALUES (496,'2023_04_09_154733_add_id_to_product_accessory_field',1);
INSERT INTO `migrations` VALUES (497,'2023_04_11_145617_add_id_in_product_attribute',1);
INSERT INTO `migrations` VALUES (498,'2023_04_30_125808_drop_index_and_create_unique_index',1);
INSERT INTO `migrations` VALUES (499,'2023_05_09_104846_add_id_field_site_language',1);
INSERT INTO `migrations` VALUES (500,'2023_05_09_134643_page_translation_table',1);
INSERT INTO `migrations` VALUES (501,'2023_05_12_184742_create_element_translation_table',1);
INSERT INTO `migrations` VALUES (502,'2023_05_14_021450_create_category_translations_table',1);
INSERT INTO `migrations` VALUES (503,'2023_05_15_112452_brand_name_unique',1);
INSERT INTO `migrations` VALUES (504,'2023_05_16_023930_create_product_translations_table',1);
INSERT INTO `migrations` VALUES (505,'2023_05_17_124135_create_product_option_translations',1);
INSERT INTO `migrations` VALUES (506,'2023_05_17_124718_create_product_option_value_translations',1);
INSERT INTO `migrations` VALUES (507,'2023_05_22_111711_create_attribute_set_translations_table',1);
INSERT INTO `migrations` VALUES (508,'2023_05_22_112605_create_attribute_translations_table',1);
INSERT INTO `migrations` VALUES (509,'2023_05_22_112655_create_attribute_option_translations_table',1);
INSERT INTO `migrations` VALUES (510,'2023_05_26_091722_create_ordering_rule_translation_table',1);
INSERT INTO `migrations` VALUES (511,'2023_05_31_190309_rank_default_value',1);
INSERT INTO `migrations` VALUES (512,'2023_06_04_150231_create_id_for_checkout_payments',1);
INSERT INTO `migrations` VALUES (513,'2023_06_05_091139_create_site_translation_table',1);
INSERT INTO `migrations` VALUES (514,'2023_06_09_055824_change_bulk_edit_change',1);
INSERT INTO `migrations` VALUES (515,'2023_06_19_145335_bulk_edit_string_size_increase',1);
INSERT INTO `migrations` VALUES (516,'2023_06_21_154311_add_id_to_site_currency',1);
INSERT INTO `migrations` VALUES (517,'2023_06_27_103126_category_moudule_template_id_default',1);
