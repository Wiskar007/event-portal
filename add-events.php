<?php 
$title = 'Add Events';
include('includes/header.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<body class="g-sidenav-show  bg-gray-200">
  <?php 
  include('includes/sidebar.php');
  include('includes/functions.php');

 
    if(isset($_POST['submit']) && !empty($_POST)){
       
    $ename = mysqli_real_escape_string($db, $_POST['ename']);
    $edate = mysqli_real_escape_string($db, $_POST['edate']);
    $etime1 = mysqli_real_escape_string($db, $_POST['etime1']);
    $etime2 = mysqli_real_escape_string($db, $_POST['etime2']);
    $edetails = mysqli_real_escape_string($db, $_POST['edetails']);
    $eagenda = mysqli_real_escape_string($db, $_POST['eagenda']);
    $evenue = mysqli_real_escape_string($db, $_POST['evenue']);

    

    if(empty($ename) || empty($edate) ||  empty($etime1) || empty($etime2)){
      $_SESSION['error'] = 'Please fill all fields';
    }else{
        if (isset($_POST['membership_type']) && !empty($_POST['membership_type'])) {
            $membership_types = $_POST['membership_type'];
            foreach ($membership_types as &$membership_type) {
                $membership_type = mysqli_real_escape_string($db, $membership_type);

            }
            $insert_data = [
                "event_name" =>  $ename,
                "event_date" => $edate,
                "event_start_time" => $etime1,
                "event_end_time" => $etime2,
                "event_venue" => $evenue,
                "event_details" => $edetails,
                "event_agenda"=>$eagenda
                
                ];
        
                $tableName = 'events';
                $insert = insertData($tableName, $insert_data ,$db);
        
                if ($insert !== false) {

                    $membershipTypeTableName = 'event_membership';

                    foreach ($membership_types as $membership_type) {
                        $membership_type_insert_data = [
                            "event_id" =>$insert,
                            "membership_type" => $membership_type,
                            // Include any other fields you want to insert
                        ];
                        $membershipTypeInsert = insertData($membershipTypeTableName, $membership_type_insert_data, $db);
                        
                        if ($membershipTypeInsert === false) {
                            // Handle insertion failure for individual designation
                            $_SESSION['error'] = 'Failed to insert designation: ' . $membership_type;
                            // You can choose to break out of the loop or continue
                        }else{
                            $_SESSION['success'] = 'Events Added Successfully';
                        }
                    }
                   
                  
                 
                        
                    } else {
                  $_SESSION['error'] = 'Something went wrong Please try again';
                  
                    }
            
        } else {
            // Handle the case where no designation is selected
            $_SESSION['error'] = 'Please select at least one designation.';
            
        }
     
      
          
    }

    
  }

  ?>
  
  
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <?php
    include('includes/nav.php'); 
    ?>
	<div class="container-fluid py-4">
    <div class="row justify-content-center">
    <div class="col-lg-4 col-md-6">
    <?php if(isset($_SESSION['error'])){
                echo " <div class='alert alert-danger mb-5' role='alert'>
                ".$_SESSION['error']."
                </div>";
            }
            unset($_SESSION['error']);
         ?>

 <?php if(isset($_SESSION['success'])){
                echo " <div class='alert alert-success mb-5' role='alert'>
                ".$_SESSION['success']."
                </div>";
            }
            unset($_SESSION['success']);
         ?> 
    <h4 class="text-center">Add New Events</h4>
        <div class="card">
            <div class="card-body">
                <form role="form" class="text-start" method="post" autocomplete="off">
                    <div class="input-group input-group-outline my-3 ">
                        <label class="form-label">Event Name</label>
                        <input type="text" class="form-control" id="ename" name="ename" required="required">
                    </div>
                    <div class="input-group input-group-outline my-3 ">
                        <label class="form-label">Event Date</label>
                        <input type="text" class="form-control" id="edate" name="edate" required="required">
                    </div>
                    <div class="input-group input-group-outline my-3 ">
                        <label class="form-label">Event Start Time</label>
                        <input type="text" class="form-control" id="etime1" name="etime1" required="required">
                    </div>
                    <div class="input-group input-group-outline my-3 ">
                        <label class="form-label">Event End Time Date</label>
                        <input type="text" class="form-control" id="etime2" name="etime2" required="required">
                    </div>
                    <div class="input-group input-group-outline mb-3 ">
                        <label class="form-label">Event Details</label>
                        <textarea name="edetails" id="edetails" placeholder="Enter your event details here..."></textarea>
                    </div>
                    <div class="input-group input-group-outline mb-3 ">
                        <label class="form-label">Event Agenda</label>
                        <textarea name="eagenda" id="eagenda" placeholder="Enter your agenda here..."></textarea>
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Event Venue</label>
                        <textarea name="evenue" rows="3" cols="50"></textarea>
                    </div>
                    <div class="input-group input-group-outline mb-3 ">
                        <label class="form-label">Membership Type</label>
                        <select class="form-control" multiple data-multi-select id="membership_type" name="membership_type" required="required">
                            
                            <?php 
                           $membership_types = fetchData('membership_types', '*', '',$db);
                           if(!empty($membership_types)){
                            foreach($membership_types as $membership_type){
                                echo '<option value="'.$membership_type['membership_type_id'].'">'.$membership_type['membership_type'].'</option>';
                            }
                           }
                            ?>
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2" name = "submit">Add Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

        
       
        
      </div>
      
      <?php
      include('includes/footer.php');
      ?>
    </div>
  </main>
  <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="material-icons py-2">settings</i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3">
        <div class="float-start">
          <h5 class="mt-3 mb-0">Material UI Configurator</h5>
          <p>See our dashboard options.</p>
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="material-icons">clear</i>
          </button>
        </div>
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0">
        <!-- Sidebar Backgrounds -->
        <div>
          <h6 class="mb-0">Sidebar Colors</h6>
        </div>
        <a href="javascript:void(0)" class="switch-trigger background-color">
          <div class="badge-colors my-2 text-start">
            <span class="badge filter bg-gradient-primary active" data-color="primary" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
          </div>
        </a>
        <!-- Sidenav Type -->
        <div class="mt-3">
          <h6 class="mb-0">Sidenav Type</h6>
          <p class="text-sm">Choose between 2 different sidenav types.</p>
        </div>
        <div class="d-flex">
          <button class="btn bg-gradient-dark px-3 mb-2 active" data-class="bg-gradient-dark" onclick="sidebarType(this)">Dark</button>
          <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent" onclick="sidebarType(this)">Transparent</button>
          <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
        </div>
        <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
        <!-- Navbar Fixed -->
        <div class="mt-3 d-flex">
          <h6 class="mb-0">Navbar Fixed</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
          </div>
        </div>
        <hr class="horizontal dark my-3">
        <div class="mt-2 d-flex">
          <h6 class="mb-0">Light / Dark</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
          </div>
        </div>
        <hr class="horizontal dark my-sm-4">
        <a class="btn bg-gradient-info w-100" href="https://www.creative-tim.com/product/material-dashboard-pro">Free Download</a>
        <a class="btn btn-outline-dark w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard">View documentation</a>
        <div class="w-100 text-center">
          <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star creativetimofficial/material-dashboard on GitHub">Star</a>
          <h6 class="mt-3">Thank you for sharing!</h6>
          <a href="https://twitter.com/intent/tweet?text=Check%20Material%20UI%20Dashboard%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fsoft-ui-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
          </a>
          <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/material-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
          </a>
        </div>
      </div>
    </div>
  </div>
</body>

</html>