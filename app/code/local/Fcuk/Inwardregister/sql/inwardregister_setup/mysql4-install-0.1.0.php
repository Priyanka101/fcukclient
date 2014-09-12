<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('inwardregister')};
CREATE TABLE {$this->getTable('inwardregister')} (
  `inwardregister_id` int(11) unsigned NOT NULL auto_increment,
  `sku` varchar(100) NOT NULL default '',
  `supplier_id` varchar(100) NOT NULL default '',
  `qty` int(10) NOT NULL,
  `stock_move_to_live` int(10) NOT NULL,
  `stock_remain_not_move_to_live` int(10) NOT NULL,
  `comment` text NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`inwardregister_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 
