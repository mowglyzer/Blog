-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 04 mars 2021 à 09:50
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `title`, `content`, `date`) VALUES
(2, 'TITRE 1', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2021-02-15 11:06:45'),
(3, 'TITRE 2', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2021-02-15 11:07:43'),
(4, 'TITRE 3', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2021-02-15 11:07:43'),
(5, 'bonjour', 'blablabla !! ', '2021-02-23 15:08:02'),
(6, 're-bonjour', '\r\nYou\'re never gonna be unsatisfied.\r\nGot a motel and built a fort out of sheets.\r\nDon\'t need apologies. Boy, you\'re an alien your touch so foreign, it\'s supernatural, extraterrestrial. Talk about our future like we had a clue. I can feel a phoenix inside of me.\r\n\r\n \r\nAbout\r\nSaw you downtown singing the Blues. Watch you circle the drain. Why don\'t you let me stop by? Heavy is the head that wears the crown. Yes, we make angels cry, raining down on earth from up above.\r\n\r\nArchives\r\nMarch 2014\r\nFebruary 2014\r\nJanuary 2014\r\nDecember 2013\r\nNovember 2013\r\nOctober 2013\r\nSeptember 2013\r\nAugust 2013\r\nJuly 2013\r\nJune 2013\r\nMay 2013\r\nApril 2013\r\nElsewhere\r\nGitHub\r\nTwitter\r\n', '2021-02-23 15:36:32'),
(7, 'coucou', 'Caler le footer en bas de page\r\nUne astuce qui peut paraître banale mais quand on oublie de la mettre en place le rendu des pages avec peu de contenu et le footer en milieu de page peu faire un peu bizzare. Voyez plutôt :', '2021-02-23 16:40:22');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `articleid` int(11) NOT NULL,
  `author` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `articleid` (`articleid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `articleid`, `author`, `comment`, `date`) VALUES
(1, 4, 'momo', 'duhezindiezu', '2021-02-22 11:38:51'),
(2, 4, ' momo', 'bou', '2021-02-22 12:18:19'),
(3, 3, ' momo', 'coucou !! ', '2021-02-22 12:24:07'),
(4, 7, ' momo', 'coucou', '2021-02-23 16:49:21');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`articleid`) REFERENCES `articles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
