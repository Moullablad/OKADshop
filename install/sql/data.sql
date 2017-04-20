--
-- Contenu de la table `attributes`
--

INSERT INTO `%%attributes` (`id`, `id_lang`, `name`, `permalink`) VALUES
(1, 1, 'Portes', 'portes'),
(2, 1, 'Energie', 'energie'),
(3, 1, 'Boite', 'boite'),
(4, 1, 'CO2', 'co2');

--
-- Contenu de la table `attribute_values`
--

INSERT INTO `%%attribute_values` (`id`, `id_lang`, `id_attribute`, `name`, `permalink`) VALUES
(1, 1, 1, '2', '2'),
(2, 1, 1, '3', '3'),
(3, 1, 1, '5', '5'),
(4, 1, 2, 'Essence', 'essence'),
(5, 1, 2, 'Diesel', 'diesel'),
(6, 1, 2, 'Ess./Elec.', 'ess-elec'),
(7, 1, 2, 'Elec.', 'elec'),
(8, 1, 3, 'Mécanique', 'emcanique'),
(9, 1, 3, 'Auto', 'auto'),
(10, 1, 4, 'NC', 'nc'),
(11, 1, 4, '0 g/km', '0g-km'),
(12, 1, 4, '12 g/km', '12g-km'),
(13, 1, 4, '99 g/km', '99g-km'),
(14, 1, 4, '101 g/km', '101g-km'),
(15, 1, 4, '107 g/km', '107g-km'),
(16, 1, 4, '109 g/km', '109g-km'),
(17, 1, 4, '110 g/km', '110g-km'),
(18, 1, 4, '112 g/km', '112g-km'),
(19, 1, 4, '113 g/km', '113g-km'),
(20, 1, 4, '115 g/km', '115g-km'),
(21, 1, 4, '118 g/km', '118g-km'),
(22, 1, 4, '119 g/km', '119g-km'),
(23, 1, 4, '123 g/km', '123g-km'),
(24, 1, 4, '127 g/km', '127g-km'),
(25, 1, 4, '129 g/km', '129g-km'),
(26, 1, 4, '130 g/km', '130g-km'),
(27, 1, 4, '135 g/km', '135g-km'),
(28, 1, 4, '137 g/km', '137g-km'),
(29, 1, 4, '138 g/km', '138g-km'),
(30, 1, 4, '139 g/km', '139g-km'),
(31, 1, 4, '144 g/km', '144g-km'),
(32, 1, 4, '145 g/km', '145g-km'),
(33, 1, 4, '149 g/km', '149g-km'),
(34, 1, 4, '171 g/km', '171g-km'),
(35, 1, 4, '175 g/km', '175g-km'),
(36, 1, 4, '304 g/km', '304g-km'),
(37, 1, 4, '329 g/km', '329g-km'),
(38, 1, 4, '350 g/km', '350g-km');

--
-- Contenu de la table `carrier`
--

INSERT INTO `%%carrier` (`id`, `id_tax`, `name`, `type`, `description`, `min_delay`, `max_delay`, `grade`, `logo`, `url`, `shipping_handling`, `is_free`, `shipping_method`, `range_behavior`, `range_inf`, `range_sup`, `max_width`, `max_height`, `is_default`, `max_depth`, `max_weight`, `active`) VALUES
(1, 0, 'OkadShop', 'economic', 'Some usefull informations...', 2, 15, 10, 'default.png', 'http://okadshop.com', 0, 1, 0, 0, '0.00', '0.00', 0, 0, 1, 0, '0.000000', 1);

--
-- Contenu de la table `categories`
--
INSERT INTO `%%categories` (`id`, `id_lang`, `id_parent`, `cover`, `position`, `active`) VALUES (1, 1, 0, '', 0, 1);


--
-- Dumping data for table `csh_category_trans`
--

