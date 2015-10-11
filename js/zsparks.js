/*home page scripts*/
$(document).ready(function()
{
	function login()
	{
		window.open ('profile.html','_self')
	}
	$("#loginbtn").click(login);
	
	function register()
	{
		window.open ('signup.html','_self',false)
	}
	$("#registerbtn").click(register);
});

/*registration page scripts*/
	/*$(document).ready(function()
	{
		function completeregistration()
	{
		window.open ('administration.html','_self')	
	}
		$("#completeregistrationbtn").click(completeregistration);
	});*/


/*profile page scripts*/
$(document).ready(function()
{
	function editbtn()
	{
		//todo
	}
	$("#id_here").click(editbtn);
});


/*admin page script*/
$(document).ready(function()
{
	function exportbtn()
	{
		//todo
	}
	$("#id_here").click(exportbtn);
});