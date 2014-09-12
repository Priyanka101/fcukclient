<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table cod(cod_id int not null auto_increment, pincode varchar(100),
city varchar(100),
location varchar(100),
state varchar(100),
cod varchar(100),
zone varchar(100),
eastzone int(10),
 primary key(cod_id));

create table ncod(ncod_id int not null auto_increment, pincode varchar(100),
city varchar(100),
location varchar(100),
state varchar(100),
ncod varchar(100),
zone varchar(100),
eastzone int(10),
 primary key(ncod_id));

SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 