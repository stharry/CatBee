<div id="sliderOptions" height=0 width=0 style="display: none;">10

<?php
$rewardsCount = count($p->landing->landingRewards);

echo "<div id=\"rewardsCount\">{$rewardsCount}</div>";

for ($rewardNo = 0; $rewardNo < $rewardsCount; $rewardNo++)
{
    echo "<div id=\"leaderRewardValue{$rewardNo}\">{$p->landing->landingRewards[$rewardNo]->leaderReward->value}</div>";
    echo "<div id=\"leaderRewardType{$rewardNo}\">{$p->landing->landingRewards[$rewardNo]->leaderReward->type}</div>";
    echo "<div id=\"leaderRewardCode{$rewardNo}\">{$p->landing->landingRewards[$rewardNo]->leaderReward->code}</div>";
    echo "<div id=\"leaderRewardDesc{$rewardNo}\">{$p->landing->landingRewards[$rewardNo]->leaderReward->description}</div>";

    echo "<div id=\"friendRewardValue{$rewardNo}\">{$p->landing->landingRewards[$rewardNo]->friendReward->value}</div>";
    echo "<div id=\"friendRewardType{$rewardNo}\">{$p->landing->landingRewards[$rewardNo]->friendReward->type}</div>";
    echo "<div id=\"friendRewardCode{$rewardNo}\">{$p->landing->landingRewards[$rewardNo]->friendReward->code}</div>";
    echo "<div id=\"friendRewardDesc{$rewardNo}\">{$p->landing->landingRewards[$rewardNo]->friendReward->description}</div>";
}
?>
</div>