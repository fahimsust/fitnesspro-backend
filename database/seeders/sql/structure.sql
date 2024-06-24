-- MySQL dump 10.13  Distrib 5.7.32, for Linux (x86_64)
--
-- Host: localhost    Database: dev_fitpro2
-- ------------------------------------------------------
-- Server version	5.7.32-0ubuntu0.16.04.1

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
-- Table structure for table `accessories_fields`
--

/*DROP TABLE IF EXISTS `accessories_fields`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accessories_fields` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `label` varchar(100) NOT NULL,
  `field_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=select menu, 2=radio options, 3=checkboxes',
  `required` tinyint(1) NOT NULL,
  `select_display` varchar(65) NOT NULL COMMENT 'select menu default display before option is selected',
  `select_auto` tinyint(1) NOT NULL COMMENT 'should the first option be auto selected',
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accessories_fields_products`
--

/*DROP TABLE IF EXISTS `accessories_fields_products`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accessories_fields_products` (
  `accessories_fields_id` int(20) NOT NULL,
  `product_id` int(20) NOT NULL,
  `label` varchar(100) NOT NULL,
  `rank` int(3) NOT NULL,
  `price_adjust_type` tinyint(1) NOT NULL COMMENT '1=adjust this price, 2=adjust parent price',
  `price_adjust_calc` tinyint(1) NOT NULL COMMENT '1=flat amount, 2=percentage',
  `price_adjust_amount` decimal(8,2) NOT NULL,
  UNIQUE KEY `accessories_fields_id_2` (`accessories_fields_id`,`product_id`),
  KEY `accessories_fields_id` (`accessories_fields_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts-membership-attributes`
--

/*DROP TABLE IF EXISTS `accounts-membership-attributes`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts-membership-attributes` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `rank` int(5) NOT NULL,
  `details` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `section_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts-membership-attributes-sections`
--

/*DROP TABLE IF EXISTS `accounts-membership-attributes-sections`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts-membership-attributes-sections` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `rank` int(5) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts-membership-levels`
--

/*DROP TABLE IF EXISTS `accounts-membership-levels`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts-membership-levels` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `rank` int(5) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `annual_product_id` int(10) NOT NULL,
  `monthly_product_id` int(10) NOT NULL,
  `renewal_discount` decimal(5,2) NOT NULL,
  `description` text NOT NULL,
  `signupemail_customer` int(5) NOT NULL,
  `renewemail_customer` int(5) NOT NULL,
  `expirationalert1_email` int(5) NOT NULL,
  `expirationalert2_email` int(5) NOT NULL,
  `expiration_email` int(5) NOT NULL,
  `affiliate_level_id` int(5) NOT NULL,
  `is_default` tinyint(1) NOT NULL,
  `signuprenew_option` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts-membership-levels_attributes`
--

/*DROP TABLE IF EXISTS `accounts-membership-levels_attributes`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts-membership-levels_attributes` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `level_id` int(10) NOT NULL,
  `attribute_id` int(10) NOT NULL,
  `attribute_value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `level_id` (`level_id`,`attribute_id`)
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts-membership-levels_settings`
--

/*DROP TABLE IF EXISTS `accounts-membership-levels_settings`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts-membership-levels_settings` (
  `level_id` int(5) NOT NULL AUTO_INCREMENT,
  `badge` int(5) NOT NULL,
  `search_limit` int(5) NOT NULL,
  `event_limit` int(5) NOT NULL,
  `ad_limit` int(5) NOT NULL,
  PRIMARY KEY (`level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts-memberships_payment_methods`
--

/*DROP TABLE IF EXISTS `accounts-memberships_payment_methods`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts-memberships_payment_methods` (
  `site_id` int(5) NOT NULL,
  `payment_method_id` int(5) NOT NULL,
  `gateway_account_id` int(5) NOT NULL,
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts-specialties`
--

/*DROP TABLE IF EXISTS `accounts-specialties`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts-specialties` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `parent_id` int(5) DEFAULT NULL,
  `name` varchar(55) NOT NULL,
  `rank` int(5) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts-specialties_products`
--

/*DROP TABLE IF EXISTS `accounts-specialties_products`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts-specialties_products` (
  `specialty_id` int(5) NOT NULL,
  `product_id` int(10) NOT NULL,
  UNIQUE KEY `type_id` (`specialty_id`,`product_id`),
  KEY `product_id` (`product_id`),
  KEY `type_id_2` (`specialty_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts-statuses`
--

/*DROP TABLE IF EXISTS `accounts-statuses`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts-statuses` (
  `id` tinyint(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts-types`
--

/*DROP TABLE IF EXISTS `accounts-types`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts-types` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `default_account_status` tinyint(2) NOT NULL,
  `custom_form_id` int(5) NOT NULL,
  `email_template_id_creation_admin` int(5) NOT NULL,
  `email_template_id_creation_user` int(5) NOT NULL,
  `email_template_id_activate_user` int(5) NOT NULL,
  `discount_level_id` int(5) NOT NULL,
  `verify_user_email` tinyint(5) NOT NULL DEFAULT '0',
  `filter_products` tinyint(1) NOT NULL COMMENT '0=no, 1=show select, 2= hide selected',
  `filter_categories` tinyint(1) NOT NULL COMMENT '0=no, 1=show select, 2= hide selected',
  `loyaltypoints_id` int(5) NOT NULL,
  `use_specialties` tinyint(1) NOT NULL,
  `membership_level_id` int(3) NOT NULL,
  `email_template_id_verify_email` int(5) NOT NULL,
  `affiliate_level_id` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts-types_categories`
--

/*DROP TABLE IF EXISTS `accounts-types_categories`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts-types_categories` (
  `type_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  UNIQUE KEY `type_id` (`type_id`,`category_id`),
  KEY `product_id` (`category_id`),
  KEY `type_id_2` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts-types_products`
--

/*DROP TABLE IF EXISTS `accounts-types_products`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts-types_products` (
  `type_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  UNIQUE KEY `type_id` (`type_id`,`product_id`),
  KEY `product_id` (`product_id`),
  KEY `type_id_2` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts-types_restrictordering`
--

/*DROP TABLE IF EXISTS `accounts-types_restrictordering`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts-types_restrictordering` (
  `type_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  UNIQUE KEY `type_id` (`type_id`,`product_id`),
  KEY `product_id` (`product_id`),
  KEY `type_id_2` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_addressbook`
--

/*DROP TABLE IF EXISTS `accounts_addressbook`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_addressbook` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `account_id` int(20) NOT NULL,
  `label` varchar(35) NOT NULL,
  `is_billing` tinyint(1) NOT NULL,
  `is_shipping` tinyint(1) NOT NULL,
  `company` varchar(155) NOT NULL,
  `first_name` varchar(55) NOT NULL,
  `last_name` varchar(55) NOT NULL,
  `address_1` varchar(85) NOT NULL,
  `address_2` varchar(85) NOT NULL,
  `city` varchar(35) NOT NULL,
  `state_id` int(5) NOT NULL,
  `country_id` int(5) NOT NULL,
  `postal_code` varchar(15) NOT NULL,
  `email` varchar(85) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `is_residential` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `old_billingid` int(10) NOT NULL,
  `old_shippingid` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49212 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_addtl_fields`
--

/*DROP TABLE IF EXISTS `accounts_addtl_fields`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_addtl_fields` (
  `account_id` int(10) NOT NULL,
  `form_id` int(5) NOT NULL,
  `section_id` int(5) NOT NULL,
  `field_id` int(10) NOT NULL,
  `field_value` text NOT NULL,
  UNIQUE KEY `account_id_2` (`account_id`,`form_id`,`section_id`,`field_id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_advertising`
--

/*DROP TABLE IF EXISTS `accounts_advertising`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_advertising` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(500) NOT NULL,
  `img` varchar(155) NOT NULL,
  `clicks` int(10) NOT NULL,
  `shown` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_advertising_campaigns`
--

/*DROP TABLE IF EXISTS `accounts_advertising_campaigns`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_advertising_campaigns` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `lastshown_ad` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_advertising_clicks`
--

/*DROP TABLE IF EXISTS `accounts_advertising_clicks`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_advertising_clicks` (
  `ad_id` int(10) NOT NULL,
  `clicked` datetime NOT NULL,
  KEY `ad_id` (`ad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_bulletins`
--

/*DROP TABLE IF EXISTS `accounts_bulletins`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_bulletins` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL,
  `subject` varchar(155) NOT NULL,
  `body` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_cims`
--

/*DROP TABLE IF EXISTS `accounts_cims`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_cims` (
  `account_id` int(10) NOT NULL,
  `cim_profile_id` int(10) NOT NULL,
  `id` int(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3504 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_comments`
--

/*DROP TABLE IF EXISTS `accounts_comments`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_comments` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL,
  `body` text NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(10) NOT NULL,
  `beenread` tinyint(1) NOT NULL DEFAULT '0',
  `replyto_id` int(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `replyto_id` (`replyto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=239 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_discounts_used`
--

/*DROP TABLE IF EXISTS `accounts_discounts_used`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_discounts_used` (
  `account_id` int(10) NOT NULL,
  `discount_id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `times_used` int(5) NOT NULL,
  `used` datetime NOT NULL,
  KEY `account_id` (`account_id`),
  KEY `discount_id` (`discount_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_loyaltypoints`
--

/*DROP TABLE IF EXISTS `accounts_loyaltypoints`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_loyaltypoints` (
  `account_id` int(10) NOT NULL,
  `loyaltypoints_level_id` int(5) NOT NULL,
  `points_available` int(10) NOT NULL,
  UNIQUE KEY `account_id_2` (`account_id`,`loyaltypoints_level_id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_loyaltypoints_credits`
--

/*DROP TABLE IF EXISTS `accounts_loyaltypoints_credits`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_loyaltypoints_credits` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL,
  `loyaltypoints_level_id` int(5) NOT NULL,
  `shipment_id` int(10) NOT NULL,
  `points_awarded` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0=pending, 1=credited',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `shipment_id` (`shipment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_loyaltypoints_debits`
--

/*DROP TABLE IF EXISTS `accounts_loyaltypoints_debits`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_loyaltypoints_debits` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL,
  `loyaltypoints_level_id` int(5) NOT NULL,
  `order_id` int(10) NOT NULL,
  `points_used` int(10) NOT NULL,
  `created` datetime NOT NULL,
  `notes` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_id_2` (`account_id`,`loyaltypoints_level_id`,`order_id`),
  KEY `account_id` (`account_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_memberships`
--

/*DROP TABLE IF EXISTS `accounts_memberships`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_memberships` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `membership_id` int(5) NOT NULL,
  `amount_paid` decimal(8,2) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `account_id` int(10) NOT NULL,
  `order_id` int(11) NOT NULL,
  `subscription_price` decimal(8,2) NOT NULL,
  `product_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `cancelled` datetime DEFAULT NULL,
  `expirealert1_sent` tinyint(1) NOT NULL,
  `expirealert2_sent` tinyint(1) NOT NULL,
  `expire_sent` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44419 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_messages`
--

/*DROP TABLE IF EXISTS `accounts_messages`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_messages` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `header_id` int(20) NOT NULL,
  `replied_id` int(20) NOT NULL,
  `to_id` int(10) NOT NULL,
  `from_id` int(10) NOT NULL,
  `body` text NOT NULL,
  `sent` datetime NOT NULL,
  `readdate` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=deleted, 2=spam, 3=saved',
  `beenseen` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38053 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_messages_headers`
--

/*DROP TABLE IF EXISTS `accounts_messages_headers`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_messages_headers` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34851 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_onmind`
--

/*DROP TABLE IF EXISTS `accounts_onmind`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_onmind` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `account_id` int(20) NOT NULL,
  `text` text NOT NULL,
  `posted` datetime NOT NULL,
  `like_count` int(7) NOT NULL DEFAULT '0',
  `dislike_count` int(7) NOT NULL DEFAULT '0',
  `comment_count` int(7) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1919 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_onmind_comments`
--

/*DROP TABLE IF EXISTS `accounts_onmind_comments`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_onmind_comments` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `onmind_id` int(20) NOT NULL,
  `comment_id` int(20) NOT NULL,
  `account_id` int(10) NOT NULL,
  `text` varchar(200) NOT NULL,
  `posted` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `onmind_id` (`onmind_id`,`comment_id`,`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1630 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_onmind_likes`
--

/*DROP TABLE IF EXISTS `accounts_onmind_likes`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_onmind_likes` (
  `onmind_id` int(20) NOT NULL,
  `account_id` int(10) NOT NULL,
  `type_id` tinyint(1) NOT NULL,
  KEY `onmind_id` (`onmind_id`,`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_programs`
--

/*DROP TABLE IF EXISTS `accounts_programs`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_programs` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_programs_accounts`
--

/*DROP TABLE IF EXISTS `accounts_programs_accounts`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_programs_accounts` (
  `account_id` int(10) NOT NULL,
  `program_id` int(10) NOT NULL,
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_resourcebox`
--

/*DROP TABLE IF EXISTS `accounts_resourcebox`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_resourcebox` (
  `account_id` int(11) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `about_author` varchar(500) NOT NULL,
  `link_1` varchar(255) NOT NULL,
  `link_2` varchar(255) NOT NULL,
  `link_1_title` varchar(65) NOT NULL,
  `link_2_title` varchar(65) NOT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_specialties`
--

/*DROP TABLE IF EXISTS `accounts_specialties`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_specialties` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `account_id` int(20) NOT NULL,
  `specialty_id` int(5) NOT NULL,
  `approved` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_id_2` (`account_id`,`specialty_id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=197080 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_templates_sent`
--

/*DROP TABLE IF EXISTS `accounts_templates_sent`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_templates_sent` (
  `account_id` int(20) NOT NULL,
  `template_id` int(10) NOT NULL,
  `sent` datetime NOT NULL,
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_transactions`
--

/*DROP TABLE IF EXISTS `accounts_transactions`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_transactions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `transid` varchar(35) NOT NULL,
  `ccnum` varchar(4) NOT NULL,
  `ccexpmonth` tinyint(2) NOT NULL,
  `ccexpyear` year(4) NOT NULL,
  `account_id` int(10) NOT NULL,
  `zipcode` varchar(15) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `description` varchar(255) NOT NULL,
  `orig_amount` decimal(8,2) NOT NULL,
  `disc_amount` decimal(8,2) NOT NULL,
  `disc_code` varchar(55) NOT NULL,
  `created` datetime NOT NULL,
  `membership_id` int(10) NOT NULL,
  `payment_profile_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8194 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_updates`
--

/*DROP TABLE IF EXISTS `accounts_updates`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_updates` (
  `account_id` int(10) NOT NULL,
  `newmessages` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_views`
--

/*DROP TABLE IF EXISTS `accounts_views`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_views` (
  `profile_id` int(10) NOT NULL,
  `account_id` int(10) NOT NULL COMMENT 'viewers id',
  `viewed_date` date NOT NULL,
  `viewed_time` time NOT NULL,
  KEY `profile_id` (`profile_id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_emails_sent`
--

/*DROP TABLE IF EXISTS `admin_emails_sent`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_emails_sent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL,
  `template_id` int(5) NOT NULL,
  `sent_to` varchar(85) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `sent_date` datetime NOT NULL,
  `sent_by` int(5) NOT NULL,
  `order_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7298 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_levels`
--

/*DROP TABLE IF EXISTS `admin_levels`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_levels` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_levels_menus`
--

/*DROP TABLE IF EXISTS `admin_levels_menus`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_levels_menus` (
  `level_id` int(5) NOT NULL,
  `menu_id` int(5) NOT NULL,
  KEY `level_id` (`level_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_users`
--

/*DROP TABLE IF EXISTS `admin_users`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_users` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `user` varchar(15) NOT NULL,
  `password` varchar(15) NOT NULL,
  `email` varchar(65) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `level_id` int(5) NOT NULL,
  `filter_orders` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_users_distributors`
--

/*DROP TABLE IF EXISTS `admin_users_distributors`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_users_distributors` (
  `user_id` int(5) NOT NULL,
  `distributor_id` int(5) NOT NULL,
  UNIQUE KEY `user_id` (`user_id`,`distributor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `affiliates`
--

/*DROP TABLE IF EXISTS `affiliates`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `affiliates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(155) NOT NULL,
  `email` varchar(85) NOT NULL,
  `password` varchar(35) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address_1` varchar(100) NOT NULL,
  `address_2` varchar(100) NOT NULL,
  `city` char(35) NOT NULL,
  `state_id` int(4) NOT NULL,
  `country_id` int(4) NOT NULL,
  `postal_code` varchar(15) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `affiliate_level_id` int(10) NOT NULL DEFAULT '100',
  `account_id` int(10) NOT NULL COMMENT 'if linking account to affiliate',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31062 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `affiliates_levels`
--

/*DROP TABLE IF EXISTS `affiliates_levels`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `affiliates_levels` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(35) NOT NULL,
  `order_rate` decimal(6,2) NOT NULL,
  `subscription_rate` decimal(6,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `affiliates_payments`
--

/*DROP TABLE IF EXISTS `affiliates_payments`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `affiliates_payments` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `affiliate_id` int(20) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `notes` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `affiliate_id` (`affiliate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `affiliates_payments_referrals`
--

/*DROP TABLE IF EXISTS `affiliates_payments_referrals`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `affiliates_payments_referrals` (
  `payment_id` int(20) NOT NULL,
  `referral_id` int(20) NOT NULL,
  KEY `referral_id` (`referral_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `affiliates_referrals`
--

/*DROP TABLE IF EXISTS `affiliates_referrals`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `affiliates_referrals` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `affiliate_id` int(10) NOT NULL,
  `order_id` int(20) NOT NULL,
  `status_id` int(5) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `type_id` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `affiliate_id` (`affiliate_id`),
  KEY `type_id` (`type_id`),
  KEY `order_id` (`order_id`),
  KEY `ordertype_id` (`order_id`,`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1447 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `affiliates_referrals_statuses`
--

/*DROP TABLE IF EXISTS `affiliates_referrals_statuses`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `affiliates_referrals_statuses` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `affiliates_referrals_types`
--

/*DROP TABLE IF EXISTS `affiliates_referrals_types`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `affiliates_referrals_types` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `airports`
--

/*DROP TABLE IF EXISTS `airports`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `airports` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `articles`
--

/*DROP TABLE IF EXISTS `articles`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `headline` varchar(255) NOT NULL,
  `short_headline` varchar(35) NOT NULL,
  `author` varchar(155) NOT NULL,
  `body` longtext NOT NULL,
  `photo` int(20) NOT NULL,
  `account_id` int(10) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `category` int(5) NOT NULL,
  `views` int(10) NOT NULL,
  `featured` tinyint(1) NOT NULL,
  `url_name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rank` (`views`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `articles_categories`
--

/*DROP TABLE IF EXISTS `articles_categories`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articles_categories` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `parent_id` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `url_name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `articles_comments`
--

/*DROP TABLE IF EXISTS `articles_comments`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articles_comments` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `article_id` int(20) NOT NULL,
  `body` text NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(10) NOT NULL,
  `beenread` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(55) NOT NULL,
  `webaddress` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `articles_resources`
--

/*DROP TABLE IF EXISTS `articles_resources`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articles_resources` (
  `article_id` int(20) NOT NULL,
  `keywords` varchar(500) NOT NULL,
  `about_author` varchar(500) NOT NULL,
  `link_1` varchar(255) NOT NULL,
  `link_2` varchar(255) NOT NULL,
  `link_1_title` varchar(65) NOT NULL,
  `link_2_title` varchar(65) NOT NULL,
  PRIMARY KEY (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `articles_views`
--

/*DROP TABLE IF EXISTS `articles_views`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articles_views` (
  `article_id` int(20) NOT NULL,
  `account_id` int(10) NOT NULL,
  `viewed_date` date NOT NULL,
  `viewed_time` time NOT NULL,
  KEY `article_id` (`article_id`,`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `attributes`
--

/*DROP TABLE IF EXISTS `attributes`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attributes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `type_id` tinyint(2) NOT NULL,
  `show_in_details` tinyint(1) NOT NULL,
  `show_in_search` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `attributes-packages`
--

/*DROP TABLE IF EXISTS `attributes-packages`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attributes-packages` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `attributes-packages_sets`
--

/*DROP TABLE IF EXISTS `attributes-packages_sets`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attributes-packages_sets` (
  `package_id` int(10) NOT NULL,
  `set_id` int(10) NOT NULL,
  KEY `package_id` (`package_id`,`set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `attributes-sets`
--

/*DROP TABLE IF EXISTS `attributes-sets`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attributes-sets` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `attributes-sets_attributes`
--

/*DROP TABLE IF EXISTS `attributes-sets_attributes`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attributes-sets_attributes` (
  `set_id` int(5) NOT NULL,
  `attribute_id` int(10) NOT NULL,
  KEY `set_id` (`set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `attributes-types`
--

/*DROP TABLE IF EXISTS `attributes-types`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attributes-types` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `attributes_options`
--

/*DROP TABLE IF EXISTS `attributes_options`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attributes_options` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `attribute_id` int(10) NOT NULL,
  `display` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL,
  `rank` int(3) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `attribute_id` (`attribute_id`)
) ENGINE=InnoDB AUTO_INCREMENT=532 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `automated_emails`
--

/*DROP TABLE IF EXISTS `automated_emails`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `automated_emails` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `message_template_id` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `send_on` tinyint(2) NOT NULL COMMENT '0=status change, 1=days after order, 2=days after shipped, 3= days after delivered',
  `send_on_status` int(5) NOT NULL,
  `send_on_daysafter` int(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `message_template_id` (`message_template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `automated_emails_accounttypes`
--

/*DROP TABLE IF EXISTS `automated_emails_accounttypes`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `automated_emails_accounttypes` (
  `automated_email_id` int(10) NOT NULL,
  `account_type_id` int(10) NOT NULL,
  UNIQUE KEY `automated_email_id_2` (`automated_email_id`,`account_type_id`),
  KEY `automated_email_id` (`automated_email_id`),
  KEY `account_type_id` (`account_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `automated_emails_sites`
--

/*DROP TABLE IF EXISTS `automated_emails_sites`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `automated_emails_sites` (
  `automated_email_id` int(10) NOT NULL,
  `site_id` int(5) NOT NULL,
  UNIQUE KEY `automated_email_id_2` (`automated_email_id`,`site_id`),
  KEY `automated_email_id` (`automated_email_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `banners_campaigns`
--

/*DROP TABLE IF EXISTS `banners_campaigns`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banners_campaigns` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `location` varchar(100) NOT NULL,
  `width` int(5) NOT NULL,
  `height` int(5) NOT NULL,
  `new_window` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `banners_clicks`
--

/*DROP TABLE IF EXISTS `banners_clicks`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banners_clicks` (
  `banner_id` int(20) NOT NULL,
  `clicked` datetime NOT NULL,
  KEY `banner_id` (`banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `banners_images`
--

/*DROP TABLE IF EXISTS `banners_images`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banners_images` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `campaign_id` int(10) NOT NULL,
  `name` varchar(55) NOT NULL,
  `link` varchar(255) NOT NULL,
  `image` varchar(100) NOT NULL,
  `clicks_no` int(10) NOT NULL,
  `show_no` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `campaign_id` (`campaign_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `banners_shown`
--

/*DROP TABLE IF EXISTS `banners_shown`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banners_shown` (
  `banner_id` int(20) NOT NULL,
  `shown` datetime NOT NULL,
  KEY `banner_id` (`banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `blog_entry`
--

/*DROP TABLE IF EXISTS `blog_entry`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_entry` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `blog_id` int(10) NOT NULL,
  `body` blob NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(10) NOT NULL,
  `updated` datetime NOT NULL,
  `allowcomments` tinyint(1) NOT NULL,
  `title` varchar(100) NOT NULL,
  `short_title` varchar(35) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `views` int(10) NOT NULL,
  `photo` int(20) NOT NULL,
  `url_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `blog_entry_comments`
--

/*DROP TABLE IF EXISTS `blog_entry_comments`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_entry_comments` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `entry_id` int(20) NOT NULL,
  `body` text NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(10) NOT NULL,
  `beenread` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(55) NOT NULL,
  `webaddress` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `blog_entry_views`
--

/*DROP TABLE IF EXISTS `blog_entry_views`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_entry_views` (
  `entry_id` int(20) NOT NULL,
  `account_id` int(10) NOT NULL,
  `viewed_date` date NOT NULL,
  `viewed_time` time NOT NULL,
  KEY `entry_id` (`entry_id`,`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `blogs`
--

/*DROP TABLE IF EXISTS `blogs`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blogs` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(155) NOT NULL,
  `description` varchar(800) NOT NULL,
  `createdby` int(10) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `lastposted` datetime NOT NULL,
  `allowcomments` tinyint(1) NOT NULL,
  `views` int(10) NOT NULL,
  `photo` int(20) NOT NULL,
  `featured` tinyint(1) NOT NULL,
  `url_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `blogs_views`
--

/*DROP TABLE IF EXISTS `blogs_views`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blogs_views` (
  `blog_id` int(20) NOT NULL,
  `account_id` varchar(10) NOT NULL,
  `viewed_date` date NOT NULL,
  `viewed_time` time NOT NULL,
  KEY `blog_id` (`blog_id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `board_categories`
--

/*DROP TABLE IF EXISTS `board_categories`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `board_categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(155) NOT NULL,
  `description` varchar(255) NOT NULL,
  `board_id` int(5) NOT NULL,
  `created` datetime NOT NULL,
  `rank` tinyint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `board_thread_entry`
--

/*DROP TABLE IF EXISTS `board_thread_entry`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `board_thread_entry` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `thread_id` int(20) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(10) NOT NULL,
  `body` text NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `thread_id` (`thread_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `board_threads`
--

/*DROP TABLE IF EXISTS `board_threads`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `board_threads` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `category_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(10) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(10) NOT NULL,
  `allowreply` tinyint(1) NOT NULL DEFAULT '1',
  `lastpost` datetime NOT NULL,
  `lastposter` int(10) NOT NULL,
  `photo` int(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `board_threads_details`
--

/*DROP TABLE IF EXISTS `board_threads_details`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `board_threads_details` (
  `thread_id` int(20) NOT NULL,
  `keywords` varchar(500) NOT NULL,
  `city` varchar(35) NOT NULL,
  `state` varchar(2) NOT NULL,
  `country` varchar(2) NOT NULL,
  `zipcode` varchar(15) NOT NULL,
  `webaddress` varchar(100) NOT NULL,
  `email` varchar(85) NOT NULL,
  `phone` varchar(15) NOT NULL,
  PRIMARY KEY (`thread_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `board_type`
--

/*DROP TABLE IF EXISTS `board_type`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `board_type` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `boards`
--

/*DROP TABLE IF EXISTS `boards`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `boards` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `type` tinyint(3) NOT NULL,
  `group_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bookingas`
--

/*DROP TABLE IF EXISTS `bookingas`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bookingas` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(555) NOT NULL,
  `display` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bookingas_options`
--

/*DROP TABLE IF EXISTS `bookingas_options`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bookingas_options` (
  `bookingas_id` int(5) NOT NULL,
  `options` text NOT NULL,
  KEY `bookingas_id` (`bookingas_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bookingas_products`
--

/*DROP TABLE IF EXISTS `bookingas_products`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bookingas_products` (
  `bookingas_id` int(5) NOT NULL,
  `product` int(10) NOT NULL,
  KEY `bookingas_id` (`bookingas_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `brands`
--

/*DROP TABLE IF EXISTS `brands`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brands` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `brands_index_1` (`id`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bulkedit_change`
--

/*DROP TABLE IF EXISTS `bulkedit_change`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bulkedit_change` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `action_type` varchar(10) NOT NULL,
  `action_changeto` text NOT NULL,
  `products_edited` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bulkedit_change_products`
--

/*DROP TABLE IF EXISTS `bulkedit_change_products`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bulkedit_change_products` (
  `change_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `changed_from` text NOT NULL,
  UNIQUE KEY `change_id` (`change_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `catalog_updates`
--

/*DROP TABLE IF EXISTS `catalog_updates`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catalog_updates` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(5) NOT NULL COMMENT '0=product, 1=category, 2=new image size, 5-5.99=datafeed, 6=sitemap, 7=notify backinstock',
  `item_id` int(20) NOT NULL,
  `processing` tinyint(1) NOT NULL,
  `start` int(10) NOT NULL,
  `info` text NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories`
--

/*DROP TABLE IF EXISTS `categories`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_id` int(10) NOT NULL,
  `rank` int(3) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `url_name` varchar(155) NOT NULL,
  `show_sale` tinyint(1) NOT NULL,
  `limit_min_price` tinyint(1) NOT NULL,
  `min_price` decimal(10,2) NOT NULL,
  `limit_max_price` tinyint(1) NOT NULL,
  `max_price` decimal(10,2) NOT NULL,
  `show_in_list` tinyint(1) NOT NULL DEFAULT '1',
  `limit_days` int(5) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories_attributes`
--

/*DROP TABLE IF EXISTS `categories_attributes`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_attributes` (
  `category_id` int(10) NOT NULL,
  `option_id` int(20) NOT NULL,
  KEY `category_id` (`category_id`,`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories_attributes_rules`
--

/*DROP TABLE IF EXISTS `categories_attributes_rules`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_attributes_rules` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category_id` int(20) NOT NULL,
  `temp_id` int(20) NOT NULL,
  `match_type` tinyint(1) NOT NULL COMMENT '0=any, 1=all',
  `value_id` int(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories_brands`
--

/*DROP TABLE IF EXISTS `categories_brands`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_brands` (
  `category_id` int(10) NOT NULL,
  `brand_id` int(10) NOT NULL,
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories_featured`
--

/*DROP TABLE IF EXISTS `categories_featured`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_featured` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_id_2` (`category_id`,`product_id`),
  KEY `category_id` (`category_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories_products_assn`
--

/*DROP TABLE IF EXISTS `categories_products_assn`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_products_assn` (
  `category_id` int(20) NOT NULL,
  `product_id` int(20) NOT NULL,
  `manual` tinyint(1) NOT NULL,
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories_products_hide`
--

/*DROP TABLE IF EXISTS `categories_products_hide`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_products_hide` (
  `category_id` int(20) NOT NULL,
  `product_id` int(20) NOT NULL,
  UNIQUE KEY `catproduct` (`category_id`,`product_id`),
  KEY `category_id` (`category_id`),
  KEY `categories_products_hide_index_1` (`product_id`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories_products_ranks`
--

/*DROP TABLE IF EXISTS `categories_products_ranks`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_products_ranks` (
  `category_id` int(20) NOT NULL,
  `product_id` int(20) NOT NULL,
  `rank` int(5) NOT NULL,
  UNIQUE KEY `catproductmanual` (`category_id`,`product_id`),
  KEY `category_id` (`category_id`),
  KEY `categories_products_ranks_index_1` (`category_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories_products_sorts`
--

/*DROP TABLE IF EXISTS `categories_products_sorts`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_products_sorts` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `category_id` int(10) NOT NULL,
  `sort_id` int(3) NOT NULL,
  `rank` int(3) NOT NULL,
  `isdefault` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_id_2` (`category_id`,`sort_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories_rules`
--

/*DROP TABLE IF EXISTS `categories_rules`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_rules` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category_id` int(20) NOT NULL,
  `temp_id` int(20) NOT NULL,
  `match_type` tinyint(1) NOT NULL COMMENT '0=any, 1=all',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=162 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories_rules_attributes`
--

/*DROP TABLE IF EXISTS `categories_rules_attributes`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_rules_attributes` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `rule_id` int(10) NOT NULL,
  `value_id` int(20) NOT NULL,
  `set_id` int(10) NOT NULL,
  `match_type` tinyint(4) NOT NULL COMMENT '0=matches, 1=doesn''t match',
  PRIMARY KEY (`id`),
  KEY `rule_id` (`rule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories_settings`
--

/*DROP TABLE IF EXISTS `categories_settings`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_settings` (
  `category_id` int(10) NOT NULL,
  `settings_template_id` int(10) NOT NULL,
  `use_default_category` tinyint(1) NOT NULL,
  `use_default_feature` tinyint(1) NOT NULL,
  `use_default_product` tinyint(1) NOT NULL,
  `category_thumbnail_template` int(5) NOT NULL,
  `product_thumbnail_template` int(5) NOT NULL,
  `product_thumbnail_count` int(3) NOT NULL,
  `feature_thumbnail_template` int(5) NOT NULL,
  `feature_thumbnail_count` int(3) NOT NULL,
  `feature_showsort` tinyint(1) NOT NULL,
  `product_thumbnail_showsort` tinyint(1) NOT NULL,
  `product_thumbnail_showmessage` tinyint(1) NOT NULL,
  `feature_showmessage` tinyint(1) NOT NULL,
  `show_categories_in_body` tinyint(1) NOT NULL,
  `show_products` tinyint(1) NOT NULL,
  `show_featured` tinyint(1) NOT NULL,
  `layout_id` int(5) NOT NULL,
  `module_template_id` int(5) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories_settings_sites`
--

/*DROP TABLE IF EXISTS `categories_settings_sites`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_settings_sites` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `category_id` int(10) NOT NULL,
  `site_id` int(5) NOT NULL,
  `settings_template_id` int(10) DEFAULT NULL,
  `category_thumbnail_template` int(5) DEFAULT NULL,
  `product_thumbnail_template` int(5) DEFAULT NULL,
  `product_thumbnail_count` int(3) DEFAULT NULL,
  `feature_thumbnail_template` int(5) DEFAULT NULL,
  `feature_thumbnail_count` int(3) DEFAULT NULL,
  `feature_showsort` tinyint(1) DEFAULT NULL,
  `feature_defaultsort` tinyint(2) DEFAULT NULL,
  `product_thumbnail_showsort` tinyint(1) DEFAULT NULL,
  `product_thumbnail_defaultsort` tinyint(2) DEFAULT NULL,
  `product_thumbnail_customsort` tinyint(1) DEFAULT NULL,
  `product_thumbnail_showmessage` tinyint(1) DEFAULT NULL,
  `feature_showmessage` tinyint(1) DEFAULT NULL,
  `show_categories_in_body` tinyint(1) DEFAULT NULL,
  `show_products` tinyint(1) DEFAULT NULL,
  `show_featured` tinyint(1) DEFAULT NULL,
  `layout_id` int(5) DEFAULT NULL,
  `module_template_id` int(5) DEFAULT NULL,
  `search_form_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_id` (`category_id`,`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=218 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories_settings_sites_modulevalues`
--

/*DROP TABLE IF EXISTS `categories_settings_sites_modulevalues`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_settings_sites_modulevalues` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `category_id` int(10) NOT NULL,
  `site_id` int(5) NOT NULL,
  `section_id` int(10) NOT NULL,
  `module_id` int(10) NOT NULL,
  `field_id` int(10) NOT NULL,
  `custom_value` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_id_3` (`category_id`,`site_id`,`section_id`,`module_id`,`field_id`),
  KEY `product_id` (`category_id`),
  KEY `product_id_2` (`category_id`,`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=314 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories_settings_templates`
--

/*DROP TABLE IF EXISTS `categories_settings_templates`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_settings_templates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `settings_template_id` int(1) DEFAULT NULL,
  `use_default_category` tinyint(1) DEFAULT NULL,
  `use_default_feature` tinyint(1) DEFAULT NULL,
  `use_default_product` tinyint(1) DEFAULT NULL,
  `category_thumbnail_template` int(5) DEFAULT NULL,
  `product_thumbnail_template` int(5) DEFAULT NULL,
  `product_thumbnail_count` int(3) DEFAULT NULL,
  `feature_thumbnail_template` int(5) DEFAULT NULL,
  `feature_thumbnail_count` int(3) DEFAULT NULL,
  `feature_showsort` tinyint(1) DEFAULT NULL,
  `feature_defaultsort` tinyint(2) DEFAULT NULL,
  `product_thumbnail_showsort` tinyint(1) DEFAULT NULL,
  `product_thumbnail_defaultsort` tinyint(2) DEFAULT NULL,
  `product_thumbnail_customsort` tinyint(1) DEFAULT NULL,
  `product_thumbnail_showmessage` tinyint(1) DEFAULT NULL,
  `feature_showmessage` tinyint(1) DEFAULT NULL,
  `show_categories_in_body` tinyint(1) DEFAULT NULL,
  `show_products` tinyint(1) DEFAULT NULL,
  `show_featured` tinyint(1) DEFAULT NULL,
  `layout_id` int(5) DEFAULT NULL,
  `module_template_id` int(5) DEFAULT NULL,
  `module_custom_values` text NOT NULL,
  `search_form_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories_settings_templates_modulevalues`
--

/*DROP TABLE IF EXISTS `categories_settings_templates_modulevalues`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_settings_templates_modulevalues` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `settings_template_id` int(5) NOT NULL,
  `section_id` int(10) NOT NULL,
  `module_id` int(10) NOT NULL,
  `field_id` int(10) NOT NULL,
  `custom_value` text,
  PRIMARY KEY (`id`),
  KEY `settings_template_id` (`settings_template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=287 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories_types`
--

/*DROP TABLE IF EXISTS `categories_types`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_types` (
  `category_id` int(10) NOT NULL,
  `type_id` int(10) NOT NULL,
  `id` int(5) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cim_profile`
--

/*DROP TABLE IF EXISTS `cim_profile`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cim_profile` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `authnet_profile_id` varchar(20) NOT NULL,
  `gateway_account_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11066 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cim_profile_paymentprofile`
--

/*DROP TABLE IF EXISTS `cim_profile_paymentprofile`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cim_profile_paymentprofile` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `profile_id` int(10) NOT NULL,
  `first_cc_number` int(2) NOT NULL,
  `cc_number` varchar(4) NOT NULL,
  `cc_exp` date NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `authnet_payment_profile_id` varchar(20) NOT NULL,
  `is_default` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `profile_id` (`profile_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13557 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `countries`
--

/*DROP TABLE IF EXISTS `countries`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(85) NOT NULL,
  `abbreviation` varchar(3) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rank` int(5) NOT NULL,
  `iso_code` varchar(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=660 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `countries_iso`
--

/*DROP TABLE IF EXISTS `countries_iso`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries_iso` (
  `name` varchar(255) NOT NULL,
  `iso` varchar(3) NOT NULL,
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `countries_regions`
--

/*DROP TABLE IF EXISTS `countries_regions`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries_regions` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `country_id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `rank` int(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `currencies`
--

/*DROP TABLE IF EXISTS `currencies`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currencies` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `custom_fields`
--

/*DROP TABLE IF EXISTS `custom_fields`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_fields` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `display` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` tinyint(2) NOT NULL COMMENT '0=text, 1=textarea, 2=checkbox, 3=radio, 4=select, 5=selectmultiple, 6=button',
  `required` tinyint(1) NOT NULL DEFAULT '1',
  `rank` int(5) NOT NULL,
  `cssclass` varchar(100) NOT NULL,
  `options` text NOT NULL,
  `specs` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=170 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `custom_forms`
--

/*DROP TABLE IF EXISTS `custom_forms`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_forms` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `custom_forms_sections`
--

/*DROP TABLE IF EXISTS `custom_forms_sections`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_forms_sections` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `form_id` int(5) NOT NULL,
  `title` varchar(155) NOT NULL,
  `rank` int(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `form_id` (`form_id`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `custom_forms_sections_fields`
--

/*DROP TABLE IF EXISTS `custom_forms_sections_fields`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_forms_sections_fields` (
  `section_id` int(5) NOT NULL,
  `field_id` int(10) NOT NULL,
  `required` tinyint(1) NOT NULL,
  `rank` int(3) NOT NULL,
  `new_row` tinyint(1) NOT NULL,
  KEY `section_id` (`section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `custom_forms_show`
--

/*DROP TABLE IF EXISTS `custom_forms_show`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_forms_show` (
  `form_id` int(10) NOT NULL,
  `show_on` tinyint(2) NOT NULL COMMENT '0=checkout, 1=product details',
  `show_for` tinyint(2) NOT NULL COMMENT '0=all, 1=product types, 2=product id',
  `show_count` tinyint(2) NOT NULL COMMENT '0=once, 1=per product, 2=per product qty, 3=per type in cart',
  `rank` int(5) NOT NULL,
  KEY `form_id` (`form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `custom_forms_show_products`
--

/*DROP TABLE IF EXISTS `custom_forms_show_products`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_forms_show_products` (
  `form_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `rank` int(5) NOT NULL,
  KEY `form_id` (`form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `custom_forms_show_producttypes`
--

/*DROP TABLE IF EXISTS `custom_forms_show_producttypes`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_forms_show_producttypes` (
  `form_id` int(10) NOT NULL,
  `product_type_id` int(10) NOT NULL,
  KEY `form_id` (`form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discount`
--

/*DROP TABLE IF EXISTS `discount`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `display` varchar(85) NOT NULL,
  `start_date` datetime NOT NULL,
  `exp_date` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `limit_per_order` int(5) NOT NULL DEFAULT '1',
  `match_anyall` tinyint(1) NOT NULL COMMENT '0=all, 1=any',
  `random_generated` varchar(20) NOT NULL,
  `limit_uses` int(8) NOT NULL,
  `limit_per_customer` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15885 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discount_advantage`
--

/*DROP TABLE IF EXISTS `discount_advantage`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount_advantage` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `discount_id` int(10) NOT NULL,
  `advantage_type_id` int(5) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `apply_shipping_id` int(5) NOT NULL,
  `apply_shipping_country` int(5) NOT NULL,
  `apply_shipping_distributor` int(5) NOT NULL,
  `applyto_qty_type` tinyint(1) NOT NULL COMMENT '0=combined,1=individual',
  `applyto_qty_combined` int(5) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `discount_id` (`discount_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15890 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discount_advantage_products`
--

/*DROP TABLE IF EXISTS `discount_advantage_products`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount_advantage_products` (
  `advantage_id` int(20) NOT NULL,
  `product_id` int(10) NOT NULL,
  `applyto_qty` int(5) NOT NULL DEFAULT '1',
  KEY `advantage_id` (`advantage_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discount_advantage_producttypes`
--

/*DROP TABLE IF EXISTS `discount_advantage_producttypes`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount_advantage_producttypes` (
  `advantage_id` int(20) NOT NULL,
  `producttype_id` int(10) NOT NULL,
  `applyto_qty` int(5) NOT NULL,
  KEY `advantage_id` (`advantage_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discount_advantage_types`
--

/*DROP TABLE IF EXISTS `discount_advantage_types`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount_advantage_types` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discount_rule`
--

/*DROP TABLE IF EXISTS `discount_rule`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount_rule` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `discount_id` int(10) NOT NULL,
  `match_anyall` tinyint(1) NOT NULL COMMENT '0=all, 1=any',
  `rank` int(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `discount_id` (`discount_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15900 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discount_rule_condition`
--

/*DROP TABLE IF EXISTS `discount_rule_condition`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount_rule_condition` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `rule_id` int(10) NOT NULL,
  `condition_type_id` int(4) NOT NULL,
  `required_cart_value` decimal(10,2) NOT NULL,
  `required_code` varchar(25) NOT NULL,
  `required_qty_type` tinyint(1) NOT NULL,
  `required_qty_combined` int(5) NOT NULL DEFAULT '1',
  `match_anyall` tinyint(1) NOT NULL,
  `rank` int(3) NOT NULL DEFAULT '1',
  `equals_notequals` tinyint(1) NOT NULL,
  `use_with_rules_products` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15901 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discount_rule_condition_accounttypes`
--

/*DROP TABLE IF EXISTS `discount_rule_condition_accounttypes`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount_rule_condition_accounttypes` (
  `condition_id` int(10) NOT NULL,
  `accounttype_id` int(10) NOT NULL,
  UNIQUE KEY `condition_id` (`condition_id`,`accounttype_id`),
  KEY `rule_id` (`condition_id`),
  KEY `accounttype_id` (`accounttype_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discount_rule_condition_attributes`
--

/*DROP TABLE IF EXISTS `discount_rule_condition_attributes`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount_rule_condition_attributes` (
  `condition_id` int(10) NOT NULL,
  `attributevalue_id` int(10) NOT NULL,
  `required_qty` int(4) NOT NULL DEFAULT '1',
  UNIQUE KEY `condition_id` (`condition_id`,`attributevalue_id`),
  KEY `rule_id` (`condition_id`),
  KEY `product_id` (`attributevalue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discount_rule_condition_countries`
--

/*DROP TABLE IF EXISTS `discount_rule_condition_countries`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount_rule_condition_countries` (
  `condition_id` int(10) NOT NULL,
  `country_id` int(10) NOT NULL,
  UNIQUE KEY `condition_id` (`condition_id`,`country_id`),
  KEY `rule_id` (`condition_id`),
  KEY `site_id` (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discount_rule_condition_distributors`
--

/*DROP TABLE IF EXISTS `discount_rule_condition_distributors`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount_rule_condition_distributors` (
  `condition_id` int(10) NOT NULL,
  `distributor_id` int(10) NOT NULL,
  UNIQUE KEY `condition_id` (`condition_id`,`distributor_id`),
  KEY `rule_id` (`condition_id`),
  KEY `site_id` (`distributor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discount_rule_condition_membershiplevels`
--

/*DROP TABLE IF EXISTS `discount_rule_condition_membershiplevels`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount_rule_condition_membershiplevels` (
  `condition_id` int(10) NOT NULL,
  `membershiplevel_id` int(10) NOT NULL,
  UNIQUE KEY `condition_id` (`condition_id`,`membershiplevel_id`),
  KEY `rule_id` (`condition_id`),
  KEY `product_id` (`membershiplevel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discount_rule_condition_onsalestatuses`
--

/*DROP TABLE IF EXISTS `discount_rule_condition_onsalestatuses`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount_rule_condition_onsalestatuses` (
  `condition_id` int(10) NOT NULL,
  `onsalestatus_id` tinyint(1) NOT NULL,
  `required_qty` int(4) NOT NULL,
  UNIQUE KEY `condition_id` (`condition_id`,`onsalestatus_id`),
  KEY `rule_id` (`condition_id`),
  KEY `product_id` (`onsalestatus_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discount_rule_condition_outofstockstatuses`
--

/*DROP TABLE IF EXISTS `discount_rule_condition_outofstockstatuses`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount_rule_condition_outofstockstatuses` (
  `condition_id` int(10) NOT NULL,
  `outofstockstatus_id` int(10) NOT NULL,
  `required_qty` int(4) NOT NULL,
  UNIQUE KEY `condition_id` (`condition_id`,`outofstockstatus_id`),
  KEY `rule_id` (`condition_id`),
  KEY `product_id` (`outofstockstatus_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discount_rule_condition_productavailabilities`
--

/*DROP TABLE IF EXISTS `discount_rule_condition_productavailabilities`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount_rule_condition_productavailabilities` (
  `condition_id` int(10) NOT NULL,
  `availability_id` int(10) NOT NULL,
  `required_qty` int(4) NOT NULL,
  UNIQUE KEY `condition_id` (`condition_id`,`availability_id`),
  KEY `rule_id` (`condition_id`),
  KEY `product_id` (`availability_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discount_rule_condition_products`
--

/*DROP TABLE IF EXISTS `discount_rule_condition_products`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount_rule_condition_products` (
  `condition_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `required_qty` int(5) NOT NULL,
  UNIQUE KEY `condition_id` (`condition_id`,`product_id`),
  KEY `rule_id` (`condition_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discount_rule_condition_producttypes`
--

/*DROP TABLE IF EXISTS `discount_rule_condition_producttypes`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount_rule_condition_producttypes` (
  `condition_id` int(10) NOT NULL,
  `producttype_id` int(10) NOT NULL,
  `required_qty` int(4) NOT NULL,
  UNIQUE KEY `condition_id` (`condition_id`,`producttype_id`),
  KEY `rule_id` (`condition_id`),
  KEY `product_id` (`producttype_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discount_rule_condition_sites`
--

/*DROP TABLE IF EXISTS `discount_rule_condition_sites`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount_rule_condition_sites` (
  `condition_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  UNIQUE KEY `condition_id` (`condition_id`,`site_id`),
  KEY `rule_id` (`condition_id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discount_rule_condition_types`
--

/*DROP TABLE IF EXISTS `discount_rule_condition_types`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount_rule_condition_types` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discounts`
--

/*DROP TABLE IF EXISTS `discounts`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discounts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `display` varchar(85) NOT NULL,
  `start_date` datetime NOT NULL,
  `exp_date` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15880 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discounts-levels`
--

/*DROP TABLE IF EXISTS `discounts-levels`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discounts-levels` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `apply_to` tinyint(2) NOT NULL COMMENT '0=all products, 1=selected products, 2=not selected products',
  `action_type` tinyint(1) NOT NULL COMMENT '0=percentage, 1=site pricing',
  `action_percentage` decimal(5,2) NOT NULL,
  `action_sitepricing` int(5) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discounts-levels_products`
--

/*DROP TABLE IF EXISTS `discounts-levels_products`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discounts-levels_products` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `discount_level_id` int(5) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `discount_level_id` (`discount_level_id`,`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2212 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discounts_advantages`
--

/*DROP TABLE IF EXISTS `discounts_advantages`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discounts_advantages` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `discount_id` int(10) NOT NULL,
  `advantage_type_id` int(5) NOT NULL,
  `flat_amount` decimal(10,2) NOT NULL,
  `percentage_amount` decimal(6,2) NOT NULL,
  `product_qty` int(3) NOT NULL,
  `apply_shipping_id` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `discount_id` (`discount_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15884 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discounts_advantages_products`
--

/*DROP TABLE IF EXISTS `discounts_advantages_products`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discounts_advantages_products` (
  `advantage_id` int(20) NOT NULL,
  `product_id` int(10) NOT NULL,
  KEY `advantage_id` (`advantage_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discounts_rules`
--

/*DROP TABLE IF EXISTS `discounts_rules`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discounts_rules` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `discount_id` int(10) NOT NULL,
  `rule_type_id` int(4) NOT NULL,
  `required_cart_value` decimal(10,2) NOT NULL,
  `required_product_qty` int(8) NOT NULL,
  `required_code` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `discount_id` (`discount_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15894 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discounts_rules_products`
--

/*DROP TABLE IF EXISTS `discounts_rules_products`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discounts_rules_products` (
  `rule_id` int(20) NOT NULL,
  `product_id` int(10) NOT NULL,
  UNIQUE KEY `rule_id_2` (`rule_id`,`product_id`),
  KEY `rule_id` (`rule_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `display_layouts`
--

/*DROP TABLE IF EXISTS `display_layouts`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `display_layouts` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `file` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `display_sections`
--

/*DROP TABLE IF EXISTS `display_sections`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `display_sections` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(35) NOT NULL,
  `display` varchar(55) NOT NULL,
  `rank` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `display_templates`
--

/*DROP TABLE IF EXISTS `display_templates`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `display_templates` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `type_id` int(3) NOT NULL,
  `name` varchar(55) NOT NULL,
  `include` varchar(255) NOT NULL,
  `image_width` varchar(10) NOT NULL,
  `image_height` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `display_templates_index_1` (`include`,`image_width`,`image_height`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `display_templates_types`
--

/*DROP TABLE IF EXISTS `display_templates_types`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `display_templates_types` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `display_themes`
--

/*DROP TABLE IF EXISTS `display_themes`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `display_themes` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(35) NOT NULL,
  `folder` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `distributors`
--

/*DROP TABLE IF EXISTS `distributors`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `distributors` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `email` varchar(85) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `account_no` varchar(35) NOT NULL,
  `is_dropshipper` tinyint(1) NOT NULL,
  `inventory_account_id` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `distributors_availabilities`
--

/*DROP TABLE IF EXISTS `distributors_availabilities`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `distributors_availabilities` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `distributor_id` int(5) NOT NULL,
  `availability_id` int(5) NOT NULL,
  `display` varchar(55) DEFAULT NULL,
  `qty_min` decimal(8,2) DEFAULT NULL,
  `qty_max` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `distavail` (`distributor_id`,`availability_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `distributors_canadapost`
--

/*DROP TABLE IF EXISTS `distributors_canadapost`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `distributors_canadapost` (
  `distributor_id` int(10) NOT NULL,
  `username` varchar(55) NOT NULL,
  `customer_number` varchar(55) NOT NULL,
  `contract_id` varchar(35) NOT NULL,
  `password` varchar(35) NOT NULL,
  `company` varchar(55) NOT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state_id` int(3) NOT NULL,
  `postal_code` varchar(55) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `country_id` int(5) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `email` varchar(65) NOT NULL,
  `package_type` varchar(30) NOT NULL,
  `default_weight` decimal(5,1) NOT NULL,
  `test` tinyint(5) NOT NULL,
  `discount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `label_creation` tinyint(1) NOT NULL,
  `quote_type` tinyint(1) NOT NULL COMMENT '0=commerical, 1=counter',
  `promo_code` varchar(35) NOT NULL,
  PRIMARY KEY (`distributor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `distributors_endicia`
--

/*DROP TABLE IF EXISTS `distributors_endicia`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `distributors_endicia` (
  `distributor_id` int(10) NOT NULL,
  `requester_id` varchar(55) NOT NULL,
  `account_id` varchar(55) NOT NULL,
  `pass_phrase` varchar(100) NOT NULL,
  `company` varchar(55) NOT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state_id` int(3) NOT NULL,
  `postal_code` varchar(55) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `country_id` int(5) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `email` varchar(65) NOT NULL,
  `package_type` varchar(30) NOT NULL DEFAULT 'Parcel',
  `default_weight` decimal(5,1) NOT NULL,
  `test` tinyint(5) NOT NULL,
  `discount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `label_creation` tinyint(1) NOT NULL,
  `default_label_size` int(5) NOT NULL,
  `default_label_rotate` tinyint(1) NOT NULL,
  `destconfirm_label_size` int(5) NOT NULL,
  `destconfirm_label_rotate` tinyint(1) NOT NULL,
  `certified_label_size` int(5) NOT NULL,
  `certified_label_rotate` tinyint(1) NOT NULL,
  `international_label_size` int(5) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `distributors_fedex`
--

/*DROP TABLE IF EXISTS `distributors_fedex`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `distributors_fedex` (
  `distributor_id` int(10) NOT NULL,
  `accountno` varchar(55) NOT NULL,
  `meterno` varchar(55) NOT NULL,
  `keyword` varchar(35) NOT NULL,
  `pass` varchar(35) NOT NULL,
  `company` varchar(55) NOT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state_id` int(3) NOT NULL,
  `postal_code` varchar(55) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `country_id` int(5) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `email` varchar(65) NOT NULL,
  `package_type` varchar(30) NOT NULL,
  `default_weight` decimal(5,1) NOT NULL,
  `test` tinyint(5) NOT NULL,
  `discount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `label_creation` tinyint(1) NOT NULL,
  `rate_type` tinyint(1) NOT NULL COMMENT '0=account, 1=list',
  PRIMARY KEY (`distributor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `distributors_genericshipping`
--

/*DROP TABLE IF EXISTS `distributors_genericshipping`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `distributors_genericshipping` (
  `distributor_id` int(10) NOT NULL,
  `company` varchar(55) NOT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state_id` int(3) NOT NULL,
  `postal_code` varchar(55) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `country_id` int(5) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `email` varchar(65) NOT NULL,
  PRIMARY KEY (`distributor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `distributors_shipping_flatrates`
--

/*DROP TABLE IF EXISTS `distributors_shipping_flatrates`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `distributors_shipping_flatrates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `distributor_shippingmethod_id` int(10) NOT NULL,
  `start_weight` decimal(8,2) NOT NULL,
  `end_weight` decimal(8,2) NOT NULL,
  `shipto_country` int(5) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `flat_price` decimal(8,2) NOT NULL,
  `handling_fee` decimal(8,2) NOT NULL,
  `call_for_estimate` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `distributor_id` (`distributor_shippingmethod_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `distributors_shipping_gateways`
--

/*DROP TABLE IF EXISTS `distributors_shipping_gateways`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `distributors_shipping_gateways` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `distributor_id` int(10) NOT NULL,
  `shipping_gateway_id` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `distship` (`distributor_id`,`shipping_gateway_id`),
  KEY `distributor_id` (`distributor_id`,`shipping_gateway_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `distributors_shipping_methods`
--

/*DROP TABLE IF EXISTS `distributors_shipping_methods`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `distributors_shipping_methods` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `distributor_id` int(10) NOT NULL,
  `shipping_method_id` int(5) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `distributors_shipstation`
--

/*DROP TABLE IF EXISTS `distributors_shipstation`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `distributors_shipstation` (
  `distributor_id` int(10) NOT NULL,
  `api_key` varchar(55) NOT NULL,
  `api_secret` varchar(55) NOT NULL,
  `company` varchar(55) NOT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state_id` int(3) NOT NULL,
  `postal_code` varchar(55) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `country_id` int(5) NOT NULL,
  `is_residential` tinyint(1) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `email` varchar(65) NOT NULL,
  `package_type` varchar(30) NOT NULL DEFAULT 'Parcel',
  `default_weight` decimal(5,1) NOT NULL,
  `test` tinyint(5) NOT NULL,
  `discount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `label_creation` tinyint(1) NOT NULL,
  `delivery_confirmation` tinyint(1) NOT NULL,
  `insured_mail` tinyint(1) NOT NULL,
  `storeid` varchar(35) NOT NULL,
  `nondelivery` tinyint(1) NOT NULL,
  PRIMARY KEY (`distributor_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `distributors_ups`
--

/*DROP TABLE IF EXISTS `distributors_ups`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `distributors_ups` (
  `distributor_id` int(10) NOT NULL,
  `account_no` varchar(35) NOT NULL,
  `company` varchar(85) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(65) NOT NULL,
  `address_1` varchar(85) NOT NULL,
  `address_2` varchar(85) NOT NULL,
  `city` varchar(35) NOT NULL,
  `state_id` int(5) NOT NULL,
  `postal_code` varchar(15) NOT NULL,
  `country_id` int(5) NOT NULL,
  `license_number` varchar(35) NOT NULL,
  `user_id` varchar(35) NOT NULL,
  `password` varchar(35) NOT NULL,
  `label_creation` tinyint(1) NOT NULL,
  PRIMARY KEY (`distributor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `distributors_usps`
--

/*DROP TABLE IF EXISTS `distributors_usps`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `distributors_usps` (
  `distributor_id` int(10) NOT NULL,
  `company` varchar(85) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(65) NOT NULL,
  `address_1` varchar(85) NOT NULL,
  `address_2` varchar(85) NOT NULL,
  `city` varchar(35) NOT NULL,
  `state_id` int(5) NOT NULL,
  `postal_code` varchar(15) NOT NULL,
  `country_id` int(5) NOT NULL,
  `user_id` varchar(35) NOT NULL,
  `password` varchar(35) NOT NULL,
  `label_creation` tinyint(1) NOT NULL,
  PRIMARY KEY (`distributor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `elements`
--

/*DROP TABLE IF EXISTS `elements`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `elements` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(155) NOT NULL,
  `notes` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `events`
--

/*DROP TABLE IF EXISTS `events`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `sdate` datetime NOT NULL,
  `edate` datetime NOT NULL,
  `timezone` varchar(155) NOT NULL DEFAULT 'UTC',
  `created` datetime NOT NULL,
  `createdby` int(10) NOT NULL,
  `photo` int(20) NOT NULL,
  `type` tinyint(3) NOT NULL,
  `type_id` int(10) NOT NULL,
  `city` varchar(35) NOT NULL,
  `state` varchar(2) NOT NULL,
  `country` varchar(2) NOT NULL,
  `webaddress` varchar(255) NOT NULL,
  `email` varchar(65) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `views` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `events_toattend`
--

/*DROP TABLE IF EXISTS `events_toattend`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events_toattend` (
  `userid` int(10) NOT NULL,
  `eventid` int(20) NOT NULL,
  UNIQUE KEY `userid_2` (`userid`,`eventid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `events_types`
--

/*DROP TABLE IF EXISTS `events_types`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events_types` (
  `id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `events_views`
--

/*DROP TABLE IF EXISTS `events_views`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events_views` (
  `event_id` int(20) NOT NULL,
  `account_id` int(10) NOT NULL,
  `viewed_date` date NOT NULL,
  `viewed_time` time NOT NULL,
  KEY `event_id` (`event_id`,`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `faqs`
--

/*DROP TABLE IF EXISTS `faqs`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faqs` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `rank` int(5) NOT NULL,
  `url` varchar(85) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `faqs-categories`
--

/*DROP TABLE IF EXISTS `faqs-categories`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faqs-categories` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `rank` int(5) NOT NULL,
  `url` varchar(85) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `faqs-categories_translations`
--

/*DROP TABLE IF EXISTS `faqs-categories_translations`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faqs-categories_translations` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `categories_id` int(10) NOT NULL,
  `language_id` int(5) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_id_2` (`categories_id`,`language_id`),
  KEY `language_id` (`language_id`),
  KEY `content_id` (`categories_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `faqs_categories`
--

/*DROP TABLE IF EXISTS `faqs_categories`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faqs_categories` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `faqs_id` int(10) NOT NULL,
  `categories_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_id_2` (`faqs_id`,`categories_id`),
  KEY `language_id` (`categories_id`),
  KEY `content_id` (`faqs_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `faqs_translations`
--

/*DROP TABLE IF EXISTS `faqs_translations`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faqs_translations` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `faqs_id` int(10) NOT NULL,
  `language_id` int(5) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_id_2` (`faqs_id`,`language_id`),
  KEY `language_id` (`language_id`),
  KEY `content_id` (`faqs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `files`
--

/*DROP TABLE IF EXISTS `files`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `caption` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filetype` varchar(55) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `filters`
--

/*DROP TABLE IF EXISTS `filters`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `filters` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `label` varchar(55) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `rank` int(3) NOT NULL,
  `show_in_search` tinyint(1) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '0=avail, 1=price, 2=attributes, 3=brands, 4=product types, 5=option values',
  `field_type` tinyint(1) NOT NULL COMMENT '0=select,1=checkboxes',
  `override_parent` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `filters_attributes`
--

/*DROP TABLE IF EXISTS `filters_attributes`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `filters_attributes` (
  `attribute_id` int(10) NOT NULL,
  `filter_id` int(5) NOT NULL,
  `label` varchar(55) NOT NULL,
  `rank` int(3) NOT NULL,
  `status` tinyint(1) NOT NULL,
  UNIQUE KEY `attribute_id` (`attribute_id`,`filter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `filters_availabilities`
--

/*DROP TABLE IF EXISTS `filters_availabilities`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `filters_availabilities` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `avail_ids` varchar(30) NOT NULL,
  `filter_id` int(5) NOT NULL,
  `label` varchar(55) NOT NULL,
  `rank` int(3) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `filters_categories`
--

/*DROP TABLE IF EXISTS `filters_categories`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `filters_categories` (
  `filter_id` int(5) NOT NULL,
  `category_id` int(10) NOT NULL,
  UNIQUE KEY `filter_id` (`filter_id`,`category_id`),
  KEY `filter_id_2` (`filter_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `filters_pricing`
--

/*DROP TABLE IF EXISTS `filters_pricing`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `filters_pricing` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `filter_id` int(5) NOT NULL,
  `label` varchar(55) NOT NULL,
  `rank` int(3) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `price_min` decimal(8,2) DEFAULT NULL,
  `price_max` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `filter_id` (`filter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `filters_productoptions`
--

/*DROP TABLE IF EXISTS `filters_productoptions`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `filters_productoptions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(85) NOT NULL,
  `filter_id` int(5) NOT NULL,
  `label` varchar(55) NOT NULL,
  `rank` int(3) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `optionfilter` (`option_name`,`filter_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `friend_requests`
--

/*DROP TABLE IF EXISTS `friend_requests`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friend_requests` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL,
  `friend_id` int(10) NOT NULL,
  `note` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userid` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1945 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `friends`
--

/*DROP TABLE IF EXISTS `friends`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friends` (
  `account_id` int(10) NOT NULL,
  `friend_id` int(10) NOT NULL,
  `rank` int(5) NOT NULL,
  `added` datetime NOT NULL,
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `friends_updates`
--

/*DROP TABLE IF EXISTS `friends_updates`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friends_updates` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `friend_id` int(10) NOT NULL,
  `type` tinyint(3) NOT NULL,
  `type_id` int(20) NOT NULL,
  `num` int(5) NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `friend_id` (`friend_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16260 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `friends_updates_types`
--

/*DROP TABLE IF EXISTS `friends_updates_types`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friends_updates_types` (
  `id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gift_cards`
--

/*DROP TABLE IF EXISTS `gift_cards`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gift_cards` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `card_code` varchar(16) NOT NULL,
  `card_exp` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `account_id` int(10) NOT NULL,
  `email` varchar(85) NOT NULL,
  `site_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `card_code` (`card_code`,`card_exp`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gift_cards_transactions`
--

/*DROP TABLE IF EXISTS `gift_cards_transactions`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gift_cards_transactions` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `giftcard_id` int(20) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `action` tinyint(1) NOT NULL COMMENT '0=credit,1=debit',
  `notes` varchar(85) NOT NULL,
  `admin_user_id` int(5) NOT NULL,
  `order_id` int(10) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `giftcard_id` (`giftcard_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `giftregistry`
--

/*DROP TABLE IF EXISTS `giftregistry`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `giftregistry` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL,
  `registry_name` varchar(100) NOT NULL,
  `registry_type` tinyint(3) NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `event_date` datetime NOT NULL,
  `public_private` tinyint(1) NOT NULL,
  `private_key` varchar(55) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `shipto_id` int(10) NOT NULL,
  `notes_to_friends` text NOT NULL,
  `registrant_name` varchar(155) NOT NULL,
  `coregistrant_name` varchar(155) NOT NULL,
  `baby_duedate` date NOT NULL,
  `baby_gender` tinyint(1) NOT NULL COMMENT '0=male;1=female',
  `baby_name` char(85) NOT NULL,
  `baby_firstchild` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `giftregistry_genders`
--

/*DROP TABLE IF EXISTS `giftregistry_genders`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `giftregistry_genders` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `giftregistry_items`
--

/*DROP TABLE IF EXISTS `giftregistry_items`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `giftregistry_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registry_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `parent_product` int(10) NOT NULL,
  `added` datetime NOT NULL,
  `qty_wanted` decimal(8,2) NOT NULL,
  `qty_purchased` decimal(8,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `registry_id` (`registry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `giftregistry_items_purchased`
--

/*DROP TABLE IF EXISTS `giftregistry_items_purchased`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `giftregistry_items_purchased` (
  `registry_item_id` int(11) NOT NULL,
  `account_id` int(10) NOT NULL,
  `qty_purchased` decimal(8,2) NOT NULL,
  `order_id` int(10) NOT NULL,
  `order_product_id` int(10) NOT NULL,
  KEY `registry_id` (`registry_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `giftregistry_types`
--

/*DROP TABLE IF EXISTS `giftregistry_types`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `giftregistry_types` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `group_bulletins`
--

/*DROP TABLE IF EXISTS `group_bulletins`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_bulletins` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `group_id` int(10) NOT NULL,
  `subject` varchar(155) NOT NULL,
  `body` text NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`,`createdby`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `group_requests`
--

/*DROP TABLE IF EXISTS `group_requests`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_requests` (
  `group_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `note` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  KEY `group_id` (`group_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `group_updates`
--

/*DROP TABLE IF EXISTS `group_updates`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_updates` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `group_id` int(10) NOT NULL,
  `type` tinyint(3) NOT NULL,
  `type_id` int(20) NOT NULL,
  `updated` datetime NOT NULL,
  `friend_id` int(10) NOT NULL,
  `num` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `group_users`
--

/*DROP TABLE IF EXISTS `group_users`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_users` (
  `group_id` int(10) NOT NULL,
  `user_id` int(20) NOT NULL,
  `joined` datetime NOT NULL,
  `admin` tinyint(1) NOT NULL,
  KEY `group_id` (`group_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `group_views`
--

/*DROP TABLE IF EXISTS `group_views`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_views` (
  `group_id` int(20) NOT NULL,
  `account_id` int(10) NOT NULL,
  `viewed_date` date NOT NULL,
  `viewed_time` time NOT NULL,
  KEY `group_id` (`group_id`,`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `groups`
--

/*DROP TABLE IF EXISTS `groups`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `admin_user` int(10) NOT NULL,
  `description` varchar(255) NOT NULL,
  `photo` int(20) NOT NULL,
  `views` int(10) NOT NULL,
  `featured` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `help_pops`
--

/*DROP TABLE IF EXISTS `help_pops`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `help_pops` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(155) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `images`
--

/*DROP TABLE IF EXISTS `images`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `filename` varchar(155) NOT NULL,
  `default_caption` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `inventory_image_id` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `images_index_1` (`id`,`filename`)
) ENGINE=MyISAM AUTO_INCREMENT=1268 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `images_sizes`
--

/*DROP TABLE IF EXISTS `images_sizes`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images_sizes` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `width` int(5) NOT NULL,
  `height` int(4) NOT NULL,
  `crop` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `instructors_certfiles`
--

/*DROP TABLE IF EXISTS `instructors_certfiles`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instructors_certfiles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_id` int(10) NOT NULL,
  `upload_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6631 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `inventory_gateways`
--

/*DROP TABLE IF EXISTS `inventory_gateways`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory_gateways` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `class_name` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `loadproductsby` tinyint(2) NOT NULL COMMENT '0=date, 1=id',
  `price_fields` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `inventory_gateways_accounts`
--

/*DROP TABLE IF EXISTS `inventory_gateways_accounts`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory_gateways_accounts` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `gateway_id` int(5) NOT NULL,
  `name` varchar(55) NOT NULL,
  `user` varchar(55) NOT NULL,
  `password` varchar(85) NOT NULL,
  `url` varchar(255) NOT NULL,
  `transkey` varchar(500) NOT NULL,
  `last_load` datetime NOT NULL COMMENT 'Last time grabbed new products from gateway',
  `last_load_id` int(10) NOT NULL,
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
  `distributor_id` int(5) NOT NULL,
  `base_currency` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `distributor_id` (`distributor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `inventory_gateways_fields`
--

/*DROP TABLE IF EXISTS `inventory_gateways_fields`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory_gateways_fields` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `gateway_id` int(5) NOT NULL,
  `feed_field` varchar(100) NOT NULL,
  `product_field` varchar(100) NOT NULL,
  `displayorvalue` tinyint(1) NOT NULL COMMENT 'display or value of product field: 0=display, 1=value',
  PRIMARY KEY (`id`),
  KEY `gateway_id` (`gateway_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `inventory_gateways_orders`
--

/*DROP TABLE IF EXISTS `inventory_gateways_orders`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory_gateways_orders` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `gateway_account_id` int(10) NOT NULL,
  `gateway_order_id` varchar(55) NOT NULL,
  `shipment_id` int(10) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `shipment_id` (`shipment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `inventory_gateways_scheduledtasks`
--

/*DROP TABLE IF EXISTS `inventory_gateways_scheduledtasks`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory_gateways_scheduledtasks` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `gateway_account_id` int(5) NOT NULL,
  `task_type` tinyint(3) NOT NULL COMMENT '1=update product prices, 2=update product inventory, 3=load new products',
  `task_start` int(8) NOT NULL,
  `task_startdate` datetime NOT NULL,
  `task_status` tinyint(1) NOT NULL COMMENT '0=waiting, 1=processing',
  `task_modified` int(11) NOT NULL,
  `task_custom_info` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gateway_account_id` (`gateway_account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `inventory_gateways_scheduledtasks_products`
--

/*DROP TABLE IF EXISTS `inventory_gateways_scheduledtasks_products`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory_gateways_scheduledtasks_products` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `task_id` int(10) NOT NULL,
  `products_id` int(20) NOT NULL,
  `products_distributors_id` int(20) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `task_id` (`task_id`),
  KEY `products_id` (`products_id`),
  KEY `products_distributors_id` (`products_distributors_id`),
  KEY `taskproductsdist` (`task_id`,`products_distributors_id`),
  KEY `taskproducts` (`task_id`,`products_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `inventory_gateways_sites`
--

/*DROP TABLE IF EXISTS `inventory_gateways_sites`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory_gateways_sites` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `gateway_account_id` int(10) NOT NULL,
  `site_id` int(5) NOT NULL,
  `update_pricing` tinyint(1) NOT NULL,
  `pricing_adjustment` decimal(8,2) NOT NULL,
  `update_status` tinyint(1) NOT NULL,
  `publish_on_import` tinyint(1) NOT NULL DEFAULT '1',
  `regular_price_field` varchar(55) NOT NULL,
  `sale_price_field` varchar(55) NOT NULL,
  `onsale_formula` tinyint(1) NOT NULL COMMENT '0=none, 1=sale < reg',
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `inventory_rules`
--

/*DROP TABLE IF EXISTS `inventory_rules`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory_rules` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `action` tinyint(2) NOT NULL COMMENT '0=hide, 1=change availability',
  `min_stock_qty` int(5) DEFAULT NULL,
  `max_stock_qty` int(5) DEFAULT NULL,
  `availabity_changeto` int(5) NOT NULL,
  `label` varchar(55) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `availabity_changeto` (`availabity_changeto`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `languages`
--

/*DROP TABLE IF EXISTS `languages`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `languages` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(35) NOT NULL,
  `code` varchar(8) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `languages_content`
--

/*DROP TABLE IF EXISTS `languages_content`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `languages_content` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `msgid` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `msgid` (`msgid`)
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `languages_translations`
--

/*DROP TABLE IF EXISTS `languages_translations`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `languages_translations` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `content_id` int(10) NOT NULL,
  `language_id` int(5) NOT NULL,
  `msgstr` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_id_2` (`content_id`,`language_id`),
  KEY `language_id` (`language_id`),
  KEY `content_id` (`content_id`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `loyaltypoints`
--

/*DROP TABLE IF EXISTS `loyaltypoints`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loyaltypoints` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(85) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `active_level_id` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `loyaltypoints_levels`
--

/*DROP TABLE IF EXISTS `loyaltypoints_levels`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loyaltypoints_levels` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `loyaltypoints_id` int(5) NOT NULL,
  `points_per_dollar` tinyint(3) NOT NULL DEFAULT '1',
  `value_per_point` decimal(5,2) NOT NULL DEFAULT '0.01',
  PRIMARY KEY (`id`),
  KEY `loyaltypoints_id` (`loyaltypoints_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `menu`
--

/*DROP TABLE IF EXISTS `menu`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `parent` int(5) NOT NULL,
  `name` varchar(55) NOT NULL,
  `url` varchar(65) NOT NULL,
  `rank` int(2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=225 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `menus`
--

/*DROP TABLE IF EXISTS `menus`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(35) NOT NULL,
  `url_name` varchar(55) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `menus-links`
--

/*DROP TABLE IF EXISTS `menus-links`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus-links` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `link_type` tinyint(1) NOT NULL COMMENT '1=url, 2=system, 3=javascript',
  `label` varchar(155) NOT NULL,
  `target` enum('_blank','_self','_parent','_top') NOT NULL,
  `url_link` text NOT NULL,
  `system_link` int(3) NOT NULL COMMENT '1=home, 2=contact, 3=myaccount, 4=cart, 5=checkout, 6=wishlist',
  `javascript_link` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `menus_catalogcategories`
--

/*DROP TABLE IF EXISTS `menus_catalogcategories`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus_catalogcategories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `menu_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  `rank` int(5) NOT NULL,
  `submenu_levels` tinyint(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `menus_categories`
--

/*DROP TABLE IF EXISTS `menus_categories`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus_categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `menu_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  `rank` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `menus_links`
--

/*DROP TABLE IF EXISTS `menus_links`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus_links` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `menu_id` int(10) NOT NULL,
  `links_id` int(5) NOT NULL,
  `rank` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `menus_menus`
--

/*DROP TABLE IF EXISTS `menus_menus`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus_menus` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `menu_id` int(10) NOT NULL,
  `child_menu_id` int(10) NOT NULL,
  `rank` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `menus_pages`
--

/*DROP TABLE IF EXISTS `menus_pages`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus_pages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `menu_id` int(10) NOT NULL,
  `page_id` int(10) NOT NULL,
  `rank` int(5) NOT NULL,
  `target` enum('_blank','_self','_parent','_top') NOT NULL DEFAULT '_self',
  `sub_pagemenu_id` int(5) NOT NULL,
  `sub_categorymenu_id` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `menus_sites`
--

/*DROP TABLE IF EXISTS `menus_sites`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus_sites` (
  `menu_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `rank` int(5) NOT NULL,
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `message_templates_new`
--

/*DROP TABLE IF EXISTS `message_templates_new`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message_templates_new` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `alt_body` text NOT NULL,
  `html_body` text NOT NULL,
  `note` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mods_account_ads`
--

/*DROP TABLE IF EXISTS `mods_account_ads`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mods_account_ads` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `link` varchar(500) CHARACTER SET latin1 NOT NULL,
  `img` varchar(155) CHARACTER SET latin1 NOT NULL,
  `clicks` int(10) NOT NULL,
  `shown` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=MyISAM AUTO_INCREMENT=121 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mods_account_ads_campaigns`
--

/*DROP TABLE IF EXISTS `mods_account_ads_campaigns`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mods_account_ads_campaigns` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `lastshown_ad` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mods_account_ads_clicks`
--

/*DROP TABLE IF EXISTS `mods_account_ads_clicks`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mods_account_ads_clicks` (
  `ad_id` int(10) NOT NULL,
  `clicked` datetime NOT NULL,
  KEY `ad_id` (`ad_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mods_account_certifications`
--

/*DROP TABLE IF EXISTS `mods_account_certifications`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mods_account_certifications` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL,
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
  KEY `account_id_2` (`account_id`,`approval_status`)
) ENGINE=InnoDB AUTO_INCREMENT=8233 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mods_account_certifications_files`
--

/*DROP TABLE IF EXISTS `mods_account_certifications_files`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mods_account_certifications_files` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `certification_id` int(10) NOT NULL,
  `filename` varchar(85) NOT NULL,
  `uploaded` datetime NOT NULL,
  `approval_status` tinyint(1) NOT NULL,
  `site_id` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `certification_id` (`certification_id`),
  KEY `certification_id_2` (`certification_id`,`approval_status`)
) ENGINE=InnoDB AUTO_INCREMENT=8244 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mods_account_files`
--

/*DROP TABLE IF EXISTS `mods_account_files`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mods_account_files` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL,
  `filename` varchar(85) NOT NULL,
  `uploaded` datetime NOT NULL,
  `site_id` int(5) NOT NULL,
  `approval_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mods_dates_auto_orderrules`
--

/*DROP TABLE IF EXISTS `mods_dates_auto_orderrules`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mods_dates_auto_orderrules` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mods_dates_auto_orderrules_action`
--

/*DROP TABLE IF EXISTS `mods_dates_auto_orderrules_action`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mods_dates_auto_orderrules_action` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `dao_id` int(10) NOT NULL,
  `criteria_startdatewithindays` int(5) NOT NULL,
  `criteria_orderingruleid` int(10) DEFAULT NULL,
  `criteria_siteid` int(5) DEFAULT NULL,
  `changeto_orderingruleid` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `dao_id` (`dao_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mods_dates_auto_orderrules_excludes`
--

/*DROP TABLE IF EXISTS `mods_dates_auto_orderrules_excludes`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mods_dates_auto_orderrules_excludes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `dao_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_dao` (`product_id`,`dao_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mods_dates_auto_orderrules_products`
--

/*DROP TABLE IF EXISTS `mods_dates_auto_orderrules_products`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mods_dates_auto_orderrules_products` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `dao_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_dao` (`product_id`,`dao_id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mods_lookbooks`
--

/*DROP TABLE IF EXISTS `mods_lookbooks`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mods_lookbooks` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
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
  `galleries_thumbnail` int(10) NOT NULL,
  `plugin_type` enum('tn3','cycle2') NOT NULL DEFAULT 'tn3',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mods_lookbooks_areas`
--

/*DROP TABLE IF EXISTS `mods_lookbooks_areas`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mods_lookbooks_areas` (
  `lookbook_id` int(10) NOT NULL,
  `area_id` int(10) NOT NULL,
  `text` text NOT NULL,
  `use_static` tinyint(4) NOT NULL,
  `timing` decimal(4,1) NOT NULL DEFAULT '1.0',
  `show_thumbs` tinyint(1) NOT NULL DEFAULT '0',
  `show_arrows` tinyint(1) NOT NULL DEFAULT '0',
  KEY `lookbook_id` (`lookbook_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mods_lookbooks_areas_images`
--

/*DROP TABLE IF EXISTS `mods_lookbooks_areas_images`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mods_lookbooks_areas_images` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `temp_id` int(10) NOT NULL,
  `lookbook_id` int(5) NOT NULL,
  `area_id` int(10) NOT NULL,
  `image_id` int(10) NOT NULL,
  `link` varchar(155) NOT NULL,
  `timing` decimal(4,1) NOT NULL DEFAULT '1.0',
  `static` tinyint(1) NOT NULL,
  `rank` tinyint(2) NOT NULL,
  `width` int(5) NOT NULL,
  `height` int(5) NOT NULL,
  `content_title` text NOT NULL,
  `content_desc` text NOT NULL,
  `content_width` varchar(10) NOT NULL,
  `content_top` varchar(10) NOT NULL,
  `content_bottom` varchar(10) NOT NULL,
  `content_left` varchar(10) NOT NULL,
  `content_right` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lookbook_id` (`lookbook_id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mods_lookbooks_images`
--

/*DROP TABLE IF EXISTS `mods_lookbooks_images`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mods_lookbooks_images` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `link` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mods_lookbooks_images_maps`
--

/*DROP TABLE IF EXISTS `mods_lookbooks_images_maps`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mods_lookbooks_images_maps` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `eimage_id` int(10) NOT NULL,
  `shape` tinyint(1) NOT NULL,
  `coord` text NOT NULL,
  `href` varchar(255) NOT NULL,
  `target` tinyint(4) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `popup_position` tinyint(1) NOT NULL,
  `popup_offsetx` int(5) NOT NULL,
  `popup_offsety` int(5) NOT NULL,
  `popup_width` int(5) NOT NULL DEFAULT '200',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mods_pages_viewed`
--

/*DROP TABLE IF EXISTS `mods_pages_viewed`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mods_pages_viewed` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL,
  `page_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mods_resort_details`
--

/*DROP TABLE IF EXISTS `mods_resort_details`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mods_resort_details` (
  `attribute_option_id` int(10) NOT NULL,
  `description` text NOT NULL,
  `comments` text NOT NULL,
  `logo` varchar(80) NOT NULL DEFAULT '',
  `fax` varchar(20) NOT NULL DEFAULT '',
  `contact_addr` varchar(80) NOT NULL DEFAULT '',
  `contact_city` varchar(35) NOT NULL DEFAULT '',
  `contact_state_id` int(3) NOT NULL,
  `contact_zip` varchar(20) NOT NULL DEFAULT '',
  `contact_country_id` int(3) NOT NULL,
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
  `region_id` int(5) NOT NULL,
  `airport_id` int(10) NOT NULL,
  PRIMARY KEY (`attribute_option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mods_resort_details-amenities`
--

/*DROP TABLE IF EXISTS `mods_resort_details-amenities`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mods_resort_details-amenities` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mods_resort_details_amenities`
--

/*DROP TABLE IF EXISTS `mods_resort_details_amenities`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mods_resort_details_amenities` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `resort_details_id` int(10) NOT NULL,
  `amenity_id` int(4) NOT NULL,
  `details` tinyint(2) NOT NULL COMMENT '1=included, 2=addtl cost, 3=available, 4=not available, 5=other',
  PRIMARY KEY (`id`),
  UNIQUE KEY `resort_amenity` (`resort_details_id`,`amenity_id`),
  KEY `resort_id` (`resort_details_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4264 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mods_trip_flyers`
--

/*DROP TABLE IF EXISTS `mods_trip_flyers`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mods_trip_flyers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `orders_products_id` int(20) NOT NULL,
  `position` varchar(85) NOT NULL,
  `logo` varchar(85) DEFAULT NULL,
  `bio` text,
  `name` varchar(85) NOT NULL,
  `approval_status` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `photo_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_products_id` (`orders_products_id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mods_trip_flyers_settings`
--

/*DROP TABLE IF EXISTS `mods_trip_flyers_settings`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mods_trip_flyers_settings` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL,
  `photo_id` int(10) NOT NULL,
  `bio` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `modules`
--

/*DROP TABLE IF EXISTS `modules`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `file` varchar(155) NOT NULL,
  `config_values` text NOT NULL,
  `description` varchar(255) NOT NULL,
  `showinmenu` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `file` (`file`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `modules-templates`
--

/*DROP TABLE IF EXISTS `modules-templates`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules-templates` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `parent_template_id` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `modules-templates_modules`
--

/*DROP TABLE IF EXISTS `modules-templates_modules`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules-templates_modules` (
  `template_id` int(5) NOT NULL,
  `section_id` int(5) NOT NULL,
  `module_id` int(5) NOT NULL,
  `rank` tinyint(2) NOT NULL,
  `temp_id` int(10) NOT NULL,
  KEY `layout_id` (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `modules-templates_sections`
--

/*DROP TABLE IF EXISTS `modules-templates_sections`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules-templates_sections` (
  `template_id` int(5) NOT NULL,
  `section_id` int(5) NOT NULL,
  `temp_id` int(10) NOT NULL,
  KEY `layout_id` (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `modules_admin_controllers`
--

/*DROP TABLE IF EXISTS `modules_admin_controllers`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules_admin_controllers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `module_id` int(5) NOT NULL,
  `controller_section` varchar(155) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module_id` (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `modules_crons`
--

/*DROP TABLE IF EXISTS `modules_crons`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules_crons` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `module_id` int(5) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `function` varchar(55) NOT NULL,
  `last_run` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `module_id` (`module_id`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `modules_crons_scheduledtasks`
--

/*DROP TABLE IF EXISTS `modules_crons_scheduledtasks`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules_crons_scheduledtasks` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `task_type` int(10) NOT NULL COMMENT '1=update product prices, 2=update product inventory, 3=load new products',
  `task_start` int(8) NOT NULL,
  `task_startdate` datetime NOT NULL,
  `task_status` tinyint(1) NOT NULL COMMENT '0=waiting, 1=processing',
  `task_remaining` int(10) NOT NULL,
  `task_modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `modules_fields`
--

/*DROP TABLE IF EXISTS `modules_fields`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules_fields` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `module_id` int(10) NOT NULL,
  `field_name` varchar(85) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module_id` (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `modules_site_controllers`
--

/*DROP TABLE IF EXISTS `modules_site_controllers`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules_site_controllers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `module_id` int(5) NOT NULL,
  `controller_section` varchar(155) CHARACTER SET utf8 NOT NULL,
  `showinmenu` tinyint(1) NOT NULL,
  `menu_label` varchar(55) NOT NULL,
  `menu_link` varchar(85) NOT NULL,
  `url_name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module_id` (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `newsletters`
--

/*DROP TABLE IF EXISTS `newsletters`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsletters` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `description` text NOT NULL,
  `url_name` varchar(65) NOT NULL,
  `from_name` varchar(55) NOT NULL,
  `from_email` varchar(85) NOT NULL,
  `show_in_checkout` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `newsletters_history`
--

/*DROP TABLE IF EXISTS `newsletters_history`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsletters_history` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `newsletter_id` int(10) NOT NULL,
  `subject` varchar(155) NOT NULL,
  `body` text NOT NULL,
  `sent` datetime NOT NULL,
  `subscribers_no` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `newsletter_id` (`newsletter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `newsletters_sites`
--

/*DROP TABLE IF EXISTS `newsletters_sites`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsletters_sites` (
  `newsletter_id` int(5) NOT NULL,
  `site_id` int(5) NOT NULL,
  KEY `newsletter_id` (`newsletter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `newsletters_subscribers`
--

/*DROP TABLE IF EXISTS `newsletters_subscribers`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsletters_subscribers` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `newsletter_id` int(5) NOT NULL,
  `name` varchar(85) NOT NULL,
  `email` varchar(85) NOT NULL,
  `joined` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `newsletter_id` (`newsletter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `options_templates`
--

/*DROP TABLE IF EXISTS `options_templates`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `options_templates` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `options_templates_images`
--

/*DROP TABLE IF EXISTS `options_templates_images`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `options_templates_images` (
  `template_id` int(5) NOT NULL,
  `image_id` int(10) NOT NULL,
  KEY `template_id` (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `options_templates_options`
--

/*DROP TABLE IF EXISTS `options_templates_options`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `options_templates_options` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `display` varchar(100) NOT NULL,
  `type_id` int(5) NOT NULL,
  `show_with_thumbnail` tinyint(1) NOT NULL,
  `rank` int(3) NOT NULL,
  `required` tinyint(1) NOT NULL,
  `template_id` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `product_id` (`template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `options_templates_options_custom`
--

/*DROP TABLE IF EXISTS `options_templates_options_custom`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `options_templates_options_custom` (
  `value_id` int(10) NOT NULL,
  `custom_type` tinyint(1) NOT NULL COMMENT '0=text, 1=textarea, 2=color',
  `custom_charlimit` int(5) NOT NULL,
  `custom_label` varchar(35) NOT NULL,
  `custom_instruction` varchar(255) NOT NULL,
  UNIQUE KEY `value_id` (`value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `options_templates_options_values`
--

/*DROP TABLE IF EXISTS `options_templates_options_values`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `options_templates_options_values` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `option_id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `display` varchar(100) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `rank` int(3) NOT NULL,
  `image_id` int(10) NOT NULL,
  `is_custom` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `option_id` (`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `orders-statuses`
--

/*DROP TABLE IF EXISTS `orders-statuses`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders-statuses` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `rank` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orders_activities`
--

/*DROP TABLE IF EXISTS `orders_activities`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders_activities` (
  `order_id` int(20) NOT NULL,
  `user_id` int(5) NOT NULL,
  `description` varchar(400) NOT NULL,
  `created` datetime NOT NULL,
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orders_billing`
--

/*DROP TABLE IF EXISTS `orders_billing`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders_billing` (
  `order_id` int(20) NOT NULL,
  `bill_company` varchar(85) NOT NULL,
  `bill_first_name` varchar(35) NOT NULL,
  `bill_last_name` varchar(35) NOT NULL,
  `bill_address_1` varchar(85) NOT NULL,
  `bill_address_2` varchar(85) NOT NULL,
  `bill_city` varchar(35) NOT NULL,
  `bill_state_id` int(5) NOT NULL,
  `bill_country_id` int(5) NOT NULL,
  `bill_postal_code` varchar(15) NOT NULL,
  `bill_phone` varchar(15) NOT NULL,
  `bill_email` varchar(85) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orders_customforms`
--

/*DROP TABLE IF EXISTS `orders_customforms`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders_customforms` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `order_id` int(10) NOT NULL,
  `form_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `product_type_id` int(10) NOT NULL,
  `form_count` int(4) NOT NULL,
  `form_values` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10752 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orders_discounts`
--

/*DROP TABLE IF EXISTS `orders_discounts`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders_discounts` (
  `order_id` int(20) NOT NULL,
  `discount_id` int(10) NOT NULL,
  `amount` varchar(12) NOT NULL,
  `advantage_id` int(20) NOT NULL,
  `id` int(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=753 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `orders_notes`
--

/*DROP TABLE IF EXISTS `orders_notes`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders_notes` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `order_id` int(20) NOT NULL,
  `user_id` int(5) NOT NULL,
  `note` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12615 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orders_packages`
--

/*DROP TABLE IF EXISTS `orders_packages`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders_packages` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `shipment_id` int(20) NOT NULL,
  `package_type` int(3) NOT NULL,
  `package_size` int(5) NOT NULL,
  `is_dryice` tinyint(1) NOT NULL,
  `dryice_weight` decimal(5,1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `shipment_id` (`shipment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11076 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orders_products`
--

/*DROP TABLE IF EXISTS `orders_products`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders_products` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `order_id` int(20) NOT NULL,
  `product_id` int(10) NOT NULL,
  `product_qty` int(5) NOT NULL,
  `product_price` decimal(8,2) NOT NULL,
  `product_notes` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `product_saleprice` decimal(8,2) NOT NULL,
  `product_onsale` tinyint(1) NOT NULL,
  `actual_product_id` int(10) NOT NULL,
  `package_id` int(20) NOT NULL,
  `parent_product_id` int(20) NOT NULL COMMENT 'If accessory showing as option, id of product that this should show under',
  `cart_id` int(20) NOT NULL COMMENT 'unique id in cart',
  `product_label` varchar(155) NOT NULL,
  `registry_item_id` int(11) NOT NULL,
  `free_from_discount_advantage` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`,`product_id`,`package_id`),
  KEY `package_id` (`package_id`),
  KEY `actual_product_id` (`actual_product_id`),
  KEY `order_id_2` (`order_id`),
  KEY `product_id` (`product_id`),
  KEY `order_id_3` (`order_id`,`product_id`,`actual_product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16974 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orders_products_customfields`
--

/*DROP TABLE IF EXISTS `orders_products_customfields`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders_products_customfields` (
  `orders_products_id` int(20) NOT NULL,
  `form_id` int(10) NOT NULL,
  `section_id` int(10) NOT NULL,
  `field_id` int(10) NOT NULL,
  `value` text NOT NULL,
  UNIQUE KEY `orders_products_id_2` (`orders_products_id`,`form_id`,`section_id`,`field_id`),
  KEY `orders_products_id` (`orders_products_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orders_products_customsinfo`
--

/*DROP TABLE IF EXISTS `orders_products_customsinfo`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders_products_customsinfo` (
  `orders_products_id` int(20) NOT NULL,
  `customs_description` varchar(255) NOT NULL,
  `customs_weight` decimal(5,2) NOT NULL,
  `customs_value` decimal(8,2) NOT NULL,
  UNIQUE KEY `orders_products_id` (`orders_products_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orders_products_discounts`
--

/*DROP TABLE IF EXISTS `orders_products_discounts`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders_products_discounts` (
  `orders_products_id` int(20) NOT NULL,
  `discount_id` int(10) NOT NULL,
  `advantage_id` int(10) NOT NULL,
  `amount` varchar(12) NOT NULL,
  `qty` int(6) NOT NULL,
  `id` int(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `orders_products_id` (`orders_products_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orders_products_options`
--

/*DROP TABLE IF EXISTS `orders_products_options`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders_products_options` (
  `orders_products_id` int(20) NOT NULL,
  `value_id` int(20) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `custom_value` text NOT NULL,
  KEY `orders_products_id` (`orders_products_id`),
  KEY `orders_products_id_2` (`orders_products_id`),
  KEY `orders_products_id_3` (`orders_products_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orders_products_sentemails`
--

/*DROP TABLE IF EXISTS `orders_products_sentemails`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders_products_sentemails` (
  `op_id` int(10) NOT NULL,
  `email_id` int(10) NOT NULL,
  KEY `email_id` (`email_id`),
  KEY `op_id` (`op_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orders_shipments`
--

/*DROP TABLE IF EXISTS `orders_shipments`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders_shipments` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `order_id` int(20) NOT NULL,
  `distributor_id` int(10) NOT NULL,
  `ship_method_id` int(4) NOT NULL,
  `order_status_id` int(4) NOT NULL DEFAULT '1',
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
  `signature_required` int(2) NOT NULL,
  `cod` tinyint(1) NOT NULL,
  `cod_amount` decimal(10,2) NOT NULL,
  `cod_currency` int(2) NOT NULL,
  `insured` tinyint(1) NOT NULL,
  `insured_value` decimal(10,2) NOT NULL,
  `archived` tinyint(1) NOT NULL COMMENT '0 = active, 1 = archived',
  `inventory_order_id` varchar(35) NOT NULL,
  `registry_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`,`ship_method_id`),
  KEY `distributor_id` (`distributor_id`),
  KEY `archived` (`archived`)
) ENGINE=InnoDB AUTO_INCREMENT=11070 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orders_shipments_labels`
--

/*DROP TABLE IF EXISTS `orders_shipments_labels`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders_shipments_labels` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `shipment_id` int(10) NOT NULL,
  `package_id` int(10) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `label_size_id` int(5) NOT NULL,
  `gateway_label_id` varchar(55) NOT NULL,
  `tracking_no` varchar(65) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `filename` (`filename`),
  KEY `shipment_id` (`shipment_id`),
  KEY `package_id` (`package_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orders_shipping`
--

/*DROP TABLE IF EXISTS `orders_shipping`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders_shipping` (
  `order_id` int(20) NOT NULL,
  `ship_company` varchar(155) NOT NULL,
  `ship_first_name` varchar(35) NOT NULL,
  `ship_last_name` varchar(35) NOT NULL,
  `ship_address_1` varchar(85) NOT NULL,
  `ship_address_2` varchar(85) NOT NULL,
  `ship_city` varchar(35) NOT NULL,
  `ship_state_id` int(5) NOT NULL,
  `ship_country_id` int(5) NOT NULL,
  `ship_postal_code` varchar(15) NOT NULL,
  `ship_email` varchar(85) NOT NULL,
  `ship_phone` varchar(15) NOT NULL,
  `is_residential` tinyint(1) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orders_tasks`
--

/*DROP TABLE IF EXISTS `orders_tasks`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders_tasks` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `order_id` int(10) NOT NULL,
  `message` text NOT NULL,
  `priority` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orders_transactions`
--

/*DROP TABLE IF EXISTS `orders_transactions`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders_transactions` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `order_id` int(20) NOT NULL,
  `transaction_no` varchar(35) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `original_amount` decimal(10,2) NOT NULL,
  `cc_no` varchar(4) NOT NULL,
  `cc_exp` date NOT NULL,
  `notes` text NOT NULL,
  `status` tinyint(2) NOT NULL COMMENT '1 = Authorized, 2 = Captured, 3 = Voided',
  `account_billing_id` int(10) NOT NULL,
  `payment_method_id` int(4) NOT NULL,
  `gateway_account_id` int(5) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `cim_payment_profile_id` int(20) NOT NULL,
  `capture_on_shipment` int(10) NOT NULL,
  `voided_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12483 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orders_transactions_billing`
--

/*DROP TABLE IF EXISTS `orders_transactions_billing`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders_transactions_billing` (
  `orders_transactions_id` int(20) NOT NULL,
  `bill_first_name` varchar(35) NOT NULL,
  `bill_last_name` varchar(35) NOT NULL,
  `bill_address_1` varchar(85) NOT NULL,
  `bill_address_2` varchar(85) NOT NULL,
  `bill_city` varchar(35) NOT NULL,
  `bill_state_id` int(3) NOT NULL,
  `bill_postal_code` varchar(15) NOT NULL,
  `bill_country_id` int(3) NOT NULL,
  `bill_phone` varchar(15) NOT NULL,
  PRIMARY KEY (`orders_transactions_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orders_transactions_credits`
--

/*DROP TABLE IF EXISTS `orders_transactions_credits`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders_transactions_credits` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `orders_transactions_id` int(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `recorded` datetime NOT NULL,
  `transaction_id` varchar(35) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_transactions_id` (`orders_transactions_id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orders_transactions_statuses`
--

/*DROP TABLE IF EXISTS `orders_transactions_statuses`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders_transactions_statuses` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(35) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pages`
--

/*DROP TABLE IF EXISTS `pages`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `url_name` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `notes` varchar(100) NOT NULL,
  `meta_title` varchar(200) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keywords` varchar(500) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pages-categories`
--

/*DROP TABLE IF EXISTS `pages-categories`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages-categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(35) NOT NULL,
  `url_name` varchar(55) NOT NULL,
  `parent_category_id` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pages-categories_pages`
--

/*DROP TABLE IF EXISTS `pages-categories_pages`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages-categories_pages` (
  `category_id` int(10) NOT NULL,
  `page_id` int(10) NOT NULL,
  `rank` int(5) NOT NULL,
  KEY `menu_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pages_settings`
--

/*DROP TABLE IF EXISTS `pages_settings`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages_settings` (
  `page_id` int(10) NOT NULL,
  `settings_template_id` int(10) NOT NULL,
  `module_template_id` int(5) NOT NULL,
  `layout_id` int(5) NOT NULL,
  `module_custom_values` text NOT NULL,
  `module_override_values` text NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pages_settings_sites`
--

/*DROP TABLE IF EXISTS `pages_settings_sites`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages_settings_sites` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `page_id` int(10) NOT NULL,
  `site_id` int(5) NOT NULL,
  `settings_template_id` int(10) DEFAULT NULL,
  `layout_id` int(5) DEFAULT NULL,
  `module_template_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_id_2` (`page_id`,`site_id`),
  KEY `product_id` (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pages_settings_sites_modulevalues`
--

/*DROP TABLE IF EXISTS `pages_settings_sites_modulevalues`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages_settings_sites_modulevalues` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `page_id` int(10) NOT NULL,
  `site_id` int(5) NOT NULL,
  `section_id` int(10) NOT NULL,
  `module_id` int(10) NOT NULL,
  `field_id` int(10) NOT NULL,
  `custom_value` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_id_3` (`page_id`,`site_id`,`section_id`,`module_id`,`field_id`),
  KEY `product_id` (`page_id`),
  KEY `product_id_2` (`page_id`,`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=247 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pages_settings_templates`
--

/*DROP TABLE IF EXISTS `pages_settings_templates`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages_settings_templates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `layout_id` int(5) DEFAULT NULL,
  `module_template_id` int(5) DEFAULT NULL,
  `settings_template_id` int(5) DEFAULT NULL,
  `module_custom_values` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pages_settings_templates_modulevalues`
--

/*DROP TABLE IF EXISTS `pages_settings_templates_modulevalues`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages_settings_templates_modulevalues` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `settings_template_id` int(5) NOT NULL,
  `section_id` int(10) NOT NULL,
  `module_id` int(10) NOT NULL,
  `field_id` int(10) NOT NULL,
  `custom_value` text,
  PRIMARY KEY (`id`),
  KEY `settings_template_id` (`settings_template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payment_gateways`
--

/*DROP TABLE IF EXISTS `payment_gateways`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_gateways` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `template` varchar(30) NOT NULL,
  `is_creditcard` tinyint(1) NOT NULL DEFAULT '1',
  `classname` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payment_gateways_accounts`
--

/*DROP TABLE IF EXISTS `payment_gateways_accounts`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_gateways_accounts` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `gateway_id` int(5) NOT NULL,
  `name` varchar(55) NOT NULL,
  `login_id` varchar(35) NOT NULL,
  `password` varchar(35) NOT NULL,
  `transaction_key` varchar(255) NOT NULL,
  `use_cvv` tinyint(1) NOT NULL,
  `currency_code` varchar(4) NOT NULL,
  `use_test` tinyint(1) NOT NULL,
  `custom_fields` text NOT NULL,
  `limitby_country` tinyint(1) NOT NULL COMMENT '0=no,1=billing,2=shipping,3=billing not,4=shipping not',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payment_gateways_accounts_limitcountries`
--

/*DROP TABLE IF EXISTS `payment_gateways_accounts_limitcountries`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_gateways_accounts_limitcountries` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `gateway_account_id` int(5) NOT NULL,
  `country_id` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gateway_account_id` (`gateway_account_id`,`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payment_gateways_errors`
--

/*DROP TABLE IF EXISTS `payment_gateways_errors`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_gateways_errors` (
  `created` datetime NOT NULL,
  `response` text NOT NULL,
  `gateway_account_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payment_methods`
--

/*DROP TABLE IF EXISTS `payment_methods`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_methods` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `display` varchar(55) NOT NULL,
  `gateway_id` int(5) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `template` varchar(55) DEFAULT NULL,
  `limitby_country` tinyint(1) NOT NULL COMMENT '0=no,1=billing,2=shipping,3=billing not,4=shipping not',
  `feeby_country` tinyint(1) NOT NULL COMMENT '0=billing, 1=shipping',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payment_methods_limitcountries`
--

/*DROP TABLE IF EXISTS `payment_methods_limitcountries`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_methods_limitcountries` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `payment_method_id` int(5) NOT NULL,
  `country_id` int(5) NOT NULL,
  `fee` decimal(8,4) DEFAULT NULL,
  `limiting` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payment_method_id` (`payment_method_id`,`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `photos`
--

/*DROP TABLE IF EXISTS `photos`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photos` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `added` datetime NOT NULL,
  `addedby` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `img` varchar(100) NOT NULL,
  `album` int(20) NOT NULL,
  `approved` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `album` (`album`),
  KEY `addedby` (`addedby`)
) ENGINE=InnoDB AUTO_INCREMENT=40502 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `photos_albums`
--

/*DROP TABLE IF EXISTS `photos_albums`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photos_albums` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `type` tinyint(1) NOT NULL,
  `type_id` int(20) NOT NULL,
  `recent_photo_id` int(10) NOT NULL,
  `updated` datetime NOT NULL,
  `photos_count` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16252 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `photos_albums_type`
--

/*DROP TABLE IF EXISTS `photos_albums_type`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photos_albums_type` (
  `id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `photos_comments`
--

/*DROP TABLE IF EXISTS `photos_comments`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photos_comments` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `photo_id` int(20) NOT NULL,
  `body` text NOT NULL,
  `account_id` int(10) NOT NULL,
  `created` datetime NOT NULL,
  `beenread` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `photo_id` (`photo_id`),
  KEY `read` (`beenread`)
) ENGINE=InnoDB AUTO_INCREMENT=232 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `photos_favorites`
--

/*DROP TABLE IF EXISTS `photos_favorites`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photos_favorites` (
  `account_id` int(10) NOT NULL,
  `photo_id` int(20) NOT NULL,
  KEY `user_id` (`account_id`,`photo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `photos_sizes`
--

/*DROP TABLE IF EXISTS `photos_sizes`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photos_sizes` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `width` int(5) NOT NULL,
  `height` int(4) NOT NULL,
  `crop` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pricing_rules`
--

/*DROP TABLE IF EXISTS `pricing_rules`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pricing_rules` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pricing_rules_levels`
--

/*DROP TABLE IF EXISTS `pricing_rules_levels`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pricing_rules_levels` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `rule_id` int(10) NOT NULL,
  `min_qty` int(10) NOT NULL,
  `max_qty` int(10) NOT NULL,
  `amount_type` tinyint(1) NOT NULL COMMENT '0=percentage, 1=flat amount',
  `amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rule_id` (`rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products`
--

/*DROP TABLE IF EXISTS `products`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_product` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `default_outofstockstatus_id` int(3) DEFAULT NULL,
  `details_img_id` int(20) NOT NULL,
  `category_img_id` int(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `product_no` varchar(155) NOT NULL,
  `combined_stock_qty` decimal(8,2) NOT NULL,
  `default_cost` decimal(10,4) DEFAULT NULL,
  `weight` decimal(5,2) NOT NULL,
  `created` datetime NOT NULL,
  `default_distributor_id` int(5) DEFAULT NULL,
  `fulfillment_rule_id` int(10) DEFAULT NULL,
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
  FULLTEXT KEY `meta_keywords` (`meta_keywords`),
  FULLTEXT KEY `product_no` (`product_no`),
  FULLTEXT KEY `titleurl` (`url_name`,`title`),
  FULLTEXT KEY `titleurlnosubtitle` (`url_name`,`title`,`product_no`,`subtitle`)
) ENGINE=MyISAM AUTO_INCREMENT=7597 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products-availability`
--

/*DROP TABLE IF EXISTS `products-availability`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products-availability` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `display` varchar(55) DEFAULT NULL,
  `qty_min` decimal(8,2) DEFAULT NULL,
  `qty_max` decimal(8,2) DEFAULT NULL,
  `auto_adjust` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `products-availability_index_1` (`auto_adjust`,`id`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products-children_options`
--

/*DROP TABLE IF EXISTS `products-children_options`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products-children_options` (
  `product_id` int(20) NOT NULL,
  `option_id` int(20) NOT NULL,
  UNIQUE KEY `product_id_2` (`product_id`,`option_id`),
  KEY `product_id` (`product_id`),
  KEY `option_id` (`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products-rules-fulfillment`
--

/*DROP TABLE IF EXISTS `products-rules-fulfillment`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products-rules-fulfillment` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(85) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `any_all` enum('any','all') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products-rules-fulfillment_conditions`
--

/*DROP TABLE IF EXISTS `products-rules-fulfillment_conditions`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products-rules-fulfillment_conditions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `rule_id` int(10) NOT NULL,
  `type` enum('has_stock','logged_in','account_type','shipping_country','shipping_state','shipping_zipcode','stock_greaterthan_qtyordering','has_most_stock') NOT NULL,
  `status` tinyint(1) NOT NULL,
  `any_all` enum('all','any') NOT NULL,
  `target_distributor` int(5) NOT NULL,
  `score` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rule_id` (`rule_id`),
  KEY `type` (`type`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products-rules-fulfillment_conditions_items`
--

/*DROP TABLE IF EXISTS `products-rules-fulfillment_conditions_items`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products-rules-fulfillment_conditions_items` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `condition_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `value` varchar(85) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `condition_id` (`condition_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products-rules-fulfillment_distributors`
--

/*DROP TABLE IF EXISTS `products-rules-fulfillment_distributors`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products-rules-fulfillment_distributors` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `rule_id` int(10) NOT NULL,
  `distributor_id` int(10) NOT NULL,
  `rank` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `parent_rule_id` (`rule_id`,`distributor_id`),
  KEY `rule_id` (`rule_id`),
  KEY `child_rule_id` (`distributor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products-rules-fulfillment_rules`
--

/*DROP TABLE IF EXISTS `products-rules-fulfillment_rules`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products-rules-fulfillment_rules` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_rule_id` int(10) NOT NULL,
  `child_rule_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `parent_rule_id` (`parent_rule_id`,`child_rule_id`),
  KEY `rule_id` (`parent_rule_id`),
  KEY `child_rule_id` (`child_rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products-rules-ordering`
--

/*DROP TABLE IF EXISTS `products-rules-ordering`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products-rules-ordering` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(85) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `any_all` enum('any','all') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `products-rules-ordering_index_1` (`status`,`id`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products-rules-ordering_conditions`
--

/*DROP TABLE IF EXISTS `products-rules-ordering_conditions`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products-rules-ordering_conditions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `rule_id` int(10) NOT NULL,
  `type` enum('required_account','required_account_type','required_account_specialty') NOT NULL,
  `status` tinyint(1) NOT NULL,
  `any_all` enum('all','any') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rule_id` (`rule_id`),
  KEY `type` (`type`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products-rules-ordering_conditions_items`
--

/*DROP TABLE IF EXISTS `products-rules-ordering_conditions_items`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products-rules-ordering_conditions_items` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `condition_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `condition_id` (`condition_id`)
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products-rules-ordering_rules`
--

/*DROP TABLE IF EXISTS `products-rules-ordering_rules`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products-rules-ordering_rules` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_rule_id` int(10) NOT NULL,
  `child_rule_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `parent_rule_id` (`parent_rule_id`,`child_rule_id`),
  KEY `rule_id` (`parent_rule_id`),
  KEY `child_rule_id` (`child_rule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products-types`
--

/*DROP TABLE IF EXISTS `products-types`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products-types` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products-types_attributes-sets`
--

/*DROP TABLE IF EXISTS `products-types_attributes-sets`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products-types_attributes-sets` (
  `type_id` int(10) NOT NULL,
  `set_id` int(10) NOT NULL,
  KEY `type_id` (`type_id`,`set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_accessories`
--

/*DROP TABLE IF EXISTS `products_accessories`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_accessories` (
  `product_id` int(20) NOT NULL,
  `accessory_id` int(20) NOT NULL,
  `required` tinyint(1) NOT NULL,
  `show_as_option` tinyint(1) NOT NULL,
  `discount_percentage` tinyint(3) NOT NULL,
  `description` varchar(255) NOT NULL,
  `link_actions` tinyint(1) NOT NULL,
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_accessories_fields`
--

/*DROP TABLE IF EXISTS `products_accessories_fields`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_accessories_fields` (
  `product_id` int(20) NOT NULL,
  `accessories_fields_id` int(20) NOT NULL,
  `rank` int(3) NOT NULL,
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_attributes`
--

/*DROP TABLE IF EXISTS `products_attributes`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_attributes` (
  `product_id` int(10) NOT NULL,
  `option_id` int(20) NOT NULL,
  UNIQUE KEY `product_id_2` (`product_id`,`option_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_details`
--

/*DROP TABLE IF EXISTS `products_details`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_details` (
  `product_id` int(10) NOT NULL,
  `summary` text NOT NULL,
  `description` text NOT NULL,
  `attributes` text NOT NULL,
  `type_id` int(5) NOT NULL,
  `brand_id` int(5) NOT NULL,
  `rating` decimal(4,1) NOT NULL,
  `views_30days` int(8) NOT NULL,
  `views_90days` int(10) NOT NULL,
  `views_180days` int(10) NOT NULL,
  `views_1year` int(10) NOT NULL,
  `views_all` int(20) NOT NULL,
  `orders_30days` int(6) NOT NULL,
  `orders_90days` int(7) NOT NULL,
  `orders_180days` int(8) NOT NULL,
  `orders_1year` int(10) NOT NULL,
  `orders_all` int(10) NOT NULL,
  `downloadable` tinyint(1) NOT NULL,
  `downloadable_file` varchar(200) NOT NULL,
  `default_category_id` int(10) NOT NULL,
  `orders_updated` datetime NOT NULL,
  `views_updated` datetime NOT NULL,
  `create_children_auto` tinyint(1) NOT NULL,
  `display_children_grid` tinyint(1) NOT NULL,
  `override_parent_description` tinyint(1) NOT NULL,
  `allow_pricing_discount` tinyint(1) NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `brand_id` (`brand_id`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

/*DROP TABLE IF EXISTS `products_distributors`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_distributors` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) NOT NULL,
  `distributor_id` int(5) NOT NULL,
  `stock_qty` decimal(8,2) NOT NULL,
  `outofstockstatus_id` tinyint(3) DEFAULT NULL,
  `cost` decimal(12,4) DEFAULT NULL,
  `inventory_id` varchar(155) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_id_2` (`product_id`,`distributor_id`,`inventory_id`),
  KEY `product_id` (`product_id`),
  KEY `proddist` (`product_id`,`distributor_id`),
  KEY `inventory_id` (`inventory_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7638 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_images`
--

/*DROP TABLE IF EXISTS `products_images`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_images` (
  `product_id` int(10) NOT NULL,
  `image_id` int(10) NOT NULL,
  `caption` varchar(55) NOT NULL,
  `rank` tinyint(2) NOT NULL,
  `show_in_gallery` tinyint(1) NOT NULL DEFAULT '1',
  UNIQUE KEY `prodimage` (`product_id`,`image_id`),
  KEY `product_id` (`product_id`),
  KEY `image_id` (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_log`
--

/*DROP TABLE IF EXISTS `products_log`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_log` (
  `product_id` int(10) NOT NULL,
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `productdistributor_id` int(20) NOT NULL,
  `action_type` tinyint(2) NOT NULL COMMENT '0=stock qty change',
  `changed_from` varchar(85) NOT NULL,
  `changed_to` varchar(85) NOT NULL,
  `logged` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `productdistributor_id` (`productdistributor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_needschildren`
--

/*DROP TABLE IF EXISTS `products_needschildren`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_needschildren` (
  `product_id` int(20) NOT NULL,
  `option_id` int(20) NOT NULL,
  `qty` int(5) NOT NULL,
  `account_level` text NOT NULL,
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_options`
--

/*DROP TABLE IF EXISTS `products_options`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_options` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `display` varchar(100) NOT NULL,
  `type_id` int(5) NOT NULL,
  `show_with_thumbnail` tinyint(1) NOT NULL,
  `rank` int(3) NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '1',
  `product_id` int(10) NOT NULL,
  `is_template` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nametypeidstatus` (`name`,`type_id`,`product_id`,`status`),
  KEY `product_id` (`product_id`),
  KEY `products_options_index_1` (`status`,`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=600 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_options-types`
--

/*DROP TABLE IF EXISTS `products_options-types`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_options-types` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_options_custom`
--

/*DROP TABLE IF EXISTS `products_options_custom`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_options_custom` (
  `value_id` int(10) NOT NULL,
  `custom_type` tinyint(1) NOT NULL COMMENT '0=text, 1=textarea, 2=color',
  `custom_charlimit` int(5) NOT NULL,
  `custom_label` varchar(35) NOT NULL,
  `custom_instruction` varchar(255) NOT NULL,
  UNIQUE KEY `value_id` (`value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_options_values`
--

/*DROP TABLE IF EXISTS `products_options_values`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_options_values` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `option_id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `display` varchar(100) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `rank` int(3) NOT NULL,
  `image_id` int(10) NOT NULL,
  `is_custom` tinyint(1) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `option_id` (`option_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=12060 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_pricing`
--

/*DROP TABLE IF EXISTS `products_pricing`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_pricing` (
  `product_id` int(10) NOT NULL,
  `site_id` int(5) NOT NULL,
  `price_reg` decimal(10,4) NOT NULL,
  `price_sale` decimal(10,4) NOT NULL,
  `onsale` tinyint(1) NOT NULL,
  `min_qty` decimal(8,2) NOT NULL DEFAULT '1.00',
  `max_qty` decimal(8,2) NOT NULL DEFAULT '0.00',
  `feature` tinyint(1) NOT NULL,
  `pricing_rule_id` int(10) NOT NULL,
  `ordering_rule_id` int(5) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `published_date` datetime NOT NULL,
  UNIQUE KEY `prodsite` (`product_id`,`site_id`),
  KEY `status` (`status`),
  KEY `products_pricing_index_1` (`status`,`site_id`,`product_id`,`ordering_rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_pricing_temp`
--

/*DROP TABLE IF EXISTS `products_pricing_temp`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_pricing_temp` (
  `product_id` int(10) NOT NULL,
  `site_id` int(5) NOT NULL,
  `price_reg` decimal(8,2) NOT NULL,
  `price_sale` decimal(8,2) NOT NULL,
  `onsale` tinyint(1) NOT NULL,
  `min_qty` int(10) NOT NULL DEFAULT '1',
  `max_qty` int(10) NOT NULL DEFAULT '0',
  `feature` tinyint(1) NOT NULL,
  `pricing_rule_id` int(10) NOT NULL,
  `ordering_rule_id` int(5) NOT NULL,
  `status` tinyint(1) NOT NULL,
  KEY `product_id` (`product_id`,`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_related`
--

/*DROP TABLE IF EXISTS `products_related`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_related` (
  `product_id` int(10) NOT NULL,
  `related_id` int(10) NOT NULL,
  KEY `product_id` (`product_id`),
  KEY `related_id` (`related_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_resort`
--

/*DROP TABLE IF EXISTS `products_resort`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_resort` (
  `product_id` int(20) NOT NULL,
  `resort_id` int(10) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_reviews`
--

/*DROP TABLE IF EXISTS `products_reviews`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_reviews` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `item_type` tinyint(1) NOT NULL,
  `item_id` int(10) NOT NULL COMMENT 'product or attribute id',
  `name` varchar(85) NOT NULL,
  `comment` text NOT NULL,
  `created` datetime NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `approved` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`item_id`),
  KEY `item_type` (`item_type`,`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2080 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_settings`
--

/*DROP TABLE IF EXISTS `products_settings`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_settings` (
  `product_id` int(10) NOT NULL,
  `settings_template_id` int(10) NOT NULL,
  `product_detail_template` int(5) NOT NULL,
  `product_thumbnail_template` int(5) NOT NULL,
  `product_zoom_template` int(5) NOT NULL,
  `product_related_count` int(3) NOT NULL,
  `product_brands_count` int(3) NOT NULL,
  `product_related_template` int(5) NOT NULL,
  `product_brands_template` int(4) NOT NULL,
  `show_brands_products` tinyint(1) NOT NULL,
  `show_related_products` tinyint(1) NOT NULL,
  `show_specs` tinyint(1) NOT NULL,
  `show_reviews` tinyint(1) NOT NULL,
  `layout_id` int(5) NOT NULL,
  `module_template_id` int(5) NOT NULL,
  `module_custom_values` text NOT NULL,
  `module_override_values` text NOT NULL,
  `use_default_related` tinyint(1) NOT NULL,
  `use_default_brand` tinyint(1) NOT NULL,
  `use_default_specs` tinyint(1) NOT NULL,
  `use_default_reviews` tinyint(1) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_settings_sites`
--

/*DROP TABLE IF EXISTS `products_settings_sites`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_settings_sites` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) NOT NULL,
  `site_id` int(5) NOT NULL,
  `settings_template_id` int(10) DEFAULT NULL,
  `product_detail_template` int(5) DEFAULT NULL,
  `product_thumbnail_template` int(5) DEFAULT NULL,
  `product_zoom_template` int(5) DEFAULT NULL,
  `layout_id` int(5) DEFAULT NULL,
  `module_template_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_id_2` (`product_id`,`site_id`),
  KEY `product_id` (`product_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=523 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_settings_sites_modulevalues`
--

/*DROP TABLE IF EXISTS `products_settings_sites_modulevalues`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_settings_sites_modulevalues` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) NOT NULL,
  `site_id` int(5) NOT NULL,
  `section_id` int(10) NOT NULL,
  `module_id` int(10) NOT NULL,
  `field_id` int(10) NOT NULL,
  `custom_value` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_id_3` (`product_id`,`site_id`,`section_id`,`module_id`,`field_id`),
  KEY `product_id` (`product_id`),
  KEY `product_id_2` (`product_id`,`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_settings_templates`
--

/*DROP TABLE IF EXISTS `products_settings_templates`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_settings_templates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `settings_template_id` int(10) DEFAULT NULL,
  `product_detail_template` int(5) DEFAULT NULL,
  `product_thumbnail_template` int(5) DEFAULT NULL,
  `product_zoom_template` int(5) DEFAULT NULL,
  `layout_id` int(5) DEFAULT NULL,
  `module_template_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_settings_templates_modulevalues`
--

/*DROP TABLE IF EXISTS `products_settings_templates_modulevalues`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_settings_templates_modulevalues` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `settings_template_id` int(5) NOT NULL,
  `section_id` int(10) NOT NULL,
  `module_id` int(10) NOT NULL,
  `field_id` int(10) NOT NULL,
  `custom_value` text,
  PRIMARY KEY (`id`),
  KEY `settings_template_id` (`settings_template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_sorts`
--

/*DROP TABLE IF EXISTS `products_sorts`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_sorts` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `orderby` varchar(55) NOT NULL,
  `sortby` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `rank` int(3) NOT NULL,
  `isdefault` tinyint(1) NOT NULL,
  `display` varchar(55) DEFAULT NULL,
  `categories_only` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_specialties`
--

/*DROP TABLE IF EXISTS `products_specialties`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_specialties` (
  `product_id` int(20) NOT NULL,
  `specialty_id` int(20) NOT NULL,
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_specialties_check`
--

/*DROP TABLE IF EXISTS `products_specialties_check`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_specialties_check` (
  `product_id` int(20) NOT NULL,
  `specialties` varchar(255) NOT NULL,
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_specialtiesaccountsrules`
--

/*DROP TABLE IF EXISTS `products_specialtiesaccountsrules`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_specialtiesaccountsrules` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `accounts` varchar(255) NOT NULL,
  `specialties` varchar(255) NOT NULL,
  `rule_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `accounts` (`accounts`,`specialties`),
  KEY `product_id` (`accounts`)
) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_tasks`
--

/*DROP TABLE IF EXISTS `products_tasks`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_tasks` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) NOT NULL,
  `message` text NOT NULL,
  `priority` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_viewed`
--

/*DROP TABLE IF EXISTS `products_viewed`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_viewed` (
  `product_id` int(20) NOT NULL,
  `viewed` datetime NOT NULL,
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reports`
--

/*DROP TABLE IF EXISTS `reports`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `created` datetime NOT NULL,
  `criteria` text NOT NULL,
  `type_id` tinyint(2) NOT NULL,
  `ready` tinyint(1) NOT NULL,
  `from_date` datetime NOT NULL,
  `to_date` datetime NOT NULL,
  `breakdown` tinyint(2) NOT NULL,
  `restart` int(10) NOT NULL,
  `variables` text NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reports_breakdowns`
--

/*DROP TABLE IF EXISTS `reports_breakdowns`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports_breakdowns` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reports_products_fields`
--

/*DROP TABLE IF EXISTS `reports_products_fields`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports_products_fields` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `reference` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reports_types`
--

/*DROP TABLE IF EXISTS `reports_types`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports_types` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `resorts_amenities`
--

/*DROP TABLE IF EXISTS `resorts_amenities`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resorts_amenities` (
  `resort_id` int(10) NOT NULL,
  `amenity_id` int(4) NOT NULL,
  `details` tinyint(2) NOT NULL COMMENT '1=included, 2=addtl cost, 3=available, 4=not available, 5=other',
  KEY `resort_id` (`resort_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `saved_cart`
--

/*DROP TABLE IF EXISTS `saved_cart`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saved_cart` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=252 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `saved_cart_discounts`
--

/*DROP TABLE IF EXISTS `saved_cart_discounts`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saved_cart_discounts` (
  `saved_cart_id` int(20) NOT NULL,
  `applied_codes_json` longtext NOT NULL,
  `shipping_discounts_json` longtext NOT NULL,
  `order_discounts_json` longtext NOT NULL,
  `product_discounts_json` longtext NOT NULL,
  PRIMARY KEY (`saved_cart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `saved_cart_items`
--

/*DROP TABLE IF EXISTS `saved_cart_items`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saved_cart_items` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `saved_cart_id` int(20) NOT NULL,
  `cart_id` int(5) NOT NULL COMMENT 'cartitem_id to signify row',
  `product_id` int(10) NOT NULL,
  `parent_product` int(10) NOT NULL,
  `parent_cart_id` int(10) NOT NULL,
  `required` int(20) NOT NULL,
  `qty` int(11) NOT NULL,
  `price_reg` decimal(8,2) NOT NULL,
  `price_sale` decimal(8,2) NOT NULL,
  `onsale` tinyint(1) NOT NULL,
  `product_label` varchar(155) NOT NULL,
  `registry_item_id` int(11) NOT NULL,
  `accessory_field_id` int(10) NOT NULL,
  `distributor_id` int(5) NOT NULL,
  `accessory_link_actions` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `saved_cart_id` (`saved_cart_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1186 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `saved_cart_items_customfields`
--

/*DROP TABLE IF EXISTS `saved_cart_items_customfields`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saved_cart_items_customfields` (
  `saved_cart_item_id` int(20) NOT NULL,
  `form_id` int(10) NOT NULL,
  `section_id` int(10) NOT NULL,
  `field_id` int(10) NOT NULL,
  `value` text NOT NULL,
  UNIQUE KEY `saved_cart_item_id` (`saved_cart_item_id`,`form_id`,`section_id`,`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `saved_cart_items_options`
--

/*DROP TABLE IF EXISTS `saved_cart_items_options`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saved_cart_items_options` (
  `saved_cart_item_id` int(20) NOT NULL,
  `options_json` longtext NOT NULL,
  PRIMARY KEY (`saved_cart_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `saved_cart_items_options_customvalues`
--

/*DROP TABLE IF EXISTS `saved_cart_items_options_customvalues`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saved_cart_items_options_customvalues` (
  `saved_cart_item_id` int(20) NOT NULL,
  `option_id` int(10) NOT NULL,
  `custom_value` text NOT NULL,
  UNIQUE KEY `cartitem_option` (`saved_cart_item_id`,`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `saved_order`
--

/*DROP TABLE IF EXISTS `saved_order`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saved_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(20) NOT NULL,
  `account_id` int(10) NOT NULL,
  `saved_cart_id` int(20) NOT NULL,
  `created` datetime NOT NULL,
  `site_id` int(5) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `saved_cart_id` (`saved_cart_id`),
  KEY `unique_id` (`unique_id`)
) ENGINE=InnoDB AUTO_INCREMENT=556 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `saved_order_discounts`
--

/*DROP TABLE IF EXISTS `saved_order_discounts`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saved_order_discounts` (
  `order_id` int(20) NOT NULL,
  `discount_id` int(20) NOT NULL,
  `discount_code` varchar(55) NOT NULL,
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `saved_order_information`
--

/*DROP TABLE IF EXISTS `saved_order_information`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saved_order_information` (
  `order_id` int(20) NOT NULL AUTO_INCREMENT,
  `order_email` varchar(85) NOT NULL,
  `account_billing_id` int(20) NOT NULL,
  `account_shipping_id` int(20) NOT NULL,
  `bill_first_name` varchar(35) NOT NULL,
  `bill_last_name` varchar(35) NOT NULL,
  `bill_address_1` varchar(85) NOT NULL,
  `bill_address_2` varchar(85) NOT NULL,
  `bill_city` varchar(35) NOT NULL,
  `bill_state_id` int(5) NOT NULL,
  `bill_postal_code` varchar(15) NOT NULL,
  `bill_country_id` int(5) NOT NULL,
  `bill_phone` varchar(15) NOT NULL,
  `is_residential` tinyint(1) NOT NULL,
  `ship_company` varchar(155) NOT NULL,
  `ship_first_name` varchar(35) NOT NULL,
  `ship_last_name` varchar(35) NOT NULL,
  `ship_address_1` varchar(85) NOT NULL,
  `ship_address_2` varchar(85) NOT NULL,
  `ship_city` varchar(35) NOT NULL,
  `ship_state_id` int(5) NOT NULL,
  `ship_postal_code` varchar(15) NOT NULL,
  `ship_country_id` int(5) NOT NULL,
  `ship_email` varchar(85) NOT NULL,
  `payment_method_id` int(5) NOT NULL,
  `shipping_method_id` int(5) NOT NULL,
  `step` tinyint(2) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=556 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `search_forms`
--

/*DROP TABLE IF EXISTS `search_forms`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `search_forms` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `search_forms_fields`
--

/*DROP TABLE IF EXISTS `search_forms_fields`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `search_forms_fields` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `display` varchar(255) NOT NULL,
  `type` tinyint(2) NOT NULL COMMENT '0=text, 1=textarea, 2=checkbox, 3=radio, 4=select, 5=selectmultiple, 6=button',
  `search_type` tinyint(1) NOT NULL COMMENT '0=attribute, 1=producttype, 2=membershiplevel',
  `search_id` int(10) NOT NULL,
  `rank` int(5) NOT NULL,
  `cssclass` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `help_element_id` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `search_forms_sections`
--

/*DROP TABLE IF EXISTS `search_forms_sections`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `search_forms_sections` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `form_id` int(5) NOT NULL,
  `title` varchar(155) NOT NULL,
  `rank` int(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `form_id` (`form_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `search_forms_sections_fields`
--

/*DROP TABLE IF EXISTS `search_forms_sections_fields`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `search_forms_sections_fields` (
  `section_id` int(5) NOT NULL,
  `field_id` int(10) NOT NULL,
  `rank` int(3) NOT NULL,
  `new_row` tinyint(1) NOT NULL,
  KEY `section_id` (`section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `search_history`
--

/*DROP TABLE IF EXISTS `search_history`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `search_history` (
  `keywords` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  KEY `keywords` (`keywords`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shipping_carriers`
--

/*DROP TABLE IF EXISTS `shipping_carriers`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shipping_carriers` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `gateway_id` int(5) NOT NULL,
  `name` varchar(35) NOT NULL,
  `classname` varchar(100) NOT NULL,
  `table` varchar(35) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `multipackage_support` tinyint(1) NOT NULL DEFAULT '1',
  `carrier_code` varchar(35) NOT NULL,
  `limit_shipto` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gateway_id` (`gateway_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shipping_carriers_shipto`
--

/*DROP TABLE IF EXISTS `shipping_carriers_shipto`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shipping_carriers_shipto` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `shipping_carriers_id` int(5) NOT NULL,
  `country_id` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `shipping_carriers_id_2` (`shipping_carriers_id`,`country_id`),
  KEY `shipping_carriers_id` (`shipping_carriers_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shipping_gateways`
--

/*DROP TABLE IF EXISTS `shipping_gateways`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shipping_gateways` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(35) NOT NULL,
  `classname` varchar(100) NOT NULL,
  `table` varchar(35) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `multipackage_support` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shipping_label_sizes`
--

/*DROP TABLE IF EXISTS `shipping_label_sizes`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shipping_label_sizes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `gateway_id` int(5) NOT NULL,
  `carrier_code` varchar(55) NOT NULL,
  `default` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `label_template` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shipping_label_templates`
--

/*DROP TABLE IF EXISTS `shipping_label_templates`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shipping_label_templates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `filename` varchar(55) NOT NULL,
  `required_js` varchar(255) NOT NULL,
  `required_css` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shipping_methods`
--

/*DROP TABLE IF EXISTS `shipping_methods`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shipping_methods` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '',
  `display` varchar(155) NOT NULL,
  `refname` char(85) NOT NULL DEFAULT '',
  `carriercode` varchar(55) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `rank` tinyint(3) NOT NULL DEFAULT '0',
  `ships_residential` tinyint(1) NOT NULL COMMENT '0 = ships both, 1= residential only, 2=commercial only',
  `carrier_id` int(2) NOT NULL,
  `weight_limit` decimal(6,2) NOT NULL,
  `weight_min` decimal(6,2) NOT NULL,
  `is_international` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=656 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shipping_package_sizes`
--

/*DROP TABLE IF EXISTS `shipping_package_sizes`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shipping_package_sizes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(30) NOT NULL,
  `length` int(5) NOT NULL,
  `width` int(5) NOT NULL,
  `height` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shipping_package_types`
--

/*DROP TABLE IF EXISTS `shipping_package_types`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shipping_package_types` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `carrier_id` tinyint(2) NOT NULL,
  `carrier_reference` varchar(30) NOT NULL,
  `default` tinyint(1) NOT NULL,
  `is_international` tinyint(4) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`),
  KEY `carrier_id` (`carrier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shipping_signature_options`
--

/*DROP TABLE IF EXISTS `shipping_signature_options`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shipping_signature_options` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `carrier_id` tinyint(1) NOT NULL,
  `carrier_reference` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sites_categories`
--

/*DROP TABLE IF EXISTS `sites_categories`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sites_categories` (
  `site_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  UNIQUE KEY `site_id_2` (`site_id`,`category_id`),
  KEY `site_id` (`site_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sites_currencies`
--

/*DROP TABLE IF EXISTS `sites_currencies`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sites_currencies` (
  `site_id` int(5) NOT NULL,
  `currency_id` int(5) NOT NULL,
  `rank` tinyint(2) NOT NULL,
  UNIQUE KEY `sitecurr` (`site_id`,`currency_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sites_datafeeds`
--

/*DROP TABLE IF EXISTS `sites_datafeeds`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sites_datafeeds` (
  `site_id` int(10) NOT NULL,
  `datafeed_id` int(10) NOT NULL,
  `parent_children` tinyint(1) NOT NULL,
  `custom_info` text NOT NULL,
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sites_inventory_rules`
--

/*DROP TABLE IF EXISTS `sites_inventory_rules`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sites_inventory_rules` (
  `site_id` int(5) NOT NULL,
  `rule_id` int(5) NOT NULL,
  PRIMARY KEY (`site_id`),
  KEY `rule_id` (`rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sites_languages`
--

/*DROP TABLE IF EXISTS `sites_languages`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sites_languages` (
  `site_id` int(5) NOT NULL,
  `language_id` int(5) NOT NULL,
  `rank` tinyint(2) NOT NULL,
  UNIQUE KEY `sitelang` (`site_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sites_message_templates`
--

/*DROP TABLE IF EXISTS `sites_message_templates`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sites_message_templates` (
  `site_id` int(5) NOT NULL,
  `html` text NOT NULL,
  `alt` text NOT NULL,
  PRIMARY KEY (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sites_packingslip`
--

/*DROP TABLE IF EXISTS `sites_packingslip`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sites_packingslip` (
  `site_id` int(5) NOT NULL,
  `packingslip_appendix_elementid` int(10) NOT NULL,
  `packingslip_showlogo` tinyint(1) NOT NULL,
  PRIMARY KEY (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sites_payment_methods`
--

/*DROP TABLE IF EXISTS `sites_payment_methods`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sites_payment_methods` (
  `site_id` int(5) NOT NULL,
  `payment_method_id` int(5) NOT NULL,
  `gateway_account_id` int(5) NOT NULL,
  `fee` decimal(8,4) DEFAULT NULL,
  UNIQUE KEY `sitepaygate` (`site_id`,`payment_method_id`,`gateway_account_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sites_settings`
--

/*DROP TABLE IF EXISTS `sites_settings`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sites_settings` (
  `site_id` int(5) NOT NULL,
  `default_layout_id` int(5) NOT NULL,
  `default_category_thumbnail_template` int(5) NOT NULL,
  `default_product_thumbnail_template` int(5) NOT NULL,
  `default_product_detail_template` int(5) NOT NULL,
  `default_product_zoom_template` int(5) NOT NULL,
  `default_feature_thumbnail_template` int(5) NOT NULL,
  `default_feature_count` int(3) NOT NULL,
  `default_product_thumbnail_count` int(3) NOT NULL,
  `default_show_categories_in_body` tinyint(1) NOT NULL,
  `search_layout_id` int(5) NOT NULL,
  `search_thumbnail_template` int(5) NOT NULL,
  `search_thumbnail_count` int(3) NOT NULL,
  `home_feature_count` int(5) NOT NULL,
  `home_feature_thumbnail_template` int(5) NOT NULL,
  `home_feature_show` tinyint(1) NOT NULL,
  `home_feature_showsort` tinyint(1) NOT NULL,
  `home_feature_showmessage` tinyint(1) NOT NULL,
  `home_show_categories_in_body` tinyint(1) NOT NULL,
  `home_layout_id` int(5) NOT NULL,
  `default_product_related_count` int(11) NOT NULL,
  `default_product_brands_count` int(11) NOT NULL,
  `default_feature_showsort` tinyint(1) NOT NULL,
  `default_product_thumbnail_showsort` tinyint(1) NOT NULL,
  `default_product_thumbnail_showmessage` tinyint(1) NOT NULL,
  `default_feature_showmessage` tinyint(1) NOT NULL,
  `default_product_related_template` int(5) NOT NULL,
  `default_product_brands_template` int(5) NOT NULL,
  `require_customer_account` tinyint(1) NOT NULL,
  `default_category_layout_id` int(5) NOT NULL,
  `default_product_layout_id` int(5) NOT NULL,
  `account_layout_id` int(5) NOT NULL,
  `cart_layout_id` int(5) NOT NULL,
  `checkout_layout_id` int(5) NOT NULL,
  `page_layout_id` int(5) NOT NULL,
  `affiliate_layout_id` int(5) NOT NULL,
  `wishlist_layout_id` int(5) NOT NULL,
  `default_module_template_id` int(5) NOT NULL,
  `default_module_custom_values` text NOT NULL,
  `default_category_module_template_id` int(5) NOT NULL,
  `default_category_module_custom_values` text NOT NULL,
  `default_product_module_template_id` int(5) NOT NULL,
  `default_product_module_custom_values` text NOT NULL,
  `home_module_template_id` int(5) NOT NULL,
  `home_module_custom_values` text NOT NULL,
  `account_module_template_id` int(5) NOT NULL,
  `account_module_custom_values` text NOT NULL,
  `search_module_template_id` int(5) NOT NULL,
  `search_module_custom_values` text NOT NULL,
  `cart_module_template_id` int(5) NOT NULL,
  `cart_module_custom_values` text NOT NULL,
  `checkout_module_template_id` int(5) NOT NULL,
  `checkout_module_custom_values` text NOT NULL,
  `page_module_template_id` int(5) NOT NULL,
  `page_module_custom_values` text NOT NULL,
  `affiliate_module_template_id` int(5) NOT NULL,
  `affiliate_module_custom_values` text NOT NULL,
  `wishlist_module_template_id` int(11) NOT NULL,
  `wishlist_module_custom_values` text NOT NULL,
  `catalog_layout_id` int(5) NOT NULL,
  `catalog_module_template_id` int(5) NOT NULL,
  `catalog_module_custom_values` text NOT NULL,
  `catalog_show_products` tinyint(1) NOT NULL,
  `catalog_feature_show` tinyint(1) NOT NULL,
  `catalog_show_categories_in_body` tinyint(1) NOT NULL,
  `catalog_feature_count` int(5) NOT NULL,
  `catalog_feature_thumbnail_template` int(5) NOT NULL,
  `catalog_feature_showsort` tinyint(1) NOT NULL,
  `catalog_feature_showmessage` tinyint(1) NOT NULL,
  `cart_addtoaction` tinyint(1) NOT NULL COMMENT '0=forward to cart, 1=show popup',
  `cart_orderonlyavailableqty` tinyint(1) NOT NULL,
  `checkout_process` tinyint(1) NOT NULL COMMENT '0=5step,1=singlepage',
  `offline_layout_id` int(5) NOT NULL,
  `cart_allowavailability` varchar(100) NOT NULL DEFAULT 'any' COMMENT 'any, instock, lowstock, outofstock, onorder, discontinued',
  `filter_categories` tinyint(1) NOT NULL,
  `default_category_search_form_id` int(5) NOT NULL,
  `recaptcha_key` varchar(55) NOT NULL,
  `recaptcha_secret` varchar(55) NOT NULL,
  PRIMARY KEY (`site_id`),
  KEY `sites_settings_index_1` (`site_id`,`default_product_thumbnail_template`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sites_settings_modulevalues`
--

/*DROP TABLE IF EXISTS `sites_settings_modulevalues`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sites_settings_modulevalues` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `section` enum('default','home','search','checkout','catalog','cart','product','category','page','wishlist','account','affiliate') NOT NULL,
  `site_id` int(5) NOT NULL,
  `section_id` int(10) NOT NULL,
  `module_id` int(10) NOT NULL,
  `field_id` int(10) NOT NULL,
  `custom_value` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `section` (`section`,`site_id`,`section_id`,`module_id`,`field_id`),
  KEY `product_id_2` (`section`,`site_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2366 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sites_tax_rules`
--

/*DROP TABLE IF EXISTS `sites_tax_rules`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sites_tax_rules` (
  `site_id` int(5) NOT NULL,
  `tax_rule_id` int(10) NOT NULL,
  UNIQUE KEY `id` (`site_id`,`tax_rule_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sites_themes`
--

/*DROP TABLE IF EXISTS `sites_themes`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sites_themes` (
  `site_id` int(5) NOT NULL,
  `theme_id` int(5) NOT NULL,
  `theme_values` text NOT NULL,
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `states`
--

/*DROP TABLE IF EXISTS `states`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `states` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(85) NOT NULL,
  `abbreviation` varchar(3) NOT NULL,
  `country_id` int(5) NOT NULL,
  `tax_rate` decimal(3,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system`
--

/*DROP TABLE IF EXISTS `system`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system` (
  `id` int(5) NOT NULL DEFAULT '1',
  `path` varchar(255) NOT NULL,
  `use_cim` tinyint(1) NOT NULL,
  `charge_action` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 = auth & capture, 2 = auth only',
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
  `cart_expiration` int(3) NOT NULL DEFAULT '30' COMMENT 'number of days before cookie expires',
  `cart_removestatus` varchar(100) NOT NULL,
  `cart_updateprices` tinyint(1) NOT NULL DEFAULT '1',
  `cart_savediscounts` tinyint(1) NOT NULL DEFAULT '1',
  `feature_toggle` text NOT NULL,
  `check_for_shipped` tinyint(1) NOT NULL,
  `check_for_delivered` tinyint(1) NOT NULL,
  `orderplaced_defaultstatus` varchar(255) NOT NULL DEFAULT '{"default":1, "label":2, "download":1, "dropship":4, "unpaid":9}',
  `validate_addresses` varchar(20) NOT NULL COMMENT '0=no validation; >0=distributor.carrier_id to validate with',
  `giftcard_template_id` int(5) NOT NULL,
  `giftcard_waccount_template_id` int(5) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system_alerts`
--

/*DROP TABLE IF EXISTS `system_alerts`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_alerts` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `reference_type` tinyint(2) NOT NULL COMMENT '0 = other, 1 = order, 2 = transaction, 3 = shipment, 4 = package, 5 = account, 6 = product',
  `reference_id` int(20) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `been_read` tinyint(1) NOT NULL,
  `read_on` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `reference_type` (`reference_type`,`reference_id`),
  KEY `reference_id` (`reference_id`)
) ENGINE=InnoDB AUTO_INCREMENT=474 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system_errors`
--

/*DROP TABLE IF EXISTS `system_errors`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_errors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(10) NOT NULL,
  `created` datetime NOT NULL,
  `error` text NOT NULL,
  `details` text NOT NULL,
  `moredetails` text NOT NULL,
  `type_id` int(10) NOT NULL,
  `type` tinyint(2) NOT NULL COMMENT '0 = general system error, 1 = inventory gateway error, 2 = order error, 3 = order shipment error, 4 = order package error',
  `type_subid` int(10) NOT NULL,
  `been_read` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system_logs`
--

/*DROP TABLE IF EXISTS `system_logs`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_logs` (
  `data` text NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system_membership`
--

/*DROP TABLE IF EXISTS `system_membership`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_membership` (
  `id` int(5) NOT NULL DEFAULT '1',
  `signupemail_customer` int(5) NOT NULL,
  `signupemail_admin` int(5) NOT NULL,
  `renewemail_customer` int(5) NOT NULL,
  `renewemail_admin` int(5) NOT NULL,
  `expirationalert1_days` int(2) NOT NULL,
  `expirationalert2_days` int(2) NOT NULL,
  `expirationalert1_email` int(5) NOT NULL,
  `expirationalert2_email` int(5) NOT NULL,
  `expiration_email` int(5) NOT NULL,
  `downgrade_restriction_days` int(3) NOT NULL COMMENT 'must be within certain number of days of expiration in order to downgrade',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system_messages`
--

/*DROP TABLE IF EXISTS `system_messages`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_messages` (
  `id` int(10) NOT NULL,
  `message` varchar(500) NOT NULL,
  `posted` datetime NOT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system_tasks`
--

/*DROP TABLE IF EXISTS `system_tasks`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_tasks` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `site_id` int(5) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '0=download update',
  `type_info` varchar(255) NOT NULL COMMENT 'type = 0: download url',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system_updates`
--

/*DROP TABLE IF EXISTS `system_updates`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_updates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `site_id` int(5) NOT NULL,
  `version` varchar(25) NOT NULL,
  `type` tinyint(2) NOT NULL COMMENT '0=download, 1=run update',
  `processing` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tax_rules`
--

/*DROP TABLE IF EXISTS `tax_rules`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tax_rules` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `rate` decimal(8,2) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '0=all,1=location specific',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tax_rules_locations`
--

/*DROP TABLE IF EXISTS `tax_rules_locations`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tax_rules_locations` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tax_rule_id` int(10) NOT NULL,
  `name` varchar(55) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '0=country, 1=state/province, 2=zipcode',
  `country_id` int(10) NOT NULL,
  `state_id` int(10) NOT NULL,
  `zipcode` varchar(15) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tax_rule_id` (`tax_rule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tax_rules_product-types`
--

/*DROP TABLE IF EXISTS `tax_rules_product-types`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tax_rules_product-types` (
  `tax_rule_id` int(10) NOT NULL,
  `type_id` int(10) NOT NULL,
  UNIQUE KEY `id` (`tax_rule_id`,`type_id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wishlists`
--

/*DROP TABLE IF EXISTS `wishlists`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wishlists` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wishlists_items`
--

/*DROP TABLE IF EXISTS `wishlists_items`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wishlists_items` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `wishlist_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `parent_product` int(10) NOT NULL,
  `added` datetime NOT NULL,
  `parent_wishlists_items_id` int(10) NOT NULL,
  `is_accessory` tinyint(1) NOT NULL COMMENT '0=no,1=yes,2=as option',
  `accessory_required` tinyint(1) NOT NULL,
  `accessory_field_id` int(10) NOT NULL,
  `notify_backinstock` tinyint(1) NOT NULL COMMENT '0=no, 1=yes, 2=notified',
  `notify_backinstock_attempted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wlprod_id` (`wishlist_id`,`product_id`),
  KEY `wishlist_id` (`wishlist_id`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wishlists_items_customfields`
--

/*DROP TABLE IF EXISTS `wishlists_items_customfields`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wishlists_items_customfields` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `wishlists_item_id` int(20) NOT NULL,
  `form_id` int(10) NOT NULL,
  `section_id` int(10) NOT NULL,
  `field_id` int(10) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `saved_cart_item_id` (`wishlists_item_id`,`form_id`,`section_id`,`field_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wishlists_items_options`
--

/*DROP TABLE IF EXISTS `wishlists_items_options`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wishlists_items_options` (
  `wishlists_item_id` int(20) NOT NULL,
  `options_json` longtext NOT NULL,
  PRIMARY KEY (`wishlists_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wishlists_items_options_customvalues`
--

/*DROP TABLE IF EXISTS `wishlists_items_options_customvalues`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wishlists_items_options_customvalues` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `wishlists_item_id` int(20) NOT NULL,
  `option_id` int(10) NOT NULL,
  `custom_value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `saved_cart_item_id` (`wishlists_item_id`,`option_id`),
  UNIQUE KEY `cartitem_option` (`wishlists_item_id`,`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
