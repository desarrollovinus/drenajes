/*
Navicat MySQL Data Transfer

Source Server         : Mantenimiento
Source Server Version : 50549
Source Host           : 192.168.11.177:3306
Source Database       : drenajes

Target Server Type    : MYSQL
Target Server Version : 50549
File Encoding         : 65001

Date: 2016-06-02 15:55:35
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for calzadas
-- ----------------------------
DROP TABLE IF EXISTS `calzadas`;
CREATE TABLE `calzadas` (
  `Pk_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`Pk_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of calzadas
-- ----------------------------
INSERT INTO `calzadas` VALUES ('1', 'E');
INSERT INTO `calzadas` VALUES ('2', 'W');

-- ----------------------------
-- Table structure for drenajes_tipos
-- ----------------------------
DROP TABLE IF EXISTS `drenajes_tipos`;
CREATE TABLE `drenajes_tipos` (
  `Pk_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`Pk_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of drenajes_tipos
-- ----------------------------
INSERT INTO `drenajes_tipos` VALUES ('1', 'Longitudinal');
INSERT INTO `drenajes_tipos` VALUES ('2', 'Transversal');

-- ----------------------------
-- Table structure for estados
-- ----------------------------
DROP TABLE IF EXISTS `estados`;
CREATE TABLE `estados` (
  `Pk_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`Pk_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of estados
-- ----------------------------
INSERT INTO `estados` VALUES ('1', 'Limpio');
INSERT INTO `estados` VALUES ('2', 'Obstruido');

-- ----------------------------
-- Table structure for lados
-- ----------------------------
DROP TABLE IF EXISTS `lados`;
CREATE TABLE `lados` (
  `Pk_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`Pk_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lados
-- ----------------------------
INSERT INTO `lados` VALUES ('1', 'Derecho');
INSERT INTO `lados` VALUES ('2', 'Izquierdo');
INSERT INTO `lados` VALUES ('3', 'Separador');

-- ----------------------------
-- Table structure for mediciones
-- ----------------------------
DROP TABLE IF EXISTS `mediciones`;
CREATE TABLE `mediciones` (
  `Pk_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Descole` decimal(6,2) DEFAULT NULL,
  `Encole` decimal(6,1) DEFAULT NULL,
  `Fecha` datetime DEFAULT NULL,
  `Fk_Id_Calzada` int(11) DEFAULT NULL,
  `Fk_Id_Estado` int(11) DEFAULT NULL,
  `Fk_Id_Lado` int(11) DEFAULT NULL,
  `Fk_Id_Obra` int(11) DEFAULT NULL,
  `Fk_Id_Usuario` int(11) DEFAULT NULL,
  `Observaciones` text,
  PRIMARY KEY (`Pk_Id`),
  KEY `Fk_Id_Obra` (`Fk_Id_Obra`),
  KEY `Fk_Id_Calzada` (`Fk_Id_Calzada`),
  KEY `Fk_Id_Estado` (`Fk_Id_Estado`),
  CONSTRAINT `mediciones_ibfk_1` FOREIGN KEY (`Fk_Id_Obra`) REFERENCES `obras` (`Pk_Id`) ON DELETE CASCADE,
  CONSTRAINT `mediciones_ibfk_2` FOREIGN KEY (`Fk_Id_Obra`) REFERENCES `lados` (`Pk_Id`) ON DELETE CASCADE,
  CONSTRAINT `mediciones_ibfk_3` FOREIGN KEY (`Fk_Id_Calzada`) REFERENCES `calzadas` (`Pk_Id`) ON DELETE CASCADE,
  CONSTRAINT `mediciones_ibfk_4` FOREIGN KEY (`Fk_Id_Estado`) REFERENCES `estados` (`Pk_Id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mediciones
-- ----------------------------
INSERT INTO `mediciones` VALUES ('1', null, '40.2', null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for mediciones_fotos
-- ----------------------------
DROP TABLE IF EXISTS `mediciones_fotos`;
CREATE TABLE `mediciones_fotos` (
  `Pk_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_Archivo` varchar(175) DEFAULT NULL,
  `Fk_Id_Mediciones` int(11) DEFAULT NULL,
  PRIMARY KEY (`Pk_Id`),
  KEY `Fk_Id_Mediciones` (`Fk_Id_Mediciones`),
  CONSTRAINT `mediciones_fotos_ibfk_1` FOREIGN KEY (`Fk_Id_Mediciones`) REFERENCES `mediciones` (`Pk_Id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mediciones_fotos
-- ----------------------------

-- ----------------------------
-- Table structure for obras
-- ----------------------------
DROP TABLE IF EXISTS `obras`;
CREATE TABLE `obras` (
  `Pk_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Abscisa_Inicial` decimal(6,0) DEFAULT NULL,
  `Abscisa_Final` decimal(6,0) DEFAULT NULL,
  `Coordenadas` point DEFAULT NULL,
  `Fk_Id_Obra_Tipo` int(11) DEFAULT NULL,
  `Fk_Id_Punto_Referencia` int(11) DEFAULT NULL,
  `Fk_Id_Unidad_Funcional` int(11) DEFAULT NULL,
  `Odometro` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`Pk_Id`),
  KEY `Fk_Id_Unidad_Funcional` (`Fk_Id_Unidad_Funcional`),
  KEY `Fk_Id_Punto_Referencia` (`Fk_Id_Punto_Referencia`),
  KEY `Fk_Id_Obra_Tipo` (`Fk_Id_Obra_Tipo`),
  CONSTRAINT `obras_ibfk_1` FOREIGN KEY (`Fk_Id_Punto_Referencia`) REFERENCES `puntos_referencia` (`Pk_Id`) ON DELETE CASCADE,
  CONSTRAINT `obras_ibfk_2` FOREIGN KEY (`Fk_Id_Obra_Tipo`) REFERENCES `obras_tipos` (`Pk_Id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of obras
-- ----------------------------

-- ----------------------------
-- Table structure for obras_fotos
-- ----------------------------
DROP TABLE IF EXISTS `obras_fotos`;
CREATE TABLE `obras_fotos` (
  `Pk_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_Archivo` varchar(255) DEFAULT NULL,
  `Fk_Id_Obra` int(11) DEFAULT NULL,
  PRIMARY KEY (`Pk_Id`),
  KEY `Fk_Id_Obra` (`Fk_Id_Obra`),
  CONSTRAINT `obras_fotos_ibfk_1` FOREIGN KEY (`Fk_Id_Obra`) REFERENCES `obras` (`Pk_Id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of obras_fotos
-- ----------------------------

-- ----------------------------
-- Table structure for obras_tipos
-- ----------------------------
DROP TABLE IF EXISTS `obras_tipos`;
CREATE TABLE `obras_tipos` (
  `Pk_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(175) DEFAULT NULL,
  `Fk_Id_Drenaje_Tipo` int(11) DEFAULT NULL,
  PRIMARY KEY (`Pk_Id`),
  KEY `Fk_Id_Drenaje_Tipo` (`Fk_Id_Drenaje_Tipo`),
  CONSTRAINT `obras_tipos_ibfk_1` FOREIGN KEY (`Fk_Id_Drenaje_Tipo`) REFERENCES `drenajes_tipos` (`Pk_Id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of obras_tipos
-- ----------------------------
INSERT INTO `obras_tipos` VALUES ('1', 'Box Coulvert', '2');
INSERT INTO `obras_tipos` VALUES ('2', 'Cuneta', '2');
INSERT INTO `obras_tipos` VALUES ('3', 'Puente', '2');
INSERT INTO `obras_tipos` VALUES ('4', 'Pontón', '2');
INSERT INTO `obras_tipos` VALUES ('5', 'Alcantarilla (box)', '1');
INSERT INTO `obras_tipos` VALUES ('6', 'Alcantarilla (tubo simple)', '1');
INSERT INTO `obras_tipos` VALUES ('7', 'Alcantarilla (tubo doble)', '1');
INSERT INTO `obras_tipos` VALUES ('8', 'Alcantarilla (tubo triple)', '1');

-- ----------------------------
-- Table structure for puntos_referencia
-- ----------------------------
DROP TABLE IF EXISTS `puntos_referencia`;
CREATE TABLE `puntos_referencia` (
  `Pk_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) DEFAULT NULL,
  `Fk_Id_Unidad_Funcional` int(11) DEFAULT NULL,
  PRIMARY KEY (`Pk_Id`),
  KEY `Fk_Id_Unidad_Funcional` (`Fk_Id_Unidad_Funcional`),
  CONSTRAINT `puntos_referencia_ibfk_1` FOREIGN KEY (`Fk_Id_Unidad_Funcional`) REFERENCES `unidades_funcionales` (`Pk_Id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of puntos_referencia
-- ----------------------------
INSERT INTO `puntos_referencia` VALUES ('1', 'La Mielera', null);
INSERT INTO `puntos_referencia` VALUES ('2', 'Peaje Cisneros', null);
INSERT INTO `puntos_referencia` VALUES ('3', 'Entrada al Brasil', null);
INSERT INTO `puntos_referencia` VALUES ('4', 'Hidroeléctrica', null);
INSERT INTO `puntos_referencia` VALUES ('5', 'Base 1', null);
INSERT INTO `puntos_referencia` VALUES ('6', 'Base 2', null);
INSERT INTO `puntos_referencia` VALUES ('7', 'Santa Ana', null);
INSERT INTO `puntos_referencia` VALUES ('8', 'Peaje antiguo', null);
INSERT INTO `puntos_referencia` VALUES ('9', 'Quebrada La Sonadora', null);
INSERT INTO `puntos_referencia` VALUES ('10', 'Finca San Antonio', null);
INSERT INTO `puntos_referencia` VALUES ('11', 'Ecopetrol', null);
INSERT INTO `puntos_referencia` VALUES ('12', 'Cantayus', null);
INSERT INTO `puntos_referencia` VALUES ('13', 'Quebrada La Palma', null);
INSERT INTO `puntos_referencia` VALUES ('14', 'Cancha La Palma', null);
INSERT INTO `puntos_referencia` VALUES ('15', 'El Silencio', null);
INSERT INTO `puntos_referencia` VALUES ('16', 'Quebrada La Mina', null);
INSERT INTO `puntos_referencia` VALUES ('17', 'Finca La Palmita', null);
INSERT INTO `puntos_referencia` VALUES ('18', 'La Arenera', null);
INSERT INTO `puntos_referencia` VALUES ('19', 'Los Badeos', null);
INSERT INTO `puntos_referencia` VALUES ('20', 'Finca Nataly', null);
INSERT INTO `puntos_referencia` VALUES ('21', 'La Esperanza', null);
INSERT INTO `puntos_referencia` VALUES ('22', 'Sofía', null);
INSERT INTO `puntos_referencia` VALUES ('23', 'Quebrada 3 Jotas', null);
INSERT INTO `puntos_referencia` VALUES ('24', 'Finca el Ruby', null);
INSERT INTO `puntos_referencia` VALUES ('25', 'San Jorge', null);
INSERT INTO `puntos_referencia` VALUES ('26', 'Entrada a San Roque', null);
INSERT INTO `puntos_referencia` VALUES ('27', 'Finca El Palomar', null);
INSERT INTO `puntos_referencia` VALUES ('28', 'Recta Los Balcones', null);
INSERT INTO `puntos_referencia` VALUES ('29', 'Finca Puerta Roja', null);
INSERT INTO `puntos_referencia` VALUES ('30', 'El Basurero', null);
INSERT INTO `puntos_referencia` VALUES ('31', 'Finca La Libertad', null);
INSERT INTO `puntos_referencia` VALUES ('32', 'La Cascada', null);
INSERT INTO `puntos_referencia` VALUES ('33', 'La Terraza', null);
INSERT INTO `puntos_referencia` VALUES ('34', 'Recta Talud', null);
INSERT INTO `puntos_referencia` VALUES ('35', 'La Terraza Nro. 2', null);
INSERT INTO `puntos_referencia` VALUES ('36', 'Pradera', null);
INSERT INTO `puntos_referencia` VALUES ('37', 'La Mina', null);

-- ----------------------------
-- Table structure for unidades_funcionales
-- ----------------------------
DROP TABLE IF EXISTS `unidades_funcionales`;
CREATE TABLE `unidades_funcionales` (
  `Pk_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Codigo` varchar(3) DEFAULT NULL,
  `Nombre` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`Pk_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of unidades_funcionales
-- ----------------------------
INSERT INTO `unidades_funcionales` VALUES ('1', 'UF1', 'Pradera - Porcesito');
INSERT INTO `unidades_funcionales` VALUES ('2', 'UF2', 'Porcesito - Santiago');
INSERT INTO `unidades_funcionales` VALUES ('3', 'UF3', 'Túneles');
INSERT INTO `unidades_funcionales` VALUES ('4', 'UF4', 'El Limón - Cisneros');
INSERT INTO `unidades_funcionales` VALUES ('5', 'UF5', 'Cisneros - San José del Nus');
