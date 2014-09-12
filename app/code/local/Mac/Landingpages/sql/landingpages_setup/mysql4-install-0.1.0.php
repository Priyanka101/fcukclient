<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
CREATE TABLE IF NOT EXISTS `landingpages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catname` varchar(100) DEFAULT NULL,
  `imageposition` varchar(100) DEFAULT NULL,
  `content` varchar(2000) DEFAULT NULL,
  `bannerimage` varchar(500) DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  `image` varchar(500) DEFAULT NULL,
  `video` varchar(500) DEFAULT NULL,
  `css` varchar(5000) DEFAULT NULL,
  PRIMARY KEY (`id`)
)
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 