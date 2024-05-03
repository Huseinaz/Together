<?php

require_once "connection.php";

session_start(); 

if ($_SESSION['loggedin'] != true)
{ 
header("Location: login.php");
} 

if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
  $id = $_POST['user_id'];
  if (isset($_POST['block'])) {
    $status = 'Blocked';
  } else {
    $status = 'Active';
  }

  $userUpdate="UPDATE users set status='$status' WHERE userID='$id'";
  if (mysqli_query($conn, $userUpdate)) {
    $_SESSION["success"] = "User status updated Successfully!";
  } else {
    $_SESSION["error"] = "Sorry, request failed!";
  }
}

$users = "SELECT * FROM users WHERE `roleID` != 1";
$result = mysqli_query($conn, $users);
$rows = array();
while($row = mysqli_fetch_assoc($result))
$rows[] = $row;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Together | UsersTables</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="shortcut icon" type="image/x-icon" href="assets/images/together.jpg">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link">
      <center><span class="brand-text font-weight-light">Together Admin</span></center>
    </a>

    <!-- Sidebar -->
    <!-- style="background-color: #FF324D;" -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">Hussein Abou Zeinab</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
               </p>
            </a>
          </li>
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Tables
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="usersTable.php" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Users Table</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="casesTable.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cases Table</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="takedTable.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Taken Cases Table</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Log out
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php if(isset($_SESSION["success"])) { ?>
      <div id="alert" class="alert alert-success" role="alert">
          <?php echo $_SESSION["success"] ?>
      </div>
      <?php } ?>
      <?php if(isset($_SESSION["error"])) { ?>
      <div id="alert" class="alert alert-danger" role="alert">
          <?php echo $_SESSION["error"]; ?>
      </div>
      <?php } ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users Table</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>User name</th>
                    <th>Phone number</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($rows as $key => $item) { ?>
                  <tr>
                    <td><?php echo ++$key ?></td>
                    <td><?php echo $item['name'] ?></td>
                    <td><?php echo $item['phoneNumber'] ?></td>
                    <td><?php echo $item['email'] ?></td>
                    <td><?php echo $item['address'] ?></td>
                    <td>
                      <?php if($item['status'] == 'Blocked') { ?>
                        <span class="badge badge-secondary">
                          <?php echo $item['status'] ?>
                        </span> 
                      <?php } elseif($item['status'] == 'Active') { ?>
                        <span class="badge badge-success">
                          <?php echo $item['status'] ?>
                        </span> 
                      <?php } else { ?>
                        <span class="badge badge-warning text-white">
                          <?php echo $item['status'] ?>
                        </span> 
                      <?php } ?>
                    </td>
                    <td>
                      <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" name="blockForm" method="POST">
                        <input type="hidden" name="user_id" value="<?php echo $item['userID'] ?>">
                        <?php if($item['status'] == 'Blocked') { ?>
                          <button type="submit" name="unblock" class="btn btn-sm btn-primary">UnBlock</button>
                        <?php } else { ?>
                          <button type="submit" name="block" class="btn btn-sm btn-secondary">Block</button>
                        <?php } ?>
                      </form>
                      
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <center>
  <footer class="main-footer">
    <strong>Copyright &copy; 2022 Hussein Abou Zeinab.</strong> All rights reserved.
  </footer>
  </center>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="dist/js/demo.js"></script> -->
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

<script>
    $("#alert").fadeTo(8000, 500).slideUp(500, function(){
        $("#alert").slideUp(500);
    });
</script>

<?php
    unset($_SESSION["success"]);
    unset($_SESSION["error"]);
    mysqli_close($conn);
?>

</body>
</html>
