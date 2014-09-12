<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table paymentinfo(payment_info_id int not null auto_increment, name varchar(100), payment_type varchar(100), price varchar(100),
 primary key(payment_info_id));
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 