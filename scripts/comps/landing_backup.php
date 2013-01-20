<div class="box-content"><!-- remove rounded-bottom -->
    <div class="inner-box-content-wrapper"><!-- remove rounded-bottom -->
        <div class="inner-box-content"><!-- remove rounded-bottom -->
            <?php /* <div class="slider-desc"><?php echo $p[0]->landing->firstSliderLine?></div>
            <div class="slider-desc"><?php echo $p[0]->landing->secondSliderLine?></div> */ ?>
			<div id="slider-blue-content">
				<div id="slider-info-text">
					<p>You get  $20 gift card and your friends get 05% off coupon</p>
				</div>
				<div class="slider-description">
					<span>Move the slider to play</span>
				</div>
				<div class="slider-wrapper">
					<div class="icons_wrapper clearfix">
						<div class="cat_icon"></div>
						<div class="bee_icon"></div>
					</div>
					<div id="slider"></div>
					<div id="sliderUnits" class="clearfix">
						<div class="unit"></div>
						<?php
						for ($divNo = 1; $divNo < count($p[0]->landing->landingRewards) - 1; $divNo++ )
						{
							$left = round($divNo / (count($p[0]->landing->landingRewards) - 1) * 100);
						?>
							<div class="unit" style="left: <?php echo $left?>%;"></div>

						<?php
						}
						?>
						<div class="unit pos_right"></div>
					</div>
				</div>

				<div class="gifts">
					<div id="leaderArea"><label id="LeaderRewardPhrase"
								for="LeaderReward"><?php echo $p[0]->landing->landingRewards[0]->leaderReward->description?></label>
						<input id="LeaderReward" readonly="readonly"/>
					  <?php echo $p[0]->landing->landingRewards[0]->leaderReward->typeDescription?>
					</div>

					<div id="friendArea"><label id="FriendRewardPhrase"
								for="FriendReward"><?php echo $p[0]->landing->landingRewards[0]->friendReward->description?></label>
						<input id="FriendReward" readonly="readonly"/>
						<?php echo $p[0]->landing->landingRewards[0]->friendReward->typeDescription?>
					</div>

				</div>
           
			</div><!-- slider-blue-content -->
		   <?php /* <div class="gift-desc">
            </div> */ ?>
