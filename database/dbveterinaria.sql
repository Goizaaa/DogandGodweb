-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 06-11-2026 a las 04:34:41
-- Versión del servidor: 8.4.7
-- Versión de PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbveterinaria`
--

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `expediente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `expediente` (IN `id_mas` VARCHAR(50), OUT `nomMasc` VARCHAR(50), OUT `nomTut` VARCHAR(50), OUT `diagnosticos` VARCHAR(50), OUT `tratamientos` VARCHAR(50))   begin
select nom_mascota into nomMasc from mascota where id_mascota=id_mas;
select nom_tutor into nomTut from tutor     inner join mascota on tutor.correo_tutor=mascota.correo_tutor     where mascota.id_mascota=id_mas;
select nom_tutor into nomTut from tutor     inner join mascota on tutor.correo_tutor=mascota.correo_tutor     where mascota.id_mascota=id_mas;
select concat(nombre_medicamento, ' ', dosis) into tratamientos from tratamiento     join diagnostico on tratamiento.id_diagnostico=diagnostico.id_diagnostico     join consulta on diagnostico.id_diagnostico=consulta.id_diagnostico     join cita on cita.id_cita= consulta.id_cita     join tutor on cita.correo_tutor= tutor.correo_tutor     limit 1;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

DROP TABLE IF EXISTS `cita`;
CREATE TABLE IF NOT EXISTS `cita` (
  `id_cita` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `procedimiento` varchar(150) DEFAULT NULL,
  `correo_tutor` varchar(150) DEFAULT NULL,
  `correo_veterinario` varchar(100) DEFAULT NULL,
  `id_modificar` varchar(100) DEFAULT NULL,
  `id_creacion` varchar(100) DEFAULT NULL,
  `id_eliminar` varchar(100) DEFAULT NULL,
  `fecha_modificar` varchar(100) DEFAULT NULL,
  `fecha_crear` varchar(100) DEFAULT NULL,
  `fecha_eliminar` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_cita`),
  KEY `cita_veterinario_FK` (`correo_veterinario`),
  KEY `ixcorreo_tutor` (`correo_tutor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`id_cita`, `fecha`, `hora`, `procedimiento`, `correo_tutor`, `correo_veterinario`, `id_modificar`, `id_creacion`, `id_eliminar`, `fecha_modificar`, `fecha_crear`, `fecha_eliminar`) VALUES
