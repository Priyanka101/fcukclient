<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table pressreleases(release_id int not null auto_increment, release_name varchar(100),new_date datetime,blog text,banner varchar(1000),primary key(release_id));

create table presscoverage(coverage_id int not null auto_increment,title varchar(100),new_date datetime,image varchar(265),imagetitle varchar(265),primary key(coverage_id));

create table 	defaultbanner(banner_id int not null auto_increment,default_banner varchar(255),primary key(banner_id));		
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 