-- MySQL dump 10.13  Distrib 8.0.32, for Win64 (x86_64)
--
-- Host: localhost    Database: restaurantedb
-- ------------------------------------------------------
-- Server version	8.0.32

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
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `idTipoMenu` int NOT NULL AUTO_INCREMENT,
  `tipoNombre` varchar(50) NOT NULL,
  PRIMARY KEY (`idTipoMenu`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'Menú Kids'),(2,'Promociones Familiares'),(3,'Ensaladas para Compartir'),(4,'Ensaladas de Fondo'),(5,'Guarniciones'),(6,'Postres'),(7,'Bebidas');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
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
  `mesaSecundaria` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idControlOrden`),
  KEY `idOrden` (`idOrden`),
  KEY `fk_mesa` (`idMesa`),
  KEY `fk_usuario` (`idUsuario`),
  CONSTRAINT `controlordenes_ibfk_1` FOREIGN KEY (`idOrden`) REFERENCES `ordenes` (`idOrden`),
  CONSTRAINT `fk_mesa` FOREIGN KEY (`idMesa`) REFERENCES `mesas` (`idMesa`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `controlordenes`
--

LOCK TABLES `controlordenes` WRITE;
/*!40000 ALTER TABLE `controlordenes` DISABLE KEYS */;
INSERT INTO `controlordenes` VALUES (1,1,1,1,1,'2024-12-01','12:00 PM',''),(2,2,2,1,1,'2024-12-01','01:00 PM',''),(3,3,3,1,1,'2024-12-01','02:00 PM',''),(4,4,4,1,1,'2024-12-01','03:00 PM',''),(5,5,5,1,1,'2024-12-01','04:00 PM','');
/*!40000 ALTER TABLE `controlordenes` ENABLE KEYS */;
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
  CONSTRAINT `menuitems_ibfk_1` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idTipoMenu`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menuitems`
--

LOCK TABLES `menuitems` WRITE;
/*!40000 ALTER TABLE `menuitems` DISABLE KEYS */;
INSERT INTO `menuitems` VALUES (1,'1/8 Pardos Brasa','1/8 de pollo con papas fritas y jugo rompecebras',18.9,1),(2,'Un Pardos Brasa','Con papas fritas y ensalada Pardos regular',60.9,2),(3,'Parrilla para 2','Variedad de parrilla con acompañamientos',89.9,2),(4,'Sabor para 4','Parrilla para 4 personas con guarniciones',115.9,2),(5,'Cocida','Ensalada con beterraga, zanahoria, vainita y palta',17.9,3),(6,'Fresca','Lechuga americana, tomate, rabanito y palta',17.9,3),(7,'Delicia','Lechuga americana, espinaca, choclo, tomate y queso fresco',18.9,4),(8,'César\'s','Lechuga romana, croutones, queso parmesano y aderezo especial',19.9,4),(9,'Sensación','Lechuga americana, espinaca, tomate, manzana y pecanas',20.9,4),(10,'Honey','Croutones, lechuga, espinaca, beterraga, zanahoria y queso fresco',20.9,4),(11,'Papas Fritas (1/2 Porción)','Papas fritas clásicas',7.9,5),(12,'Papas Fritas (Porción Completa)','Papas fritas clásicas',13.9,5),(13,'Papas Doradas','Papas doradas al horno',13.9,5),(14,'Choclo','Choclo con mantequilla',9.9,5),(15,'Torta de Chocolate','Deliciosa torta de chocolate',15.5,6),(16,'Tres Leches','Clásico postre Tres Leches',15.5,6),(17,'Pie de Limón','Postre refrescante de limón',15.5,6),(18,'Chicha Pardos (Vaso)','Refresco tradicional',6.9,7),(19,'Chicha Pardos (Jarra)','Refresco tradicional en jarra',20.9,7),(20,'Limonada Frozen (Vaso)','Limonada helada',8.9,7),(21,'Coca Cola (500ml)','Gaseosa regular',6.9,7),(22,'Café Americano','Café negro',9.9,7),(23,'Capuccino','Café con espuma de leche',10.9,7);
/*!40000 ALTER TABLE `menuitems` ENABLE KEYS */;
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
  PRIMARY KEY (`idMesa`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mesas`
--

