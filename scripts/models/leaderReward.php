<?php

class leaderReward {  
    public $reward;  
    public $low; 
	public $med;
	public $high;
	public $value;

    public function __construct($reward, $low,$med,$high,$value)  
    {  
        $this->reward = $reward;  
        $this->low = $low; 
		$this->med = $med; 
		$this->high = $high; 
		$this->value = $value;
    }  
     function getleaderReward($store)
	{
	$query = sprintf("SELECT id,reward,low,med,high FROM leaderreward");
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return new leaderReward($row['reward'],$row['low'],$row['med'],$row['high']);
	}
} 
?>
