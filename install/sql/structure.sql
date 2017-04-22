--
-- Structure de la table `addresses`
--

CREATE TABLE IF NOT EXISTS `%%addresses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT '0',
  `id_country` int(11) NOT NULL DEFAULT '0',
  `name` varchar(45) DEFAULT NULL,
  `addresse` varchar(500) DEFAULT NULL,
  `addresse2` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `company` varchar(32) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `codepostal` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `info` text NOT NULL,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `attributes`
--

CREATE TABLE IF NOT EXISTS `%%attributes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_lang` int(11) NOT NULL DEFAULT '0',
  `name` varchar(45) NOT NULL,
  `permalink` varchar(45) DEFAULT NULL,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `attribute_values`
--

CREATE TABLE IF NOT EXISTS `%%attribute_values` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_lang` int(11) NOT NULL DEFAULT '0',
  `id_attribute` int(11) NOT NULL DEFAULT '0',
  `name` varchar(45) NOT NULL,
  `permalink` varchar(45) DEFAULT NULL,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `carrier`
--

CREATE TABLE IF NOT EXISTS `%%carrier` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_tax` int(10) UNSIGNED DEFAULT '0',
  `name` varchar(64) NOT NULL,
  `type` varchar(32) NOT NULL DEFAULT 'economic',
  `description` text NOT NULL,
  `min_delay` int(10) UNSIGNED DEFAULT '0',
  `max_delay` int(10) UNSIGNED DEFAULT '0',
  `grade` int(10) DEFAULT '0',
  `logo` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `shipping_handling` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `is_free` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `shipping_method` int(2) NOT NULL DEFAULT '0',
  `range_behavior` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `range_inf` decimal(20,2) DEFAULT '0.00',
  `range_sup` decimal(20,2) DEFAULT '0.00',
  `max_width` int(10) DEFAULT '0',
  `max_height` int(10) DEFAULT '0',
  `max_depth` int(10) DEFAULT '0',
  `max_weight` decimal(20,6) DEFAULT '0.000000',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `carrier_users_groups`
--

CREATE TABLE IF NOT EXISTS `%%carrier_users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_carrier` int(10) UNSIGNED DEFAULT '0',
  `id_group` int(10) UNSIGNED DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `carrier_zones`
--

CREATE TABLE IF NOT EXISTS `%%carrier_zones` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_carrier` int(10) UNSIGNED DEFAULT '0',
  `id_zone` int(10) UNSIGNED DEFAULT '0',
  `fees` decimal(20,2) DEFAULT '0.00',
  `active` int(11) NOT NULL DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cart_rule`
--

CREATE TABLE IF NOT EXISTS `%%cart_rule` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_customer` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(62) NOT NULL,
  `description` text,
  `code` varchar(255) NOT NULL,
  `date_from` datetime NOT NULL,
  `date_to` datetime NOT NULL,
  `minimum_amount` decimal(17,2) NOT NULL DEFAULT '0.00',
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `quantity_per_user` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `carrier_restriction` varchar(255) DEFAULT NULL,
  `group_restriction` varchar(255) DEFAULT NULL,
  `product_restriction` varchar(255) DEFAULT NULL,
  `free_shipping` tinyint(1) NOT NULL DEFAULT '0',
  `reduction` decimal(5,2) NOT NULL DEFAULT '0.00',
  `apply_discount` tinyint(1) NOT NULL DEFAULT '0',
  `reduction_type` varchar(12) NOT NULL DEFAULT 'order',
  `reduction_product` int(10) NOT NULL DEFAULT '0',
  `gift_product` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `gift_product_attribute` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cart_rule_user_codes`
--

CREATE TABLE IF NOT EXISTS `%%cart_rule_user_codes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_cart_rule` int(10) unsigned NOT NULL DEFAULT '0',
  `id_customer` int(10) unsigned NOT NULL DEFAULT '0',
  `quantity` int(10) unsigned NOT NULL DEFAULT '0',
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE IF NOT EXISTS `%%categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_lang` int(10) UNSIGNED NOT NULL,
  `id_parent` int(11) NOT NULL DEFAULT '0',
  `cover` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------
--
-- Structure de la table `category_trans`
--

CREATE TABLE IF NOT EXISTS `%%category_trans` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_lang` int(10) UNSIGNED NOT NULL,
  `id_category` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(64) NOT NULL,
  `description` text,
  `meta_title` varchar(128) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `link_rewrite` varchar(128) NOT NULL,
  `cdate` datetime DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cms`
--

CREATE TABLE IF NOT EXISTS `%%cms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_lang` int(11) DEFAULT NULL,
  `id_cmscat` int(11) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `description` text,
  `permalink` varchar(150) DEFAULT NULL,
  `content` text,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keywords` text NOT NULL,
  `keywords` text NOT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `cover_cms` varchar(255) NOT NULL,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  `img_cms` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cms_categories`
--

CREATE TABLE IF NOT EXISTS `%%cms_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_lang` int(11) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `permalink` varchar(150) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keywords` text,
  `description` varchar(500) DEFAULT NULL,
  `keywords` text NOT NULL,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `configuration`
