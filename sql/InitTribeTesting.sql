INSERT INTO tribes(id,tribeName) VALUES(2,'Test1');
INSERT INTO tribes(id,tribeName) VALUES(1,'Test2');


INSERT INTO storebranch(id,storeId,shopId,shopName,url,logoUrl,email)
VALUES(2,2,2,'glassesmarket','http://www.glassesmarket.com','http://www.glassesmarket.com/skin/frontend/glassesmarket2/default/images/logo.png','');

INSERT INTO storebranch(id,storeId,shopId,shopName,url,logoUrl,email)
VALUES(3,3,3,'CharmsToTreasure','http://www.glassesmarket.com','http://gallery.mailchimp.com/f503f7e5aac319051c907e2fb/images/CTT_email_header_v3.jpg','');

INSERT INTO customers(id,email,firstName,lastName,nickName,sharedPhoto)VALUES(3,'Navot@tribzi.com','Navot','Dgani','Navot','');
INSERT INTO customers(id,email,firstName,lastName,nickName,sharedPhoto)VALUES(4,'Shiran@tribzi.com','Shiran','cohen','Shiran','');
INSERT INTO customers(id,email,firstName,lastName,nickName,sharedPhoto)VALUES(5,'Chaim@tribzi.com','Chaim','Kutnicki','Chaim','');
INSERT INTO customers(id,email,firstName,lastName,nickName,sharedPhoto)VALUES(6,'Tomer@tribzi.com','Tom','hanks','Tom','');

INSERT INTO tribeCustomers(id,TribeId,CustomerID)VALUES(1,1,2);
INSERT INTO tribeCustomers(id,TribeId,CustomerID)VALUES(2,1,3);
INSERT INTO tribeCustomers(id,TribeId,CustomerID)VALUES(3,1,4);
INSERT INTO tribeCustomers(id,TribeId,CustomerID)VALUES(5,1,6);
INSERT INTO tribeCustomers(id,TribeId,CustomerID)VALUES(4,2,5);

INSERT INTO tribeStores(id,TribeID,StoreID) VALUES(1,1,1);
INSERT INTO tribeStores(id,TribeID,StoreID) VALUES(2,1,2);
INSERT INTO tribeStores(id,TribeID,StoreID) VALUES(3,2,3);

INSERT INTO rule(id,name,description,actionTriger,reward,type,rewardval)VALUES(1,'Purchase','1 point for every $10 Spent',1,1,'social credit',50);
INSERT INTO rule(id,name,description,actionTriger,reward,type,rewardval)VALUES(2,'Reigister','5 point for New Tribe Member registration',1,1,'social credit',5);
INSERT INTO rule(id,name,description,actionTriger,reward,type,rewardval)VALUES(3,'Gift Card Tribe Goal','$25 gift Card For ',1,1,'Tribe Goal',5);


INSERT INTO rewardrules(id,Name,type,value) VALUES(1,'Credit for purchase','points','$10');

INSERT INTO storerules(id,storeid,ruleid)VALUES(1,1,1);
INSERT INTO storerules(id,storeid,ruleid)VALUES(2,2,1);
INSERT INTO storerules(id,storeid,ruleid)VALUES(3,2,3);

