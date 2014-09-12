<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('outwardregister')};
CREATE TABLE {$this->getTable('outwardregister')} (
  `outwardregister_id` int(11) unsigned NOT NULL auto_increment,
  `sku` varchar(100) NOT NULL default '',
  `supplier_id` varchar(100) NOT NULL default '',
  `qty` int(10) NOT NULL,
  `comment` text NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`outwardregister_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 