CREATE TABLE tx_mobilecompany_domain_model_mobile (
	company        int(11) unsigned DEFAULT '0' NOT NULL,
	model_name     varchar(255) NOT NULL DEFAULT '',
	slug           varchar(255) NOT NULL DEFAULT '',
	brand          varchar(255)  NOT NULL DEFAULT '',
	image          int(11) unsigned NOT NULL DEFAULT '0',
	price          double(11,2) NOT NULL DEFAULT '0.00',
	release_date   date DEFAULT NULL,
	specifications varchar(255) NOT NULL DEFAULT '',
	companies      int(11) NOT NULL DEFAULT '0'
);

CREATE TABLE tx_mobilecompany_domain_model_company (
	name         varchar(255) NOT NULL DEFAULT '',
	country      varchar(255) NOT NULL DEFAULT '',
	founded_year int(11) NOT NULL DEFAULT '0',
	website      varchar(255) NOT NULL DEFAULT '',
	description  text NOT NULL DEFAULT '',
	mobiles      int(11) unsigned NOT NULL DEFAULT '0'
);
