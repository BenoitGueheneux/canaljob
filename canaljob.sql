-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 16 oct. 2023 à 16:49
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `canaljob`
--

-- --------------------------------------------------------

--
-- Structure de la table `collaborator`
--

DROP TABLE IF EXISTS `collaborator`;
CREATE TABLE IF NOT EXISTS `collaborator` (
  `user_source` int NOT NULL,
  `user_target` int NOT NULL,
  PRIMARY KEY (`user_source`,`user_target`),
  KEY `IDX_606D487C3AD8644E` (`user_source`),
  KEY `IDX_606D487C233D34C1` (`user_target`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `collaborator`
--

INSERT INTO `collaborator` (`user_source`, `user_target`) VALUES
(6, 9),
(6, 11),
(6, 12);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20231016024642', '2023-10-16 02:47:02', 70),
('DoctrineMigrations\\Version20231016101057', '2023-10-16 10:12:06', 225);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `first_name`, `last_name`, `address`, `phone`) VALUES
(6, 'benoit.gueheneux@hotmail.com', '[]', '$2y$13$x06CHr9WOskeTDvvtksCA.r12k22j5nizT9s2TU7COosHME488oYW', 'Benoit', 'GUEHENEUX', '16 avenue Georges Clemenceau', '+33631093256'),
(7, 'benoit@hotmail.com', '[]', '$2y$13$qmHzw5HUdErXLtZo8FYfn.gG1DrzIoknusdZGzxCFVgBey20mT3q6', 'Benoit', 'GUEHENEUX', '16 avenue Georges Clemenceau', '+33631093256'),
(8, 'benoi@hotmail.com', '[]', '$2y$13$tqwQP8I8lv7pPCowhqzt3OB/qVG5v.rjaNtFJKxIdEaoRRm.LuRUm', 'Benoit', 'GUEHENEUX', '16 avenue Georges Clemenceau', '+33631093256'),
(9, 'beno@hotmail.com', '[]', '$2y$13$64357rudaCD270RWOSD1PeKjByCnp4FNL5AefAakzhy4CqAgDZepO', 'Benoit', 'GUEHENEUX', '16 avenue Georges Clemenceau', '+33631093256'),
(10, 'ben@hotmail.com', '[]', '$2y$13$frTuvHjN.cVvdLZz9JRKYuZ4x44UsTeWcMfDQvE/mVH6GBqDFL88S', 'Benoit', 'GUEHENEUX', '16 avenue Georges Clemenceau', '+33631093256'),
(11, 'ben@hotmail.co', '[]', '$2y$13$07VM4P7EYWuNbR3ktBqTd.RJ6BOghKWlQiRWpgkjG2.u1zQvls5gm', 'Benoit', 'GUEHENEUX', '16 avenue Georges Clemenceau', '+33631093256'),
(12, 'jean@yahoo.fr', '[]', '$2y$13$GVQ07FN4qIla.PGhcXi7wOC1Ii16iWEFXtVnPIGvBjDYFQDTaajnO', 'Benoit', 'a', 'a', 'a');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `collaborator`
--
ALTER TABLE `collaborator`
  ADD CONSTRAINT `FK_606D487C233D34C1` FOREIGN KEY (`user_target`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_606D487C3AD8644E` FOREIGN KEY (`user_source`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
