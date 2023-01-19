-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 19 jan. 2023 à 00:35
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_5_oc`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `description_article` text NOT NULL,
  `content` text NOT NULL,
  `slug` varchar(255) NOT NULL,
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image_article` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `comments_articles`
--

DROP TABLE IF EXISTS `comments_articles`;
CREATE TABLE IF NOT EXISTS `comments_articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` longtext NOT NULL,
  `id_parent` int(11) NOT NULL DEFAULT '0',
  `date_comment` datetime NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `count_reported` int(11) NOT NULL,
  `users_report` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_id` (`id_user`),
  KEY `fk_article_id` (`id_article`)
) ENGINE=InnoDB AUTO_INCREMENT=588 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_account` text NOT NULL,
  `photo` text NOT NULL,
  `type_user` varchar(255) NOT NULL DEFAULT 'user',
  `date_inscription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `key_confirm` varchar(255) NOT NULL,
  `account_confirmed` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `email`, `password_account`, `photo`, `type_user`, `date_inscription`, `key_confirm`, `account_confirmed`) VALUES
(90, 'admin', 'mail@mail.fr', '$2y$10$lIO5n76IlEfK4Fz6mYvwAO2fH6bdIMXwigmM/1Vl2ekZN/mIe2ZaK', 'default.svg', 'super_admin', '2023-01-19 01:33:43', '6149649490673967', 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments_articles`
--
ALTER TABLE `comments_articles`
  ADD CONSTRAINT `fk_article_id` FOREIGN KEY (`id_article`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
