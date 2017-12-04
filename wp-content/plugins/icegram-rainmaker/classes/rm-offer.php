<?php
		$screen = get_current_screen(); 
	        if ( !in_array( $screen->id, array( 'edit-rainmaker_form', 'rainmaker_form','edit-rainmaker_lead','rainmaker_form_page_icegram-rainmaker-support', 'rainmaker_form_page_icegram-rainmaker-upgrade' ), true ) ) return;

		if( get_option('rm_offer_accepted_icegram') == 1 ) return;
?>
		<style type="text/css">
			.ig-offer-container {
				background-color: rgb(77,14,39) !important;
			    margin-top: 1%;
			    padding: 1em 1em 0.5em 1.6em;
			    box-shadow: 0 0 7px 0 rgba(0, 0, 0, .2);
			    color: rgb(200,195,210);
			    font-size: 1.1em;
			    height: auto;
			    max-width: 35%;
			    margin: 1% auto;
			    text-align: center;
			}
			.ig-offer-wrapper {
				margin-bottom:0.4em;
			}
			.ig-btn-wrapper{
				margin: 2em 0;
			}
		</style>
		<div class="ig-offer-container wrap">
			<div class="ig-offer-wrapper">
				<div class="ig-offer-headline">
					<div class="ig-mainheadline"><img src="<?php echo  $this->plugin_url ?>../assets/images/halloween.png"/></div>
				    <div class="" style=" font-size: 1.5em;line-height: 1.4; margin: 1.6em 0;">
				    	BOO!!! It's the Halloween sale.<br/> Get <span  style="color:#fff;font-weight:bold">flat 20% Off</span> on any Rainmaker plan. <br/><br/>
						Use coupon code <span  style="color:#fff;font-weight:bold">HALLOWEEN17</span> during checkout!<br/>
						Offer ends on 31st October, 2017. 
					</div>
					<div class="ig-btn-wrapper">
						<a href="?rm_dismiss_admin_notice=1&rm_option_name=rm_offer_accepted" class="btn" style="cursor:pointer;background: #e94e21;background-image: linear-gradient(to bottom, #e94e21, #ef3124);-webkit-border-radius: 28;-moz-border-radius: 28;border-radius: 27px;font-family: sans-serif;color: #ffffff;font-size: 2em;padding: 0.3em 1.2em;text-decoration: none;">SHOP NOW</a>
					</div>
				</div>
			</div>
		</div>
