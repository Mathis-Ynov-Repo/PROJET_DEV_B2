-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le :  jeu. 23 jan. 2020 à 16:16
-- Version du serveur :  10.3.12-MariaDB
-- Version de PHP :  7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `resto_dbo`
--

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Frais` double NOT NULL,
  `Id_Membre` int(11) NOT NULL,
  `DateAchat` datetime(3) NOT NULL,
  `DateReception` datetime(3) NOT NULL,
  `Prix` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_Commandes_Membres` (`Id_Membre`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `commande_plats`
--

DROP TABLE IF EXISTS `commande_plats`;
CREATE TABLE IF NOT EXISTS `commande_plats` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Prix` int(11) NOT NULL,
  `Id_Commande` int(11) NOT NULL,
  `Id_Plat` int(11) DEFAULT NULL,
  `Id_menu` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `Id_Plat` (`Id_Plat`),
  KEY `Id_menu` (`Id_menu`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commande_plats`
--

INSERT INTO `commande_plats` (`Id`, `Prix`, `Id_Commande`, `Id_Plat`, `Id_menu`) VALUES
(1, 0, 5, 4, NULL),
(2, 0, 5, 7, NULL),
(3, 0, 8, 7, NULL),
(4, 2, 8, 7, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

DROP TABLE IF EXISTS `membres`;
CREATE TABLE IF NOT EXISTS `membres` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `membres`
--

INSERT INTO `membres` (`Id`, `Libelle`) VALUES
(1, 'John'),
(2, 'Carl'),
(3, 'Antho');

-- --------------------------------------------------------

--
-- Structure de la table `membres_histo`
--

DROP TABLE IF EXISTS `membres_histo`;
CREATE TABLE IF NOT EXISTS `membres_histo` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Membre` int(11) NOT NULL,
  `DateOperation` datetime(3) NOT NULL,
  `Montant` double NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_MembresHisto_Membres` (`ID_Membre`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `membres_histo`
--

INSERT INTO `membres_histo` (`Id`, `ID_Membre`, `DateOperation`, `Montant`) VALUES
(1, 3, '3000-12-02 00:00:00.000', 20),
(2, 1, '2323-10-04 00:00:00.000', 60),
(3, 3, '2000-11-01 00:00:00.000', 80);

-- --------------------------------------------------------

--
-- Structure de la table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Libelle` varchar(255) NOT NULL,
  `Prix` int(11) NOT NULL,
  `Id_Resto` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `menu`
--

INSERT INTO `menu` (`Id`, `Libelle`, `Prix`, `Id_Resto`) VALUES
(1, 'Entrée - Plat', 15, 0);

-- --------------------------------------------------------

--
-- Structure de la table `menu_details`
--

DROP TABLE IF EXISTS `menu_details`;
CREATE TABLE IF NOT EXISTS `menu_details` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Id_Menu` int(11) NOT NULL,
  `Id_Plat` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Id_Menu` (`Id_Menu`),
  KEY `Id_Plat` (`Id_Plat`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `plats`
--

DROP TABLE IF EXISTS `plats`;
CREATE TABLE IF NOT EXISTS `plats` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Libelle` varchar(50) NOT NULL,
  `Id_Restaurant` int(11) NOT NULL,
  `Id_PlatType` int(11) NOT NULL,
  `Prix` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_Plats_Plat_types` (`Id_PlatType`),
  KEY `FK_Plats_Restaurants` (`Id_Restaurant`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `plats`
--

INSERT INTO `plats` (`Id`, `Libelle`, `Id_Restaurant`, `Id_PlatType`, `Prix`) VALUES
(1, 'Kebab', 2, 4, 8),
(2, 'Tacos', 2, 4, 9),
(3, 'Burger', 2, 4, 8),
(4, 'Coca', 2, 2, 3);

-- --------------------------------------------------------

--
-- Structure de la table `plat_types`
--

DROP TABLE IF EXISTS `plat_types`;
CREATE TABLE IF NOT EXISTS `plat_types` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Libelle` varchar(50) NOT NULL,
  `Type` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `unique_type` (`Type`)
) ;

--
-- Déchargement des données de la table `plat_types`
--

INSERT INTO `plat_types` (`Id`, `Libelle`, `Type`) VALUES
(1, 'Boisson', 1),
(2, 'Salade', 2),
(3, 'Plat', 3),
(4, 'Dessert', 4),
(5, 'Entrée', 5);

-- --------------------------------------------------------

--
-- Structure de la table `restaurants`
--

DROP TABLE IF EXISTS `restaurants`;
CREATE TABLE IF NOT EXISTS `restaurants` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Libelle` varchar(50) NOT NULL,
  `Id_Membre` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_Restaurants_Membres` (`Id_Membre`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `restaurants`
--

INSERT INTO `restaurants` (`Id`, `Libelle`, `Id_Membre`) VALUES
(1, 'Coeur', 2),
(2, 'FD', 1);

-- --------------------------------------------------------

--
-- Structure de la table `restaurateur`
--

DROP TABLE IF EXISTS `restaurateur`;
CREATE TABLE IF NOT EXISTS `restaurateur` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
