<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html>
<head>
	<title>JQuery Form Example</title> 
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
    <script type="text/javascript">
	$(document).ready(function(){
		$("#myform").validate({
			debug: false,
			rules: {
				name: "required",
				email: {
					required: true,
					email: true
				}
			},
			messages: {
				name: "Please let us know who you are.",
				email: "A valid email will help us get in touch with you.",
			},
			submitHandler: function(form) {
				// do other stuff for a valid form
				$.post('process.php', $("#myform").serialize(), function(data) {
					$('#results').html(data);
				});
			}
		});
	});
	</script>
	<style>
	label.error { width: 250px; display: inline; color: red;}
	</style>
</head>
<body>
<?php if(isset($_POST['submit'])){
	include("ajax.php");
	echo "Done!!";
}?>
<form name="myform" id="myform" action="" method="post">  
<!-- The Name form field -->
    <label for="name" id="name_label">Name</label>  
    <input type="text" name="fname" id="fname" size="30" value=""/>  
	<br>
<!-- The Email form field -->
    <label for="email" id="email_label">Email</label>  
    <input type="text" name="lname" id="lname" size="30" value=""/> 
	<br>
<!-- The Submit button -->
	<input type="submit" name="submit" value="Submit"> 
</form>
<!-- We will output the results from process.php here -->
<div id="results"><div>
</body>
</html>