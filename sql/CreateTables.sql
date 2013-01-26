CREATE TABLE IF NOT EXISTS customers (
   id INT AUTO_INCREMENT,
   email VARCHAR(50),
   firstName VARCHAR(50),
   lastName VARCHAR(50),
   nickName VARCHAR(50),
   PRIMARY KEY(id)
);


CREATE  TABLE IF NOT EXISTS CampaignLandings (
campaignId INT NOT NULL ,
landingId INT NOT NULL ,
PRIMARY KEY (campaignId, landingId) );

CREATE  TABLE IF NOT EXISTS campfriendlanding (
 campaignId INT NOT NULL ,
 FriendLandingID INT NOT NULL ,
  PRIMARY KEY (CampaignId, FriendLandingID) );


CREATE  TABLE IF NOT EXISTS landing (
  id INT AUTO_INCREMENT ,
  sloganFirst VARCHAR(60) NULL ,
  sloganSecond VARCHAR(60) NULL ,
  sliderFirst VARCHAR(45) NULL ,
  sliderSecond VARCHAR(45) NULL ,
  message VARCHAR(200) NULL ,
PRIMARY KEY (id) );



CREATE  TABLE IF NOT EXISTS Campaign (
id INT AUTO_INCREMENT ,
store INT NULL ,
code VARCHAR(45) NOT NULL ,
description VARCHAR(45) NULL ,
landingUrl VARCHAR(250) NULL ,
PRIMARY KEY (id) );

CREATE TABLE IF NOT EXISTS CampaignRestrictions (
  id INT AUTO_INCREMENT ,
  name VARCHAR(45) NULL ,
  campaignId INT NOT NULL ,
  description VARCHAR(100) NOT NULL ,
  code INT NULL ,
  expression BLOB NULL ,
  PRIMARY KEY (id) );


CREATE  TABLE IF NOT EXISTS Adaptor (
id INT AUTO_INCREMENT ,
description VARCHAR(200) NULL ,
authCode VARCHAR(50) NULL ,
url VARCHAR(250) NULL ,
landingUrl VARCHAR(250) NULL ,
PRIMARY KEY (id) );

CREATE  TABLE IF NOT EXISTS StoreBranch (
id INT AUTO_INCREMENT ,
storeId INT NOT NULL ,
shopId INT NOT NULL ,
shopName VARCHAR(50) NOT NULL ,
url VARCHAR(250) NULL ,
logoUrl VARCHAR(250) NULL ,
email VARCHAR(50) NOT NULL,
PRIMARY KEY (id) );


CREATE  TABLE IF NOT EXISTS reward (

id INT AUTO_INCREMENT ,

RewardDesc VARCHAR(45) NULL ,

Value DOUBLE NULL ,

type VARCHAR(45) NULL ,

RewardTypeDesc VARCHAR(45) NULL ,

code VARCHAR(45) NULL ,

PRIMARY KEY (id) );



CREATE  TABLE IF NOT EXISTS landingReward (

	id INT AUTO_INCREMENT ,

	landingId INT NOT NULL,

	FriendReward INT NOT NULL ,

	LeaderReward INT NOT NULL ,

	RewardIndex INT ,

PRIMARY KEY (id) );



CREATE  TABLE IF NOT EXISTS deal
(

id INT AUTO_INCREMENT ,

parentId INT NULL,

landing INT NOT NULL ,

campaignId INT NOT NULL ,

branchId INT NOT NULL,

orderId VARCHAR(50) NOT NULL ,

status INT NOT NULL ,

customerId INT NOT NULL ,

initDate DATETIME NOT NULL ,

updateDate DATETIME NOT NULL ,

PRIMARY KEY (id) );

CREATE  TABLE IF NOT EXISTS ActiveShare (
  id INT AUTO_INCREMENT,
  uid VARCHAR(36) NOT NULL,
  dealId INT NOT NULL,
  shareType INT NOT NULL,
  status INT NOT NULL,
  landRewardId INT NOT NULL,
  shareDate DATETIME,
  value blob,
  PRIMARY KEY (id)
);


CREATE  TABLE IF NOT EXISTS CampaignShareTemplate (

  id INT auto_increment,

  campaignId INT NOT NULL,

  shareType INT NOT NULL ,

  targetId INT NOT NULL,

  message VARCHAR(500) NULL,

  customMessage VARCHAR(500) NULL,

  body TEXT NULL ,

PRIMARY KEY (id) );


CREATE  TABLE IF NOT EXISTS friendlanding (
id int(11) AUTO_INCREMENT,
slogan varchar(60) DEFAULT NULL,
friendMessage varchar(60) DEFAULT NULL,
rewardMessage1 varchar(60) DEFAULT NULL,
rewardMessage2 varchar(60) DEFAULT NULL,
PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS customerAuth (
  contextId INT NOT NULL,
  customerId INT NOT NULL,
  userId INT NOT NULL,
  accessToken VARCHAR(250),
  PRIMARY KEY (contextId, customerId)
);

CREATE TABLE IF NOT EXISTS oauthApps (

  id INT AUTO_INCREMENT ,
  contextId INT NOT NULL ,
  oauthId VARCHAR(100) NOT NULL ,
  oauthKey VARCHAR(100) NOT NULL ,
  oauthSecret VARCHAR(100) NOT NULL ,
  oauthUrl VARCHAR(250) NOT NULL ,
  redirectUrl VARCHAR(250) NOT NULL ,
  PRIMARY KEY (id)
);

CREATE TABLE If NOT EXISTS successfulReferral  (
  ActiveShareID int(11) NOT NULL,
  orderID VARCHAR(50) NOT NULL,
  PRIMARY KEY (ActiveShareID,orderID)
);

CREATE TABLE  If NOT EXISTS impression (
  ActiveShareID int(11) DEFAULT NULL,
  IP varchar(45) DEFAULT NULL,
  TimeStamp varchar(45) DEFAULT NULL,
  Browser varchar(45) DEFAULT NULL,
  Customer varchar(45) DEFAULT NULL
);

CREATE TABLE If NOT EXISTS ShopActions (
  shopId INT NOT NULL,
  action VARCHAR(1000),
  PRIMARY KEY shopId
);
