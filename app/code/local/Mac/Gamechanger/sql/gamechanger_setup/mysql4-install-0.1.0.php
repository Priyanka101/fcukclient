<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table if not exists gamechanger(
id int not null auto_increment, 
categoryname varchar(100), 
bannertype varchar(100), 
bannerno varchar(100), 
bannerposition varchar(100), 
image varchar(100), 
content varchar(100), 
url varchar(100), 
primary key(id));
 
		
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 