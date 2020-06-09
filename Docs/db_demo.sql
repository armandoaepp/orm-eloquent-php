/*
Navicat MySQL Data Transfer

Source Server         : LOCALHOST
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_tours

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2020-06-09 10:17:07
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for actividad
-- ----------------------------
DROP TABLE IF EXISTS `actividad`;
CREATE TABLE `actividad` (
  `actividad_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `horas` int(11) NOT NULL DEFAULT 0,
  `estado` char(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`actividad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of actividad
-- ----------------------------
INSERT INTO `actividad` VALUES ('1', 'Actividades acuáticas', '&lt;p&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;El concepto de actividades acuáticas ha sido acuñado recientemente en nuestra sociedad, pues a lo largo de historia el agua ha sido entendida bajo distintas concepciones, de las cuales la más conocida ha sido el término de natación. Pero, ¿Es natación todo lo que realizamos en piscina?&lt;/p&gt;', '6', '1');
INSERT INTO `actividad` VALUES ('2', 'Actividades aéreas', '&lt;p&gt;Los deportes aeronáuticos exigen capacidad física, habilidad, destreza, competitividad, afán de superación , respeto por las normas . Los deportes aéreos contribuyen a la educación del cuerpo y la mente en un ambiente técnico y en un medio singularmente bello como es el aire.&lt;/p&gt;', '5', '1');
INSERT INTO `actividad` VALUES ('3', 'Actividades acuáticas', '', '6', '1');
INSERT INTO `actividad` VALUES ('4', 'Actividades aéreas', '', '5', '1');
INSERT INTO `actividad` VALUES ('5', 'Andinismo, alpinismo', '', '2', '1');
INSERT INTO `actividad` VALUES ('6', 'Barranquismo, canyoning', '', '6', '1');
INSERT INTO `actividad` VALUES ('7', 'Bicicleta', '', '6', '1');
INSERT INTO `actividad` VALUES ('8', 'Buceo', '', '3', '1');
INSERT INTO `actividad` VALUES ('9', 'Buggies, areneros, off road', '', '2', '1');
INSERT INTO `actividad` VALUES ('10', 'Bus turístico, panorámico', '', '1', '1');
INSERT INTO `actividad` VALUES ('11', 'Caminata, senderismo, trekking', '', '2', '1');
INSERT INTO `actividad` VALUES ('12', 'Canopy, zipline, tirolesa', '', '6', '1');
INSERT INTO `actividad` VALUES ('13', 'Canotaje', '', '1', '1');
INSERT INTO `actividad` VALUES ('14', 'Cata de Vinos o Licores', '', '1', '1');
INSERT INTO `actividad` VALUES ('15', 'Compra de artesanía', '', '6', '1');
INSERT INTO `actividad` VALUES ('16', 'Cuatrimoto, Quads, ATV', '', '2', '1');
INSERT INTO `actividad` VALUES ('17', 'Degustación otras bebidas', '', '6', '1');
INSERT INTO `actividad` VALUES ('18', 'Escalada', '', '4', '1');
INSERT INTO `actividad` VALUES ('19', 'Espeleología', '', '5', '1');
INSERT INTO `actividad` VALUES ('20', 'Gastronomía', '', '1', '1');
INSERT INTO `actividad` VALUES ('21', 'Kayak, piraguismo', '', '2', '1');
INSERT INTO `actividad` VALUES ('22', 'Kitesurf', '', '3', '1');
INSERT INTO `actividad` VALUES ('23', 'Misticismo, chamanismo', '', '3', '1');
INSERT INTO `actividad` VALUES ('24', 'Moto Acuatica', '', '5', '1');
INSERT INTO `actividad` VALUES ('25', 'Motocross', '', '5', '1');
INSERT INTO `actividad` VALUES ('26', 'Museos, monumentos', '', '6', '1');
INSERT INTO `actividad` VALUES ('27', 'Observación de aves', '', '6', '1');
INSERT INTO `actividad` VALUES ('28', 'Observación fauna y flora', '', '3', '1');
INSERT INTO `actividad` VALUES ('29', 'Off Road 4x4', '', '3', '1');
INSERT INTO `actividad` VALUES ('30', 'Paintball', '', '4', '1');
INSERT INTO `actividad` VALUES ('31', 'Parapente', '', '5', '1');
INSERT INTO `actividad` VALUES ('32', 'Paseo Áreas Naturales', '', '4', '1');
INSERT INTO `actividad` VALUES ('33', 'Paseos a caballo', '', '2', '1');
INSERT INTO `actividad` VALUES ('34', 'Paseos Aéreos', '', '2', '1');
INSERT INTO `actividad` VALUES ('35', 'Paseos en Embarcaciones', '', '1', '1');
INSERT INTO `actividad` VALUES ('36', 'Paseos en otros vehículos', '', '1', '1');
INSERT INTO `actividad` VALUES ('37', 'Pesca Deportiva', '', '6', '1');
INSERT INTO `actividad` VALUES ('38', 'Remo', '', '4', '1');
INSERT INTO `actividad` VALUES ('39', 'Sandboard', '', '5', '1');
INSERT INTO `actividad` VALUES ('40', 'Shows y espectaculos', '', '2', '1');
INSERT INTO `actividad` VALUES ('41', 'Surf', '', '1', '1');
INSERT INTO `actividad` VALUES ('42', 'Teleférico, funicular, telecabinas', '', '1', '1');
INSERT INTO `actividad` VALUES ('43', 'Termalismo', '', '6', '1');
INSERT INTO `actividad` VALUES ('44', 'Visitas arqueológicas', '', '3', '1');
INSERT INTO `actividad` VALUES ('45', 'Visitas culturales', '', '3', '1');
INSERT INTO `actividad` VALUES ('46', 'Visitas guiadas', '', '1', '1');
INSERT INTO `actividad` VALUES ('47', 'Visitas Históricas', '', '2', '1');
INSERT INTO `actividad` VALUES ('48', 'Windsurf', '', '5', '1');

-- ----------------------------
-- Table structure for adicional
-- ----------------------------
DROP TABLE IF EXISTS `adicional`;
CREATE TABLE `adicional` (
  `adicional_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  PRIMARY KEY (`adicional_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of adicional
-- ----------------------------
INSERT INTO `adicional` VALUES ('1', 'Recorrido en motaxi por la ciudad', '5.00', '1');
INSERT INTO `adicional` VALUES ('2', 'Paseo en Caballo', '6.00', '1');
