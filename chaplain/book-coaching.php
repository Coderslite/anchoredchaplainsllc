<?php include "includes/header.php";

$today = date('Y-m-d');
$query = mysqli_query(
    $con,
    "SELECT *
     FROM clients 
     WHERE program_applied = 'Book Coaching' AND assigned_chaplain = '$chaplainId' AND status <> 'deleted'"
);


$totalClientsQuery = mysqli_query(
    $con,
    "SELECT COUNT(*) AS total 
     FROM clients 
     WHERE program_applied = 'Book Coaching' AND status <> 'deleted' AND assigned_chaplain = '$chaplainId' "
);

$totalClients = mysqli_fetch_assoc($totalClientsQuery)['total'];


$expiredRenewalQuery = mysqli_query(
    $con,
    "SELECT COUNT(*) AS expired 
     FROM clients 
     WHERE program_applied = 'Book Coaching'
     AND assigned_chaplain = '$chaplainId' 
     AND approved_date IS NOT NULL
     AND status <> 'deleted'
     AND (
         renewed_date IS NULL 
         OR renewed_date < '$today'
     )"
);

$expiredRenewals = mysqli_fetch_assoc($expiredRenewalQuery)['expired'];

?>

<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid default-dashboard py-5">
        <div class="row">
            <!-- Recent Activity Card (Redesigned) -->
            <div class="col-xl-12 box-col-5 col-md-12 proorder-md-2 mb-4">
                <div class="card h-100">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Book Coaching</h4>
                            <p class="text-muted mb-0">Active clients and engagement</p>
                        </div>
                        <div class="dropdown icon-dropdown setting-menu">
                            <button class="btn dropdown-toggle" id="userdropdown1" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <svg>
                                    <use href="assets/svg/icon-sprite.svg#setting"></use>
                                </svg>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown1">
                                <a class="dropdown-item" href="#">Weekly</a>
                                <a class="dropdown-item" href="#">Monthly</a>
                                <a class="dropdown-item" href="#">Yearly</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Stats Section -->
                        <div class="stats-section mb-4">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="stat-card bg-light-primary rounded p-3 text-center">
                                        <div class="stat-icon mb-2">
                                            <svg width="24" height="24" class="text-primary">
                                                <use href="assets/svg/icon-sprite.svg#user"></use>
                                            </svg>
                                        </div>
                                        <h3 class="mb-1"><?php echo $totalClients;?></h3>
                                        <p class="text-muted mb-0">Total Clients</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-card bg-light-danger rounded p-3 text-center">
                                        <div class="stat-icon mb-2">
                                            <svg width="24" height="24" class="text-danger">
                                                <use href="assets/svg/icon-sprite.svg#activity"></use>
                                            </svg>
                                        </div>
                                        <h3 class="mb-1"><?php echo $expiredRenewals; ?></h3>
                                        <p class="text-muted mb-0">Expired Renewal</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


              <!-- Recent Registration Table -->
            <div class="col-xl-12 col-md-12 box-col-12 proorder-md-4">
                <div class="card">
                    <div class="card-header card-no-border">
                        <div class="header-top">
                            <h4>Book Coaching Registration</h4>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive custom-scrollbar">
                            <table class=" table" id="last-orders">
                                <div class="mt-3 align-item-right d-flex">
                                    <!-- <button class="btn btn-primary btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addClientModal">
                                        + Add Client
                                    </button> -->
                                </div>
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Applied Date</th>
                                        <th>Approve Date</th>
                                        <th>Renewed Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $count = 0;
                                    while($row = mysqli_fetch_assoc($query)){
                                        $count+1;
                                        ?>
                                    <!-- Table rows remain the same -->
                                    <tr>
                                        <td>
                                            <div class="flex">
                                                <!-- <div><img src="assets/images/dashboard/avtar/2.jpg" alt="avatar" class="rounded-circle"></div> -->
                                                <div>
                                                    <a>
                                                        <h4><?php echo $row['fullname'];?></h4>
                                                    </a>
                                                    <!-- <span>Switzerland</span> -->
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo $row['email'];?></td>
                                        <td><?php echo $row['phone'];?></td>
                                        <td><?php echo $row['applied_date'];?></td>
                                        <td><?php echo $row['approved_date'];?></td>
                                        <td><?php echo $row['renewed_date'];?></td>
                                        <td>
                                           <div class="d-flex gap-2">
                                                <a class="btn btn-success" href="view-client.php?id=<?php echo $row['id'];?>">View</a>
                                                <a href="javascript:void(0)"
                                                    class="btn btn-danger delete-client-btn"
                                                    data-id="<?= $row['id']; ?>">
                                                    Delete
                                                </a>
                                           </div>
                                        </td>
                                    </tr>
                                    <!-- Other table rows... -->
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>

<style>
/* Custom styles for the redesigned cards */
.stat-card {
    transition: transform 0.3s ease;
    border: 1px solid transparent;
}

.stat-card:hover {
    transform: translateY(-2px);
    border-color: var(--bs-primary);
}

.stat-icon {
    width: 40px;
    height: 40px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
}

.stat-card h3 {
    font-weight: 700;
    color: var(--bs-dark);
}

.activity-item {
    padding: 8px;
    border-radius: 8px;
    transition: background-color 0.2s ease;
}

.activity-item:hover {
    background-color: var(--bs-light);
}

.activity-icon {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.bg-light-primary { background-color: rgba(var(--bs-primary-rgb), 0.1) !important; }
.bg-light-success { background-color: rgba(var(--bs-success-rgb), 0.1) !important; }
.bg-light-info { background-color: rgba(var(--bs-info-rgb), 0.1) !important; }
.bg-light-warning { background-color: rgba(var(--bs-warning-rgb), 0.1) !important; }
.bg-light-pink { background-color: rgba(255, 107, 159, 0.1) !important; }
.bg-light-orange { background-color: rgba(255, 159, 67, 0.1) !important; }

.text-pink { color: #ff6b9f !important; }
.text-orange { color: #ff9f43 !important; }

.card {
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    border: 1px solid #f0f0f0;
}

.card-header {
    background: transparent;
    border-bottom: 1px solid #f0f0f0;
}
</style>

<?php include "includes/footer.php";?>

<!-- Add New Client Modal -->
<div class="modal fade" id="addClientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title">Add New Book Coaching Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <form action="php/add_client.php" method="POST">
                <div class="modal-body">

                    <input type="hidden" name="program_applied" value="Book Coaching">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="fullname" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Applied Date</label>
                            <input type="date" name="applied_date" class="form-control"
                                   value="<?= date('Y-m-d') ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Approved Date</label>
                            <input type="date" name="approved_date" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Renewed Date</label>
                            <input type="date" name="renewed_date" class="form-control">
                        </div>

                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">Cancel</button>

                    <button type="submit" class="btn btn-primary">
                        Save Client
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


<script>
document.querySelectorAll('.delete-client-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        if (confirm('Are you sure you want to delete this client?')) {
            window.location.href = 'php/delete_client.php?id=' + btn.dataset.id+'&route=book-coaching';
        }
    });
});
</script>
