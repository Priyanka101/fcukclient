<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('outwardproduct')};
CREATE TABLE {$this->getTable('outwardproduct')} (
  `outwardproduct_id` int(11) unsigned NOT NULL auto_increment,
  `outwardregister_id` int(11) NOT NULL default '0',
  `itemsku` varchar(50) NOT NULL default '',
  `itemdescription` varchar(200) NOT NULL default '',
  `qty` int(11) NOT NULL default '0',
  `price` int(11) NOT NULL default '0',
  `total` decimal(20) NOT NULL default '0',
  PRIMARY KEY (`outwardproduct_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 