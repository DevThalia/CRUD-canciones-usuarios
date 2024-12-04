ALTER TABLE `proveidors` CHANGE `codiContableProveidor`  `codiComptableProveidor` VARCHAR(255) NULL DEFAULT NULL;
ALTER TABLE `proveidors` ADD `dataBaixaProveidor` DATE NULL DEFAULT NULL AFTER `compteBancariProveidor`;
ALTER TABLE `proveidors` ADD `codiPaisFacturacioProveidor` VARCHAR(2) NULL DEFAULT NULL;
ALTER TABLE `proveidors` ADD `paisFacturacioProveidor` VARCHAR(255) NULL DEFAULT NULL;
ALTER TABLE `proveidors` ADD `comentarisProveidor` VARCHAR(255) NULL DEFAULT NULL;
