<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table campaign(campaign_id int not null auto_increment, email_address varchar(100),prefix varchar(10),firstname varchar(100),lastname varchar(100),gender varchar(10),customerdob varchar(10),telephoneno varchar(50),mobileno varchar(50), primary key(campaign_id));
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 