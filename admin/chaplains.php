<?php include "includes/header.php";

$today = date('Y-m-d');
$query = mysqli_query(
    $con,
    "SELECT *
     FROM chaplains
     WHERE status <> 'deleted'"
);


$totalChaplainQuery = mysqli_query(
    $con,
    "SELECT COUNT(*) AS total 
     FROM chaplains
     WHERE status <> 'deleted'"
);

$totalChaplain = mysqli_fetch_assoc($totalChaplainQuery)['total'];

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
                            <h4 class="mb-0">Chaplain Coaching</h4>
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
                                        <h3 class="mb-1"><?php echo $totalChaplain;?></h3>
                                        <p class="text-muted mb-0">Total Chaplains</p>
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
                            <h4>Chaplains</h4>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive custom-scrollbar">
                            <table class=" table" id="last-orders">
                                <div class="mt-3 align-item-right d-flex">
                                    <button class="btn btn-primary btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addChaplainModal">
                                        + Add Chaplain
                                    </button>
                                </div>
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Password</th>
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
                                                        <h4><?php echo $row['name'];?></h4>
                                                    </a>
                                                    <!-- <span>Switzerland</span> -->
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo $row['email'];?></td>
                                        <td><?php echo $row['phone'];?></td>
                                        <td><?php echo $row['password'];?></td>
                                        <td>
                                            <a href="javascript:void(0)"
                                                class="text-primary me-2 edit-chaplain-btn"
                                                data-id="<?= $row['id']; ?>"
                                                data-name="<?= htmlspecialchars($row['name']); ?>"
                                                data-email="<?= $row['email']; ?>"
                                                data-phone="<?= $row['phone']; ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editChaplainModal">
                                                Edit
                                            </a>

                                            <a href="javascript:void(0)"
                                                class="text-danger delete-chaplain-btn"
                                                data-id="<?= $row['id']; ?>">
                                                Delete
                                            </a>

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

<!-- Add Chaplain Modal -->
<div class="modal fade" id="addChaplainModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add New Chaplain</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="php/add_chaplain.php" method="POST">
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Save Chaplain
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


<!-- Edit Chaplain Modal -->
<div class="modal fade" id="editChaplainModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Chaplain</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="php/edit_chaplain.php" method="POST">
                <input type="hidden" name="id" id="edit-id">

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" id="edit-name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="edit-email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" id="edit-phone" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


<script>
document.querySelectorAll('.edit-chaplain-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById('edit-id').value = btn.dataset.id;
        document.getElementById('edit-name').value = btn.dataset.name;
        document.getElementById('edit-email').value = btn.dataset.email;
        document.getElementById('edit-phone').value = btn.dataset.phone;
    });
});
</script>

<script>
document.querySelectorAll('.delete-chaplain-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        if (confirm('Are you sure you want to delete this chaplain?')) {
            window.location.href = 'php/delete_chaplain.php?id=' + btn.dataset.id;
        }
    });
});
</script>
