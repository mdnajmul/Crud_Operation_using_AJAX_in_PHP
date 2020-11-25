<!DOCTYPE html>
<html>
<head>
	<title>AJAX CRUD</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>

    <div class="container">

    	<h1 class="text-primary text-uppercase text-center"> AJAX CRUD OPERATION </h1>

    	<div class="d-flex justify-content-end">
    		<!-- Button to Open the Modal -->
			<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal">ADD Data</button>
    	</div>

    	<h2 class="text-danger">All Records </h2>

    	<div id="records_contant">
    		
    	</div>

        <!-- The Modal(save data) -->
		<div class="modal" id="myModal">
		  <div class="modal-dialog">
		    <div class="modal-content">

		      <!-- Modal Header -->
		      <div class="modal-header">
		        <h4 class="modal-title">Ajax crud Operation</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		      </div>

		      <!-- Modal body -->
		      <div class="modal-body">

		        <div class="form-group">
		        	<label for="firstname">First Name:</label>
		        	<input type="text" name="firstname" id="firstname" class="form-control" placeholder="First Name">
		        </div>

		        <div class="form-group">
		        	<label for="lastname">Last Name:</label>
		        	<input type="text" name="lastname" id="lastname" class="form-control" placeholder="Last Name">
		        </div>

		        <div class="form-group">
		        	<label for="email">Email:</label>
		        	<input type="email" name="email" id="email" class="form-control" placeholder="Email">
		        </div>

		        <div class="form-group">
		        	<label for="mobile">Mobile:</label>
		        	<input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile Number">
		        </div>
		        
		      </div>

		      <!-- Modal footer -->
		      <div class="modal-footer">
		      	<button type="button" class="btn btn-success" data-dismiss="modal" onclick="addRecord()">Save</button>
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		      </div>

		    </div>
		  </div>
		</div>


		<!--== Update Modal ==-->
		<div class="modal" id="update_user_modal">
		  <div class="modal-dialog">
		    <div class="modal-content">

		      <!-- Modal Header -->
		      <div class="modal-header">
		        <h4 class="modal-title">Ajax Update Operation</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		      </div>

		      <!-- Modal body -->
		      <div class="modal-body">

		        <div class="form-group">
		        	<label for="update_firstname">Update First Name:</label>
		        	<input type="text" name="" id="update_firstname" class="form-control">
		        </div>

		        <div class="form-group">
		        	<label for="update_lastname">Update Last Name:</label>
		        	<input type="text" name="" id="update_lastname" class="form-control">
		        </div>

		        <div class="form-group">
		        	<label for="update_email">Update Email:</label>
		        	<input type="email" name="" id="update_email" class="form-control">
		        </div>

		        <div class="form-group">
		        	<label for="update_mobile">Update Mobile:</label>
		        	<input type="text" name="" id="update_mobile" class="form-control">
		        </div>
		        
		      </div>

		      <!-- Modal footer -->
		      <div class="modal-footer">
		      	<button type="button" class="btn btn-success" data-dismiss="modal" onclick="updateRecord()">Update</button>
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		        <input type="hidden" name="" id="hidden_user_id">
		      </div>

		    </div>
		  </div>
		</div>



    </div>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>


    <!-- Use JavaScript for save user details inside database -->
	<script type="text/javascript">

		//when page load/ready then all data from database table
		$(document).ready(function(){
            //call this functio for show data
			readRecord();
		});


		//This function is used for fetch/read/show data from database table
		function readRecord(){
			//
			var read_record = "readrecord";
			//Now we use ajax to fetch data from database
			$.ajax({
				url:'backend.php',
				type: 'post',
				data: { readrecord:read_record },
				success:function(data,status){
					//show data inside html <div> which id is #records_contant
					$('#records_contant').html(data);
				}
			});
		}



		//This function is used for add/insert data inside database table 
		function addRecord(){
			//hold all data from user form by using jQuery
			var firstName = $('#firstname').val();
			var lastName = $('#lastname').val();
			var Email = $('#email').val();
			var Mobile = $('#mobile').val();

			//Now we pass these data to our backend page by using ajax
			$.ajax({
				url:'backend.php',
				type: 'post',
				//data: which are we sent to other page
				data: { firstname :firstName,
					    lastname : lastName,
					    email : Email,
					    mobile : Mobile
					  },
				success:function(data,status){
					readRecord();

				}	  
			});
	}


    //This function is used for delete data from database table
    function deleteUserDetails(delete_id){
        //for alert/pop-up message
    	var conf = confirm("Are you sure? ")

    	//validate
    	if(conf==true){
    		//Now we pass delete id to our backend page by using ajax
    		$.ajax({
    			url: 'backend.php',
    			type: 'post',
    			data: { delete_id:delete_id },
    			success:function(data,status){
    				//call this function when delele was happened
    				readRecord();

    			}

    		});
    	}

    } 


/*============================== Start Edit/Update Option =========================================================*/

    //This function is used when clcik edit button, then show only that id's data which one we want to update
    function editUserDetails(id){

    	$('#hidden_user_id').val(id);

    	//In post we have three parameter that are url,Data and Callback.Load data from the server using a HTTP POST request//
    	//First parameter:- A String containing the URL to which the request is sent
    	//Second parameter:- Now,DATA: a object or string that is sent to the server with the request
    	//Third parameter:- A callback function that is executed if the request succeeds.
    	$.post(
	    		"backend.php", 
	    		{
	    		id:id
	    		}, 
	    		function(data,sratus){
	    			//JSON.parse() parses a string, written in JSON format, and returns a JavaScript object.
	    			var user = JSON.parse(data);
	    			//when click Edit button then shows that id's data which id data we want to edit/update
	    			$('#update_firstname').val(user.firstname);
	    			$('#update_lastname').val(user.lastname);
	    			$('#update_email').val(user.email);
	    			$('#update_mobile').val(user.mobile);

	    	    }
    		 );

    	//write this, the update modal is open
    	$('#update_user_modal').modal("show");


    }





    //This function is for update data & show data after updated
    function updateRecord(){
    	//hold all data from update modal form
    	var upd_firstname = $('#update_firstname').val();
    	var upd_lastname = $('#update_lastname').val();
    	var upd_email = $('#update_email').val();
    	var upd_mobile = $('#update_mobile').val();

    	//pass hidden_user_id for hold that id number(which one we updated)
    	var hidden_user_id_upd = $('#hidden_user_id').val();

    	$.post(
	    		"backend.php", 
	    		{
	    		hidden_id:hidden_user_id_upd,
	    		firstName:upd_firstname,
	    		lastName:upd_lastname,
	    		Email:upd_email,
	    		Mobile:upd_mobile,
	    		}, 
	    		function(data,status){
	    			//write this, the update modal is hide
    				$('#update_user_modal').modal("hide");
    				//call this function when update was happened
    				readRecord();
	    		}
	    	);
    }

 /*============================== End Edit/Update Option =========================================================*/   


	</script>
</body>
</html>