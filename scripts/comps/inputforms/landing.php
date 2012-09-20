<form>
<div>
	<?=$p->firstLine?>
</div>
<div>
	<?=$p->secondLine?>
</div>
<div class="icons_wrapper">
	<div class="cat_icon"></div>
	<div class="bee_icon"></div>
</div>
<div id="slider"></div>
<label for="LeaderReward">You get</label><input type="text" value="10" id="LeaderReward"/></br>
<label for="FriendReward">Your friends get</label><input type="text" value="10" id="FriendReward"/>


    <div id="wrapper">
        <p><a class="mailmodalbox" id="mailToFriend" href="#mailInline">via e-mail</a></p>
    </div>

    <div id="mailInline">
        <h2>Send us a Message</h2>

        <form id="contact" name="contact" action="#" method="post">
            <label for="email">Your E-mail</label>
            <input type="email" id="email" name="email" class="txt">
            <br>
            <label for="msg">Enter a Message</label>
            <textarea id="msg" name="msg" class="txtarea"></textarea>
            <input type="hidden" name="leaderEmail" id="leaderEmail" value='<?php echo $leaderEmail; ?>' />
            <input type="hidden" name="storeName" id="storeName" value='<?php echo $storeName; ?>' />
            <input type="hidden" name="tribziId" id="tribziId" value='<?php echo $tribziId; ?>' />
            <button id="sendViaEmail">Send E-mail</button>
        </form>
    </div>

</form>