LOCK TABLES `mesas` WRITE;
/*!40000 ALTER TABLE `mesas` DISABLE KEYS */;
INSERT INTO `mesas` VALUES (1,4,1,2,1),(2,2,1,2,1),(3,6,1,2,1),(4,6,1,3,1),(5,4,1,2,1),(6,6,1,1,0),(7,4,1,1,1),(8,2,1,1,1),(9,2,1,1,1),(10,6,1,1,1),(12,6,1,1,1),(13,6,1,1,1),(14,4,1,1,1),(15,6,1,1,1);
/*!40000 ALTER TABLE `mesas` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificaciones`
--

LOCK TABLES `notificaciones` WRITE;
/*!40000 ALTER TABLE `notificaciones` DISABLE KEYS */;
INSERT INTO `notificaciones` VALUES (1,'actualizar_estado','ID Mesa: 2, Estado anterior: 2, Nuevo estado: 1','2024-12-03 07:25:57',1),(2,'actualizar_estado','ID Mesa: 3, Estado anterior: 1, Nuevo estado: 2','2024-12-03 07:25:57',1),(3,'actualizar_estado','ID Mesa: 3, Estado anterior: 2, Nuevo estado: 3','2024-12-03 08:05:13',1),(4,'actualizar_estado','ID Mesa: 2, Estado anterior: 1, Nuevo estado: 3','2024-12-03 08:05:14',1),(5,'actualizar_estado','ID Mesa: 2, Estado anterior: 3, Nuevo estado: 1','2024-12-03 08:17:22',1),(6,'actualizar_estado','ID Mesa: 3, Estado anterior: 3, Nuevo estado: 1','2024-12-03 08:17:22',1),(7,'actualizar_estado','ID Mesa: 2, Estado anterior: 1, Nuevo estado: 2','2024-12-03 08:19:58',1),(8,'actualizar_estado','ID Mesa: 3, Estado anterior: 1, Nuevo estado: 2','2024-12-03 08:19:58',1),(9,'actualizar_estado','ID Mesa: 3, Estado anterior: 2, Nuevo estado: 3','2024-12-03 08:31:25',1),(10,'actualizar_estado','ID Mesa: 2, Estado anterior: 2, Nuevo estado: 3','2024-12-03 08:31:25',1),(11,'actualizar_estado','ID Mesa: 1, Estado anterior: 1, Nuevo estado: 3','2024-12-03 08:31:25',1),(12,'actualizar_estado','ID Mesa: 1, Estado anterior: 3, Nuevo estado: 1','2024-12-03 08:36:25',1),(13,'actualizar_estado','ID Mesa: 2, Estado anterior: 3, Nuevo estado: 1','2024-12-03 08:36:25',1),(14,'actualizar_estado','ID Mesa: 3, Estado anterior: 3, Nuevo estado: 1','2024-12-03 08:36:25',1),(15,'actualizar_estado','ID Mesa: 1, Estado anterior: 1, Nuevo estado: 3','2024-12-03 08:49:03',1),(16,'actualizar_estado','ID Mesa: 2, Estado anterior: 1, Nuevo estado: 3','2024-12-03 08:49:03',1),(17,'actualizar_estado','ID Mesa: 3, Estado anterior: 1, Nuevo estado: 3','2024-12-03 08:49:03',1),(18,'actualizar_estado','ID Mesa: 1, Estado anterior: 3, Nuevo estado: 1','2024-12-03 08:49:46',1),(19,'actualizar_estado','ID Mesa: 2, Estado anterior: 3, Nuevo estado: 1','2024-12-03 08:49:46',1),(20,'actualizar_estado','ID Mesa: 3, Estado anterior: 3, Nuevo estado: 1','2024-12-03 08:49:46',1),(21,'actualizar_estado','ID Mesa: 1, Estado anterior: 1, Nuevo estado: 2','2024-12-03 08:50:16',1),(22,'actualizar_estado','ID Mesa: 2, Estado anterior: 1, Nuevo estado: 2','2024-12-03 08:50:16',1),(23,'actualizar_estado','ID Mesa: 3, Estado anterior: 1, Nuevo estado: 2','2024-12-03 08:50:16',1);
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
INSERT INTO `ordendetalles` VALUES (1,2,1),(1,1,5),(2,1,2),(3,1,3),(4,1,4),(5,1,1),(6,1,2),(7,1,3),(8,2,4),(9,1,5),(11,1,1),(11,2,5),(12,1,2),(13,1,3),(14,1,4),(15,1,1),(16,2,2),(17,1,3),(18,3,4),(19,1,5);
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordenes`
--

LOCK TABLES `ordenes` WRITE;
/*!40000 ALTER TABLE `ordenes` DISABLE KEYS */;
INSERT INTO `ordenes` VALUES (1,'12:00 PM'),(2,'01:00 PM'),(3,'02:00 PM'),(4,'03:00 PM'),(5,'04:00 PM');
/*!40000 ALTER TABLE `ordenes` ENABLE KEYS */;
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

-- Dump completed on 2024-12-06  1:45:23
