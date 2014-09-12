<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table subscription(s_id int not null auto_increment, email varchar(100), mobileno varchar(20),primary key(s_id));

SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 