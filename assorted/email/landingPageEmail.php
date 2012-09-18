<!doctype html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" type="text/css" media="all" href="style.css">
  <link rel="stylesheet" type="text/css" media="all" href="fancybox/jquery.fancybox.css">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script type="text/javascript" src="fancybox/jquery.fancybox.js?v=2.0.6"></script>
</head>

<body>
<div id="wrapper">
	<p><a class="modalbox" id="mailTo" href="#inline">click to open</a></p>
</div>

<!-- hidden inline form -->
<div id="inline">
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
		<button id="send">Send E-mail</button>
	</form>
</div>

<!-- basic fancybox setup -->
<script type="text/javascript">
	function validateEmail(email) { 
		var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return reg.test(email);
	}

	$(document).ready(function() {
		$(".modalbox").fancybox();
		$("#contact").submit(function() { return false; });

		
		$("#send").on("click", function(){
			var emailval  = $("#email").val();
			var msgval    = $("#msg").val();
			var msglen    = msgval.length;
			var mailvalid = validateEmail(emailval);
			
			if(mailvalid == false) {
				$("#email").addClass("error");
			}
			else if(mailvalid == true){
				$("#email").removeClass("error");
			}
			
			if(msglen < 4) {
				$("#msg").addClass("error");
			}
			else if(msglen >= 4){
				$("#msg").removeClass("error");
			}
			
			if(mailvalid == true && msglen >= 4) {
				// if both validate we attempt to send the e-mail
				// first we hide the submit btn so the user doesnt click twice
				$("#send").replaceWith("<em>sending...</em>");

                alert("before sending");

				$.ajax({
					type: 'POST',
					url: 'inviteFriendViaEmail.php',
					data: $("#contact").serialize(),
					success: function(data) {

                        alert(data);

						if(data.toLowerCase().indexOf("message_sent") > 0) {
                            alert("CLosing...");
							$("#contact").fadeOut("fast", function(){
								$(this).before("<p><strong>Success! Your feedback has been sent, thanks :)</strong></p>");
								setTimeout("$.fancybox.close()", 1000);
							});
						}
                        else
                        {
                            alert("Closing with failure...");
                            $(this).before("<p><strong>Message sending failed :-(</strong></p>");
                            setTimeout("$.fancybox.close()", 1000);

                        }
					}
				});
			}
		});
	});
</script>

</body>
</html>