INSERT INTO `%%category_trans` (`id`, `id_lang`, `id_category`, `name`, `description`, `meta_title`, `meta_description`, `meta_keywords`, `link_rewrite`) VALUES
(1, 1, 1, 'Home', 'Home category', 'Home', 'Home category', 'home', 'home');



--
-- Contenu de la table `countries`
--

INSERT INTO `%%countries` (`id`, `name`, `id_zone`, `id_currency`, `id_lang`, `iso_code`, `call_prefix`, `active`, `contains_states`, `need_identification_number`, `need_zip_code`, `zip_code_format`, `display_tax_label`) VALUES
(1, 'Allemagne', 1, 1, 1, 'DE', 49, 1, 0, 0, 1, 'NNNNN', 0),
(2, 'Canada', 2, 1, 1, 'CA', 1, 1, 1, 0, 1, 'LNL NLN', 0),
(3, 'Chine', 3, 1, 1, 'CN', 86, 1, 0, 0, 1, 'NNNNNN', 0),
(4, 'Espagne', 1, 1, 1, 'ES', 34, 1, 0, 1, 1, 'NNNNN', 0),
(5, 'France', 1, 1, 1, 'FR', 33, 1, 0, 0, 1, 'NNNNN', 0),
(6, 'Italie', 1, 1, 1, 'IT', 39, 1, 1, 0, 1, 'NNNNN', 0),
(7, 'Japon', 3, 1, 1, 'JP', 81, 1, 1, 0, 1, 'NNN-NNNN', 0),
(8, 'Royaume-Uni', 1, 1, 1, 'GB', 44, 1, 0, 0, 1, '', 0),
(9, 'États-Unis', 2, 1, 1, 'US', 1, 1, 1, 0, 1, 'NNNNN', 0),
(10, 'Inde', 3, 1, 1, 'IN', 91, 1, 0, 0, 1, 'NNN NNN', 0);

--
-- Contenu de la table `currencies`
--

INSERT INTO `%%currencies` (`id`, `name`, `iso_code`, `iso_code_num`, `sign`, `default_currency`, `active`) VALUES
(1, 'Euro', 'EUR', '978', '&euro;', 0, 1),
(2, 'Dolar', 'USD', '978', '&#36;', 0, 1);

--
-- Contenu de la table `declinaisons`
--

INSERT INTO `%%declinaisons` (`id`, `id_product`, `cu`, `reference`, `ean13`, `upc`, `buy_price`, `sell_price`, `price_impact`, `price`, `weight_impact`, `weight`, `unit_impact`, `unity`, `quantity`, `min_quantity`, `available_date`, `default_dec`, `images`) VALUES
(1, 1, NULL, '16V 75 AUTHENTIQUE 5P', NULL, NULL, 0, '13700', 0, NULL, 0, NULL, 0, NULL, 12, 1, NULL, 1, '1,2'),
(2, 2, NULL, 'HDI 90 4CV 99G ACTIVE 5P', NULL, NULL, 0, '17950', 0, NULL, 0, NULL, 0, NULL, 15, 3, NULL, 1, '4,6'),
(3, 3, NULL, 'TCE 125 4X4 AMBIANCE E6', NULL, NULL, 0, '16700', 0, NULL, 0, NULL, 0, NULL, 3, 1, NULL, 1, '8,9'),
(4, 17, '1:1,2:4,3:9,4:17', '', '', '', 0, '12000', 0, 0, 0, 0, 0, 0, 20, 2, '2016-06-27', 0, ''),
(5, 17, '1:3,2:5,3:9,4:27', '', '', '', 0, '30000', 0, 0, 0, 0, 0, 0, 2, 1, '2016-06-20', NULL, '');

--
-- Contenu de la table `gender`
--

INSERT INTO `%%gender` (`id`, `id_lang`, `name`) VALUES
(1, 1, 'Mr'),
(2, 1, 'Mme');



