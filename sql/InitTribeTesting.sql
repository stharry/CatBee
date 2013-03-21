INSERT INTO tribes(id,tribeName) VALUES(2,'Test1');
INSERT INTO tribes(id,tribeName) VALUES(1,'Test2');


INSERT INTO storebranch(id,storeId,shopId,shopName,url,logoUrl,email)
VALUES(2,2,2,'glassesmarket','http://www.glassesmarket.com','http://www.glassesmarket.com/skin/frontend/glassesmarket2/default/images/logo.png','');

INSERT INTO storebranch(id,storeId,shopId,shopName,url,logoUrl,email)
VALUES(3,3,3,'CharmsToTreasure','http://www.glassesmarket.com','http://gallery.mailchimp.com/f503f7e5aac319051c907e2fb/images/CTT_email_header_v3.jpg','');

INSERT INTO tribeCustomers(id,TribeId,CustomerID)VALUES(1,1,2);

INSERT INTO tribeStores(id,TribeID,StoreID) VALUES(1,1,1);
INSERT INTO tribeStores(id,TribeID,StoreID) VALUES(2,1,2);

INSERT INTO rule(id,name,description,actionTriger,reward,type,rewardval)VALUES(1,'Purchase','1 point for every $10 Spent',1,1,'social credit',50);

INSERT INTO rewardrules(id,Name,type,value) VALUES(1,'Credit for purchase','points','$10');

INSERT INTO storerules(id,storeid,ruleid)VALUES(1,1,1);


