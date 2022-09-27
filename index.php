<?php 

$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$lastUriSegment = array_pop($uriSegments);
$fleeca_gateway_url = "http://banking.local/gateway/";
$fleeca_token_url = "http://banking.local/gateway_token/";
$auth_key = "elbSESftufNV2lnMTX01ET0mFLvuGn6RgPFVSAXAvaLgG0WUxliaigsi69utHqfp";

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<span>Authentication Key</span>
<input type="text" name="auth_key" id="auth_key" value="<?php echo $auth_key; ?>"><br/>
<br/>
<input type="text" name="price" id="price" placeholder="Price"> <a href="#" id="dynamic_link_purchase">Purchase</a><br/>
<input type="text" name="token" id="token" placeholder="Token" value="<?php echo $lastUriSegment; ?>"> <a href="#" id="auth_token">Authenticate Token</a><br/>
<br/>
<span id="token_results"></span>

<script>
	$(function() {
		$("#price").change(function() {
			var price = $(this).val();
			$("#dynamic_link_purchase").attr("href", "<?php echo $fleeca_gateway_url.$auth_key."/0/"; ?>"+price)
		});


		$("#auth_token").click(function() {
			event.preventDefault();
			var token = $("#token").val();

			$.ajax({
                url: '<?php echo $fleeca_token_url ?>'+token,
                type: 'POST',
                success: function(data) {
                    var json = $.parseJSON(data);
                    $("#token_results").text(json.message + ' Sandbox: ' + json.sandbox + ' Expired Token: ' + json.token_expired);
                },
                error: function(data) {
                    $("#token_results").text("payment error");
                }
        	});
		})
	})

</script>