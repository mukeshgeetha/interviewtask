<?php

include 'db.php';



?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Registration Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>

<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="index2.html"><b>Admin</b>LTE</a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form id="registerform" method="post" autocomplete="off">
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="name" name="name" placeholder="Full name" onfocusout="name_focusout();">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div id="mobilediv" class="input-group mb-3">
          <input type="text" class="form-control"  id="mobile" name="mobile"  placeholder="Mobile">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-mobile-alt"></span>
            </div>
          </div>
        </div>
        <div class="errmsg" style="display: none;">
          <span style="color: red;font-size:13px;margin-left:10px;">Invalid mobile number. Please enter a 10-digit number.</span>
        </div>
        <div id="emaildiv" class="input-group mb-3">
          <input type="email" class="form-control" id="email" name="email" placeholder="Email">
         
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="e_errmsg" style="display: none;">
          <span style="color: red;font-size:13px;margin-left:10px;">Valid email address </span>
        </div>
        
        
        <div class="input-group mb-3">
          <input type="date" class="form-control" id="dob" name="dob">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="far fa-calendar"></span>
            </div>
          </div>
        </div>
        <!-- is-invalid -->
     

        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="button" style="width: 100px;" id="registerdata" class="btn btn-primary btn-block"><i id="spin"></i><b>Register</b></button>
            <button type="button" style="width: 100px;display:none;" id="registerdata1" class="btn btn-primary btn-block"><b><i class="fas fa-check-circle"></i>
</b></button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>
          Sign up using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i>
          Sign up using Google+
        </a>
      </div>

      <a href="login.php" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script>
  
    function validateMobile(mobile) {      
      var mobilePattern = /^\d{10}$/;
      return mobilePattern.test(mobile);
      }
</script>
<script>
    $(document).on('click','#registerdata',function(){
        
        var action = 'Register';
        if(data >= 1){
          Swal.fire('Email is Already Exist');
        }
        // else if(!validateMobile($('#mobile').val().trim())){
        //   Swal.fire('Invalid mobile number. Please enter a 10-digit number.');
        // }
        else{
          $(this).html('<i class="fa fa-spinner fa-spin"></i>');
          $.ajax({
            
        url: "<?php echo __ROOT__ ?>",
        method: "POST",
        data: $('#registerform').serialize()+"&action="+action,
        success:function(res){
            $('#registerdata').hide();
            $('#registerdata1').show();

            $('#registerdata1').attr('class','btn btn-primary btn-block disable');
             $('#name').val('');
             $('#email').val('');
             $('#mobile').val('');
             $('#dob').val('');
            Swal.fire({
    title: 'Registered',
    text: "Password genrated link send to your email Pls check...!",
    icon: 'success', // 'success', 'error', 'warning', 'info', etc.
    confirmButtonText: 'OK',
    confirmButtonColor: '#3085d6',
});

      
            console.log(res);
        }
       })
        }



      
    })
</script>

<script>
  
  function name_focusout(){
    var name = $('#name').val();
    if(name==''){
      $('#name').attr('class','form-control is-invalid');
    }else{
      $('#name').attr('class','form-control is-valid');
    }
  }
</script>


<script>
    $(document).on('keyup','#email',function(){
       var email = $(this).val();
       $.ajax({
            
            url: "<?php echo __ROOT__ ?>",
            method: "POST",
            data: {email,action:"validate_email"},
            success:function(res){
              var data = JSON.parse(res);
              getResponse(data)
                console.log(res);
            }
           })
    })
</script>

<script>
    $(document).on('focusout','#email',function(){
       var email = $(this).val();
       
       if(email==''){
        $('#emaildiv').attr('class','input-group mb-3');
        $('.e_errmsg').css('display','none');
        $('#email').attr('class','form-control');
       }
      else if(!isValidEmail(email)){
        $('#emaildiv').attr('class','input-group');
         $('.e_errmsg').css('display','block');
         $('#email').attr('class','form-control is-invalid');
       }else{
        $('#emaildiv').attr('class','input-group mb-3');
        $('.e_errmsg').css('display','none');
        $('#email').attr('class','form-control is-valid');
       }
    })
</script>

<script>
    $(document).on('keyup','#mobile',function(){
       var mobile = $(this).val();
       console.log(mobile);
       if(mobile==''){
        $('#mobilediv').attr('class','input-group mb-3');
        $('.errmsg').css('display','none');
        $('#mobile').attr('class','form-control');
       }
      else if(!validateMobile(mobile)){
        $('#mobilediv').attr('class','input-group');
         $('.errmsg').css('display','block');
         $('#mobile').attr('class','form-control is-invalid');
       }else{
        $('#mobilediv').attr('class','input-group mb-3');
        $('.errmsg').css('display','none');
        $('#mobile').attr('class','form-control is-valid');
       }
    })
</script>

<script>
  console.log("alone"+data);
</script>

<script>
   var data;
   var response;
function getResponse(response) {
    data = response;
    return data;
}
</script>

<script> 
  function isValidEmail(email) {
        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        return emailPattern.test(email);
    }
</script>



<script>
    $(document).ready( function() {
    $.getJSON("http://ip-api.io/api/json",
        function(data){
            console.log(data);
        }
    );
});
</script>
</body>
</html>
