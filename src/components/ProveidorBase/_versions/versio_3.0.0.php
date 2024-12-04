<?php
$callerFile = $_SERVER['PHP_SELF'];
if ($callerFile !== '/SistemaBase/MigracionVersions/controlVersionsSistemaBaseOperacions.php') {
  throw new Exception("error de seguretat");
}
$versio = '3.0.0';
$autor = 'Lluert';
$data = '2024-11-20';
$descripcio = 'Versió inicial de Proveidors';

$sqlUpdate = "CREATE TABLE IF NOT EXISTS `proveidors` (
  `idProveidor` int NOT NULL AUTO_INCREMENT,
  `nomProveidor` varchar(255) DEFAULT NULL,
  `emailProveidor` varchar(255) DEFAULT NULL,
  `contrasenyaProveidor` varchar(255) DEFAULT NULL,
  `localitzadorProveidor` varchar(255) DEFAULT NULL,
  `nomFacturacioProveidor` varchar(255) DEFAULT NULL,
  `direccioFacturacioProveidor` varchar(255) DEFAULT NULL,
  `cpFacturacioProveidor` varchar(255) DEFAULT NULL,
  `poblacioFacturacioProveidor` varchar(255) DEFAULT NULL,
  `provinciaFacturacioProveidor` varchar(255) DEFAULT NULL,
  `codiPaisFacturacioProveidor` varchar(2) DEFAULT NULL,
  `paisFacturacioProveidor` varchar(255) DEFAULT NULL,
  `cifFacturacioProveidor` varchar(255) DEFAULT NULL,
  `correuFacturacioProveidor` varchar(255) DEFAULT NULL,
  `codiComptableProveidor` varchar(12) DEFAULT NULL,
  `telProveidor` varchar(255) DEFAULT NULL,
  `tokenProveidor` varchar(255) DEFAULT NULL,
  `flagActiuProveidor` int NOT NULL DEFAULT '1',
  `longitudComptaComptableProveidor` int NOT NULL DEFAULT '8',
  `idFormaPagament` int NOT NULL DEFAULT '0',
  `dia1Pagament` int DEFAULT '0',
  `dia2Pagament` int DEFAULT '0',
  `compteBancariProveidor` varchar(255) DEFAULT NULL,
  `dataBaixaProveidor` date DEFAULT NULL,
  `comentarisProveidor` varchar(255) DEFAULT NULL,
  `idEmpresa` int NOT NULL DEFAULT '0',
  `idUsuariCreacio` int NOT NULL DEFAULT '0',
  `dataCreacio` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idUsuariModificacio` int NOT NULL DEFAULT '0',
  `dataModificacio` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idProveidor`)
) ENGINE=MyISAM;";
if (!$this->db->query($sqlUpdate)) {
  throw new Exception("error sql " . $this->db->error() . ' ' . $sqlUpdate);
}