--

/*CREATE TABLE IF NOT EXISTS `%%configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `more` varchar(255) NOT NULL,
  `cdate` date NOT NULL,
  `udate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;*/

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

/*CREATE TABLE IF NOT EXISTS `%%contact` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `save_msg` tinyint(1) NOT NULL DEFAULT '0',
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;*/

-- --------------------------------------------------------

--
-- Structure de la table `contact_trans`
--

/*CREATE TABLE IF NOT EXISTS `%%contact_trans` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_contact` int(10) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` text,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;*/

-- --------------------------------------------------------

--
-- Structure de la table `countries`
--

CREATE TABLE IF NOT EXISTS `%%countries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `id_zone` int(10) UNSIGNED NOT NULL,
  `id_currency` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_lang` int(11) NOT NULL DEFAULT '1',
  `iso_code` varchar(3) NOT NULL,
  `call_prefix` int(10) NOT NULL DEFAULT '0',
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `contains_states` tinyint(1) NOT NULL DEFAULT '0',
  `need_identification_number` tinyint(1) NOT NULL DEFAULT '0',
  `need_zip_code` tinyint(1) NOT NULL DEFAULT '1',
  `zip_code_format` varchar(12) NOT NULL DEFAULT '',
  `display_tax_label` tinyint(1) NOT NULL,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cron_job`
--

/*CREATE TABLE IF NOT EXISTS `%%cron_job` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `cron_date` date NOT NULL,
  `cron_time` time NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;*/

-- --------------------------------------------------------

--
-- Structure de la table `currencies`
--

CREATE TABLE IF NOT EXISTS `%%currencies` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `iso_code` varchar(3) NOT NULL DEFAULT '0',
  `iso_code_num` varchar(3) NOT NULL DEFAULT '0',
  `sign` varchar(8) NOT NULL,
  `default_currency` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `declinaisons`
--

CREATE TABLE IF NOT EXISTS `%%declinaisons` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_product` int(11) NOT NULL,
  `cu` varchar(255) DEFAULT NULL,
  `reference` varchar(45) DEFAULT NULL,
  `ean13` varchar(45) DEFAULT NULL,
  `upc` varchar(45) DEFAULT NULL,
  `buy_price` float NOT NULL,
  `sell_price` decimal(20,0) NOT NULL DEFAULT '0',
  `price_impact` int(11) DEFAULT '0',
  `price` float DEFAULT NULL,
  `weight_impact` int(11) DEFAULT '0',
  `weight` float DEFAULT NULL,
  `unit_impact` int(11) DEFAULT '0',
  `unity` float DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `min_quantity` int(11) NOT NULL,
  `available_date` date DEFAULT NULL,
  `default_dec` int(11) DEFAULT NULL,
  `images` varchar(255) NOT NULL,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `features`
--

CREATE TABLE IF NOT EXISTS `%%features` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `position` int(10) unsigned NOT NULL DEFAULT '0',
  `cdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `feature_product`
--

CREATE TABLE IF NOT EXISTS `%%feature_product` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_feature` int(10) unsigned NOT NULL,
  `id_product` int(10) unsigned NOT NULL,
  `id_feature_value` int(10) unsigned NOT NULL,
  `custom` varchar(32) NOT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `feature_trans`
