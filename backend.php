<?php
  
   //create database connection link
   $con = mysqli_connect('localhost','root','','ajax_crud_operation');

   //extract() function is used to import variables form an array into the current symbol table
   //It is same like:" var firstname = $_POST['firstname']; "
   extract($_POST);

   //We use isset() function for each function call
   //This for create select query & execute this query for show data from database table
   if(isset($_POST['readrecord'])){
      //Here, we put <table> tag & table header tag inside $data variable
   	  $data = '<table class="table table-bordered table-striped">
			   	  <tr>
				   	  <th>No.</th>
				   	  <th>First Name</th>
				   	  <th>Last Name</th>
				   	  <th>Email Address</th>
				   	  <th>Mobile Number</th>
				   	  <th>Edit Action</th>
				   	  <th>Delete Action</th>
			   	  </tr>';

       //write select query to fetch all data from database table
	   $select_query = "SELECT * FROM user_details";
	   //execute $select_query & put this inside $result variable
	   $result = mysqli_query($con,$select_query);

	   //check data is found or not by using mysqli_num_rows() function
	   if(mysqli_num_rows($result) > 0){
            //this variable for show id number in frontend
		   	$number = 1;
		   	//write while loop for show all data inside html table
		   	while($row = mysqli_fetch_array($result)){

		   		//concatenate previous $data value with it
		   		//Here we write html table data where we show all data & show two button(Edit,Delete)
		   		$data .= '<tr>
					   		<td>'.$number.'</td>
					   		<td>'.$row['firstname'].'</td>
					   		<td>'.$row['lastname'].'</td>
					   		<td>'.$row['email'].'</td>
					   		<td>'.$row['mobile'].'</td>
					   		<td>
				           		 <button onclick="editUserDetails('.$row['id'].')" class="btn btn-warning">Edit</button>
					   		</td>
					   		<td>
				           		 <button onclick="deleteUserDetails('.$row['id'].')" class="btn btn-danger">Delete</button>
					   		</td>
				   		 </tr>';
				   		 $number++;
			}
		}
		//concatenate end table tag '</table>' with previous $data value
		$data .= '</table>';
		//print/show $data value
		echo $data;		   	  
    }

 



   //isset() function is used to check whether a variable is set or not
   //This for create insert query & execute this query for add data inside database table
   if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['mobile'])){
    //write insert query
   	$sql_query = "INSERT INTO user_details(firstname,lastname,email,mobile) VALUES('$firstname','$lastname','$email','$mobile')";
   	//execute query
   	mysqli_query($con,$sql_query);

   }





   //This for create delete query & execute this query for delete data from database table
   if(isset($_POST['delete_id'])){

   	//put this id inside $userid variable
   	$userid = $_POST['delete_id'];

   	//write delete query
   	$delete_query = "DELETE FROM user_details WHERE id=$userid";
   	//execute this query
   	mysqli_query($con,$delete_query);

   }




/*========================== Start Update Section==================================================*/

   ////This for create update query & execute this query for update data from database table
   //get user id for update
   if(isset($_POST['id']) && isset($_POST['id']) != ""){
	   	//hold id inside $user_id variable which data we want to update
	   	$user_id = $_POST['id'];
	   	//write select query to show data which is we want to update
	   	$query = "SELECT * FROM user_details WHERE id = '$user_id'";
	   	//check, if query is not executed
	   	if(!$result = mysqli_query($con,$query)){
	   		exit(mysqli_error());
	   	}

	   	//After successfully query executed, create an array called $response
	   	$response = array();
	   	//if row found then fetch all data inside $row variable
	   	if(mysqli_num_rows($result) > 0){
	   		while ($row = mysqli_fetch_assoc($result)) {
	   			//put all data from $row variables to inside $response variable
	   			$response = $row;
	   		}
	   	} else{
	   		$response['status'] = 200;
	   		$response['message'] = "Data not found!";
	   	}

	   	// PHP has some built-in functions to handle JSON.
	   	//Objects in PHP can be converted into JSON by using the PHP function json_encode();
	   	echo json_encode($response);
   } else{
   		$response['status'] = 200;
		$response['message'] = "Invalid Request!";
   }


   //Update table
   if(isset($_POST['hidden_id'])){
   	//hold all data from update modal table
   	$upd_id = $_POST['hidden_id'];
   	$upd_firstname = $_POST['firstName'];
   	$upd_lastname = $_POST['lastName'];
   	$upd_email = $_POST['Email'];
   	$upd_mobile = $_POST['Mobile'];

   	//write update query
   	$upd_query = "UPDATE user_details SET firstname='$upd_firstname',lastname='$upd_lastname',email='$upd_email',mobile='$upd_mobile' WHERE id='$upd_id'";

   	//execute query
   	mysqli_query($con,$upd_query);
   }

 /*========================== End Update Section==================================================*/  

?>