<?php
class PdoImpression
{
    public function InsertImpression($impression)
    {
        $names = array( "ActiveShareID", 'TimeStamp');

        $values = array(
            $impression->share,
            $impression->timeStamp);

        DbManager::insertOnly("impression", $names, $values);

    }

}
