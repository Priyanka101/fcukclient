<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table IF NOT EXISTS lookbook
(id int not null auto_increment, 
name varchar(100),
category varchar(100),
smallimage varchar(100),
thumbnailimage varchar(100),
productsku varchar(2000),
shopbylooksku varchar(2000),
shopbylookurl varchar(500),
 primary key(id));
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 