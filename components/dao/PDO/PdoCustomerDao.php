<?php

include_once("../ICustomerDao.php");
include_once("DbManager.php");

class PdoCustomerDao implements ICustomerDao
{

    public function IsCustomerExists($customer)
    {
        $conn = DbManager::getConnection();
        $stmt = $conn->prepare("SELECT id FROM customer WHERE email=?");
        $stmt->bindValue(1, $customer->email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            echo "Customer does not exists";
            return false;
        }
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $customer->id = $rows[0][0];

        return true;
    }

    public function InsertCustomer($customer)
    {
        try {

            $sql = "INSERT INTO customer  (email,firstName, lastName) VALUES (:email,:firstName,:lastName)";
            $conn = DbManager::getConnection();

            var_dump($conn);

            $q = $conn->prepare($sql);
            $b = $q->execute(array(':email' => $customer->email,
                ':firstName' => $customer->firstName,
                ':lastName' => $customer->lastName));

            echo "After insert as ".$b."</p>";

            $customer->id = $conn->lastInsertId("id");

            echo "After insert id= " . $customer->id;
        } catch (PDOException $pe) {
            echo $pe->getMessage();
        }

    }

    public function UpdateCustomer($customer)
    {
        // TODO: Implement UpdateCustomer() method.
    }
}
