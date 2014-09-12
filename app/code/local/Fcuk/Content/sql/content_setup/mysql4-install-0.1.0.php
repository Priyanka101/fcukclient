<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table IF NOT EXISTS gamechangernew(gamechangerid int not null auto_increment,slideno varchar(100),
type varchar(100),
name1 varchar(100),
image1 varchar(500),
url1 varchar(300),
name2 varchar(100),
image2 varchar(500),
url2 varchar(300),
name3 varchar(100),
image3 varchar(500),
url3 varchar(300),
name4 varchar(100),
image4 varchar(500),
url4 varchar(300),
name5 varchar(100),
image5 varchar(500),
url5 varchar(300),
name6 varchar(100),
image6 varchar(500),
url6 varchar(300),
primary key(gamechangerid));
 
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 