CREATE TABLE tx_mksamlauth_domain_model_identityprovider (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) DEFAULT '0' NOT NULL,
    crdate int(11) DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    sorting int(10) DEFAULT '0' NOT NULL,
    deleted tinyint(4) DEFAULT '0' NOT NULL,
    hidden tinyint(4) DEFAULT '0' NOT NULL,
    starttime int(11) DEFAULT '0' NOT NULL,
    endtime int(11) DEFAULT '0' NOT NULL,

    name VARCHAR(255) DEFAULT '' NOT NULL,
    domain VARCHAR(255) NOT NULL,
    user_folder int(11) DEFAULT '0' NOT NULL,
    url VARCHAR(255) DEFAULT '' NOT NULL,
    certificate text NOT NULL,
    cert_key text NOT NULL,
    passphrase VARCHAR(255) NULL,
    default_groups_enable int(1) DEFAULT '0' NOT NULL,
    default_groups tinytext,

    PRIMARY KEY (uid),
    KEY parent (pid)
);

CREATE TABLE tx_mksamlauth_domain_model_serviceprovider (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) DEFAULT '0' NOT NULL,
    crdate int(11) DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    sorting int(10) DEFAULT '0' NOT NULL,
    deleted tinyint(4) DEFAULT '0' NOT NULL,
    hidden tinyint(4) DEFAULT '0' NOT NULL,
    starttime int(11) DEFAULT '0' NOT NULL,
    endtime int(11) DEFAULT '0' NOT NULL,

    name VARCHAR(255) DEFAULT '' NOT NULL,
    domain VARCHAR(255) NOT NULL,
    certificate text NOT NULL,
    cert_key text NOT NULL,
    passphrase VARCHAR(255) NULL,

    PRIMARY KEY (uid),
    KEY parent (pid)
);

CREATE TABLE tx_mksamlauth_domain_model_group_mapping (
  uid int(11) NOT NULL auto_increment,
  pid int(11) DEFAULT '0' NOT NULL,
  tstamp int(11) DEFAULT '0' NOT NULL,
  crdate int(11) DEFAULT '0' NOT NULL,
  cruser_id int(11) DEFAULT '0' NOT NULL,
  sorting int(10) DEFAULT '0' NOT NULL,
  deleted tinyint(4) DEFAULT '0' NOT NULL,
  hidden tinyint(4) DEFAULT '0' NOT NULL,
  starttime int(11) DEFAULT '0' NOT NULL,
  endtime int(11) DEFAULT '0' NOT NULL,

  idp_name VARCHAR(255) DEFAULT '' NOT NULL,
  idp_id INT(11) DEFAULT '0' NOT NULL,
  group_ids VARCHAR(255) NOT NULL,

  PRIMARY KEY (uid),
  KEY parent (pid)
);

CREATE TABLE fe_users (
    mksamlauth_host VARCHAR(255) DEFAULT '' NOT NULL
);