--
-- Contenu de la table `meta_value`
--
INSERT INTO `%%meta_value` (`name`, `value`) VALUES
('default_shop_theme', 'mirzam'),
('cart_labels', '{"add-to-cart":{"en":"Add to cart","fr":"Ajouter au panier"},"try":{"en":"Try","fr":"Essai"},"subscribe":{"en":"Subscribe","fr":"Souscrire"},"ask-quotation":{"en":"Ask quotation","fr":"Demande de devis"},"book":{"en":"Book Now","fr":"Réserver"},"buy":{"en":"Buy","fr":"Acheter"}}');


--
-- Contenu de la table `payment_methodes`
--

INSERT INTO `%%payment_methodes` (`id`, `value`, `description`, `image`) VALUES
(1, 'Virement bancaire', 'Payer par virement bancaire', 'modules/bankwire/assets/images/bankwire.jpg'),
(2, 'Mandat Postal', 'Payer par Mandat Postal', 'modules/os-mandatpostal/assets/images/mandatpostal.png'),
(3, 'PayPal', 'Payer par PayPal', 'modules/paypalexpress/assets/images/paypal.png'),
(4, 'Western Union', 'Payer par Western Union', 'modules/westernunion/assets/images/western.png');


--
-- Contenu de la table `products`
--

