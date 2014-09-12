<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('inwardproduct')};
CREATE TABLE {$this->getTable('inwardproduct')} (
  `inwardproduct_id` int(11) unsigned NOT NULL auto_increment,
  `inwardregister_id` int(11) NOT NULL default '0',
  `itemsku` varchar(50) NOT NULL default '',
  `itemdescription` varchar(200) NOT NULL default '',
  `qty` int(11) NOT NULL default '0',
  `price` int(11) NOT NULL default '0',
  `total` decimal(20) NOT NULL default '0',
  PRIMARY KEY (`inwardproduct_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 