<div class="popup" id="activationHint" pd-popup="activationHint">
	<div class="popup-inner">
		<div class="box-body">
			<div class="box box-primary" style="border-top:0px solid;text-align:justify;box-shadow: 0 0px 0px;">
				<h3 class="text-primary" style="font-weight: 400;margin-top: 0px;">Hello <?php echo $firstname;?></h3>
				<h5 class="text-purple" style="font-weight: 200;">An activation link will be sent to your email address in a few minutes.</h5>
				<h5 class="text-black" style="font-weight: 300;">Check your email inbox at <u><?php echo $email;?></u> to complete the sign up process by activating your account.</h5>
			</div>
			<br>
			<div class="box-footer no-padding">
				<a href="javascript:void(0)" pd-popup-close="activationHint" class="btn btn-primary pull-right">Okay</a>
				<a id="changeAddress" href="javascript:void(0)" class="btn btn-default pull-left">Change email address</a>
			</div>
		</div>
	</div>
</div>