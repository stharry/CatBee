<?php
class landingFriend {
    public $id;
    public $refSlogan;
    public $reward;
    public $rewardSlogan;

    public function __construct($id,$refSlogan,$reward,$rewardSlogan)
    {
        $this->id = $id;
        $this->refSlogan= $refSlogan;
        $this->reward = $reward;
        $this->rewardSlogan = $rewardSlogan;
    }
    function GetlandingFriend($id)
    {
        return new landingFriend('1','Tomer','1','10');
    }
}
?>