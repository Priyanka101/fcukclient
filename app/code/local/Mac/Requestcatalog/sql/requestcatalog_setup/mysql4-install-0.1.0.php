<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table IF NOT EXISTS requestcatalog(id int not null auto_increment, 
title varchar(100), 
firstname varchar(100),
lastname varchar(100),
email varchar(100),
address varchar(1000), 
city varchar(100), 
postcode varchar(100), 
state varchar(100), 
country varchar(100), 
primary key(id));
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 