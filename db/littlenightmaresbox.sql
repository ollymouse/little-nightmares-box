-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           8.4.3 - MySQL Community Server - GPL
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para littlenightmaresbox
CREATE DATABASE IF NOT EXISTS `littlenightmaresbox` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `littlenightmaresbox`;

-- Copiando estrutura para tabela littlenightmaresbox.capitulo
CREATE TABLE IF NOT EXISTS `capitulo` (
  `idCap` int NOT NULL AUTO_INCREMENT,
  `capNome` varchar(150) DEFAULT NULL,
  `capDesc` varchar(250) DEFAULT NULL,
  `idPersona` int NOT NULL,
  PRIMARY KEY (`idCap`),
  UNIQUE KEY `capNome` (`capNome`),
  UNIQUE KEY `capDesc` (`capDesc`),
  KEY `idPersona` (`idPersona`),
  CONSTRAINT `capitulo_ibfk_1` FOREIGN KEY (`idPersona`) REFERENCES `personagem` (`idPersona`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela littlenightmaresbox.colecionavel
CREATE TABLE IF NOT EXISTS `colecionavel` (
  `idColecao` int NOT NULL AUTO_INCREMENT,
  `colNome` varchar(100) DEFAULT NULL,
  `colLocal` varchar(100) DEFAULT NULL,
  `colTipo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idColecao`),
  UNIQUE KEY `colNome` (`colNome`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela littlenightmaresbox.jogador
CREATE TABLE IF NOT EXISTS `jogador` (
  `idJog` int NOT NULL AUTO_INCREMENT,
  `jogNome` varchar(250) DEFAULT NULL,
  `jogEmail` varchar(250) DEFAULT NULL,
  `jogApel` varchar(250) DEFAULT NULL,
  `idProg` int DEFAULT NULL,
  PRIMARY KEY (`idJog`),
  KEY `idProg` (`idProg`),
  CONSTRAINT `jogador_ibfk_1` FOREIGN KEY (`idProg`) REFERENCES `progresso` (`idProg`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela littlenightmaresbox.local
CREATE TABLE IF NOT EXISTS `local` (
  `idLocal` int NOT NULL AUTO_INCREMENT,
  `locNome` varchar(150) DEFAULT NULL,
  `locDesc` varchar(250) DEFAULT NULL,
  `idColecao` int NOT NULL,
  PRIMARY KEY (`idLocal`),
  UNIQUE KEY `locNome` (`locNome`),
  KEY `idColecao` (`idColecao`),
  CONSTRAINT `local_ibfk_1` FOREIGN KEY (`idColecao`) REFERENCES `colecionavel` (`idColecao`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela littlenightmaresbox.personagem
CREATE TABLE IF NOT EXISTS `personagem` (
  `idPersona` int NOT NULL AUTO_INCREMENT,
  `perNome` varchar(100) DEFAULT NULL,
  `perTipo` varchar(50) DEFAULT NULL,
  `perPersonalidade` varchar(250) DEFAULT NULL,
  `perHab` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`idPersona`),
  UNIQUE KEY `perNome` (`perNome`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela littlenightmaresbox.progresso
CREATE TABLE IF NOT EXISTS `progresso` (
  `idProg` int NOT NULL AUTO_INCREMENT,
  `progDataConclusao` date DEFAULT NULL,
  `idColecao` int NOT NULL,
  `idCap` int NOT NULL,
  PRIMARY KEY (`idProg`),
  KEY `idColecao` (`idColecao`),
  KEY `idCap` (`idCap`),
  CONSTRAINT `progresso_ibfk_1` FOREIGN KEY (`idColecao`) REFERENCES `colecionavel` (`idColecao`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `progresso_ibfk_2` FOREIGN KEY (`idCap`) REFERENCES `capitulo` (`idCap`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
cadmeow