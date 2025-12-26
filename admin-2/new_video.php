<?php include "includes/header.php";?>
<div class="content-page">
          <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">
                    <h1>Create New Video</h1>
                    <form action="php/new_video.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group mb-3">
                            <label for="">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">URL</label>
                            <input type="text" name="url" class="form-control" required>
                        </div>
                        <button class="btn btn-primary mt-3">Submit</button>
                    </form>
                <div>
            <div>
<div>

<?php include "includes/footer.php";?>
