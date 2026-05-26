-- phpMyAdmin SQL Dump
-- MyInsta - Clone Instagram
-- Version corrigée

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Base de données : `myinsta`

-- --------------------------------------------------------
-- Table `users`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `comments`;
DROP TABLE IF EXISTS `likes`;
DROP TABLE IF EXISTS `photos`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id`       INT          NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50)  NOT NULL,
  `password` VARCHAR(255) DEFAULT NULL,
  `bio`      VARCHAR(250) NOT NULL DEFAULT '',
  `avatar`   VARCHAR(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------
-- Table `photos`
-- --------------------------------------------------------

CREATE TABLE `photos` (
  `id`          INT          NOT NULL AUTO_INCREMENT,
  `link`        VARCHAR(250) NOT NULL,
  `description` VARCHAR(250) NOT NULL DEFAULT '',
  `user_id`     INT          NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_photo_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------
-- Table `likes`
-- --------------------------------------------------------

CREATE TABLE `likes` (
  `id`       INT NOT NULL AUTO_INCREMENT,
  `user_id`  INT NOT NULL,
  `photo_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_like` (`user_id`, `photo_id`),
  CONSTRAINT `fk_like_user`  FOREIGN KEY (`user_id`)  REFERENCES `users`  (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_like_photo` FOREIGN KEY (`photo_id`) REFERENCES `photos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------
-- Table `comments`
-- --------------------------------------------------------

CREATE TABLE `comments` (
  `id`         INT          NOT NULL AUTO_INCREMENT,
  `content`    VARCHAR(250) NOT NULL,
  `user_id`    INT          NOT NULL,
  `photo_id`   INT          NOT NULL,
  `created_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_comment_user`  FOREIGN KEY (`user_id`)  REFERENCES `users`  (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_comment_photo` FOREIGN KEY (`photo_id`) REFERENCES `photos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------
-- Données de démonstration
-- --------------------------------------------------------

INSERT INTO `users` (`id`, `username`, `bio`) VALUES
(1, 'OSUOD', 'Passionné de photographie ✈️');

INSERT INTO `photos` (`id`, `link`, `description`, `user_id`) VALUES
(1, '96c4f5dbd1654394dc8d06db783c76c7.jpg',           'Firestorm',  1),
(2, 'super-cobra-helicopters-celestial-images.jpg',   'Night',      1),
(3, 'wallpaperflare.com_wallpaper (1).jpg',           'The best',   1),
(4, 'wallpaperflare.com_wallpaper.jpg',               'Two',        1);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
