-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: loja
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `administradores`
--

DROP TABLE IF EXISTS `administradores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `administradores` (
  `cpf_adm` varchar(11) NOT NULL,
  `email_adm` text NOT NULL,
  `senha_adm` text NOT NULL,
  PRIMARY KEY (`cpf_adm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administradores`
--

LOCK TABLES `administradores` WRITE;
/*!40000 ALTER TABLE `administradores` DISABLE KEYS */;
INSERT INTO `administradores` VALUES ('23345','vitoria@agmail.com','$2y$10$74yrzmNT2U9viYSXhs0xZOvF/o4CrP8nwC.2Wm6M/djNefC4fgtVO'),('3333','caike.dom@gmail.com','$2y$10$F2aC/XrxFs779LGKxx1yBuWBSucZHtKoxckFzLsUNvDwzMrrH5vDO'),('4444','caike.dom@gmail.com','$2y$10$kl2mhcy/6G8Mqo460tz8g.g6OsOh2QLU.g71tRRLjuBqwB5Rg5Ptu');
/*!40000 ALTER TABLE `administradores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carrinho`
--

DROP TABLE IF EXISTS `carrinho`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrinho` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_produto_adquirido` varchar(4) NOT NULL,
  `nome_produto_adquirido` text NOT NULL,
  `preco_produto_adquirido` float NOT NULL,
  `prazo_entrega_produto_adquirido` text DEFAULT NULL,
  `dono_carrinho` varchar(11) DEFAULT NULL,
  `imagem_produto_adquirido` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrinho`
--

LOCK TABLES `carrinho` WRITE;
/*!40000 ALTER TABLE `carrinho` DISABLE KEYS */;
/*!40000 ALTER TABLE `carrinho` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pessoas`
--

DROP TABLE IF EXISTS `pessoas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pessoas` (
  `nome` text NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `senha` text DEFAULT NULL,
  `email` text NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `foto` text DEFAULT NULL,
  `saldo_compra` float NOT NULL,
  PRIMARY KEY (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pessoas`
--

LOCK TABLES `pessoas` WRITE;
/*!40000 ALTER TABLE `pessoas` DISABLE KEYS */;
INSERT INTO `pessoas` VALUES ('renan','1234','$2y$10$b1Op9ntYKOzxe9JAk6l6ae55RMQ1XMbmTaq6O7vBGN65XobMvjn8u','caike.dom@gmail.com','2024-09-07 14:47:35','2024-09-07 14:47:35','imagens/IMG-20220406-WA0035.jpg',189000),('caike','18989','$2y$10$br.YP0URhHFdix/h.wpIXu/uTwSLiDZyobupf2ZtfCHhlDFbtyknG','caike.dom@gmail.com','2024-08-03 19:45:34','2024-09-07 17:00:47','imagens/IMG-20220417-WA0007.jpg',1500),('otavio','2904','$2y$10$VeyXoFr.RETjYoFO5gF1lOIhVrrfnc1NrFZ/SuK.sYihgkS8LLYx2','caike.dom@gmail.com','2025-01-14 16:56:05','2025-01-14 17:30:18','imagens/Captura de tela 2023-08-09 125507.png',159419),('caike','909090','$2y$10$Xnjp5C6us29p20Q59Ss/O.OixkaRkuYQsftDr7IdIiAzaHKsw1tzC','caike.dom@gmail.com','2025-01-13 17:15:29','2025-01-13 17:20:04','imagens/IMG-20220417-WA0007.jpg',3700);
/*!40000 ALTER TABLE `pessoas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produtos` (
  `codigo_produto` varchar(4) NOT NULL,
  `quantidade_produto` int(11) NOT NULL,
  `nome_produto` text NOT NULL,
  `preco_produto` float NOT NULL,
  `descricao_produto` text NOT NULL,
  `prazo_entrega` text NOT NULL,
  `imagem_produto` text NOT NULL,
  `quant_vendas` int(11) DEFAULT NULL,
  PRIMARY KEY (`codigo_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos`
--

LOCK TABLES `produtos` WRITE;
/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
INSERT INTO `produtos` VALUES ('0700',0,'limpa moveis',40,'produto especifico para limpeza de móveis','10 dias','ImagensProdutos/produto de limpeza.jpeg',3),('0800',64,'perfume',100,'perfume  para uso do dia-a-dia','12 dias','ImagensProdutos/perfume.webp',5),('0900',32,'estante',30000.9,'estante para quadros','3 dias','ImagensProdutos/IMG-20220330-WA0012.jpg',1),('8900',20,'produtos para cabelo',30,'kit com cremes para cuidados capilares ','15 dias','ImagensProdutos/produto para cabelo.jpg',2);
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-14 14:36:53
