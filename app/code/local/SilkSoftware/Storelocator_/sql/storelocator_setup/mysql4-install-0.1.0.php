<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table storelocator(store_id int not null auto_increment, store varchar(100), address varchar(1000),city varchar(265),state varchar(265),pincode int,tel_number int ,primary key(store_id));

 
		
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 