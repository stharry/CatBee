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
PRIMARY KEY (id) );



CREATE  TABLE IF NOT EXISTS campaign (
id INT AUTO_INCREMENT ,
store INT NULL ,
name VARCHAR(45) NULL ,
description VARCHAR(45) NULL ,
PRIMARY KEY (id) );

CREATE  TABLE IF NOT EXISTS Store (
id INT AUTO_INCREMENT ,
description VARCHAR(45) NULL ,
authCode VARCHAR(50) NULL ,
url VARCHAR(1000) NULL ,
PRIMARY KEY (id) );

CREATE  TABLE IF NOT EXISTS StoreBranch (
id INT AUTO_INCREMENT ,
storeId INT NOT NULL ,
shopId INT NOT NULL ,
shopName VARCHAR(50) NULL ,
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



  CREATE  TABLE IF NOT EXISTS customer (

id INT AUTO_INCREMENT ,

email VARCHAR(60) NULL ,

firstName VARCHAR(45) NULL ,

lastName VARCHAR(45) NULL ,

PRIMARY KEY (id) );




CREATE  TABLE IF NOT EXISTS deal (

id INT AUTO_INCREMENT ,

parentId INT NULL,

code VARCHAR(45) NULL ,

landing INT NOT NULL ,

campaignId INT NOT NULL ,

branchId INT NOT NULL,

orderId INT NOT NULL ,

status INT NOT NULL ,

landingReward DOUBLE NULL ,

customerId INT NOT NULL ,

initDate DATETIME NOT NULL ,

updateDate DATETIME NOT NULL ,

PRIMARY KEY (id) );





CREATE  TABLE IF NOT EXISTS frienddeal (
id int(11) AUTO_INCREMENT,
dealID int(11) DEFAULT NULL,
customer int(11) DEFAULT NULL,
status varchar(45) DEFAULT NULL,
initDate datetime DEFAULT NULL,
updateDate datetime DEFAULT NULL,
PRIMARY KEY (id)
);

CREATE  TABLE IF NOT EXISTS purchase (

id INT AUTO_INCREMENT ,

product VARCHAR(45) NULL ,

url VARCHAR(45) NULL ,

price DOUBLE NULL ,

PRIMARY KEY (id) );

CREATE  TABLE IF NOT EXISTS activeshare (
shareType int(11) NOT NULL,
value blob,
deal int(11) NOT NULL,
PRIMARY KEY (shareType,deal)
);


CREATE  TABLE IF NOT EXISTS StoreShareTemplate (

	id INT auto_increment,

	storeId INT NOT NULL,

	campaignId INT NOT NULL,

	shareType INT NOT NULL ,

	message BLOB NULL ,

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
  oauthUrl VARCHAR(500) NOT NULL ,
  redirectUrl VARCHAR(500) NOT NULL ,
  PRIMARY KEY (id)
);