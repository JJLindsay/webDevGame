$(document).ready(function()
{	
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

	
	/*admin page script*/
	function exportbtn()
	{
		window.open ('export_table.php','_self');
		//window.open ('export_table.php?query="'+$(this).attr('query'),'_self');

	}$("#exportbtn").click(exportbtn);


	//executes Play Iteration
	function playIteration()
	{
		//alert("found method!")
		$.ajax({
			url: './iterate.php',
			success: function() {
				//alert("Fixed group configured: updated dilemmas table!")
			},
		});				
	}$("#iterationbtn").click(playIteration);
	
	
	//player chose to cooperate with their partner and remain quiet
	function submitCoop()
	{
		//alert("found choice method!")
		$.ajax({
			url: "./coopdefect.php?decision="+ $(this).attr('submitChoice'),
			success: function() {
				//alert("METHOD UNDER CONSTRUCTION")
			},
		});		
				
	}$("#btnCoop").click(submitCoop);
	
	
	//player chose to betray their partner and speak
	function submitBetray()
	{
		//alert("found choice method!")
		$.ajax({
			url: "./coopdefect.php?decision="+ $(this).attr('submitChoice'),
			success: function() {
				//alert("METHOD UNDER CONSTRUCTION")
			},
		});						
	}$("#btnBetray").click(submitBetray);
	
	
	function addCourse()
	{
		//alert("found choice method!");
		window.open ('admin_add_course.php','_self');	
	}$("#addcour").click(addCourse);
	
	
	$(function(){
      $('#updateIterative').click(function(){
        var val = [];
		var classes = "";
        $(':checkbox:checked').each(function(i){
		  classes += $(this).val() + "|";
        });
		window.open ('build_iterate_teams.php?checked='+classes,'_self');	
		//alert("start:"+classes+":end");
      });
    });
	
	
	$(function(){
      $('#updateRandom').click(function(){
        var val = [];
		var classes = "";
		$("input:checkbox:not(:checked)").each(function(i){
          //val[i] = $(this).val();
		  classes += $(this).val() + "|";
        });
		window.open ('random.php?unchecked='+classes,'_self');	
		//alert("start:"+classes+":end");
      });
    });	
	
	
	/*submit table dump button scripts*/	
	function dumpTables()
	{
		window.open ('dump_tables.php','_self')	
	}$("#dumpSemesterData").click(dumpTables);
});