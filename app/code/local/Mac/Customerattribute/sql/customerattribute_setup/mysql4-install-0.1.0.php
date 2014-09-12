<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
CREATE TABLE IF NOT EXISTS `findaddress` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `country_id` varchar(100) NOT NULL,
  `postcode` varchar(100) NOT NULL,
  `street` varchar(300) NOT NULL,
  `state` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
)
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 