ALTER TABLE `proveidors` ADD `idEmpresa` INT NOT NULL DEFAULT '0' AFTER `idAlbaraProveidor`;
UPDATE proveidors set idEmpresa=1;

ALTER TABLE `proveidors` CHANGE `correuFacturacio` `correuFacturacioProveidor` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;