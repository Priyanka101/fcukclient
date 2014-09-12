<?php
$installer = $this;
$installer->startSetup();
$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('store_location')};
CREATE TABLE {$this->getTable('store_location')} (
  			`id` INT(10) NOT NULL AUTO_INCREMENT,
			`name` VARCHAR(1000) NULL DEFAULT '0',
			`address` VARCHAR(1000) NULL DEFAULT '0',
			`landmark` VARCHAR(1000) NULL DEFAULT '0',
			`area` VARCHAR(1000) ,
			`city` VARCHAR(1000) ,
			`phone` VARCHAR(1000) ,
			`email` VARCHAR(1000) ,
			`gender` VARCHAR(1000) ,
			
			PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
$installer->endSetup();