--

CREATE TABLE IF NOT EXISTS `%%feature_trans` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_feature` int(10) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `cdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `feature_value`
--

CREATE TABLE IF NOT EXISTS `%%feature_value` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_feature` int(10) unsigned NOT NULL,
  `custom` tinyint(1) unsigned DEFAULT '0',
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `feature_value_trans`
--

CREATE TABLE IF NOT EXISTS `%%feature_value_trans` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_lang` int(10) unsigned NOT NULL,
  `id_value` int(11) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;


-- --------------------------------------------------------

--
-- Structure de la table `gender`
--

CREATE TABLE IF NOT EXISTS `%%gender` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_lang` int(11) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------


-- --------------------------------------------------------

--
-- Structure de la table `invoices`
--

CREATE TABLE IF NOT EXISTS `%%invoices` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_order` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_employee` int(11) NOT NULL,
  `id_state` int(11) NOT NULL,
  `id_payment_method` int(11) NOT NULL,
  `name` varchar(32) DEFAULT NULL,
  `reference` varchar(15) NOT NULL,
  `company` varchar(32) DEFAULT NULL,
  `address_invoice` varchar(100) DEFAULT NULL,
  `address_delivery` varchar(100) DEFAULT NULL,
  `currency_sign` varchar(10) NOT NULL DEFAULT '$',
  `loyalty_points` int(10) NOT NULL,
  `loyalty_value` decimal(20,2) DEFAULT '0.00',
  `global_discount` decimal(20,2) DEFAULT '0.00',
  `voucher_code` varchar(32) DEFAULT NULL,
  `voucher_value` decimal(20,2) DEFAULT '0.00',
  `voucher_type` tinyint(1) NOT NULL DEFAULT '0',
  `avoir` decimal(20,2) DEFAULT '0.00',
  `total_saved` decimal(20,2) DEFAULT '0.00',
  `total_letters` varchar(100) DEFAULT NULL,
  `more_info` text,
  `informations` text NOT NULL,
  `carrier_type` varchar(32) NOT NULL DEFAULT 'economic',
  `uby` int(11) NOT NULL,
  `cby` int(11) NOT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `invoice_carrier`
--

CREATE TABLE IF NOT EXISTS `%%invoice_carrier` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_invoice` int(10) unsigned NOT NULL,
  `id_carrier` int(10) unsigned NOT NULL,
  `carrier_name` varchar(32) DEFAULT NULL,
  `shipping_costs` decimal(20,2) NOT NULL DEFAULT '0.00',
  `min_delay` int(11) NOT NULL DEFAULT '0',
  `max_delay` int(11) NOT NULL DEFAULT '0',
  `delay_type` tinyint(1) NOT NULL DEFAULT '0',
  `min_prepa` int(11) NOT NULL DEFAULT '0',
  `max_prepa` int(11) NOT NULL DEFAULT '0',
  `prepa_type` tinyint(1) NOT NULL DEFAULT '0',
  `weight_including_packing` decimal(20,2) NOT NULL DEFAULT '0.00',
  `number_packages` int(11) NOT NULL DEFAULT '0',
  `more_info` text NOT NULL,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `invoice_detail`
--

CREATE TABLE IF NOT EXISTS `%%invoice_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_invoice` int(10) unsigned NOT NULL,
  `id_product` int(11) DEFAULT NULL,
  `id_declinaisons` int(10) DEFAULT NULL,
  `attributs` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_reference` varchar(32) DEFAULT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_ean13` varchar(13) DEFAULT NULL,
  `product_upc` varchar(12) DEFAULT NULL,
  `product_price` decimal(20,2) NOT NULL DEFAULT '0.00',
  `product_buyprice` decimal(20,2) NOT NULL DEFAULT '0.00',
  `product_discount` decimal(20,2) NOT NULL DEFAULT '0.00',
  `discount_type` tinyint(1) NOT NULL DEFAULT '0',
  `loyalty_points` int(11) NOT NULL DEFAULT '0',
  `product_packing` int(11) NOT NULL DEFAULT '0',
  `product_quantity` int(10) unsigned NOT NULL DEFAULT '0',
  `product_min_quantity` int(11) NOT NULL DEFAULT '1',
  `product_stock` int(11) NOT NULL DEFAULT '0',
  `product_weight` decimal(20,2) DEFAULT '0.00',
  `product_height` int(10) DEFAULT '0',
  `product_width` int(10) DEFAULT '0',
  `product_depth` int(10) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `languages`
