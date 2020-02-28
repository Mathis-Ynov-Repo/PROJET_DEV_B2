-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le :  ven. 28 fév. 2020 à 09:40
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
  `Prix` float NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Id_Membre` (`Id_Membre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `commande_plats`
--

DROP TABLE IF EXISTS `commande_plats`;
CREATE TABLE IF NOT EXISTS `commande_plats` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Prix` float NOT NULL,
  `Id_Commande` int(11) DEFAULT NULL,
  `Id_Plat` int(11) DEFAULT NULL,
  `Id_menu` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `Id_menu` (`Id_menu`),
  KEY `Id_Commande` (`Id_Commande`),
  KEY `Id_Plat` (`Id_Plat`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Libelle` varchar(255) NOT NULL,
  `Prix` float NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

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
  KEY `Id_Plat` (`Id_Plat`),
  KEY `Id_Menu` (`Id_Menu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `Prix` float NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Id_PlatType` (`Id_PlatType`),
  KEY `Id_Restaurant` (`Id_Restaurant`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

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
  `Id_Restaurateur` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Id_Restaurateur` (`Id_Restaurateur`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `restaurants`
--

INSERT INTO `restaurants` (`Id`, `Libelle`, `Id_Restaurateur`) VALUES
(1, 'Coeur', 3),
(2, 'FD', 3);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `roles` longtext NOT NULL,
  `mdp_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`Id`, `mail`, `nom`, `prenom`, `roles`, `mdp_hash`) VALUES
(1, 'h@h.h', 'user1', 'user1', '[\"ROLE_MEMBRE\"]', 'mdpd'),
(2, 'admin@admin.admin', 'admin', 'admin', '[\"ROLE_ADMIN\"]', 'mdpadmin'),
(3, 'marco@marco.marco', 'marco', 'marco', '[\"ROLE_RESTAURATEUR\"]', 'mdpresto');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`Id_Membre`) REFERENCES `utilisateurs` (`Id`);

--
-- Contraintes pour la table `commande_plats`
--
ALTER TABLE `commande_plats`
  ADD CONSTRAINT `commande_plats_ibfk_1` FOREIGN KEY (`Id_menu`) REFERENCES `menu` (`Id`),
  ADD CONSTRAINT `commande_plats_ibfk_2` FOREIGN KEY (`Id_Plat`) REFERENCES `plats` (`Id`),
  ADD CONSTRAINT `commande_plats_ibfk_3` FOREIGN KEY (`Id_Commande`) REFERENCES `commandes` (`Id`);

--
-- Contraintes pour la table `menu_details`
--
ALTER TABLE `menu_details`
  ADD CONSTRAINT `menu_details_ibfk_1` FOREIGN KEY (`Id_Plat`) REFERENCES `plats` (`Id`),
  ADD CONSTRAINT `menu_details_ibfk_2` FOREIGN KEY (`Id_Menu`) REFERENCES `menu` (`Id`);

--
-- Contraintes pour la table `plats`
--
ALTER TABLE `plats`
  ADD CONSTRAINT `plats_ibfk_1` FOREIGN KEY (`Id_PlatType`) REFERENCES `plat_types` (`Id`),
  ADD CONSTRAINT `plats_ibfk_2` FOREIGN KEY (`Id_Restaurant`) REFERENCES `restaurants` (`Id`);

--
-- Contraintes pour la table `restaurants`
--
ALTER TABLE `restaurants`
  ADD CONSTRAINT `restaurants_ibfk_1` FOREIGN KEY (`Id_Restaurateur`) REFERENCES `utilisateurs` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
