<div id="header-section" class="zContainer">
	<img src="/CatBee/public/res/images/friendDeal/logo.jpg" alt="Glasses Market" />
</div>

<div id="product-photo-coupon" class="zContainer">
	<div id="product-photo" class="fl">
		<img src="/CatBee/public/res/images/friendDeal/product-glasses.jpg" alt="Product glasses" />
	</div>
	<div id="coupon-text" class="fl">
		<p id="reward-info">Here is your special friend-only gift,<br/> created by <span><?php echo $p[0]->friend->firstName?> <?php echo $p[0]->friend->lastName?></span></p>
		<h4 id="reward-content">Get <span>$<?php echo $p[0]->share->reward->friendReward->value?></span> off your order with this coupon:</h4>
		<div id="coupon-content">
			<span><?php echo $p[0]->share->reward->friendReward->code?></span>
		</div>
	</div>
</div>

<div id="date-expires" class="zContainer">
	<p><span></span></p>
</div>

<div id="start-shopping" class="zContainer">
	<div id="blueLinkLeft" class="fl"></div>
	<div id="blueLinkMiddle" class="fl">
		<a href="#" id="go-btn">Start Shopping - <span>Enjoy Your Reward &gt;&gt;</span></a>
	</div>
	<div id="blueLinkRight" class="fl"></div>
</div>

<div id="footer-section" class="zContainer">
	<div id="footer-left" class="fl footer-box">
		<h5>How Does This Deal Work?</h5>
		<p>Copy the coupon code <?php echo $p[0]->share->reward->friendReward->code?> and place it on the shopping cart page for your instant discount</p>
	</div>
	<div id="footer-right" class="fl footer-box last">
		<h5>Have a Question?</h5>
		<p>We're here to help, contact with any question that you may have: <a class="support-email" href="mailto:<?php echo $p[0]->order->branch->email?>"><?php echo $p[0]->order->branch->email?><a></p>
	</div>
</div>
<?php /* <div class="deal-text">
    <?php echo $p[0]->friend->firstName?> <?php echo $p[0]->landing->friendMessage?><br />
    <p>Get <?php echo $p[0]->share->reward->friendReward->value?>% <?php echo $p[0]->landing->slogan?> <?php echo $p[1]->shopName?></p>
    <?php echo $p[0]->landing->rewardMessage1?><?php echo $p[0]->share->reward->friendReward->code?><br />
    <?php echo $p[0]->landing->rewardMessage2?><br />
    <div class="clearfix"><a href="#" class="go-btn">Go</a></div>
</div> */ ?>