<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table IF NOT EXISTS man(id int not null auto_increment, name varchar(100),
url varchar(500),
content varchar(500),
image varchar(500),
 primary key(id));

		
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 