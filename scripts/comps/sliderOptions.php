<?php

    $leaderDealAdapter = new JsonLeaderDealAdapter();
    $catBeeData = json_encode($leaderDealAdapter->toArray($p));
?>

<div id="sliderOptions" height=0 width=0 style="display: none;">
    <div id="catBeeData"><?=$catBeeData?></div>
</div>