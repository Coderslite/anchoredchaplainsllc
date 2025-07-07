<?php include "includes/header.php";
$q = mysqli_query($con, "SELECT * FROM lock_content");
$row = mysqli_fetch_assoc($q);
?>
<div class="content-page">
          <div class="content">
                <!-- Start Content-->
                <div class="container-fluid mx-auto col-md-8">
                    <?php echo errorMessage(); echo successMessage();?>
                    <h1>Update PIN</h1>
                    <form action="php/update_pin.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group mb-3">
                            <label for="">Pin</label>
                            <input type="text" value="<?php echo $row['pin'] ?>" name="pin" class="form-control" required>
                        </div>
                        <button class="btn btn-primary mt-1">Update</button>
                    </form>
                <div>
            <div>
<div>

<?php include "includes/footer.php";?>
