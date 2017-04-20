CREATE TABLE IF NOT EXISTS {menu} (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY  NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_lang` int(11) DEFAULT NULL,
  `position` int(11) NOT NULL,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 

CREATE TABLE IF NOT EXISTS {menu_item} (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `id_menu` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `permalink` varchar(255) NOT NULL,
  `id_type` int(11) NOT NULL,
  `id_content` int(11) NOT NULL,
  `content` text NOT NULL,
  `link` text NOT NULL,
  `position` int(11) NOT NULL DEFAULT '1',
  `id_parent` int(11) NOT NULL,
  `cdate` datetime NOT NULL,
  `udate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS  {menu_item_trans} (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_menu_item` int(11) NOT NULL,
  `id_lang` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `content` text CHARACTER SET utf32 NOT NULL,
  `cdate` datetime NOT NULL,
  `udate` datetime NOT NULL
) ENGINE=Aria DEFAULT CHARSET=latin1;


CREATE TABLE  IF NOT EXISTS  {menu_item_type} (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `cdate` datetime NOT NULL,
  `udate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DELETE FROM {menu_item_type};
INSERT INTO {menu_item_type} (`id`, `slug`, `title`, `cdate`, `udate`) VALUES
(1, 'cms', 'pages', '2016-08-26 13:03:20', '0000-00-00 00:00:00'),
(2, 'blog', 'Article', '2016-08-26 13:03:20', '0000-00-00 00:00:00'),
(3, 'product_category', 'categorie des produits', '2016-08-26 13:03:20', '0000-00-00 00:00:00'),
(4, 'link', 'lien personnalisé', '2016-08-26 13:03:20', '0000-00-00 00:00:00'),
(5, 'blog_category', 'catégorie des Articles', '2016-08-26 13:03:20', '0000-00-00 00:00:00'),
(6, 'html', 'text et html', '2016-08-26 13:03:20', '0000-00-00 00:00:00'),
(7, 'cms_category', 'catégorie des pages', '0000-00-00 00:00:00', '0000-00-00 00:00:00');


CREATE TABLE  IF NOT EXISTS  {menu_location} (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_menu` int(11) NOT NULL,
  `id_location` int(11) NOT NULL,
  `udate` datetime NOT NULL,
  `cdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS  {menu_location_lang} (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `udate` datetime NOT NULL,
  `cdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DELETE FROM {menu_location_lang};
INSERT INTO {menu_location_lang} (`id`, `name`, `udate`, `cdate`) VALUES
(1, 'sec_menu', '0000-00-00 00:00:00', '2016-08-26 15:03:27'),
(2, 'sec_pretop_left', '0000-00-00 00:00:00', '2016-08-26 15:03:27'),
(3, 'sec_pretop_right', '0000-00-00 00:00:00', '2016-08-26 15:03:27'),
(4, 'sec_footer_menu', '0000-00-00 00:00:00', '2016-08-31 11:30:30');
 
CREATE TABLE IF NOT EXISTS  {menu_trans} (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_menu` int(11) NOT NULL,
  `id_lang` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf32 NOT NULL,
  `cdate` datetime NOT NULL,
  `udate` datetime NOT NULL
) ENGINE=Aria DEFAULT CHARSET=latin1;