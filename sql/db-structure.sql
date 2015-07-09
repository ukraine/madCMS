-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июл 09 2015 г., 15:51
-- Версия сервера: 5.5.43-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `itranslate_mcms`
--

-- --------------------------------------------------------

--
-- Структура таблицы `actors_info`
--

CREATE TABLE IF NOT EXISTS `actors_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actor_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `price` float NOT NULL,
  `filename` varchar(255) NOT NULL,
  `size` int(11) NOT NULL DEFAULT '0',
  `duration` int(11) NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL,
  `additional` text NOT NULL,
  `demotracks` text NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `actor_id` (`actor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Структура таблицы `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(100) NOT NULL,
  `val` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `co_payments`
--

CREATE TABLE IF NOT EXISTS `co_payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `currency` varchar(3) NOT NULL,
  `quantity` int(11) NOT NULL,
  `goods_name` varchar(64) DEFAULT NULL,
  `invoice_id` varchar(64) NOT NULL,
  `order_id` varchar(64) NOT NULL,
  `merchant_order_id` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `first_name` varchar(32) DEFAULT NULL,
  `last_name` varchar(32) DEFAULT NULL,
  `country` varchar(32) DEFAULT NULL,
  `city` varchar(32) DEFAULT NULL,
  `street` varchar(32) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pay_method` varchar(3) DEFAULT NULL,
  `card_holder_name` varchar(64) DEFAULT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `refund` tinyint(4) DEFAULT NULL,
  `refund_date` timestamp NULL DEFAULT NULL,
  `refund_category` tinyint(4) DEFAULT NULL,
  `refund_comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_id` (`invoice_id`,`order_id`,`merchant_order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица платежей 2Checkout' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `criteria_group`
--

CREATE TABLE IF NOT EXISTS `criteria_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Структура таблицы `criterion`
--

CREATE TABLE IF NOT EXISTS `criterion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55 ;

-- --------------------------------------------------------

--
-- Структура таблицы `criterion_to_actors`
--

