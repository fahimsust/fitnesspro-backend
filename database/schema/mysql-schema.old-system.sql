-- -------------------------------------------------------------
-- TablePlus 5.4.0(504)
--
-- https://tableplus.com/
--
-- Database: fitness_pro_travel
-- Generation Time: 2023-09-18 16:35:46.3370
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

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


CREATE TABLE `accessories_fields` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `label` varchar(100) NOT NULL,
  `field_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=select menu, 2=radio options, 3=checkboxes',
  `required` tinyint(1) NOT NULL,
  `select_display` varchar(65) NOT NULL COMMENT 'select menu default display before option is selected',
  `select_auto` tinyint(1) NOT NULL COMMENT 'should the first option be auto selected',
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accessories_fields_products` (
  `accessories_fields_id` int NOT NULL,
  `product_id` int NOT NULL,
  `label` varchar(100) NOT NULL,
  `rank` int NOT NULL,
  `price_adjust_type` tinyint(1) NOT NULL COMMENT '1=adjust this price, 2=adjust parent price',
  `price_adjust_calc` tinyint(1) NOT NULL COMMENT '1=flat amount, 2=percentage',
  `price_adjust_amount` decimal(8,2) NOT NULL,
  UNIQUE KEY `accessories_fields_id_2` (`accessories_fields_id`,`product_id`),
  KEY `accessories_fields_id` (`accessories_fields_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_email` varchar(85) NOT NULL,
  `account_user` varchar(55) NOT NULL,
  `account_pass` varchar(35) NOT NULL,
  `account_phone` varchar(15) NOT NULL,
  `account_created` datetime NOT NULL,
  `account_lastlogin` datetime NOT NULL,
  `account_status_id` tinyint NOT NULL,
  `account_type_id` int NOT NULL DEFAULT '1',
  `default_billing_id` int NOT NULL,
  `default_shipping_id` int NOT NULL,
  `affiliate_id` int NOT NULL,
  `cim_profile_id` int NOT NULL,
  `first_name` varchar(55) NOT NULL,
  `last_name` varchar(55) NOT NULL,
  `admin_notes` text NOT NULL,
  `photo_id` int NOT NULL,
  `site_id` int NOT NULL,
  `loyaltypoints_id` int NOT NULL,
  `profile_public` tinyint(1) NOT NULL DEFAULT '1',
  `send_verify_email` tinyint NOT NULL COMMENT '0 = allow, 1=disallow',
  `last_verify_attempt_date` date NOT NULL,
  `user_ip` varchar(50) DEFAULT NULL,
  `membership_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `account_status_id` (`account_status_id`),
  KEY `id` (`id`,`account_created`,`account_status_id`),
  KEY `account_created` (`account_created`,`account_status_id`),
  KEY `account_created_2` (`account_created`)
) ENGINE=InnoDB AUTO_INCREMENT=52069 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts-membership-attributes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `rank` int NOT NULL,
  `details` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `section_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts-membership-attributes-sections` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `rank` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts-membership-levels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `rank` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  `annual_product_id` int NOT NULL,
  `monthly_product_id` int NOT NULL,
  `renewal_discount` decimal(5,2) NOT NULL,
  `description` text NOT NULL,
  `signupemail_customer` int DEFAULT NULL,
  `renewemail_customer` int DEFAULT NULL,
  `expirationalert1_email` int DEFAULT NULL,
  `expirationalert2_email` int DEFAULT NULL,
  `expiration_email` int DEFAULT NULL,
  `affiliate_level_id` int NOT NULL,
  `is_default` tinyint(1) NOT NULL,
  `signuprenew_option` tinyint(1) NOT NULL DEFAULT '1',
  `auto_renewal_of` int DEFAULT NULL,
  `trial` tinyint(1) NOT NULL DEFAULT '0',
  `paypal_plan_id` varchar(255) DEFAULT NULL,
  `auto_renew_reward` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts-membership-levels_attributes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `level_id` int NOT NULL,
  `attribute_id` int NOT NULL,
  `attribute_value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `level_id` (`level_id`,`attribute_id`)
) ENGINE=InnoDB AUTO_INCREMENT=852 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts-membership-levels_settings` (
  `level_id` int NOT NULL AUTO_INCREMENT,
  `badge` int NOT NULL,
  `search_limit` int NOT NULL,
  `event_limit` int NOT NULL,
  `ad_limit` int NOT NULL,
  PRIMARY KEY (`level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts-memberships_payment_methods` (
  `site_id` int NOT NULL,
  `payment_method_id` int NOT NULL,
  `gateway_account_id` int NOT NULL,
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts-specialties` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent_id` int DEFAULT NULL,
  `name` varchar(55) NOT NULL,
  `rank` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts-specialties_products` (
  `specialty_id` int NOT NULL,
  `product_id` int NOT NULL,
  UNIQUE KEY `type_id` (`specialty_id`,`product_id`),
  KEY `product_id` (`product_id`),
  KEY `type_id_2` (`specialty_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts-statuses` (
  `id` tinyint NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts-types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `default_account_status` tinyint NOT NULL,
  `custom_form_id` int NOT NULL,
  `email_template_id_creation_admin` int NOT NULL,
  `email_template_id_creation_user` int NOT NULL,
  `email_template_id_activate_user` int NOT NULL,
  `discount_level_id` int NOT NULL,
  `verify_user_email` tinyint NOT NULL DEFAULT '0',
  `filter_products` tinyint(1) NOT NULL COMMENT '0=no, 1=show select, 2= hide selected',
  `filter_categories` tinyint(1) NOT NULL COMMENT '0=no, 1=show select, 2= hide selected',
  `loyaltypoints_id` int NOT NULL,
  `use_specialties` tinyint(1) NOT NULL,
  `membership_level_id` int NOT NULL,
  `email_template_id_verify_email` int NOT NULL,
  `affiliate_level_id` int NOT NULL,
  `is_trial` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts-types_categories` (
  `type_id` int NOT NULL,
  `category_id` int NOT NULL,
  UNIQUE KEY `type_id` (`type_id`,`category_id`),
  KEY `product_id` (`category_id`),
  KEY `type_id_2` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts-types_products` (
  `type_id` int NOT NULL,
  `product_id` int NOT NULL,
  UNIQUE KEY `type_id` (`type_id`,`product_id`),
  KEY `product_id` (`product_id`),
  KEY `type_id_2` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts-types_restrictordering` (
  `type_id` int NOT NULL,
  `product_id` int NOT NULL,
  UNIQUE KEY `type_id` (`type_id`,`product_id`),
  KEY `product_id` (`product_id`),
  KEY `type_id_2` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_addressbook` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_id` int NOT NULL,
  `label` varchar(35) NOT NULL,
  `is_billing` tinyint(1) NOT NULL,
  `is_shipping` tinyint(1) NOT NULL,
  `company` varchar(155) NOT NULL,
  `first_name` varchar(55) NOT NULL,
  `last_name` varchar(55) NOT NULL,
  `address_1` varchar(85) NOT NULL,
  `address_2` varchar(85) NOT NULL,
  `city` varchar(35) NOT NULL,
  `state_id` int NOT NULL,
  `country_id` int NOT NULL,
  `postal_code` varchar(15) NOT NULL,
  `email` varchar(85) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `is_residential` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `old_billingid` int NOT NULL,
  `old_shippingid` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=75763 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_addtl_fields` (
  `account_id` int NOT NULL,
  `form_id` int NOT NULL,
  `section_id` int NOT NULL,
  `field_id` int NOT NULL,
  `field_value` text NOT NULL,
  UNIQUE KEY `account_id_2` (`account_id`,`form_id`,`section_id`,`field_id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_advertising` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(500) NOT NULL,
  `img` varchar(155) NOT NULL,
  `clicks` int NOT NULL,
  `shown` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_advertising_campaigns` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lastshown_ad` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_advertising_clicks` (
  `ad_id` int NOT NULL,
  `clicked` datetime NOT NULL,
  KEY `ad_id` (`ad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_bulletins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_id` int NOT NULL,
  `subject` varchar(155) NOT NULL,
  `body` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_cims` (
  `account_id` int NOT NULL,
  `cim_profile_id` int NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8007 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_id` int NOT NULL,
  `body` text NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `beenread` tinyint(1) NOT NULL DEFAULT '0',
  `replyto_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `replyto_id` (`replyto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=352 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_discounts_used` (
  `account_id` int NOT NULL,
  `discount_id` int NOT NULL,
  `order_id` int NOT NULL,
  `times_used` int NOT NULL,
  `used` datetime NOT NULL,
  KEY `account_id` (`account_id`),
  KEY `discount_id` (`discount_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_loyaltypoints` (
  `account_id` int NOT NULL,
  `loyaltypoints_level_id` int NOT NULL,
  `points_available` int NOT NULL,
  UNIQUE KEY `account_id_2` (`account_id`,`loyaltypoints_level_id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_loyaltypoints_credits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_id` int NOT NULL,
  `loyaltypoints_level_id` int NOT NULL,
  `shipment_id` int NOT NULL,
  `points_awarded` int NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0=pending, 1=credited',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `shipment_id` (`shipment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_loyaltypoints_debits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_id` int NOT NULL,
  `loyaltypoints_level_id` int NOT NULL,
  `order_id` int NOT NULL,
  `points_used` int NOT NULL,
  `created` datetime NOT NULL,
  `notes` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_id_2` (`account_id`,`loyaltypoints_level_id`,`order_id`),
  KEY `account_id` (`account_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_memberships` (
  `id` int NOT NULL AUTO_INCREMENT,
  `membership_id` int NOT NULL,
  `amount_paid` decimal(8,2) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `account_id` int NOT NULL,
  `order_id` int NOT NULL,
  `subscription_price` decimal(8,2) NOT NULL,
  `product_id` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `cancelled` datetime DEFAULT NULL,
  `expirealert1_sent` tinyint(1) NOT NULL,
  `expirealert2_sent` tinyint(1) NOT NULL,
  `expire_sent` tinyint(1) NOT NULL,
  `auto_renew` tinyint(1) NOT NULL DEFAULT '0',
  `renew_payment_method` tinyint DEFAULT NULL,
  `renew_payment_profile_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=99884 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_message_keys` (
  `key_id` varchar(55) NOT NULL,
  `key_var` varchar(55) NOT NULL,
  PRIMARY KEY (`key_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `header_id` int NOT NULL,
  `replied_id` int NOT NULL,
  `to_id` int NOT NULL,
  `from_id` int NOT NULL,
  `body` text NOT NULL,
  `sent` datetime NOT NULL,
  `readdate` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=deleted, 2=spam, 3=saved',
  `beenseen` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39112 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_messages_headers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35282 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_oldbilling` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_id` int NOT NULL,
  `name` varchar(20) NOT NULL,
  `bill_first_name` varchar(35) NOT NULL,
  `bill_last_name` varchar(35) NOT NULL,
  `bill_address_1` varchar(85) NOT NULL,
  `bill_address_2` varchar(85) NOT NULL,
  `bill_city` varchar(35) NOT NULL,
  `bill_state_id` int NOT NULL,
  `bill_country_id` int NOT NULL,
  `bill_postal_code` varchar(15) NOT NULL,
  `bill_phone` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4650 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_oldfitpro` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_email` varchar(85) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `account_user` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `account_pass` varchar(35) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `account_phone` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `account_created` datetime NOT NULL,
  `account_lastlogin` datetime NOT NULL,
  `account_status_id` tinyint NOT NULL,
  `account_type_id` int NOT NULL,
  `default_billing_id` int NOT NULL,
  `default_shipping_id` int NOT NULL,
  `affiliate_id` int NOT NULL,
  `cim_profile_id` int NOT NULL,
  `first_name` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `last_name` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `admin_notes` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `photo_id` int NOT NULL,
  `site_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_status_id` (`account_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31222 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE TABLE `accounts_oldfitproinstructors` (
  `account_id` int NOT NULL AUTO_INCREMENT,
  `biography` text NOT NULL,
  `cert` varchar(255) NOT NULL DEFAULT '',
  `certby` text NOT NULL,
  `proexp` text NOT NULL,
  `ref1` varchar(50) NOT NULL DEFAULT '',
  `ref1_phone` varchar(20) NOT NULL DEFAULT '',
  `ref2` varchar(50) NOT NULL DEFAULT '',
  `ref2_phone` varchar(20) NOT NULL DEFAULT '',
  `level` tinyint NOT NULL,
  `businessname` varchar(55) NOT NULL,
  `employersname` varchar(55) NOT NULL,
  `website_1` varchar(55) NOT NULL,
  `website_2` varchar(55) NOT NULL,
  `cert_1_num` varchar(35) NOT NULL,
  `cert_1_exp` date NOT NULL,
  `cert_2_num` varchar(35) NOT NULL,
  `cert_2_exp` date NOT NULL,
  `cert_3_num` varchar(35) NOT NULL,
  `cert_3_exp` date NOT NULL,
  `other_cert` text NOT NULL,
  `gender` varchar(1) NOT NULL,
  `dob` date NOT NULL,
  `ref3` varchar(55) NOT NULL,
  `ref3_phone` varchar(15) NOT NULL,
  `ref3_email` varchar(65) NOT NULL,
  `ref2_email` varchar(65) NOT NULL,
  `ref1_email` varchar(65) NOT NULL,
  `secondary_email` varchar(65) NOT NULL,
  `cell_phone` varchar(15) NOT NULL,
  `ref1_relation` varchar(55) NOT NULL,
  `ref2_relation` varchar(55) NOT NULL,
  `ref3_relation` varchar(55) NOT NULL,
  `cert_1_org` varchar(55) NOT NULL,
  `cert_1_type` varchar(55) NOT NULL,
  `cert_2_org` varchar(55) NOT NULL,
  `cert_2_type` varchar(55) NOT NULL,
  `cert_3_org` varchar(55) NOT NULL,
  `cert_3_type` varchar(55) NOT NULL,
  `views` int NOT NULL,
  `address` varchar(100) NOT NULL,
  `address_2` varchar(100) NOT NULL,
  `city` varchar(35) NOT NULL,
  `state_id` int NOT NULL,
  `country_id` int NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `affiliate_account_id` int NOT NULL,
  `profile_public` tinyint(1) NOT NULL DEFAULT '1',
  `modified_by_pro` datetime NOT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27558 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_oldmembership` (
  `id` int NOT NULL AUTO_INCREMENT,
  `level_id` int NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `account_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `end_date` (`end_date`)
) ENGINE=InnoDB AUTO_INCREMENT=44229 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_oldshipping` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_id` int NOT NULL,
  `name` varchar(20) NOT NULL,
  `ship_first_name` varchar(35) NOT NULL,
  `ship_last_name` varchar(35) NOT NULL,
  `ship_address_1` varchar(85) NOT NULL,
  `ship_address_2` varchar(85) NOT NULL,
  `ship_city` varchar(35) NOT NULL,
  `ship_state_id` int NOT NULL,
  `ship_country_id` int NOT NULL,
  `ship_postal_code` varchar(15) NOT NULL,
  `ship_email` varchar(85) NOT NULL,
  `is_residential` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4441 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_oldspecialties` (
  `instructor_id` int NOT NULL,
  `specialty_id` int NOT NULL,
  KEY `instructor_id` (`instructor_id`),
  KEY `specialty_id` (`specialty_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_onmind` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_id` int NOT NULL,
  `text` text NOT NULL,
  `posted` datetime NOT NULL,
  `like_count` int NOT NULL DEFAULT '0',
  `dislike_count` int NOT NULL DEFAULT '0',
  `comment_count` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2602 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_onmind_comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `onmind_id` int NOT NULL,
  `comment_id` int NOT NULL,
  `account_id` int NOT NULL,
  `text` varchar(200) NOT NULL,
  `posted` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `onmind_id` (`onmind_id`,`comment_id`,`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2261 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_onmind_likes` (
  `onmind_id` int NOT NULL,
  `account_id` int NOT NULL,
  `type_id` tinyint(1) NOT NULL,
  KEY `onmind_id` (`onmind_id`,`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_programs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_programs_accounts` (
  `account_id` int NOT NULL,
  `program_id` int NOT NULL,
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_resourcebox` (
  `account_id` int NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `about_author` varchar(500) NOT NULL,
  `link_1` varchar(255) NOT NULL,
  `link_2` varchar(255) NOT NULL,
  `link_1_title` varchar(65) NOT NULL,
  `link_2_title` varchar(65) NOT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_specialties` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_id` int NOT NULL,
  `specialty_id` int NOT NULL,
  `approved` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_id_2` (`account_id`,`specialty_id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1671609 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_templates_sent` (
  `account_id` int NOT NULL,
  `template_id` int NOT NULL,
  `sent` datetime NOT NULL,
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `transid` varchar(35) NOT NULL,
  `ccnum` varchar(4) NOT NULL,
  `ccexpmonth` tinyint NOT NULL,
  `ccexpyear` year NOT NULL,
  `account_id` int NOT NULL,
  `zipcode` varchar(15) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `status` tinyint NOT NULL,
  `description` varchar(255) NOT NULL,
  `orig_amount` decimal(8,2) NOT NULL,
  `disc_amount` decimal(8,2) NOT NULL,
  `disc_code` varchar(55) NOT NULL,
  `created` datetime NOT NULL,
  `membership_id` int NOT NULL,
  `payment_profile_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8194 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_updates` (
  `account_id` int NOT NULL,
  `newmessages` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `accounts_views` (
  `profile_id` int NOT NULL,
  `account_id` int NOT NULL COMMENT 'viewers id',
  `viewed_date` date NOT NULL,
  `viewed_time` time NOT NULL,
  KEY `profile_id` (`profile_id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `admin_emails_sent` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_id` int NOT NULL,
  `template_id` int NOT NULL,
  `sent_to` varchar(85) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `sent_date` datetime NOT NULL,
  `sent_by` int NOT NULL,
  `order_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `admin_levels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `admin_levels_menus` (
  `level_id` int NOT NULL,
  `menu_id` int NOT NULL,
  KEY `level_id` (`level_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `admin_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user` varchar(15) NOT NULL,
  `password` varchar(15) NOT NULL,
  `email` varchar(65) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `level_id` int NOT NULL,
  `filter_orders` tinyint(1) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `account_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `admin_users_distributors` (
  `user_id` int NOT NULL,
  `distributor_id` int NOT NULL,
  UNIQUE KEY `user_id` (`user_id`,`distributor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `affiliates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(155) NOT NULL,
  `email` varchar(85) NOT NULL,
  `password` varchar(35) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address_1` varchar(100) NOT NULL,
  `address_2` varchar(100) NOT NULL,
  `city` char(35) NOT NULL,
  `state_id` int NOT NULL,
  `country_id` int NOT NULL,
  `postal_code` varchar(15) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `affiliate_level_id` int NOT NULL DEFAULT '100',
  `account_id` int NOT NULL COMMENT 'if linking account to affiliate',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51814 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `affiliates_levels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(35) NOT NULL,
  `order_rate` decimal(6,2) NOT NULL,
  `subscription_rate` decimal(6,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `affiliates_oldfitpro` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(155) NOT NULL,
  `email` varchar(85) NOT NULL,
  `password` varchar(35) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address_1` varchar(100) NOT NULL,
  `address_2` varchar(100) NOT NULL,
  `city` char(35) NOT NULL,
  `state_id` int NOT NULL,
  `country_id` int NOT NULL,
  `postal_code` varchar(15) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `affiliate_level_id` int NOT NULL DEFAULT '100',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31020 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `affiliates_payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `affiliate_id` int NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `notes` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `affiliate_id` (`affiliate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `affiliates_payments_referrals` (
  `payment_id` int NOT NULL,
  `referral_id` int NOT NULL,
  KEY `referral_id` (`referral_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `affiliates_referrals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `affiliate_id` int NOT NULL,
  `order_id` int NOT NULL,
  `status_id` int NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `type_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `affiliate_id` (`affiliate_id`),
  KEY `type_id` (`type_id`),
  KEY `order_id` (`order_id`),
  KEY `ordertype_id` (`order_id`,`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2936 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `affiliates_referrals_statuses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `affiliates_referrals_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `airports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `articles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `headline` varchar(255) NOT NULL,
  `short_headline` varchar(35) NOT NULL,
  `author` varchar(155) NOT NULL,
  `body` longtext NOT NULL,
  `photo` int NOT NULL,
  `account_id` int NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `category` int NOT NULL,
  `views` int NOT NULL,
  `featured` tinyint(1) NOT NULL,
  `url_name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rank` (`views`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `articles_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `url_name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `articles_comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `article_id` int NOT NULL,
  `body` text NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `beenread` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(55) NOT NULL,
  `webaddress` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `articles_resources` (
  `article_id` int NOT NULL,
  `keywords` varchar(500) NOT NULL,
  `about_author` varchar(500) NOT NULL,
  `link_1` varchar(255) NOT NULL,
  `link_2` varchar(255) NOT NULL,
  `link_1_title` varchar(65) NOT NULL,
  `link_2_title` varchar(65) NOT NULL,
  PRIMARY KEY (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `articles_views` (
  `article_id` int NOT NULL,
  `account_id` int NOT NULL,
  `viewed_date` date NOT NULL,
  `viewed_time` time NOT NULL,
  KEY `article_id` (`article_id`,`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `attributes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `type_id` tinyint NOT NULL,
  `show_in_details` tinyint(1) NOT NULL,
  `show_in_search` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `attributes-packages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `attributes-packages_sets` (
  `package_id` int NOT NULL,
  `set_id` int NOT NULL,
  KEY `package_id` (`package_id`,`set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `attributes-sets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `attributes-sets_attributes` (
  `set_id` int NOT NULL,
  `attribute_id` int NOT NULL,
  KEY `set_id` (`set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `attributes-types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `attributes_options` (
  `id` int NOT NULL AUTO_INCREMENT,
  `attribute_id` int NOT NULL,
  `display` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL,
  `rank` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `attribute_id` (`attribute_id`)
) ENGINE=InnoDB AUTO_INCREMENT=633 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `automated_emails` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `message_template_id` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  `send_on` tinyint NOT NULL COMMENT '0=status change, 1=days after order, 2=days after shipped, 3= days after delivered',
  `send_on_status` int NOT NULL,
  `send_on_daysafter` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `message_template_id` (`message_template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `automated_emails_accounttypes` (
  `automated_email_id` int NOT NULL,
  `account_type_id` int NOT NULL,
  UNIQUE KEY `automated_email_id_2` (`automated_email_id`,`account_type_id`),
  KEY `automated_email_id` (`automated_email_id`),
  KEY `account_type_id` (`account_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `automated_emails_sites` (
  `automated_email_id` int NOT NULL,
  `site_id` int NOT NULL,
  UNIQUE KEY `automated_email_id_2` (`automated_email_id`,`site_id`),
  KEY `automated_email_id` (`automated_email_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `banners_campaigns` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `location` varchar(100) NOT NULL,
  `width` int NOT NULL,
  `height` int NOT NULL,
  `new_window` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `banners_clicks` (
  `banner_id` int NOT NULL,
  `clicked` datetime NOT NULL,
  KEY `banner_id` (`banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `banners_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `campaign_id` int NOT NULL,
  `name` varchar(55) NOT NULL,
  `link` varchar(255) NOT NULL,
  `image` varchar(100) NOT NULL,
  `clicks_no` int NOT NULL,
  `show_no` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `campaign_id` (`campaign_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `banners_shown` (
  `banner_id` int NOT NULL,
  `shown` datetime NOT NULL,
  KEY `banner_id` (`banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `blog_entry` (
  `id` int NOT NULL AUTO_INCREMENT,
  `blog_id` int NOT NULL,
  `body` blob NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `updated` datetime NOT NULL,
  `allowcomments` tinyint(1) NOT NULL,
  `title` varchar(100) NOT NULL,
  `short_title` varchar(35) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `views` int NOT NULL,
  `photo` int NOT NULL,
  `url_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `blog_entry_comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `entry_id` int NOT NULL,
  `body` text NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `beenread` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(55) NOT NULL,
  `webaddress` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `blog_entry_views` (
  `entry_id` int NOT NULL,
  `account_id` int NOT NULL,
  `viewed_date` date NOT NULL,
  `viewed_time` time NOT NULL,
  KEY `entry_id` (`entry_id`,`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `blogs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(155) NOT NULL,
  `description` varchar(800) NOT NULL,
  `createdby` int NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `lastposted` datetime NOT NULL,
  `allowcomments` tinyint(1) NOT NULL,
  `views` int NOT NULL,
  `photo` int NOT NULL,
  `featured` tinyint(1) NOT NULL,
  `url_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `blogs_views` (
  `blog_id` int NOT NULL,
  `account_id` varchar(10) NOT NULL,
  `viewed_date` date NOT NULL,
  `viewed_time` time NOT NULL,
  KEY `blog_id` (`blog_id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `board_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(155) NOT NULL,
  `description` varchar(255) NOT NULL,
  `board_id` int NOT NULL,
  `created` datetime NOT NULL,
  `rank` tinyint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `board_thread_entry` (
  `id` int NOT NULL AUTO_INCREMENT,
  `thread_id` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `body` text NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `thread_id` (`thread_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `board_threads` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int NOT NULL,
  `allowreply` tinyint(1) NOT NULL DEFAULT '1',
  `lastpost` datetime NOT NULL,
  `lastposter` int NOT NULL,
  `photo` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `board_threads_details` (
  `thread_id` int NOT NULL,
  `keywords` varchar(500) NOT NULL,
  `city` varchar(35) NOT NULL,
  `state` varchar(2) NOT NULL,
  `country` varchar(2) NOT NULL,
  `zipcode` varchar(15) NOT NULL,
  `webaddress` varchar(100) NOT NULL,
  `email` varchar(85) NOT NULL,
  `phone` varchar(15) NOT NULL,
  PRIMARY KEY (`thread_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `board_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `boards` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `type` tinyint NOT NULL,
  `group_id` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `bookingas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(555) NOT NULL,
  `display` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `bookingas_options` (
  `bookingas_id` int NOT NULL,
  `options` text NOT NULL,
  KEY `bookingas_id` (`bookingas_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `bookingas_products` (
  `bookingas_id` int NOT NULL,
  `product` int NOT NULL,
  KEY `bookingas_id` (`bookingas_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `brands` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `brands_index_1` (`id`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `bulkedit_change` (
  `id` int NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `action_type` varchar(10) NOT NULL,
  `action_changeto` text NOT NULL,
  `products_edited` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=247 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `bulkedit_change_products` (
  `change_id` int NOT NULL,
  `product_id` int NOT NULL,
  `changed_from` text NOT NULL,
  UNIQUE KEY `change_id` (`change_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `catalog_updates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(5) NOT NULL COMMENT '0=product, 1=category, 2=new image size, 5-5.99=datafeed, 6=sitemap, 7=notify backinstock',
  `item_id` int NOT NULL,
  `processing` tinyint(1) NOT NULL,
  `start` int NOT NULL,
  `info` text NOT NULL,
  `modified` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13585 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_id` int NOT NULL,
  `rank` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  `url_name` varchar(155) NOT NULL,
  `show_sale` tinyint(1) NOT NULL,
  `limit_min_price` tinyint(1) NOT NULL,
  `min_price` decimal(10,2) NOT NULL,
  `limit_max_price` tinyint(1) NOT NULL,
  `max_price` decimal(10,2) NOT NULL,
  `show_in_list` tinyint(1) NOT NULL DEFAULT '1',
  `limit_days` int NOT NULL,
  `meta_title` varchar(200) NOT NULL,
  `meta_desc` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `show_types` tinyint(1) NOT NULL DEFAULT '1',
  `show_brands` tinyint(1) NOT NULL DEFAULT '1',
  `rules_match_type` tinyint(1) NOT NULL COMMENT '0=any, 1=all',
  `inventory_id` varchar(35) NOT NULL,
  `menu_class` varchar(55) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `inventory_id` (`inventory_id`)
) ENGINE=InnoDB AUTO_INCREMENT=248 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `categories_attributes` (
  `category_id` int NOT NULL,
  `option_id` int NOT NULL,
  KEY `category_id` (`category_id`,`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `categories_attributes_rules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `temp_id` int NOT NULL,
  `match_type` tinyint(1) NOT NULL COMMENT '0=any, 1=all',
  `value_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `categories_brands` (
  `category_id` int NOT NULL,
  `brand_id` int NOT NULL,
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `categories_featured` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `product_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_id_2` (`category_id`,`product_id`),
  KEY `category_id` (`category_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `categories_products_assn` (
  `category_id` int NOT NULL,
  `product_id` int NOT NULL,
  `manual` tinyint(1) NOT NULL,
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `categories_products_hide` (
  `category_id` int NOT NULL,
  `product_id` int NOT NULL,
  UNIQUE KEY `catproduct` (`category_id`,`product_id`),
  KEY `category_id` (`category_id`),
  KEY `categories_products_hide_index_1` (`product_id`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `categories_products_ranks` (
  `category_id` int NOT NULL,
  `product_id` int NOT NULL,
  `rank` int NOT NULL,
  UNIQUE KEY `catproductmanual` (`category_id`,`product_id`),
  KEY `category_id` (`category_id`),
  KEY `categories_products_ranks_index_1` (`category_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `categories_products_sorts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `sort_id` int NOT NULL,
  `rank` int NOT NULL,
  `isdefault` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_id_2` (`category_id`,`sort_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `categories_rules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `temp_id` int NOT NULL,
  `match_type` tinyint(1) NOT NULL COMMENT '0=any, 1=all',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=247 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `categories_rules_attributes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rule_id` int NOT NULL,
  `value_id` int NOT NULL,
  `set_id` int NOT NULL,
  `match_type` tinyint NOT NULL COMMENT '0=matches, 1=doesn''t match',
  PRIMARY KEY (`id`),
  KEY `rule_id` (`rule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=242 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `categories_settings` (
  `category_id` int NOT NULL,
  `settings_template_id` int NOT NULL,
  `use_default_category` tinyint(1) NOT NULL,
  `use_default_feature` tinyint(1) NOT NULL,
  `use_default_product` tinyint(1) NOT NULL,
  `category_thumbnail_template` int NOT NULL,
  `product_thumbnail_template` int NOT NULL,
  `product_thumbnail_count` int NOT NULL,
  `feature_thumbnail_template` int NOT NULL,
  `feature_thumbnail_count` int NOT NULL,
  `feature_showsort` tinyint(1) NOT NULL,
  `product_thumbnail_showsort` tinyint(1) NOT NULL,
  `product_thumbnail_showmessage` tinyint(1) NOT NULL,
  `feature_showmessage` tinyint(1) NOT NULL,
  `show_categories_in_body` tinyint(1) NOT NULL,
  `show_products` tinyint(1) NOT NULL,
  `show_featured` tinyint(1) NOT NULL,
  `layout_id` int NOT NULL,
  `module_template_id` int NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `categories_settings_sites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `site_id` int NOT NULL,
  `settings_template_id` int DEFAULT NULL,
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
  `layout_id` int DEFAULT NULL,
  `module_template_id` int DEFAULT NULL,
  `search_form_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_id` (`category_id`,`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=456 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `categories_settings_sites_modulevalues` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `site_id` int NOT NULL,
  `section_id` int NOT NULL,
  `module_id` int NOT NULL,
  `field_id` int NOT NULL,
  `custom_value` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_id_3` (`category_id`,`site_id`,`section_id`,`module_id`,`field_id`),
  KEY `product_id` (`category_id`),
  KEY `product_id_2` (`category_id`,`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4064 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `categories_settings_templates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `settings_template_id` int DEFAULT NULL,
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
  `layout_id` int DEFAULT NULL,
  `module_template_id` int DEFAULT NULL,
  `module_custom_values` text NOT NULL,
  `search_form_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `categories_settings_templates_modulevalues` (
  `id` int NOT NULL AUTO_INCREMENT,
  `settings_template_id` int NOT NULL,
  `section_id` int NOT NULL,
  `module_id` int NOT NULL,
  `field_id` int NOT NULL,
  `custom_value` text,
  PRIMARY KEY (`id`),
  KEY `settings_template_id` (`settings_template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=349 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `categories_types` (
  `category_id` int NOT NULL,
  `type_id` int NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=199 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `cim_profile` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `authnet_profile_id` varchar(20) NOT NULL,
  `gateway_account_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17077 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `cim_profile_paymentprofile` (
  `id` int NOT NULL AUTO_INCREMENT,
  `profile_id` int NOT NULL,
  `first_cc_number` int NOT NULL,
  `cc_number` varchar(4) NOT NULL,
  `cc_exp` date NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `authnet_payment_profile_id` varchar(20) NOT NULL,
  `is_default` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `profile_id` (`profile_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28817 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `countries` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(85) NOT NULL,
  `abbreviation` varchar(3) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rank` int NOT NULL,
  `iso_code` varchar(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=660 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `countries_iso` (
  `name` varchar(255) NOT NULL,
  `iso` varchar(3) NOT NULL,
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `countries_regions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `country_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `rank` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `currencies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(35) NOT NULL,
  `code` varchar(8) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `exchange_rate` decimal(12,5) NOT NULL,
  `exchange_api` tinyint(1) NOT NULL,
  `base` tinyint(1) NOT NULL,
  `decimal_places` tinyint(1) NOT NULL,
  `decimal_separator` varchar(1) NOT NULL DEFAULT '.',
  `locale_code` varchar(8) NOT NULL,
  `format` varchar(10) DEFAULT NULL,
  `symbol` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `custom_fields` (
  `id` int NOT NULL AUTO_INCREMENT,
  `display` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` tinyint NOT NULL COMMENT '0=text, 1=textarea, 2=checkbox, 3=radio, 4=select, 5=selectmultiple, 6=button',
  `required` tinyint(1) NOT NULL DEFAULT '1',
  `rank` int NOT NULL,
  `cssclass` varchar(100) NOT NULL,
  `options` text NOT NULL,
  `specs` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=181 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `custom_forms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `custom_forms_sections` (
  `id` int NOT NULL AUTO_INCREMENT,
  `form_id` int NOT NULL,
  `title` varchar(155) NOT NULL,
  `rank` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `form_id` (`form_id`)
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `custom_forms_sections_fields` (
  `section_id` int NOT NULL,
  `field_id` int NOT NULL,
  `required` tinyint(1) NOT NULL,
  `rank` int NOT NULL,
  `new_row` tinyint(1) NOT NULL,
  KEY `section_id` (`section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `custom_forms_show` (
  `form_id` int NOT NULL,
  `show_on` tinyint NOT NULL COMMENT '0=checkout, 1=product details',
  `show_for` tinyint NOT NULL COMMENT '0=all, 1=product types, 2=product id',
  `show_count` tinyint NOT NULL COMMENT '0=once, 1=per product, 2=per product qty, 3=per type in cart',
  `rank` int NOT NULL,
  KEY `form_id` (`form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `custom_forms_show_products` (
  `form_id` int NOT NULL,
  `product_id` int NOT NULL,
  `rank` int NOT NULL,
  KEY `form_id` (`form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `custom_forms_show_producttypes` (
  `form_id` int NOT NULL,
  `product_type_id` int NOT NULL,
  KEY `form_id` (`form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `discount` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `display` varchar(85) NOT NULL,
  `start_date` datetime NOT NULL,
  `exp_date` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `limit_per_order` int NOT NULL DEFAULT '1',
  `match_anyall` tinyint(1) NOT NULL COMMENT '0=all, 1=any',
  `random_generated` varchar(20) NOT NULL,
  `limit_uses` int NOT NULL,
  `limit_per_customer` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18022 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `discount_advantage` (
  `id` int NOT NULL AUTO_INCREMENT,
  `discount_id` int NOT NULL,
  `advantage_type_id` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `apply_shipping_id` int NOT NULL,
  `apply_shipping_country` int NOT NULL,
  `apply_shipping_distributor` int NOT NULL,
  `applyto_qty_type` tinyint(1) NOT NULL COMMENT '0=combined,1=individual',
  `applyto_qty_combined` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `discount_id` (`discount_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18178 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `discount_advantage_products` (
  `advantage_id` int NOT NULL,
  `product_id` int NOT NULL,
  `applyto_qty` int NOT NULL DEFAULT '1',
  KEY `advantage_id` (`advantage_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `discount_advantage_producttypes` (
  `advantage_id` int NOT NULL,
  `producttype_id` int NOT NULL,
  `applyto_qty` int NOT NULL,
  KEY `advantage_id` (`advantage_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `discount_advantage_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `discount_rule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `discount_id` int NOT NULL,
  `match_anyall` tinyint(1) NOT NULL COMMENT '0=all, 1=any',
  `rank` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `discount_id` (`discount_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18044 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `discount_rule_condition` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rule_id` int NOT NULL,
  `condition_type_id` int NOT NULL,
  `required_cart_value` decimal(10,2) NOT NULL,
  `required_code` varchar(25) NOT NULL,
  `required_qty_type` tinyint(1) NOT NULL,
  `required_qty_combined` int NOT NULL DEFAULT '1',
  `match_anyall` tinyint(1) NOT NULL,
  `rank` int NOT NULL DEFAULT '1',
  `equals_notequals` tinyint(1) NOT NULL,
  `use_with_rules_products` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18036 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `discount_rule_condition_accounttypes` (
  `condition_id` int NOT NULL,
  `accounttype_id` int NOT NULL,
  UNIQUE KEY `condition_id` (`condition_id`,`accounttype_id`),
  KEY `rule_id` (`condition_id`),
  KEY `accounttype_id` (`accounttype_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `discount_rule_condition_attributes` (
  `condition_id` int NOT NULL,
  `attributevalue_id` int NOT NULL,
  `required_qty` int NOT NULL DEFAULT '1',
  UNIQUE KEY `condition_id` (`condition_id`,`attributevalue_id`),
  KEY `rule_id` (`condition_id`),
  KEY `product_id` (`attributevalue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `discount_rule_condition_countries` (
  `condition_id` int NOT NULL,
  `country_id` int NOT NULL,
  UNIQUE KEY `condition_id` (`condition_id`,`country_id`),
  KEY `rule_id` (`condition_id`),
  KEY `site_id` (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `discount_rule_condition_distributors` (
  `condition_id` int NOT NULL,
  `distributor_id` int NOT NULL,
  UNIQUE KEY `condition_id` (`condition_id`,`distributor_id`),
  KEY `rule_id` (`condition_id`),
  KEY `site_id` (`distributor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `discount_rule_condition_membershiplevels` (
  `condition_id` int NOT NULL,
  `membershiplevel_id` int NOT NULL,
  UNIQUE KEY `condition_id` (`condition_id`,`membershiplevel_id`),
  KEY `rule_id` (`condition_id`),
  KEY `product_id` (`membershiplevel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `discount_rule_condition_onsalestatuses` (
  `condition_id` int NOT NULL,
  `onsalestatus_id` tinyint(1) NOT NULL,
  `required_qty` int NOT NULL,
  UNIQUE KEY `condition_id` (`condition_id`,`onsalestatus_id`),
  KEY `rule_id` (`condition_id`),
  KEY `product_id` (`onsalestatus_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `discount_rule_condition_outofstockstatuses` (
  `condition_id` int NOT NULL,
  `outofstockstatus_id` int NOT NULL,
  `required_qty` int NOT NULL,
  UNIQUE KEY `condition_id` (`condition_id`,`outofstockstatus_id`),
  KEY `rule_id` (`condition_id`),
  KEY `product_id` (`outofstockstatus_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `discount_rule_condition_productavailabilities` (
  `condition_id` int NOT NULL,
  `availability_id` int NOT NULL,
  `required_qty` int NOT NULL,
  UNIQUE KEY `condition_id` (`condition_id`,`availability_id`),
  KEY `rule_id` (`condition_id`),
  KEY `product_id` (`availability_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `discount_rule_condition_products` (
  `condition_id` int NOT NULL,
  `product_id` int NOT NULL,
  `required_qty` int NOT NULL,
  UNIQUE KEY `condition_id` (`condition_id`,`product_id`),
  KEY `rule_id` (`condition_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `discount_rule_condition_producttypes` (
  `condition_id` int NOT NULL,
  `producttype_id` int NOT NULL,
  `required_qty` int NOT NULL,
  UNIQUE KEY `condition_id` (`condition_id`,`producttype_id`),
  KEY `rule_id` (`condition_id`),
  KEY `product_id` (`producttype_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `discount_rule_condition_sites` (
  `condition_id` int NOT NULL,
  `site_id` int NOT NULL,
  UNIQUE KEY `condition_id` (`condition_id`,`site_id`),
  KEY `rule_id` (`condition_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `discount_rule_condition_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `discounts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `display` varchar(85) NOT NULL,
  `start_date` datetime NOT NULL,
  `exp_date` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15880 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `discounts-levels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `apply_to` tinyint NOT NULL COMMENT '0=all products, 1=selected products, 2=not selected products',
  `action_type` tinyint(1) NOT NULL COMMENT '0=percentage, 1=site pricing',
  `action_percentage` decimal(5,2) NOT NULL,
  `action_sitepricing` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `discounts-levels_products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `discount_level_id` int NOT NULL,
  `product_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `discount_level_id` (`discount_level_id`,`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7613 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `discounts_advantages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `discount_id` int NOT NULL,
  `advantage_type_id` int NOT NULL,
  `flat_amount` decimal(10,2) NOT NULL,
  `percentage_amount` decimal(6,2) NOT NULL,
  `product_qty` int NOT NULL,
  `apply_shipping_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `discount_id` (`discount_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15884 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `discounts_advantages_products` (
  `advantage_id` int NOT NULL,
  `product_id` int NOT NULL,
  KEY `advantage_id` (`advantage_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `discounts_rules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `discount_id` int NOT NULL,
  `rule_type_id` int NOT NULL,
  `required_cart_value` decimal(10,2) NOT NULL,
  `required_product_qty` int NOT NULL,
  `required_code` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `discount_id` (`discount_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15894 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `discounts_rules_products` (
  `rule_id` int NOT NULL,
  `product_id` int NOT NULL,
  UNIQUE KEY `rule_id_2` (`rule_id`,`product_id`),
  KEY `rule_id` (`rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `display_layouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `file` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `display_sections` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(35) NOT NULL,
  `display` varchar(55) NOT NULL,
  `rank` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `display_templates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_id` int NOT NULL,
  `name` varchar(55) NOT NULL,
  `include` varchar(255) NOT NULL,
  `image_width` varchar(10) NOT NULL,
  `image_height` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `display_templates_index_1` (`include`,`image_width`,`image_height`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `display_templates_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `display_themes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(35) NOT NULL,
  `folder` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `distributors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `email` varchar(85) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `account_no` varchar(35) NOT NULL,
  `is_dropshipper` tinyint(1) NOT NULL,
  `inventory_account_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `distributors_availabilities` (
  `id` int NOT NULL AUTO_INCREMENT,
  `distributor_id` int NOT NULL,
  `availability_id` int NOT NULL,
  `display` varchar(55) DEFAULT NULL,
  `qty_min` decimal(8,2) DEFAULT NULL,
  `qty_max` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `distavail` (`distributor_id`,`availability_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `distributors_canadapost` (
  `distributor_id` int NOT NULL,
  `username` varchar(55) NOT NULL,
  `customer_number` varchar(55) NOT NULL,
  `contract_id` varchar(35) NOT NULL,
  `password` varchar(35) NOT NULL,
  `company` varchar(55) NOT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state_id` int NOT NULL,
  `postal_code` varchar(55) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `country_id` int NOT NULL,
  `phone` varchar(15) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `email` varchar(65) NOT NULL,
  `package_type` varchar(30) NOT NULL,
  `default_weight` decimal(5,1) NOT NULL,
  `test` tinyint NOT NULL,
  `discount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `label_creation` tinyint(1) NOT NULL,
  `quote_type` tinyint(1) NOT NULL COMMENT '0=commerical, 1=counter',
  `promo_code` varchar(35) NOT NULL,
  PRIMARY KEY (`distributor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `distributors_endicia` (
  `distributor_id` int NOT NULL,
  `requester_id` varchar(55) NOT NULL,
  `account_id` varchar(55) NOT NULL,
  `pass_phrase` varchar(100) NOT NULL,
  `company` varchar(55) NOT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state_id` int NOT NULL,
  `postal_code` varchar(55) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `country_id` int NOT NULL,
  `phone` varchar(15) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `email` varchar(65) NOT NULL,
  `package_type` varchar(30) NOT NULL DEFAULT 'Parcel',
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
  PRIMARY KEY (`distributor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `distributors_fedex` (
  `distributor_id` int NOT NULL,
  `accountno` varchar(55) NOT NULL,
  `meterno` varchar(55) NOT NULL,
  `keyword` varchar(35) NOT NULL,
  `pass` varchar(35) NOT NULL,
  `company` varchar(55) NOT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state_id` int NOT NULL,
  `postal_code` varchar(55) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `country_id` int NOT NULL,
  `phone` varchar(15) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `email` varchar(65) NOT NULL,
  `package_type` varchar(30) NOT NULL,
  `default_weight` decimal(5,1) NOT NULL,
  `test` tinyint NOT NULL,
  `discount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `label_creation` tinyint(1) NOT NULL,
  `rate_type` tinyint(1) NOT NULL COMMENT '0=account, 1=list',
  PRIMARY KEY (`distributor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `distributors_genericshipping` (
  `distributor_id` int NOT NULL,
  `company` varchar(55) NOT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state_id` int NOT NULL,
  `postal_code` varchar(55) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `country_id` int NOT NULL,
  `phone` varchar(15) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `email` varchar(65) NOT NULL,
  PRIMARY KEY (`distributor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `distributors_shipping_flatrates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `distributor_shippingmethod_id` int NOT NULL,
  `start_weight` decimal(8,2) NOT NULL,
  `end_weight` decimal(8,2) NOT NULL,
  `shipto_country` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  `flat_price` decimal(8,2) NOT NULL,
  `handling_fee` decimal(8,2) NOT NULL,
  `call_for_estimate` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `distributor_id` (`distributor_shippingmethod_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `distributors_shipping_gateways` (
  `id` int NOT NULL AUTO_INCREMENT,
  `distributor_id` int NOT NULL,
  `shipping_gateway_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `distship` (`distributor_id`,`shipping_gateway_id`),
  KEY `distributor_id` (`distributor_id`,`shipping_gateway_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `distributors_shipping_methods` (
  `id` int NOT NULL AUTO_INCREMENT,
  `distributor_id` int NOT NULL,
  `shipping_method_id` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  `flat_price` decimal(8,2) NOT NULL,
  `flat_use` tinyint(1) NOT NULL,
  `handling_fee` decimal(8,2) NOT NULL,
  `handling_percentage` decimal(8,2) NOT NULL,
  `call_for_estimate` tinyint(1) NOT NULL,
  `discount_rate` decimal(8,2) NOT NULL,
  `display` varchar(255) DEFAULT NULL,
  `override_is_international` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `distributor_id` (`distributor_id`,`shipping_method_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `distributors_shipstation` (
  `distributor_id` int NOT NULL,
  `api_key` varchar(55) NOT NULL,
  `api_secret` varchar(55) NOT NULL,
  `company` varchar(55) NOT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state_id` int NOT NULL,
  `postal_code` varchar(55) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `country_id` int NOT NULL,
  `is_residential` tinyint(1) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `email` varchar(65) NOT NULL,
  `package_type` varchar(30) NOT NULL DEFAULT 'Parcel',
  `default_weight` decimal(5,1) NOT NULL,
  `test` tinyint NOT NULL,
  `discount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `label_creation` tinyint(1) NOT NULL,
  `delivery_confirmation` tinyint(1) NOT NULL,
  `insured_mail` tinyint(1) NOT NULL,
  `storeid` varchar(35) NOT NULL,
  `nondelivery` tinyint(1) NOT NULL,
  PRIMARY KEY (`distributor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `distributors_ups` (
  `distributor_id` int NOT NULL,
  `account_no` varchar(35) NOT NULL,
  `company` varchar(85) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(65) NOT NULL,
  `address_1` varchar(85) NOT NULL,
  `address_2` varchar(85) NOT NULL,
  `city` varchar(35) NOT NULL,
  `state_id` int NOT NULL,
  `postal_code` varchar(15) NOT NULL,
  `country_id` int NOT NULL,
  `license_number` varchar(35) NOT NULL,
  `user_id` varchar(35) NOT NULL,
  `password` varchar(35) NOT NULL,
  `label_creation` tinyint(1) NOT NULL,
  PRIMARY KEY (`distributor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `distributors_usps` (
  `distributor_id` int NOT NULL,
  `company` varchar(85) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(65) NOT NULL,
  `address_1` varchar(85) NOT NULL,
  `address_2` varchar(85) NOT NULL,
  `city` varchar(35) NOT NULL,
  `state_id` int NOT NULL,
  `postal_code` varchar(15) NOT NULL,
  `country_id` int NOT NULL,
  `user_id` varchar(35) NOT NULL,
  `password` varchar(35) NOT NULL,
  `label_creation` tinyint(1) NOT NULL,
  PRIMARY KEY (`distributor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `elements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(155) NOT NULL,
  `notes` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `sdate` datetime NOT NULL,
  `edate` datetime NOT NULL,
  `timezone` varchar(155) NOT NULL DEFAULT 'UTC',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `photo` int NOT NULL,
  `type` tinyint NOT NULL,
  `type_id` int NOT NULL,
  `city` varchar(35) NOT NULL,
  `state` varchar(2) NOT NULL,
  `country` varchar(2) NOT NULL,
  `webaddress` varchar(255) NOT NULL,
  `email` varchar(65) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `views` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `events_toattend` (
  `userid` int NOT NULL,
  `eventid` int NOT NULL,
  UNIQUE KEY `userid_2` (`userid`,`eventid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `events_types` (
  `id` tinyint NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `events_views` (
  `event_id` int NOT NULL,
  `account_id` int NOT NULL,
  `viewed_date` date NOT NULL,
  `viewed_time` time NOT NULL,
  KEY `event_id` (`event_id`,`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `faqs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `rank` int NOT NULL,
  `url` varchar(85) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `faqs-categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `rank` int NOT NULL,
  `url` varchar(85) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `faqs-categories_translations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categories_id` int NOT NULL,
  `language_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_id_2` (`categories_id`,`language_id`),
  KEY `language_id` (`language_id`),
  KEY `content_id` (`categories_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `faqs_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `faqs_id` int NOT NULL,
  `categories_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_id_2` (`faqs_id`,`categories_id`),
  KEY `categories_id` (`categories_id`),
  KEY `faqs_id` (`faqs_id`)
) ENGINE=InnoDB AUTO_INCREMENT=179 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `faqs_translations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `faqs_id` int NOT NULL,
  `language_id` int NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `content_id` (`faqs_id`,`language_id`),
  KEY `language_id` (`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `files` (
  `id` int NOT NULL AUTO_INCREMENT,
  `caption` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filetype` varchar(55) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=739 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `filters` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `label` varchar(55) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `rank` int NOT NULL,
  `show_in_search` tinyint(1) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '0=avail, 1=price, 2=attributes, 3=brands, 4=product types, 5=option values',
  `field_type` tinyint(1) NOT NULL COMMENT '0=select,1=checkboxes',
  `override_parent` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `filters_attributes` (
  `attribute_id` int NOT NULL,
  `filter_id` int NOT NULL,
  `label` varchar(55) NOT NULL,
  `rank` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  UNIQUE KEY `attribute_id` (`attribute_id`,`filter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `filters_availabilities` (
  `id` int NOT NULL AUTO_INCREMENT,
  `avail_ids` varchar(30) NOT NULL,
  `filter_id` int NOT NULL,
  `label` varchar(55) NOT NULL,
  `rank` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `filters_categories` (
  `filter_id` int NOT NULL,
  `category_id` int NOT NULL,
  UNIQUE KEY `filter_id` (`filter_id`,`category_id`),
  KEY `filter_id_2` (`filter_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `filters_pricing` (
  `id` int NOT NULL AUTO_INCREMENT,
  `filter_id` int NOT NULL,
  `label` varchar(55) NOT NULL,
  `rank` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  `price_min` decimal(8,2) DEFAULT NULL,
  `price_max` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `filter_id` (`filter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `filters_productoptions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `option_name` varchar(85) NOT NULL,
  `filter_id` int NOT NULL,
  `label` varchar(55) NOT NULL,
  `rank` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `optionfilter` (`option_name`,`filter_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `friend_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_id` int NOT NULL,
  `friend_id` int NOT NULL,
  `note` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userid` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3263 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `friend_requests_oldfitpro` (
  `userid` int NOT NULL,
  `friendid` int NOT NULL,
  `note` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `friends` (
  `account_id` int NOT NULL,
  `friend_id` int NOT NULL,
  `rank` int NOT NULL,
  `added` datetime NOT NULL,
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `friends_updates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `friend_id` int NOT NULL,
  `type` tinyint NOT NULL,
  `type_id` int NOT NULL,
  `num` int NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `friend_id` (`friend_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18229 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `friends_updates_types` (
  `id` tinyint NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `gift_cards` (
  `id` int NOT NULL AUTO_INCREMENT,
  `card_code` varchar(16) NOT NULL,
  `card_exp` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `account_id` int NOT NULL,
  `email` varchar(85) NOT NULL,
  `site_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `card_code` (`card_code`,`card_exp`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `gift_cards_transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `giftcard_id` int NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `action` tinyint(1) NOT NULL COMMENT '0=credit,1=debit',
  `notes` varchar(85) NOT NULL,
  `admin_user_id` int NOT NULL,
  `order_id` int NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `giftcard_id` (`giftcard_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `giftregistry` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_id` int NOT NULL,
  `registry_name` varchar(100) NOT NULL,
  `registry_type` tinyint NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `event_date` datetime NOT NULL,
  `public_private` tinyint(1) NOT NULL,
  `private_key` varchar(55) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `shipto_id` int NOT NULL,
  `notes_to_friends` text NOT NULL,
  `registrant_name` varchar(155) NOT NULL,
  `coregistrant_name` varchar(155) NOT NULL,
  `baby_duedate` date NOT NULL,
  `baby_gender` tinyint(1) NOT NULL COMMENT '0=male;1=female',
  `baby_name` char(85) NOT NULL,
  `baby_firstchild` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  FULLTEXT KEY `registry_name` (`registry_name`),
  FULLTEXT KEY `event_name` (`event_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `giftregistry_genders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `giftregistry_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `registry_id` int NOT NULL,
  `product_id` int NOT NULL,
  `parent_product` int NOT NULL,
  `added` datetime NOT NULL,
  `qty_wanted` decimal(8,2) NOT NULL,
  `qty_purchased` decimal(8,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `registry_id` (`registry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `giftregistry_items_purchased` (
  `registry_item_id` int NOT NULL,
  `account_id` int NOT NULL,
  `qty_purchased` decimal(8,2) NOT NULL,
  `order_id` int NOT NULL,
  `order_product_id` int NOT NULL,
  KEY `registry_id` (`registry_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `giftregistry_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `group_bulletins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `group_id` int NOT NULL,
  `subject` varchar(155) NOT NULL,
  `body` text NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`,`createdby`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `group_requests` (
  `group_id` int NOT NULL,
  `user_id` int NOT NULL,
  `note` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  KEY `group_id` (`group_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `group_updates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `group_id` int NOT NULL,
  `type` tinyint NOT NULL,
  `type_id` int NOT NULL,
  `updated` datetime NOT NULL,
  `friend_id` int NOT NULL,
  `num` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `group_users` (
  `group_id` int NOT NULL,
  `user_id` int NOT NULL,
  `joined` datetime NOT NULL,
  `admin` tinyint(1) NOT NULL,
  KEY `group_id` (`group_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `group_views` (
  `group_id` int NOT NULL,
  `account_id` int NOT NULL,
  `viewed_date` date NOT NULL,
  `viewed_time` time NOT NULL,
  KEY `group_id` (`group_id`,`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `groups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `admin_user` int NOT NULL,
  `description` varchar(255) NOT NULL,
  `photo` int NOT NULL,
  `views` int NOT NULL,
  `featured` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `help_pops` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(155) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `filename` varchar(155) NOT NULL,
  `default_caption` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `inventory_image_id` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `images_index_1` (`id`,`filename`),
  FULLTEXT KEY `filename` (`filename`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2402 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `images_sizes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `width` int NOT NULL,
  `height` int NOT NULL,
  `crop` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `instructors` (
  `account_id` int NOT NULL AUTO_INCREMENT,
  `biography` text NOT NULL,
  `cert` varchar(255) NOT NULL DEFAULT '',
  `certby` text NOT NULL,
  `proexp` text NOT NULL,
  `ref1` varchar(50) NOT NULL DEFAULT '',
  `ref1_phone` varchar(20) NOT NULL DEFAULT '',
  `ref2` varchar(50) NOT NULL DEFAULT '',
  `ref2_phone` varchar(20) NOT NULL DEFAULT '',
  `level` tinyint NOT NULL,
  `businessname` varchar(55) NOT NULL,
  `employersname` varchar(55) NOT NULL,
  `website_1` varchar(55) NOT NULL,
  `website_2` varchar(55) NOT NULL,
  `cert_1_num` varchar(35) NOT NULL,
  `cert_1_exp` date NOT NULL,
  `cert_2_num` varchar(35) NOT NULL,
  `cert_2_exp` date NOT NULL,
  `cert_3_num` varchar(35) NOT NULL,
  `cert_3_exp` date NOT NULL,
  `other_cert` text NOT NULL,
  `gender` varchar(1) NOT NULL,
  `dob` date NOT NULL,
  `ref3` varchar(55) NOT NULL,
  `ref3_phone` varchar(15) NOT NULL,
  `ref3_email` varchar(65) NOT NULL,
  `ref2_email` varchar(65) NOT NULL,
  `ref1_email` varchar(65) NOT NULL,
  `secondary_email` varchar(65) NOT NULL,
  `cell_phone` varchar(15) NOT NULL,
  `ref1_relation` varchar(55) NOT NULL,
  `ref2_relation` varchar(55) NOT NULL,
  `ref3_relation` varchar(55) NOT NULL,
  `cert_1_org` varchar(55) NOT NULL,
  `cert_1_type` varchar(55) NOT NULL,
  `cert_2_org` varchar(55) NOT NULL,
  `cert_2_type` varchar(55) NOT NULL,
  `cert_3_org` varchar(55) NOT NULL,
  `cert_3_type` varchar(55) NOT NULL,
  `views` int NOT NULL,
  `address` varchar(100) NOT NULL,
  `address_2` varchar(100) NOT NULL,
  `city` varchar(35) NOT NULL,
  `state_id` int NOT NULL,
  `country_id` int NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `affiliate_account_id` int NOT NULL,
  `profile_public` tinyint(1) NOT NULL DEFAULT '1',
  `modified_by_pro` datetime NOT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31222 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `instructors_certfiles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `account_id` int NOT NULL,
  `upload_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6631 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE TABLE `inventory_gateways` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `class_name` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `loadproductsby` tinyint NOT NULL COMMENT '0=date, 1=id',
  `price_fields` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `inventory_gateways_accounts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `gateway_id` int NOT NULL,
  `name` varchar(55) NOT NULL,
  `user` varchar(55) NOT NULL,
  `password` varchar(85) NOT NULL,
  `url` varchar(255) NOT NULL,
  `transkey` varchar(500) NOT NULL,
  `last_load` datetime NOT NULL COMMENT 'Last time grabbed new products from gateway',
  `last_load_id` int NOT NULL,
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
  `regular_price_field` varchar(55) NOT NULL,
  `sale_price_field` varchar(55) NOT NULL,
  `onsale_formula` tinyint(1) NOT NULL COMMENT '0=none, 1=sale < reg',
  `use_taxinclusive_pricing` tinyint(1) NOT NULL,
  `custom_fields` text NOT NULL,
  `timezone` varchar(55) NOT NULL DEFAULT 'UTC',
  `payment_method` varchar(85) NOT NULL DEFAULT 'Web Credit Card|webpayment',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `refresh_token` varchar(85) NOT NULL,
  `use_parent_inventory_id` tinyint(1) NOT NULL,
  `distributor_id` int NOT NULL,
  `base_currency` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `distributor_id` (`distributor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `inventory_gateways_fields` (
  `id` int NOT NULL AUTO_INCREMENT,
  `gateway_id` int NOT NULL,
  `feed_field` varchar(100) NOT NULL,
  `product_field` varchar(100) NOT NULL,
  `displayorvalue` tinyint(1) NOT NULL COMMENT 'display or value of product field: 0=display, 1=value',
  PRIMARY KEY (`id`),
  KEY `gateway_id` (`gateway_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `inventory_gateways_orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `gateway_account_id` int NOT NULL,
  `gateway_order_id` varchar(55) NOT NULL,
  `shipment_id` int NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `shipment_id` (`shipment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `inventory_gateways_scheduledtasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `gateway_account_id` int NOT NULL,
  `task_type` tinyint NOT NULL COMMENT '1=update product prices, 2=update product inventory, 3=load new products',
  `task_start` int NOT NULL,
  `task_startdate` datetime NOT NULL,
  `task_status` tinyint(1) NOT NULL COMMENT '0=waiting, 1=processing',
  `task_modified` int NOT NULL,
  `task_custom_info` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gateway_account_id` (`gateway_account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `inventory_gateways_scheduledtasks_products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `task_id` int NOT NULL,
  `products_id` int NOT NULL,
  `products_distributors_id` int NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `task_id` (`task_id`),
  KEY `products_id` (`products_id`),
  KEY `products_distributors_id` (`products_distributors_id`),
  KEY `taskproductsdist` (`task_id`,`products_distributors_id`),
  KEY `taskproducts` (`task_id`,`products_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `inventory_gateways_sites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `gateway_account_id` int NOT NULL,
  `site_id` int NOT NULL,
  `update_pricing` tinyint(1) NOT NULL,
  `pricing_adjustment` decimal(8,2) NOT NULL,
  `update_status` tinyint(1) NOT NULL,
  `publish_on_import` tinyint(1) NOT NULL DEFAULT '1',
  `regular_price_field` varchar(55) NOT NULL,
  `sale_price_field` varchar(55) NOT NULL,
  `onsale_formula` tinyint(1) NOT NULL COMMENT '0=none, 1=sale < reg',
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `inventory_rules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `action` tinyint NOT NULL COMMENT '0=hide, 1=change availability',
  `min_stock_qty` int DEFAULT NULL,
  `max_stock_qty` int DEFAULT NULL,
  `availabity_changeto` int NOT NULL,
  `label` varchar(55) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `availabity_changeto` (`availabity_changeto`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `languages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(35) NOT NULL,
  `code` varchar(8) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `languages_content` (
  `id` int NOT NULL AUTO_INCREMENT,
  `msgid` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `msgid` (`msgid`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `languages_translations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content_id` int NOT NULL,
  `language_id` int NOT NULL,
  `msgstr` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_id_2` (`content_id`,`language_id`),
  KEY `language_id` (`language_id`),
  KEY `content_id` (`content_id`)
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `loyaltypoints` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(85) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `active_level_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `loyaltypoints_levels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `loyaltypoints_id` int NOT NULL,
  `points_per_dollar` tinyint NOT NULL DEFAULT '1',
  `value_per_point` decimal(5,2) NOT NULL DEFAULT '0.01',
  PRIMARY KEY (`id`),
  KEY `loyaltypoints_id` (`loyaltypoints_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `menu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent` int NOT NULL,
  `name` varchar(55) NOT NULL,
  `url` varchar(65) NOT NULL,
  `rank` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=224 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `menus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(35) NOT NULL,
  `url_name` varchar(55) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `menus-links` (
  `id` int NOT NULL AUTO_INCREMENT,
  `link_type` tinyint(1) NOT NULL COMMENT '1=url, 2=system, 3=javascript',
  `label` varchar(155) NOT NULL,
  `target` enum('_blank','_self','_parent','_top') NOT NULL,
  `url_link` text NOT NULL,
  `system_link` int NOT NULL COMMENT '1=home, 2=contact, 3=myaccount, 4=cart, 5=checkout, 6=wishlist',
  `javascript_link` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `menus_catalogcategories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `menu_id` int NOT NULL,
  `category_id` int NOT NULL,
  `rank` int NOT NULL,
  `submenu_levels` tinyint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `menus_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `menu_id` int NOT NULL,
  `category_id` int NOT NULL,
  `rank` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `menus_links` (
  `id` int NOT NULL AUTO_INCREMENT,
  `menu_id` int NOT NULL,
  `links_id` int NOT NULL,
  `rank` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `menus_menus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `menu_id` int NOT NULL,
  `child_menu_id` int NOT NULL,
  `rank` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `menus_pages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `menu_id` int NOT NULL,
  `page_id` int NOT NULL,
  `rank` int NOT NULL,
  `target` enum('_blank','_self','_parent','_top') NOT NULL DEFAULT '_self',
  `sub_pagemenu_id` int NOT NULL,
  `sub_categorymenu_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `menus_sites` (
  `menu_id` int NOT NULL,
  `site_id` int NOT NULL,
  `rank` int NOT NULL,
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `message_templates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `alt_body` text NOT NULL,
  `html_body` text NOT NULL,
  `note` varchar(255) NOT NULL,
  `system_id` varchar(85) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `system_id` (`system_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=214 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `message_templates_new` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `alt_body` text NOT NULL,
  `html_body` text NOT NULL,
  `note` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=431 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `mods_account_ads` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `link` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `img` varchar(155) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `clicks` int NOT NULL,
  `shown` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE TABLE `mods_account_ads_campaigns` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lastshown_ad` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE TABLE `mods_account_ads_clicks` (
  `ad_id` int NOT NULL,
  `clicked` datetime NOT NULL,
  KEY `ad_id` (`ad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE TABLE `mods_account_certifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_id` int NOT NULL,
  `cert_num` varchar(35) NOT NULL,
  `cert_exp` date DEFAULT NULL,
  `cert_type` varchar(55) NOT NULL,
  `cert_org` varchar(55) NOT NULL,
  `approval_status` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `file_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `approval_status` (`approval_status`),
  KEY `account_id_2` (`account_id`,`approval_status`)
) ENGINE=InnoDB AUTO_INCREMENT=33120 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `mods_account_certifications_files` (
  `id` int NOT NULL AUTO_INCREMENT,
  `certification_id` int NOT NULL,
  `filename` varchar(85) NOT NULL,
  `uploaded` datetime NOT NULL,
  `approval_status` tinyint(1) NOT NULL,
  `site_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `certification_id` (`certification_id`,`approval_status`),
  KEY `certification_id_2` (`certification_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22219 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `mods_account_files` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_id` int NOT NULL,
  `filename` varchar(85) NOT NULL,
  `uploaded` datetime NOT NULL,
  `site_id` int NOT NULL,
  `approval_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=352 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `mods_dates_auto_orderrules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `mods_dates_auto_orderrules_action` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dao_id` int NOT NULL,
  `criteria_startdatewithindays` int NOT NULL,
  `criteria_orderingruleid` int DEFAULT NULL,
  `criteria_siteid` int DEFAULT NULL,
  `changeto_orderingruleid` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `dao_id` (`dao_id`)
) ENGINE=InnoDB AUTO_INCREMENT=212 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `mods_dates_auto_orderrules_excludes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dao_id` int NOT NULL,
  `product_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_dao` (`product_id`,`dao_id`)
) ENGINE=InnoDB AUTO_INCREMENT=336 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `mods_dates_auto_orderrules_products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dao_id` int NOT NULL,
  `product_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_dao` (`product_id`,`dao_id`)
) ENGINE=InnoDB AUTO_INCREMENT=932 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `mods_lookbooks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(155) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `config_id` varchar(55) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `default_status` tinyint(1) NOT NULL,
  `header_text` text NOT NULL,
  `footer_text` text NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_desc` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `galleries_thumbnail` int NOT NULL,
  `plugin_type` enum('tn3','cycle2') NOT NULL DEFAULT 'tn3',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `mods_lookbooks_areas` (
  `lookbook_id` int NOT NULL,
  `area_id` int NOT NULL,
  `text` text NOT NULL,
  `use_static` tinyint NOT NULL,
  `timing` decimal(4,1) NOT NULL DEFAULT '1.0',
  `show_thumbs` tinyint(1) NOT NULL DEFAULT '0',
  `show_arrows` tinyint(1) NOT NULL DEFAULT '0',
  KEY `lookbook_id` (`lookbook_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `mods_lookbooks_areas_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `temp_id` int NOT NULL,
  `lookbook_id` int NOT NULL,
  `area_id` int NOT NULL,
  `image_id` int NOT NULL,
  `link` varchar(155) NOT NULL,
  `timing` decimal(4,1) NOT NULL DEFAULT '1.0',
  `static` tinyint(1) NOT NULL,
  `rank` tinyint NOT NULL,
  `width` int NOT NULL,
  `height` int NOT NULL,
  `content_title` text NOT NULL,
  `content_desc` text NOT NULL,
  `content_width` varchar(10) NOT NULL,
  `content_top` varchar(10) NOT NULL,
  `content_bottom` varchar(10) NOT NULL,
  `content_left` varchar(10) NOT NULL,
  `content_right` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lookbook_id` (`lookbook_id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `mods_lookbooks_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `link` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `mods_lookbooks_images_maps` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eimage_id` int NOT NULL,
  `shape` tinyint(1) NOT NULL,
  `coord` text NOT NULL,
  `href` varchar(255) NOT NULL,
  `target` tinyint NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `popup_position` tinyint(1) NOT NULL,
  `popup_offsetx` int NOT NULL,
  `popup_offsety` int NOT NULL,
  `popup_width` int NOT NULL DEFAULT '200',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `mods_resort_details` (
  `attribute_option_id` int NOT NULL,
  `description` text NOT NULL,
  `comments` text NOT NULL,
  `logo` varchar(255) NOT NULL DEFAULT '',
  `fax` varchar(20) NOT NULL DEFAULT '',
  `contact_addr` varchar(80) NOT NULL DEFAULT '',
  `contact_city` varchar(35) NOT NULL DEFAULT '',
  `contact_state_id` int NOT NULL,
  `contact_zip` varchar(20) NOT NULL DEFAULT '',
  `contact_country_id` int NOT NULL,
  `mgr_lname` varchar(35) NOT NULL DEFAULT '',
  `mgr_fname` varchar(35) NOT NULL DEFAULT '',
  `mgr_phone` varchar(20) NOT NULL DEFAULT '',
  `mgr_email` varchar(65) NOT NULL DEFAULT '',
  `mgr_fax` varchar(20) NOT NULL DEFAULT '',
  `notes` text NOT NULL,
  `transfer_info` text NOT NULL,
  `url_name` varchar(200) NOT NULL,
  `details` blob NOT NULL,
  `schedule_info` text NOT NULL,
  `suz_comments` text NOT NULL,
  `link_resort` varchar(255) NOT NULL,
  `concierge_name` varchar(65) NOT NULL,
  `concierge_email` varchar(85) NOT NULL,
  `facebook_fanpage` varchar(255) NOT NULL,
  `giftfund_info` text NOT NULL,
  `resort_type` tinyint(1) NOT NULL,
  `region_id` int NOT NULL,
  `airport_id` int NOT NULL,
  `fpt_manager_id` int DEFAULT NULL,
  `mobile_background_image` varchar(255) NOT NULL,
  `fee_entertainment` varchar(25) DEFAULT NULL,
  `fee_admin` varchar(25) DEFAULT NULL,
  `fee_gift` varchar(25) DEFAULT NULL,
  `fee_airtravel` varchar(25) DEFAULT NULL,
  `fee_transfers` varchar(25) DEFAULT NULL,
  `fee_companion` varchar(25) DEFAULT NULL,
  `fee_entertainment_toggle` tinyint(1) NOT NULL DEFAULT '1',
  `fee_total` varchar(155) DEFAULT NULL,
  PRIMARY KEY (`attribute_option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `mods_resort_details-amenities` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `mods_resort_details_amenities` (
  `id` int NOT NULL AUTO_INCREMENT,
  `resort_details_id` int NOT NULL,
  `amenity_id` int NOT NULL,
  `details` tinyint NOT NULL COMMENT '1=included, 2=addtl cost, 3=available, 4=not available, 5=other',
  PRIMARY KEY (`id`),
  UNIQUE KEY `resort_amenity` (`resort_details_id`,`amenity_id`),
  KEY `resort_id` (`resort_details_id`)
) ENGINE=InnoDB AUTO_INCREMENT=87228 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `mods_trip_flyers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `orders_products_id` int NOT NULL,
  `position` varchar(85) NOT NULL,
  `bio` text,
  `name` varchar(85) NOT NULL,
  `approval_status` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `photo_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_products_id` (`orders_products_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16100 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `mods_trip_flyers_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_id` int NOT NULL,
  `photo_id` int NOT NULL,
  `bio` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14509 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `modules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `file` varchar(155) NOT NULL,
  `config_values` text NOT NULL,
  `description` varchar(255) NOT NULL,
  `showinmenu` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `file` (`file`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `modules-templates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `parent_template_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `modules-templates_modules` (
  `template_id` int NOT NULL,
  `section_id` int NOT NULL,
  `module_id` int NOT NULL,
  `rank` tinyint NOT NULL,
  `temp_id` int NOT NULL,
  KEY `layout_id` (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `modules-templates_sections` (
  `template_id` int NOT NULL,
  `section_id` int NOT NULL,
  `temp_id` int NOT NULL,
  KEY `layout_id` (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `modules_admin_controllers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `module_id` int NOT NULL,
  `controller_section` varchar(155) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module_id` (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `modules_crons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `module_id` int NOT NULL,
  `type` tinyint(1) NOT NULL,
  `function` varchar(55) NOT NULL,
  `last_run` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `module_id` (`module_id`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `modules_crons_scheduledtasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `task_type` int NOT NULL COMMENT '1=update product prices, 2=update product inventory, 3=load new products',
  `task_start` int NOT NULL,
  `task_startdate` datetime NOT NULL,
  `task_remaining` int NOT NULL,
  `task_status` tinyint(1) NOT NULL COMMENT '0=waiting, 1=processing',
  `task_modified` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=171 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `modules_fields` (
  `id` int NOT NULL AUTO_INCREMENT,
  `module_id` int NOT NULL,
  `field_name` varchar(85) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module_id` (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `modules_site_controllers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `module_id` int NOT NULL,
  `controller_section` varchar(155) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `showinmenu` tinyint(1) NOT NULL,
  `menu_label` varchar(55) NOT NULL,
  `menu_link` varchar(85) NOT NULL,
  `url_name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module_id` (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `newsletters` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `description` text NOT NULL,
  `url_name` varchar(65) NOT NULL,
  `from_name` varchar(55) NOT NULL,
  `from_email` varchar(85) NOT NULL,
  `show_in_checkout` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `newsletters_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `newsletter_id` int NOT NULL,
  `subject` varchar(155) NOT NULL,
  `body` text NOT NULL,
  `sent` datetime NOT NULL,
  `subscribers_no` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `newsletter_id` (`newsletter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `newsletters_sites` (
  `newsletter_id` int NOT NULL,
  `site_id` int NOT NULL,
  KEY `newsletter_id` (`newsletter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `newsletters_subscribers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `newsletter_id` int NOT NULL,
  `name` varchar(85) NOT NULL,
  `email` varchar(85) NOT NULL,
  `joined` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `newsletter_id` (`newsletter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `options_templates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `options_templates_images` (
  `template_id` int NOT NULL,
  `image_id` int NOT NULL,
  KEY `template_id` (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `options_templates_options` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `display` varchar(100) NOT NULL,
  `type_id` int NOT NULL,
  `show_with_thumbnail` tinyint(1) NOT NULL,
  `rank` int NOT NULL,
  `required` tinyint(1) NOT NULL,
  `template_id` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `product_id` (`template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `options_templates_options_custom` (
  `value_id` int NOT NULL,
  `custom_type` tinyint(1) NOT NULL COMMENT '0=text, 1=textarea, 2=color',
  `custom_charlimit` int NOT NULL,
  `custom_label` varchar(35) NOT NULL,
  `custom_instruction` varchar(255) NOT NULL,
  UNIQUE KEY `value_id` (`value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `options_templates_options_values` (
  `id` int NOT NULL AUTO_INCREMENT,
  `option_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `display` varchar(100) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `rank` int NOT NULL,
  `image_id` int NOT NULL,
  `is_custom` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `option_id` (`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_no` varchar(20) NOT NULL,
  `account_id` int NOT NULL,
  `account_billing_id` int NOT NULL,
  `account_shipping_id` int NOT NULL,
  `order_phone` varchar(15) NOT NULL COMMENT 'only use if no account',
  `order_email` varchar(85) NOT NULL COMMENT 'only use if no account',
  `order_created` datetime NOT NULL,
  `payment_method` int NOT NULL,
  `payment_method_fee` decimal(8,4) DEFAULT NULL,
  `addtl_discount` decimal(10,2) NOT NULL,
  `addtl_fee` decimal(10,2) NOT NULL,
  `comments` text NOT NULL,
  `site_id` int NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0 = active, 1 = archived',
  `inventory_order_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `order_created` (`order_created`)
) ENGINE=InnoDB AUTO_INCREMENT=94371 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `orders-statuses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `rank` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `orders_activities` (
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `description` varchar(400) NOT NULL,
  `created` datetime NOT NULL,
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `orders_billing` (
  `order_id` int NOT NULL,
  `bill_company` varchar(85) NOT NULL,
  `bill_first_name` varchar(35) NOT NULL,
  `bill_last_name` varchar(35) NOT NULL,
  `bill_address_1` varchar(85) NOT NULL,
  `bill_address_2` varchar(85) NOT NULL,
  `bill_city` varchar(35) NOT NULL,
  `bill_state_id` int NOT NULL,
  `bill_country_id` int NOT NULL,
  `bill_postal_code` varchar(15) NOT NULL,
  `bill_phone` varchar(15) NOT NULL,
  `bill_email` varchar(85) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `orders_customforms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `form_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_type_id` int NOT NULL,
  `form_count` int NOT NULL,
  `form_values` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=50138 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `orders_discounts` (
  `order_id` int NOT NULL,
  `discount_id` int NOT NULL,
  `amount` varchar(12) NOT NULL,
  `advantage_id` int NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2098 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `orders_message_keys` (
  `key_id` varchar(55) NOT NULL,
  `key_var` varchar(55) NOT NULL,
  PRIMARY KEY (`key_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `orders_notes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `note` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29508 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `orders_packages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `shipment_id` int NOT NULL,
  `package_type` int NOT NULL,
  `package_size` int NOT NULL,
  `is_dryice` tinyint(1) NOT NULL,
  `dryice_weight` decimal(5,1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `shipment_id` (`shipment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=94583 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `orders_products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_qty` int NOT NULL,
  `product_price` decimal(8,2) NOT NULL,
  `product_notes` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `product_saleprice` decimal(8,2) NOT NULL,
  `product_onsale` tinyint(1) NOT NULL,
  `actual_product_id` int NOT NULL,
  `package_id` int NOT NULL,
  `parent_product_id` int NOT NULL COMMENT 'If accessory showing as option, id of product that this should show under',
  `cart_id` int NOT NULL COMMENT 'unique id in cart',
  `product_label` varchar(155) NOT NULL,
  `registry_item_id` int NOT NULL,
  `free_from_discount_advantage` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`,`product_id`,`package_id`),
  KEY `package_id` (`package_id`),
  KEY `actual_product_id` (`actual_product_id`),
  KEY `order_id_2` (`order_id`),
  KEY `product_id` (`product_id`),
  KEY `order_id_3` (`order_id`,`product_id`,`actual_product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=122284 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `orders_products_customfields` (
  `orders_products_id` int NOT NULL,
  `form_id` int NOT NULL,
  `section_id` int NOT NULL,
  `field_id` int NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`orders_products_id`),
  UNIQUE KEY `orders_products_id_2` (`orders_products_id`,`form_id`,`section_id`,`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `orders_products_customsinfo` (
  `orders_products_id` int NOT NULL,
  `customs_description` varchar(255) NOT NULL,
  `customs_weight` decimal(5,2) NOT NULL,
  `customs_value` decimal(8,2) NOT NULL,
  UNIQUE KEY `orders_products_id` (`orders_products_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `orders_products_discounts` (
  `orders_products_id` int NOT NULL,
  `discount_id` int NOT NULL,
  `advantage_id` int NOT NULL,
  `amount` varchar(12) NOT NULL,
  `qty` int NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `orders_products_id` (`orders_products_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7333 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `orders_products_oldfitpro` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_qty` int NOT NULL,
  `product_price` decimal(8,2) NOT NULL,
  `product_saleprice` decimal(8,2) NOT NULL,
  `product_onsale` tinyint(1) NOT NULL,
  `actual_product_id` int NOT NULL,
  `package_id` int NOT NULL,
  `parent_product_id` int NOT NULL COMMENT 'If accessory showing as option, id of product that this should show under',
  `date_id` int NOT NULL COMMENT 'if resort, id of date span selected',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`,`product_id`,`package_id`),
  KEY `package_id` (`package_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16689 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `orders_products_options` (
  `orders_products_id` int NOT NULL,
  `value_id` int NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `custom_value` text NOT NULL,
  KEY `orders_products_id` (`orders_products_id`),
  KEY `orders_products_id_2` (`orders_products_id`),
  KEY `orders_products_id_3` (`orders_products_id`),
  KEY `orders_products_id_4` (`orders_products_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `orders_products_sentemails` (
  `op_id` int NOT NULL,
  `email_id` int NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `email_id` (`email_id`),
  KEY `op_id` (`op_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE TABLE `orders_shipments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `distributor_id` int NOT NULL,
  `ship_method_id` int NOT NULL,
  `order_status_id` int NOT NULL DEFAULT '1',
  `ship_tracking_no` varchar(40) NOT NULL,
  `ship_cost` decimal(8,2) NOT NULL,
  `ship_date` datetime NOT NULL,
  `future_ship_date` datetime NOT NULL,
  `delivery_date` datetime NOT NULL,
  `signed_for_by` varchar(55) NOT NULL,
  `is_downloads` tinyint(1) NOT NULL,
  `last_status_update` datetime NOT NULL,
  `saturday_delivery` tinyint(1) NOT NULL,
  `alcohol` tinyint(1) NOT NULL,
  `dangerous_goods` tinyint(1) NOT NULL,
  `dangerous_goods_accessibility` tinyint(1) NOT NULL,
  `hold_at_location` tinyint(1) NOT NULL,
  `hold_at_location_address` varchar(250) NOT NULL,
  `signature_required` int NOT NULL,
  `cod` tinyint(1) NOT NULL,
  `cod_amount` decimal(10,2) NOT NULL,
  `cod_currency` int NOT NULL,
  `insured` tinyint(1) NOT NULL,
  `insured_value` decimal(10,2) NOT NULL,
  `archived` tinyint(1) NOT NULL COMMENT '0 = active, 1 = archived',
  `inventory_order_id` varchar(35) NOT NULL,
  `registry_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`,`ship_method_id`),
  KEY `distributor_id` (`distributor_id`),
  KEY `order_id_2` (`order_id`,`archived`),
  KEY `order_id_3` (`order_id`),
  KEY `archived` (`archived`),
  KEY `order_id_4` (`order_id`,`distributor_id`,`archived`),
  KEY `distributor_id_2` (`distributor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=94616 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `orders_shipments_labels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `shipment_id` int NOT NULL,
  `package_id` int NOT NULL,
  `filename` varchar(100) NOT NULL,
  `label_size_id` int NOT NULL,
  `gateway_label_id` varchar(55) NOT NULL,
  `tracking_no` varchar(65) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `filename` (`filename`),
  KEY `shipment_id` (`shipment_id`),
  KEY `package_id` (`package_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `orders_shipping` (
  `order_id` int NOT NULL,
  `ship_company` varchar(155) NOT NULL,
  `ship_first_name` varchar(35) NOT NULL,
  `ship_last_name` varchar(35) NOT NULL,
  `ship_address_1` varchar(85) NOT NULL,
  `ship_address_2` varchar(85) NOT NULL,
  `ship_city` varchar(35) NOT NULL,
  `ship_state_id` int NOT NULL,
  `ship_country_id` int NOT NULL,
  `ship_postal_code` varchar(15) NOT NULL,
  `ship_email` varchar(85) NOT NULL,
  `ship_phone` varchar(15) NOT NULL,
  `is_residential` tinyint(1) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `orders_tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `message` text NOT NULL,
  `priority` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `orders_transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `transaction_no` varchar(35) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `original_amount` decimal(10,2) NOT NULL,
  `cc_no` varchar(4) NOT NULL,
  `cc_exp` date NOT NULL,
  `notes` text NOT NULL,
  `status` tinyint NOT NULL COMMENT '1 = Authorized, 2 = Captured, 3 = Voided',
  `account_billing_id` int NOT NULL,
  `payment_method_id` int NOT NULL,
  `gateway_account_id` int NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `cim_payment_profile_id` int NOT NULL,
  `capture_on_shipment` int NOT NULL,
  `voided_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=56577 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `orders_transactions_billing` (
  `orders_transactions_id` int NOT NULL,
  `bill_first_name` varchar(35) NOT NULL,
  `bill_last_name` varchar(35) NOT NULL,
  `bill_address_1` varchar(85) NOT NULL,
  `bill_address_2` varchar(85) NOT NULL,
  `bill_city` varchar(35) NOT NULL,
  `bill_state_id` int NOT NULL,
  `bill_postal_code` varchar(15) NOT NULL,
  `bill_country_id` int NOT NULL,
  `bill_phone` varchar(15) NOT NULL,
  PRIMARY KEY (`orders_transactions_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `orders_transactions_credits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `orders_transactions_id` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `recorded` datetime NOT NULL,
  `transaction_id` varchar(35) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_transactions_id` (`orders_transactions_id`)
) ENGINE=InnoDB AUTO_INCREMENT=256 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `orders_transactions_statuses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(35) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `pages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `url_name` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `notes` varchar(100) NOT NULL,
  `meta_title` varchar(200) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keywords` varchar(500) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `pages-categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(35) NOT NULL,
  `url_name` varchar(55) NOT NULL,
  `parent_category_id` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `pages-categories_pages` (
  `category_id` int NOT NULL,
  `page_id` int NOT NULL,
  `rank` int NOT NULL,
  KEY `menu_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `pages-menus_catalogcategories` (
  `menu_id` int NOT NULL,
  `catalogcategory_id` int NOT NULL,
  `rank` int NOT NULL,
  KEY `menu_id` (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `pages-menus_categories` (
  `menu_id` int NOT NULL,
  `category_id` int NOT NULL,
  `rank` int NOT NULL,
  KEY `menu_id` (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `pages-menus_links` (
  `id` int NOT NULL AUTO_INCREMENT,
  `menu_id` int NOT NULL,
  `link_type` tinyint(1) NOT NULL COMMENT '1=url, 2=system, 3=javascript',
  `label` varchar(155) NOT NULL,
  `target` enum('_blank','_self','_parent','_top') NOT NULL,
  `url_link` text NOT NULL,
  `system_link` int NOT NULL COMMENT '1=home, 2=contact, 3=myaccount, 4=cart, 5=checkout, 6=wishlist',
  `javascript_link` text NOT NULL,
  `rank` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `pages_settings` (
  `page_id` int NOT NULL,
  `settings_template_id` int NOT NULL,
  `module_template_id` int NOT NULL,
  `layout_id` int NOT NULL,
  `module_custom_values` text NOT NULL,
  `module_override_values` text NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `pages_settings_sites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `page_id` int NOT NULL,
  `site_id` int NOT NULL,
  `settings_template_id` int DEFAULT NULL,
  `layout_id` int DEFAULT NULL,
  `module_template_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_id_2` (`page_id`,`site_id`),
  KEY `product_id` (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `pages_settings_sites_modulevalues` (
  `id` int NOT NULL AUTO_INCREMENT,
  `page_id` int NOT NULL,
  `site_id` int NOT NULL,
  `section_id` int NOT NULL,
  `module_id` int NOT NULL,
  `field_id` int NOT NULL,
  `custom_value` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_id_3` (`page_id`,`site_id`,`section_id`,`module_id`,`field_id`),
  KEY `product_id` (`page_id`),
  KEY `product_id_2` (`page_id`,`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=288 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `pages_settings_templates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `layout_id` int DEFAULT NULL,
  `module_template_id` int DEFAULT NULL,
  `settings_template_id` int DEFAULT NULL,
  `module_custom_values` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `pages_settings_templates_modulevalues` (
  `id` int NOT NULL AUTO_INCREMENT,
  `settings_template_id` int NOT NULL,
  `section_id` int NOT NULL,
  `module_id` int NOT NULL,
  `field_id` int NOT NULL,
  `custom_value` text,
  PRIMARY KEY (`id`),
  KEY `settings_template_id` (`settings_template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `payment_gateways` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `template` varchar(30) NOT NULL,
  `is_creditcard` tinyint(1) NOT NULL DEFAULT '1',
  `classname` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `payment_gateways_accounts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `gateway_id` int NOT NULL,
  `name` varchar(55) NOT NULL,
  `login_id` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `transaction_key` varchar(255) NOT NULL,
  `use_cvv` tinyint(1) NOT NULL,
  `currency_code` varchar(4) NOT NULL,
  `use_test` tinyint(1) NOT NULL,
  `custom_fields` text NOT NULL,
  `limitby_country` tinyint(1) NOT NULL COMMENT '0=no,1=billing,2=shipping,3=billing not,4=shipping not',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `payment_gateways_accounts_limitcountries` (
  `id` int NOT NULL AUTO_INCREMENT,
  `gateway_account_id` int NOT NULL,
  `country_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gateway_account_id` (`gateway_account_id`,`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `payment_gateways_errors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `response` text NOT NULL,
  `gateway_account_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `payment_methods` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `display` varchar(55) NOT NULL,
  `gateway_id` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  `template` varchar(55) DEFAULT NULL,
  `limitby_country` tinyint(1) NOT NULL COMMENT '0=no,1=billing,2=shipping,3=billing not,4=shipping not',
  `feeby_country` tinyint(1) NOT NULL COMMENT '0=billing, 1=shipping',
  `supports_auto_renewal` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `payment_methods_limitcountries` (
  `id` int NOT NULL AUTO_INCREMENT,
  `payment_method_id` int NOT NULL,
  `country_id` int NOT NULL,
  `fee` decimal(8,4) DEFAULT NULL,
  `limiting` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payment_method_id` (`payment_method_id`,`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `paypal_subscriptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `gateway_account_id` int NOT NULL,
  `paypal_subscription_id` varchar(85) NOT NULL,
  `approval_link` varchar(255) NOT NULL,
  `status` tinyint NOT NULL,
  `activated_at` timestamp NULL DEFAULT NULL,
  `order_no` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `photos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `added` datetime NOT NULL,
  `addedby` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `img` varchar(100) NOT NULL,
  `album` int NOT NULL,
  `approved` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `album` (`album`),
  KEY `addedby` (`addedby`)
) ENGINE=InnoDB AUTO_INCREMENT=95383 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `photos_albums` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `type` tinyint(1) NOT NULL,
  `type_id` int NOT NULL,
  `recent_photo_id` int NOT NULL,
  `updated` datetime NOT NULL,
  `photos_count` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28745 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `photos_albums_type` (
  `id` tinyint NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `photos_comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `photo_id` int NOT NULL,
  `body` text NOT NULL,
  `account_id` int NOT NULL,
  `created` datetime NOT NULL,
  `beenread` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `photo_id` (`photo_id`),
  KEY `read` (`beenread`)
) ENGINE=InnoDB AUTO_INCREMENT=498 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `photos_favorites` (
  `account_id` int NOT NULL,
  `photo_id` int NOT NULL,
  KEY `user_id` (`account_id`,`photo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `photos_sizes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `width` int NOT NULL,
  `height` int NOT NULL,
  `crop` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `pricing_rules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `pricing_rules_levels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rule_id` int NOT NULL,
  `min_qty` int NOT NULL,
  `max_qty` int NOT NULL,
  `amount_type` tinyint(1) NOT NULL COMMENT '0=percentage, 1=flat amount',
  `amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rule_id` (`rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent_product` int NOT NULL,
  `title` varchar(500) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `default_outofstockstatus_id` int DEFAULT NULL,
  `details_img_id` int NOT NULL,
  `category_img_id` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  `product_no` varchar(155) NOT NULL,
  `combined_stock_qty` decimal(8,2) NOT NULL,
  `default_cost` decimal(10,4) DEFAULT NULL,
  `weight` decimal(5,2) NOT NULL,
  `created` datetime NOT NULL,
  `default_distributor_id` int DEFAULT NULL,
  `fulfillment_rule_id` int DEFAULT NULL,
  `url_name` varchar(255) NOT NULL,
  `meta_title` varchar(155) NOT NULL,
  `meta_desc` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `inventory_id` varchar(155) NOT NULL,
  `customs_description` varchar(255) NOT NULL,
  `tariff_number` varchar(55) NOT NULL,
  `country_origin` varchar(20) NOT NULL,
  `inventoried` tinyint(1) NOT NULL DEFAULT '1',
  `shared_inventory_id` varchar(155) DEFAULT NULL,
  `addtocart_setting` enum('0','1','2') DEFAULT '0',
  `addtocart_external_label` varchar(255) DEFAULT NULL,
  `addtocart_external_link` varchar(255) DEFAULT NULL,
  `has_children` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url_name` (`url_name`),
  KEY `parent_product` (`parent_product`),
  KEY `inventory_id` (`inventory_id`),
  KEY `category_img_id` (`category_img_id`),
  KEY `status` (`status`),
  KEY `parent_product_2` (`parent_product`,`status`),
  KEY `fulfillment_rule_id` (`fulfillment_rule_id`),
  KEY `shared_inv` (`shared_inventory_id`),
  KEY `combined_stock_qty` (`combined_stock_qty`),
  KEY `has_children` (`has_children`),
  KEY `products_index_1` (`status`,`parent_product`,`has_children`,`inventoried`,`id`,`default_outofstockstatus_id`),
  KEY `shared_inventory_id` (`shared_inventory_id`),
  FULLTEXT KEY `title` (`title`),
  FULLTEXT KEY `subtitle` (`subtitle`),
  FULLTEXT KEY `product_no` (`product_no`),
  FULLTEXT KEY `meta_keywords` (`meta_keywords`),
  FULLTEXT KEY `titleurl` (`url_name`,`title`),
  FULLTEXT KEY `titleurlnosubtitle` (`url_name`,`title`,`product_no`,`subtitle`)
) ENGINE=InnoDB AUTO_INCREMENT=41526 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products-availability` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `display` varchar(55) DEFAULT NULL,
  `qty_min` decimal(8,2) DEFAULT NULL,
  `qty_max` decimal(8,2) DEFAULT NULL,
  `auto_adjust` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `products-availability_index_1` (`auto_adjust`,`id`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products-children_options` (
  `product_id` int NOT NULL,
  `option_id` int NOT NULL,
  UNIQUE KEY `product_id_2` (`product_id`,`option_id`),
  KEY `product_id` (`product_id`),
  KEY `option_id` (`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products-rules-fulfillment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(85) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `any_all` enum('any','all') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products-rules-fulfillment_conditions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rule_id` int NOT NULL,
  `type` enum('has_stock','logged_in','account_type','shipping_country','shipping_state','shipping_zipcode','stock_greaterthan_qtyordering','has_most_stock') NOT NULL,
  `status` tinyint(1) NOT NULL,
  `any_all` enum('all','any') NOT NULL,
  `target_distributor` int NOT NULL,
  `score` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rule_id` (`rule_id`),
  KEY `type` (`type`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products-rules-fulfillment_conditions_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `condition_id` int NOT NULL,
  `item_id` int NOT NULL,
  `value` varchar(85) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `condition_id` (`condition_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products-rules-fulfillment_distributors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rule_id` int NOT NULL,
  `distributor_id` int NOT NULL,
  `rank` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `parent_rule_id` (`rule_id`,`distributor_id`),
  KEY `rule_id` (`rule_id`),
  KEY `child_rule_id` (`distributor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products-rules-fulfillment_rules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent_rule_id` int NOT NULL,
  `child_rule_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `parent_rule_id` (`parent_rule_id`,`child_rule_id`),
  KEY `rule_id` (`parent_rule_id`),
  KEY `child_rule_id` (`child_rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products-rules-ordering` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(85) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `any_all` enum('any','all') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `products-rules-ordering_index_1` (`status`,`id`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=253 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products-rules-ordering_conditions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rule_id` int NOT NULL,
  `type` enum('required_account','required_account_type','required_account_specialty') NOT NULL,
  `status` tinyint(1) NOT NULL,
  `any_all` enum('all','any') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rule_id` (`rule_id`),
  KEY `type` (`type`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=165 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products-rules-ordering_conditions_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `condition_id` int NOT NULL,
  `item_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `condition_id` (`condition_id`)
) ENGINE=InnoDB AUTO_INCREMENT=469 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products-rules-ordering_rules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent_rule_id` int NOT NULL,
  `child_rule_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `parent_rule_id` (`parent_rule_id`,`child_rule_id`),
  KEY `rule_id` (`parent_rule_id`),
  KEY `child_rule_id` (`child_rule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=405 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products-types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products-types_attributes-sets` (
  `type_id` int NOT NULL,
  `set_id` int NOT NULL,
  KEY `type_id` (`type_id`,`set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_accessories` (
  `product_id` int NOT NULL,
  `accessory_id` int NOT NULL,
  `required` tinyint(1) NOT NULL,
  `show_as_option` tinyint(1) NOT NULL,
  `discount_percentage` tinyint NOT NULL,
  `description` varchar(255) NOT NULL,
  `link_actions` tinyint(1) NOT NULL,
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_accessories_fields` (
  `product_id` int NOT NULL,
  `accessories_fields_id` int NOT NULL,
  `rank` int NOT NULL,
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_attributes` (
  `product_id` int NOT NULL,
  `option_id` int NOT NULL,
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_details` (
  `product_id` int NOT NULL,
  `summary` text NOT NULL,
  `description` text NOT NULL,
  `attributes` text NOT NULL,
  `type_id` int NOT NULL,
  `brand_id` int NOT NULL,
  `rating` decimal(4,1) NOT NULL,
  `views_30days` int NOT NULL,
  `views_90days` int NOT NULL,
  `views_180days` int NOT NULL,
  `views_1year` int NOT NULL,
  `views_all` int NOT NULL,
  `orders_30days` int NOT NULL,
  `orders_90days` int NOT NULL,
  `orders_180days` int NOT NULL,
  `orders_1year` int NOT NULL,
  `orders_all` int NOT NULL,
  `downloadable` tinyint(1) NOT NULL,
  `downloadable_file` varchar(200) NOT NULL,
  `default_category_id` int NOT NULL,
  `orders_updated` datetime NOT NULL,
  `views_updated` datetime NOT NULL,
  `create_children_auto` tinyint(1) NOT NULL,
  `display_children_grid` tinyint(1) NOT NULL,
  `override_parent_description` tinyint(1) NOT NULL,
  `allow_pricing_discount` tinyint(1) NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `brand_id` (`brand_id`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_distributors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `distributor_id` int NOT NULL,
  `stock_qty` decimal(8,2) NOT NULL,
  `outofstockstatus_id` tinyint DEFAULT NULL,
  `cost` decimal(12,4) DEFAULT NULL,
  `inventory_id` varchar(155) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_id_2` (`product_id`,`distributor_id`,`inventory_id`),
  KEY `product_id` (`product_id`),
  KEY `proddist` (`product_id`,`distributor_id`),
  KEY `inventory_id` (`inventory_id`)
) ENGINE=InnoDB AUTO_INCREMENT=96366 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_images` (
  `product_id` int NOT NULL,
  `image_id` int NOT NULL,
  `caption` varchar(100) NOT NULL,
  `rank` tinyint NOT NULL,
  `show_in_gallery` tinyint(1) NOT NULL DEFAULT '1',
  UNIQUE KEY `prodimage` (`product_id`,`image_id`),
  KEY `product_id` (`product_id`),
  KEY `image_id` (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_log` (
  `product_id` int NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `productdistributor_id` int NOT NULL,
  `action_type` tinyint NOT NULL COMMENT '0=stock qty change',
  `changed_from` varchar(85) NOT NULL,
  `changed_to` varchar(85) NOT NULL,
  `logged` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `productdistributor_id` (`productdistributor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=156818 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_needschildren` (
  `product_id` int NOT NULL,
  `option_id` int NOT NULL,
  `qty` int NOT NULL,
  `account_level` text NOT NULL,
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_options` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `display` varchar(100) NOT NULL,
  `type_id` int NOT NULL,
  `show_with_thumbnail` tinyint(1) NOT NULL,
  `rank` int NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '1',
  `product_id` int NOT NULL,
  `is_template` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nametypeidstatus` (`name`,`type_id`,`product_id`,`status`),
  KEY `product_id` (`product_id`),
  KEY `products_options_index_1` (`status`,`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=744 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_options-types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_options_custom` (
  `value_id` int NOT NULL,
  `custom_type` tinyint(1) NOT NULL COMMENT '0=text, 1=textarea, 2=color',
  `custom_charlimit` int NOT NULL,
  `custom_label` varchar(35) NOT NULL,
  `custom_instruction` varchar(255) NOT NULL,
  UNIQUE KEY `value_id` (`value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_options_values` (
  `id` int NOT NULL AUTO_INCREMENT,
  `option_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `display` varchar(100) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `rank` int NOT NULL,
  `image_id` int NOT NULL,
  `is_custom` tinyint(1) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `option_id` (`option_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=46644 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_pricing` (
  `product_id` int NOT NULL,
  `site_id` int NOT NULL,
  `price_reg` decimal(10,4) NOT NULL,
  `price_sale` decimal(10,4) NOT NULL,
  `onsale` tinyint(1) NOT NULL,
  `min_qty` decimal(8,2) NOT NULL DEFAULT '1.00',
  `max_qty` decimal(8,2) NOT NULL DEFAULT '0.00',
  `feature` tinyint(1) NOT NULL,
  `pricing_rule_id` int NOT NULL,
  `ordering_rule_id` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  `published_date` datetime NOT NULL,
  UNIQUE KEY `prodsite` (`product_id`,`site_id`),
  KEY `status` (`status`),
  KEY `products_pricing_index_1` (`status`,`site_id`,`product_id`,`ordering_rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_pricing_temp` (
  `product_id` int NOT NULL,
  `site_id` int NOT NULL,
  `price_reg` decimal(8,2) NOT NULL,
  `price_sale` decimal(8,2) NOT NULL,
  `onsale` tinyint(1) NOT NULL,
  `min_qty` int NOT NULL DEFAULT '1',
  `max_qty` int NOT NULL DEFAULT '0',
  `feature` tinyint(1) NOT NULL,
  `pricing_rule_id` int NOT NULL,
  `ordering_rule_id` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  KEY `product_id` (`product_id`,`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_related` (
  `product_id` int NOT NULL,
  `related_id` int NOT NULL,
  KEY `product_id` (`product_id`),
  KEY `related_id` (`related_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_resort` (
  `product_id` int NOT NULL,
  `resort_id` int NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_resort_dates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `qty` int NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL,
  `product_id` int NOT NULL,
  `restrictedto_accountlevels` varchar(35) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=6473649 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_type` tinyint(1) NOT NULL,
  `item_id` int NOT NULL COMMENT 'product or attribute id',
  `name` varchar(85) NOT NULL,
  `comment` text NOT NULL,
  `created` datetime NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `approved` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`item_id`),
  KEY `item_type` (`item_type`,`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4270 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_reviews_oldfitpro` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `name` varchar(85) NOT NULL,
  `comment` text NOT NULL,
  `created` datetime NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2318 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_settings` (
  `product_id` int NOT NULL,
  `settings_template_id` int NOT NULL,
  `product_detail_template` int NOT NULL,
  `product_thumbnail_template` int NOT NULL,
  `product_zoom_template` int NOT NULL,
  `product_related_count` int NOT NULL,
  `product_brands_count` int NOT NULL,
  `product_related_template` int NOT NULL,
  `product_brands_template` int NOT NULL,
  `show_brands_products` tinyint(1) NOT NULL,
  `show_related_products` tinyint(1) NOT NULL,
  `show_specs` tinyint(1) NOT NULL,
  `show_reviews` tinyint(1) NOT NULL,
  `layout_id` int NOT NULL,
  `module_template_id` int NOT NULL,
  `module_custom_values` text NOT NULL,
  `module_override_values` text NOT NULL,
  `use_default_related` tinyint(1) NOT NULL,
  `use_default_brand` tinyint(1) NOT NULL,
  `use_default_specs` tinyint(1) NOT NULL,
  `use_default_reviews` tinyint(1) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_settings_sites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `site_id` int NOT NULL,
  `settings_template_id` int DEFAULT NULL,
  `product_detail_template` int DEFAULT NULL,
  `product_thumbnail_template` int DEFAULT NULL,
  `product_zoom_template` int DEFAULT NULL,
  `layout_id` int DEFAULT NULL,
  `module_template_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_id_2` (`product_id`,`site_id`),
  KEY `product_id` (`product_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=720 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_settings_sites_modulevalues` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `site_id` int NOT NULL,
  `section_id` int NOT NULL,
  `module_id` int NOT NULL,
  `field_id` int NOT NULL,
  `custom_value` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_id_3` (`product_id`,`site_id`,`section_id`,`module_id`,`field_id`),
  KEY `product_id` (`product_id`),
  KEY `product_id_2` (`product_id`,`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6621 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_settings_templates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `settings_template_id` int DEFAULT NULL,
  `product_detail_template` int DEFAULT NULL,
  `product_thumbnail_template` int DEFAULT NULL,
  `product_zoom_template` int DEFAULT NULL,
  `layout_id` int DEFAULT NULL,
  `module_template_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_settings_templates_modulevalues` (
  `id` int NOT NULL AUTO_INCREMENT,
  `settings_template_id` int NOT NULL,
  `section_id` int NOT NULL,
  `module_id` int NOT NULL,
  `field_id` int NOT NULL,
  `custom_value` text,
  PRIMARY KEY (`id`),
  KEY `settings_template_id` (`settings_template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_sorts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `orderby` varchar(55) NOT NULL,
  `sortby` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `rank` int NOT NULL,
  `isdefault` tinyint(1) NOT NULL,
  `display` varchar(55) DEFAULT NULL,
  `categories_only` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_specialties` (
  `product_id` int NOT NULL,
  `specialty_id` int NOT NULL,
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_specialties_check` (
  `product_id` int NOT NULL,
  `specialties` varchar(255) NOT NULL,
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_specialtiesaccountsrules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `accounts` varchar(255) NOT NULL,
  `specialties` varchar(255) NOT NULL,
  `rule_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `accounts` (`accounts`,`specialties`),
  KEY `product_id` (`accounts`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `message` text NOT NULL,
  `priority` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `products_viewed` (
  `product_id` int NOT NULL,
  `viewed` datetime NOT NULL,
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `reports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `created` datetime NOT NULL,
  `criteria` text NOT NULL,
  `type_id` tinyint NOT NULL,
  `ready` tinyint(1) NOT NULL,
  `from_date` datetime NOT NULL,
  `to_date` datetime NOT NULL,
  `breakdown` tinyint NOT NULL,
  `restart` int NOT NULL,
  `variables` text NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1462 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `reports_breakdowns` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `reports_products_fields` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `reference` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `reports_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `resorts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `comments` text NOT NULL,
  `logo` varchar(80) NOT NULL DEFAULT '',
  `airport_id` int NOT NULL,
  `fax` varchar(20) NOT NULL DEFAULT '',
  `contact_addr` varchar(80) NOT NULL DEFAULT '',
  `contact_city` varchar(35) NOT NULL DEFAULT '',
  `contact_state_id` int NOT NULL,
  `contact_zip` varchar(20) NOT NULL DEFAULT '',
  `contact_country_id` int NOT NULL,
  `mgr_lname` varchar(35) NOT NULL DEFAULT '',
  `mgr_fname` varchar(35) NOT NULL DEFAULT '',
  `mgr_phone` varchar(20) NOT NULL DEFAULT '',
  `mgr_email` varchar(65) NOT NULL DEFAULT '',
  `mgr_fax` varchar(20) NOT NULL DEFAULT '',
  `notes` text NOT NULL,
  `transfer_info` text NOT NULL,
  `url_name` varchar(200) NOT NULL,
  `details` blob NOT NULL,
  `schedule_info` text NOT NULL,
  `suz_comments` text NOT NULL,
  `link_resort` varchar(255) NOT NULL,
  `concierge_name` varchar(65) NOT NULL,
  `concierge_email` varchar(85) NOT NULL,
  `facebook_fanpage` varchar(255) NOT NULL,
  `giftfund_info` text NOT NULL,
  `resort_type` tinyint(1) NOT NULL,
  `group_id` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `user` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `region_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `resorts_amenities` (
  `resort_id` int NOT NULL,
  `amenity_id` int NOT NULL,
  `details` tinyint NOT NULL COMMENT '1=included, 2=addtl cost, 3=available, 4=not available, 5=other',
  KEY `resort_id` (`resort_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `saved_cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_id` int NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41097 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `saved_cart_discounts` (
  `saved_cart_id` int NOT NULL,
  `applied_codes_json` longtext NOT NULL,
  `shipping_discounts_json` longtext NOT NULL,
  `order_discounts_json` longtext NOT NULL,
  `product_discounts_json` longtext NOT NULL,
  PRIMARY KEY (`saved_cart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `saved_cart_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `saved_cart_id` int NOT NULL,
  `cart_id` int NOT NULL COMMENT 'cartitem_id to signify row',
  `product_id` int NOT NULL,
  `parent_product` int NOT NULL,
  `parent_cart_id` int NOT NULL,
  `required` int NOT NULL,
  `qty` int NOT NULL,
  `price_reg` decimal(8,2) NOT NULL,
  `price_sale` decimal(8,2) NOT NULL,
  `onsale` tinyint(1) NOT NULL,
  `product_label` varchar(155) NOT NULL,
  `registry_item_id` int NOT NULL,
  `accessory_field_id` int NOT NULL,
  `distributor_id` int NOT NULL,
  `accessory_link_actions` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `saved_cart_id` (`saved_cart_id`)
) ENGINE=InnoDB AUTO_INCREMENT=184788 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `saved_cart_items_customfields` (
  `saved_cart_item_id` int NOT NULL,
  `form_id` int NOT NULL,
  `section_id` int NOT NULL,
  `field_id` int NOT NULL,
  `value` text NOT NULL,
  UNIQUE KEY `saved_cart_item_id` (`saved_cart_item_id`,`form_id`,`section_id`,`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `saved_cart_items_options` (
  `saved_cart_item_id` int NOT NULL,
  `options_json` longtext NOT NULL,
  PRIMARY KEY (`saved_cart_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `saved_cart_items_options_customvalues` (
  `saved_cart_item_id` int NOT NULL,
  `option_id` int NOT NULL,
  `custom_value` text NOT NULL,
  UNIQUE KEY `cartitem_option` (`saved_cart_item_id`,`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `saved_order` (
  `id` int NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(20) NOT NULL,
  `account_id` int NOT NULL,
  `saved_cart_id` int NOT NULL,
  `created` datetime NOT NULL,
  `site_id` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `saved_cart_id` (`saved_cart_id`),
  KEY `unique_id` (`unique_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42031 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `saved_order_discounts` (
  `order_id` int NOT NULL,
  `discount_id` int NOT NULL,
  `discount_code` varchar(55) NOT NULL,
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `saved_order_information` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `order_email` varchar(85) NOT NULL,
  `account_billing_id` int NOT NULL,
  `account_shipping_id` int NOT NULL,
  `bill_first_name` varchar(35) NOT NULL,
  `bill_last_name` varchar(35) NOT NULL,
  `bill_address_1` varchar(85) NOT NULL,
  `bill_address_2` varchar(85) NOT NULL,
  `bill_city` varchar(35) NOT NULL,
  `bill_state_id` int NOT NULL,
  `bill_postal_code` varchar(15) NOT NULL,
  `bill_country_id` int NOT NULL,
  `bill_phone` varchar(15) NOT NULL,
  `is_residential` tinyint(1) NOT NULL,
  `ship_company` varchar(155) NOT NULL,
  `ship_first_name` varchar(35) NOT NULL,
  `ship_last_name` varchar(35) NOT NULL,
  `ship_address_1` varchar(85) NOT NULL,
  `ship_address_2` varchar(85) NOT NULL,
  `ship_city` varchar(35) NOT NULL,
  `ship_state_id` int NOT NULL,
  `ship_postal_code` varchar(15) NOT NULL,
  `ship_country_id` int NOT NULL,
  `ship_email` varchar(85) NOT NULL,
  `payment_method_id` int NOT NULL,
  `shipping_method_id` int NOT NULL,
  `step` tinyint NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42031 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `search_forms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `search_forms_fields` (
  `id` int NOT NULL AUTO_INCREMENT,
  `display` varchar(255) NOT NULL,
  `type` tinyint NOT NULL COMMENT '0=text, 1=textarea, 2=checkbox, 3=radio, 4=select, 5=selectmultiple, 6=button',
  `search_type` tinyint(1) NOT NULL COMMENT '0=attribute, 1=producttype, 2=membershiplevel',
  `search_id` int NOT NULL,
  `rank` int NOT NULL,
  `cssclass` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `help_element_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `search_forms_sections` (
  `id` int NOT NULL AUTO_INCREMENT,
  `form_id` int NOT NULL,
  `title` varchar(155) NOT NULL,
  `rank` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `form_id` (`form_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `search_forms_sections_fields` (
  `section_id` int NOT NULL,
  `field_id` int NOT NULL,
  `rank` int NOT NULL,
  `new_row` tinyint(1) NOT NULL,
  KEY `section_id` (`section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `search_history` (
  `keywords` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  KEY `keywords` (`keywords`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `shipping_carriers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `gateway_id` int NOT NULL,
  `name` varchar(35) NOT NULL,
  `classname` varchar(100) NOT NULL,
  `table` varchar(35) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `multipackage_support` tinyint(1) NOT NULL DEFAULT '1',
  `carrier_code` varchar(35) NOT NULL,
  `limit_shipto` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gateway_id` (`gateway_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `shipping_carriers_shipto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `shipping_carriers_id` int NOT NULL,
  `country_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `shipping_carriers_id_2` (`shipping_carriers_id`,`country_id`),
  KEY `shipping_carriers_id` (`shipping_carriers_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `shipping_gateways` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(35) NOT NULL,
  `classname` varchar(100) NOT NULL,
  `table` varchar(35) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `multipackage_support` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `shipping_label_sizes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `gateway_id` int NOT NULL,
  `carrier_code` varchar(55) NOT NULL,
  `default` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `label_template` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `shipping_label_templates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `filename` varchar(55) NOT NULL,
  `required_js` varchar(255) NOT NULL,
  `required_css` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `shipping_methods` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '',
  `display` varchar(155) NOT NULL,
  `refname` char(85) NOT NULL DEFAULT '',
  `carriercode` varchar(55) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `rank` tinyint NOT NULL DEFAULT '0',
  `ships_residential` tinyint(1) NOT NULL COMMENT '0 = ships both, 1= residential only, 2=commercial only',
  `carrier_id` int NOT NULL,
  `weight_limit` decimal(6,2) NOT NULL,
  `weight_min` decimal(6,2) NOT NULL,
  `is_international` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=656 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `shipping_package_sizes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nickname` varchar(30) NOT NULL,
  `length` int NOT NULL,
  `width` int NOT NULL,
  `height` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `shipping_package_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `carrier_id` tinyint NOT NULL,
  `carrier_reference` varchar(30) NOT NULL,
  `default` tinyint(1) NOT NULL,
  `is_international` tinyint NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`),
  KEY `carrier_id` (`carrier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `shipping_signature_options` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `carrier_id` tinyint(1) NOT NULL,
  `carrier_reference` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `sites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `domain` varchar(65) NOT NULL,
  `email` varchar(85) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `url` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `offline_message` text NOT NULL,
  `offline_key` int NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keywords` varchar(500) NOT NULL,
  `meta_desc` varchar(255) NOT NULL,
  `account_type_id` int NOT NULL,
  `require_login` tinyint(1) NOT NULL COMMENT '0=no, 1=for site, 2=for catalog',
  `required_account_types` varchar(100) NOT NULL,
  `version` varchar(25) NOT NULL,
  `template_set` varchar(55) NOT NULL DEFAULT 'basic',
  `theme_id` int NOT NULL,
  `apply_updates` tinyint(1) NOT NULL DEFAULT '1',
  `logo_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `sites_categories` (
  `site_id` int NOT NULL,
  `category_id` int NOT NULL,
  UNIQUE KEY `site_id_2` (`site_id`,`category_id`),
  KEY `site_id` (`site_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `sites_currencies` (
  `site_id` int NOT NULL,
  `currency_id` int NOT NULL,
  `rank` tinyint NOT NULL,
  UNIQUE KEY `sitecurr` (`site_id`,`currency_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `sites_datafeeds` (
  `site_id` int NOT NULL,
  `datafeed_id` int NOT NULL,
  `parent_children` tinyint(1) NOT NULL,
  `custom_info` text NOT NULL,
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `sites_inventory_rules` (
  `site_id` int NOT NULL,
  `rule_id` int NOT NULL,
  PRIMARY KEY (`site_id`),
  KEY `rule_id` (`rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `sites_languages` (
  `site_id` int NOT NULL,
  `language_id` int NOT NULL,
  `rank` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `sites_message_keys` (
  `key_id` varchar(55) NOT NULL,
  `key_var` varchar(55) NOT NULL,
  PRIMARY KEY (`key_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `sites_message_templates` (
  `site_id` int NOT NULL,
  `html` text NOT NULL,
  `alt` text NOT NULL,
  PRIMARY KEY (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `sites_packingslip` (
  `site_id` int NOT NULL,
  `packingslip_appendix_elementid` int NOT NULL,
  `packingslip_showlogo` tinyint(1) NOT NULL,
  PRIMARY KEY (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `sites_payment_methods` (
  `site_id` int NOT NULL,
  `payment_method_id` int NOT NULL,
  `gateway_account_id` int NOT NULL,
  `fee` decimal(8,4) DEFAULT NULL,
  UNIQUE KEY `sitepaygate` (`site_id`,`payment_method_id`,`gateway_account_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `sites_settings` (
  `site_id` int NOT NULL,
  `default_layout_id` int NOT NULL,
  `default_category_thumbnail_template` int NOT NULL,
  `default_product_thumbnail_template` int NOT NULL,
  `default_product_detail_template` int NOT NULL,
  `default_product_zoom_template` int NOT NULL,
  `default_feature_thumbnail_template` int NOT NULL,
  `default_feature_count` int NOT NULL,
  `default_product_thumbnail_count` int NOT NULL,
  `default_show_categories_in_body` tinyint(1) NOT NULL,
  `search_layout_id` int NOT NULL,
  `search_thumbnail_template` int NOT NULL,
  `search_thumbnail_count` int NOT NULL,
  `home_feature_count` int NOT NULL,
  `home_feature_thumbnail_template` int NOT NULL,
  `home_feature_show` tinyint(1) NOT NULL,
  `home_feature_showsort` tinyint(1) NOT NULL,
  `home_feature_showmessage` tinyint(1) NOT NULL,
  `home_show_categories_in_body` tinyint(1) NOT NULL,
  `home_layout_id` int NOT NULL,
  `default_product_related_count` int NOT NULL,
  `default_product_brands_count` int NOT NULL,
  `default_feature_showsort` tinyint(1) NOT NULL,
  `default_product_thumbnail_showsort` tinyint(1) NOT NULL,
  `default_product_thumbnail_showmessage` tinyint(1) NOT NULL,
  `default_feature_showmessage` tinyint(1) NOT NULL,
  `default_product_related_template` int NOT NULL,
  `default_product_brands_template` int NOT NULL,
  `require_customer_account` tinyint(1) NOT NULL,
  `default_category_layout_id` int NOT NULL,
  `default_product_layout_id` int NOT NULL,
  `account_layout_id` int NOT NULL,
  `cart_layout_id` int NOT NULL,
  `checkout_layout_id` int NOT NULL,
  `page_layout_id` int NOT NULL,
  `affiliate_layout_id` int NOT NULL,
  `wishlist_layout_id` int NOT NULL,
  `default_module_template_id` int NOT NULL,
  `default_module_custom_values` text NOT NULL,
  `default_category_module_template_id` int NOT NULL,
  `default_category_module_custom_values` text NOT NULL,
  `default_product_module_template_id` int NOT NULL,
  `default_product_module_custom_values` text NOT NULL,
  `home_module_template_id` int NOT NULL,
  `home_module_custom_values` text NOT NULL,
  `account_module_template_id` int NOT NULL,
  `account_module_custom_values` text NOT NULL,
  `search_module_template_id` int NOT NULL,
  `search_module_custom_values` text NOT NULL,
  `cart_module_template_id` int NOT NULL,
  `cart_module_custom_values` text NOT NULL,
  `checkout_module_template_id` int NOT NULL,
  `checkout_module_custom_values` text NOT NULL,
  `page_module_template_id` int NOT NULL,
  `page_module_custom_values` text NOT NULL,
  `affiliate_module_template_id` int NOT NULL,
  `affiliate_module_custom_values` text NOT NULL,
  `wishlist_module_template_id` int NOT NULL,
  `wishlist_module_custom_values` text NOT NULL,
  `catalog_layout_id` int NOT NULL,
  `catalog_module_template_id` int NOT NULL,
  `catalog_module_custom_values` text NOT NULL,
  `catalog_show_products` tinyint(1) NOT NULL,
  `catalog_feature_show` tinyint(1) NOT NULL,
  `catalog_show_categories_in_body` tinyint(1) NOT NULL,
  `catalog_feature_count` int NOT NULL,
  `catalog_feature_thumbnail_template` int NOT NULL,
  `catalog_feature_showsort` tinyint(1) NOT NULL,
  `catalog_feature_showmessage` tinyint(1) NOT NULL,
  `cart_addtoaction` tinyint(1) NOT NULL COMMENT '0=forward to cart, 1=show popup',
  `cart_orderonlyavailableqty` tinyint(1) NOT NULL,
  `checkout_process` tinyint(1) NOT NULL COMMENT '0=5step,1=singlepage',
  `offline_layout_id` int NOT NULL,
  `cart_allowavailability` varchar(100) NOT NULL DEFAULT 'any' COMMENT 'any, instock, lowstock, outofstock, onorder, discontinued',
  `filter_categories` tinyint(1) NOT NULL,
  `default_category_search_form_id` int NOT NULL,
  `recaptcha_key` varchar(55) NOT NULL,
  `recaptcha_secret` varchar(55) NOT NULL,
  PRIMARY KEY (`site_id`),
  KEY `sites_settings_index_1` (`site_id`,`default_product_thumbnail_template`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `sites_settings_modulevalues` (
  `id` int NOT NULL AUTO_INCREMENT,
  `section` enum('default','home','search','checkout','catalog','cart','product','category','page','wishlist','account','affiliate') NOT NULL,
  `site_id` int NOT NULL,
  `section_id` int NOT NULL,
  `module_id` int NOT NULL,
  `field_id` int NOT NULL,
  `custom_value` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `section` (`section`,`site_id`,`section_id`,`module_id`,`field_id`),
  KEY `product_id_2` (`section`,`site_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3913 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `sites_tax_rules` (
  `site_id` int NOT NULL,
  `tax_rule_id` int NOT NULL,
  UNIQUE KEY `id` (`site_id`,`tax_rule_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `sites_themes` (
  `site_id` int NOT NULL,
  `theme_id` int NOT NULL,
  `theme_values` text NOT NULL,
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `states` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(85) NOT NULL,
  `abbreviation` varchar(3) NOT NULL,
  `country_id` int NOT NULL,
  `tax_rate` decimal(3,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `system` (
  `id` int NOT NULL DEFAULT '1',
  `path` varchar(255) NOT NULL,
  `use_cim` tinyint(1) NOT NULL,
  `charge_action` tinyint NOT NULL DEFAULT '1' COMMENT '1 = auth & capture, 2 = auth only',
  `split_charges_by_shipment` tinyint(1) NOT NULL,
  `auto_archive_completed` tinyint(1) NOT NULL,
  `auto_archive_canceled` tinyint(1) NOT NULL,
  `use_fedex` tinyint(1) NOT NULL,
  `use_ups` tinyint(1) NOT NULL,
  `use_usps` tinyint(1) NOT NULL,
  `catalog_img_url` varchar(155) NOT NULL DEFAULT '//domain.com/',
  `system_admin_url` varchar(155) NOT NULL DEFAULT 'https://domain.com/admin/',
  `system_name` varchar(55) NOT NULL DEFAULT 'Advision Ecommerce',
  `version` varchar(20) NOT NULL DEFAULT '1.0.0',
  `version_updated` datetime NOT NULL,
  `master_account_pass` varchar(85) NOT NULL,
  `is_admin_secure` tinyint(1) NOT NULL,
  `system_admin_cookie` varchar(85) NOT NULL,
  `smtp_use` tinyint(1) NOT NULL,
  `smtp_host` varchar(85) NOT NULL,
  `smtp_auth` tinyint(1) NOT NULL,
  `smtp_secure` tinyint(1) NOT NULL,
  `smtp_port` varchar(6) NOT NULL,
  `smtp_username` varchar(85) NOT NULL,
  `smtp_password` varchar(55) NOT NULL,
  `cart_expiration` int NOT NULL DEFAULT '30' COMMENT 'number of days before cookie expires',
  `cart_removestatus` varchar(100) NOT NULL,
  `cart_updateprices` tinyint(1) NOT NULL DEFAULT '1',
  `cart_savediscounts` tinyint(1) NOT NULL DEFAULT '1',
  `feature_toggle` text NOT NULL,
  `check_for_shipped` tinyint(1) NOT NULL,
  `check_for_delivered` tinyint(1) NOT NULL,
  `orderplaced_defaultstatus` varchar(255) NOT NULL DEFAULT '{"default":1, "label":2, "download":1, "dropship":4, "unpaid":9}',
  `validate_addresses` varchar(20) NOT NULL COMMENT '0=no validation; >0=distributor.carrier_id to validate with',
  `giftcard_template_id` int NOT NULL,
  `giftcard_waccount_template_id` int NOT NULL,
  `packingslip_showinternalnotes` tinyint(1) NOT NULL,
  `packingslip_showavail` tinyint(1) NOT NULL,
  `packingslip_showshipmethod` tinyint(1) NOT NULL,
  `packingslip_showbillingaddress` tinyint(1) NOT NULL,
  `ordersummaryemail_showavail` tinyint(1) NOT NULL,
  `require_agreetoterms` tinyint(1) NOT NULL,
  `profile_description` text NOT NULL,
  `timezone` varchar(155) NOT NULL DEFAULT 'UTC',
  `addtocart_external_label` varchar(255) NOT NULL DEFAULT 'Order from Affiliate',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `system_alerts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reference_type` tinyint NOT NULL COMMENT '0 = other, 1 = order, 2 = transaction, 3 = shipment, 4 = package, 5 = account, 6 = product',
  `reference_id` int NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `been_read` tinyint(1) NOT NULL,
  `read_on` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `reference_type` (`reference_type`,`reference_id`),
  KEY `reference_id` (`reference_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `system_errors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent` int NOT NULL,
  `created` datetime NOT NULL,
  `error` text NOT NULL,
  `details` text NOT NULL,
  `moredetails` text NOT NULL,
  `type_id` int NOT NULL,
  `type` tinyint NOT NULL COMMENT '0 = general system error, 1 = inventory gateway error, 2 = order error, 3 = order shipment error, 4 = order package error',
  `type_subid` int NOT NULL,
  `been_read` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `system_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `data` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `system_messages` (
  `id` int NOT NULL,
  `message` varchar(500) NOT NULL,
  `posted` datetime NOT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `system_tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `site_id` int NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '0=download update',
  `type_info` varchar(255) NOT NULL COMMENT 'type = 0: download url',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `system_updates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `site_id` int NOT NULL,
  `version` varchar(25) NOT NULL,
  `type` tinyint NOT NULL COMMENT '0=download, 1=run update',
  `processing` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `tax_rules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `rate` decimal(8,2) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '0=all,1=location specific',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `tax_rules_locations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tax_rule_id` int NOT NULL,
  `name` varchar(55) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '0=country, 1=state/province, 2=zipcode',
  `country_id` int NOT NULL,
  `state_id` int NOT NULL,
  `zipcode` varchar(15) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tax_rule_id` (`tax_rule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `tax_rules_product-types` (
  `tax_rule_id` int NOT NULL,
  `type_id` int NOT NULL,
  UNIQUE KEY `id` (`tax_rule_id`,`type_id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `wishlists` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_id` int NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4178 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `wishlists_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `wishlist_id` int NOT NULL,
  `product_id` int NOT NULL,
  `parent_product` int NOT NULL,
  `added` datetime NOT NULL,
  `parent_wishlist_items_id` int NOT NULL,
  `is_accessory` tinyint(1) NOT NULL COMMENT '0=no,1=yes,2=as option',
  `accessory_required` tinyint(1) NOT NULL,
  `accessory_field_id` int NOT NULL,
  `notify_backinstock` tinyint(1) NOT NULL COMMENT '0=no, 1=yes, 2=notified',
  `notify_backinstock_attempted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wlprod_id` (`wishlist_id`,`product_id`),
  KEY `wishlist_id` (`wishlist_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7979 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `wishlists_items_customfields` (
  `id` int NOT NULL AUTO_INCREMENT,
  `wishlists_item_id` int NOT NULL,
  `form_id` int NOT NULL,
  `section_id` int NOT NULL,
  `field_id` int NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `saved_cart_item_id` (`wishlists_item_id`,`form_id`,`section_id`,`field_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2104 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `wishlists_items_options` (
  `wishlists_item_id` int NOT NULL,
  `options_json` longtext NOT NULL,
  PRIMARY KEY (`wishlists_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `wishlists_items_options_customvalues` (
  `id` int NOT NULL AUTO_INCREMENT,
  `wishlists_item_id` int NOT NULL,
  `option_id` int NOT NULL,
  `custom_value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `saved_cart_item_id` (`wishlists_item_id`,`option_id`),
  UNIQUE KEY `cartitem_option` (`wishlists_item_id`,`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
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
INSERT INTO `migrations` VALUES (418,'2019_12_15_015843_add_new_fields_to_resort_table',1);
INSERT INTO `migrations` VALUES (419,'2020_01_23_170902_add_fee_entertainment_toggle_to_resort_details_table',1);
INSERT INTO `migrations` VALUES (420,'2020_02_06_164301_add_fee_total_to_resort_details_table',1);
INSERT INTO `migrations` VALUES (421,'2020_03_21_032251_membership_tweaks',1);
INSERT INTO `migrations` VALUES (422,'2020_03_21_040954_create_paypal_subscriptions_table',1);
INSERT INTO `migrations` VALUES (423,'2020_03_25_230310_add_supports_auto_renewal_to_payment_methods',1);
INSERT INTO `migrations` VALUES (424,'2020_03_26_010949_increase_size_of_payment_account_fields',1);
INSERT INTO `migrations` VALUES (425,'2020_03_27_001617_update_paypal_subscription_id',1);
INSERT INTO `migrations` VALUES (426,'2020_03_28_222842_add_trial_flag_to_account_types',1);
INSERT INTO `migrations` VALUES (427,'2020_03_29_230758_increase_size_of_message_template_system_id_field',1);
INSERT INTO `migrations` VALUES (428,'2020_03_30_230413_add_auto_renew_reward_to_membership_levels',1);
