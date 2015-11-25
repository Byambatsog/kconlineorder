-- MySQL dump 10.13  Distrib 5.6.26, for osx10.5 (x86_64)
--
-- Host: localhost    Database: kc_online_order
-- ------------------------------------------------------
-- Server version	5.6.26

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES UTF8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cardtypes`
--

DROP TABLE IF EXISTS `cardtypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cardtypes` (
  `cardTypeID` int(11) NOT NULL,
  `description` varchar(60) NOT NULL,
  PRIMARY KEY (`cardTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cardtypes`
--

LOCK TABLES `cardtypes` WRITE;
/*!40000 ALTER TABLE `cardtypes` DISABLE KEYS */;
INSERT INTO `cardtypes` VALUES (1,'Master Card'),(2,'Visa'),(3,'American Express'),(4,'Gift card');
/*!40000 ALTER TABLE `cardtypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `customerID` int(11) NOT NULL,
  `billingStreet` varchar(60) NOT NULL,
  `billingCity` varchar(40) NOT NULL,
  `billingState` varchar(2) NOT NULL,
  `billingZipCode` varchar(10) NOT NULL,
  `shippingStreet` varchar(60) DEFAULT NULL,
  `shippingCity` varchar(40) DEFAULT NULL,
  `shippingState` varchar(2) DEFAULT NULL,
  `shippingZipCode` varchar(10) DEFAULT NULL,
  `cardTypeID` int(11) DEFAULT NULL,
  `cardNumber` char(16) DEFAULT NULL,
  `cardExpMonth` char(2) DEFAULT NULL,
  `cardExpYear` char(4) DEFAULT NULL,
  `discountPercentage` int(11) NOT NULL,
  PRIMARY KEY (`customerID`),
  KEY `shippingCity` (`shippingCity`),
  KEY `shippingState` (`shippingState`),
  KEY `shippingZipCode` (`shippingZipCode`),
  KEY `cardTypeID` (`cardTypeID`),
  CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`cardTypeID`) REFERENCES `cardtypes` (`cardTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'1246 W PRATT BLVD','Chicago','IL','60626','1246 W PRATT BLVD','Chicago','IL','60626',1,'5370463888813020','01','2018',0),(9,'9 Murfreesboro Rd','Chicago','IL','60623','9 Murfreesboro Rd','Chicago','IL','60623',1,'5299156156891938','02','2018',0),(10,'45 E Acacia Ct','Chicago','IL','60624','45 E Acacia Ct','Chicago','IL','60624',1,'5293850200713058','03','2018',0),(11,'72 Beechwood Ter','Chicago','IL','60657','72 Beechwood Ter','Chicago','IL','60657',1,'5548024663365664','04','2018',0),(12,'25 E 75th St #69','Los Angeles','CA','90034','25 E 75th St #69','Los Angeles','CA','90034',1,'5218014427039266','05','2018',0),(13,'90991 Thorburn Ave','New York','NY','10011','90991 Thorburn Ave','New York','NY','10011',1,'5399070641280178','06','2018',0),(14,'2742 Distribution Way','New York','NY','10025','2742 Distribution Way','New York','NY','10025',1,'5144869127761108','07','2018',0),(15,'128 Bransten Rd','New York','NY','10011','128 Bransten Rd','New York','NY','10011',1,'5527124750467780','09','2018',0),(16,'775 W 17th St','San Antonio','TX','78204','775 W 17th St','San Antonio','TX','78204',1,'5180380736798221','10','2018',0),(17,'678 3rd Ave','Miami','FL','33196','678 3rd Ave','Miami','FL','33196',1,'5413442801450036','11','2018',0),(18,'38938 Park Blvd','Boston','MA','2128','38938 Park Blvd','Boston','MA','2128',2,'4929381332664295','01','2019',0),(19,'4486 W O St #1','New York','NY','10003','4486 W O St #1','New York','NY','10003',2,'4916481158148111','02','2019',0),(20,'3305 Nabell Ave #679','New York','NY','10009','3305 Nabell Ave #679','New York','NY','10009',2,'4916403492698783','03','2019',0),(21,'701 S Harrison Rd','San Francisco','CA','94104','701 S Harrison Rd','San Francisco','CA','94104',2,'4539538574255825','04','2019',0),(22,'32860 Sierra Rd','Miami','FL','33133','32860 Sierra Rd','Miami','FL','33133',2,'4916976652406147','05','2019',0),(23,'9 N College Ave #3','Milwaukee','WI','53216','9 N College Ave #3','Milwaukee','WI','53216',2,'4556007212947415','07','2019',0),(24,'8 Industry Ln','New York','NY','10002','8 Industry Ln','New York','NY','10002',2,'4532422069229909','07','2019',0),(25,'229 N Forty Driv','New York','NY','10011','229 N Forty Driv','New York','NY','10011',2,'4916673475725015','08','2019',0),(26,'6 Middlegate Rd #106','San Francisco','CA','94107','6 Middlegate Rd #106','San Francisco','CA','94107',2,'4539003137030728','09','2019',0),(27,'25346 New Rd','New York','NY','10016','25346 New Rd','New York','NY','10016',3,'378282246310005','01','2016',0),(28,'42744 Hamann Industrial Pky #82','Miami','FL','33136','42744 Hamann Industrial Pky #82','Miami','FL','33136',3,'371449635398431','02','2017',0),(29,'3882 W Congress St #799','Los Angeles','CA','90016','3882 W Congress St #799','Los Angeles','CA','90016',3,'378282246310005','04','2018',0),(30,'209 Decker Dr','Philadelphia','PA','19132','209 Decker Dr','Philadelphia','PA','19132',1,'4846515574646378','01','2017',0),(31,'3 Fort Worth Ave','Philadelphia','PA','19106','3 Fort Worth Ave','Philadelphia','PA','19106',1,'4846515574646378','01','2017',0),(32,'63381 Jenks Ave','Philadelphia','PA','19134','63381 Jenks Ave','Philadelphia','PA','19134',1,'4846515574646378','01','2017',0),(33,'992 Civic Center Dr','Philadelphia','PA','19123','992 Civic Center Dr','Philadelphia','PA','19123',1,'4846515574646378','01','2017',0),(34,'73 Southern Blvd','Philadelphia','PA','19103','73 Southern Blvd','Philadelphia','PA','19103',1,'4846515574646378','01','2017',0),(35,'4379 Highway 116','Philadelphia','PA','19103','4379 Highway 116','Philadelphia','PA','19103',1,'4846515574646378','01','2017',0),(36,'4441 Point Term Mkt','Philadelphia','PA','19143','4441 Point Term Mkt','Philadelphia','PA','19143',1,'4846515574646378','01','2017',0),(37,'910 Rahway Ave','Philadelphia','PA','19102','910 Rahway Ave','Philadelphia','PA','19102',1,'4846515574646378','01','2017',0);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employees` (
  `employeeID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `birthDate` date NOT NULL,
  `dateHired` date NOT NULL,
  `supervisorID` int(11) NOT NULL,
  `locationID` int(11) NOT NULL,
  PRIMARY KEY (`employeeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,'Executive','1986-08-15','2005-12-21',0,1),(2,'Manager','1985-05-12','2008-03-15',0,2),(3,'Front desc clerk','1990-01-24','2013-09-12',1,1),(4,'Front desc clerk','1992-01-24','2011-06-11',1,1),(5,'Front desc clerk','1988-02-28','2012-08-01',1,1),(6,'Front desc clerk','1989-05-09','2014-04-30',2,2),(7,'Front desc clerk','1987-09-26','2011-05-07',2,2),(8,'Front desc clerk','1988-10-09','2012-03-24',2,2);
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `flavors`
--

DROP TABLE IF EXISTS `flavors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `flavors` (
  `flavorID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `itemID` int(11) NOT NULL,
  `status` char(1) NOT NULL,
  `created` datetime NOT NULL,
  `createdBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`flavorID`),
  KEY `status` (`status`),
  KEY `itemID` (`itemID`),
  KEY `createdBy` (`createdBy`),
  CONSTRAINT `flavors_ibfk_1` FOREIGN KEY (`itemID`) REFERENCES `menuitems` (`itemID`),
  CONSTRAINT `flavors_ibfk_2` FOREIGN KEY (`createdBy`) REFERENCES `users` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flavors`
--

LOCK TABLES `flavors` WRITE;
/*!40000 ALTER TABLE `flavors` DISABLE KEYS */;
INSERT INTO `flavors` VALUES (1,'Smoky',1,'E','2015-11-18 16:30:13',1),(2,'Cheesy',1,'E','2015-11-18 16:30:13',1),(3,'Grilled',1,'E','2015-11-18 16:30:13',1),(4,'Spicy',1,'E','2015-11-18 16:30:13',1),(5,'Salty',2,'E','2015-11-18 16:38:04',1),(6,'Spicy',2,'E','2015-11-18 16:38:04',1),(7,'Savory',2,'E','2015-11-18 16:38:04',1),(8,'Sour',2,'E','2015-11-18 16:38:04',1),(9,'Salty',3,'E','2015-11-18 16:38:04',1),(10,'Spicy',3,'E','2015-11-18 16:38:04',1),(11,'Bitter',3,'E','2015-11-18 16:38:04',1),(12,'Sweet',3,'E','2015-11-18 16:38:04',1),(13,'Savory',4,'E','2015-11-18 16:38:04',1),(14,'Spicy',4,'E','2015-11-18 16:38:04',1),(15,'Sour',4,'E','2015-11-18 16:38:04',1),(16,'Sweet',4,'E','2015-11-18 16:38:04',1);
/*!40000 ALTER TABLE `flavors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `giftcards`
--

DROP TABLE IF EXISTS `giftcards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `giftcards` (
  `giftCardId` int(11) NOT NULL AUTO_INCREMENT,
  `giftCardCode` varchar(10) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `expMonth` char(2) NOT NULL,
  `expYear` char(4) NOT NULL,
  `status` char(1) NOT NULL,
  `created` datetime NOT NULL,
  `createdBy` int(11) NOT NULL,
  PRIMARY KEY (`giftCardId`),
  UNIQUE KEY `giftCardCode` (`giftCardCode`),
  KEY `status` (`status`),
  KEY `createdBy` (`createdBy`),
  CONSTRAINT `giftcards_ibfk_1` FOREIGN KEY (`createdBy`) REFERENCES `users` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `giftcards`
--

LOCK TABLES `giftcards` WRITE;
/*!40000 ALTER TABLE `giftcards` DISABLE KEYS */;
INSERT INTO `giftcards` VALUES (1,'IFWS89IDF0',20.00,20.00,'02','2016','E','2015-11-18 16:43:51',1),(2,'IFWDWSIDF1',50.00,50.00,'02','2016','E','2015-11-18 16:43:51',1),(3,'IFWS8SDLDF',50.00,50.00,'02','2016','E','2015-11-18 16:43:51',1),(4,'IFWSDS89DF',30.00,30.00,'02','2016','E','2015-11-18 16:43:51',1),(5,'IFSDFW67F0',30.00,30.00,'02','2016','E','2015-11-18 16:43:51',1),(6,'IFSDF9FDS8',100.00,100.00,'02','2016','E','2015-11-18 16:43:51',1),(7,'IFMNDOW987',100.00,100.00,'02','2016','E','2015-11-18 16:43:51',1);
/*!40000 ALTER TABLE `giftcards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `locationID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `street` varchar(60) NOT NULL,
  `city` varchar(40) NOT NULL,
  `state` varchar(2) NOT NULL,
  `zipCode` varchar(10) NOT NULL,
  `coordinate` varchar(100) DEFAULT NULL,
  `phone` varchar(12) NOT NULL,
  `fax` varchar(12) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `timeTable` varchar(255) NOT NULL,
  `managerID` int(11) DEFAULT NULL,
  `status` char(1) NOT NULL,
  `created` datetime NOT NULL,
  `createdBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`locationID`),
  KEY `name` (`name`),
  KEY `city` (`city`),
  KEY `state` (`state`),
  KEY `zipCode` (`zipCode`),
  KEY `status` (`status`),
  KEY `managerID` (`managerID`),
  KEY `createdBy` (`createdBy`),
  CONSTRAINT `locations_ibfk_1` FOREIGN KEY (`managerID`) REFERENCES `employees` (`employeeID`),
  CONSTRAINT `locations_ibfk_2` FOREIGN KEY (`createdBy`) REFERENCES `users` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,'John Hancock Center','875 North Michigan Avenue','Chicago','IL','60611','','312-337-1101','312-337-1101','johnhancock@kingscrown.com','11:00AM - 12:30AM',1,'E','2015-11-17 23:34:15',1),(2,'Michigan & Wacker','316 N Michigan Avenue','Chicago','IL','60601','','312.578.0950','312.578.0967','michigan@kingscrown.com','10:30 AM - 10:00 PM',2,'E','2015-11-17 23:34:15',1);
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menucategories`
--

DROP TABLE IF EXISTS `menucategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menucategories` (
  `categoryID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `ranking` int(11) NOT NULL,
  `status` char(1) NOT NULL,
  `created` datetime NOT NULL,
  `createdBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`categoryID`),
  KEY `status` (`status`),
  KEY `createdBy` (`createdBy`),
  CONSTRAINT `menucategories_ibfk_1` FOREIGN KEY (`createdBy`) REFERENCES `users` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menucategories`
--

LOCK TABLES `menucategories` WRITE;
/*!40000 ALTER TABLE `menucategories` DISABLE KEYS */;
INSERT INTO `menucategories` VALUES (1,'Main Entrees','',1,'E','2015-11-18 15:00:14',1),(2,'Salads','',2,'E','2015-11-18 15:00:14',1),(3,'Deserts','',3,'E','2015-11-18 15:00:14',1),(4,'Beverages','',4,'E','2015-11-18 15:00:14',1);
/*!40000 ALTER TABLE `menucategories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menuitems`
--

DROP TABLE IF EXISTS `menuitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menuitems` (
  `itemID` int(11) NOT NULL AUTO_INCREMENT,
  `categoryID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `description` text,
  `unitPrice` decimal(10,2) NOT NULL,
  `calories` int(11) DEFAULT NULL,
  `ranking` int(11) NOT NULL,
  `status` char(1) NOT NULL,
  `created` datetime NOT NULL,
  `createdBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`itemID`),
  KEY `name` (`name`),
  KEY `unitPrice` (`unitPrice`),
  KEY `calories` (`calories`),
  KEY `ranking` (`ranking`),
  KEY `status` (`status`),
  KEY `createdBy` (`createdBy`),
  KEY `categoryID` (`categoryID`),
  CONSTRAINT `menuitems_ibfk_1` FOREIGN KEY (`createdBy`) REFERENCES `users` (`userID`),
  CONSTRAINT `menuitems_ibfk_2` FOREIGN KEY (`categoryID`) REFERENCES `menucategories` (`categoryID`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menuitems`
--

LOCK TABLES `menuitems` WRITE;
/*!40000 ALTER TABLE `menuitems` DISABLE KEYS */;
INSERT INTO `menuitems` VALUES (1,1,'Burger','http://cdn.foodbeast.com.s3.amazonaws.com/content/uploads/2013/12/Olive-Garden-Burger.jpg','Charbroiled on a Toasted Brioche Bun with Lettuce, Tomato, Onion, Pickles and Mayonnaise. Served with French Fries or Green Salad',7.50,750,1,'E','2015-11-18 15:28:32',1),(2,1,'Sandwich','http://cdn.sheknows.com/articles/2013/12/Mike/Sponsored/3_grilled_cheeses/caprese-grilled-cheese.jpg','Tender Pulled Pork, Crispy Bacon, and Slow Roasted Applewood Smoked Bacon Topped with Creamy Cole Slaw on a Grilled Bun with Pickles and B.B.Q. Sauce.',7.00,700,2,'E','2015-11-18 15:28:32',1),(3,1,'Tacos','http://1.bp.blogspot.com/-uH4s-SUyNhk/VaAFVRXrZRI/AAAAAAAA1ww/DdbhdveFyTU/s1600/Chicken%2BNugget%2BTacos%2Bwith%2BLime%2BDressing.jpg','Soft Corn Tortillas Filled with Spicy Chicken, Cheese, Tomato, Avocado, Onion, Chipotle and Cilantro. Served with Rice and Beans',7.20,680,3,'E','2015-11-18 15:28:32',1),(4,1,'Burrito','http://www.hagerstownpizzabrothers.com/wp-content/uploads/2014/12/special-burrito.jpg','A Monster Burrito with Chicken, Cheese, Cilantro Rice, Onions and Peppers. Served with Guacamole, Sour Cream, Salsa and Black Beans.',8.00,800,4,'E','2015-11-18 15:28:32',1),(5,1,'Pizza slice','https://h2savecom.files.wordpress.com/2014/05/screen-shot-2014-05-21-at-11-04-31-am.png','Italian Soppressata, Mildly Spicy Peppers, Fresh Mozzarella, Tomato Sauce and Parmesan.',5.80,600,5,'E','2015-11-18 15:28:32',1),(6,2,'Caesar Salad','http://etaiscatering.com/weborders/images/final/salads/chickenCaesarSalad.jpg','The Almost Traditional Recipe with Croutons, Parmesan Cheese and Our Special Caesar Dressing. Available with Chicken.',4.00,300,1,'E','2015-11-18 15:32:40',1),(7,2,'Cobb Salad','https://s3.amazonaws.com/cdn2/Cocos+Menu/m.zipscene+images/cobb-salad.jpg','Chicken Breast, Avocado, Blue Cheese, Bacon, Tomato, Egg and Romaine Tossed in Our Vinaigrette.',3.50,270,2,'E','2015-11-18 15:32:40',1),(8,2,'Fresh Vegetable Salad','http://www.yellowdoorartmarket.com/.a/6a0134868a53d2970c01a3fca0f65b970b-800wi','Mixed Greens, Grilled Asparagus, Fresh Beets, Goat Cheese, Candied Pecans and Vinaigrette.',3.20,200,3,'E','2015-11-18 15:32:40',1),(9,2,'Tuna Salad','https://www.nuggetmarket.com/media/images/thai_tuna_salad_cabbage_wraps01.jpg','Fresh Ahi Lightly Seared and Served Rare with Avocado, Tomato and Mixed Greens. Tossed with Wasabi Vinaigrette.',3.80,350,4,'E','2015-11-18 15:32:40',1),(10,2,'Santa Fe Salad','https://herbamum.files.wordpress.com/2014/06/chilis-grill-bar-introduces-lighter-choices.jpg','Lime-Marinated Chicken, Fresh Corn, Black Beans, Cheese, Tortilla Strips, Tomato and Mixed Greens with a Spicy Peanut-Cilantro Vinaigrette.',3.60,290,5,'E','2015-11-18 15:32:40',1),(11,3,'Cheese cake','http://cache1.asset-cache.net/xc/494768709.jpg?v=2&c=IWSAsset&k=2&d=ey8z21AXG22BieIj6I_sVn2r7CVXNZw3aFbY09LlTH-XK6PbJ0H5ZOwCFL4LSgCj0','The One that Started it All! Our Famous Creamy Cheesecake with a Graham Cracker Crust and Sour Cream Topping.',5.00,450,1,'E','2015-11-18 15:36:54',1),(12,3,'Carrot cake','http://www.onehundreddollarsamonth.com/wp-content/uploads/2013/03/slice-of-carrot-cake.jpg?e3857c','Deliciously Moist Layers of Carrot Cake and Our Famous Cream Cheese Icing.',4.50,400,2,'E','2015-11-18 15:36:54',1),(13,3,'Tiramisu','http://assets.nydailynews.com/polopoly_fs/1.950758!/img/httpImage/image.jpg','talian Custard Made with Mascarpone, Whipped Cream, Lady Fingers, Marsala and Coffee Liqueur. Topped with Whipped Cream and Ground Chocolate.',3.50,390,3,'E','2015-11-18 15:36:54',1),(14,3,'Vanilla Ice cream','http://images.divinecaroline.mdpcdn.com/sites/divinecaroline.com/files/styles/story_detail_enlarge/public/600_story_the-scoop-the-best-vanilla-ice-cream-brand.jpg','Two and a half scoops of your choice of Vanilla, Coffee or Chocolate Ice Cream. With a dollop of whipped cream on top.',4.80,420,4,'E','2015-11-18 15:36:54',1),(15,3,'Creme brulee','http://www.afarmgirlsdabbles.com/wp-content/uploads/2012/02/600afd_X_IMG_3506_almond_vanilla_bean_creme_brulee1.jpg','Caramel Cheesecake and Creamy Caramel Mousse on a Blonde Brownie all topped with Salted Caramel.',3.60,420,5,'E','2015-11-18 15:36:54',1),(16,4,'Coke','http://www.shopfromapound.co.uk/images/coca-cola-coca-cola-large-size-bottle-1-75l-p693-1263_medium.jpg','',2.00,300,1,'E','2015-11-18 15:39:42',1),(17,4,'Coffee','http://www.dunkindonuts.com/content/dunkindonuts/en/menu/beverages/hotbeverages/coffee/hot_coffee/_jcr_content/block/image.img.png/1429214448918.png','',2.50,360,2,'E','2015-11-18 15:39:42',1),(18,4,'Orange Juice','http://www.mcdonalds.com/content/dam/McDonalds/item/mcdonalds-Minute-Maid-Orange-Juice-Small.png','',2.50,200,3,'E','2015-11-18 15:39:42',1),(19,4,'Lemonade','http://www.mcdonalds.com/content/dam/McDonalds/item/h-mcdonalds-Iced-Strawberry-Lemonade-Small.png','',2.20,180,4,'E','2015-11-18 15:39:42',1),(20,4,'Bottled Water','http://i5.walmartimages.com/dfw/dce07b8c-6766/k2-_df5b1993-7513-487f-a29a-2f8e46fbeca7.v1.jpg','',1.50,0,5,'D','2015-11-18 15:39:42',1);
/*!40000 ALTER TABLE `menuitems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orderlines`
--

DROP TABLE IF EXISTS `orderlines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orderlines` (
  `orderLineID` int(11) NOT NULL AUTO_INCREMENT,
  `orderID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  `unitPrice` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`orderLineID`),
  KEY `orderID` (`orderID`),
  KEY `itemID` (`itemID`),
  CONSTRAINT `orderlines_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`),
  CONSTRAINT `orderlines_ibfk_2` FOREIGN KEY (`itemID`) REFERENCES `menuitems` (`itemID`)
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orderlines`
--

LOCK TABLES `orderlines` WRITE;
/*!40000 ALTER TABLE `orderlines` DISABLE KEYS */;
INSERT INTO `orderlines` VALUES (1,1,2,7.00,3,1),(2,1,8,3.20,3,1),(3,1,15,3.60,2,1),(4,1,20,1.50,2,1),(5,2,1,7.50,3,1),(6,2,6,4.00,3,1),(7,2,11,5.00,3,1),(8,2,16,2.00,3,1),(9,3,1,7.50,1,1),(10,3,8,3.20,1,1),(11,3,14,4.80,1,1),(12,3,18,2.50,1,1),(13,4,1,7.50,1,1),(14,4,6,4.00,1,1),(15,4,12,4.50,1,1),(16,4,18,2.50,1,1),(17,5,1,7.50,1,1),(18,5,6,4.00,1,1),(19,5,15,3.60,1,1),(20,5,19,2.20,1,1),(21,6,4,8.00,1,1),(22,6,9,3.80,1,1),(23,6,14,4.80,1,1),(24,6,20,1.50,1,1),(25,7,1,7.50,1,1),(26,7,6,4.00,1,1),(27,7,12,4.50,1,1),(28,7,18,2.50,1,1),(29,8,5,5.80,1,1),(30,8,8,3.20,1,1),(31,8,15,3.60,1,1),(32,8,19,2.20,1,1),(33,9,4,8.00,1,1),(34,9,10,3.60,1,1),(35,9,15,3.60,1,1),(36,9,20,1.50,1,1),(37,10,4,8.00,1,1),(38,10,6,4.00,1,1),(39,10,12,4.50,1,1),(40,10,20,1.50,1,1),(41,11,2,7.00,1,1),(42,11,8,3.20,1,1),(43,11,11,5.00,1,1),(44,11,18,2.50,1,1),(45,12,5,5.80,1,1),(46,12,6,4.00,1,1),(47,12,15,3.60,1,1),(48,12,18,2.50,1,1),(49,13,3,7.20,1,1),(50,13,7,3.50,1,1),(51,13,11,5.00,1,1),(52,13,19,2.20,1,1),(53,14,5,5.80,1,1),(54,14,10,3.60,1,1),(55,14,12,4.50,1,1),(56,14,20,1.50,1,1),(57,15,3,7.20,1,1),(58,15,7,3.50,1,1),(59,15,12,4.50,1,1),(60,15,17,2.50,1,1),(61,16,2,7.00,1,1),(62,16,9,3.80,1,1),(63,16,12,4.50,1,1),(64,16,18,2.50,1,1),(65,17,4,8.00,1,1),(66,17,10,3.60,1,1),(67,17,13,3.50,1,1),(68,17,20,1.50,1,1),(69,18,5,5.80,1,1),(70,18,8,3.20,1,1),(71,18,14,4.80,1,1),(72,18,17,2.50,1,1),(73,19,2,7.00,1,1),(74,19,10,3.60,1,1),(75,19,13,3.50,1,1),(76,19,19,2.20,1,1),(77,20,2,7.00,1,1),(78,20,10,3.60,1,1),(79,20,14,4.80,1,1),(80,20,16,2.00,1,1),(81,21,3,7.20,1,1),(82,21,7,3.50,1,1),(83,21,11,5.00,1,1),(84,21,20,1.50,1,1),(85,22,5,5.80,1,1),(86,22,10,3.60,1,1),(87,22,12,4.50,1,1),(88,22,17,2.50,1,1),(89,23,2,7.00,1,1),(90,23,6,4.00,1,1),(91,23,15,3.60,1,1),(92,23,18,2.50,1,1),(93,24,3,7.20,1,1),(94,24,8,3.20,1,1),(95,24,13,3.50,1,1),(96,24,18,2.50,1,1),(97,25,2,7.00,1,1),(98,25,9,3.80,1,1),(99,25,15,3.60,1,1),(100,25,20,1.50,1,1),(101,26,5,5.80,1,1),(102,26,10,3.60,1,1),(103,26,14,4.80,1,1),(104,26,18,2.50,1,1),(105,27,4,8.00,1,1),(106,27,7,3.50,1,1),(107,27,12,4.50,1,1),(108,27,17,2.50,1,1),(109,28,3,7.20,1,1),(110,28,6,4.00,1,1),(111,28,11,5.00,1,1),(112,28,18,2.50,1,1),(113,29,5,5.80,1,1),(114,29,8,3.20,1,1),(115,29,11,5.00,1,1),(116,29,16,2.00,1,1),(117,30,4,8.00,1,1),(118,30,7,3.50,1,1),(119,30,15,3.60,1,1),(120,30,17,2.50,1,1),(121,31,4,8.00,1,1),(122,31,10,3.60,1,1),(123,31,17,2.50,1,1),(124,32,3,7.20,1,1),(125,32,6,4.00,1,1),(126,32,20,1.50,1,1),(127,33,3,7.20,1,1),(128,33,8,3.20,1,1),(129,33,19,2.20,1,1),(130,34,3,7.20,1,1),(131,34,10,3.60,1,1),(132,34,20,1.50,1,1),(133,35,5,5.80,1,1),(134,35,10,3.60,1,1),(135,35,20,1.50,1,1),(136,36,2,7.00,1,1),(137,36,7,3.50,1,1),(138,36,19,2.20,1,1),(139,37,1,7.50,1,1),(140,37,10,3.60,1,1),(141,37,19,2.20,1,1),(142,38,5,5.80,1,1),(143,38,9,3.80,1,1),(144,38,17,2.50,1,1),(145,39,1,7.50,1,1),(146,39,10,3.60,1,1),(147,39,18,2.50,1,1),(148,40,5,5.80,1,1),(149,40,7,3.50,1,1),(150,40,16,2.00,1,1),(151,41,2,7.00,1,1),(152,41,8,3.20,1,1),(153,41,20,1.50,1,1),(154,42,1,7.50,1,1),(155,42,10,3.60,1,1),(156,42,16,2.00,1,1),(157,43,4,8.00,1,1),(158,43,7,3.50,1,1),(159,43,19,2.20,1,1),(160,44,1,7.50,1,1),(161,44,8,3.20,1,1),(162,44,17,2.50,1,1);
/*!40000 ALTER TABLE `orderlines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `orderID` int(11) NOT NULL AUTO_INCREMENT,
  `customerID` int(11) NOT NULL,
  `locationID` int(11) NOT NULL,
  `orderDateTime` datetime NOT NULL,
  `pickupType` char(1) NOT NULL,
  `fulfillmentDateTime` datetime NOT NULL,
  `orderComment` text NOT NULL,
  `shippingStreet` varchar(60) DEFAULT NULL,
  `shippingCity` varchar(40) DEFAULT NULL,
  `shippingState` varchar(2) DEFAULT NULL,
  `shippingZipCode` varchar(10) DEFAULT NULL,
  `status` char(1) NOT NULL,
  `created` datetime NOT NULL,
  `referBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`orderID`),
  KEY `orderDateTime` (`orderDateTime`),
  KEY `pickupType` (`pickupType`),
  KEY `shippingCity` (`shippingCity`),
  KEY `shippingState` (`shippingState`),
  KEY `shippingZipCode` (`shippingZipCode`),
  KEY `status` (`status`),
  KEY `customerID` (`customerID`),
  KEY `locationID` (`locationID`),
  KEY `referBy` (`referBy`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `customers` (`customerID`),
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`locationID`) REFERENCES `locations` (`locationID`),
  CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`referBy`) REFERENCES `users` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,1,2,'2015-11-17 16:49:00','P','2015-11-17 17:50:00','','','','','','E','2015-11-18 16:49:00',6),(2,9,2,'2015-11-17 16:49:00','P','2015-11-17 17:51:00','','','','','','E','2015-11-18 16:49:00',6),(3,10,1,'2015-11-17 16:49:00','P','2015-11-17 17:52:00','','','','','','E','2015-11-18 16:49:00',3),(4,11,2,'2015-11-17 16:49:00','P','2015-11-17 17:53:00','','','','','','E','2015-11-18 16:49:00',6),(5,12,1,'2015-11-17 16:49:00','P','2015-11-17 17:54:00','','','','','','E','2015-11-18 16:49:00',3),(6,13,2,'2015-11-17 16:49:00','P','2015-11-17 17:55:00','','','','','','E','2015-11-18 16:49:00',6),(7,14,1,'2015-11-17 16:49:00','P','2015-11-17 17:56:00','','','','','','E','2015-11-18 16:49:00',3),(8,15,2,'2015-11-17 16:49:00','D','2015-11-17 17:57:00','','128 Bransten Rd','New York','NY','10011','E','2015-11-18 16:49:00',6),(9,16,1,'2015-11-17 16:49:00','D','2015-11-17 17:58:00','','775 W 17th St','San Antonio','TX','78204','E','2015-11-18 16:49:00',3),(10,17,2,'2015-11-17 16:49:00','D','2015-11-17 17:59:00','','678 3rd Ave','Miami','FL','33196','E','2015-11-18 16:49:00',6),(11,18,1,'2015-11-17 16:49:00','D','2015-11-17 18:00:00','','38938 Park Blvd','Boston','MA','2128','E','2015-11-18 16:49:00',3),(12,19,2,'2015-11-17 16:49:00','D','2015-11-17 18:01:00','','4486 W O St #1','New York','NY','10003','E','2015-11-18 16:49:00',6),(13,20,1,'2015-11-17 16:49:00','D','2015-11-17 18:02:00','','3305 Nabell Ave #679','New York','NY','10009','E','2015-11-18 16:49:00',3),(14,21,2,'2015-11-17 16:49:00','D','2015-11-17 18:03:00','','701 S Harrison Rd','San Francisco','CA','94104','E','2015-11-18 16:49:00',6),(15,22,1,'2015-11-17 16:49:00','D','2015-11-17 18:04:00','','32860 Sierra Rd','Miami','FL','33133','E','2015-11-18 16:49:00',3),(16,23,2,'2015-11-17 16:49:00','D','2015-11-17 18:05:00','','9 N College Ave #3','Milwaukee','WI','53216','E','2015-11-18 16:49:00',6),(17,24,1,'2015-11-17 16:49:00','D','2015-11-17 18:06:00','','8 Industry Ln','New York','NY','10002','E','2015-11-18 16:49:00',3),(18,25,2,'2015-11-17 16:49:00','D','2015-11-17 18:07:00','','229 N Forty Driv','New York','NY','10011','E','2015-11-18 16:49:00',6),(19,26,1,'2015-11-17 16:49:00','D','2015-11-17 18:08:00','','6 Middlegate Rd #106','San Francisco','CA','94107','E','2015-11-18 16:49:00',3),(20,27,2,'2015-11-17 16:49:00','D','2015-11-17 18:09:00','','25346 New Rd','New York','NY','10016','E','2015-11-18 16:49:00',6),(21,28,1,'2015-11-17 16:49:00','D','2015-11-17 18:10:00','','42744 Hamann Industrial Pky #82','Miami','FL','33136','E','2015-11-18 16:49:00',3),(22,29,2,'2015-11-17 16:49:00','D','2015-11-17 18:11:00','','3882 W Congress St #799','Los Angeles','CA','90016','E','2015-11-18 16:49:00',6),(23,1,2,'2015-11-18 16:59:12','P','2015-11-18 17:22:52','','','','','','E','2015-11-18 16:55:33',7),(24,9,2,'2015-11-18 16:59:12','P','2015-11-18 17:23:52','','','','','','E','2015-11-18 16:55:33',7),(25,10,1,'2015-11-18 16:59:12','P','2015-11-18 17:24:52','','','','','','E','2015-11-18 16:55:33',4),(26,11,2,'2015-11-18 16:59:12','P','2015-11-18 17:25:52','','','','','','E','2015-11-18 16:55:33',7),(27,12,1,'2015-11-18 16:59:12','P','2015-11-18 17:26:52','','','','','','E','2015-11-18 16:55:33',4),(28,13,2,'2015-11-18 16:59:12','P','2015-11-18 17:27:52','','','','','','E','2015-11-18 16:55:33',7),(29,14,1,'2015-11-18 16:59:12','P','2015-11-18 17:28:52','','','','','','E','2015-11-18 16:55:33',4),(30,15,2,'2015-11-18 16:59:12','D','2015-11-18 17:29:52','','128 Bransten Rd','New York','NY','10011','E','2015-11-18 16:55:33',7),(31,16,1,'2015-11-18 16:59:12','D','2015-11-18 17:10:52','','775 W 17th St','San Antonio','TX','78204','E','2015-11-18 16:55:33',4),(32,17,2,'2015-11-18 16:59:12','D','2015-11-18 17:11:52','','678 3rd Ave','Miami','FL','33196','E','2015-11-18 16:55:33',7),(33,18,1,'2015-11-18 16:59:12','D','2015-11-18 17:12:52','','38938 Park Blvd','Boston','MA','2128','E','2015-11-18 16:55:33',4),(34,19,2,'2015-11-18 16:59:12','D','2015-11-18 17:13:52','','4486 W O St #1','New York','NY','10003','E','2015-11-18 16:55:33',7),(35,20,1,'2015-11-18 16:59:12','D','2015-11-18 17:14:52','','3305 Nabell Ave #679','New York','NY','10009','E','2015-11-18 16:55:33',4),(36,21,2,'2015-11-18 16:59:12','D','2015-11-18 17:15:52','','701 S Harrison Rd','San Francisco','CA','94104','E','2015-11-18 16:55:33',7),(37,22,1,'2015-11-18 16:59:12','D','2015-11-18 17:16:52','','32860 Sierra Rd','Miami','FL','33133','E','2015-11-18 16:55:33',4),(38,23,2,'2015-11-18 16:59:12','D','2015-11-18 17:17:52','','9 N College Ave #3','Milwaukee','WI','53216','E','2015-11-18 16:55:33',7),(39,24,1,'2015-11-18 16:59:12','D','2015-11-18 17:18:52','','8 Industry Ln','New York','NY','10002','E','2015-11-18 16:55:33',4),(40,25,2,'2015-11-18 16:59:12','D','2015-11-18 17:19:52','','229 N Forty Driv','New York','NY','10011','E','2015-11-18 16:55:33',7),(41,26,1,'2015-11-18 16:59:12','D','2015-11-18 17:20:52','','6 Middlegate Rd #106','San Francisco','CA','94107','E','2015-11-18 16:55:33',4),(42,27,2,'2015-11-18 16:59:12','D','2015-11-18 17:21:52','','25346 New Rd','New York','NY','10016','E','2015-11-18 16:55:33',7),(43,28,1,'2015-11-18 16:59:12','D','2015-11-18 17:22:52','','42744 Hamann Industrial Pky #82','Miami','FL','33136','E','2015-11-18 16:55:33',4),(44,29,2,'2015-11-18 16:59:12','D','2015-11-18 17:23:52','','3882 W Congress St #799','Los Angeles','CA','90016','E','2015-11-18 16:55:33',7);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `paymentID` int(11) NOT NULL AUTO_INCREMENT,
  `orderID` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paymentDateTime` datetime NOT NULL,
  `cardTypeID` int(11) DEFAULT NULL,
  `cardNumber` char(16) DEFAULT NULL,
  `cardExpMonth` char(2) DEFAULT NULL,
  `cardExpYear` char(4) DEFAULT NULL,
  PRIMARY KEY (`paymentID`),
  KEY `cardNumber` (`cardNumber`),
  KEY `orderID` (`orderID`),
  KEY `cardTypeID` (`cardTypeID`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`),
  CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`cardTypeID`) REFERENCES `cardtypes` (`cardTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,1,15.30,'2015-11-17 16:49:00',1,'5370463888813020','01','2018'),(2,2,18.50,'2015-11-17 16:49:00',1,'5299156156891938','02','2018'),(3,3,18.00,'2015-11-17 16:49:00',1,'5293850200713058','03','2018'),(4,4,18.50,'2015-11-17 16:49:00',1,'5548024663365664','04','2018'),(5,5,17.30,'2015-11-17 16:49:00',1,'5218014427039266','05','2018'),(6,6,18.10,'2015-11-17 16:49:00',1,'5399070641280178','06','2018'),(7,7,18.50,'2015-11-17 16:49:00',1,'5144869127761108','07','2018'),(8,8,14.80,'2015-11-17 16:49:00',1,'5527124750467780','09','2018'),(9,9,16.70,'2015-11-17 16:49:00',1,'5180380736798221','10','2018'),(10,10,18.00,'2015-11-17 16:49:00',1,'5413442801450036','11','2018'),(11,11,17.70,'2015-11-17 16:49:00',2,'4929381332664295','01','2019'),(12,12,15.90,'2015-11-17 16:49:00',2,'4916481158148111','02','2019'),(13,13,17.90,'2015-11-17 16:49:00',2,'4916403492698783','03','2019'),(14,14,15.40,'2015-11-17 16:49:00',2,'4539538574255825','04','2019'),(15,15,17.70,'2015-11-17 16:49:00',2,'4916976652406147','05','2019'),(16,16,17.80,'2015-11-17 16:49:00',2,'4556007212947415','07','2019'),(17,17,16.60,'2015-11-17 16:49:00',2,'4532422069229909','07','2019'),(18,18,16.30,'2015-11-17 16:49:00',2,'4916673475725015','08','2019'),(19,19,16.30,'2015-11-17 16:49:00',2,'4539003137030728','09','2019'),(20,20,17.40,'2015-11-17 16:49:00',3,'378282246310005','01','2016'),(21,21,17.20,'2015-11-17 16:49:00',3,'371449635398431','02','2017'),(22,22,16.40,'2015-11-17 16:49:00',3,'378282246310005','04','2018'),(23,23,17.10,'2015-11-18 16:59:12',1,'5370463888813020','01','2018'),(24,24,16.40,'2015-11-18 16:59:12',1,'5299156156891938','02','2018'),(25,25,15.90,'2015-11-18 16:59:12',1,'5293850200713058','03','2018'),(26,26,16.70,'2015-11-18 16:59:12',1,'5548024663365664','04','2018'),(27,27,18.50,'2015-11-18 16:59:12',1,'5218014427039266','05','2018'),(28,28,18.70,'2015-11-18 16:59:12',1,'5399070641280178','06','2018'),(29,29,16.00,'2015-11-18 16:59:12',1,'5144869127761108','07','2018'),(30,30,17.60,'2015-11-18 16:59:12',1,'5527124750467780','09','2018'),(31,31,14.10,'2015-11-18 16:59:12',1,'5180380736798221','10','2018'),(32,32,12.70,'2015-11-18 16:59:12',1,'5413442801450036','11','2018'),(33,33,12.60,'2015-11-18 16:59:12',2,'4929381332664295','01','2019'),(34,34,12.30,'2015-11-18 16:59:12',2,'4916481158148111','02','2019'),(35,35,10.90,'2015-11-18 16:59:12',2,'4916403492698783','03','2019'),(36,36,12.70,'2015-11-18 16:59:12',2,'4539538574255825','04','2019'),(37,37,13.30,'2015-11-18 16:59:12',2,'4916976652406147','05','2019'),(38,38,12.10,'2015-11-18 16:59:12',2,'4556007212947415','07','2019'),(39,39,13.60,'2015-11-18 16:59:12',2,'4532422069229909','07','2019'),(40,40,11.30,'2015-11-18 16:59:12',2,'4916673475725015','08','2019'),(41,41,11.70,'2015-11-18 16:59:12',2,'4539003137030728','09','2019'),(42,42,13.10,'2015-11-18 16:59:12',3,'378282246310005','01','2016'),(43,43,13.70,'2015-11-18 16:59:12',3,'371449635398431','02','2017'),(44,44,13.20,'2015-11-18 16:59:12',3,'378282246310005','04','2018');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstName` varchar(60) NOT NULL,
  `lastName` varchar(60) NOT NULL,
  `street` varchar(60) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `zipCode` varchar(10) DEFAULT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `status` char(1) NOT NULL,
  `eFlag` tinyint(1) NOT NULL,
  `cFlag` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`userID`),
  KEY `userName` (`userName`),
  KEY `city` (`city`),
  KEY `state` (`state`),
  KEY `zipCode` (`zipCode`),
  KEY `phone` (`phone`),
  KEY `status` (`status`),
  KEY `eFlag` (`eFlag`),
  KEY `cFlag` (`cFlag`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Byambaa','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Byambatsog','Chimed','1246 W PRATT BLVD','Chicago','IL','60626','byambatsog@gmail.com','773-595-5660','E',1,1,'2015-11-17 22:42:47'),(2,'James','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','James','Butt','6649 N Blue Gum St','New Orleans','LA','70116','jbutt@gmail.com','504-621-8927','E',1,0,'2015-11-17 22:42:47'),(3,'Josephine','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Josephine','Darakjy','4 B Blue Ridge Blvd','Brighton','MI','48116','josephine_darakjy@darakjy.org','810-292-9388','E',1,0,'2015-11-17 22:42:47'),(4,'Mitsue','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Mitsue','Tollner','7 Eads St','Chicago','IL','60632','mitsue_tollner@yahoo.com','773-573-6914','E',1,0,'2015-11-17 22:42:47'),(5,'Gladys','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Gladys','Rim','322 New Horizon Blvd','Milwaukee','WI','53207','gladys.rim@rim.org','414-661-9598','E',1,0,'2015-11-17 22:42:47'),(6,'Viva','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Viva','Toelkes','4284 Dorigo Ln','Chicago','IL','60647','viva.toelkes@gmail.com','773-446-5569','E',1,0,'2015-11-17 22:42:47'),(7,'Marti','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Marti','Maybury','4 Warehouse Point Rd #7','Chicago','IL','60638','marti.maybury@yahoo.com','773-775-4522','E',1,0,'2015-11-17 22:42:47'),(8,'Valentin','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Valentin','Klimek','137 Pioneer Way','Chicago','IL','60604','vklimek@klimek.org','312-303-5453','E',1,0,'2015-11-17 22:42:47'),(9,'Carmela','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Carmela','Cookey','9 Murfreesboro Rd','Chicago','IL','60623','ccookey@cookey.org','773-494-4195','E',0,1,'2015-11-17 22:54:24'),(10,'Erick','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Erick','Nievas','45 E Acacia Ct','Chicago','IL','60624','erick_nievas@aol.com','773-704-9903','E',0,1,'2015-11-17 22:54:24'),(11,'Nichelle','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Nichelle','Meteer','72 Beechwood Ter','Chicago','IL','60657','nichelle_meteer@meteer.com','773-225-9985','E',0,1,'2015-11-17 22:54:24'),(12,'Kiley','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Kiley','Caldarera','25 E 75th St #69','Los Angeles','CA','90034','kiley.caldarera@aol.com','310-498-5651','E',0,1,'2015-11-17 22:54:24'),(13,'Willow','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Willow','Kusko','90991 Thorburn Ave','New York','NY','10011','wkusko@yahoo.com','212-582-4976','E',0,1,'2015-11-17 22:54:24'),(14,'Alishia','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Alishia','Sergi','2742 Distribution Way','New York','NY','10025','asergi@gmail.com','212-860-1579','E',0,1,'2015-11-17 22:54:24'),(15,'Jose','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Jose','Stockham','128 Bransten Rd','New York','NY','10011','jose@yahoo.com','212-675-8570','E',0,1,'2015-11-17 22:54:24'),(16,'Valentine','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Valentine','Gillian','775 W 17th St','San Antonio','TX','78204','valentine_gillian@gmail.com','210-812-9597','E',0,1,'2015-11-17 22:54:24'),(17,'Lavera','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Lavera','Perin','678 3rd Ave','Miami','FL','33196','lperin@perin.org','305-606-7291','E',0,1,'2015-11-17 22:54:24'),(18,'Jina','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Jina','Briddick','38938 Park Blvd','Boston','MA','2128','jina_briddick@briddick.com','617-399-5124','E',0,1,'2015-11-17 22:54:24'),(19,'Brock','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Brock','Bolognia','4486 W O St #1','New York','NY','10003','bbolognia@yahoo.com','212-402-9216','E',0,1,'2015-11-17 23:05:01'),(20,'Tawna','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Tawna','Buvens','3305 Nabell Ave #679','New York','NY','10009','tawna@gmail.com','212-674-9610','E',0,1,'2015-11-17 23:05:01'),(21,'Kallie','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Kallie','Blackwood','701 S Harrison Rd','San Francisco','CA','94104','kallie.blackwood@gmail.com','415-315-2761','E',0,1,'2015-11-17 23:05:01'),(22,'Tiffiny','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Tiffiny','Steffensmeier','32860 Sierra Rd','Miami','FL','33133','tiffiny_steffensmeier@cox.net','305-385-9695','E',0,1,'2015-11-17 23:05:01'),(23,'Daren','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Daren','Weirather','9 N College Ave #3','Milwaukee','WI','53216','dweirather@aol.com','414-959-2540','E',0,1,'2015-11-17 23:05:01'),(24,'Ozell','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Ozell','Shealy','8 Industry Ln','New York','NY','10002','oshealy@hotmail.com','212-332-8435','E',0,1,'2015-11-17 23:05:01'),(25,'Layla','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Layla','Springe','229 N Forty Driv','New York','NY','10011','layla.springe@cox.net','212-260-3151','E',0,1,'2015-11-17 23:05:01'),(26,'Norah','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Norah','Waymire','6 Middlegate Rd #106','San Francisco','CA','94107','norah.waymire@gmail.com','415-306-7897','E',0,1,'2015-11-17 23:05:01'),(27,'Haydee','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Haydee','Denooyer','25346 New Rd','New York','NY','10016','hdenooyer@denooyer.org','212-792-8658','E',0,1,'2015-11-17 23:05:01'),(28,'Theodora','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Theodora','Restrepo','42744 Hamann Industrial Pky #82','Miami','FL','33136','theodora.restrepo@restrepo.com','305-936-8226','E',0,1,'2015-11-17 23:05:01'),(29,'Filiberto','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Filiberto','Tawil','3882 W Congress St #799','Los Angeles','CA','90016','ftawil@hotmail.com','323-765-2528','E',0,1,'2015-11-17 23:05:01'),(30,'Blair','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Blair','Malet','209 Decker Dr','Philadelphia','PA','19132','bmalet@yahoo.com','215-907-9111','E',0,1,'2015-11-19 15:05:30'),(31,'Tyra','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Tyra','Shields','3 Fort Worth Ave','Philadelphia','PA','19106','tshields@gmail.com','215-255-1641','E',0,1,'2015-11-19 15:05:30'),(32,'Dierdre','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Dierdre','Yum','63381 Jenks Ave','Philadelphia','PA','19134','dyum@yahoo.com','215-325-3042','E',0,1,'2015-11-19 15:05:30'),(33,'Evangelina','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Evangelina','Radde','992 Civic Center Dr','Philadelphia','PA','19123','evangelina@aol.com','215-964-3284','E',0,1,'2015-11-19 15:05:30'),(34,'Ronny','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Ronny','Caiafa','73 Southern Blvd','Philadelphia','PA','19103','ronny.caiafa@caiafa.org','215-605-7570','E',0,1,'2015-11-19 15:05:30'),(35,'Franklyn','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Franklyn','Emard','4379 Highway 116','Philadelphia','PA','19103','femard@emard.com','215-558-8189','E',0,1,'2015-11-19 15:05:30'),(36,'Vincent','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Vincent','Meinerding','4441 Point Term Mkt','Philadelphia','PA','19143','vincent.meinerding@hotmail.com','215-372-1718','E',0,1,'2015-11-19 15:05:30'),(37,'Dalene','$2y$10$yNg2urQ5R74LmkGKO3hcNu.XtAvU7l7MqWJScpzrAz1xUC6OCXRWO','Dalene','Schoeneck','910 Rahway Ave','Philadelphia','PA','19102','dalene@schoeneck.org','215-268-1275','E',0,1,'2015-11-19 15:05:30');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-11-25 14:49:38
