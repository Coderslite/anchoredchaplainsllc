<?php 
include "includes/header.php";
@$from = $_GET['from'];
?>
<!-- Content Area
================= -->
<main class="fix">

    <!-- Page Header Banner
    ======================= -->
    <section class="page-header" data-background="assets/images/home1/hero-bg-1.png">
        <div class="container">
            <div class="row">
                <h1 class="mb-2 text-white">Authentication</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Authentication</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <div class="col-md-8 m-4 mx-auto">
        <form action="">
            <div class="form-group">
                <label for="" class="mb-2">Enter Security PIN</label>
                <input type="text" name="" class="form-control" id="">
            </div>
            <button class="btn btn-primary btn-block mt-3">Proceed</button>
        </form>
    </div>
</main>
<?php include "includes/footer.php"?>