<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table if not exists whitelies(
id int not null auto_increment, 
categoryname varchar(100), 
bannername varchar(100), 
bannertype varchar(100), 
bannerno varchar(100), 
bannerposition varchar(100), 
content varchar(1000), 
productid varchar(200),
url varchar(100), 
smallimage varchar(200), 
thumbnail varchar(200),
primary key(id));
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 