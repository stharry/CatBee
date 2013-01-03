<?php

class ShareTarget
{
    private $shareTargets;

    function __construct($targetName = '')
    {
        $this->shareTargets = array(
            0 => 'friend',
            1 => 'leader',
            2 => 'friendbuy');

        foreach ($this->shareTargets as $id => $name)
        {
            if (strcmp(strtolower($name), strtolower($targetName)) == 0)
            {
                $this->id = $id;
                $this->name = $targetName;
                return;
            }
        }

        $this->name = $this->shareTargets[0];
        $this->id = 0;
    }

    public static $SHARE_TARGET_FRIEND = 'friend';
    public static $SHARE_TARGET_LEADER_ON_SHARE = 'leader';
    public static $SHARE_TARGET_LEADER_ON_FRIEND_BUY = 'friendbuy';

    public $name;
    public $id;
    public $from;
    public $to;
}