INSERT INTO `%%products` (`id`, `id_user`, `id_lang`, `id_tax`, `id_category_default`, `reference`, `upc`, `ean13`, `type`, `product_condition`, `buy_price`, `sell_price`, `packing_price`, `wholesale_price`, `wholesale_per_qty`, `discount`, `discount_type`, `width`, `height`, `depth`, `weight`, `quantity`, `min_quantity`, `loyalty_points`, `active`) VALUES
(1, 1, 1, NULL, 2, '16V 75 ALIZE 3P', NULL, NULL, 0, '', '0.00', '10090.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 50, 1, 0, 1),
(2, 1, 1, NULL, 3, '1.6 HDI 90 4CV 99G ACTIVE 5P', NULL, NULL, 0, '', '0.00', '17950.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 12, 1, 0, 1),
(3, 1, 1, NULL, 4, '1.2 TCE 125 4X4 AMBIANCE E6', NULL, NULL, 0, '', '0.00', '16700.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 32, 1, 0, 1),
(4, 1, 1, NULL, 6, 'CABRIO 55KW SALES&CARE', NULL, NULL, 0, '', '0.00', '22500.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 43, 1, 0, 1),
(5, 1, 1, NULL, 3, 'CC 1.6 E-HDI 112 FAP SPORT PACK ', NULL, NULL, 0, '', '0.00', '30850.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 54, 1, 0, 1),
(6, 1, 1, NULL, 5, '1.2 DIG-T 115 ACENTA', NULL, NULL, 0, '', '0.00', '19450.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 62, 1, 0, 1),
(7, 1, 1, NULL, 7, '1.2 PURETECH 110 FEEL', NULL, NULL, 0, '', '0.00', '21450.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 13, 1, 0, 1),
(8, 1, 1, NULL, 2, '1.5 DCI 110 BOSE EDITION ECO2', NULL, NULL, 0, '', '0.00', '30100.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 32, 1, 0, 1),
(9, 1, 1, NULL, 5, '1.5 DCI 110 6CV ACENTA', NULL, NULL, 0, '', '0.00', '26840.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 55, 1, 0, 1),
(10, 1, 1, NULL, 3, '1.6 HDI 112 FAP FELINE', NULL, NULL, 0, '', '0.00', '27550.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 78, 1, 0, 1),
(11, 1, 1, NULL, 8, 'COUPE 6.2 V8 405 BVA', NULL, NULL, 0, '', '0.00', '45000.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 90, 1, 0, 1),
(12, 1, 1, NULL, 7, 'PURETECH 110 CONFORT', NULL, NULL, 0, '', '0.00', '19350.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 120, 1, 0, 1),
(13, 1, 1, NULL, 7, 'E-MEHARI', NULL, NULL, 0, '', '0.00', '25000.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 12, 1, 0, 1),
(14, 1, 1, NULL, 7, 'PURETECH 110 CONFORT', NULL, NULL, 0, '', '0.00', '19350.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 5, 1, 0, 1),
(15, 1, 1, NULL, 9, '60 AH ATELIER', NULL, NULL, 0, '', '0.00', '35790.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 3, 1, 0, 1),
(16, 1, 1, NULL, 10, 'SPECIALE DCT', NULL, NULL, 0, '', '0.00', '204172.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 92, 1, 0, 1),
(17, 1, 1, 0, 10, 'FERRARI GTC4 LUSSO', '', '', 0, 'new', '0.00', '266196.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 37, 1, 0, 1);


--
-- Contenu de la table `product_trans`
--
INSERT INTO `%%product_trans` (`id_product`, `id_lang`, `name`, `description`, `excerpt`, `meta_title`, `meta_description`, `link_rewrite`, `meta_keywords`) VALUES
('1','1','Renault clio 3 de 2013','Bient','La Clio 3 retrouve de son p','Renault clio 3 de 2013','La Clio 3 retrouve de son p','renault-clio-3-de-2013','Renault, clio, 3, de, 2013'),
('2','1','Peugeot 207','Lorsque Peugeot a lev','Apr','Peugeot 207','Apr','peugeot-207','Peugeot, 207'),
('3','1','Dacia duster (2) 1.2 tce 125 4x4 ambiance e6','Le ph','Le Duster vient de franchir la barre du million d?exemplaires vendus dans le monde. Rien ne semble arr','Dacia duster (2) 1.2 tce 125 4x4 ambiance e6','Le Duster vient de franchir la barre du million d?exemplaires vendus dans le monde. Rien ne semble arr','dacia-duster-2-1-2-tce-125-4x4-ambiance-e6','Dacia, duster, (2), 1.2, tce, 125, 4x4, ambiance, e6'),
('4','1','Smart fortwo 2 cabrio de 2016','La Forwto est la voiture de pr','La Smart Fortwo vit ses derni','Smart fortwo 2 cabrio de 2016','La Smart Fortwo vit ses derni','smart-fortwo-2-cabrio-de-2016','Smart, fortwo, 2, cabrio, de, 2016'),
('5','1','Peugeot 308 cc de 2015','Le cabriolet n?est plus une inconnue pour le constructeur fran','Peugeot a capitalis','Peugeot 308 cc de 2015','Peugeot a capitalis','peugeot-308-cc-de-2015','Peugeot, 308, cc, de, 2015'),
('6','1','Nissan juke de 2016','Le Juke est un hit dans la gamme Nissan. Deuxi','Le Juke restyl','Nissan juke de 2016','Le Juke restyl','nissan-juke-de-2016','Nissan, juke, de, 2016'),
('7','1','Citroen c4 (2e generation) de 2016','Distanc','Citro','Citroen c4 (2e generation) de 2016','Citro','citroen-c4-2e-generation-de-2016','Citroen, c4, (2e, generation), de, 2016'),
('8','1','Renault laguna 3 de 2015','Avec 24.000 ventes en 2010, la Laguna 3 ne r','Sous des atours perfectibles, la Laguna 3 sortie en 2007 cachait des qualit','Renault laguna 3 de 2015','Sous des atours perfectibles, la Laguna 3 sortie en 2007 cachait des qualit','renault-laguna-3-de-2015','Renault, laguna, 3, de, 2015'),
('9','1','Nissan qashqai de 2015','Nissan met ','La star de Nissan profite de la synergie de groupe et re','Nissan qashqai de 2015','La star de Nissan profite de la synergie de groupe et re','nissan-qashqai-de-2015','Nissan, qashqai, de, 2015'),
('10','1','Peugeot 207 cc de 2015','Le cabriolet est plus qu?un simple effet de mode chez Peugeot. C?est un savoir-faire datant de pr','Adieu 206, bonjour 207. Le premier coup','Peugeot 207 cc de 2015','Adieu 206, bonjour 207. Le premier coup','peugeot-207-cc-de-2015','Peugeot, 207, cc, de, 2015'),
('11','1','Chevrolet camaro 5 de 2015','La Chevrolet Camaro comme la Nissan 370Z sont issues toutes deux d\'une lign','R','Chevrolet camaro 5 de 2015','R','chevrolet-camaro-5-de-2015','Chevrolet, camaro, 5, de, 2015'),
('12','1','Citroen c3 picasso de 2016','Depuis son arriv','Rejoint par une concurrence aux dents longues, le C3 Picasso, jusqu?ici leader sur le march','Citroen c3 picasso de 2016','Rejoint par une concurrence aux dents longues, le C3 Picasso, jusqu?ici leader sur le march','citroen-c3-picasso-de-2016','Citroen, c3, picasso, de, 2016'),
('13','1','Citroen e-mehari de 2016','En ce mois de mars, pour une fois fid','Vous aviez pris l\'habitude de retrouver pour chacun de nos essais importants une s','Citroen e-mehari de 2016','Vous aviez pris l\'habitude de retrouver pour chacun de nos essais importants une s','citroen-e-mehari-de-2016','Citroen, e-mehari, de, 2016'),
('14','1','Citroen c3 picasso de 2016','Depuis son arriv','Rejoint par une concurrence aux dents longues, le C3 Picasso, jusqu?ici leader sur le march','Citroen c3 picasso de 2016','Rejoint par une concurrence aux dents longues, le C3 Picasso, jusqu?ici leader sur le march','citroen-c3-picasso-de-2016','Citroen, c3, picasso, de, 2016'),
('15','1','Bmw i3','C\'est cependant ','Tout au long du d','Bmw i3','Tout au long du d','bmw-i3','Bmw, i3'),
('16','1','Ferrari 458','Ceux qui aiment les cabriolets violents chez Ferrari doivent souvent s\'armer de patience lors de la sortie d\'un nouveau produit puisque cette d','Ferrari a souvent pour habitude de d','Ferrari 458','Ferrari a souvent pour habitude de d','ferrari-458','Ferrari, 458'),
('17','1','Ferrari gtc4lusso de 2016','Ferrari va bien, merci pour lui. Au premier trimestre, le constructeur italien a battu son record historique de ventes avec 1 882 voitures ','Ferrari lance ce printemps la GTC4Lusso, qui se pr','Ferrari gtc4lusso de 2016','Ferrari lance ce printemps la GTC4Lusso, qui se pr','ferrari-gtc4lusso-de-2016','Ferrari, gtc4lusso, de, 2016');


--
-- Contenu de la table `product_associated`
--

INSERT INTO `%%product_associated` (`id`, `id_product`, `associated_with`) VALUES
(1, 1, 8),
(2, 8, 1),
(3, 2, 5),
(4, 2, 0),
(5, 5, 2),
(6, 5, 10),
(7, 6, 9),
(8, 7, 12),
(9, 7, 13),
(10, 7, 14),
(11, 12, 7),
(12, 12, 13),
(13, 12, 14),
(14, 13, 07),
(15, 13, 12),
(16, 13, 14),
(17, 14, 07),
(18, 14, 12),
(19, 14, 13),
(20, 9, 6),
(21, 10, 2),
(22, 10, 5),
(23, 16, 17),
(24, 17, 16);

--
-- Contenu de la table `product_category`
--

INSERT INTO `%%product_category` (`id_product`, `id_category`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 3),
(3, 1),
(3, 4),
(4, 1),
(4, 6),
(5, 1),
(5, 3),
(6, 1),
(6, 5),
(7, 1),
(7, 7),
(8, 1),
(8, 2),
(9, 1),
(9, 5),
(10, 1),
(10, 3),
(11, 1),
(11, 8),
(12, 1),
(12, 7),
(13, 1),
(13, 7),
(14, 1),
(14, 7),
(15, 1),
(15, 9),
(16, 1),
(16, 10),
(17, 1),
(17, 10);

--
-- Contenu de la table `product_declinaisons`
--

INSERT INTO `%%product_declinaisons` (`id`, `id_declinaison`, `id_attribute`, `id_value`) VALUES
(1, 1, 1, 3),
(2, 1, 2, 4),
(3, 1, 3, 8),
(4, 1, 4, 24),
(5, 2, 1, 3),
(6, 2, 2, 5),
(7, 2, 3, 8),
(8, 2, 4, 13),
(9, 3, 1, 3),
(10, 3, 2, 5),
(11, 3, 3, 8),
(12, 3, 4, 32),
(13, 4, 1, 1),
(14, 4, 2, 4),
(15, 4, 3, 9),
(16, 4, 4, 17),
(17, 5, 1, 3),
(18, 5, 2, 5),
(19, 5, 3, 9),
(20, 5, 4, 27);

--
-- Contenu de la table `product_images`
--

INSERT INTO `%%product_images` (`id`, `id_product`, `name`, `position`, `futured`) VALUES
(1, 1, 'renault-clio-3-1.jpg', 0, 1),
(2, 1, 'renault-clio-3-2.jpg', 0, 0),
(3, 1, 'renault-clio-3-3.jpg', 0, 0),
(4, 2, 'peugeot-207-de-2016-1.jpg', 0, 1),
(5, 2, 'peugeot-207-de-2016-2.jpg', 0, 0),
(6, 2, 'peugeot-207-de-2016-3.jpg', 0, 0),
(7, 3, 'dacia-duster-de-2016-1.jpg', 0, 1),
(8, 3, 'dacia-duster-de-2016-2.jpg', 0, 0),
(9, 3, 'dacia-duster-de-2016-3.jpg', 0, 0),
(10, 4, 'smart-fortwo-2-cabrio-de-2016-1.jpg', 0, 1),
(11, 4, 'smart-fortwo-2-cabrio-de-2016-2.jpg', 0, 0),
(12, 4, 'smart-fortwo-2-cabrio-de-2016-3.jpg', 0, 0),
(13, 5, 'peugeot-308-cc-de-2015-1.jpg', 0, 1),
(14, 5, 'peugeot-308-cc-de-2015-2.jpg', 0, 0),
(15, 5, 'peugeot-308-cc-de-2015-3.jpg', 0, 0),
(16, 6, 'nissan-juke-de-2016-1.jpg', 0, 1),
(17, 6, 'nissan-juke-de-2016-2.jpg', 0, 0),
(18, 6, 'nissan-juke-de-2016-3.jpg', 0, 0),
(19, 7, 'citroen-c4-(2e-generation)-de-2016-1.jpg', 0, 1),
(20, 7, 'citroen-c4-(2e-generation)-de-2016-2.jpg', 0, 0),
(21, 7, 'citroen-c4-(2e-generation)-de-2016-3.jpg', 0, 0),
(22, 8, 'renault-laguna-3-de-2015-1.jpeg', 0, 1),
(23, 8, 'renault-laguna-3-de-2015-2.jpg', 0, 0),
(24, 8, 'renault-laguna-3-de-2015-3.jpg', 0, 0),
(25, 9, 'nissan-qashqai-de-2015-1.jpg', 0, 1),
(26, 9, 'nissan-qashqai-de-2015-2.jpg', 0, 0),
(27, 9, 'nissan-qashqai-de-2015-3.jpg', 0, 0),
(28, 10, 'peugeot-207-cc-de-2015-1.jpg', 0, 1),
(29, 10, 'peugeot-207-cc-de-2015-2.jpg', 0, 0),
(30, 10, 'peugeot-207-cc-de-2015-3.jpg', 0, 0),
(31, 11, 'chevrolet-camaro-5-de-2015-1.jpg', 0, 1),
(32, 11, 'chevrolet-camaro-5-de-2015-2.jpg', 0, 0),
(33, 11, 'chevrolet-camaro-5-de-2015-3.jpg', 0, 0),
(34, 12, 'citroen-c3-picasso-1.jpg', 0, 1),
(35, 12, 'citroen-c3-picasso-2.jpg', 0, 0),
(36, 12, 'citroen-c3-picasso-3.jpg', 0, 0),
(37, 13, 'citroen-e-mehari-de-2016-1.jpg', 0, 1),
(38, 13, 'citroen-e-mehari-de-2016-2.jpg', 0, 0),
(39, 13, 'citroen-e-mehari-de-2016-3.jpg', 0, 0),
(40, 14, 'citroen-c3-picasso-de-2016-1.jpg', 0, 1),
(41, 14, 'citroen-c3-picasso-de-2016-2.jpg', 0, 0),
(42, 14, 'citroen-c3-picasso-de-2016-3.jpg', 0, 0),
(43, 15, 'bmw-i3-1.jpg', 0, 1),
(44, 15, 'bmw-i3-2.jpg', 0, 0),
(45, 15, 'bmw-i3-3.jpg', 0, 0),
(46, 16, 'ferrari-458-1.jpg', 0, 1),
(47, 16, 'ferrari-458-2.jpg', 0, 0),
(48, 16, 'ferrari-458-3.jpg', 0, 0),
(49, 17, 'ferrari-gtc4lusso-de-2016-1.jpg', 0, 1),
(50, 17, 'ferrari-gtc4lusso-de-2016-2.jpg', 0, 0),
(51, 17, 'ferrari-gtc4lusso-de-2016-3.jpg', 0, 0);




--
-- Contenu de la table `shop_activity`
--

INSERT INTO `%%shop_activity` (`id`, `name`) VALUES
(1, 'Alimentation et gastronomie'),
(2, 'Animaux'),
(3, 'Articles pour bébé'),
(4, 'Arts et culture'),
(5, 'Auto et moto'),
(6, 'Bijouterie'),
(7, 'Chaussures et accessoires'),
(8, 'Fleurs, cadeaux et artisanat'),
(9, 'Hifi, photo et vidéo'),
(10, 'Informatique et logiciels'),
(11, 'Lingerie et Adulte'),
(12, 'Maison et jardin'),
(13, 'Mode et accessoires'),
(14, 'Santé et beauté'),
(15, 'Services'),
(16, 'Sports et loisirs'),
(17, 'Téléchargement'),
(18, 'Télé©phonie et communication'),
(19, 'Voyage et tourisme'),
(20, 'électromÃ©nager'),
(21, 'Autre activité ...');



--
-- Contenu de la table `users_groups`
--

INSERT INTO `%%users_groups` (`id`, `name`, `slug`, `active`) VALUES
(1, 'Professionnels', 'professionnels', 1),
(2, 'Particulières', 'particulieres', 1);

--
-- Contenu de la table `zones`
--

INSERT INTO `%%zones` (`id`, `name`, `active`) VALUES
(1, 'Europe', 1),
(2, 'North America', 1),
(3, 'Asia', 1),
(4, 'Africa', 1),
(5, 'Oceania', 1),
(6, 'South America', 1),
(7, 'Europe (non-EU)', 1),
(8, 'Central America/Antilla', 1);

--
-- Contenu de la table `carrier_zones`
--

INSERT INTO `%%carrier_zones` (`id`, `id_carrier`, `id_zone`, `fees`, `active`) VALUES
(1, 1, 1, '0.00', 1),
(2, 1, 2, '0.00', 1),
(3, 1, 3, '0.00', 1),
(4, 1, 4, '0.00', 1),
(5, 1, 5, '0.00', 1),
(6, 1, 6, '0.00', 1),
(7, 1, 7, '0.00', 1),
(8, 1, 8, '0.00', 1);