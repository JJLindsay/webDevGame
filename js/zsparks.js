$(document).ready(function()
{
	/*home page scripts*/
	function login()
	{
		window.open ('profile.php','_self')
	}$("#loginbtn").click(login);
	
	function register()
	{
		window.open ('signup.php','_self',false)
	}$("#regPagebtn").click(register);

	/*edit profile page button scripts*/	
	function editprofile()
	{
		window.open ('edit_profile.php','_self')	
	}$("#editbtn").click(editprofile);


	/*Go to Registration Page from Login Page Button*/
	function index()
	{
		window.open ('signup.php','_self')	
	}$("#regPagebtn").click(index);
	

	/*profile page scripts*/
	function editbtn()
	{
		//todo
	}$("#id_here").click(editbtn);



	/*admin page script*/
	function exportbtn()
	{
		//todo
	}$("#id_here").click(exportbtn);


	//executes Play Iteration
	function playIteration()
	{
		alert("found method!")
		$.ajax({
			url: './iterate.php',
			success: function() {
				alert("Fixed group configured: updated dilemmas table!")
			},
		});				
	}$("#iterationbtn").click(playIteration);

	//executes Play Random
	function playAtRandom()
	{
		alert("found method!")
		$.ajax({
			url: './random.php',
			success: function() {
				alert("Random configured: dilemmas table updated")
			},
		});				
	}$("#playrandombtn").click(playAtRandom);
	
});