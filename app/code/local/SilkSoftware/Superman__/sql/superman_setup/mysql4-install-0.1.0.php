<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table IF NOT EXISTS superman_customer(customer_id int not null auto_increment, name varchar(100), lastname varchar(100) ,address text,city varchar(100), zip varchar(100),email varchar(100),mobile int,product_name varchar(255),sku varchar(100), size varchar(100),color varchar(100),primary key(customer_id));
SQLTEXT;

$installer->run($sql);

$installer->endSetup();
	 