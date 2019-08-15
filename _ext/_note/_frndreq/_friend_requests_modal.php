<div class="modal fade" id="friendRequestModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
				<button type="button" class="pull-right close fa-1x" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h6 class="modal-title" id="defaultModalLabel">Friend requests</h6>
            </div>
			<span id="followers">
				<div class="modal-body" style="padding:0px;">
					<div class="uq">
						<div id="content">		
							<ul id="friend_request" class="products-list product-list-in-box">
								<div class="text-center">
									<div class="preloader pl-size-xs" style="margin: 5px;"><div class="spinner-layer pl-red"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>
								</div>
							</ul>
						</div>
						<div id="find" style="display:none;">
							<div style="text-align:center;" id="loader"></div>
						</div>
					</div>
				</div>
				<div class="text-center" style="padding: 5px;"></div>
			</span>   
        </div>
    </div>
</div>
<script>
function friendReqHandler(action,reqid,user1,elem){
	_(elem).innerHTML = '<div class="preloader pl-size-xs" style="margin: 5px;"><div class="spinner-layer pl-red"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
	var ajax = ajaxObj("POST", "_parse/_system_friend.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == "accept_ok"){
				_(elem).innerHTML = "<span style='color:green;font-size: 12px;'>Request Accepted</span><br/><span style='font-size: 12px;'>You are now friends</span>";
			}else if(ajax.responseText == "reject_ok"){
				_(elem).innerHTML = "<span style='color:rgb(192, 41, 41);font-size: 12px;'>Request Rejected</span>";
			}else {
				_(elem).innerHTML = ajax.responseText;
			}
		}
	}
	ajax.send("action="+action+"&reqid="+reqid+"&user1="+user1);
}	
</script>