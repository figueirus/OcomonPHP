CREATE TABLE `formularios` (
	`form_id` INT(5) NOT NULL AUTO_INCREMENT,
	`form_tipo` VARCHAR(50) NOT NULL DEFAULT '0',
	`data_solicit` DATE NOT NULL DEFAULT '0000-00-00',
	`data_prevista` DATE NOT NULL DEFAULT '0000-00-00',
	`usuario` VARCHAR(50) NOT NULL,
	`usuario_ramal` INT(4) NOT NULL,
	`ocorrencia` INT(5) NOT NULL,
	`centro_custo` INT(5) NOT NULL,
	`categ_ramal` INT(5) NULL DEFAULT NULL,
	`ramal_alter` INT(5) NULL DEFAULT NULL,
	`qtd_equip` INT(2) NULL DEFAULT NULL,
	`tipo_equip` INT(5) NULL DEFAULT NULL,
	`flag_equip` VARCHAR(10) NULL DEFAULT NULL,
	`fornecedor` VARCHAR(50) NULL DEFAULT NULL,
	`software` VARCHAR(50) NULL DEFAULT NULL,
	`tipo_licenca` INT(5) NULL DEFAULT NULL,
	`inst_cod` INT(5) NULL DEFAULT NULL,
	`etiqueta` INT(5) NULL DEFAULT NULL,
	`valor_estimado` FLOAT NULL DEFAULT NULL,
	PRIMARY KEY (`form_id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
AUTO_INCREMENT=8;

CREATE TABLE `ramal_controles` (
	`ramal_id` INT(5) NOT NULL AUTO_INCREMENT,
	`ramal` INT(5) NULL DEFAULT '0',
	`ramal_tipo` VARCHAR(50) NULL DEFAULT NULL,
	`ramal_cc` VARCHAR(50) NULL DEFAULT NULL,
	`inst_cod` INT(5) NULL DEFAULT '0',
	`loc_id` INT(5) NULL DEFAULT '0',
	`cat_id` INT(2) NULL DEFAULT '0',
	`situacao_id` INT(2) NULL DEFAULT '0' NULL,
	`data` DATE NULL DEFAULT '0000-00-00',
	`obs` VARCHAR(50) NULL DEFAULT NULL,
	`status` INT(1) NULL DEFAULT '1' ,
	PRIMARY KEY (`ramal_id`),
	INDEX `inst_cod` (`inst_cod`),
	INDEX `loc_id` (`loc_id`),
	INDEX `cat_id` (`cat_id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=MyISAM;

CREATE TABLE `ramal_situacao` (
	`situacao_id` INT(5) NULL AUTO_INCREMENT,
	`situacao_desc` VARCHAR(50) NULL,
	PRIMARY KEY (`situacao_id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `ramal_tipo` (
  `ramalTipo_id` int(5) NOT NULL AUTO_INCREMENT,
  `ramalTipo_desc` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ramalTipo_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `ramal_tipo` (`ramalTipo_id`, `ramalTipo_desc`) VALUES
	(1, 'Analógico'),
	(2, 'Digital'),
	(3, 'Operador');

CREATE TABLE `checkList` (
`id_checkList` INT( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`tit_checkList` VARCHAR( 25 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
`desc_checkList` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
`status_id` INT( 5 ) NOT NULL ,
INDEX ( `status_id` )
) ENGINE = MYISAM ;

CREATE TABLE `status_geral` (
`status_id` INT( 5 ) NOT NULL AUTO_INCREMENT ,
`status` VARCHAR( 20 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
PRIMARY KEY ( `status_id` )
) ENGINE = MYISAM ;

INSERT INTO `status_geral` (`status_id` ,`status`) VALUES (NULL , 'Ativo'), (NULL , 'Inativo');

CREATE TABLE IF NOT EXISTS `avaliacao_oco` (
  `aval_id` int(5) NOT NULL AUTO_INCREMENT,
  `nota_aval_id` int(5) NOT NULL,
  `tipo_atend_id` int(5) NOT NULL,
  `aval_obs` text CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `data_aval` datetime NOT NULL,
  `aval_comentario` text CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `tecnico` text NOT NULL,
  `numero` int(5) NOT NULL,
  PRIMARY KEY (`aval_id`),
  KEY `nota_aval_id` (`nota_aval_id`,`tipo_atend_id`),
  KEY `numero` (`numero`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

-- 
-- Preventivas
 CREATE TABLE IF NOT EXISTS `config_preventiva` (
`id` int(4) NOT NULL auto_increment,
`conf_num_chamado` int(4) NOT NULL,
`conf_tempo_min` int(4) NOT NULL,
`conf_tempo_max` int(4) NOT NULL,
`conf_maq_nova` int(4) NOT NULL,
`conf_data_inic` date NOT NULL,
`conf_tipo_equip` varchar(20) default NULL,
`conf_equip_situac` varchar(20) default NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Configuração de Preventivas';

ALTER TABLE `equipamentos` 
 ADD(
 `comp_leitor` int(4) unsigned default NULL,
 `comp_os` int(4) unsigned default NULL,
 `comp_sn_os` varchar(30) default NULL
 );

CREATE TABLE `nota_aval` (
	`nota_aval_id` INT(5) NOT NULL auto_increment,
	`nota_aval` VARCHAR(60) NOT NULL COLLATE 'latin1_spanish_ci',
	`status_id` INT(5) NOT NULL,
	PRIMARY KEY (`nota_aval_id`),
	INDEX `status_id` (`status_id`)
);

INSERT INTO `nota_aval` (`nota_aval_id`, `nota_aval`,`status_id`) VALUES
(1, 'Excelente',1),
(2, 'Muito Bom',1),
(3, 'Bom',1),
(4, 'Regular',1),
(5, 'Péssimo',1),
(6, 'Não qualificado',2),
(7, 'Não Avaliado - DESAT.',2);

CREATE TABLE IF NOT EXISTS `tipo_atend` (
  `id_atend` int(5) NOT NULL auto_increment,
  `desc_atend` text CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `flag_atend` int(1) NOT NULL,
  PRIMARY KEY (`id_atend`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Tabala de tipo de atendimento' AUTO_INCREMENT=7 ;

CREATE TABLE `usuarioXcentro_custo` (
	`vinc_id` INT(5) NOT NULL auto_increment,
	`user_id` INT(10) NOT NULL DEFAULT '0',
	`centro_custo` INT(10) NOT NULL DEFAULT '0',
	`flag_gestor` INT(10) NULL DEFAULT '0',
	`status` INT(1) NULL DEFAULT NULL,
	PRIMARY KEY (`vinc_id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
AUTO_INCREMENT=4;

CREATE TABLE `usuarioXinstituicao` (
	`vinc_id` INT(5) NOT NULL auto_increment,
	`user_id` INT(10) NOT NULL DEFAULT '0',
	`inst_cod` INT(10) NOT NULL DEFAULT '0',
	`flag_gestor` INT(10) NULL DEFAULT '0',
	`status` INT(1) NULL DEFAULT NULL,
	PRIMARY KEY (`vinc_id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
AUTO_INCREMENT=62;

CREATE TABLE `diretorias` (
	`diretoria_id` INT(5) NULL auto_increment,
	`diretoria_desc` VARCHAR(75) NULL,
	`diretoria_resp` VARCHAR(50) NULL,
	PRIMARY KEY (`diretoria_id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=MyISAM;

INSERT INTO diretorias (diretoria_desc, diretoria_resp) VALUES ('Diretoria Administrativa', '');
INSERT INTO diretorias (diretoria_desc, diretoria_resp) VALUES ('Diretoria de Markting', '');
INSERT INTO diretorias (diretoria_desc, diretoria_resp) VALUES ('Diretoria de Gestão de Pessoas', '');
INSERT INTO diretorias (diretoria_desc, diretoria_resp) VALUES ('Diretoria de Graduação', '');
INSERT INTO diretorias (diretoria_desc, diretoria_resp) VALUES ('Diretoria de Pós Graduação', '');

--
-- Alteração tabelas --
ALTER TABLE `ocorrencias` ADD `id_atend` INT( 5 ) NOT NULL ,
ADD INDEX ( `id_atend` );

ALTER TABLE ocorrencias ADD usu_nota INT(11) default 7;

ALTER TABLE `ocorrencias` ADD COLUMN `form_id` INT(5) NULL DEFAULT '0';

ALTER TABLE `usuarios`
	ADD COLUMN `user_externo` INT(1) NOT NULL DEFAULT '0' AFTER `user_admin`;

ALTER TABLE `reitorias`
	ADD COLUMN `status` INT(1) NULL DEFAULT NULL AFTER `reit_nome`;

ALTER TABLE `ramal_controles`
	ADD COLUMN `diretoria_id` INT(5) NULL DEFAULT '0' AFTER `situacao_id`;
ALTER TABLE `ramal_controles`
	ADD INDEX `diretoria_id` (`diretoria_id`);