CREATE TABLE IF NOT EXISTS `criterion_to_actors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `criterion_id` int(11) NOT NULL,
  `actor_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `criterion_id` (`criterion_id`,`actor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31995 ;

-- --------------------------------------------------------

--
-- Структура таблицы `data`
--

CREATE TABLE IF NOT EXISTS `data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `regdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `regip` varchar(50) NOT NULL,
  `regtype` varchar(10) NOT NULL,
  `blocked` int(11) DEFAULT '1',
  `srcLang` int(11) NOT NULL,
  `dstLang` int(11) NOT NULL,
  `motherTongue` int(11) NOT NULL,
  `motherTonguesAgency` text NOT NULL,
  `srcLangsAgency` text NOT NULL,
  `dstLangsAgency` text NOT NULL,
  `address` text NOT NULL,
  `info` text NOT NULL,
  `info_additional` text NOT NULL,
  `transPrice` tinyint(4) NOT NULL,
  `proofPrice` tinyint(4) NOT NULL,
  `login_id` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `capacity` int(11) NOT NULL,
  `isagency` int(11) NOT NULL DEFAULT '0',
  `activated` int(11) DEFAULT '0',
  `regstep` int(11) NOT NULL,
  `currency` char(3) DEFAULT 'USD',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10403 ;

-- --------------------------------------------------------

--
-- Структура таблицы `joblist`
--

CREATE TABLE IF NOT EXISTS `joblist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `contacts` varchar(255) CHARACTER SET utf8 NOT NULL,
  `date_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ptype` enum('open','closed') NOT NULL DEFAULT 'open',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Структура таблицы `latest_events`
--

CREATE TABLE IF NOT EXISTS `latest_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `track` varchar(40) CHARACTER SET utf8 NOT NULL,
  `eventdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `track_url` varchar(255) NOT NULL,
  `track_file` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=91 ;

-- --------------------------------------------------------

--
-- Структура таблицы `madcms_categories`
--

CREATE TABLE IF NOT EXISTS `madcms_categories` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(48) NOT NULL DEFAULT '',
  `cat_path` varchar(32) NOT NULL DEFAULT '',
  `header` char(1) NOT NULL DEFAULT '',
  `footer` char(1) NOT NULL DEFAULT '',
  `visibility` char(1) NOT NULL DEFAULT '',
  `priority` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `cat_path` (`cat_path`),
  UNIQUE KEY `cat_name` (`cat_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Структура таблицы `madcms_countries`
--

CREATE TABLE IF NOT EXISTS `madcms_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(255) DEFAULT NULL,
  `country_eng` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Структура таблицы `madcms_expos`
--

CREATE TABLE IF NOT EXISTS `madcms_expos` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `itemurl` varchar(60) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(950) DEFAULT NULL,
  `url` varchar(69) DEFAULT NULL,
  `frequency` varchar(80) DEFAULT NULL,
  `location` varchar(113) DEFAULT NULL,
  `dates` varchar(177) DEFAULT NULL,
  `organizer` varchar(366) DEFAULT NULL,
  `who` varchar(96) DEFAULT NULL,
  `country` varchar(23) DEFAULT NULL,
  `city` varchar(126) DEFAULT NULL,
  `theme` varchar(286) DEFAULT NULL,
  `contacts` varchar(391) DEFAULT NULL,
  `notes` varchar(474) DEFAULT NULL,
  `accomp_events` varchar(989) DEFAULT NULL,
  `logo` varchar(39) DEFAULT NULL,
  `is_ufi_approved` int(1) DEFAULT NULL,
  `if_ruef_approved` int(1) DEFAULT NULL,
  `visibility` char(1) NOT NULL,
  `priority` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1192 ;

-- --------------------------------------------------------

--
-- Структура таблицы `madcms_faq`
--

CREATE TABLE IF NOT EXISTS `madcms_faq` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `question` varchar(112) NOT NULL DEFAULT '',
  `answer` text NOT NULL,
  `priority` int(1) NOT NULL DEFAULT '0',
  `visibility` char(1) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Структура таблицы `madcms_files`
--

CREATE TABLE IF NOT EXISTS `madcms_files` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '',
  `path` varchar(32) NOT NULL DEFAULT '',
  `priority` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `path` (`path`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `madcms_languages`
--

CREATE TABLE IF NOT EXISTS `madcms_languages` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `code` char(2) NOT NULL DEFAULT '',
  `name` varchar(32) NOT NULL DEFAULT '',
  `priority` int(1) NOT NULL DEFAULT '0',
  `visibility` char(1) DEFAULT NULL,
  `registrationtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Структура таблицы `madcms_links`
--

CREATE TABLE IF NOT EXISTS `madcms_links` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(128) NOT NULL DEFAULT '',
  `backurl` varchar(255) NOT NULL DEFAULT '',
  `link_cat_id` tinyint(3) NOT NULL DEFAULT '0',
  `email` varchar(64) NOT NULL DEFAULT '',
  `phone` varchar(25) NOT NULL DEFAULT '',
  `contacturl` varchar(128) NOT NULL DEFAULT '',
  `name` varchar(64) NOT NULL DEFAULT '',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lastcheck` varchar(19) NOT NULL DEFAULT '',
  `mailsent` varchar(19) NOT NULL DEFAULT '',
  `metarobots` tinyint(1) NOT NULL DEFAULT '0',
  `404` int(1) NOT NULL,
  `robotstxt` tinyint(1) NOT NULL DEFAULT '0',
  `noindex` tinyint(1) NOT NULL DEFAULT '0',
  `norel` tinyint(1) NOT NULL DEFAULT '0',
  `ourlink` varchar(128) NOT NULL,
  `date_message_sent` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `presence` tinyint(1) NOT NULL DEFAULT '0',
  `visibility` char(1) NOT NULL DEFAULT '0',
  `content` varchar(128) NOT NULL DEFAULT '',
  `autocheck` int(1) NOT NULL,
  `priority` tinyint(1) NOT NULL DEFAULT '0',
  `showonpage` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=160 ;

-- --------------------------------------------------------

--
-- Структура таблицы `madcms_news`
--

CREATE TABLE IF NOT EXISTS `madcms_news` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL DEFAULT '',
  `keywords` varchar(128) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `file_id` int(5) NOT NULL DEFAULT '0',
  `priority` int(1) NOT NULL DEFAULT '0',
  `visibility` char(1) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `onthefirstpage` int(1) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `madcms_pages`
--

CREATE TABLE IF NOT EXISTS `madcms_pages` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `parent_id` int(6) NOT NULL DEFAULT '0',
  `page_name` varchar(128) NOT NULL DEFAULT '',
  `page_path` varchar(48) NOT NULL DEFAULT '',
  `title` varchar(128) NOT NULL DEFAULT '',
  `h1` varchar(128) NOT NULL DEFAULT '',
  `keywords` varchar(128) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `priority` int(6) DEFAULT NULL,
  `advertise` int(1) NOT NULL,
  `visibility` char(1) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `onthefirstpage` int(1) NOT NULL DEFAULT '0',
  `file_id` int(5) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `category` int(1) NOT NULL,
  `counter` int(8) NOT NULL,
  `title_de` varchar(128) NOT NULL,
  `description_de` text NOT NULL,
  `keywords_de` varchar(128) NOT NULL,
  `h1_de` varchar(128) NOT NULL,
  `content_de` text NOT NULL,
  `page_name_de` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=86 ;

-- --------------------------------------------------------

--
-- Структура таблицы `madcms_paymenttypes`
--

CREATE TABLE IF NOT EXISTS `madcms_paymenttypes` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `fee` decimal(4,3) NOT NULL DEFAULT '0.000',
  `visibility` char(1) NOT NULL DEFAULT 'n',
  `priority` int(2) NOT NULL,
  `registrationtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Структура таблицы `madcms_rates`
--

CREATE TABLE IF NOT EXISTS `madcms_rates` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(48) DEFAULT NULL,
  `name_original` varchar(128) NOT NULL,
  `ppw` decimal(5,4) NOT NULL DEFAULT '0.0000',
  `fixedrate` int(3) NOT NULL,
  `issued_in` int(1) NOT NULL,
  `target_lang_id` tinyint(3) NOT NULL,
  `source_lang_id` tinyint(3) NOT NULL,
  `priority` int(1) NOT NULL,
  `visibility` char(1) NOT NULL,
  `registrationtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=92 ;

-- --------------------------------------------------------

--
-- Структура таблицы `madcms_settings`
--

CREATE TABLE IF NOT EXISTS `madcms_settings` (
  `id` int(1) NOT NULL DEFAULT '0',
  `softurl` varchar(128) NOT NULL DEFAULT '',
  `softname` varchar(32) CHARACTER SET utf8 NOT NULL,
  `company_name` varchar(128) CHARACTER SET utf8 NOT NULL,
  `ownername` varchar(128) CHARACTER SET utf8 NOT NULL,
  `mail_address` varchar(128) NOT NULL DEFAULT '',
  `email` varchar(64) NOT NULL DEFAULT '',
  `login` varchar(24) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `phone` varchar(20) NOT NULL DEFAULT '',
  `sitename` varchar(128) NOT NULL DEFAULT '',
  `default_title` varchar(128) NOT NULL DEFAULT '',
  `default_description` varchar(255) NOT NULL DEFAULT '',
  `default_keywords` varchar(255) NOT NULL DEFAULT '',
  `counters` text NOT NULL,
  `onlinechatcode` text NOT NULL,
  `onlinechatcode_enabled` int(1) NOT NULL,
  `link_manager` varchar(255) NOT NULL,
  `itemsonpage` int(2) NOT NULL DEFAULT '0',
  `minimal_request_price` int(6) NOT NULL,
  `newsperpage` int(3) NOT NULL DEFAULT '0',
  `itemsontopmenu` int(2) NOT NULL,
  `itemsonbottommenu` int(2) NOT NULL,
  `itemsonlinkspage` int(3) NOT NULL,
  `custom_priorities` int(1) NOT NULL,
  `advEditor` int(1) NOT NULL,
  `admin_session_id` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `madcms_tests`
--

CREATE TABLE IF NOT EXISTS `madcms_tests` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `email` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `icq` varchar(16) NOT NULL,
  `skype` varchar(32) NOT NULL,
  `location` varchar(32) CHARACTER SET utf8 NOT NULL,
  `testtranslation` text CHARACTER SET utf8 NOT NULL,
  `timespent` int(3) NOT NULL,
  `comments` text NOT NULL,
  `ip` varchar(15) NOT NULL,
  `referal` varchar(255) NOT NULL,
  `priority` int(2) NOT NULL,
  `visibility` char(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rate` int(1) NOT NULL,
  `rater_comment` text NOT NULL,
  `test_id` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=212 ;

-- --------------------------------------------------------

--
-- Структура таблицы `madcms_translators`
--

CREATE TABLE IF NOT EXISTS `madcms_translators` (
  `id` int(5) NOT NULL,
  `firstname` varchar(128) NOT NULL,
  `lastname` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(128) NOT NULL,
  `country` varchar(128) NOT NULL,
  `zip` varchar(12) NOT NULL,
  `phone` varchar(128) NOT NULL,
  `cellphone` varchar(128) NOT NULL,
  `fax` varchar(128) NOT NULL,
  `motherTongue` varchar(128) NOT NULL,
  `SourceLanguage` varchar(128) NOT NULL,
  `TargetLanguage` varchar(128) NOT NULL,
  `Specialization` varchar(128) NOT NULL,
  `DTPApplication` varchar(128) NOT NULL,
  `TranslationMemoryTools` varchar(128) NOT NULL,
  `TranslationPrice` varchar(128) NOT NULL,
  `ProofPrice` varchar(128) NOT NULL,
  `testtranslation` varchar(1) NOT NULL,
  `opensourcetranslation` varchar(1) NOT NULL,
  `sworntranslator` varchar(1) NOT NULL,
  `comment` text NOT NULL,
  `ip` varchar(15) NOT NULL,
  `referal` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actor_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 NOT NULL,
  `comment` text NOT NULL,
  `attach` varchar(255) CHARACTER SET latin1 NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_ip` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `order_documents`
--

CREATE TABLE IF NOT EXISTS `order_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(19) NOT NULL,
  `document_id` tinyint(4) NOT NULL,
  `quantity` tinyint(4) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`,`document_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Структура таблицы `order_options`
--

CREATE TABLE IF NOT EXISTS `order_options` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(19) NOT NULL,
  `from_lang_id` tinyint(4) DEFAULT NULL,
  `to_lang_id` tinyint(4) DEFAULT NULL,
  `certification` tinyint(4) DEFAULT NULL,
  `certification_cost` decimal(10,2) DEFAULT NULL,
  `delivery` tinyint(4) DEFAULT NULL,
  `delivery_cost` decimal(10,2) DEFAULT NULL,
  `over_night` tinyint(4) DEFAULT NULL,
  `over_night_cost` tinyint(4) DEFAULT NULL,
  `email_delivery` tinyint(4) DEFAULT NULL,
  `email_delivery_cost` decimal(10,2) DEFAULT NULL,
  `notarization` tinyint(4) DEFAULT NULL,
  `notarization_cost` decimal(10,2) DEFAULT NULL,
  `immediate` tinyint(4) DEFAULT NULL,
  `immediate_cost` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица дополнительных опций заказа' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Структура таблицы `payment_orders`
--

CREATE TABLE IF NOT EXISTS `payment_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(32) NOT NULL,
  `order_id` varchar(19) NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(32) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `instructions` text,
  `promocode` varchar(32) DEFAULT NULL,
  `discount` tinyint(4) DEFAULT NULL,
  `discount_by_count` decimal(10,2) DEFAULT NULL,
  `status` varchar(8) NOT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  `result_cost` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `client_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `session_id` (`session_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Table of payment orders' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Структура таблицы `stats`
--

CREATE TABLE IF NOT EXISTS `stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actor_id` int(11) NOT NULL,
  `stats` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=288 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tracktype`
--

CREATE TABLE IF NOT EXISTS `tracktype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `isglobal` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=92 ;

-- --------------------------------------------------------

--
-- Структура таблицы `upload_files`
--

CREATE TABLE IF NOT EXISTS `upload_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` varchar(32) NOT NULL,
  `order_id` varchar(19) NOT NULL,
  `document_id` tinyint(3) unsigned NOT NULL,
  `original_file_name` varchar(64) NOT NULL,
  `system_file_name` varchar(64) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
