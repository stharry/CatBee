<?php

class deal {  
    public $id;  
    public $leader;
	public $landing;
    public $landingFriend;
	public $initDate;
	
	

    public function __construct($id,$leader,$landing,$landingFriend,$initDate)
    {  
        $this->id = $id;
        $this->leader = $leader;
        $this->landing = $landing;
        $this->landingFriend = $landingFriend;
        $this->initDate = $initDate;

    }
    function GetDeal($code)
    {
        $query = sprintf("select id,landing,leader,landingFriend,initDate from deal
		where name='%s'",mysql_real_escape_string($code));
        $result = mysql_query($query);
        if (mysql_num_rows($result)==0)
            return null;
        $row = mysql_fetch_assoc($result);
        return new deal($row['id'],$row['landing'],$row['leader'],$row['landingFriend'],$row['initDate']);
    }
} 
?>