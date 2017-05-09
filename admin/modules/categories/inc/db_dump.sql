CREATE TABLE IF NOT EXISTS `{categories}` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_lang` int(10) UNSIGNED NOT NULL,
  `id_parent` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `cover` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{category_trans}` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_lang` int(10) UNSIGNED NOT NULL,
  `id_category` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(64) NOT NULL,
  `description` text DEFAULT NULL,
  `meta_title` varchar(128) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `link_rewrite` varchar(128) NOT NULL,
  `cdate` datetime DEFAULT NULL,
  `udate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;