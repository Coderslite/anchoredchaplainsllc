<?php include "includes/header.php";
include "php/db_config.php";

$bookQuery = mysqli_query($con,"SELECT * FROM books");
$books = mysqli_num_rows($bookQuery);

?>

		<!-- ============================================================== -->
		<!-- Start Page Content here -->
		<!-- ============================================================== -->

		<div class="content-page">
			<div class="content">

				<!-- Start Content-->
				<div class="container-fluid">

					<div class="row">
						<div class="col-xl-4">
							<div class="card overflow-hidden border-top-0">
								<div class="progress progress-sm rounded-0 bg-light" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100">
									<div class="progress-bar bg-primary" style="width: 90%"></div>
								</div>
								<div class="card-body">
									<div class="d-flex align-items-center justify-content-between">
										<div class="">
											<p class="text-muted fw-semibold fs-16 mb-1">Books</p>
											<p class="text-muted mb-4">
												Total numbers of book
											</p>
										</div>
									</div>
									<div class="d-flex flex-wrap flex-lg-nowrap justify-content-between align-items-end">
										<h3 class="mb-0 d-flex"><?php echo $books; ?> </h3>
									</div>
								</div><!-- end card-body -->
							</div><!-- end card -->
						</div><!-- end col -->

					</div><!-- end row -->

				</div>
				<!-- end container -->



			</div>
			<!-- content -->
		</div>

		<!-- ============================================================== -->
		<!-- End Page content -->
		<!-- ============================================================== -->

		<?php include "includes/footer.php";?>
