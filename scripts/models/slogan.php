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
     function getSlogan($camp)
	{
	$query = sprintf("select sg.id,firstLine,secondLine from landing la
		inner join slogan sg on la.slogan=sg.id
		where campaign='%s'",mysql_real_escape_string($camp));
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return new slogan($row['firstLine'],$row['secondLine']);
	}
} 
?>
