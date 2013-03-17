<?php

class PdoTribeDao
{

    public function getTribe($tribeFilter)
    {
        RestLogger::log("PdoTribeDao::getTribe begin");

         try
         {
             $selectClause = " select TR.id as TribeID,TR.tribeName,Cu.email,Cu.firstName,Cu.lastName from tribes as TR inner join tribeCustomers as TC";
             $selectClause = $selectClause." on TR.id=TC.TribeId";
             $selectClause = $selectClause. " inner join customers Cu on TC.CustomerID=Cu.id";
             $selectClause = $selectClause." where TC.TribeId = ";
             $selectClause = $selectClause."(select TribeId from tribeCustomers inner join customers on tribeCustomers.CustomerID=customers.id where email='";
            $selectClause = $selectClause. $tribeFilter->customers->email;
             $selectClause = $selectClause."')";
             $rows = DbManager::selectValues($selectClause, null);
             $tribe = new Tribe();
             $tribe->TribeName = $rows[0]["tribeName"];
             $tribe->id = $rows[0]["TribeID"];
             foreach ($rows as $row)
             {
                $tribe->AddCustomerToTribe($this->AddCustomer($row));
             }
             return $tribe;

         }
         catch (Exception $e)
         {
             RestLogger::log("Exception: " . $e->getMessage());
             throw new Exception("", 0, $e);
         }

    }

    private function AddCustomer($row)
    {
        $customer = new Customer();
        $customer->id = $row["CustomerID"];
        $customer->email = $row["email"];
        $customer->firstName = $row["firstName"];
        $customer->lastName = $row["lastName"];
        return $customer;
    }

}
