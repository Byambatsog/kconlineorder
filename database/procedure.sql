DELIMITER $$
DROP PROCEDURE IF EXISTS user_add$$
CREATE PROCEDURE user_add(
IN userName VARCHAR(60), IN password varchar(255), IN firstName VARCHAR(60), IN lastName VARCHAR(60),
IN emailAddress VARCHAR(255), IN status CHAR(1), IN eFlag TINYINT(1), IN cFlag TINYINT(1), OUT userID INT(11)
)
BEGIN
INSERT INTO users VALUES(
NULL, userName, password, firstName, lastName, NULL, NULL, NULL, NULL, emailAddress,
NULL, status, eFlag, cFlag, sysdate());
SELECT last_insert_id() INTO userID;
end$$

DROP PROCEDURE IF EXISTS customer_add$$
CREATE PROCEDURE customer_add(
IN customerID INT(11), IN billingStreet VARCHAR(60), IN billingCity VARCHAR(40), IN billingState VARCHAR(2),
IN billingZipCode VARCHAR(10), IN shippingStreet VARCHAR(60), IN shippingCity VARCHAR(40), IN shippingState VARCHAR(2),
IN shippingZipCode VARCHAR(10), IN cardTypeID INT(11), IN cardNumber CHAR(16), IN cardExpMonth CHAR(2), IN cardExpYear CHAR(4)
)
BEGIN
INSERT INTO customers VALUES(
customerID, billingStreet, billingCity, billingState, billingZipCode, shippingStreet, shippingCity, shippingState,
shippingZipCode, cardTypeID, cardNumber, cardExpMonth, cardExpYear, 0);
end$$