('C001', '2026-03-10', '10:00:00', 'Consulta General', 'maria.gomez@mail.com', 'lopez.consulta@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C002', '2026-03-11', '11:30:00', 'Vacunación', 'juan.lopez@mail.com', 'martinez.vacunas@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C003', '2026-03-12', '09:00:00', 'Cirugía', 'ana.perez@mail.com', 'ramirez.cirugia@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C004', '2026-03-13', '14:00:00', 'Desparasitación', 'carlos.ramirez@mail.com', 'cruz.desparasitacion@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C005', '2026-03-14', '16:00:00', 'Rayos X', 'sofia.martinez@mail.com', 'vega.rayosx@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C006', '2026-03-15', '12:00:00', 'Ultrasonido', 'fernando.diaz@mail.com', 'silva.ultrasonido@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C007', '2026-03-16', '15:30:00', 'Limpieza Dental', 'laura.santos@mail.com', 'ortiz.dental@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C008', '2026-03-17', '13:00:00', 'Esterilización', 'miguel.torres@mail.com', 'torres.esterilizacion@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C009', '2026-03-18', '10:30:00', 'Hospitalización', 'paola.fernandez@mail.com', 'morales.hospital@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C010', '2026-03-19', '09:30:00', 'Emergencia', 'ricardo.mendoza@mail.com', 'herrera.emergencia@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C503', '2026-04-26', '11:00:00', 'Limpieza de Oidos', 'cliente.003@mail.com', 'cruz.desparasitacion@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C504', '2026-04-27', '08:30:00', 'Test Distemper', 'cliente.004@mail.com', 'martinez.vacunas@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C505', '2026-04-27', '09:30:00', 'Ultrasonido', 'cliente.005@mail.com', 'silva.ultrasonido@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C506', '2026-04-27', '10:30:00', 'Dermatologia', 'cliente.006@mail.com', 'lopez.consulta@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C507', '2026-04-27', '11:30:00', 'Analisis Sangre', 'cliente.007@mail.com', 'martinez.vacunas@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C508', '2026-04-28', '08:00:00', 'Control Leucemia', 'cliente.008@mail.com', 'morales.hospital@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C509', '2026-04-28', '09:00:00', 'Electrocardiograma', 'cliente.009@mail.com', 'vega.rayosx@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C510', '2026-04-28', '10:00:00', 'Desparasitacion', 'cliente.010@mail.com', 'cruz.desparasitacion@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C511', '2026-04-28', '11:00:00', 'Perfil Hepatico', 'cliente.011@mail.com', 'lopez.consulta@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C512', '2026-04-29', '09:00:00', 'Oftalmologia', 'cliente.012@mail.com', 'lopez.consulta@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C513', '2026-04-29', '10:00:00', 'Cirugia Menor', 'cliente.013@mail.com', 'ramirez.cirugia@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C514', '2026-04-29', '11:00:00', 'Test Ehrlichia', 'cliente.014@mail.com', 'cruz.desparasitacion@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C515', '2026-04-30', '08:00:00', 'Control Diabetes', 'cliente.015@mail.com', 'lopez.consulta@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C516', '2026-04-30', '09:00:00', 'Urianalisis', 'cliente.016@mail.com', 'silva.ultrasonido@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C517', '2026-04-30', '10:00:00', 'Cultivo', 'cliente.017@mail.com', 'lopez.consulta@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C518', '2026-04-30', '11:00:00', 'Endoscopia', 'cliente.018@mail.com', 'ramirez.cirugia@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C519', '2026-05-01', '09:00:00', 'Presion Arterial', 'cliente.019@mail.com', 'lopez.consulta@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C520', '2026-05-01', '10:00:00', 'Profilaxis Dental', 'cliente.020@mail.com', 'ortiz.dental@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C521', '2026-05-02', '09:00:00', 'Revision de Piel', 'cliente.021@mail.com', 'lopez.consulta@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C522', '2026-05-02', '10:00:00', 'Vacuna Rabia', 'cliente.022@mail.com', 'martinez.vacunas@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C523', '2026-05-02', '11:00:00', 'Limpieza Dental', 'cliente.023@mail.com', 'ortiz.dental@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C525', '2026-05-03', '09:30:00', 'Rayos X Cadera', 'cliente.025@mail.com', 'vega.rayosx@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C526', '2026-05-03', '10:30:00', 'Consulta General', 'cliente.026@mail.com', 'lopez.consulta@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C527', '2026-05-04', '11:30:00', 'Esterilizacion', 'cliente.027@mail.com', 'torres.esterilizacion@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C528', '2026-05-04', '13:00:00', 'Control Cardiaco', 'cliente.028@mail.com', 'morales.hospital@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C529', '2026-05-04', '15:00:00', 'Ultrasonido Renal', 'cliente.029@mail.com', 'silva.ultrasonido@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C530', '2026-05-05', '09:00:00', 'Urgencia Digestiva', 'cliente.030@mail.com', 'herrera.emergencia@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C531', '2026-05-05', '10:00:00', 'Vacunacion Triple', 'cliente.031@mail.com', 'martinez.vacunas@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C532', '2026-05-05', '11:00:00', 'Revision de Oidos', 'cliente.032@mail.com', 'lopez.consulta@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C533', '2026-05-06', '08:00:00', 'Cirugia de Tejidos', 'cliente.033@mail.com', 'ramirez.cirugia@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C534', '2026-05-06', '09:00:00', 'Test Rapido 4Dx', 'cliente.034@mail.com', 'cruz.desparasitacion@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C535', '2026-05-06', '10:00:00', 'Consulta Senior', 'cliente.035@mail.com', 'lopez.consulta@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C536', '2026-05-07', '11:00:00', 'Rayos X Torax', 'cliente.036@mail.com', 'vega.rayosx@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C537', '2026-05-07', '12:00:00', 'Limpieza Dental', 'cliente.037@mail.com', 'ortiz.dental@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C538', '2026-05-07', '13:00:00', 'Hospitalizacion Dia', 'cliente.038@mail.com', 'morales.hospital@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C539', '2026-05-08', '09:00:00', 'Control de Alergia', 'cliente.039@mail.com', 'lopez.consulta@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C540', '2026-05-08', '10:00:00', 'Ecografia Abdominal', 'cliente.140@mail.com', 'silva.ultrasonido@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C541', '2026-05-08', '11:00:00', 'Vacunacion Puppy', 'cliente.141@mail.com', 'martinez.vacunas@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C542', '2026-05-09', '08:30:00', 'Revision Quirurgica', 'cliente.142@mail.com', 'ramirez.cirugia@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C543', '2026-05-09', '09:30:00', 'Toma de Muestra', 'cliente.143@mail.com', 'lopez.consulta@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C544', '2026-05-09', '10:30:00', 'Control de Peso', 'cliente.144@mail.com', 'lopez.consulta@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C545', '2026-05-10', '09:00:00', 'Desparasitacion Ext.', 'cliente.145@mail.com', 'cruz.desparasitacion@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C546', '2026-05-10', '10:00:00', 'Consulta General', 'cliente.146@mail.com', 'lopez.consulta@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C547', '2026-05-10', '11:00:00', 'Ultrasonido Gest.', 'cliente.147@mail.com', 'silva.ultrasonido@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C548', '2026-05-11', '08:00:00', 'Vacuna Giardia', 'cliente.148@mail.com', 'martinez.vacunas@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C549', '2026-05-11', '09:00:00', 'Revision Oftalmica', 'cliente.149@mail.com', 'lopez.consulta@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C550', '2026-05-11', '10:00:00', 'Consulta de Urgencia', 'cliente.150@mail.com', 'herrera.emergencia@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C650', '2026-05-05', '12:00:00', 'Revision General', 'cliente.150@mail.com', 'lopez.consulta@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C652', '2026-10-15', '09:00:00', 'Estética', 'nuevoC@gmail.com', 'cruz.desparasitacion@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C653', '2026-10-15', '11:40:00', 'Consulta Médica', 'correo@gmail.com', 'cruz.desparasitacion@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL),
('C654', '2026-10-15', '13:00:00', 'Vacunación', 'correo@gmail.com', 'cruz.desparasitacion@vetmail.com', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta`
--

DROP TABLE IF EXISTS `consulta`;
CREATE TABLE IF NOT EXISTS `consulta` (
  `id_consulta` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `temperatura` decimal(10,0) DEFAULT NULL,
  `peso_consulta` decimal(10,0) NOT NULL,
  `frecuencia_card` smallint DEFAULT NULL,
  `id_diagnostico` varchar(100) DEFAULT NULL,
  `id_cita` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_consulta`),
  KEY `consulta_diagnostico_FK` (`id_diagnostico`),
  KEY `consulta_cita_FK` (`id_cita`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `consulta`
--

INSERT INTO `consulta` (`id_consulta`, `fecha`, `temperatura`, `peso_consulta`, `frecuencia_card`, `id_diagnostico`, `id_cita`) VALUES
('CONS001', '2026-03-10', 38, 25, 90, 'D001', 'C001'),
('CONS002', '2026-03-11', 37, 30, 85, 'D002', 'C002'),
('CONS003', '2026-03-12', 39, 5, 100, 'D003', 'C003'),
('CONS004', '2026-03-13', 37, 8, 88, 'D004', 'C004'),
('CONS005', '2026-03-14', 38, 20, 92, 'D005', 'C005'),
('CONS006', '2026-03-15', 36, 4, 80, 'D006', 'C006'),
('CONS007', '2026-03-16', 37, 2, 95, 'D007', 'C007'),
('CONS008', '2026-03-17', 38, 18, 89, 'D008', 'C008'),
('CONS009', '2026-03-18', 39, 6, 93, 'D009', 'C009'),
('CONS010', '2026-03-19', 37, 10, 87, 'D010', 'C010'),
('CONS153', '2026-04-26', 37, 30, 85, 'D153', 'C503'),
('CONS154', '2026-04-27', 38, 5, 120, 'D154', 'C504'),
('CONS155', '2026-04-27', 39, 9, 105, 'D155', 'C505'),
('CONS156', '2026-04-27', 38, 25, 90, 'D156', 'C506'),
('CONS157', '2026-04-27', 37, 6, 115, 'D157', 'C507'),
('CONS158', '2026-04-28', 38, 20, 100, 'D158', 'C508'),
('CONS159', '2026-04-28', 39, 7, 98, 'D159', 'C509'),
('CONS160', '2026-04-28', 38, 15, 102, 'D160', 'C510'),
('CONS161', '2026-04-28', 37, 12, 88, 'D161', 'C511'),
('CONS162', '2026-04-29', 38, 10, 112, 'D162', 'C512'),
('CONS163', '2026-04-29', 39, 28, 80, 'D163', 'C513'),
('CONS164', '2026-04-29', 38, 4, 130, 'D164', 'C514'),
('CONS165', '2026-04-30', 37, 22, 95, 'D165', 'C515'),
('CONS166', '2026-04-30', 38, 14, 105, 'D166', 'C516'),
('CONS167', '2026-04-30', 39, 6, 110, 'D167', 'C517'),
('CONS168', '2026-04-30', 38, 18, 92, 'D168', 'C518'),
('CONS169', '2026-05-01', 37, 5, 118, 'D169', 'C519'),
('CONS170', '2026-05-01', 38, 32, 84, 'D170', 'C520');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diagnostico`
--

DROP TABLE IF EXISTS `diagnostico`;
CREATE TABLE IF NOT EXISTS `diagnostico` (
  `id_diagnostico` varchar(100) NOT NULL,
  `fecha_diagnostico` date DEFAULT NULL,
  `analisis_clinicos` varchar(100) DEFAULT NULL,
  `detalles_diagnosticos` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_diagnostico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `diagnostico`
--

INSERT INTO `diagnostico` (`id_diagnostico`, `fecha_diagnostico`, `analisis_clinicos`, `detalles_diagnosticos`) VALUES
('D001', '2026-03-01', 'Examen físico', 'Mascota en buen estado general'),
('D002', '2026-03-02', 'Hemograma', 'Leve anemia detectada'),
('D003', '2026-03-03', 'Radiografía torácica', 'No se observan anomalías'),
('D004', '2026-03-04', 'Ultrasonido abdominal', 'Presencia de cálculos renales'),
('D005', '2026-03-05', 'Perfil bioquímico', 'Valores hepáticos elevados'),
('D006', '2026-03-06', 'Coprológico', 'Parásitos intestinales presentes'),
('D007', '2026-03-07', 'Electrocardiograma', 'Arritmia leve detectada'),
('D008', '2026-03-08', 'Examen dental', 'Gingivitis moderada'),
('D009', '2026-03-09', 'Prueba de alergias', 'Reacción positiva a polvo'),
('D010', '2026-03-10', 'Cultivo bacteriano', 'Infección urinaria confirmada'),
('D151', '2025-10-21', 'Radiografia Digital', 'Fractura distal en miembro anterior'),
('D152', '2025-10-22', 'Perfil Bioquimico', 'Insuficiencia renal leve'),
('D153', '2025-10-23', 'Citologia de Oido', 'Otitis externa por Malassezia'),
('D154', '2025-10-24', 'Test de Distemper', 'Resultado Negativo'),
('D155', '2025-10-25', 'Ultrasonido Abdominal', 'Presencia de sedimento urinario'),
('D156', '2025-10-26', 'Raspado Cutaneo', 'Demodicosis localizada'),
('D157', '2025-10-27', 'Hemograma Completo', 'Leucocitosis por infeccion bacteriana'),
('D158', '2025-10-28', 'Test de Leucemia Felina', 'Resultado Positivo - Etapa inicial'),
('D159', '2025-10-29', 'Electrocardiograma', 'Arritmia sinusal fisiologica'),
('D160', '2025-10-30', 'Examen Coprologico', 'Coccidiosis detectada'),
('D161', '2025-11-01', 'Perfil Hepatico', 'Elevacion de ALT y ALP'),
('D162', '2025-11-02', 'Oftalmoscopia', 'Ulcera corneal superficial'),
('D163', '2025-11-03', 'Biopsia de Masa', 'Lipoma benigno confirmado'),
('D164', '2025-11-04', 'Test de Ehrlichia', 'Resultado Positivo'),
('D165', '2025-11-05', 'Glucometria', 'Diabetes mellitus tipo 1'),
('D166', '2025-11-06', 'Analisis de Orina', 'Cristales de oxalato de calcio'),
('D167', '2025-11-07', 'Cultivo Bacteriano', 'Staphylococcus pseudintermedius'),
('D168', '2025-11-08', 'Endoscopia', 'Cuerpo extraño en esofago'),
('D169', '2025-11-09', 'Presion Arterial', 'Hipertension sistemica'),
('D170', '2025-11-10', 'Evaluacion Dental', 'Enfermedad periodontal grado III'),
('D171', '2025-11-11', 'Test de Parvovirus', 'Positivo - Requiere hospitalizacion'),
('D172', '2025-11-12', 'Prueba de Alergia', 'Atopia ambiental detectada'),
('D173', '2025-11-13', 'Mielograma', 'Mielitis infecciosa sospechada'),
('D174', '2025-11-14', 'Ecocardiografia', 'Estenosis pulmonar leve'),
('D175', '2025-11-15', 'Panel de Coagulacion', 'Tiempos prolongados de protrombina'),
('D176', '2025-11-16', 'Examen Fisico', 'Gingivitis y sarro abundante'),
('D177', '2025-11-17', 'Ecografia de Cuello', 'Quiste tirogloso pequeño'),
('D178', '2025-11-18', 'Test de Sida Felino', 'Resultado Negativo'),
('D179', '2025-11-19', 'Quimica 12 elementos', 'Valores dentro de rangos'),
('D180', '2025-11-20', 'Evaluacion Neurologica', 'Sindrome vestibular periferico'),
('D181', '2025-11-21', 'Citologia Vaginal', 'Estro temprano detectado'),
('D182', '2025-11-22', 'Puncion con Aguja Fina', 'Histiocitoma cutaneo'),
('D183', '2025-11-23', 'Test de Giardia', 'Positivo'),
('D184', '2025-11-24', 'Perfil Geriatrico', 'Degeneracion articular'),
('D185', '2025-11-25', 'Test de Brucelosis', 'Negativo'),
('D186', '2025-11-26', 'Evaluacion de Reflejos', 'Ataxia posterior'),
('D187', '2025-11-27', 'Otoscopia', 'Presencia de cuerpo extraño (espiga)'),
('D188', '2025-11-28', 'Test Snap 4Dx', 'Positivo a Anaplasma'),
('D189', '2025-11-29', 'Gases en Sangre', 'Acidosis metabolica compensada'),
('D190', '2025-11-30', 'Revision Post-quirurgica', 'Suturas integras sin infeccion'),
('D191', '2025-12-01', 'Hemograma', 'Anemia regenerativa'),
('D192', '2025-12-02', 'Radiografia de Torax', 'Edema pulmonar cardiogenico'),
('D193', '2025-12-03', 'Ecografia Gestacional', '3 embriones con latido'),
('D194', '2025-12-04', 'Test de Pancreatitis', 'Negativo'),
('D195', '2025-12-05', 'Tiroxina T4', 'Hipertiroidismo detectado'),
('D196', '2025-12-06', 'Cultivo Fungico', 'Microsporum canis (Tiña)'),
('D197', '2025-12-07', 'Perfil Renal', 'Creatinina elevada'),
('D198', '2025-12-08', 'Prueba de Shrimer', 'Queratoconjuntivitis seca'),
('D199', '2025-12-09', 'Linfografia', 'Linfadenopatia reactiva'),
('D200', '2025-12-10', 'Examen Fisico', 'Deshidratacion del 5%');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mascota`
--

DROP TABLE IF EXISTS `mascota`;
CREATE TABLE IF NOT EXISTS `mascota` (
  `id_mascota` varchar(25) NOT NULL,
  `nom_mascota` varchar(100) NOT NULL,
  `especie` varchar(50) NOT NULL,
  `raza` varchar(50) NOT NULL,
  `fecha_adopcion` date NOT NULL,
  `peso_inicial` decimal(10,0) NOT NULL,
  `sexo` varchar(50) NOT NULL,
  `esterilizado` tinyint(1) NOT NULL,
  `correo_tutor` varchar(150) DEFAULT NULL,
  `alergias` varchar(255) DEFAULT 'Sin alergias conocidas',
  PRIMARY KEY (`id_mascota`),
  KEY `mascota_tutor_FK` (`correo_tutor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `mascota`
--

INSERT INTO `mascota` (`id_mascota`, `nom_mascota`, `especie`, `raza`, `fecha_adopcion`, `peso_inicial`, `sexo`, `esterilizado`, `correo_tutor`, `alergias`) VALUES
('M001', 'Luna', 'Perro', 'Labrador', '2023-05-12', 25, 'Hembra', 1, 'maria.gomez@mail.com', 'Sin alergias conocidas'),
('M002', 'Max', 'Perro', 'Pastor Alemán', '2022-11-03', 30, 'Macho', 0, 'juan.lopez@mail.com', 'Sin alergias conocidas'),
('M003', 'Coco', 'Gato', 'Siamés', '2024-01-20', 5, 'Macho', 1, 'ana.perez@mail.com', 'Sin alergias conocidas'),
('M004', 'Bella', 'Perro', 'Poodle', '2023-07-15', 8, 'Hembra', 1, 'carlos.ramirez@mail.com', 'Sin alergias conocidas'),
('M005', 'Rocky', 'Perro', 'Bulldog Inglés', '2021-09-10', 20, 'Macho', 0, 'sofia.martinez@mail.com', 'Sin alergias conocidas'),
('M006', 'Nube', 'Gato', 'Persa', '2022-03-25', 4, 'Hembra', 1, 'fernando.diaz@mail.com', 'Sin alergias conocidas'),
('M007', 'Toby', 'Conejo', 'Holland Lop', '2023-02-18', 2, 'Macho', 0, 'laura.santos@mail.com', 'Sin alergias conocidas'),
('M008', 'Kira', 'Perro', 'Husky Siberiano', '2024-06-05', 18, 'Hembra', 1, 'miguel.torres@mail.com', 'Sin alergias conocidas'),
('M009', 'Simba', 'Gato', 'Maine Coon', '2021-12-30', 6, 'Macho', 1, 'paola.fernandez@mail.com', 'Sin alergias conocidas'),
('M010', 'Lola', 'Perro', 'Beagle', '2022-08-22', 10, 'Hembra', 0, 'ricardo.mendoza@mail.com', 'Sin alergias conocidas'),
('M104', 'Bella', 'Gato', 'Siames', '2024-01-15', 4, 'Hembra', 1, 'cliente.004@mail.com', 'Sin alergias conocidas'),
('M105', 'Benny', 'Perro', 'Pug', '2024-01-20', 8, 'Macho', 1, 'cliente.005@mail.com', 'Sin alergias conocidas'),
('M106', 'Bingo', 'Perro', 'Dalmata', '2024-01-25', 22, 'Macho', 0, 'cliente.006@mail.com', 'Sin alergias conocidas'),
('M107', 'Blanca', 'Gato', 'Persa', '2024-01-30', 5, 'Hembra', 1, 'cliente.007@mail.com', 'Sin alergias conocidas'),
('M108', 'Bolt', 'Perro', 'Pastor Blanco', '2024-02-01', 28, 'Macho', 1, 'cliente.008@mail.com', 'Sin alergias conocidas'),
('M109', 'Bonnie', 'Perro', 'Caniche', '2024-02-05', 6, 'Hembra', 1, 'cliente.009@mail.com', 'Sin alergias conocidas'),
('M110', 'Boris', 'Gato', 'Maine Coon', '2024-02-10', 7, 'Macho', 0, 'cliente.010@mail.com', 'Sin alergias conocidas'),
('M111', 'Brandy', 'Perro', 'Cocker', '2024-02-15', 12, 'Hembra', 1, 'cliente.011@mail.com', 'Sin alergias conocidas'),
('M112', 'Bruce', 'Perro', 'Bull Terrier', '2024-02-20', 24, 'Macho', 1, 'cliente.012@mail.com', 'Sin alergias conocidas'),
('M113', 'Bubba', 'Perro', 'Mastin', '2024-02-25', 45, 'Macho', 0, 'cliente.013@mail.com', 'Sin alergias conocidas'),
('M114', 'Cala', 'Gato', 'Bengala', '2024-03-01', 4, 'Hembra', 1, 'cliente.014@mail.com', 'Sin alergias conocidas'),
('M115', 'Capitan', 'Perro', 'Schnauzer', '2024-03-05', 9, 'Macho', 1, 'cliente.015@mail.com', 'Sin alergias conocidas'),
('M116', 'Casper', 'Gato', 'Angora', '2024-03-10', 5, 'Macho', 1, 'cliente.016@mail.com', 'Sin alergias conocidas'),
('M117', 'Chiqui', 'Perro', 'Chihuahua', '2024-03-15', 2, 'Hembra', 1, 'cliente.017@mail.com', 'Sin alergias conocidas'),
('M118', 'Clifford', 'Perro', 'San Bernardo', '2024-03-20', 60, 'Macho', 0, 'cliente.018@mail.com', 'Sin alergias conocidas'),
('M120', 'Cooper', 'Perro', 'Golden Retriever', '2024-03-30', 30, 'Macho', 1, 'cliente.020@mail.com', 'Sin alergias conocidas'),
('M121', 'Daisy', 'Perro', 'Labrador', '2024-04-01', 26, 'Hembra', 1, 'cliente.021@mail.com', 'Sin alergias conocidas'),
('M122', 'Dante', 'Perro', 'Xoloitzcuintle', '2024-04-05', 15, 'Macho', 0, 'cliente.022@mail.com', 'Sin alergias conocidas'),
('M123', 'Diva', 'Gato', 'Esfinge', '2024-04-10', 3, 'Hembra', 1, 'cliente.023@mail.com', 'Sin alergias conocidas'),
('M124', 'Duke', 'Perro', 'Gran Danes', '2024-04-15', 55, 'Macho', 1, 'cliente.024@mail.com', 'Sin alergias conocidas'),
('M125', 'Elvis', 'Perro', 'Basset Hound', '2024-04-20', 20, 'Macho', 1, 'cliente.025@mail.com', 'Sin alergias conocidas'),
('M126', 'Fiona', 'Gato', 'Ruso Azul', '2024-04-25', 4, 'Hembra', 1, 'cliente.026@mail.com', 'Sin alergias conocidas'),
('M127', 'Fluffy', 'Gato', 'Somalí', '2024-04-30', 5, 'Macho', 0, 'cliente.027@mail.com', 'Sin alergias conocidas'),
('M128', 'Gaby', 'Perro', 'Border Collie', '2024-05-01', 18, 'Hembra', 1, 'cliente.028@mail.com', 'Sin alergias conocidas'),
('M129', 'Ghost', 'Perro', 'Husky', '2024-05-05', 24, 'Macho', 1, 'cliente.029@mail.com', 'Sin alergias conocidas'),
('M130', 'Gizmo', 'Gato', 'Exotico', '2024-05-10', 4, 'Macho', 1, 'cliente.030@mail.com', 'Sin alergias conocidas'),
('M131', 'Goofy', 'Perro', 'Bloodhound', '2024-05-15', 35, 'Macho', 0, 'cliente.031@mail.com', 'Sin alergias conocidas'),
('M132', 'Gordo', 'Gato', 'Manx', '2024-05-20', 6, 'Macho', 1, 'cliente.032@mail.com', 'Sin alergias conocidas'),
('M133', 'Greta', 'Perro', 'Doberman', '2024-05-25', 28, 'Hembra', 1, 'cliente.033@mail.com', 'Sin alergias conocidas'),
('M134', 'Gus', 'Gato', 'Birmano', '2024-05-30', 5, 'Macho', 1, 'cliente.034@mail.com', 'Sin alergias conocidas'),
('M135', 'Hachi', 'Perro', 'Shiba Inu', '2024-06-01', 11, 'Macho', 1, 'cliente.035@mail.com', 'Sin alergias conocidas'),
('M136', 'Hanna', 'Perro', 'Samoyedo', '2024-06-05', 21, 'Hembra', 1, 'cliente.036@mail.com', 'Sin alergias conocidas'),
('M137', 'Harley', 'Perro', 'Pitbull', '2024-06-10', 25, 'Hembra', 0, 'cliente.037@mail.com', 'Sin alergias conocidas'),
('M138', 'Hercules', 'Perro', 'Rottweiler', '2024-06-15', 40, 'Macho', 1, 'cliente.038@mail.com', 'Sin alergias conocidas'),
('M139', 'Hera', 'Perro', 'Whippet', '2024-06-20', 12, 'Hembra', 1, 'cliente.039@mail.com', 'Sin alergias conocidas'),
('M140', 'Hodor', 'Perro', 'Terranova', '2024-06-25', 65, 'Macho', 0, 'cliente.040@mail.com', 'Sin alergias conocidas'),
('M141', 'Honey', 'Perro', 'Chow Chow', '2024-06-30', 23, 'Hembra', 1, 'cliente.041@mail.com', 'Sin alergias conocidas'),
('M142', 'Igor', 'Gato', 'Burmes', '2024-07-01', 5, 'Macho', 1, 'cliente.042@mail.com', 'Sin alergias conocidas'),
('M143', 'Indy', 'Perro', 'Pointer', '2024-07-05', 24, 'Hembra', 1, 'cliente.043@mail.com', 'Sin alergias conocidas'),
('M144', 'Jack', 'Perro', 'Jack Russell', '2024-07-10', 7, 'Macho', 1, 'cliente.044@mail.com', 'Sin alergias conocidas'),
('M145', 'Jade', 'Gato', 'Abisinio', '2024-07-15', 4, 'Hembra', 1, 'cliente.045@mail.com', 'Sin alergias conocidas'),
('M146', 'Jagger', 'Perro', 'Setter', '2024-07-20', 26, 'Macho', 0, 'cliente.046@mail.com', 'Sin alergias conocidas'),
('M147', 'Java', 'Gato', 'Bombay', '2024-07-25', 4, 'Hembra', 1, 'cliente.047@mail.com', 'Sin alergias conocidas'),
('M148', 'Jazz', 'Perro', 'Maltes', '2024-07-30', 3, 'Hembra', 1, 'cliente.048@mail.com', 'Sin alergias conocidas'),
('M149', 'Juno', 'Perro', 'Malamute', '2024-08-01', 38, 'Hembra', 1, 'cliente.049@mail.com', 'Sin alergias conocidas'),
('M150', 'Kaiser', 'Perro', 'Shar Pei', '2024-08-05', 22, 'Macho', 1, 'cliente.050@mail.com', 'Sin alergias conocidas'),
('M151', 'Kala', 'Perro', 'Pinscher', '2024-08-10', 5, 'Hembra', 1, 'cliente.051@mail.com', 'Sin alergias conocidas'),
('M152', 'Kenzo', 'Perro', 'Akita Amer.', '2024-08-15', 32, 'Macho', 1, 'cliente.052@mail.com', 'Sin alergias conocidas'),
('M153', 'Kira', 'Gato', 'Somalí', '2024-08-20', 4, 'Hembra', 1, 'cliente.053@mail.com', 'Sin alergias conocidas'),
('M154', 'Koda', 'Perro', 'Shiba Inu', '2024-08-25', 10, 'Macho', 1, 'cliente.054@mail.com', 'Sin alergias conocidas'),
('M155', 'Lana', 'Gato', 'Balines', '2024-08-30', 5, 'Hembra', 1, 'cliente.055@mail.com', 'Sin alergias conocidas'),
('M156', 'Lassy', 'Perro', 'Collie', '2024-09-01', 22, 'Hembra', 1, 'cliente.056@mail.com', 'Sin alergias conocidas'),
('M157', 'Lego', 'Gato', 'Habana', '2024-09-05', 5, 'Macho', 0, 'cliente.057@mail.com', 'Sin alergias conocidas'),
('M158', 'Leo', 'Perro', 'Leonberger', '2024-09-10', 50, 'Macho', 1, 'cliente.058@mail.com', 'Sin alergias conocidas'),
('M159', 'Lia', 'Gato', 'Korat', '2024-09-15', 4, 'Hembra', 1, 'cliente.059@mail.com', 'Sin alergias conocidas'),
('M160', 'Lobo', 'Perro', 'Checoslovaco', '2024-09-20', 32, 'Macho', 0, 'cliente.060@mail.com', 'Sin alergias conocidas'),
('M161', 'Lola', 'Gato', 'Munchkin', '2024-09-25', 3, 'Hembra', 1, 'cliente.061@mail.com', 'Sin alergias conocidas'),
('M162', 'Lucky', 'Perro', 'Bichon Frise', '2024-09-30', 6, 'Macho', 1, 'cliente.062@mail.com', 'Sin alergias conocidas'),
('M163', 'Lulu', 'Gato', 'Burmilla', '2024-10-01', 4, 'Hembra', 1, 'cliente.063@mail.com', 'Sin alergias conocidas'),
('M164', 'Mambo', 'Perro', 'Crestado Chino', '2024-10-05', 5, 'Macho', 1, 'cliente.064@mail.com', 'Sin alergias conocidas'),
('M165', 'Maya', 'Gato', 'Angora', '2024-10-10', 5, 'Hembra', 1, 'cliente.065@mail.com', 'Sin alergias conocidas'),
('M166', 'Maximus', 'Perro', 'Dogo Arg.', '2024-10-15', 42, 'Macho', 1, 'cliente.066@mail.com', 'Sin alergias conocidas'),
('M167', 'Milo', 'Gato', 'Siberiano', '2024-10-20', 6, 'Macho', 1, 'cliente.067@mail.com', 'Sin alergias conocidas'),
('M168', 'Mochi', 'Perro', 'Shih Tzu', '2024-10-25', 6, 'Hembra', 1, 'cliente.068@mail.com', 'Sin alergias conocidas'),
('M169', 'Molly', 'Gato', 'Tonquines', '2024-10-30', 4, 'Hembra', 1, 'cliente.069@mail.com', 'Sin alergias conocidas'),
('M170', 'Mufasa', 'Perro', 'Leonberger', '2024-11-01', 55, 'Macho', 0, 'cliente.070@mail.com', 'Sin alergias conocidas'),
('M171', 'Nala', 'Gato', 'Laperm', '2024-11-05', 4, 'Hembra', 1, 'cliente.071@mail.com', 'Sin alergias conocidas'),
('M172', 'Nemo', 'Perro', 'Papillon', '2024-11-10', 4, 'Macho', 1, 'cliente.072@mail.com', 'Sin alergias conocidas'),
('M173', 'Nilo', 'Gato', 'Ocicat', '2024-11-15', 6, 'Macho', 1, 'cliente.073@mail.com', 'Sin alergias conocidas'),
('M174', 'Nina', 'Perro', 'Pomerania', '2024-11-20', 3, 'Hembra', 1, 'cliente.074@mail.com', 'Sin alergias conocidas'),
('M175', 'Noa', 'Gato', 'Toyger', '2024-11-25', 5, 'Hembra', 1, 'cliente.075@mail.com', 'Sin alergias conocidas'),
('M176', 'Odín', 'Perro', 'Bullmastiff', '2024-11-30', 50, 'Macho', 1, 'cliente.076@mail.com', 'Sin alergias conocidas'),
('M177', 'Olivia', 'Gato', 'Devon Rex', '2024-12-01', 3, 'Hembra', 1, 'cliente.077@mail.com', 'Sin alergias conocidas'),
('M178', 'Oreo', 'Perro', 'Border Terrier', '2024-12-05', 7, 'Macho', 1, 'cliente.078@mail.com', 'Sin alergias conocidas'),
('M179', 'Otto', 'Gato', 'Selkirk Rex', '2024-12-10', 6, 'Macho', 1, 'cliente.079@mail.com', 'Sin alergias conocidas'),
('M180', 'Ozzy', 'Perro', 'Airedale', '2024-12-15', 25, 'Macho', 0, 'cliente.080@mail.com', 'Sin alergias conocidas'),
('M181', 'Paco', 'Gato', 'Chartreux', '2024-12-20', 6, 'Macho', 1, 'cliente.081@mail.com', 'Sin alergias conocidas'),
('M182', 'Pancha', 'Perro', 'Bulldog Fr.', '2024-12-25', 11, 'Hembra', 1, 'cliente.082@mail.com', 'Sin alergias conocidas'),
('M183', 'Panda', 'Gato', 'Bobtail Jap.', '2024-12-30', 5, 'Macho', 1, 'cliente.083@mail.com', 'Sin alergias conocidas'),
('M184', 'Pecas', 'Perro', 'Dalmata', '2025-01-01', 24, 'Hembra', 1, 'cliente.084@mail.com', 'Sin alergias conocidas'),
('M185', 'Pepe', 'Gato', 'Pixie-bob', '2025-01-05', 6, 'Macho', 1, 'cliente.085@mail.com', 'Sin alergias conocidas'),
('M186', 'Pipo', 'Perro', 'Bichon Maltes', '2025-01-10', 4, 'Macho', 1, 'cliente.086@mail.com', 'Sin alergias conocidas'),
('M187', 'Pirueta', 'Gato', 'Cymric', '2025-01-15', 5, 'Hembra', 1, 'cliente.087@mail.com', 'Sin alergias conocidas'),
('M188', 'Platon', 'Perro', 'Mastin Esp.', '2025-01-20', 70, 'Macho', 0, 'cliente.088@mail.com', 'Sin alergias conocidas'),
('M189', 'Pluto', 'Gato', 'Savannah', '2025-01-25', 8, 'Macho', 1, 'cliente.089@mail.com', 'Sin alergias conocidas'),
('M190', 'Polo', 'Perro', 'Samoyedo', '2025-01-30', 23, 'Macho', 1, 'cliente.090@mail.com', 'Sin alergias conocidas'),
('M191', 'Puchi', 'Gato', 'Peterbald', '2025-02-01', 4, 'Hembra', 1, 'cliente.091@mail.com', 'Sin alergias conocidas'),
('M192', 'Rambo', 'Perro', 'Doberman', '2025-02-05', 35, 'Macho', 1, 'cliente.092@mail.com', 'Sin alergias conocidas'),
('M193', 'Rayo', 'Gato', 'Australian Mist', '2025-02-10', 5, 'Macho', 1, 'cliente.093@mail.com', 'Sin alergias conocidas'),
('M194', 'Reina', 'Perro', 'Galgo', '2025-02-15', 20, 'Hembra', 1, 'cliente.094@mail.com', 'Sin alergias conocidas'),
('M195', 'Rex', 'Gato', 'Chausie', '2025-02-20', 7, 'Macho', 0, 'cliente.095@mail.com', 'Sin alergias conocidas'),
('M196', 'Ringo', 'Perro', 'Beagle', '2025-02-25', 12, 'Macho', 1, 'cliente.096@mail.com', 'Sin alergias conocidas'),
('M197', 'Rita', 'Gato', 'Tiffany', '2025-03-01', 5, 'Hembra', 1, 'cliente.097@mail.com', 'Sin alergias conocidas'),
('M198', 'Rocco', 'Perro', 'Rottweiler', '2025-03-05', 42, 'Macho', 1, 'cliente.098@mail.com', 'Sin alergias conocidas'),
('M199', 'Rocky', 'Gato', 'Bombay', '2025-03-10', 5, 'Macho', 1, 'cliente.099@mail.com', 'Sin alergias conocidas'),
('M200', 'Romeo', 'Perro', 'Cocker Sp.', '2025-03-15', 13, 'Macho', 1, 'cliente.100@mail.com', 'Sin alergias conocidas'),
('M201', 'Ron', 'Gato', 'Burmilla', '2025-03-20', 5, 'Macho', 1, 'cliente.101@mail.com', 'Sin alergias conocidas'),
('M202', 'Roque', 'Perro', 'Bull Terrier', '2025-03-25', 26, 'Macho', 1, 'cliente.102@mail.com', 'Sin alergias conocidas'),
('M203', 'Rosa', 'Gato', 'Singapura', '2025-03-30', 3, 'Hembra', 1, 'cliente.103@mail.com', 'Sin alergias conocidas'),
('M204', 'Rudy', 'Perro', 'Whippet', '2025-04-01', 11, 'Macho', 1, 'cliente.104@mail.com', 'Sin alergias conocidas'),
('M205', 'Rufus', 'Gato', 'Abisinio', '2025-04-05', 4, 'Macho', 1, 'cliente.105@mail.com', 'Sin alergias conocidas'),
('M206', 'Sam', 'Perro', 'Setter Irl.', '2025-04-10', 28, 'Macho', 1, 'cliente.106@mail.com', 'Sin alergias conocidas'),
('M207', 'Samy', 'Gato', 'Snowshoe', '2025-04-15', 5, 'Hembra', 1, 'cliente.107@mail.com', 'Sin alergias conocidas'),
('M208', 'Sasha', 'Perro', 'Alaskan Mal.', '2025-04-20', 35, 'Hembra', 1, 'cliente.108@mail.com', 'Sin alergias conocidas'),
('M209', 'Scout', 'Gato', 'Lykoi', '2025-04-25', 4, 'Macho', 1, 'cliente.109@mail.com', 'Sin alergias conocidas'),
('M210', 'Shadow', 'Perro', 'Schipperke', '2025-04-30', 7, 'Macho', 1, 'cliente.110@mail.com', 'Sin alergias conocidas'),
('M211', 'Shira', 'Gato', 'Scottish Fold', '2025-05-01', 4, 'Hembra', 1, 'cliente.111@mail.com', 'Sin alergias conocidas'),
('M212', 'Simba', 'Perro', 'Chow Chow', '2025-05-05', 24, 'Macho', 1, 'cliente.112@mail.com', 'Sin alergias conocidas'),
('M213', 'Simon', 'Gato', 'American Curl', '2025-05-10', 5, 'Macho', 1, 'cliente.113@mail.com', 'Sin alergias conocidas'),
('M214', 'Sira', 'Perro', 'Galgo Afgano', '2025-05-15', 25, 'Hembra', 1, 'cliente.114@mail.com', 'Sin alergias conocidas'),
('M215', 'Sky', 'Gato', 'Khao Manee', '2025-05-20', 4, 'Hembra', 1, 'cliente.115@mail.com', 'Sin alergias conocidas'),
('M216', 'Snoopy', 'Perro', 'Beagle', '2025-05-25', 10, 'Macho', 1, 'cliente.116@mail.com', 'Sin alergias conocidas'),
('M217', 'Sol', 'Gato', 'LaPerm', '2025-05-30', 4, 'Hembra', 1, 'cliente.117@mail.com', 'Sin alergias conocidas'),
('M218', 'Sparky', 'Perro', 'Terrier', '2025-06-01', 8, 'Macho', 1, 'cliente.118@mail.com', 'Sin alergias conocidas'),
('M219', 'Spike', 'Gato', 'Oriental', '2025-06-05', 5, 'Macho', 1, 'cliente.119@mail.com', 'Sin alergias conocidas'),
('M220', 'Stella', 'Perro', 'Staffordshire', '2025-06-10', 18, 'Hembra', 1, 'cliente.120@mail.com', 'Sin alergias conocidas'),
('M221', 'Sugar', 'Gato', 'Persa', '2025-06-15', 5, 'Hembra', 1, 'cliente.121@mail.com', 'Sin alergias conocidas'),
('M222', 'Tango', 'Perro', 'Pointer', '2025-06-20', 24, 'Macho', 1, 'cliente.122@mail.com', 'Sin alergias conocidas'),
('M223', 'Tara', 'Gato', 'Thai', '2025-06-25', 4, 'Hembra', 1, 'cliente.123@mail.com', 'Sin alergias conocidas'),
('M224', 'Teddy', 'Perro', 'Pomerania', '2025-06-30', 3, 'Macho', 1, 'cliente.124@mail.com', 'Sin alergias conocidas'),
('M225', 'Teo', 'Gato', 'Javanes', '2025-07-01', 5, 'Macho', 1, 'cliente.125@mail.com', 'Sin alergias conocidas'),
('M226', 'Thor', 'Perro', 'Pastor Aleman', '2025-07-05', 35, 'Macho', 1, 'cliente.126@mail.com', 'Sin alergias conocidas'),
('M227', 'Tigre', 'Gato', 'Bengala', '2025-07-10', 6, 'Macho', 1, 'cliente.127@mail.com', 'Sin alergias conocidas'),
('M228', 'Tina', 'Perro', 'Yorkshire', '2025-07-15', 3, 'Hembra', 1, 'cliente.128@mail.com', 'Sin alergias conocidas'),
('M229', 'Tito', 'Gato', 'Sphynx', '2025-07-20', 4, 'Macho', 1, 'cliente.129@mail.com', 'Sin alergias conocidas'),
('M230', 'Toby', 'Perro', 'Bichon Frise', '2025-07-25', 6, 'Macho', 1, 'cliente.130@mail.com', 'Sin alergias conocidas'),
('M231', 'Tom', 'Gato', 'Manx', '2025-07-30', 5, 'Macho', 1, 'cliente.131@mail.com', 'Sin alergias conocidas'),
('M232', 'Tora', 'Perro', 'Tosa Inu', '2025-08-01', 55, 'Hembra', 1, 'cliente.132@mail.com', 'Sin alergias conocidas'),
('M233', 'Toto', 'Gato', 'Chartreux', '2025-08-05', 6, 'Macho', 1, 'cliente.133@mail.com', 'Sin alergias conocidas'),
('M234', 'Trasto', 'Perro', 'Jack Russell', '2025-08-10', 7, 'Macho', 1, 'cliente.134@mail.com', 'Sin alergias conocidas'),
('M235', 'Trufa', 'Gato', 'Himalayo', '2025-08-15', 5, 'Hembra', 1, 'cliente.135@mail.com', 'Sin alergias conocidas'),
('M236', 'Tyron', 'Perro', 'Cane Corso', '2025-08-20', 45, 'Macho', 1, 'cliente.136@mail.com', 'Sin alergias conocidas'),
('M237', 'Ulises', 'Gato', 'Angora Turco', '2025-08-25', 5, 'Macho', 1, 'cliente.137@mail.com', 'Sin alergias conocidas'),
('M238', 'Urko', 'Perro', 'Mastin Nap.', '2025-08-30', 65, 'Macho', 1, 'cliente.138@mail.com', 'Sin alergias conocidas'),
('M239', 'Ursula', 'Gato', 'Selkirk Rex', '2025-09-01', 5, 'Hembra', 1, 'cliente.139@mail.com', 'Sin alergias conocidas'),
('M240', 'Vader', 'Perro', 'Schnauzer G.', '2025-09-05', 38, 'Macho', 1, 'cliente.140@mail.com', 'Sin alergias conocidas'),
('M241', 'Vania', 'Gato', 'Somalí', '2025-09-10', 4, 'Hembra', 1, 'cliente.141@mail.com', 'Sin alergias conocidas'),
('M242', 'Vico', 'Perro', 'Vizsla', '2025-09-15', 22, 'Macho', 1, 'cliente.142@mail.com', 'Sin alergias conocidas'),
('M243', 'Vicky', 'Gato', 'Korat', '2025-09-20', 4, 'Hembra', 1, 'cliente.143@mail.com', 'Sin alergias conocidas'),
('M244', 'Vigo', 'Perro', 'Weimaraner', '2025-09-25', 28, 'Macho', 1, 'cliente.144@mail.com', 'Sin alergias conocidas'),
('M245', 'Vilma', 'Gato', 'Siberiano', '2025-09-30', 6, 'Hembra', 1, 'cliente.145@mail.com', 'Sin alergias conocidas'),
('M246', 'Vito', 'Perro', 'Bulldog Ing.', '2025-10-01', 24, 'Macho', 1, 'cliente.146@mail.com', 'Sin alergias conocidas'),
('M247', 'Volcan', 'Gato', 'Maine Coon', '2025-10-05', 8, 'Macho', 1, 'cliente.147@mail.com', 'Sin alergias conocidas'),
('M248', 'Wanda', 'Perro', 'Setter Irl.', '2025-10-10', 26, 'Hembra', 1, 'cliente.148@mail.com', 'Sin alergias conocidas'),
('M249', 'Whisky', 'Gato', 'Ruso Azul', '2025-10-15', 5, 'Macho', 1, 'cliente.149@mail.com', 'Sin alergias conocidas'),
('M250', 'Wolf', 'Perro', 'Lobero Irl.', '2025-10-20', 60, 'Macho', 1, 'cliente.150@mail.com', 'Sin alergias conocidas'),
('M251', 'Kiki', 'gato', 'Tricolor', '2026-03-21', 2, 'Hembra', 0, 'cor@gmail.com', 'Sin alergias conocidas'),
('M252', 'Kiki', 'gato', 'TricolorAAA', '2026-05-03', 1, 'Macho', 0, 'CorN@gmail.com', 'Sin alergias conocidas'),
('M253', 'EWSFEW', 'WEFEW', 'EWFEW', '2026-06-05', 2, 'Hembra', 1, NULL, 'Sin alergias conocidas'),
('M254', 'Kikias', 'gatoas', 'Tricoloras', '2026-05-22', 2, 'Macho', 0, 'gogo@gmail.com', 'Sin alergias conocidas'),
('M255', 'Kira', 'gato', 'mestizo', '2024-02-09', 2, 'Hembra', 0, 'cliente.130@mail.com', 'Sin alergias conocidas'),
('M256', 'Nick', 'Perro', 'Pitbull', '2024-02-15', 2, 'Macho', 0, 'cliente.003@mail.com', 'Sin alergias conocidas'),
('M257', 'Kira', 'gato', 'bicolor', '2023-03-16', 6, 'Hembra', 0, 'cor@gmail.com', 'Sin alergias conocidas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

DROP TABLE IF EXISTS `producto`;
CREATE TABLE IF NOT EXISTS `producto` (
  `id_producto` varchar(100) NOT NULL,
  `nom_producto` varchar(100) NOT NULL,
  `precio_prod` decimal(10,2) NOT NULL,
  `categoria_prod` varchar(100) NOT NULL,
  `marca_prod` varchar(100) NOT NULL,
  `Stock_prod` smallint UNSIGNED NOT NULL,
  `costo_prod` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nom_producto`, `precio_prod`, `categoria_prod`, `marca_prod`, `Stock_prod`, `costo_prod`) VALUES
('P001', 'Croquetas Premium Perro Adulto', 850.00, 'Alimento', 'Royal Canin', 50, 0.00),
('P002', 'Croquetas Gato Esterilizado', 720.00, 'Alimento', 'Hill\'s', 40, 0.00),
('P003', 'Collar Antipulgas', 250.00, 'Accesorio', 'Bayer', 100, 0.00),
('P004', 'Vacuna Rabia', 300.00, 'Medicamento', 'Zoetis', 30, 0.00),
('P005', 'Vacuna Triple Felina', 400.00, 'Medicamento', 'MSD Animal Health', 25, 0.00),
('P006', 'Shampoo Medicado Perros', 180.00, 'Higiene', 'PetCare', 60, 0.00),
('P007', 'Arena Sanitaria Gatos', 120.00, 'Higiene', 'CatLovers', 80, 0.00),
('P008', 'Antibiótico Amoxicilina', 500.00, 'Medicamento', 'Pfizer Vet', 20, 0.00),
('P009', 'Juguete Mordedera Perro', 150.00, 'Accesorio', 'Kong', 75, 0.00),
('P010', 'Vitaminas Complejo B', 350.00, 'Suplemento', 'VetLife', 45, 0.00),
('P011', 'Cani - Tabs Brain & Neuro', 480.00, 'Suplementos', 'Cani-Tabs', 6, 360.00),
('P012', 'PT10 COMPREHENSIVE PLUS 17V', 700.00, 'Diagnóstico', 'PT10', 5, 535.56),
('P013', 'Caja Churu Atún (Caja con 6 sobres)', 50.00, 'Premios', 'Inaba Churu', 2, 0.01),
('P014', 'GI-RESTORE (CAJA 10 SOBRES/12GR.)', 600.00, 'Suplementos', 'GI-Restore', 2, 452.90),
('P015', '3+1 FELVITAL TAURINA', 720.00, 'Suplementos', 'Felvital', 1, 552.30),
('P016', '3+1 FELVITAL TRI-DEFENSE 30ML', 890.00, 'Suplementos', 'Felvital', 1, 680.40),
('P017', 'DERMOPLEX CREMA 60 GR.', 320.00, 'Dermatología', 'Dermoplex', 2, 242.20),
('P018', 'GI Biome .18 Lb. Feline Lata', 75.00, 'Alimentos', 'Hill\'s', 72, 54.41),
('P019', 'JERINGA 3ML NEGRA', 330.00, 'Material Médico', 'S.Medica Flores', 1, 249.00),
('P020', 'JERINGA 3ML AZUL', 330.00, 'Material Médico', 'S.Medica Flores', 1, 249.00),
('P021', 'PROPOFOL S.I FCO AMPULA', 620.00, 'Anestésicos', 'S.Medica Flores', 2, 465.00),
('P022', 'GASA 10X10 S/TR QUIMEX', 260.00, 'Material Médico', 'Quimex', 5, 193.00),
('P023', 'AGUA OXIGENADA 1 LTO', 35.00, 'Antisépticos', 'S.Medica Flores', 2, 24.00),
('P024', 'ALCOHOL TAPA ROJA 800 ML 96 GRADOS', 110.00, 'Antisépticos', 'S.Medica Flores', 3, 79.00),
('P025', '1+1 MICOPLEX MAX SHAMPOO 350 ML.', 550.00, 'Dermatología', 'Micoplex', 2, 412.00),
('P026', '1+1 CLOREXIDERM MAX SHAMPOO 350 ML.', 550.00, 'Dermatología', 'Clorexiderm', 2, 412.00),
('P027', 'NEXGARD CHICO GATO .8-2.5K', 290.00, 'Antiparasitarios', 'Boehringer', 4, 208.37),
('P028', 'NEXGARD GRANDE GATO 2.5-7.5K', 310.00, 'Antiparasitarios', 'Boehringer', 4, 227.27),
('P029', 'OSURNIA', 210.00, 'Otología', 'Dechra', 4, 135.45),
('P030', 'TRIZEDTA CRISTAL FLUSH 118 ML', 330.00, 'Dermatología', 'Dechra', 2, 238.00),
('P031', 'KLEAROTIC 118ML', 280.00, 'Otología', 'Dechra', 3, 205.80),
('P032', 'TRIOXIL 800 MG 100 TABLETAS', 420.00, 'Antibióticos', 'Alpha', 2, 306.60),
('P033', 'MALACETIC SHAMPOO 355 ML NL', 440.00, 'Dermatología', 'Dechra', 12, 320.62),
('P034', 'CORTOTIC', 430.00, 'Otología', 'Virbac', 3, 313.10),
('P035', 'SOFLORAN FCO 100 ML (ISOFLURANO) GP1', 950.00, 'Anestésicos', 'Sofloran', 6, 699.00),
('P036', 'HEMOFINN CAJA CON 30 TABS. NL', 1200.00, 'Suplementos', 'Distribuidora Campestre', 3, 903.00),
('P037', 'JERINGA 3ML CAJA PROTEC', 370.00, 'Material Médico', 'Protec', 1, 276.00),
('P038', 'JERINGA 5ML VERDE CAJA', 375.00, 'Material Médico', 'Paz y Salud', 1, 279.00),
('P039', 'VENOCAN MINI IV 0.6X13MM 26G', 32.00, 'Material Médico', 'Bubastis', 50, 20.86),
('P040', 'ESPIRANIDE CAJA C/10 TAB.', 324.00, 'Antibióticos', 'PISA', 12, 230.00),
('P041', 'RIMADYL 100 MG. 60 TABS. (RS)', 2180.00, 'Antiinflamatorios', 'Zoetis', 1, 1745.00),
('P042', 'CEFALETAS 200', 163.00, 'Antibióticos', 'Segavet', 12, 122.25),
('P043', 'SIMPARICA 1 TAB. MASTICABLES 5.1 - 10 KG.', 295.00, 'Antiparasitarios', 'Zoetis', 15, 120.83),
('P044', 'SIMPARICA 1 TAB. MASTICABLES 10.1 - 20 KG.', 310.00, 'Antiparasitarios', 'Zoetis', 15, 129.17),
('P045', 'HEMOSYLAT CAJA CON 10 FRASCOS DE 2 ML', 470.00, 'Farma', 'Alpha', 2, 329.00),
('P046', 'CYTOPOINT 20 MG', 1900.00, 'Dermatología', 'Zoetis', 1, 1520.00),
('P047', 'CYTOPOINT 30 MG', 2300.00, 'Dermatología', 'Zoetis', 1, 1870.00),
('P048', 'C/D MULTIC FEL (LATA 5.5 OZ.) .34 LB', 90.00, 'Alimentos', 'Hill\'s', 24, 64.48),
('P049', 'PISADOL 50 SOL INY FCO AMP C/50 ML NL', 620.00, 'Analgésicos', 'PISA', 4, 456.00),
('P050', 'GI-RESTORE (CAJA 10 SOBRES/12GR.)', 620.00, 'Suplementos', 'DIVEES', 2, 452.90),
('P051', '3+1 FELVITAL TAURINA 80ML / TRI-DEFENSE', 850.00, 'Suplementos', 'Felvital', 2, 616.35),
('P052', 'DERMOPLEX CREMA 60 GR.', 340.00, 'Dermatología', 'DIVEES', 2, 242.20),
('P053', 'EMAVERT', 2434.00, 'Farma', 'Dechra', 3, 1703.80),
('P054', 'NOVIBAC FELINE 1-HCP + FeLV', 277.30, 'Vacunas', 'MSD', 25, 194.04),
('P055', 'SILIPROTEC NATURAL', 465.00, 'Suplementos', 'Innvet', 6, 348.75),
('P056', 'FRESH CARE C.K. ONE', 202.59, 'Estética', 'Pharma', 9, 151.95),
('P057', 'FRESH CARE CAROLINA HERRERA', 187.00, 'Estética', 'Pharma', 5, 140.25),
('P058', 'ALIN VETERINARIO INY. 100ML', 415.00, 'Farma', 'Chinoin', 2, 311.25),
('P059', 'CANIGEN MHAPPILR SEXTUPLE', 275.20, 'Vacunas', 'Virbac', 20, 137.60),
('P060', 'CANIGEN MHA2PPIL QUINTUPLE', 228.10, 'Vacunas', 'Virbac', 20, 114.05),
('P061', 'CANIGEN MHA2 PUPPY EXTRA', 227.10, 'Vacunas', 'Virbac', 20, 113.55),
('P062', 'CANIGEN MHA2 PUPPY', 221.00, 'Vacunas', 'Virbac', 20, 110.50),
('P063', 'KETOCHLOR 250 ML', 345.00, 'Dermatología', 'Virbac', 6, 243.88),
('P064', 'HEXADENE SPHERULITES', 310.00, 'Dermatología', 'Virbac', 6, 218.03),
('P065', 'CRONVAL HD 5 NL', 1500.00, 'Farma', 'Distribuidora Campestre', 2, 1102.50),
('P066', 'ONSIOR 10MG/20MG/40MG 7 TABS', 360.00, 'Analgésicos', 'Elanco', 6, 258.25),
('P067', 'DIRULAN 15 MG. TAB. NL', 160.00, 'Farma', 'Distribuidora Campestre', 3, 115.50),
('P068', '1+1 MICOPLEX MAX SHAMPOO 350 ML.', 300.00, 'Dermatología', 'DIVEES', 4, 206.00),
('P069', '1+1 CLOREXIDERM MAX SHAMPOO 350 ML.', 300.00, 'Dermatología', 'DIVEES', 4, 206.00),
('P070', 'VETMEDIN 1.25 MG TABLETAS MASTIC', 930.00, 'Farma', 'Boehringer', 2, 664.02),
('P071', 'PUREVAX RCPH+ FELV RER', 316.65, 'Vacunas', 'Boehringer', 20, 189.99),
('P072', 'FRONTLINE SPRAY 250 ML ITD', 412.44, 'Parasitilidas', 'Boehringer', 6, 343.70),
('P073', 'FELVITAL UT / ITRA / L-CARN / TAURINA', 287.00, 'Suplementos', 'Felvital', 2, 200.50),
('P074', 'TRI-DEFENSE / KPTIN SUSPENSION', 236.00, 'Suplementos', 'Felvital', 5, 172.40),
('P075', 'MARBOCYL P 20MG', 1500.00, 'Farma', 'Vetoquinol', 1, 942.90),
('P076', 'MARBOCYL P 80MG', 3670.00, 'Farma', 'Vetoquinol', 1, 2311.57),
('P077', 'OHM', 740.00, 'Farma', 'Holly', 1, 518.00),
('P078', 'PRADOL INYECTABLE 100 ML', 152.00, 'Farma', 'Diprodavet', 2, 114.00),
('P079', 'LACTO PETS NRV 450 GR', 362.93, 'Suplementos', 'Norvet', 2, 272.19),
('P080', 'FRESH CARE PACO RABANE', 187.00, 'Estética', 'Pharma', 3, 140.25),
('P081', 'CARPROVET 75MG', 1777.00, 'Farma', 'Dechra', 1, 1333.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_trat`
--

DROP TABLE IF EXISTS `prod_trat`;
CREATE TABLE IF NOT EXISTS `prod_trat` (
  `cantidad` smallint UNSIGNED NOT NULL,
  `id_tratamiento` varchar(100) DEFAULT NULL,
  `id_producto` varchar(100) DEFAULT NULL,
  KEY `prod_trat_tratamiento_FK` (`id_tratamiento`),
  KEY `prod_trat_producto_FK` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `prod_trat`
--

INSERT INTO `prod_trat` (`cantidad`, `id_tratamiento`, `id_producto`) VALUES
(7, 'T001', 'P010'),
(14, 'T002', 'P004'),
(10, 'T003', 'P008'),
(20, 'T004', 'P005'),
(15, 'T005', 'P001'),
(12, 'T006', 'P003'),
(18, 'T007', 'P002'),
(8, 'T008', 'P006'),
(10, 'T009', 'P007'),
(6, 'T010', 'P009');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

DROP TABLE IF EXISTS `servicios`;
CREATE TABLE IF NOT EXISTS `servicios` (
  `id_servicio` varchar(10) NOT NULL,
  `nom_servicio` varchar(100) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `encargado` varchar(100) NOT NULL,
  PRIMARY KEY (`id_servicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id_servicio`, `nom_servicio`, `descripcion`, `precio`, `encargado`) VALUES
('S1', 'Consulta General', 'Revision basica', 350, 'Dr. Lopez'),
('S10', 'Emergencia', 'Atencion urgente', 1200, 'Dra. Herrera'),
('S2', 'Vacunacion', 'Aplicacion de vacunas', 250, 'Dra. Martinez'),
('S3', 'Cirugia', 'Procedimiento quirurgico', 2500, 'Dr. Ramirez'),
('S4', 'Desparasitacion', 'Control parasitario', 200, 'Dra. Cruz'),
('S5', 'Rayos X', 'Estudio radiologico', 800, 'Dr. Vega'),
('S6', 'Ultrasonido', 'Estudio de imagen', 900, 'Dra. Silva'),
('S7', 'Limpieza Dental', 'Profilaxis dental', 600, 'Dr. Ortiz'),
('S8', 'Esterilizacion', 'Cirugia preventiva', 1800, 'Dra. Torres'),
('S9', 'Hospitalizacion', 'Cuidado intensivo', 1500, 'Dr. Morales');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sintomas`
--

DROP TABLE IF EXISTS `sintomas`;
CREATE TABLE IF NOT EXISTS `sintomas` (
  `nombre` varchar(100) DEFAULT NULL,
  `id_consulta` varchar(100) DEFAULT NULL,
  KEY `sintomas_consulta_FK` (`id_consulta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `sintomas`
--

INSERT INTO `sintomas` (`nombre`, `id_consulta`) VALUES
('Letargo', 'CONS001'),
('Pérdida de apetito', 'CONS002'),
('Tos frecuente', 'CONS003'),
('Dolor abdominal', 'CONS004'),
('Ictericia', 'CONS005'),
('Diarrea', 'CONS006'),
('Palpitaciones', 'CONS007'),
('Encías inflamadas', 'CONS008'),
('Estornudos constantes', 'CONS009'),
('Dificultad para orinar', 'CONS010');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamiento`
--

DROP TABLE IF EXISTS `tratamiento`;
CREATE TABLE IF NOT EXISTS `tratamiento` (
  `id_tratamiento` varchar(100) NOT NULL,
  `frecuencia_administracion` varchar(100) NOT NULL,
  `fecha_inicial` date NOT NULL,
  `fecha_final` date NOT NULL,
  `nombre_medicamento` varchar(100) NOT NULL,
  `dosis` varchar(50) NOT NULL,
  `id_diagnostico` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_tratamiento`),
  KEY `tratamiento_diagnostico_FK` (`id_diagnostico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tratamiento`
--

INSERT INTO `tratamiento` (`id_tratamiento`, `frecuencia_administracion`, `fecha_inicial`, `fecha_final`, `nombre_medicamento`, `dosis`, `id_diagnostico`) VALUES
('T001', 'Cada 12 horas', '2026-03-01', '2026-03-07', 'Suplemento vitamínico', '1 tableta', 'D001'),
('T002', 'Diario', '2026-03-02', '2026-03-15', 'Hierro oral', '10 mg', 'D002'),
('T003', 'Cada 24 horas', '2026-03-03', '2026-03-10', 'Antiinflamatorio', '50 mg', 'D003'),
('T004', 'Cada 8 horas', '2026-03-04', '2026-03-14', 'Antibiótico', '250 mg', 'D004'),
('T005', 'Cada 24 horas', '2026-03-05', '2026-03-20', 'Hepatoprotector', '1 cápsula', 'D005'),
('T006', 'Cada 12 horas', '2026-03-06', '2026-03-12', 'Antiparasitario', '5 ml', 'D006'),
('T007', 'Cada 24 horas', '2026-03-07', '2026-03-21', 'Antiarrítmico', '20 mg', 'D007'),
('T008', 'Cada 48 horas', '2026-03-08', '2026-03-16', 'Enjuague bucal veterinario', '10 ml', 'D008'),
('T009', 'Diario', '2026-03-09', '2026-03-19', 'Antihistamínico', '5 mg', 'D009'),
('T010', 'Cada 12 horas', '2026-03-10', '2026-03-20', 'Antibiótico urinario', '100 mg', 'D010'),
('T151', 'Cada 12 horas', '2026-03-01', '2026-03-15', 'Meloxicam', '0.5 ml', 'D151'),
('T152', 'Cada 24 horas', '2026-03-02', '2026-03-20', 'Enalapril', '5 mg', 'D152'),
('T153', 'Cada 8 horas', '2026-03-03', '2026-03-10', 'Posatex Gotas', '3 gotas', 'D153'),
('T154', 'Unica dosis', '2026-03-04', '2026-03-04', 'Vacuna Multiple', '1 ml', 'D154'),
('T155', 'Cada 12 horas', '2026-03-05', '2026-03-12', 'Clanoxan', '250 mg', 'D155'),
('T156', 'Semanal', '2026-03-06', '2026-04-06', 'Ivermectina Oral', '0.2 ml', 'D156'),
('T157', 'Cada 8 horas', '2026-03-07', '2026-03-17', 'Cephalexin', '500 mg', 'D157'),
('T158', 'Cada 24 horas', '2026-03-08', '2026-06-08', 'Interferon', '1 vial', 'D158'),
('T159', 'Cada 24 horas', '2026-03-09', '2026-03-23', 'Atenolol', '10 mg', 'D159'),
('T160', 'Cada 12 horas', '2026-03-10', '2026-03-15', 'Metronidazol', '125 mg', 'D160'),
('T161', 'Cada 24 horas', '2026-03-11', '2026-04-11', 'Hepatoprotector', '1 capsula', 'D161'),
('T162', 'Cada 6 horas', '2026-03-12', '2026-03-17', 'Terramicina Ofth', '1 gota', 'D162'),
('T163', 'N/A', '2026-03-13', '2026-03-13', 'Extirpacion Quirurgica', 'N/A', 'D163'),
('T164', 'Cada 12 horas', '2026-03-14', '2026-04-14', 'Doxiciclina', '100 mg', 'D164'),
('T165', 'Cada 12 horas', '2026-03-15', '2026-12-31', 'Insulina NPH', '2 UI', 'D165'),
('T166', 'Cada 24 horas', '2026-03-16', '2026-04-16', 'Cystaid', '1 sobre', 'D166'),
('T167', 'Cada 12 horas', '2026-03-17', '2026-03-27', 'Amoxicilina/Clav.', '250 mg', 'D167'),
('T168', 'N/A', '2026-03-18', '2026-03-18', 'Remocion Endoscopica', 'N/A', 'D168'),
('T169', 'Cada 24 horas', '2026-03-19', '2026-12-31', 'Amlodipino', '2.5 mg', 'D169'),
('T170', 'Cada 12 horas', '2026-03-20', '2026-03-30', 'Clorexhidina Gel', '0.5 ml', 'D170'),
('T171', 'Cada 8 horas', '2026-05-02', '2026-05-12', 'Amoxicilina Suspension', '2.5 ml', 'D171'),
('T172', 'Cada 24 horas', '2026-05-02', '2026-05-16', 'Apoquel', '5.4 mg', 'D172'),
('T173', 'Cada 12 horas', '2026-05-02', '2026-05-09', 'Prednisolona', '5 mg', 'D173'),
('T174', 'Cada 24 horas', '2026-05-03', '2026-05-31', 'Furosemida', '20 mg', 'D174'),
('T175', 'Cada 12 horas', '2026-05-03', '2026-05-13', 'Vitamina K1', '10 mg', 'D175'),
('T176', 'Cada 12 horas', '2026-05-03', '2026-05-10', 'Clorexhidina Gel', 'Aplicacion local', 'D176'),
('T177', 'Unica dosis', '2026-05-04', '2026-05-04', 'Drenaje Quirurgico', 'N/A', 'D177'),
('T178', 'Cada 24 horas', '2026-05-04', '2026-08-04', 'Inmunomodulador', '1 ml', 'D178'),
('T179', 'Cada 24 horas', '2026-05-04', '2026-05-18', 'Omega 3 Capsulas', '1 unidad', 'D179'),
('T180', 'Cada 12 horas', '2026-05-05', '2026-05-15', 'Meclizina', '12.5 mg', 'D180'),
('T181', 'Cada 24 horas', '2026-05-05', '2026-05-08', 'Inseminacion Asist.', 'N/A', 'D181'),
('T182', 'N/A', '2026-05-05', '2026-05-05', 'Escision local', 'N/A', 'D182'),
('T183', 'Cada 12 horas', '2026-05-06', '2026-05-11', 'Metronidazol', '250 mg', 'D183'),
('T184', 'Cada 24 horas', '2026-05-06', '2026-06-06', 'Condroprotector', '1 tableta', 'D184'),
('T185', 'N/A', '2026-05-06', '2026-05-06', 'Prueba confirmatoria', 'N/A', 'D185'),
('T186', 'Cada 12 horas', '2026-05-07', '2026-05-21', 'Gabapentina', '100 mg', 'D186'),
('T187', 'N/A', '2026-05-07', '2026-05-07', 'Extraccion Manual', 'N/A', 'D187'),
('T188', 'Cada 12 horas', '2026-05-07', '2026-06-07', 'Doxiciclina', '150 mg', 'D188'),
('T189', 'Cada 8 horas', '2026-05-08', '2026-05-10', 'Bicarbonato IV', 'Infusion', 'D189'),
('T190', 'Cada 24 horas', '2026-05-08', '2026-05-15', 'Limpieza con Suero', '10 ml', 'D190'),
('T191', 'Cada 24 horas', '2026-05-08', '2026-05-22', 'Hierro Dextrano', '1 ml', 'D191'),
('T192', 'Cada 8 horas', '2026-05-09', '2026-05-14', 'Digoxina', '0.125 mg', 'D192'),
('T193', 'Cada 24 horas', '2026-05-09', '2026-06-09', 'Acido Folico', '5 mg', 'D193'),
('T194', 'N/A', '2026-05-09', '2026-05-09', 'Ayuno terapeutico', '24 horas', 'D194'),
('T195', 'Cada 24 horas', '2026-05-10', '2026-11-10', 'Metimazol', '2.5 mg', 'D195'),
('T196', 'Cada 24 horas', '2026-05-10', '2026-06-10', 'Itraconazol', '50 mg', 'D196'),
('T197', 'Cada 24 horas', '2026-05-10', '2026-05-24', 'Dieta Renal', '250 gr', 'D197'),
('T198', 'Cada 6 horas', '2026-05-11', '2026-06-11', 'Ciclosporina Ofth.', '1 gota', 'D198'),
('T199', 'Cada 24 horas', '2026-05-11', '2026-05-18', 'Meloxicam', '1.5 mg', 'D199'),
('T200', 'Cada 4 horas', '2026-05-11', '2026-05-12', 'Suero Ringer Lactato', '500 ml', 'D200');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tutor`
--

DROP TABLE IF EXISTS `tutor`;
CREATE TABLE IF NOT EXISTS `tutor` (
  `correo_tutor` varchar(150) NOT NULL,
  `id_usuario` int DEFAULT NULL,
  `nom_tutor` varchar(100) NOT NULL,
  `app_tutor` varchar(100) NOT NULL,
  `apm_tutor` varchar(100) NOT NULL,
  `numtel_tutor` varchar(15) NOT NULL,
  `sexo` varchar(20) DEFAULT NULL,
  `direccion` varchar(100) NOT NULL,
  PRIMARY KEY (`correo_tutor`),
  UNIQUE KEY `tutor_id_usuario_UQ` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tutor`
--

INSERT INTO `tutor` (`correo_tutor`, `nom_tutor`, `app_tutor`, `apm_tutor`, `numtel_tutor`, `sexo`, `direccion`) VALUES
('ana.perez@mail.com', 'Ana', 'Pérez', 'Ramírez', '2224567890', 'Femenino', 'Col. Centro 67, Puebla'),
('asdsad@gmail.com', 'asdsa', 'papapa', 'kakaka', '1234567890', 'Masculino', 'dededededede'),
('carlos.ramirez@mail.com', 'Carlos', 'Ramírez', 'Santos', '2227654321', 'Masculino', 'Av. Universitaria 89, Puebla'),
('cliente.003@mail.com', 'Abraham', 'Vazquez', 'Diaz', '2221000003', 'Masculino', 'Blvd. Atlixco 303'),
('cliente.004@mail.com', 'Adan', 'Torres', 'Perez', '2221000004', 'Masculino', 'Av. Reforma 404'),
('cliente.005@mail.com', 'Adriana', 'Jimenez', 'Sosa', '2221000005', 'Femenino', 'Col. La Paz 505'),
('cliente.006@mail.com', 'Agustin', 'Moreno', 'Ruiz', '2221000006', 'Masculino', 'Calle 16 Sept 606'),
('cliente.007@mail.com', 'Alan', 'Alvarez', 'Flores', '2221000007', 'Masculino', 'Av. 15 Mayo 707'),
('cliente.008@mail.com', 'Alejandra', 'Romero', 'Castillo', '2221000008', 'Femenino', 'Circuito JPII 808'),
('cliente.009@mail.com', 'Alejandro', 'Suarez', 'Ortega', '2221000009', 'Masculino', 'Col. San Manuel 909'),
('cliente.010@mail.com', 'Alicia', 'Morales', 'Pacheco', '2221000010', 'Femenino', 'Av. Las Torres 1010'),
('cliente.011@mail.com', 'Alfonso', 'Rios', 'Mejia', '2221000011', 'Masculino', 'Calle 2 Sur 1111'),
('cliente.012@mail.com', 'Alma', 'Ortega', 'Serrano', '2221000012', 'Femenino', 'Av. 11 Sur 1212'),
('cliente.013@mail.com', 'Alvaro', 'Nava', 'Mendez', '2221000013', 'Masculino', 'Col. Volcanes 1313'),
('cliente.014@mail.com', 'Amalia', 'Cruz', 'Cordova', '2221000014', 'Femenino', 'Calle 25 Pte 1414'),
('cliente.015@mail.com', 'Amanda', 'Rojas', 'Ibarra', '2221000015', 'Femenino', 'Blvd. 5 Mayo 1515'),
('cliente.016@mail.com', 'Amelia', 'Cano', 'Santos', '2221000016', 'Femenino', 'Col. Centro 1616'),
('cliente.017@mail.com', 'Amparo', 'Bello', 'Guerrero', '2221000017', 'Femenino', 'Av. 31 Pte 1717'),
('cliente.018@mail.com', 'Ana', 'Sosa', 'Miranda', '2221000018', 'Femenino', 'Calle 9 Nte 1818'),
('cliente.019@mail.com', 'Anabel', 'Solís', 'Vargas', '2221000019', 'Femenino', 'Col. Anzures 1919'),
('cliente.020@mail.com', 'Andres', 'Pineda', 'Lara', '2221000020', 'Masculino', 'Av. Teziutlan 2020'),
('cliente.021@mail.com', 'Angel', 'Osorio', 'Bernal', '2221000021', 'Masculino', 'Calle 43 Pte 2121'),
('cliente.022@mail.com', 'Angela', 'Bravo', 'Chavez', '2221000022', 'Femenino', 'Col. Belisario 2222'),
('cliente.023@mail.com', 'Angelica', 'Valdez', 'Soto', '2221000023', 'Femenino', 'Av. 25 Ote 2323'),
('cliente.024@mail.com', 'Antonia', 'Hidalgo', 'Ramos', '2221000024', 'Femenino', 'Calle 14 Sur 2424'),
('cliente.025@mail.com', 'Antonio', 'Duran', 'Vega', '2221000025', 'Masculino', 'Col. Huexotitla 2525'),
('cliente.026@mail.com', 'Araceli', 'Mata', 'Gallardo', '2221000026', 'Femenino', 'Av. Margaritas 2626'),
('cliente.027@mail.com', 'Armando', 'Arenas', 'Padilla', '2221000027', 'Masculino', 'Calle Zavaleta 2727'),
('cliente.028@mail.com', 'Artemio', 'Franco', 'Calderon', '2221000028', 'Masculino', 'Col. Estrellas 2828'),
('cliente.029@mail.com', 'Arturo', 'Linares', 'Esquivel', '2221000029', 'Masculino', 'Av. Nacional 2929'),
('cliente.030@mail.com', 'Asuncion', 'Cortes', 'Rosales', '2221000030', 'Femenino', 'Calle 105 Pte 3030'),
('cliente.031@mail.com', 'Aurora', 'Molina', 'Rangel', '2221000031', 'Femenino', 'Col. Castillotla 3131'),
('cliente.032@mail.com', 'Azucena', 'Lozano', 'Salas', '2221000032', 'Femenino', 'Av. 16 Sept 3232'),
('cliente.033@mail.com', 'Barbara', 'Escobar', 'Nieto', '2221000033', 'Femenino', 'Calle Bugambilias 3333'),
('cliente.034@mail.com', 'Bartolo', 'Aguirre', 'Benitez', '2221000034', 'Masculino', 'Col. Bugambilias 3434'),
('cliente.035@mail.com', 'Basilio', 'Tapia', 'Leal', '2221000035', 'Masculino', 'Av. Xonaca 3535'),
('cliente.036@mail.com', 'Baudelio', 'Cisneros', 'Vela', '2221000036', 'Masculino', 'Calle 20 Nte 3636'),
('cliente.037@mail.com', 'Beatriz', 'Gallegos', 'Maldonado', '2221000037', 'Femenino', 'Col. Humboldt 3737'),
('cliente.038@mail.com', 'Benito', 'Lara', 'Montes', '2221000038', 'Masculino', 'Av. 14 Ote 3838'),
('cliente.039@mail.com', 'Benjamin', 'Palacios', 'Carrillo', '2221000039', 'Masculino', 'Calle 24 Sur 3939'),
('cliente.040@mail.com', 'Bernardo', 'Tellez', 'Lira', '2221000040', 'Masculino', 'Col. Alseseca 4040'),
('cliente.041@mail.com', 'Berta', 'Cabrera', 'Campos', '2221000041', 'Femenino', 'Av. Fidel Velazquez 4141'),
('cliente.042@mail.com', 'Blanca', 'Navarro', 'Medina', '2221000042', 'Femenino', 'Calle 38 Sur 4242'),
('cliente.043@mail.com', 'Bonifacio', 'Olvera', 'Duarte', '2221000043', 'Masculino', 'Col. Lomas 4343'),
('cliente.044@mail.com', 'Braulio', 'Velasco', 'Villegas', '2221000044', 'Masculino', 'Av. Coyoacan 4444'),
('cliente.045@mail.com', 'Brenda', 'Guerra', 'Zuniga', '2221000045', 'Femenino', 'Calle Insurgentes 4545'),
('cliente.046@mail.com', 'Bruno', 'Luna', 'Meza', '2221000046', 'Masculino', 'Col. Condesa 4646'),
('cliente.047@mail.com', 'Calixto', 'Rangel', 'Salazar', '2221000047', 'Masculino', 'Av. Chapultepec 4747'),
('cliente.048@mail.com', 'Camila', 'Serrano', 'Villanueva', '2221000048', 'Femenino', 'Calle Polanco 4848'),
('cliente.049@mail.com', 'Camilo', 'Mendez', 'Quintero', '2221000049', 'Masculino', 'Col. Roma 4949'),
('cliente.050@mail.com', 'Candido', 'Zavala', 'Fontes', '2221000050', 'Masculino', 'Av. Juarez 5050'),
('cliente.051@mail.com', 'Carina', 'Solis', 'Lira', '2221000051', 'Femenino', 'Av. Revolucion 5151'),
('cliente.052@mail.com', 'Carmelo', 'Rosas', 'Perea', '2221000052', 'Masculino', 'Calle 4 Ote 5252'),
('cliente.053@mail.com', 'Carmen', 'Paredes', 'Guerra', '2221000053', 'Femenino', 'Col. El Mirador 5353'),
('cliente.054@mail.com', 'Carolina', 'Vaca', 'Soria', '2221000054', 'Femenino', 'Av. 5 de Mayo 5454'),
('cliente.055@mail.com', 'Casandra', 'Báez', 'Uribe', '2221000055', 'Femenino', 'Calle 10 Nte 5555'),
('cliente.056@mail.com', 'Casimiro', 'Soto', 'Varela', '2221000056', 'Masculino', 'Col. Amor 5656'),
('cliente.057@mail.com', 'Catalina', 'Soria', 'Melo', '2221000057', 'Femenino', 'Av. 2Sur 5757'),
('cliente.058@mail.com', 'Cecilio', 'Rico', 'Brito', '2221000058', 'Masculino', 'Calle Oriente 5858'),
('cliente.059@mail.com', 'Celina', 'Perea', 'Chavez', '2221000059', 'Femenino', 'Col. Libertad 5959'),
('cliente.060@mail.com', 'Cesar', 'Tello', 'Valencia', '2221000060', 'Masculino', 'Av. Reforma 6060'),
('cliente.061@mail.com', 'Cipriano', 'Peralta', 'Duran', '2221000061', 'Masculino', 'Calle Victoria 6161'),
('cliente.062@mail.com', 'Clara', 'Melo', 'Lozano', '2221000062', 'Femenino', 'Col. Morelos 6262'),
('cliente.063@mail.com', 'Claudio', 'Salgado', 'Mora', '2221000063', 'Masculino', 'Av. Independencia 6363'),
('cliente.064@mail.com', 'Clemente', 'Rivas', 'Corona', '2221000064', 'Masculino', 'Calle Hidalgo 6464'),
('cliente.065@mail.com', 'Concepcion', 'Ramos', 'Guzman', '2221000065', 'Femenino', 'Col. Bosques 6565'),
('cliente.066@mail.com', 'Cristina', 'Uribe', 'Franco', '2221000066', 'Femenino', 'Av. Tecnologico 6666'),
('cliente.067@mail.com', 'Cristobal', 'Valadez', 'Bravo', '2221000067', 'Masculino', 'Calle Pino 6767'),
('cliente.068@mail.com', 'Dalia', 'Brito', 'Tapia', '2221000068', 'Femenino', 'Col. Cedros 6868'),
('cliente.069@mail.com', 'Dalila', 'Chavez', 'Cisneros', '2221000069', 'Femenino', 'Av. Robles 6969'),
('cliente.070@mail.com', 'Damaso', 'Valencia', 'Gallegos', '2221000070', 'Masculino', 'Calle Alamos 7070'),
('cliente.071@mail.com', 'Damian', 'Duran', 'Tellez', '2221000071', 'Masculino', 'Col. Ahuehuete 7171'),
('cliente.072@mail.com', 'Dario', 'Lozano', 'Cabrera', '2221000072', 'Masculino', 'Av. Encinos 7272'),
('cliente.073@mail.com', 'David', 'Mora', 'Olvera', '2221000073', 'Masculino', 'Calle Fresno 7373'),
('cliente.074@mail.com', 'Deborah', 'Corona', 'Velasco', '2221000074', 'Femenino', 'Col. Sauce 7474'),
('cliente.075@mail.com', 'Delfino', 'Guzman', 'Guerra', '2221000075', 'Masculino', 'Av. Palma 7575'),
('cliente.076@mail.com', 'Delia', 'Franco', 'Zavala', '2221000076', 'Femenino', 'Calle Laurel 7676'),
('cliente.077@mail.com', 'Demetrio', 'Bravo', 'Mendez', '2221000077', 'Masculino', 'Col. Olivo 7777'),
('cliente.078@mail.com', 'Diana', 'Tapia', 'Zavala', '2221000078', 'Femenino', 'Av. Cipres 7878'),
('cliente.079@mail.com', 'Diego', 'Cisneros', 'Fontes', '2221000079', 'Masculino', 'Calle Ebano 7979'),
('cliente.080@mail.com', 'Dionisio', 'Gallegos', 'Ruiz', '2221000080', 'Masculino', 'Col. Caoba 8080'),
('cliente.081@mail.com', 'Dolores', 'Tellez', 'Sosa', '2221000081', 'Femenino', 'Av. Cedro 8181'),
('cliente.082@mail.com', 'Donato', 'Cabrera', 'Lara', '2221000082', 'Masculino', 'Calle Naranjo 8282'),
('cliente.083@mail.com', 'Dora', 'Olvera', 'Bernal', '2221000083', 'Femenino', 'Col. Peral 8383'),
('cliente.084@mail.com', 'Doroteo', 'Velasco', 'Chavez', '2221000084', 'Masculino', 'Av. Limon 8484'),
('cliente.085@mail.com', 'Dulce', 'Guerra', 'Soto', '2221000085', 'Femenino', 'Calle Manzano 8585'),
('cliente.086@mail.com', 'Edgar', 'Zavala', 'Ramos', '2221000086', 'Masculino', 'Col. Durazno 8686'),
('cliente.087@mail.com', 'Edith', 'Mendez', 'Vega', '2221000087', 'Femenino', 'Av. Cerezo 8787'),
('cliente.088@mail.com', 'Edmundo', 'Zavala', 'Gallardo', '2221000088', 'Masculino', 'Calle Vid 8888'),
('cliente.089@mail.com', 'Eduviges', 'Fontes', 'Padilla', '2221000089', 'Femenino', 'Col. Higo 8989'),
('cliente.090@mail.com', 'Efrain', 'Ruiz', 'Calderon', '2221000090', 'Masculino', 'Av. Ciruela 9090'),
('cliente.091@mail.com', 'Elias', 'Sosa', 'Esquivel', '2221000091', 'Masculino', 'Calle Mango 9191'),
('cliente.092@mail.com', 'Elisa', 'Lara', 'Rosales', '2221000092', 'Femenino', 'Col. Papaya 9292'),
('cliente.093@mail.com', 'Eloy', 'Bernal', 'Rangel', '2221000093', 'Masculino', 'Av. Guayaba 9393'),
('cliente.094@mail.com', 'Elsa', 'Chavez', 'Salas', '2221000094', 'Femenino', 'Calle Sandia 9494'),
('cliente.095@mail.com', 'Elvia', 'Soto', 'Nieto', '2221000095', 'Femenino', 'Col. Melon 9595'),
('cliente.096@mail.com', 'Elvira', 'Ramos', 'Benitez', '2221000096', 'Femenino', 'Av. Platano 9696'),
('cliente.097@mail.com', 'Emanuel', 'Vega', 'Leal', '2221000097', 'Masculino', 'Calle Fresa 9797'),
('cliente.098@mail.com', 'Emilia', 'Gallardo', 'Vela', '2221000098', 'Femenino', 'Col. Zarzamora 9898'),
('cliente.099@mail.com', 'Emiliano', 'Padilla', 'Maldonado', '2221000099', 'Masculino', 'Av. Arandano 9999'),
('cliente.100@mail.com', 'Emilio', 'Calderon', 'Montes', '2221000100', 'Masculino', 'Calle Frambuesa 1000'),
('cliente.101@mail.com', 'Enrique', 'Esquivel', 'Carrillo', '2221000101', 'Masculino', 'Av. Tepozan 1011'),
('cliente.102@mail.com', 'Erasmo', 'Rosales', 'Lira', '2221000102', 'Masculino', 'Calle Colorines 1022'),
('cliente.103@mail.com', 'Eric', 'Rangel', 'Campos', '2221000103', 'Masculino', 'Col. Jacarandas 1033'),
('cliente.104@mail.com', 'Ernesto', 'Salas', 'Medina', '2221000104', 'Masculino', 'Av. Tulipanes 1044'),
('cliente.105@mail.com', 'Esmeralda', 'Nieto', 'Duarte', '2221000105', 'Femenino', 'Calle Girasoles 1055'),
('cliente.106@mail.com', 'Esteban', 'Benitez', 'Villegas', '2221000106', 'Masculino', 'Col. Orquideas 1066'),
('cliente.107@mail.com', 'Estefania', 'Leal', 'Zuniga', '2221000107', 'Femenino', 'Av. Violetas 1077'),
('cliente.108@mail.com', 'Estela', 'Vela', 'Meza', '2221000108', 'Femenino', 'Calle Margaritas 1088'),
('cliente.109@mail.com', 'Ester', 'Maldonado', 'Salazar', '2221000109', 'Femenino', 'Col. Lirios 1099'),
('cliente.110@mail.com', 'Estraton', 'Montes', 'Villanueva', '2221000110', 'Masculino', 'Av. Gladiolas 1100'),
('cliente.111@mail.com', 'Etelvina', 'Carrillo', 'Quintero', '2221000111', 'Femenino', 'Calle Nochebuena 1111'),
('cliente.112@mail.com', 'Eufemia', 'Lira', 'Fontes', '2221000112', 'Femenino', 'Col. Azucenas 1122'),
('cliente.113@mail.com', 'Eugenio', 'Campos', 'Gomez', '2221000113', 'Masculino', 'Av. Begonias 1133'),
('cliente.114@mail.com', 'Eulalia', 'Medina', 'Reyes', '2221000114', 'Femenino', 'Calle Camelias 1144'),
('cliente.115@mail.com', 'Eulogio', 'Duarte', 'Vazquez', '2221000115', 'Masculino', 'Col. Hortensias 1155'),
('cliente.116@mail.com', 'Eusebio', 'Villegas', 'Torres', '2221000116', 'Masculino', 'Av. Claveles 1166'),
('cliente.117@mail.com', 'Eva', 'Zuniga', 'Jimenez', '2221000117', 'Femenino', 'Calle Crisantemos 1177'),
('cliente.118@mail.com', 'Evangelina', 'Meza', 'Moreno', '2221000118', 'Femenino', 'Col. Malvas 1188'),
('cliente.119@mail.com', 'Evaristo', 'Salazar', 'Alvarez', '2221000119', 'Masculino', 'Av. Geranios 1199'),
('cliente.120@mail.com', 'Evelia', 'Villanueva', 'Romero', '2221000120', 'Femenino', 'Calle Pensamientos 1200'),
('cliente.121@mail.com', 'Ezequiel', 'Quintero', 'Suarez', '2221000121', 'Masculino', 'Col. Jazmines 1211'),
('cliente.122@mail.com', 'Fabian', 'Fontes', 'Morales', '2221000122', 'Masculino', 'Av. Lotos 1222'),
('cliente.123@mail.com', 'Fabiola', 'Gomez', 'Ruiz', '2221000123', 'Femenino', 'Calle Petunias 1233'),
('cliente.124@mail.com', 'Facundo', 'Reyes', 'Rios', '2221000124', 'Masculino', 'Col. Gardenias 1244'),
('cliente.125@mail.com', 'Fancisco', 'Vazquez', 'Ortega', '2221000125', 'Masculino', 'Av. Magnolias 1255'),
('cliente.126@mail.com', 'Faustino', 'Torres', 'Nava', '2221000126', 'Masculino', 'Calle Amapolas 1266'),
('cliente.127@mail.com', 'Fausto', 'Jimenez', 'Cruz', '2221000127', 'Masculino', 'Col. Anturios 1277'),
('cliente.128@mail.com', 'Federico', 'Moreno', 'Rojas', '2221000128', 'Masculino', 'Av. Belenes 1288'),
('cliente.129@mail.com', 'Feliciano', 'Alvarez', 'Cano', '2221000129', 'Masculino', 'Calle Calas 1299'),
('cliente.130@mail.com', 'Felipe', 'Romero', 'Bello', '2221000130', 'Masculino', 'Col. Dalias 1300'),
('cliente.131@mail.com', 'Felix', 'Suarez', 'Sosa', '2221000131', 'Masculino', 'Av. Helechos 1311'),
('cliente.132@mail.com', 'Fermín', 'Morales', 'Solis', '2221000132', 'Masculino', 'Calle Musgos 1322'),
('cliente.133@mail.com', 'Fernando', 'Ruiz', 'Pineda', '2221000133', 'Masculino', 'Col. Pinos 1333'),
('cliente.134@mail.com', 'Fidencio', 'Rios', 'Osorio', '2221000134', 'Masculino', 'Av. Encinos 1344'),
('cliente.135@mail.com', 'Filemon', 'Ortega', 'Bravo', '2221000135', 'Masculino', 'Calle Cedros 1355'),
('cliente.136@mail.com', 'Flavia', 'Nava', 'Valdez', '2221000136', 'Femenino', 'Col. Fresnos 1366'),
('cliente.137@mail.com', 'Flavio', 'Cruz', 'Hidalgo', '2221000137', 'Masculino', 'Av. Laureles 1377'),
('cliente.138@mail.com', 'Flora', 'Rojas', 'Duran', '2221000138', 'Femenino', 'Calle Olivos 1388'),
('cliente.139@mail.com', 'Florencia', 'Cano', 'Mata', '2221000139', 'Femenino', 'Col. Palmas 1399'),
('cliente.140@mail.com', 'Florencio', 'Bello', 'Arenas', '2221000140', 'Masculino', 'Av. Sauces 1400'),
('cliente.141@mail.com', 'Florentina', 'Sosa', 'Franco', '2221000141', 'Femenino', 'Calle Robles 1411'),
('cliente.142@mail.com', 'Florentino', 'Solis', 'Linares', '2221000142', 'Masculino', 'Col. Alamos 1422'),
('cliente.143@mail.com', 'Fortino', 'Pineda', 'Cortes', '2221000143', 'Masculino', 'Av. Cipreses 1433'),
('cliente.144@mail.com', 'Francisca', 'Osorio', 'Molina', '2221000144', 'Femenino', 'Calle Abetos 1444'),
('cliente.145@mail.com', 'Francisco', 'Bravo', 'Lozano', '2221000145', 'Masculino', 'Col. Ahuehuetes 1455'),
('cliente.146@mail.com', 'Froylan', 'Valdez', 'Escobar', '2221000146', 'Masculino', 'Av. Ceibas 1466'),
('cliente.147@mail.com', 'Fulgencio', 'Hidalgo', 'Aguirre', '2221000147', 'Masculino', 'Calle Mezquites 1477'),
('cliente.148@mail.com', 'Gabriel', 'Duran', 'Tapia', '2221000148', 'Masculino', 'Col. Huizaches 1488'),
('cliente.149@mail.com', 'Gabriela', 'Mata', 'Cisneros', '2221000149', 'Femenino', 'Av. Magueyes 1499'),
('cliente.150@mail.com', 'Gael', 'Arenas', 'Gallegos', '2221000150', 'Masculino', 'Calle Agaves 1500'),
('cor@gmail.com', 'Jonathan ', 'Goiz', 'Arana', '2481586353', 'Masculino', 'independencia 23'),
('CorN@gmail.com', 'Jonathan ', 'Goiz', 'Arana', '2339875645', 'Masculino', 'independencia 23'),
('correo@gmail.com', 'Jonathan ', 'Goiz', 'Arana', '2487652323', 'Masculino', 'independencia 23'),
('fernando.diaz@mail.com', 'Fernando', 'Díaz', 'García', '2226789012', 'Masculino', 'Col. San Manuel 34, Puebla'),
('gogo@gmail.com', 'gaga', 'gege', 'gfgf', '0000000000', 'No especificado', 'Sin registrar'),
('juan.lopez@mail.com', 'Juan', 'López', 'Martínez', '2229876543', 'Masculino', 'Calle Juárez 45, Puebla'),
('laura.santos@mail.com', 'Laura', 'Santos', 'Morales', '2223451234', 'Femenino', 'Av. Las Torres 56, Puebla'),
('maria.gomez@mail.com', 'María', 'Gómez', 'Hernández', '2223456789', 'Femenino', 'Av. Reforma 123, Puebla'),
('miguel.torres@mail.com', 'Miguel', 'Torres', 'Vega', '2227890123', 'Masculino', 'Calle del Sol 78, Puebla'),
('nuevoC@gmail.com', 'Jonathan ', 'Goiz', 'Arana', '2331233434', 'Masculino', 'independencia 23'),
('paola.fernandez@mail.com', 'Paola', 'Fernández', 'Ruiz', '2229012345', 'Femenino', 'Col. La Paz 90, Puebla'),
('ricardo.mendoza@mail.com', 'Ricardo', 'Mendoza', 'Castro', '2225678901', 'Masculino', 'Av. Nacional 101, Puebla'),
('sofia.martinez@mail.com', 'Sofía', 'Martínez', 'Fernández', '2221234567', 'Femenino', 'Calle Hidalgo 12, Puebla');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `correo` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre` varchar(100) NOT NULL DEFAULT '',
  `apellido_paterno` varchar(100) DEFAULT NULL,
  `apellido_materno` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `correo`, `password`, `nombre`, `apellido_paterno`, `apellido_materno`) VALUES
(9, 'jona@gmail.com', '1212', 'jona', NULL, NULL),
(10, 'sad@gmail.com', 'asdasd', 'sad', NULL, NULL),
(11, 'mor@gmail.com', 'gagaga', 'mor', NULL, NULL),
(12, 'goa23@gmail.com', 'gaga23', 'Jonathan', 'Goiz', 'Arana'),
(13, 'geli@gmail.com', 'KeriNick', 'Karla Angelica', 'Rojano', 'Perez'),
(14, 'gaga23@gmail.com', '090909', 'GAGA', 'soso', 'DADA'),
(15, 'jona12@gmail.com', '12121212', 'jonathan', 'Goiz', 'Arana'),
(16, 'Goiz12@gmail.com', '232323', 'Jonathan', 'Goiz', 'Arana'),
(17, 'gogo@gmail.com', '121212', 'gaga', 'gege', 'gfgf'),
(18, 'Gaga@gmail.com', 'gaga23', 'jona', 'Goiz', 'Gaga'),
(19, 'correo@gmail.com', '2323233', 'Karla Angelica', 'Rojano', 'Perez'),
(20, 'hola12@gmail.com', 'hola12', 'Karla Angelica', 'Rojano', 'Perez'),
(21, 'hola1@gmail.com', 'hola1', 'Karla Angelica', 'Rojano', 'Perez'),
(22, 'nuevo@gmail.com', 'hola12', 'Karla Angelica', 'Rojano', 'Perez'),
(23, 'CorN@gmail.com', 'hola22', 'Karla Angelica', 'Rojano', 'Perez');

UPDATE `tutor` t
JOIN `usuarios` u ON LOWER(TRIM(t.`correo_tutor`)) = LOWER(TRIM(u.`correo`))
SET t.`id_usuario` = u.`id_usuario`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `veterinario`
--

DROP TABLE IF EXISTS `veterinario`;
CREATE TABLE IF NOT EXISTS `veterinario` (
  `correo_veterinario` varchar(100) NOT NULL,
  `id_usuario` int DEFAULT NULL,
  `nom_vet` varchar(100) NOT NULL,
  `app_vet` varchar(100) NOT NULL,
  `apm_vet` varchar(100) NOT NULL,
  `numtel_vet` varchar(15) NOT NULL,
  `especialidad` varchar(100) NOT NULL,
  `sexo` varchar(10) DEFAULT NULL,
  `no_cedula` varchar(20) NOT NULL,
  `id_servicio` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`correo_veterinario`),
  UNIQUE KEY `veterinario_id_usuario_UQ` (`id_usuario`),
  KEY `veterinario_servicios_FK` (`id_servicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `veterinario`
--

INSERT INTO `veterinario` (`correo_veterinario`, `nom_vet`, `app_vet`, `apm_vet`, `numtel_vet`, `especialidad`, `sexo`, `no_cedula`, `id_servicio`) VALUES
('cruz.desparasitacion@vetmail.com', 'Patricia', 'Cruz', 'Morales', '2224445566', 'Desparasitación', 'Femenino', 'CED004', 'S4'),
('herrera.emergencia@vetmail.com', 'Isabel', 'Herrera', 'Díaz', '2220001122', 'Emergencia', 'Femenino', 'CED010', 'S10'),
('lopez.consulta@vetmail.com', 'Alberto', 'Lopez', 'García', '2221112233', 'Consulta General', 'Masculino', 'CED001', 'S1'),
('martinez.vacunas@vetmail.com', 'Lucía', 'Martinez', 'Hernández', '2222223344', 'Vacunación', 'Femenino', 'CED002', 'S2'),
('morales.hospital@vetmail.com', 'Francisco', 'Morales', 'Vázquez', '2229990011', 'Hospitalización', 'Masculino', 'CED009', 'S9'),
('ortiz.dental@vetmail.com', 'Héctor', 'Ortiz', 'Martínez', '2227778899', 'Limpieza Dental', 'Masculino', 'CED007', 'S7'),
('ramirez.cirugia@vetmail.com', 'Jorge', 'Ramirez', 'Santos', '2223334455', 'Cirugía', 'Masculino', 'CED003', 'S3'),
('silva.ultrasonido@vetmail.com', 'Andrea', 'Silva', 'Ruiz', '2226667788', 'Ultrasonido', 'Femenino', 'CED006', 'S6'),
('torres.esterilizacion@vetmail.com', 'Mariana', 'Torres', 'Castro', '2228889900', 'Esterilización', 'Femenino', 'CED008', 'S8'),
('vega.rayosx@vetmail.com', 'Roberto', 'Vega', 'Fernández', '2225556677', 'Rayos X', 'Masculino', 'CED005', 'S5');

UPDATE `veterinario` v
JOIN `usuarios` u ON LOWER(TRIM(v.`correo_veterinario`)) = LOWER(TRIM(u.`correo`))
SET v.`id_usuario` = u.`id_usuario`;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `cita_tutor_FK` FOREIGN KEY (`correo_tutor`) REFERENCES `tutor` (`correo_tutor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cita_veterinario_FK` FOREIGN KEY (`correo_veterinario`) REFERENCES `veterinario` (`correo_veterinario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `consulta_cita_FK` FOREIGN KEY (`id_cita`) REFERENCES `cita` (`id_cita`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `consulta_diagnostico_FK` FOREIGN KEY (`id_diagnostico`) REFERENCES `diagnostico` (`id_diagnostico`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mascota`
--
ALTER TABLE `mascota`
  ADD CONSTRAINT `mascota_tutor_FK` FOREIGN KEY (`correo_tutor`) REFERENCES `tutor` (`correo_tutor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `prod_trat`
--
ALTER TABLE `prod_trat`
  ADD CONSTRAINT `prod_trat_producto_FK` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prod_trat_tratamiento_FK` FOREIGN KEY (`id_tratamiento`) REFERENCES `tratamiento` (`id_tratamiento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `sintomas`
--
ALTER TABLE `sintomas`
  ADD CONSTRAINT `sintomas_consulta_FK` FOREIGN KEY (`id_consulta`) REFERENCES `consulta` (`id_consulta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tratamiento`
--
ALTER TABLE `tratamiento`
  ADD CONSTRAINT `tratamiento_diagnostico_FK` FOREIGN KEY (`id_diagnostico`) REFERENCES `diagnostico` (`id_diagnostico`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `veterinario`
--
ALTER TABLE `veterinario`
  ADD CONSTRAINT `veterinario_servicios_FK` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `veterinario_usuario_FK` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `tutor`
  ADD CONSTRAINT `tutor_usuario_FK` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
