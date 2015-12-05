$(document).ready(function()
{
	/*home page scripts
	function login()
	{
		window.open ('profile.php','_self')
	}$("#loginbtn").click(login);*/
	
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
			url: './iterate_classes.php',
			//url: './random.php',
			success: function() {
				alert("Random configured: dilemmas table updated")
			},
		});				
	}$("#playrandombtn").click(playAtRandom);
	
	//export to excel spreadsheet
	function fnExcelReport()
	{
		var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
		var textRange; var j=0;
		tab = document.getElementById('headerTable'); // id of table

		for(j = 0 ; j < tab.rows.length ; j++) 
		{     
			tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
			//tab_text=tab_text+"</tr>";
		}

		tab_text=tab_text+"</table>";
		tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
		tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
		tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

		var ua = window.navigator.userAgent;
		var msie = ua.indexOf("MSIE "); 

		if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
		{
			txtArea1.document.open("txt/html","replace");
			txtArea1.document.write(tab_text);
			txtArea1.document.close();
			txtArea1.focus(); 
			sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
		}  
		else                 //other browser not tested on IE 11
			sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

		return (sa);
	}$("#btnExport").click(fnExcelReport);
	
	//GAME HISTORY TEST using coop/defect button
	function submitCoop()
	{
		alert("found choice method!")
		$.ajax({
			url: "./coopdefect.php?decision="+ $(this).attr('submitChoice'),
			success: function() {
				alert("METHOD UNDER CONSTRUCTION")
			},
		});		
				
	}$("#btnCoop").click(submitCoop);
	
	
	
	function submitBetray()
	{
		alert("found choice method!")
		$.ajax({
			url: "./coopdefect.php?decision="+ $(this).attr('submitChoice'),
			success: function() {
				alert("METHOD UNDER CONSTRUCTION")
			},
		});		
				
	}$("#btnBetray").click(submitBetray);
	/*
	function defectButtonCode($decision)
	{
		alert("found defect method!")
		$.ajax({
			url: './random.php?decision=$decision',
			success: function() {
				alert("defect configured: dilemmas table updated")
			},
		});		
			
	}$("#btnDef").click(defectButtonCode);*/
	
	function addCourse()
	{
		alert("found choice method!");
		window.open ('admin_add_course.php','_self');	
	}$("#addcour").click(addCourse);
});

