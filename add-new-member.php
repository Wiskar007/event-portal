<?php 
$title = 'Add Member';
include('includes/header.php')
?>
<body class="g-sidenav-show  bg-gray-200">
  <?php 
  include('includes/sidebar.php');
  include('includes/functions.php');

 
    if(isset($_POST['submit']) && !empty($_POST)){

    $mname = mysqli_real_escape_string($db, $_POST['mname']);
    $memail = mysqli_real_escape_string($db, $_POST['memail']);
    $designation = mysqli_real_escape_string($db, $_POST['designation']);
    $club = mysqli_real_escape_string($db, $_POST['club']);
    $blood_grp = mysqli_real_escape_string($db, $_POST['blood_grp']);
    $mobile = mysqli_real_escape_string($db, $_POST['mobile']);
    $em_contact = mysqli_real_escape_string($db, $_POST['em_contact']);
    $membership_type = mysqli_real_escape_string($db, $_POST['membership_type']);

    if(empty($mname) || empty($designation) ||  empty($designation) || empty($club) || empty($blood_grp) || empty($mobile) || empty($em_contact || $membership_type)){
      $_SESSION['error'] = 'Please fill all fields';
    }elseif (!filter_var($memail, FILTER_VALIDATE_EMAIL)) {
      $_SESSION['error'] = 'Please provide valid email format';
    }else{
      // check email is already exist or not
      $email_exist = fetchData('members', '*', ['email_id'=>$memail],$db);
      if(empty($email_exist)){
        $insert_data = [
          "member_name" => $mname,
          "club_name" => $club,
          "blood_group" => $blood_grp,
          "mobile_no" => $mobile,
          "em_contact" => $em_contact,
          "designation_id" => $designation,
          "email_id"=>$memail,
          "membership_type" => $membership_type,
          "member_id" => rand(1, 100)
          
          ];
  
          $tableName = 'members';
          $insert = insertData($tableName, $insert_data ,$db);
  
          if ($insert !== false) {
            $_SESSION['success'] = 'Members Inserted Successfully';
           
                  
              } else {
            $_SESSION['error'] = 'Something went wrong Please try again';
            
              }
      }else{
        $_SESSION['error'] = 'Email is already exist into system';
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
    <h4 class="text-center">Add New Members</h4>
        <div class="card">
            <div class="card-body">
                <form role="form" class="text-start" method="post" autocomplete="off">
                    <div class="input-group input-group-outline my-3 ">
                        <label class="form-label">Member Name</label>
                        <input type="text" class="form-control" id="mname" placeholder="Enter Member name" name="mname" required="required">
                    </div>
                    <div class="input-group input-group-outline my-3 ">
                        <label class="form-label">Member Email</label>
                        <input type="email" class="form-control" id="memail" placeholder="Enter email" name="memail" required="required">
                    </div>
                    <div class="input-group input-group-outline mb-3 ">
                        <label class="form-label">Designation</label>
                        <select class="form-control" id="designation" name="designation" placeholder="Enter Designation" required="required">
                            <option value=''>Please Select Designation</option>
                            <?php 
                           $designations = fetchData('designations', '*', '',$db);
                           if(!empty($designations)){
                            foreach($designations as $designation){
                                echo '<option value="'.$designation['designation_id'].'">'.$designation['designation'].'</option>';
                            }
                           }
                            ?>
                        </select>
                    </div>
                    <div class="input-group input-group-outline mb-3 ">
                        <label class="form-label">Club Name</label>
                        <select class="form-control" id="club" name="club" required="required" placeholder="Enter Club ">
                            <option value=''>Please Select Club Name</option>
                            <?php 
                           $clubs = fetchData('clubs', '*', '',$db);
                           if(!empty($clubs)){
                            foreach($clubs as $club){
                                echo '<option value="'.$club['club_id'].'">'.$club['club_name'].'</option>';
                            }
                           }
                            ?>
                        </select>
                    </div>
                    <div class="input-group input-group-outline mb-3 ">
                        <label class="form-label">Membership Type</label>
                        <select class="form-control" id="membership_type" name="membership_type" placeholder="Select membership type" required="required">
                            <option value=''>Please Select Membership Type</option>
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
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Blood Group</label>
                        <input type="text" class="form-control" id="blood_grp" name="blood_grp" required="required" placeholder="Enter Blood Group">
                    </div>
                    <div class="input-group input-group-outline my-3 uname">
                        <label class="form-label">Mobile No</label>
                        <input type="tel" class="form-control" id="mobile" name="mobile" required="required" placeholder="Enter Mobile">
                    </div>
                    <div class="input-group input-group-outline my-3 uname">
                        <label class="form-label">Emergency Contact No</label>
                        <input type="tel" class="form-control" id="em_contact" name="em_contact" required="required" placeholder="Enter Emergency Contact">
                    </div>
                   
                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2" name = "submit">Add Member</button>
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