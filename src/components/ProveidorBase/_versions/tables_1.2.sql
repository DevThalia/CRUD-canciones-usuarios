ALTER TABLE `proveidors` ADD `flagActiu` INT NOT NULL DEFAULT '0' AFTER `idEmpresa`;
UPDATE proveidors set flagActiu=1
