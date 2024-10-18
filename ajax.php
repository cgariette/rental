<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
ob_start();
if(!isset($_SESSION['system'])){
	$system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
	foreach($system as $k => $v){
		$_SESSION['system'][$k] = $v;
	}
}

if (isset($_GET['action']) && $_GET['action'] == 'save_property') {
    $property_name = $conn->real_escape_string($_POST['property_name']);
    $category_id = $conn->real_escape_string($_POST['category_id']);
    $developer = $conn->real_escape_string($_POST['developer']);
    $location = $conn->real_escape_string($_POST['location']);
    $building_street = $conn->real_escape_string($_POST['building_street']);
    $number_of_units = $conn->real_escape_string($_POST['number_of_units']);
    
    // Check if the property already exists
    $check_property = $conn->query("SELECT * FROM buildings WHERE property_name = '$property_name' LIMIT 1");
    if ($check_property->num_rows > 0) {
        echo 2; // Property already exists
        exit();
    }

	if ($conn->connect_error) {
		echo 'Connection failed: ' . $conn->connect_error;
		exit();
	}
	

    // Insert the property into the database
    $sql = "INSERT INTO buildings (property_name, category_id, developer, location, building_street, number_of_units) VALUES ('$property_name', '$category_id', '$developer', '$location', '$building_street', '$number_of_units')";
    
    if ($conn->query($sql) === TRUE) {
        echo 1; // Data successfully saved
    } else {
        echo 0; // Failed to save data
    }
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'toggle_active') {
    $id = $conn->real_escape_string($_POST['id']);
    $active = $conn->real_escape_string($_POST['active']);
    
    // Toggle the active status
    $sql = "UPDATE buildings SET active = '$active' WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo 1; // Status updated successfully
    } else {
        echo 0; // Failed to update status
    }
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'delete_building') {
    $id = $conn->real_escape_string($_POST['id']);
    
    // Delete the building from the database
    $sql = "DELETE FROM buildings WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo 1; // Building deleted successfully
    } else {
        echo 0; // Failed to delete building
    }
    exit();
}

// Fetch the property details for editing
if (isset($_GET['action']) && $_GET['action'] == 'fetch_property') {
    $id = $conn->real_escape_string($_POST['id']);
    
    $sql = "SELECT * FROM buildings WHERE id = '$id' LIMIT 1";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $property = $result->fetch_assoc();
        echo json_encode($property);
    } else {
        echo json_encode(null);
    }
    exit();
}

// Update the property in the database
if (isset($_GET['action']) && $_GET['action'] == 'update_property') {
    $id = $conn->real_escape_string($_POST['id']);
    $property_name = $conn->real_escape_string($_POST['property_name']);
    $category_id = $conn->real_escape_string($_POST['category_id']);
    $developer = $conn->real_escape_string($_POST['developer']);
    $location = $conn->real_escape_string($_POST['location']);
    $number_of_units = $conn->real_escape_string($_POST['number_of_units']);
    
    // Update the property in the database
    $sql = "UPDATE buildings SET property_name = '$property_name', category_id = '$category_id', developer = '$developer', location = '$location', number_of_units = '$number_of_units' WHERE id = '$id'";
    
    if ($conn->query($sql) === TRUE) {
        echo 1; // Update successful
    } else {
        echo 0; // Update failed
    }
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'save_apartment') {
    $building_id = $conn->real_escape_string($_POST['building_id']);
    $unit_no = $conn->real_escape_string($_POST['unit_no']);
    $num_bedrooms = $conn->real_escape_string($_POST['num_bedrooms']);
    $landlord = $conn->real_escape_string($_POST['landlord']);
    $unit_price = $conn->real_escape_string($_POST['unit_price']);
    $rent_amount = $conn->real_escape_string($_POST['rent_amount']);

    // Check if the apartment already exists in the building
    $check_apartment = $conn->query("SELECT * FROM apartments WHERE building_id = '$building_id' AND unit_no = '$unit_no' LIMIT 1");
    if ($check_apartment->num_rows > 0) {
        echo 2; // Apartment already exists
        exit();
    }

    // Insert the apartment into the database
    $sql = "INSERT INTO apartments (building_id, unit_no, num_bedrooms, landlord, unit_price, rent_amount) 
            VALUES ('$building_id', '$unit_no', '$num_bedrooms', '$landlord', '$unit_price', '$rent_amount')";

    if ($conn->query($sql) === TRUE) {
        echo 1; // Apartment saved successfully
    } else {
        echo 0; // Failed to save the apartment
    }
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'delete_apartment') {
    $unit_no = $conn->real_escape_string($_GET['id']);

    // Delete the apartment from the database
    $sql = "DELETE FROM apartments WHERE unit_no = '$unit_no'";

    if ($conn->query($sql) === TRUE) {
        echo 1; // Apartment deleted successfully
    } else {
        echo 0; // Failed to delete the apartment
    }
    exit();
}

