<?php
//needs to be retrieved dynamically
// echo $_POST['Game_ID'];
// $_POST['Game_ID'] = "123";
?>
<script>
$(function(){
	$.get("api/get_game_players.php?Game_ID=<?php echo $_POST['Game_ID']; ?>",
	function(stuff)
	{	
		if(stuff != null)
		{
			var data = $.parseJSON(stuff);
			console.log(data);
			for (var key in data) {
			    if (data.hasOwnProperty(key)) {
			      $('#Players').append("<div>" + data[key]['Name'] + " " + data[key]['Age'] + "<div class='button'><button id='like'>+</button><span id='dislikes'></span><button id='dislike'>-</button></div></div>");
			    }
			  }
		}
		else
		{
			$('#input').html('Error, no game by that ID');
		}
		// $('#likes').html(obj[0].Name);
	});
});


</script>
<div id="game">
	<div id="gameDetails">
		[game details]	
	</div>
	<div id="playerDetails">
		<h2>Players</h2>
		<div id="Players"></div>
	</div>
</div>







