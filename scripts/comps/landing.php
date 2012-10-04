<div id="landingPage">
    <div id="titleArea">
        <div id="firstLine">
            <?=$p->landing->firstSliderLine?>
        </div>
        <div id="secondLine">
            <?=$p->landing->secondSliderLine?>
        </div>
    </div>
    <div id="compainArea">
        <div class="icons_wrapper">
            <div class="cat_icon" id="cat_icon"></div>
            <div class="bee_icon" id="bee_icon"></div>
        </div>
        <div id="slider"></div>
        <label id="LeaderRewardPhrase" for="LeaderReward"><?=$p->landing->landingRewards[0]->leaderReward->description?></label>
        <input id="LeaderReward" style="display: none;"/>


        <p></p>
        <label id="FriendRewardPhrase" for="FriendReward"><?=$p->landing->landingRewards[0]->friendReward->description?></label>
        <input id="FriendReward" style="display: none;"/>
    </div>
</div>