if ($_GET['action'] == 'save_client') {
    $full_name = $_POST['full_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $nationality = $_POST['nationality'];
    $marital_status = $_POST['marital_status'];
    $identification = $_POST['identification'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $secondary_phone = $_POST['secondary_phone'];
    $street_address = $_POST['street_address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $postal_code = $_POST['postal_code'];
    $country = $_POST['country'];
    $contact_method = $_POST['contact_method'];

    // Check if client already exists
    $check = $conn->query("SELECT * FROM clients WHERE email = '$email' OR phone = '$phone'");
    if ($check->num_rows > 0) {
        echo '2'; // Client already exists
    } else {
        $stmt = $conn->prepare("INSERT INTO clients (full_name, dob, gender, nationality, marital_status, identification_number, email, phone, secondary_phone, street_address, city, state, postal_code, country, contact_method) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sssssssssssssss', $full_name, $dob, $gender, $nationality, $marital_status, $identification, $email, $phone, $secondary_phone, $street_address, $city, $state, $postal_code, $country, $contact_method);

        if ($stmt->execute()) {
            echo '1'; // Client successfully saved
        } else {
            echo '0'; // Failed to save client
        }
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'delete_client') {
    $id = $conn->real_escape_string($_GET['id']);

    // Delete the client from the database
    $sql = "DELETE FROM clients WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo 1; // Client deleted successfully
    } else {
        echo 0; // Failed to delete the client
    }
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'save_lease') {
    $building_id = $_POST['building_id'];
    $unit_id = $_POST['unit_id'];
    $tenant_id = $_POST['tenant_id'];
    $rent_amount = $_POST['rent_amount'];
    $start_date = $_POST['start_date'];
    $due_on = $_POST['due_on'];
    $deposit_amount = $_POST['deposit_amount'];
    $processing_fee = $_POST['processing_fee'];
    $service_fee = $_POST['service_fee'];
    $garbage_fee = $_POST['garbage_fee'];
    $water_fee = $_POST['water_fee'];
    $late_fee = $_POST['late_fee'];
    $invoice_day = $_POST['invoice_day'];
    $tenant_signature = $_POST['tenant_signature'];
    $landlord_signature = $_POST['landlord_signature'];
    $terms = isset($_POST['terms']) ? 1 : 0;
    $monthly_total = $_POST['monthly_total'];


    // Check if a lease already exists for the unit (regardless of tenant)
    $check_lease = $conn->query("SELECT * FROM leases WHERE unit_id = '$unit_id' LIMIT 1");
    if ($check_lease->num_rows > 0) {
        echo 2; // Lease already exists
        exit();
    }

    // Insert the new lease if no existing lease is found
    $stmt = $conn->prepare("INSERT INTO leases (building_id, unit_id, tenant_id, rent_amount, start_date, due_on, deposit_amount, processing_fee, service_fee, garbage_fee, water_fee, late_fee, invoice_day, tenant_signature, landlord_signature, terms, monthly_total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiissidddddddsssd", $building_id, $unit_id, $tenant_id, $rent_amount, $start_date, $due_on, $deposit_amount, $processing_fee, $service_fee, $garbage_fee, $water_fee, $late_fee, $invoice_day, $tenant_signature, $landlord_signature, $terms, $monthly_total);

    if ($stmt->execute()) {
        echo "1"; // Lease successfully saved
    } else {
        echo "3"; // Failed to save lease
    }
}




if (isset($_GET['action']) && $_GET['action'] == 'delete_tenant') {
    $id = $conn->real_escape_string($_GET['id']);

    // Delete the client from the database
    $sql = "DELETE FROM leases WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo 1; // Client deleted successfully
    } else {
        echo 0; // Failed to delete the client
    }
    exit();
}



ob_end_flush();
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $_SESSION['system']['name'] ?></title>
 	

<?php include('./header.php'); ?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>

</head>
<style>
	.field-icon {
 position: absolute;
    top: 18px;
        right: 30px;
        font-size: 20px;
        z-index: 2;
}
	body{
/*		width: 100%;
	    height: calc(100%);
	    background: #007bff;
	}
	main#main{
		width:100%;
		height: calc(100%);
		background:white;
	}
	#login-right{
		position: absolute;
		right:0;
		width:40%;
		height: calc(100%);
		background:white;
		display: flex;
		align-items: center;
	}
	#login-left{
		position: absolute;
		left:0;
		width:60%;
		height: calc(100%);
		background:#59b6ec61;
		display: flex;
		align-items: center;
		background: url(assets/uploads/blood-cells.jpg);
	    background-repeat: no-repeat;
	    background-size: cover;
	}
	#login-right .card{
		margin: auto;
		z-index: 1
	}
	.logo {
    margin: auto;
    font-size: 8rem;
    background: white;
    padding: .5em 0.7em;
    border-radius: 50% 50%;
    color: #000000b3;
    z-index: 10;
}
div#login-right::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: calc(100%);
    height: calc(100%);
    background: #000000e0;
}*/

</style>

<body>


  <main id="main" class="row bg-white">
  	<div class="col-md-6 p-0">
  		<div id="login-left" class="bg-white">
  			<img src="assets/img/login.png" width="100%" class="vh-100">
  		</div>
  	</div>
  	<div class="col-md-6">
  		<div class="text-center mb-5 pt-5">
         <a href="index.php" class="logo logo-admin"><img src="assets/img/logo.png" alt="logo" width="250px"></a>
      </div>
  		<div id="login-right" class="bg-white">
  			<div class="w-100">
			<h4 class="text-dark text-center"><b><?php echo $_SESSION['system']['name'] ?></b></h4>
			
  			<div class="card border-0 col-md-8 mx-auto">
  				<div class="card-body">
  					<form id="login-form" >
  						<div class="form-group">
  							<label for="username" class="control-label">Username</label>
  							<input type="text" id="username" name="username" class="form-control" placeholder="Username">
  						</div>
  						<div class="form-group">
  							<label class="control-label">Password</label>
  							<input type="password" id="password-field" name="password" class="form-control" placeholder="Password">
  							<!-- <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span> -->
  						</div>
  						<div class="g-recaptcha pb-3 mt-3" data-sitekey=""></div>
  						<center><button class="btn btn-primary btn-block waves-effect waves-light py-2 btn-1">Login</button></center>
  					</form>
  				</div>
  			</div>
  			</div>
  		</div>
   </div>

  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script src="https://www.google.com/recaptcha/api.js" async defer></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				if(resp == 1){
					location.href ='index.php?page=home';
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>	

<script>
$(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
  </script>
</html>
