<script>
$.ajaxSetup({cache:false});
setInterval(function(){$('#frnd_note').load('_ext/_note/_frndreq/_system_quick_friend_notes.php');}, 5000)

$.ajaxSetup({cache:false});
setInterval(function(){$('#friend_request').load('_ext/_note/_frndreq/_friend_requests_quick_query.php');}, 5000)

$.ajaxSetup({cache:false});
setInterval(function(){$('#quick_note_num').load('_ext/_note/_notes/_system_quick_notes.php');}, 5000)

$.ajaxSetup({cache:false});
setInterval(function(){$('#quick_note_toggle_num').load('_ext/_note/_notes/_system_togglebar_quick_notes.php');}, 5000)

$.ajaxSetup({cache:false});
setInterval(function(){$('#chat_nav_note').load('_ext/_note/_chat/_quick_chat_nav_note.php');}, 5000)

$.ajaxSetup({cache:false});
setInterval(function(){$('#chat_note').load('_ext/_note/_chat/_quick_chat_note.php');}, 5000)

$.ajaxSetup({cache:false});
setInterval(function(){$('#chat_note_mobile').load('_ext/_note/_chat/_quick_chat_note_mobile.php');}, 5000)

/* $.ajaxSetup({cache:false});
setInterval(function(){$('#statuslogs').load('_ext/_story/user_load_status.php');}, 300000) */
/*Refresh every 5 minutes*/
</script>