
  <?php  include './layouts/header.php';  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Simple Tables</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?=explode(".",basename($_SERVER['PHP_SELF']))[0]?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
   
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users List</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" id="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap" id="usertable">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>User</th>
                      <th>Email</th>
                      <th>Mobile</th>
                      <th>Location</th>
                      <th>Created At</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                   $fetchall = $db->query("SELECT * FROM users");
                   while($rowdata = $fetchall->fetch(PDO::FETCH_ASSOC)){
                    echo "<tr>
                    <td>".$rowdata['id']."</td>
                    <td>".$rowdata['name']."</td>
                    <td>".$rowdata['email']."</td>
                    <td><span class='tag tag-success'>".$rowdata['mobile']."</span></td>
                    <td><span class='tag tag-success'>".$rowdata['gio_location']."</span></td>
                    <td>".$rowdata['created_at']."</td>
                    <td><button class='edit-button' style='background-color: #3498db; color: #fff; border: none; padding: 5px 20px; font-size: 16px; cursor: pointer; border-radius: 5px; transition: background-color 0.3s ease, transform 0.3s ease;' data-toggle='modal' data-target='#modal-default' value='".$rowdata['id']."' id='editdata'>Edit</button>
                    &nbsp;
                    <button class='edit-button' style='background-color: #db1313; color: #fff; border: none; padding: 5px 20px; font-size: 16px; cursor: pointer; border-radius: 5px; transition: background-color 0.3s ease, transform 0.3s ease;' value='".$rowdata['id']."' id='deletedata'>Delete</button>
                    </td>
                  </tr>";
                   }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->

        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Update User</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form  id="updateform" method="POST">
          <input type="hidden" class="form-control" name='e_id' placeholder="Name" id="e_id">

        <div class="input-group mb-3">
          
          <input type="text" class="form-control" name='e_name' placeholder="Name" id="e_name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="e_email" placeholder="Email" id="e_email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="e_mobile" placeholder="Mobile" id="e_mobile">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-mobile-alt"></span>
            </div>
          </div>
        </div>
        <div class="row">

        </div>
      </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" id="closemodel" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" id="update" class="btn btn-primary">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
     


      
<?php  include './layouts/footer.php';  ?>
<script>

    $(document).on('click','#editdata',function(){
       var id = $(this).val();
       $.ajax({
            
            url: "<?php echo __ROOT__ ?>",
            method: "POST",
            data: {id,action:"fetch_edit_data"},
            success:function(res){
              var data = JSON.parse(res);
              $('#e_id').val(data.id);
               $('#e_name').val(data.name);
               $('#e_email').val(data.email);
               $('#e_mobile').val(data.mobile);
              
            }
           })
    });
</script>

<script>

    $(document).on('click','#update',function(){
       var id = $(this).val();
       $.ajax({
            
            url: "<?php echo __ROOT__ ?>",
            method: "POST",
            data: $('#updateform').serialize()+"&action=updateuser",
            success:function(res){
              console.log(res);
              var data = JSON.parse(res);
              if(data.trim()=='User Updates successfully...!'){
                swal.fire(data);
                $('#closemodel').click();
 
                setTimeout(function() {
                window.location.href = 'userlist.php'; // Replace with your desired URL
                }, 1500);

              }else{

              }
            }
           })
    });
</script>


<script>

    $(document).on('click','#deletedata',function(){
       var id = $(this).val();
       $.ajax({
            
            url: "<?php echo __ROOT__ ?>",
            method: "POST",
            data: {id,action:"deleteuser"},
            success:function(res){
              console.log(res);
              var data = JSON.parse(res);
              if(data=='Success'){
                swal.fire("User Successfully Delete....");
                setTimeout(function() {
                window.location.href = 'userlist.php'; // Replace with your desired URL
                }, 1500);
              }else{
                swal.fire("User Not Delete....");
              }
            }
           })
    });
</script>

<script>
  $(document).ready(function() {
    $('#table_search').on('keyup', function() {
        var searchText = $(this).val().toLowerCase(); // Get the search text and convert to lowercase
        $('#usertable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
        });
    });
});
</script>





