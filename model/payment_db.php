<?php
function add_payment($payment) {
    global $db;
    $query = 'INSERT INTO payments
                 (orderID, amount, paymentDateTime, cardTypeID, cardNumber, cardExpMonth, cardExpYear)
              VALUES
                 (:orderID, :amount, sysdate(), :cardTypeID, :cardNumber, :cardExpMonth, :cardExpYear)';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':orderID', $payment['orderID']);
        $statement->bindValue(':amount', $payment['amount']);
        $statement->bindValue(':cardTypeID', $payment['cardTypeID']);
        $statement->bindValue(':cardNumber', $payment['cardNumber']);
        $statement->bindValue(':cardExpMonth', $payment['cardExpMonth']);
        $statement->bindValue(':cardExpYear', $payment['cardExpYear']);
        $statement->execute();
        $statement->closeCursor();

        // Get the last product ID that was automatically generated
        $payment_id = $db->lastInsertId();
        return $payment_id;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

?>