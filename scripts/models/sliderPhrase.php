<?php

class sliderPhrase {  
    public $firstLine;  
    public $secondLine; 

    public function __construct($firstLine, $secondLine)  
    {  
        $this->firstLine = $firstLine;  
        $this->secondLine = $secondLine; 
    }  
     function getSliderPhrase($camp)
	{
	$query = sprintf("select sp.id,firstLine,secondLine from landing la
		inner join sliderphrase sp on la.sliderPhrase=sp.id
		where campaign='%s'",mysql_real_escape_string($camp));
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return new sliderPhrase($row['firstLine'],$row['secondLine']);
	}
} 
?>
