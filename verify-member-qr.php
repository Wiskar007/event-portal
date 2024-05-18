<?php 
session_start();
include('includes/functions.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!empty($_POST)){
    $member_id = mysqli_real_escape_string($db, $_POST['member_id']);
    $event_id = mysqli_real_escape_string($db, $_POST['event_id']);

    if(empty($member_id) || empty($event_id)){
        echo 'Please provide all fields';
    }else{
        $where = [
            'member_id '=>$member_id
        ];

        $members = fetchData('members', '*', $where,$db);
        if(!empty($members)){
         $memeber_ship_type= $members[0]['membership_type'];
         // verify membership type is allow for provided event or not
         $event_memberships = fetchData('event_membership', '*', ['event_id'=>$event_id],$db);
         if(!empty($event_memberships)){
          $membership_array = array();
          foreach($event_memberships as $event_membership){
            $membership_array[]=$event_membership['membership_type'];
          }
          if(in_array($memeber_ship_type,$membership_array)){
            $today = date('y-m-d H:i:s');
            $insert_data= [
              'registration_date' => $today,
              'event_id' =>$event_id,
              '	member_id' =>$member_id
            ];

            $tableName = ' registrations';
            // fircst check if user is already registered

            $already_registered = fetchData($tableName, '*', ['member_id' =>$member_id,'event_id'=> $event_id], $db);
            if(empty($already_registered)){
              $event_register = insertData($tableName, $insert_data, $db);
              if ($event_register !== false) {
                echo 'Registartion Successfully... ';
              }else{
                echo 'Registartion Failed.. ';
              }

            }else{
              echo 'Sorry this Member is already Registered ';
            }
            

          }else{
            echo 'Sorry this event is not registerd for your membership type ';
          }

         }else{
          echo 'Sorry Event Id is not sechdule';
         }

        }else{
            echo 'Sorry your Member Id is not registered with system';
        }
    }

    }else{
    echo 'Something Went Wrong';
    }

    }else{
    $_SESSION['error'] = 'You are not allow to access';
    header('location:'.site_url);
}

?>