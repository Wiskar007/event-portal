<?php
$title = 'Dashboard';
include('includes/header.php')
?>

<body class="g-sidenav-show  bg-gray-200">
  <?php
  include('includes/sidebar.php');
  ?>


  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <?php
    include('includes/nav.php');
    ?>
    <div class="container-fluid py-4">
      <div class="row justify-content-center">
        <div class="card my-4">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
              <h6 class="text-white text-capitalize ps-3">Get Report</h6>
            </div>
            <div class="card-body">
              <form role="form" class="text-start" method="post" autocomplete="off">
                <div class="row align-items-center">
                  <div class="col-lg-2">
                    <div class="input-group input-group-outline my-3 ">
                      <label class="form-label">Select Employee</label>
                      <select class="form-control" placeholder="Select Employee" name="membership_type" required="required">
                        <option value="Test">Select Employee...</option>
                        <option value="Test">Test</option>
                        <option value="Test">Test</option>
                        <option value="Test">Test</option>
                        <option value="Test">Test</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="input-group input-group-outline my-3 ">
                      <label class="form-label">Select Project</label>
                      <select class="form-control" placeholder="Select Project" name="membership_type" required="required">
                        <option value="Test">Select Project...</option>
                        <option value="Test">Test</option>
                        <option value="Test">Test</option>
                        <option value="Test">Test</option>
                        <option value="Test">Test</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="input-group input-group-outline my-3 ">
                      <label class="form-label">Start Date</label>
                      <input type="date" class="form-control" placeholder="Start Date" name="date" required="required">
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="input-group input-group-outline my-3 ">
                      <label class="form-label">End Date</label>
                      <input type="date" class="form-control" placeholder="End Start" name="edate" required="required">
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="input-group input-group-outline my-3 ">
                      <label class="form-label">Select Entry Category</label>
                      <select class="form-control" placeholder="Select  Entry Category" name="membership_type" required="required">
                        <option value="Test">Select Entry Category...</option>
                        <option value="Test">Test</option>
                        <option value="Test">Test</option>
                        <option value="Test">Test</option>
                        <option value="Test">Test</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-primary w-100 m-0" name="submit">Get Report</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid py-4">
      <div class="row justify-content-center">
        <div class="card my-4">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
              <h6 class="text-white text-capitalize ps-3">Table Name</h6>
            </div>
          </div>

          <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sr No</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Event Name</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Event Date </th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Event Start On</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div>
                          1
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <!-- <h6 class="mb-0 text-sm">John Michael</h6>
                            <p class="text-xs text-secondary mb-0">john@creative-tim.com</p> -->
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">event_name</p>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="text-xs font-weight-bold mb-0">event_date</span>
                    </td>
                    <td class="align-middle text-center">
                      <span class="text-secondary text-xs font-weight-bold">event_start_time</span>
                    </td>
                    <td class="align-middle text-center">
                      <a href="event-view.php" class="text-secondary font-weight-bold text-xs"> Edit
                      </a> |
                      <a href="javascript:;" class="text-secondary font-weight-bold text-xs">
                        Delete
                      </a>
                    </td>

                  </tr>

                </tbody>
              </table>
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

</body>

</html>