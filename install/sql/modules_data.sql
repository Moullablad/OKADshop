--
-- Contenu de la table `blockhtml`
--
INSERT INTO `%%blockhtml` (`icon`, `title`, `text`) VALUES
('<i class="fa fa-trophy  fa-5x" aria-hidden="true"></i>', 'Lorem Ipsum', 'ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'),
('<i class="fa fa-archive  fa-5x" aria-hidden="true"></i>', 'Lorem Ipsum', 'ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'),
('<i class="fa fa-phone  fa-5x" aria-hidden="true"></i>', 'Lorem Ipsum', 'ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'),
('<i class="fa fa-folder fa-5x" aria-hidden="true"></i>', 'Lorem Ipsum', 'ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');


--
-- Contenu de la table `superslider_images`
--
INSERT INTO `%%superslider_images` (`file_name`) VALUES 
('1.jpg'),
('2.jpg');


--
-- Contenu de la table `menu`
--
INSERT INTO `%%menu` (`id`, `name`, `id_lang`, `position`) VALUES
(18, 'main_menu', 1, 1),
(26, 'Legal', 1, 4),
(27, 'Contact', 1, 5),
(30, 'About US', 1, 2),
(31, 'Our Services', 1, 3);

--
-- Dumping data for table `os_menu_item`
--
INSERT INTO `%%menu_item` (`id_menu`, `title`, `permalink`, `id_type`, `id_content`, `content`, `link`, `position`, `id_parent`) VALUES
(18, 'Contact', '', 4, 0, '', 'contact', 4, 0),
(18, 'Home', '', 4, 0, '', '', 1, 0),
(26, 'Mentions legales', '', 1, 14, '', '', 1, 0),
(26, 'Conditions générales de vente', '', 1, 15, '', '', 2, 0),
(27, 'Address', '', 6, 0, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit Ut enim ad minim veniam', '', 1, 0),
(27, 'Phone', '', 6, 0, '<p class="phone"><strong>Phone: </strong>+1 0000 0000</p>', '', 2, 0),
(27, 'Email', '', 6, 0, '<p class="email"><strong>E-mail :</strong> <a href="mailto:contact@okadshop.com">contact@okadshop.com</a></p>', '', 3, 0),
(18, 'Products', '', 3, 1, '', '', 2, 0),
(18, 'My account', '', 4, 0, '', 'account', 3, 0),
(30, 'Some informations About shop', '', 6, 0, '<p style="text-align: justify;">Lorem ipsum dolor sit amet Excepteur, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>', '', 1, 0),
(31, 'Lorem ipsum dolor sit amet', '', 4, 0, '', '#', 1, 0),
(31, 'Ut enim ad minim veniam', '', 4, 0, '', '#', 2, 0),
(31, 'Excepteur sint occaecat', '', 4, 0, '', '#', 3, 0),
(31, 'Duis aute irure dolor', '', 4, 0, '', '#', 4, 0),
(31, 'Lorem ipsum dolor sit amet,', '', 4, 0, '', '#', 5, 0);

--
-- Dumping data for table `menu_item_type`
--
INSERT INTO `%%menu_item_type` (`slug`, `title`) VALUES
('cms', 'pages'),
('blog', 'Article'),
('product_category', 'categorie des produits'),
('link', 'lien personnalisé'),
('blog_category', 'catégorie des Articles'),
('html', 'text et html'),
('cms_category', 'catégorie des pages');

--
-- Dumping data for table `menu_location`
--
INSERT INTO `%%menu_location` (`id_menu`, `id_location`) VALUES
(15, 1),
(19, 4),
(20, 4),
(24, 4),
(25, 4),
(18, 1),
(26, 4),
(31, 4),
(27, 4),
(30, 4);

--
-- Dumping data for table `menu_location_lang`
--
INSERT INTO `%%menu_location_lang` (`name`) VALUES
('sec_menu'),
('sec_pretop_left'),
('sec_pretop_right'),
('sec_footer_menu');



--
-- Contenu de la table `meta_value`
--
INSERT INTO `%%meta_value` (`name`, `value`) VALUES
('trending_data', '{"cat_7":{"id":"7","position":"1"},"cat_2":{"id":"2","position":"1"},"cat_4":{"id":"4","position":"1"},"cat_5":{"id":"5","position":"1"},"cat_3":{"id":"3","position":"1"}}'),
('ads_images_data', '[{"filename":"files\/modules\/ads\/sidebar-ads.jpg","id":"1482407886"}]');