--

CREATE TABLE IF NOT EXISTS `%%languages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `locale` varchar(32) NOT NULL,
  `iso_code` varchar(32) NOT NULL,
  `flag` varchar(32) DEFAULT NULL,
  `date_format` varchar(32) NOT NULL DEFAULT 'd/m/Y',
  `datetime_format` varchar(32) NOT NULL DEFAULT 'd/m/Y H:i:s',
  `direction` tinyint(1) NOT NULL DEFAULT '0',
  `default_lang` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) DEFAULT '0',
  `cdate` datetime DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;


-- --------------------------------------------------------

--
-- Structure de la table `meta_value`
--

CREATE TABLE IF NOT EXISTS `%%meta_value` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------


--
-- Structure de la table `modules`
--

CREATE TABLE IF NOT EXISTS `%%modules` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(62) DEFAULT NULL,
  `position` tinyint(1) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;


-- --------------------------------------------------------
--
-- Structure de la table `module_hooks`
--
CREATE TABLE IF NOT EXISTS `%%module_hooks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_module` int(11) NOT NULL,
  `section_name` varchar(62) NOT NULL,
  `hook_function` varchar(62) NOT NULL,
  `position` tinyint(1) NOT NULL DEFAULT '1',
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;




-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE IF NOT EXISTS `%%orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_quotation` int(11) NOT NULL,
  `id_carrier` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_employee` int(11) NOT NULL,
  `id_state` int(11) NOT NULL,
  `id_payment_method` int(11) NOT NULL,
  `payment_method` varchar(62) NOT NULL,
  `name` varchar(32) DEFAULT NULL,
  `reference` varchar(15) NOT NULL,
  `company` varchar(32) DEFAULT NULL,
  `address_invoice` varchar(100) DEFAULT NULL,
  `address_delivery` varchar(100) DEFAULT NULL,
  `currency_sign` varchar(10) NOT NULL DEFAULT '&#36;',
  `loyalty_points` int(10) NOT NULL,
  `loyalty_value` decimal(20,2) DEFAULT '0.00',
  `global_discount` decimal(20,2) DEFAULT '0.00',
  `voucher_code` varchar(32) DEFAULT NULL,
  `voucher_value` decimal(20,2) DEFAULT '0.00',
  `voucher_type` tinyint(1) NOT NULL DEFAULT '0',
  `avoir` decimal(20,2) DEFAULT '0.00',
  `total_saved` decimal(20,2) DEFAULT '0.00',
  `total_letters` varchar(100) DEFAULT NULL,
  `more_info` text,
  `informations` text NOT NULL,
  `carrier_type` varchar(32) NOT NULL DEFAULT 'economic',
  `uby` int(11) NOT NULL,
  `cby` int(11) NOT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `order_carrier`
--

