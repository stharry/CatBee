<?php
// include_once 'globals.php';
error_reporting(E_ERROR);

class slogan {  
    public $firstLine;  
    public $secondLine; 

    public function __construct($firstLine, $secondLine)  
    {
        $this->firstLine = $firstLine;  
        $this->secondLine = $secondLine; 
    }  
     function getSlogan($store)
	{
	$query = sprintf("select sg.id,firstLine,secondLine from store st
		inner join slogan sg on st.slogan=sg.id
		where StoreName='%s'",mysql_real_escape_string($store));
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return new slogan($row['firstLine'],$row['secondLine']);
	}
    
} 
?>
