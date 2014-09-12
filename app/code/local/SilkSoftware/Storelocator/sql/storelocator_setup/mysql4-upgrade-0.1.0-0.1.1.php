<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
alter table storelocator ADD COLUMN country_name varchar(100),ADD COLUMN is_opening_soon int(5);

SQLTEXT;

$installer->run($sql);
//demo
//Mage::getModel('core/url_rewrite')->setId(null);
//demo
$installer->endSetup();

