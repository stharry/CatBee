<div>Share Via:</div>
<div class="mailmodalbox" id="mailToFriend" href="#mailInline"></div>


<div id="mailInline" class="mailForm">
    <h2>Send us a Message</h2>

    <form id="contact" name="contact" action="#" method="post">
        <label for="email">Your E-mail</label>
        <input type="email" id="email" name="email" class="txt">
        <br>
        <label for="msg">Enter a Message</label>
        <textarea id="msg" name="msg" class="txtarea"></textarea>
        <input type="hidden" name="leaderEmail" id="leaderEmail" value='<?php echo $leaderEmail; ?>'/>
        <input type="hidden" name="storeName" id="storeName" value='<?php echo $storeName; ?>'/>
        <input type="hidden" name="tribziId" id="tribziId" value='<?php echo $tribziId; ?>'/>
        <button id="sendViaEmail">Send E-mail</button>
</div>