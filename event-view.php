<?php 
$title = 'Event View';
include('includes/header.php')
?>
<link href="assets/css/qr.css" rel="stylesheet" />
<body class="g-sidenav-show  bg-gray-200">
  <?php 
  include('includes/sidebar.php');
  include('includes/functions.php');
 ?>
  
  
  

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <?php
    include('includes/nav.php');
    if(!isset($_GET['event_id']) ||empty($_GET['event_id']) ||!isset($_GET['event_date']) ||empty($_GET['event_date'])){
      $_SESSION['error'] = 'Either event id or Event Date is not Provided';
      echo '<script>window.location.href="add-events.php"</script>';

    }else{
    $event_id = mysqli_real_escape_string($db,$_GET['event_id']);
    $event_date = mysqli_real_escape_string($db,$_GET['event_date']);
    
   


    $current_date = date('Y-m-d');
            $table_name = 'events';
            $column_names = '*'; 
            $where_condition = array('event_date'=>$current_date,'event_id'=>$event_id); 
            $result = fetchData($table_name, $column_names, $where_condition,$db);
           
            
            if(!empty($result)){
    ?>
	
  <div class="container-fluid py-4">
      
      <div class="row">
        <div class="col-md-7 mt-4">
          <div class="card">
            <div class="card-header pb-0 px-3">
              <h6 class="mb-0">Event Detail</h6>
            </div>
            <div class="card-body pt-4 p-3">
              <ul class="list-group">
                <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Event Name</label>
                <input readonly type="text" value="<?=ucfirst($result[0]['event_name'])?>"class="form-control form-control-lg input-bg" id="colFormLabelLg" placeholder="Event Name">
                </li>
                <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Event Date</label>
                <input readonly type="text" value="<?=date('j M y',strtotime($result[0]['event_date']))?>"class="form-control form-control-lg input-bg" id="colFormLabelLg" placeholder="Event Name">
                </li>
                <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Event Start On</label>
                <input readonly type="text" value="<?=date('g:i A', strtotime($result[0]['event_start_time']))?>"class="form-control form-control-lg input-bg" id="colFormLabelLg" placeholder="Event Name">
                </li>
                <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Event End On</label>
                <input readonly type="text" value="<?=date('g:i A', strtotime($result[0]['event_end_time']))?>" class="form-control form-control-lg input-bg" id="colFormLabelLg" placeholder="Event Name">
                </li>
                <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg text-area">
                <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Event Details</label>
                <textarea readonly id="edetails" placeholder="Enter your event details here..." class="form-control form-control-lg input-bg"><?=($result[0]['event_details'])?></textarea>
                </li>
                <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg text-area">
                <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Event Agenda</label>
                <textarea readonly id="eagenda" placeholder="Enter your agenda here..." class="form-control form-control-lg input-bg"><?=($result[0]['event_agenda'])?></textarea>
                </li>
                <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg text-area">
                <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Event Venue</label>
                <textarea readonly placeholder="Event Venue" rows="3" cols="50"  class="form-control input-bg"><?=($result[0]['event_venue'])?></textarea>
                </li>

                <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg text-area">
                <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Scan Qr</label>

                <div class="card w-100">
                <div class="card-body">
                <div class="section">
                <div id="my-qr-reader">
            </div>
              </div>
                  </div>
              </div>
        
                </li>
                <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Scanned Id</label>
                <input type="text"  class="form-control input-bg" id="scan_result">
                <button id="scanner">Register</button>
                <input type="hidden" readonly class="form-control input-bg" value="<?=($result[0]['event_id'])?>" id="event_id">
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-5 mt-4">
          <div class="card h-100 mb-4">
            <div class="card-header pb-0 px-3">
              <div class="row">
                <div class="col-md-6">
                  <h6 class="mb-0">Registerd Members</h6>
                </div>
                <?php 
                $table_name = 'members';
                $column_names = 'members.member_name,members.member_id';
                $where_condition = ['registrations.event_id' =>$result[0]['event_id']];
                $join_type = 'INNER';
                $join_table = 'registrations';
                $join_condition = 'members.member_id = registrations.member_id';
                
                $registerd_members = fetchData($table_name, $column_names, $where_condition, $db, $join_type, $join_table, $join_condition);
                if(!empty($registerd_members)){
                  echo "<ul>";
                  foreach($registerd_members as $registerd_member){
                ?>
               
                  <li style="list-style: none;font-weight: 600;"><?=$registerd_member['member_name']?></li>
                  
                <?php }
                echo "</ul>";
                }else{
                  ?>
                  <p>Members Not Registered Yet</p>
                  <?php } ?>
              </div>
              </div>
            </div>
           
          </div>
        </div>
      </div>
    </div>

  <?php 
            }else{
              $_SESSION['error'] = 'Event Data Not Found...';
              
            }

    }
  ?>
    
    </div>
      
      <?php
      include('includes/footer.php');
      ?>
      <script src="assets/js/qr.js"></script>
    </div>
  </main>
  
</body>

</html>