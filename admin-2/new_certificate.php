<?php include "includes/header.php";?>
<div class="content-page">
          <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">
                    <h1>Create New Certificate</h1>
                    <form action="php/new_certificate.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group mb-3">
                            <label for="">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="file">File</label>
                            <input type="file" class="form-control" name="file" id="file" accept="application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                        </div>
                        <button class="btn btn-primary mt-3">Submit</button>
                    </form>
                <div>
            <div>
<div>

<?php include "includes/footer.php";?>
