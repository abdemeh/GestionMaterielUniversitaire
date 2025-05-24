-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 16, 2025 at 10:03 PM
-- Server version: 8.0.32
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestionmaterieluniversitaire`
--

-- --------------------------------------------------------

--
-- Table structure for table `ecoles`
--

DROP TABLE IF EXISTS `ecoles`;
CREATE TABLE IF NOT EXISTS `ecoles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ecoles`
--

INSERT INTO `ecoles` (`id`, `nom`, `adresse`) VALUES
(1, 'École Primaire Péguy', '12 rue des Écoles, Casablanca'),
(2, 'École Primaire Akenssouss', 'Rue Tassaout, Casablanca'),
(3, 'Lycée International de Rabat', 'Boulevard Sidi Abderrahmane, Rabat');

-- --------------------------------------------------------

--
-- Table structure for table `ecoles_matieres`
--

DROP TABLE IF EXISTS `ecoles_matieres`;
CREATE TABLE IF NOT EXISTS `ecoles_matieres` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ecole_id` int DEFAULT NULL,
  `matiere_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ecole_id` (`ecole_id`),
  KEY `matiere_id` (`matiere_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ecoles_matieres`
--

INSERT INTO `ecoles_matieres` (`id`, `ecole_id`, `matiere_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `equipements`
--

DROP TABLE IF EXISTS `equipements`;
CREATE TABLE IF NOT EXISTS `equipements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipements`
--

INSERT INTO `equipements` (`id`, `titre`, `description`) VALUES
(1, 'Carte du Maroc naturel et économique', 'Carte du Maroc naturel et économique en arabe, plastifiée, anti-reflet, format 95×110–100×120 cm'),
(2, 'Carte du monde naturel et politique', 'Carte du monde naturel et politique en arabe, plastifiée, anti-reflet, format 95×110–100×120 cm'),
(3, 'Carte des produits agricoles du Maroc', 'Carte des produits agricoles du Maroc, plastifiée, anti-reflet, format 95×110–100×120 cm'),
(4, 'Carte de la division régionale du Maroc (12 régions)', 'Carte des 12 régions du Maroc, plastifiée, anti-reflet, format 95×110–100×120 cm'),
(5, 'Carte des fleuves, villes, régions touristiques du Maroc', 'Carte des principaux fleuves, villes et régions touristiques du Maroc, plastifiée'),
(6, 'Carte topographique du Maroc', 'Carte topographique du Maroc, plastifiée, anti-reflet, format 95×110–100×120 cm'),
(7, 'Cartes naturelle et économique du continent africain', 'Cartes naturelle et économique du continent africain, plastifiées'),
(8, 'Carte des Idrissides (Idriss 1er)', 'Carte des Idrissides (Idriss 1er), plastifiée, anti-reflet'),
(9, 'Carte des Almoravides et des Almohades', 'Carte des Almoravides et Almohades, plastifiée, anti-reflet'),
(10, 'Carte de l’arrivée des Saadiens au Maroc', 'Carte de l’arrivée des Saadiens au Maroc, plastifiée, anti-reflet'),
(11, 'Carte des premières conquêtes islamiques', 'Carte des premières conquêtes islamiques, plastifiée, anti-reflet'),
(12, 'Carte du Maroc sous les Alaouites jusqu’en 1727', 'Carte du Maroc sous les Alaouites, création et extension jusqu’en 1727'),
(13, 'Globe terrestre lumineux', 'Globe terrestre lumineux d’au moins 300 mm de diamètre sur socle inoxydable'),
(14, 'Carte topographique province Elhajeb', 'Carte topographique province Elhajeb – Format 90×110 à 100×120 cm – Échelle 1:50000 – Plastifiée antireflet, rédigée en arabe, recto seul, avec œillets et légende complète'),
(15, 'Le bassin méditerranéen : naturel et économique', 'Carte du bassin méditerranéen (naturel et économique) – Format 95×110 à 100×120 cm – Plastifiée recto-verso – Quadrichromie – Œillets de suspension'),
(16, 'Le bassin méditerranéen : politique', 'Carte politique du bassin méditerranéen – Format 95×110 à 100×120 cm – Plastifiée antireflet – Œillets – Conforme aux normes pédagogiques');

-- --------------------------------------------------------

--
-- Table structure for table `matieres`
--

DROP TABLE IF EXISTS `matieres`;
CREATE TABLE IF NOT EXISTS `matieres` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `matieres`
--

INSERT INTO `matieres` (`id`, `nom`) VALUES
(1, 'Études sociales'),
(2, 'Histoire et Géographie');

-- --------------------------------------------------------

--
-- Table structure for table `matieres_equipements`
--

DROP TABLE IF EXISTS `matieres_equipements`;
CREATE TABLE IF NOT EXISTS `matieres_equipements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `matiere_id` int DEFAULT NULL,
  `equipement_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `matiere_id` (`matiere_id`),
  KEY `equipement_id` (`equipement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `matieres_equipements`
--

INSERT INTO `matieres_equipements` (`id`, `matiere_id`, `equipement_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 1, 13),
(16, 2, 14),
(17, 2, 15),
(18, 2, 16);

-- --------------------------------------------------------

--
-- Table structure for table `responsables_ecole`
--

DROP TABLE IF EXISTS `responsables_ecole`;
CREATE TABLE IF NOT EXISTS `responsables_ecole` (
  `utilisateur_id` int NOT NULL,
  `ecole_id` int NOT NULL,
  PRIMARY KEY (`utilisateur_id`),
  KEY `ecole_id` (`ecole_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `responsables_ecole`
--

INSERT INTO `responsables_ecole` (`utilisateur_id`, `ecole_id`) VALUES
(2, 1),
(3, 2),
(4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `stock_ecole`
--

DROP TABLE IF EXISTS `stock_ecole`;
CREATE TABLE IF NOT EXISTS `stock_ecole` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ecole_id` int DEFAULT NULL,
  `equipement_id` int DEFAULT NULL,
  `quantite` int DEFAULT NULL,
  `date_maj` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ecole_id` (`ecole_id`),
  KEY `equipement_id` (`equipement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_ecole`
--

INSERT INTO `stock_ecole` (`id`, `ecole_id`, `equipement_id`, `quantite`, `date_maj`) VALUES
(1, 1, 1, -3, '2025-05-15 01:52:30'),
(2, 1, 2, 8, '2025-05-16 22:12:52'),
(3, 1, 13, 1, '2025-05-01 00:00:00'),
(4, 2, 1, 2, '2025-05-02 00:00:00'),
(5, 2, 4, 4, '2025-05-02 00:00:00'),
(6, 2, 5, 6, '2025-05-02 00:00:00'),
(7, 1, 3, 4, '2025-05-15 18:22:50'),
(8, 3, 14, 5, '2025-05-15 18:20:38'),
(9, 3, 15, 3, '2025-05-15 18:20:38'),
(10, 3, 16, 4, '2025-05-15 18:20:38'),
(11, 1, 12, 4, '2025-05-15 18:22:56'),
(12, 1, 9, -4, '2025-05-15 18:23:03'),
(13, 2, 9, 300, '2025-05-15 22:25:15'),
(14, 2, 2, -6, '2025-05-15 22:35:37'),
(15, 1, 8, 4, '2025-05-16 21:53:03');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `role` enum('financier','responsable') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `email`, `mot_de_passe`, `role`) VALUES
(1, 'Asmae', 'asmae.financier@example.com', '1234', 'financier'),
(2, 'Mohamed', 'med.respo@example.com', '1234', 'responsable'),
(3, 'Khaled', 'khaled.respo@example.com', '1234', 'responsable'),
(4, 'Karim', 'karim.resp@lycee-rabat.ma', '1234', 'responsable');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ecoles_matieres`
--
ALTER TABLE `ecoles_matieres`
  ADD CONSTRAINT `ecoles_matieres_ibfk_1` FOREIGN KEY (`ecole_id`) REFERENCES `ecoles` (`id`),
  ADD CONSTRAINT `ecoles_matieres_ibfk_2` FOREIGN KEY (`matiere_id`) REFERENCES `matieres` (`id`);

--
-- Constraints for table `matieres_equipements`
--
ALTER TABLE `matieres_equipements`
  ADD CONSTRAINT `matieres_equipements_ibfk_1` FOREIGN KEY (`matiere_id`) REFERENCES `matieres` (`id`),
  ADD CONSTRAINT `matieres_equipements_ibfk_2` FOREIGN KEY (`equipement_id`) REFERENCES `equipements` (`id`);

--
-- Constraints for table `responsables_ecole`
--
ALTER TABLE `responsables_ecole`
  ADD CONSTRAINT `responsables_ecole_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `responsables_ecole_ibfk_2` FOREIGN KEY (`ecole_id`) REFERENCES `ecoles` (`id`);

--
-- Constraints for table `stock_ecole`
--
ALTER TABLE `stock_ecole`
  ADD CONSTRAINT `stock_ecole_ibfk_1` FOREIGN KEY (`ecole_id`) REFERENCES `ecoles` (`id`),
  ADD CONSTRAINT `stock_ecole_ibfk_2` FOREIGN KEY (`equipement_id`) REFERENCES `equipements` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
