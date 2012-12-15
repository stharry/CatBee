<div class="box-content rounded-bottom box-shadow">
    <div class="inner-box-content-wrapper rounded-bottom">
        <div class="inner-box-content rounded-bottom">
            <div class="slider-desc"><?=$p->landing->firstSliderLine?></div>
            <div class="slider-desc"><?=$p->landing->secondSliderLine?></div>

            <div class="slider-wrapper">
                <div class="icons_wrapper clearfix">
                    <div class="cat_icon"></div>
                    <div class="bee_icon"></div>
                </div>
                <div id="slider"></div>
                <div id="sliderUnits" class="clearfix">
                    <div class="unit"></div>
<!--                    <div class="unit pos_center"></div>-->
                    <div class="unit pos_right"></div>
                </div>
            </div>

            <div class="gifts">
                <div id="leaderArea"><label id="LeaderRewardPhrase"
                            for="LeaderReward"><?=$p->landing->landingRewards[0]->leaderReward->description?></label>
                    <input id="LeaderReward" readonly="readonly"/>
                  <?=$p->landing->landingRewards[0]->leaderReward->typeDescription?>
                </div>

                <div id="friendArea"><label id="FriendRewardPhrase"
                            for="FriendReward"><?=$p->landing->landingRewards[0]->friendReward->description?></label>
                    <input id="FriendReward" readonly="readonly"/>
                    <?=$p->landing->landingRewards[0]->friendReward->typeDescription?>
                </div>

            </div>
            <div class="gift-desc">
            </div>
