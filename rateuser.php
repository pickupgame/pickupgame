<!-- rate the host or user -->
<!-- buttons that will submit a query to increase the rating or decrease the rating -->

<?php
$profile['UserID'] = "123"; //needs to be retrieved dynamically
?>

<script src="/javascript/jquery-1.11.1.js"></script>
<script>
$(function(){
	var $ratings = $('#ratings');
	$.get("api/get_likes.php?UserID=<?php echo $profile['UserID']; ?>",
	function(stuff)
	{
		$('#likes').html(stuff);
	});

	$('#like').on("click", function(){
		$.post("api/rating.php", 
		{
			player_evaluated 	: "<?php echo $profile['UserID']; ?>",
			player_rater 		: "<?php echo $_SESSION['UserID']; ?>",
			rating 			: "1"
		},
		function(data)
		{
			alert("Rating Submitted. Thank you.");
			$.get("api/get_likes.php?UserID=<?php echo $profile['UserID']; ?>",
			function(stuff)
			{
				$('#likes').html(stuff);
			});
		});
	});

});


</script>
<div id="rateUserUp">
	<div id="input">
		<span id="likes"></span><button id="like">+</button>
		<span id="dislikes"></span><button id="dislike">-</button>
	</div>
</div>