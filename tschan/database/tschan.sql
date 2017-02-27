-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Sam 14 Janvier 2017 à 16:06
-- Version du serveur :  5.6.33
-- Version de PHP :  7.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `TSchan`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `type` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(123) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `category`
--

INSERT INTO `category` (`id`, `type`, `category`) VALUES
(1, 'a', 'Drawings and Anime'),
(2, 'b', 'Random'),
(3, 'c', 'Cats'),
(4, 'f', 'Mode'),
(5, 'l', 'Lyrics'),
(6, 'n', 'News'),
(7, 'r', 'Request'),
(8, 's', 'Taylor\'s Squad'),
(9, 't', 'Thoughts and Things'),
(10, 'x', 'Conspiracy'),
(11, 'gif', 'Animated GIFs'),
(12, 'hr', 'High Resolution');

-- --------------------------------------------------------

--
-- Structure de la table `reply`
--

CREATE TABLE `reply` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Anonymous',
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `file` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `reply`
--

INSERT INTO `reply` (`id`, `thread_id`, `name`, `comment`, `date`, `file`) VALUES
(1, 1, 'Anonymous', 'First comment approve this message!\r\nQueen Taytay will always be loved <3', '2008-08-08 08:42:42', ''),
(2, 1, 'Anonymous', 'Second comment is just a try, but also the proof of my love for Taylor Swift', '1992-05-29 00:00:00', ''),
(3, 3, 'Anonymous', 'This first answer from the chan confirms that Queen Taytay is not just Queen of all human beings, but also the Goddess Queen of all gods', '2016-12-28 03:29:56', ''),
(10, 1, 'Anonymous', '8', '2016-12-28 04:59:13', ''),
(11, 1, 'Anonymous', '42', '2016-12-28 04:59:16', ''),
(20, 21, 'Anonymous', 'test', '2017-01-04 09:26:11', ''),
(21, 21, 'Anonymous', 'qrgs', '2017-01-04 09:26:49', ''),
(26, 136, 'Anonymous', 'And it also work for replies', '2017-01-14 13:40:37', 'r261483922679473.gif'),
(27, 136, 'Anonymous', 'Even if you drag n drop many images ?', '2017-01-14 13:42:03', 'r271483922936720.gif'),
(29, 46, 'Anonymous', 'Big image to confirm', '2017-01-14 15:58:01', 'r28collage-20141111155502169.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `thread`
--

CREATE TABLE `thread` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(63) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(42) COLLATE utf8mb4_unicode_ci DEFAULT 'Anonymous',
  `comment` longtext COLLATE utf8mb4_unicode_ci,
  `date` datetime DEFAULT NULL,
  `file` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `thread`
--

INSERT INTO `thread` (`id`, `category_id`, `title`, `name`, `comment`, `date`, `file`) VALUES
(1, 2, 'First thread', 'Anonymous', 'First thread is random. Taylor Swift is THE queen', '2008-08-08 08:08:08', NULL),
(2, 2, 'Try', 'Anonymous', 'Second try just to celebrate Miss Swift perfection and to try the going of TSchan', '2016-12-23 10:03:08', NULL),
(3, 2, 'BIIIIIM', 'Anonymous', 'First time where Taylor\'s inspiring talent and beauty lead us to write a new thread from the chan dedicated to her.\r\n<script>while (1 == 1) {alert (\'Taylor Swift is the best person on Earth <3\');}</script>', '2016-12-28 01:33:32', NULL),
(16, 11, 'First GIF', 'Anonymous', 'FIRST GIF :D\r\nThanks Taylor for all the motivation you gave me just being you <3', '2016-12-28 19:49:25', 't16bravo.gif'),
(17, 6, 'TaylorSwiftchan', 'Anonymous', 'We dedicate this message to Queen Taytay.\r\nThis chan is 100% done', '2016-12-31 02:18:17', 't17gif.gif'),
(21, 2, 'Test JS', 'Anonymous', 'Test JS', '2017-01-03 11:05:23', 't21bravo.gif'),
(46, 2, 'DONE', '', '100% Done <3', '2017-01-10 14:30:04', 't46TAYLOR-SWIFT-countrywestern-country-western-pop-blonde-babe-synthpop-1920x1080.jpg'),
(136, 6, 'FINALLY OVER', 'Anonymous', 'We finnaly finished all JS applications', '2017-01-14 13:40:10', 't1361483920729591.jpg');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `thread`
--
ALTER TABLE `thread`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `reply`
--
ALTER TABLE `reply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT pour la table `thread`
--
ALTER TABLE `thread`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;