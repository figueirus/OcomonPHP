Novas Implementação Ocomon -->> Titanium

CREATE TABLE `config_import` (
	`conf_imp_situac` INT(5) NOT NULL,
	`conf_imp_local` INT(5) NOT NULL,
	`conf_imp_marca` INT(5) NOT NULL,
	`conf_imp_inst` INT(5) NOT NULL,
	`conf_imp_soft` INT(5) NOT NULL
)
COMMENT='Tabela de Importação de Máquinas'
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
;

CREATE TABLE `config_preventiva` (
	`id` INT(4) NOT NULL AUTO_INCREMENT,
	`conf_num_chamado` INT(4) NOT NULL,
	`conf_tempo_min` INT(4) NOT NULL,
	`conf_tempo_max` INT(4) NOT NULL,
	`conf_maq_nova` INT(4) NOT NULL,
	`conf_data_inic` DATE NOT NULL,
	`conf_tipo_equip` VARCHAR(20) NULL DEFAULT NULL,
	`conf_equip_situac` VARCHAR(20) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COMMENT='Configuração de Preventivas'
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
;
