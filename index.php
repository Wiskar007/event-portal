<?php
$title = 'Welcome to Lion Portal';
include('includes/header.php'); ?>
<main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-100" style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto dynamic">
            <?php if(isset($_SESSION['error'])){
                echo " <div class='alert alert-danger mb-5' role='alert'>
                ".$_SESSION['error']."
                </div>";
            }
            unset($_SESSION['error']);
         ?>
         <div id="result"></div>
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Sign in</h4>
                </div>
              </div>
              <div class="card-body">
                <form role="form" class="text-start" method="post" id="signin" autocomplete="off">
                  <div class="input-group input-group-outline my-3 uname">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" id="uname" name="uname" required="required">
                  </div>
                  <div class="input-group input-group-outline mb-3 password">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="passwprd" required="required">
                  </div>
                  <div class="form-check form-switch d-flex align-items-center mb-3">
                    <input class="form-check-input" type="checkbox" id="rememberMe" checked>
                    <label class="form-check-label mb-0 ms-3" for="rememberMe">Remember me</label>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Sign in</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php include('includes/footer.php'); ?>
    </div>
  </main>  
</body>

</html>