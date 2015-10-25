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

/*edit profile page button scripts*/
	$(document).ready(function()
	{
		function editprofile()
	{
		window.open ('edit_profile.php','_self')	
	}
		$("#editbtn").click(editprofile);
	});

/*Go to Registration Page from Login Page Button*/
	$(document).ready(function()
	{
		function index()
	{
		window.open ('signup.php','_self')	
	}
		$("#regPagebtn").click(index);
	});

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