CREATE TABLE IF NOT EXISTS `%%order_carrier` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_order` int(10) UNSIGNED NOT NULL,
  `id_carrier` int(10) UNSIGNED NOT NULL,
  `carrier_name` varchar(32) DEFAULT NULL,
  `shipping_costs` decimal(20,2) NOT NULL DEFAULT '0.00',
  `min_delay` int(11) NOT NULL DEFAULT '0',
  `max_delay` int(11) NOT NULL DEFAULT '0',
  `delay_type` tinyint(1) NOT NULL DEFAULT '0',
  `min_prepa` int(11) NOT NULL DEFAULT '0',
  `max_prepa` int(11) NOT NULL DEFAULT '0',
  `prepa_type` tinyint(1) NOT NULL DEFAULT '0',
  `weight_including_packing` decimal(20,2) NOT NULL DEFAULT '0.00',
  `number_packages` int(11) NOT NULL DEFAULT '0',
  `more_info` text NOT NULL,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `order_detail`
--

CREATE TABLE IF NOT EXISTS `%%order_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_order` int(10) UNSIGNED NOT NULL,
  `id_product` int(11) DEFAULT NULL,
  `id_declinaisons` int(10) DEFAULT NULL,
  `attributs` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_reference` varchar(32) DEFAULT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_ean13` varchar(13) DEFAULT NULL,
  `product_upc` varchar(12) DEFAULT NULL,
  `product_price` decimal(20,2) NOT NULL DEFAULT '0.00',
  `product_buyprice` decimal(20,2) NOT NULL DEFAULT '0.00',
  `product_discount` decimal(20,2) NOT NULL DEFAULT '0.00',
  `discount_type` tinyint(1) NOT NULL DEFAULT '0',
  `loyalty_points` int(11) NOT NULL DEFAULT '0',
  `product_packing` int(11) NOT NULL DEFAULT '0',
  `product_quantity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `product_min_quantity` int(11) NOT NULL DEFAULT '1',
  `product_stock` int(11) NOT NULL DEFAULT '0',
  `product_weight` decimal(20,2) DEFAULT '0.00',
  `product_height` int(10) DEFAULT '0',
  `product_width` int(10) DEFAULT '0',
  `product_depth` int(10) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `order_states`
--

CREATE TABLE IF NOT EXISTS `%%order_states` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `template` varchar(62) NOT NULL,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `payment_methodes`
--

CREATE TABLE IF NOT EXISTS `%%payment_methodes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `value` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;


-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE IF NOT EXISTS `%%products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT '1',
  `id_lang` int(11) NOT NULL DEFAULT '1',
  `id_tax` int(11) DEFAULT NULL,
  `id_category_default` int(11) NOT NULL,
  `reference` varchar(32) CHARACTER SET utf8mb4 NOT NULL,
  `upc` varchar(100) DEFAULT NULL,
  `quantity` int(10) NOT NULL,
  `ean13` varchar(100) DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `product_condition` varchar(100) NOT NULL,
  `buy_price` decimal(20,2) DEFAULT '0.00',
  `sell_price` decimal(20,2) NOT NULL DEFAULT '0.00',
  `packing_price` decimal(20,2) NOT NULL DEFAULT '0.00',
  `wholesale_price` decimal(20,2) NOT NULL DEFAULT '0.00',
  `wholesale_per_qty` int(11) NOT NULL DEFAULT '1',
  `discount` decimal(20,2) NOT NULL DEFAULT '0.00',
  `discount_type` tinyint(1) NOT NULL DEFAULT '0',
  `width` decimal(20,2) NOT NULL DEFAULT '0.00',
  `height` decimal(20,2) NOT NULL DEFAULT '0.00',
  `depth` decimal(20,2) NOT NULL DEFAULT '0.00',
  `weight` decimal(20,2) NOT NULL DEFAULT '0.00',
  `min_quantity` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `loyalty_points` int(10) NOT NULL DEFAULT '0',
  `active` tinyint(1) DEFAULT '1',
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `product_associated`
--

CREATE TABLE IF NOT EXISTS `%%product_associated` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_product` int(10) unsigned NOT NULL,
  `associated_with` int(11) NOT NULL,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `product_attachments`
--

CREATE TABLE IF NOT EXISTS `%%product_attachments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_product` int(11) NOT NULL,
  `id_quotation` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `slug` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `attachment` varchar(100) DEFAULT NULL,
  `file_md5` varchar(255) NOT NULL,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `product_category`
--

CREATE TABLE IF NOT EXISTS `%%product_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_product` int(11) DEFAULT NULL,
  `id_category` int(11) DEFAULT NULL,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `product_declinaisons`
--

CREATE TABLE IF NOT EXISTS `%%product_declinaisons` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_declinaison` int(11) NOT NULL,
  `id_attribute` int(11) NOT NULL,
  `id_value` int(11) NOT NULL,
  `cby` int(11) NOT NULL,
  `uby` int(11) NOT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `product_images`
--

CREATE TABLE IF NOT EXISTS `%%product_images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_product` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `position` int(11) NOT NULL,
  `futured` int(11) NOT NULL DEFAULT '0',
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `product_tags`
--

