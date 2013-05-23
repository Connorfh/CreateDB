<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Department of Computer Science Database Creation</title>
		<link href="style.css" type="text/css" media="screen" rel="stylesheet" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" type="text/javascript"></script>
		<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.8.1/jquery.validate.min.js" type="text/javascript"></script>
		<script type="text/javascript">
		function parseReturnedJSON(data)
		{
			//alert("parseReturnedJSON 1");
			var message = data["message"];
			var messageSpace = $("div#response p");
			switch(data["error"])
			{
				case "badUsername":
				{
					//alert("bad user name");
					message = "Incorrect user name or password.";
					break;
				}
				case "dbNameTaken":
				{
					//alert("db name taken");
					message = "The requested name for the database (" + data["dbName"] + ") is already taken."
					break;
				}
				case "internalError":
				{
					//alert("internal server error");
					message = "Internal server error. Please contact the helpdesk for help in resolving this issue. Please include this error message:<br />" + data["message"];
					break;
				}
				case "none":
				default:
				{
					messageSpace.removeClass("error");
					messageSpace.addClass("success");
					//alert("no error");
					message = "Your database <strong>" + data["dbName"] + "</strong> has been created.";
					$("input#submit").attr("disabled", true);
					break;
				}
			}
			messageSpace.html(message);
		}
		
		var _data = "";
		
		function doFormSubmit()
		{
			//alert("doFormSubmit 1");
			$.ajax({
				url: "ajaxSubmit.php",
				context: document.body,
				type: "POST",
				dataType: "json",
				data: {
					"username": $("input#username").val(),
					"password": $("input#password").val(),
					"purpose": $("input#purpose").val(),
					"dbName": $("input#dbName").val(),
				},
				success: function(data) {
					//alert("doFormSubmit ajax success");
					_data = data;
					parseReturnedJSON(data);
				}
			});
			//alert("doFormSubmit 2");
		}
		
		$(document).ready(function(){
			$("input#submit").click(function(event) {
				//event.preventDefault();

				$("#form").validate({
					rules: {
						username: "required",
						password: "required",
						purpose: "required",
						dbName: "required"
					},
					errorElement: "div",
					submitHandler: function(form)
					{
						doFormSubmit();
					}
				});
			})
		})
		</script>
	</head>
	<body>
		<div class="body">