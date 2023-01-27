-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 27 jan. 2023 à 09:21
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ticket`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `categorie_id` int(10) NOT NULL AUTO_INCREMENT,
  `categorie_nom` varchar(250) NOT NULL,
  PRIMARY KEY (`categorie_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `client_id` int(10) NOT NULL AUTO_INCREMENT,
  `client_nom` varchar(250) NOT NULL,
  `client_prenom` varchar(250) NOT NULL,
  `client_email` varchar(250) NOT NULL,
  `client_password` varchar(250) NOT NULL,
  `client_credit` int(10) NOT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_commande` int(10) NOT NULL AUTO_INCREMENT,
  `id_commande_client` int(10) NOT NULL,
  `date_commande` date NOT NULL,
  `montant_commande` float(10,2) NOT NULL,
  `etat_commande` enum('en attente','valide','annule') NOT NULL DEFAULT 'en attente',
  PRIMARY KEY (`id_commande`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `partie`
--

DROP TABLE IF EXISTS `partie`;
CREATE TABLE IF NOT EXISTS `partie` (
  `partie_id` int(10) NOT NULL AUTO_INCREMENT,
  `partie_ticket_id` int(10) NOT NULL,
  `partie_valeur` int(10) NOT NULL,
  `partie_date` date NOT NULL,
  `partie_etat` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`partie_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ticket`
--

DROP TABLE IF EXISTS `ticket`;
CREATE TABLE IF NOT EXISTS `ticket` (
  `ticket_id` int(10) NOT NULL AUTO_INCREMENT,
  `ticket_categorie_id` varchar(250) NOT NULL,
  `ticket_nom` varchar(250) NOT NULL,
  `ticket_prix` int(10) NOT NULL,
  `nb_ticket` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ticket_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