CREATE TABLE IF NOT EXISTS `%%product_tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_tag` int(11) DEFAULT NULL,
  `id_product` int(11) DEFAULT NULL,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `product_trans`
--

CREATE TABLE IF NOT EXISTS `%%product_trans` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_product` int(10) UNSIGNED NOT NULL,
  `id_lang` int(10) UNSIGNED NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text,
  `excerpt` text,
  `meta_title` varchar(128) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `link_rewrite` varchar(128) NOT NULL,
  `cdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;


-- ---------------------------------------------

-- --------------------------------------------------------

--
-- Structure de la table `shop`
--


CREATE TABLE IF NOT EXISTS `%%shop` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_activity` int(11) NOT NULL DEFAULT '0',
  `id_country` int(11) NOT NULL DEFAULT '0',
  `id_lang` int(11) NOT NULL DEFAULT '0',
  `email` varchar(32) NOT NULL,
  `immatriculation` text NOT NULL,
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `zip_code` varchar(32) NOT NULL,
  `city` varchar(32) NOT NULL,
  `phone` varchar(32) NOT NULL,
  `fax` varchar(32) NOT NULL,
  `latitude` varchar(62) NOT NULL,
  `longitude` varchar(62) NOT NULL,
  `home_url` varchar(255) NOT NULL,
  `domain` varchar(52) NOT NULL,
  `domain_ssl` varchar(52) NOT NULL,
  `ssl_active` tinyint(1) NOT NULL DEFAULT '0',
  `physical_uri` varchar(64) NOT NULL,
  `virtual_uri` varchar(64) NOT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `shop_activity`
--
CREATE TABLE IF NOT EXISTS `%%shop_trans` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_shop` int(10) UNSIGNED NOT NULL,
  `id_lang` int(10) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `tagline` varchar(255) NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `cdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;




--
-- Structure de la table `shop_activity`
--

CREATE TABLE IF NOT EXISTS `%%shop_activity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;


-- --------------------------------------------------------

--
-- Structure de la table `taxes`
--

CREATE TABLE IF NOT EXISTS `%%taxes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `taxes_rules`
--

CREATE TABLE IF NOT EXISTS `%%taxes_rules` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_group` int(11) NOT NULL,
  `id_tax` int(11) NOT NULL,
  `id_country` int(11) NOT NULL,
  `id_state` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `cby` int(11) NOT NULL,
  `uby` int(11) NOT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `taxes_rules_group`
--

CREATE TABLE IF NOT EXISTS `%%taxes_rules_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `active` int(11) NOT NULL,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;


-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `%%users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_gender` int(11) DEFAULT NULL,
  `id_group` int(10) NOT NULL DEFAULT '0',
  `id_city` int(11) DEFAULT NULL,
  `id_country` int(11) DEFAULT NULL,
  `id_lang` int(11) DEFAULT '1',
  `ip` varchar(255) NOT NULL,
  `clt_number` varchar(32) DEFAULT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) NOT NULL,
  `info_sup` text NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `mobile` varchar(45) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `birthday` date NOT NULL,
  `note_content` text NOT NULL,
  `user_type` varchar(10) NOT NULL DEFAULT 'user',
  `active` varchar(32) NOT NULL DEFAULT 'waiting',
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------
--
-- Structure de la table `usermeta`
--

CREATE TABLE IF NOT EXISTS `%%usermeta` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;


-- --------------------------------------------------------

--
-- Structure de la table `users_groups`
--

CREATE TABLE IF NOT EXISTS `%%users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `cby` int(11) NOT NULL,
  `uby` int(11) NOT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user_company`
--

CREATE TABLE IF NOT EXISTS `%%user_company` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `company` varchar(255) NOT NULL,
  `activite` varchar(255) NOT NULL,
  `siret_tva` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL,
  `attachement` varchar(255) NOT NULL,
  `date_activite` date NOT NULL,
  `info` text NOT NULL,
  `cby` int(11) NOT NULL,
  `uby` int(11) NOT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `zones`
--

CREATE TABLE IF NOT EXISTS `%%zones` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;



--
-- Structure de la table `tags`
--
CREATE TABLE IF NOT EXISTS `%%tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_lang` int(11) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `permalink` varchar(45) DEFAULT NULL,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;