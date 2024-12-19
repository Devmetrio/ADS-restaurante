-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: bdrestaurante
-- ------------------------------------------------------
-- Server version	9.1.0

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
-- Table structure for table `boletas`
--

DROP TABLE IF EXISTS `boletas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `boletas` (
  `idBoleta` int NOT NULL AUTO_INCREMENT,
  `DNI` int NOT NULL,
  `serie` int NOT NULL,
  `estadoBoleta` tinyint(1) NOT NULL,
  `idControlOrden` int NOT NULL,
  `MontoEfectivo` double DEFAULT NULL,
  `MontoVoucher` double DEFAULT NULL,
  `MontoTotal` double DEFAULT NULL,
  PRIMARY KEY (`idBoleta`),
  KEY `fk_boleta_controlorder` (`idControlOrden`),
  CONSTRAINT `fk_boleta_controlorder` FOREIGN KEY (`idControlOrden`) REFERENCES `controlordenes` (`idControlOrden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `boletas`
--

LOCK TABLES `boletas` WRITE;
/*!40000 ALTER TABLE `boletas` DISABLE KEYS */;
/*!40000 ALTER TABLE `boletas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `idTipoMenu` int NOT NULL AUTO_INCREMENT,
  `tipoNombre` varchar(50) NOT NULL,
  PRIMARY KEY (`idTipoMenu`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'Menú Kids'),(2,'Promociones Familiares'),(3,'Ensaladas para Compartir'),(4,'Ensaladas de Fondo'),(5,'Guarniciones'),(6,'Postres'),(7,'Bebidas');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `controlordenes`
--

DROP TABLE IF EXISTS `controlordenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `controlordenes` (
  `idControlOrden` int NOT NULL AUTO_INCREMENT,
  `idMesa` int NOT NULL,
  `idOrden` int DEFAULT NULL,
  `EstadoControlOrden` tinyint(1) NOT NULL,
  `idUsuario` int NOT NULL,
  `ControlFecha` varchar(10) NOT NULL,
  `ControlHora` varchar(10) NOT NULL,
  PRIMARY KEY (`idControlOrden`),
  KEY `idOrden` (`idOrden`),
  KEY `fk_mesa` (`idMesa`),
  KEY `fk_usuario` (`idUsuario`),
  CONSTRAINT `controlordenes_ibfk_1` FOREIGN KEY (`idOrden`) REFERENCES `ordenes` (`idOrden`),
  CONSTRAINT `fk_mesa` FOREIGN KEY (`idMesa`) REFERENCES `mesas` (`idMesa`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `controlordenes`
--

LOCK TABLES `controlordenes` WRITE;
/*!40000 ALTER TABLE `controlordenes` DISABLE KEYS */;
INSERT INTO `controlordenes` VALUES (32,1,9,1,1,'2024-12-10','20:38:46'),(33,2,10,1,1,'2024-12-10','20:40:18'),(34,3,11,1,1,'2024-12-10','20:42:10'),(35,4,12,1,1,'2024-12-10','20:42:53'),(36,5,13,1,1,'2024-12-10','20:43:16'),(37,7,14,1,1,'2024-12-10','21:21:53');
/*!40000 ALTER TABLE `controlordenes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facturas`
--

DROP TABLE IF EXISTS `facturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `facturas` (
  `idFactura` int NOT NULL AUTO_INCREMENT,
  `RUC` int NOT NULL,
  `razonSocial` varchar(50) NOT NULL,
  `serie` int NOT NULL,
  `estadoFactura` tinyint(1) NOT NULL,
  `idControlOrden` int NOT NULL,
  `MontoEfectivo` double DEFAULT NULL,
  `MontoVoucher` double DEFAULT NULL,
  `MontoTotal` double DEFAULT NULL,
  PRIMARY KEY (`idFactura`),
  KEY `fk_factura_controlorden` (`idControlOrden`),
  CONSTRAINT `fk_factura_controlorden` FOREIGN KEY (`idControlOrden`) REFERENCES `controlordenes` (`idControlOrden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facturas`
--

LOCK TABLES `facturas` WRITE;
/*!40000 ALTER TABLE `facturas` DISABLE KEYS */;
/*!40000 ALTER TABLE `facturas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menuitems`
--

DROP TABLE IF EXISTS `menuitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menuitems` (
  `idItem` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(150) DEFAULT NULL,
  `precio` double NOT NULL,
  `idCategoria` int DEFAULT NULL,
  PRIMARY KEY (`idItem`),
  KEY `idCategoria` (`idCategoria`),
  CONSTRAINT `menuitems_ibfk_1` FOREIGN KEY (`idCategoria`) REFERENCES `categorias` (`idTipoMenu`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menuitems`
--

LOCK TABLES `menuitems` WRITE;
/*!40000 ALTER TABLE `menuitems` DISABLE KEYS */;
INSERT INTO `menuitems` VALUES (1,'1/8 Pardos Brasa','1/8 de pollo con papas fritas y jugo rompecebras',18.9,1),(2,'Un Pardos Brasa','Con papas fritas y ensalada Pardos regular',60.9,2),(3,'Parrilla para 2','Variedad de parrilla con acompañamientos',89.9,2),(4,'Sabor para 4','Parrilla para 4 personas con guarniciones',115.9,2),(5,'Cocida','Ensalada con beterraga, zanahoria, vainita y palta',17.9,3),(6,'Fresca','Lechuga americana, tomate, rabanito y palta',17.9,3),(7,'Delicia','Lechuga americana, espinaca, choclo, tomate y queso fresco',18.9,4),(8,'César s','Lechuga romana, croutones, queso parmesano y aderezo especial',19.9,4),(9,'Sensación','Lechuga americana, espinaca, tomate, manzana y pecanas',20.9,4),(10,'Honey','Croutones, lechuga, espinaca, beterraga, zanahoria y queso fresco',20.9,4),(11,'Papas Fritas (1/2 Porción)','Papas fritas clásicas',7.9,5),(12,'Papas Fritas (Porción Completa)','Papas fritas clásicas',13.9,5),(13,'Papas Doradas','Papas doradas al horno',13.9,5),(14,'Choclo','Choclo con mantequilla',9.9,5),(15,'Torta de Chocolate','Deliciosa torta de chocolate',15.5,6),(16,'Tres Leches','Clásico postre Tres Leches',15.5,6),(17,'Pie de Limón','Postre refrescante de limón',15.5,6),(18,'Chicha Pardos (Vaso)','Refresco tradicional',6.9,7),(19,'Chicha Pardos (Jarra)','Refresco tradicional en jarra',20.9,7),(20,'Limonada Frozen (Vaso)','Limonada helada',8.9,7),(21,'Coca Cola (500ml)','Gaseosa regular',6.9,7),(22,'Café Americano','Café negro',9.9,7),(23,'Capuccino','Café con espuma de leche',10.9,7);
/*!40000 ALTER TABLE `menuitems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mesaestados`
--

DROP TABLE IF EXISTS `mesaestados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mesaestados` (
  `idMesaEstado` int NOT NULL AUTO_INCREMENT,
  `EstadoNombre` varchar(20) NOT NULL,
  PRIMARY KEY (`idMesaEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mesaestados`
--

LOCK TABLES `mesaestados` WRITE;
/*!40000 ALTER TABLE `mesaestados` DISABLE KEYS */;
INSERT INTO `mesaestados` VALUES (1,'Libre'),(2,'En espera'),(3,'Ocupado');
/*!40000 ALTER TABLE `mesaestados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mesas`
--

DROP TABLE IF EXISTS `mesas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mesas` (
  `idMesa` int NOT NULL AUTO_INCREMENT,
  `capacidad` int NOT NULL,
  `idSeccion` int NOT NULL,
  `idMesaEstado` int NOT NULL,
  `estadoTecnico` tinyint(1) NOT NULL,
  PRIMARY KEY (`idMesa`),
  KEY `fk_mesaestado` (`idMesaEstado`),
  KEY `fk_seccion` (`idSeccion`),
  CONSTRAINT `fk_mesaestado` FOREIGN KEY (`idMesaEstado`) REFERENCES `mesaestados` (`idMesaEstado`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_seccion` FOREIGN KEY (`idSeccion`) REFERENCES `secciones` (`idSeccion`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mesas`
--

LOCK TABLES `mesas` WRITE;
/*!40000 ALTER TABLE `mesas` DISABLE KEYS */;
INSERT INTO `mesas` VALUES (1,4,1,3,0),(2,2,1,3,1),(3,6,1,3,1),(4,6,1,3,1),(5,4,1,3,1),(6,6,1,2,0),(7,4,1,3,1),(8,2,1,3,1),(9,2,1,2,1),(10,6,1,2,1),(12,6,1,1,1),(13,6,1,1,1),(14,4,1,1,1),(15,6,1,1,1),(16,4,1,1,1),(17,4,1,1,1),(18,6,1,1,1),(21,2,1,1,1);
/*!40000 ALTER TABLE `mesas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mesasecundariareservas`
--

DROP TABLE IF EXISTS `mesasecundariareservas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mesasecundariareservas` (
  `idReserva` int NOT NULL,
  `idMesa` int NOT NULL,
  PRIMARY KEY (`idReserva`,`idMesa`),
  KEY `fk_idmesamesasecundaria` (`idMesa`),
  CONSTRAINT `fk_idmesamesasecundaria` FOREIGN KEY (`idMesa`) REFERENCES `mesas` (`idMesa`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_idreservamesasecundaria` FOREIGN KEY (`idReserva`) REFERENCES `reservas` (`idReserva`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mesasecundariareservas`
--

LOCK TABLES `mesasecundariareservas` WRITE;
/*!40000 ALTER TABLE `mesasecundariareservas` DISABLE KEYS */;
INSERT INTO `mesasecundariareservas` VALUES (1,2),(1,3),(6,12),(7,12),(7,14),(9,17);
/*!40000 ALTER TABLE `mesasecundariareservas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mesasecundarias`
--

DROP TABLE IF EXISTS `mesasecundarias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mesasecundarias` (
  `idControlOrden` int NOT NULL,
  `idMesa` int NOT NULL,
  PRIMARY KEY (`idControlOrden`,`idMesa`),
  KEY `fk_mesasecundaria_mesa` (`idMesa`),
  CONSTRAINT `fk_mesasecundaria_controlorden` FOREIGN KEY (`idControlOrden`) REFERENCES `controlordenes` (`idControlOrden`),
  CONSTRAINT `fk_mesasecundaria_mesa` FOREIGN KEY (`idMesa`) REFERENCES `mesas` (`idMesa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mesasecundarias`
--

LOCK TABLES `mesasecundarias` WRITE;
/*!40000 ALTER TABLE `mesasecundarias` DISABLE KEYS */;
/*!40000 ALTER TABLE `mesasecundarias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notificaciones`
--

DROP TABLE IF EXISTS `notificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notificaciones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `accion` varchar(50) NOT NULL,
  `detalles` text NOT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `procesado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificaciones`
--

LOCK TABLES `notificaciones` WRITE;
/*!40000 ALTER TABLE `notificaciones` DISABLE KEYS */;
INSERT INTO `notificaciones` VALUES (1,'actualizar_estado','ID Mesa: 2, Estado anterior: 2, Nuevo estado: 1','2024-12-03 07:25:57',1),(2,'actualizar_estado','ID Mesa: 3, Estado anterior: 1, Nuevo estado: 2','2024-12-03 07:25:57',1),(3,'actualizar_estado','ID Mesa: 3, Estado anterior: 2, Nuevo estado: 3','2024-12-03 08:05:13',1),(4,'actualizar_estado','ID Mesa: 2, Estado anterior: 1, Nuevo estado: 3','2024-12-03 08:05:14',1),(5,'actualizar_estado','ID Mesa: 2, Estado anterior: 3, Nuevo estado: 1','2024-12-03 08:17:22',1),(6,'actualizar_estado','ID Mesa: 3, Estado anterior: 3, Nuevo estado: 1','2024-12-03 08:17:22',1),(7,'actualizar_estado','ID Mesa: 2, Estado anterior: 1, Nuevo estado: 2','2024-12-03 08:19:58',1),(8,'actualizar_estado','ID Mesa: 3, Estado anterior: 1, Nuevo estado: 2','2024-12-03 08:19:58',1),(9,'actualizar_estado','ID Mesa: 3, Estado anterior: 2, Nuevo estado: 3','2024-12-03 08:31:25',1),(10,'actualizar_estado','ID Mesa: 2, Estado anterior: 2, Nuevo estado: 3','2024-12-03 08:31:25',1),(11,'actualizar_estado','ID Mesa: 1, Estado anterior: 1, Nuevo estado: 3','2024-12-03 08:31:25',1),(12,'actualizar_estado','ID Mesa: 1, Estado anterior: 3, Nuevo estado: 1','2024-12-03 08:36:25',1),(13,'actualizar_estado','ID Mesa: 2, Estado anterior: 3, Nuevo estado: 1','2024-12-03 08:36:25',1),(14,'actualizar_estado','ID Mesa: 3, Estado anterior: 3, Nuevo estado: 1','2024-12-03 08:36:25',1),(15,'actualizar_estado','ID Mesa: 1, Estado anterior: 1, Nuevo estado: 3','2024-12-03 08:49:03',1),(16,'actualizar_estado','ID Mesa: 2, Estado anterior: 1, Nuevo estado: 3','2024-12-03 08:49:03',1),(17,'actualizar_estado','ID Mesa: 3, Estado anterior: 1, Nuevo estado: 3','2024-12-03 08:49:03',1),(18,'actualizar_estado','ID Mesa: 1, Estado anterior: 3, Nuevo estado: 1','2024-12-03 08:49:46',1),(19,'actualizar_estado','ID Mesa: 2, Estado anterior: 3, Nuevo estado: 1','2024-12-03 08:49:46',1),(20,'actualizar_estado','ID Mesa: 3, Estado anterior: 3, Nuevo estado: 1','2024-12-03 08:49:46',1),(21,'actualizar_estado','ID Mesa: 1, Estado anterior: 1, Nuevo estado: 2','2024-12-03 08:50:16',1),(22,'actualizar_estado','ID Mesa: 2, Estado anterior: 1, Nuevo estado: 2','2024-12-03 08:50:16',1),(23,'actualizar_estado','ID Mesa: 3, Estado anterior: 1, Nuevo estado: 2','2024-12-03 08:50:16',1),(24,'actualizar_estado','ID Mesa: 5, Estado anterior: 2, Nuevo estado: 3','2024-12-10 14:00:28',1),(25,'actualizar_estado','ID Mesa: 3, Estado anterior: 2, Nuevo estado: 3','2024-12-10 14:00:28',1),(26,'actualizar_estado','ID Mesa: 2, Estado anterior: 2, Nuevo estado: 3','2024-12-10 14:00:28',1),(27,'actualizar_estado','ID Mesa: 1, Estado anterior: 2, Nuevo estado: 3','2024-12-10 14:00:28',1),(28,'actualizar_estado','ID Mesa: 7, Estado anterior: 1, Nuevo estado: 2','2024-12-10 14:01:10',1),(29,'actualizar_estado','ID Mesa: 8, Estado anterior: 1, Nuevo estado: 2','2024-12-10 14:01:10',1),(30,'actualizar_estado','ID Mesa: 8, Estado anterior: 2, Nuevo estado: 3','2024-12-11 01:31:58',1),(31,'actualizar_estado','ID Mesa: 7, Estado anterior: 2, Nuevo estado: 3','2024-12-11 01:35:08',1),(32,'actualizar_estado','ID Mesa: 1, Estado anterior: 3, Nuevo estado: 2','2024-12-11 01:38:28',1),(33,'actualizar_estado','ID Mesa: 2, Estado anterior: 3, Nuevo estado: 2','2024-12-11 01:38:28',1),(34,'actualizar_estado','ID Mesa: 3, Estado anterior: 3, Nuevo estado: 2','2024-12-11 01:38:28',1),(35,'actualizar_estado','ID Mesa: 4, Estado anterior: 3, Nuevo estado: 2','2024-12-11 01:38:28',1),(36,'actualizar_estado','ID Mesa: 5, Estado anterior: 3, Nuevo estado: 2','2024-12-11 01:38:28',1),(37,'actualizar_estado','ID Mesa: 6, Estado anterior: 1, Nuevo estado: 2','2024-12-11 01:38:28',1),(38,'actualizar_estado','ID Mesa: 7, Estado anterior: 3, Nuevo estado: 2','2024-12-11 01:38:28',1),(39,'actualizar_estado','ID Mesa: 8, Estado anterior: 3, Nuevo estado: 2','2024-12-11 01:38:28',1),(40,'actualizar_estado','ID Mesa: 9, Estado anterior: 1, Nuevo estado: 2','2024-12-11 01:38:28',1),(41,'actualizar_estado','ID Mesa: 10, Estado anterior: 1, Nuevo estado: 2','2024-12-11 01:38:28',1),(42,'actualizar_estado','ID Mesa: 1, Estado anterior: 2, Nuevo estado: 3','2024-12-11 01:39:58',1),(43,'actualizar_estado','ID Mesa: 2, Estado anterior: 2, Nuevo estado: 3','2024-12-11 01:41:46',1),(44,'actualizar_estado','ID Mesa: 3, Estado anterior: 2, Nuevo estado: 3','2024-12-11 01:42:20',1),(45,'actualizar_estado','ID Mesa: 4, Estado anterior: 2, Nuevo estado: 3','2024-12-11 01:43:09',1),(46,'actualizar_estado','ID Mesa: 5, Estado anterior: 2, Nuevo estado: 3','2024-12-11 01:43:26',1),(47,'actualizar_estado','ID Mesa: 7, Estado anterior: 2, Nuevo estado: 3','2024-12-11 02:24:43',1),(48,'actualizar_estado','ID Mesa: 8, Estado anterior: 2, Nuevo estado: 3','2024-12-14 09:01:39',1);
/*!40000 ALTER TABLE `notificaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordendetalles`
--

DROP TABLE IF EXISTS `ordendetalles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ordendetalles` (
  `idItem` int NOT NULL,
  `cantidad` int NOT NULL,
  `idOrden` int NOT NULL,
  `subtotal` double DEFAULT '0',
  PRIMARY KEY (`idItem`,`idOrden`),
  KEY `idOrden` (`idOrden`),
  CONSTRAINT `ordendetalles_ibfk_1` FOREIGN KEY (`idItem`) REFERENCES `menuitems` (`idItem`),
  CONSTRAINT `ordendetalles_ibfk_2` FOREIGN KEY (`idOrden`) REFERENCES `ordenes` (`idOrden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordendetalles`
--

LOCK TABLES `ordendetalles` WRITE;
/*!40000 ALTER TABLE `ordendetalles` DISABLE KEYS */;
INSERT INTO `ordendetalles` VALUES (1,1,9,18.9),(1,1,11,18.9),(1,1,13,18.9),(2,1,10,60.9),(2,2,13,121.8),(4,1,12,115.9),(5,1,12,17.9),(6,1,11,17.9),(6,1,12,17.9),(7,1,10,18.9),(7,1,14,18.9),(8,1,14,19.9),(9,1,10,20.9),(9,1,14,20.9),(11,1,9,7.9),(11,1,11,7.9),(11,1,12,7.9),(11,1,13,7.9),(11,1,15,7.9),(12,1,9,13.9),(12,1,11,13.9),(12,1,12,13.9),(12,1,13,13.9),(12,1,14,13.9),(12,1,15,13.9),(13,1,11,13.9),(13,1,15,13.9),(14,1,15,9.9),(15,1,9,15.5),(16,1,9,15.5),(16,1,13,15.5),(17,1,11,15.5),(17,1,14,15.5),(19,1,10,20.9),(20,1,10,8.9),(21,2,12,13.8);
/*!40000 ALTER TABLE `ordendetalles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordenes`
--

DROP TABLE IF EXISTS `ordenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ordenes` (
  `idOrden` int NOT NULL AUTO_INCREMENT,
  `OrdenHora` varchar(10) NOT NULL,
  PRIMARY KEY (`idOrden`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordenes`
--

LOCK TABLES `ordenes` WRITE;
/*!40000 ALTER TABLE `ordenes` DISABLE KEYS */;
INSERT INTO `ordenes` VALUES (9,'20:39:58'),(10,'20:41:46'),(11,'20:42:20'),(12,'20:43:09'),(13,'20:43:26'),(14,'21:24:43'),(15,'04:01:39');
/*!40000 ALTER TABLE `ordenes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservaestados`
--

DROP TABLE IF EXISTS `reservaestados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservaestados` (
  `idEstado` int NOT NULL AUTO_INCREMENT,
  `NombreEstado` varchar(20) NOT NULL,
  PRIMARY KEY (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservaestados`
--

LOCK TABLES `reservaestados` WRITE;
/*!40000 ALTER TABLE `reservaestados` DISABLE KEYS */;
INSERT INTO `reservaestados` VALUES (1,'En curso'),(2,'Realizado'),(3,'Cancelado');
/*!40000 ALTER TABLE `reservaestados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservas`
--

DROP TABLE IF EXISTS `reservas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservas` (
  `idReserva` int NOT NULL AUTO_INCREMENT,
  `idMesa` int NOT NULL,
  `idEstado` int NOT NULL,
  `fechaReserva` date DEFAULT NULL,
  `horaReserva` time DEFAULT NULL,
  `nombreCliente` varchar(50) NOT NULL,
  `celularCliente` int NOT NULL,
  PRIMARY KEY (`idReserva`),
  KEY `fk_mesasreservas` (`idMesa`),
  KEY `fk_estadoreservas` (`idEstado`),
  CONSTRAINT `fk_estadoreservas` FOREIGN KEY (`idEstado`) REFERENCES `reservaestados` (`idEstado`),
  CONSTRAINT `fk_mesasreservas` FOREIGN KEY (`idMesa`) REFERENCES `mesas` (`idMesa`)
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservas`
--

LOCK TABLES `reservas` WRITE;
/*!40000 ALTER TABLE `reservas` DISABLE KEYS */;
INSERT INTO `reservas` VALUES (1,1,1,'2024-12-17','12:00:00','Luis Villegas',987654321),(2,1,1,'2024-12-15','12:30:00','Luis Villegas',987654321),(3,2,1,'2024-12-15','14:00:00','Carlos Perez',987654322),(4,3,1,'2024-12-15','16:00:00','Maria Lopez',987654323),(5,9,1,'2024-12-19','12:30:00','Laura Fernández',919012345),(6,10,1,'2024-12-19','14:30:00','Juan Torres',920123456),(7,13,1,'2024-12-17','16:30:00','Felipe Herrera',912345123),(9,16,1,'2024-12-19','18:30:00','Antonio Jiménez',934567890),(97,5,1,'2024-12-16','20:00:00','Pedro Sánchez',916789012),(98,6,1,'2024-12-17','12:00:00','Sofía Díaz',917890123),(99,8,1,'2024-12-17','16:00:00','Laura Fernández',919012345),(101,7,1,'2024-12-17','14:00:00','Juan Torres',918901234),(102,9,1,'2024-12-17','18:00:00','Felipe Herrera',920123456),(103,10,1,'2024-12-17','20:00:00','Marta González',921234567),(104,12,1,'2024-12-18','14:00:00','Lucía López',923456789),(105,13,1,'2024-12-18','16:00:00','Antonio Jiménez',924567890),(106,14,1,'2024-12-18','18:00:00','Rosa Díaz',925678901),(107,15,1,'2024-12-18','20:00:00','Fernando Vázquez',926789012),(108,16,1,'2024-12-19','12:00:00','Julia Martínez',927890123),(109,17,1,'2024-12-19','14:00:00','Pedro González',928901234),(110,18,1,'2024-12-19','16:00:00','Juan Carlos Pérez',929012345);
/*!40000 ALTER TABLE `reservas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `idRol` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'anfitrion de bienvenida'),(2,'anfitrion de servicio'),(3,'cajero'),(4,'administrador');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `secciones`
--

DROP TABLE IF EXISTS `secciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `secciones` (
  `idSeccion` int NOT NULL AUTO_INCREMENT,
  `seccionNombre` varchar(50) NOT NULL,
  PRIMARY KEY (`idSeccion`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `secciones`
--

LOCK TABLES `secciones` WRITE;
/*!40000 ALTER TABLE `secciones` DISABLE KEYS */;
INSERT INTO `secciones` VALUES (1,'Piso 01');
/*!40000 ALTER TABLE `secciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `idUsuario` int NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `password` varchar(40) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `idRol` int DEFAULT NULL,
  PRIMARY KEY (`idUsuario`),
  KEY `idRol` (`idRol`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`idRol`) REFERENCES `roles` (`idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'GermanA','germanA',1,2);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-19  0:43:25
