<?php

class sliderPhrase {  
    public $firstLine;  
    public $secondLine; 

    public function __construct($firstLine, $secondLine)  
    {  
        $this->firstLine = $firstLine;  
        $this->secondLine = $secondLine; 
    }  
     function getSliderPhrase($store)
	{
	$query = sprintf("select sp.id,firstLine,secondLine from store st
		inner join sliderphrase sp on st.sliderPhrase=sp.id
		where StoreName='%s'",mysql_real_escape_string($store));
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return new sliderPhrase($row['firstLine'],$row['secondLine']);
	}
} 
?>
