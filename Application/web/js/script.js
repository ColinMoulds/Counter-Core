var socket = io('http://176.63.56.48:3000');

socket.on('disablecredit', function (data)
{
	$('#credits').attr('disabled', 'disabled');

});
socket.on('enablecredit', function (data)
{
	$('#credits').removeAttr('disabled');

});

function jpupdate()
{
	refreshCredits();
	$.ajax({
		method: "GET",
		url: "table1.php",
		dataType: 'html'
	}).done(function(msg) {
		$("div.t1").html(msg);

	});
	$.ajax({
			method: "GET",
			url: "updategamenumber.php"
		}).done(function(msg)
		{
			$("span.gnum").html(msg);
	});
		$.ajax({
		method: "GET",
		url: "pot1.php"
	}).done(function(msg)
	{
		$("span.cvalue").html(msg);

	});
	$.ajax({
		method: "GET",
		url: "tl1.php"
	}).done(function(msg)
	{
		$("span.ticker").html(msg);

	});
	$.ajax({
		method: "GET",
		url: "previouswinner.php",
		dataType: 'html'
	}).done(function(msg) {
		$(".lastwinner").html(msg);

	});
	$("div.wnr").html('');
}
function refreshCredits()
{
	$.ajax({
		method: "GET",
		url: "updatecredits.php"
	}).done(function(msg) {
		$(".mycredits").html(msg);
	});
}
socket.on('updategameinfo', function (data)
{
	jpupdate();
});

socket.on('jackpotanimation', function (data)
{
	$.ajax({
			method: "GET",
			url: "loadr1.php"
		}).done(function(msg)
		{
			$('.kjmhgd').before(msg);
			setTimeout(function()
			{
				jpupdate();
			},12000);
		});
});

socket.on('showthechat', function (data)
{
	$.ajax({
	method: "GET",
	url: "showchat.php",
	data: { "id": data.messageid },
	dataType: 'html',
	}).done(function(msg)
	{
		$(".newmessages").append(msg);
	});
});

					
socket.on('showthedeposit', function (data)
{
	$(".first").remove();
	refreshCredits();
	array=data.split('/');
	usteamid=array[0];
	offerid=array[1];
	setTimeout(function()
	{
		$("table#winnertable tr#dep"+usteamid).remove();
		$.ajax({
			method: "GET",
			url: "showdeposit.php",
			data: { "id": offerid }
		}).done(function(msg)
		{
			if(!msg)
			{
				setTimeout(function()
				{
					$.ajax({
					method: "GET",
					url: "showdeposit.php",
					data: { "id": offerid },
					dataType: 'html',
					}).done(function(msg)
					{
						if(msg)
						{
							$("table#winnertable tr#dep"+usteamid).remove();
							$("table#winnertable").prepend(msg);
						}
					});
				},1000);
			
			}
			else
			{
				$("table#winnertable").prepend(msg);
			}

		});
	},500);
	$.ajax({
		method: "GET",
		url: "pot1.php"
	}).done(function(msg)
	{
		$("span.cvalue").html(msg);

	});
		
});
