<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table requestproduct(requestproduct_id int not null auto_increment, name varchar(100),
email varchar(100),
phoneno int,
productid varchar(100),
primary key(requestproduct_id));

insert into requestproduct values(1,'manoj1','fhgfdh','444','hhh');
  
insert into requestproduct values(2,'manoj2','fhggh','777','ffff');
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 