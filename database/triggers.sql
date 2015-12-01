DELIMITER $$
DROP trigger IF EXISTS triggerOrderLineUpdate$$
CREATE TRIGGER triggerOrderLineUpdate AFTER UPDATE ON orderlines
FOR EACH ROW
BEGIN
DECLARE totalItem INTEGER;
DECLARE readyItem INTEGER;
DECLARE notReadyItem INTEGER;
SELECT COUNT(*) INTO totalItem FROM orderlines WHERE orderID=NEW.orderID;
SELECT COUNT(*) INTO readyItem FROM orderlines WHERE orderID=NEW.orderID AND status=1;
SELECT COUNT(*) INTO notReadyItem FROM orderlines WHERE orderID=NEW.orderID AND status=0;
IF totalItem=readyItem THEN
  UPDATE orders SET status='R' WHERE orderID=NEW.orderID;
END IF;
IF totalItem=notReadyItem THEN
  UPDATE orders SET status='P' WHERE orderID=NEW.orderID;
END IF;
IF totalItem<>readyItem && totalItem<>notReadyItem THEN
  UPDATE orders SET status='S' WHERE orderID=NEW.orderID;
END IF;
END$$