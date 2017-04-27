-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 27 Avril 2017 à 10:51
-- Version du serveur :  5.5.53-0+deb8u1
-- Version de PHP :  7.0.17-1~dotdeb+8.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `projets4`
--

-- --------------------------------------------------------

--
-- Structure de la table `cartes`
--

CREATE TABLE IF NOT EXISTS `cartes` (
`id` int(11) NOT NULL,
  `categorie` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `valeur` int(11) NOT NULL,
  `image_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `extra` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `cartes`
--

INSERT INTO `cartes` (`id`, `categorie`, `nom`, `valeur`, `image_name`, `extra`, `updated_at`) VALUES
(1, 'aperitif', 'Apéro 2', 2, '58df918809fcd.png', 0, '2017-04-01 13:39:52'),
(2, 'aperitif', 'Apéro 3', 3, '58df91825a5c9.png', 0, '2017-04-01 13:39:46'),
(3, 'aperitif', 'Apéro 4', 4, '58df917c5f0f6.png', 0, '2017-04-01 13:39:40'),
(4, 'aperitif', 'Apéro 5', 5, '58df917684bde.png', 0, '2017-04-01 13:39:34'),
(5, 'aperitif', 'Apéro 6', 6, '58df916f7f75b.png', 0, '2017-04-01 13:39:27'),
(6, 'aperitif', 'Apéro 7', 7, '58df915c1455d.png', 0, '2017-04-01 13:39:08'),
(7, 'aperitif', 'Apéro 8', 8, '58df912d76983.png', 0, '2017-04-01 13:38:21'),
(8, 'aperitif', 'Apéro 9', 9, '58df91259f924.png', 0, '2017-04-01 13:38:13'),
(9, 'aperitif', 'Apéro 10', 10, '58df911ec6637.png', 0, '2017-04-01 13:38:06'),
(10, 'aperitif', 'Apéro extra 1', 0, '58df910a4f32c.png', 1, '2017-04-01 13:37:46'),
(11, 'aperitif', 'Apéro extra 2', 0, '58df9102e281d.png', 1, '2017-04-01 13:37:38'),
(12, 'aperitif', 'Apéro extra 3', 0, '58df90fa08878.png', 1, '2017-04-01 13:37:30'),
(13, 'entree', 'Entrée 2', 2, '58df90ea1164c.png', 0, '2017-04-01 13:37:14'),
(14, 'entree', 'Entrée 3', 3, '58df90e40ed10.png', 0, '2017-04-01 13:37:08'),
(15, 'entree', 'Entrée 4', 4, '58df90de3113c.png', 0, '2017-04-01 13:37:02'),
(16, 'entree', 'Entrée 5', 5, '58df90d5a991c.png', 0, '2017-04-01 13:36:53'),
(17, 'entree', 'Entrée 6', 6, '58df90cd42d61.png', 0, '2017-04-01 13:36:45'),
(18, 'entree', 'Entrée 7', 7, '58df90c6474bb.png', 0, '2017-04-01 13:36:38'),
(19, 'entree', 'Entrée 8', 8, '58df90bc5c7d5.png', 0, '2017-04-01 13:36:28'),
(20, 'entree', 'Entrée 9', 9, '58df90b551a60.png', 0, '2017-04-01 13:36:21'),
(21, 'entree', 'Entrée 10', 10, '58df90b022bd9.png', 0, '2017-04-01 13:36:16'),
(22, 'entree', 'Entrée extra 1', 0, '58df908656724.png', 1, '2017-04-01 13:35:34'),
(23, 'entree', 'Entrée extra 2', 0, '58df908041958.png', 1, '2017-04-01 13:35:28'),
(24, 'entree', 'Entrée extra 3', 0, '58df90796b4bd.png', 1, '2017-04-01 13:35:21'),
(25, 'plat', 'Plat 2', 2, '58df9021e233b.png', 0, '2017-04-01 13:33:53'),
(26, 'plat', 'Plat 3', 3, '58df901b65ee9.png', 0, '2017-04-01 13:33:47'),
(27, 'plat', 'Plat 4', 4, '58df90131ffcc.png', 0, '2017-04-01 13:33:39'),
(28, 'plat', 'Plat 5', 5, '58df900c095e5.png', 0, '2017-04-01 13:33:32'),
(29, 'plat', 'Plat 6', 6, '58df9005df714.png', 0, '2017-04-01 13:33:25'),
(30, 'plat', 'Plat 7', 7, '58df9000a86cc.png', 0, '2017-04-01 13:33:20'),
(31, 'plat', 'Plat 8', 8, '58df8ff677adf.png', 0, '2017-04-01 13:33:10'),
(32, 'plat', 'Plat 9', 9, '58df8ff0d8160.png', 0, '2017-04-01 13:33:04'),
(33, 'plat', 'Plat 10', 10, '58df8fea61b8f.png', 0, '2017-04-01 13:32:58'),
(34, 'plat', 'Plat extra 1', 0, '58df8ea672f0c.png', 1, '2017-04-01 13:27:34'),
(35, 'plat', 'Plat extra 2', 0, '58df8ea004e70.png', 1, '2017-04-01 13:27:28'),
(36, 'plat', 'Plat extra 3', 0, '58df8e98ea84b.png', 1, '2017-04-01 13:27:20'),
(37, 'laitage', 'Laitage 2', 2, '58df8e81692ef.png', 0, '2017-04-01 13:26:57'),
(38, 'laitage', 'Laitage 3', 3, '58df8e79a5233.png', 0, '2017-04-01 13:26:49'),
(39, 'laitage', 'Laitage 4', 4, '58df8e7239f03.png', 0, '2017-04-01 13:26:42'),
(40, 'laitage', 'Laitage 5', 5, '58df8e6c0a40b.png', 0, '2017-04-01 13:26:36'),
(41, 'laitage', 'Laitage 6', 6, '58df8e664c681.png', 0, '2017-04-01 13:26:30'),
(42, 'laitage', 'Laitage 7', 7, '58df8e6119d82.png', 0, '2017-04-01 13:26:25'),
(43, 'laitage', 'Laitage 8', 8, '58df8e5a8ff09.png', 0, '2017-04-01 13:26:18'),
(44, 'laitage', 'Laitage 9', 9, '58df8e558d594.png', 0, '2017-04-01 13:26:13'),
(45, 'laitage', 'Laitage 10', 10, '58df8e503a5b3.png', 0, '2017-04-01 13:26:08'),
(46, 'laitage', 'Laitage extra 1', 0, '58df8e432b075.png', 1, '2017-04-01 13:25:55'),
(47, 'laitage', 'Laitage extra 2', 0, '58df8e3a112fa.png', 1, '2017-04-01 13:25:46'),
(48, 'laitage', 'Laitage extra 3', 0, '58df8e31a37c6.png', 1, '2017-04-01 13:25:37'),
(49, 'dessert', 'Dessert 2', 2, '58df8e20e6e54.png', 0, '2017-04-01 13:25:20'),
(50, 'dessert', 'Dessert 3', 3, '58df8e1abad49.png', 0, '2017-04-01 13:25:14'),
(51, 'dessert', 'Dessert 4', 4, '58df8e13c9fb5.png', 0, '2017-04-01 13:25:07'),
(52, 'dessert', 'Dessert 5', 5, '58df8e0b366d4.png', 0, '2017-04-01 13:24:59'),
(53, 'dessert', 'Dessert 6', 6, '58df8e03988c4.png', 0, '2017-04-01 13:24:51'),
(54, 'dessert', 'Dessert 7', 7, '58df8df569c1b.png', 0, '2017-04-01 13:24:37'),
(55, 'dessert', 'Dessert 8', 8, '58df8ce21db43.png', 0, '2017-04-01 13:20:02'),
(56, 'dessert', 'Dessert 9', 9, '58df8cda07594.png', 0, '2017-04-01 13:19:54'),
(57, 'dessert', 'Dessert 10', 10, '58df8cbed902b.png', 0, '2017-04-01 13:19:26'),
(58, 'dessert', 'Dessert extra 1', 0, '58df8cb5e92f5.png', 1, '2017-04-01 13:19:17'),
(59, 'dessert', 'Dessert extra 2', 0, '58df8cad92cc3.png', 1, '2017-04-01 13:19:09'),
(60, 'dessert', 'Dessert extra 3', 0, '58df8ca15af4f.png', 1, '2017-04-01 13:18:57');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `cartes`
--
ALTER TABLE `cartes`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `cartes`
--
ALTER TABLE `cartes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=61;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
