/*	wallet.php	*/

function loadCategories(category)
{
	$.post( "functions.php", {
		'option':'loadCategories',
		'category': category
	}, function(data) {
		$("#category").html(data);
  		console.log(data);
	});
}
