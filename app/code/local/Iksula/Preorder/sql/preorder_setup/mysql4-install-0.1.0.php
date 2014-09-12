<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table preorder(preorder_id int not null auto_increment, customer_firstname varchar(100), customer_lastname varchar(100), customer_address varchar(300), customer_city varchar(100), customer_email varchar(100), product_name varchar(100), product_sku varchar(100), selected_size varchar(100), selected_color varchar(100), primary key(preorder_id));

SQLTEXT;

$installer->run($sql);

$installer->endSetup();
	 