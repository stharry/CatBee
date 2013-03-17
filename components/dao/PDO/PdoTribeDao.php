<?php

class PdoTribeDao
{

    public function getTribe($tribeFilter)
    {
        RestLogger::log("PdoTribeDao::getTribe begin");

         try
         {
             $selectClause = " select TR.id as TribeID,TR.tribeName,Cu.email,Cu.firstName,Cu.lastName,SB.shopname,SB.id as storeid  from tribes as TR inner join tribeCustomers as TC";
             $selectClause = $selectClause." on TR.id=TC.TribeId";
             $selectClause = $selectClause. " inner join customers Cu on TC.CustomerID=Cu.id";
             $selectClause = $selectClause. " inner join tribeStores TS on TR.id=TS.TribeID inner join StoreBranch SB on TS.StoreID=SB.id";
             $selectClause = $selectClause." where TC.TribeId = ";
             $selectClause = $selectClause."(select TribeId from tribeCustomers inner join customers on tribeCustomers.CustomerID=customers.id where email='";
             $selectClause = $selectClause. $tribeFilter->customers->email;
             $selectClause = $selectClause."')";
              $selectClause = $selectClause." Order By SB.id";
             $rows = DbManager::selectValues($selectClause, null);
             $tribe = new Tribe();
             $tribe->TribeName = $rows[0]["tribeName"];
             $tribe->id = $rows[0]["TribeID"];
             $CurrentStoreID = 0;

             foreach ($rows as $row)
             {
                if($row["storeid"]!= $CurrentStoreID)
                {
                    $CurrentStoreID=$row["storeid"];
                    $tribe->AddActiveStoreToTribe($this->AddStore($row));
                }
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
    private function AddStore($row)
    {
        $store = new StoreBranch();
        $store->shopName = $row["shopname"];
        $store->id = $row["storeid"];
        return $store;
    }

}
