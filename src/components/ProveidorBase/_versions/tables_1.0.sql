-- --------------------------------------------------------

--
-- Estructura de la taula `proveidors`
--

CREATE TABLE `proveidors` (
  `idProveidor` int(11) NOT NULL,
  `nomProveidor` varchar(255) NOT NULL,
  `emailProveidor` varchar(255) DEFAULT NULL,
  `contrasenyaProveidor` varchar(255) DEFAULT NULL,
  `localitzadorProveidor` varchar(255) DEFAULT NULL,
  `nomFacturacioProveidor` varchar(255) DEFAULT NULL,
  `direccioFacturacioProveidor` varchar(255) DEFAULT NULL,
  `cpFacturacioProveidor` varchar(255) DEFAULT NULL,
  `poblacioFacturacioProveidor` varchar(255) DEFAULT NULL,
  `provinciaFacturacioProveidor` varchar(255) DEFAULT NULL,
  `cifFacturacioProveidor` varchar(255) DEFAULT NULL,
  `correuFacturacio` varchar(255) DEFAULT NULL,
  `codiComptableProveidor` VARCHAR(255) NULL DEFAULT NULL,
  `telProveidor` varchar(255) DEFAULT NULL,
  `tokenProveidor` varchar(255) DEFAULT NULL,
  `codiImpresa` int(11) NOT NULL DEFAULT '0',
  `longitudComptaComptableProveidor` int(11) NOT NULL DEFAULT '8',
  `idComandaProveidor` int(11) NOT NULL,
  `idAlbaraProveidor` int(11) NOT NULL,
  `idUsuariModificacio` int(11) NOT NULL DEFAULT '0',
  `dataModificacio` datetime DEFAULT NULL,
  `idUsuariCreacio` int(11) NOT NULL DEFAULT '0',
  `dataCreacio` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
--
-- Índexs per a la taula `proveidors`
--
ALTER TABLE `proveidors`
  ADD PRIMARY KEY (`idProveidor`);
