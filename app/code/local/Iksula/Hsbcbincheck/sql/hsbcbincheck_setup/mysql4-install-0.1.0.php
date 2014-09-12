<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table credit_bin_numbers(id int not null auto_increment, credit_bins varchar(100), primary key(id));
create table debit_bin_numbers(id int not null auto_increment, debit_bins varchar(100), primary key(id));

SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 