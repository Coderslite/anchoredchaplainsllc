<?php 
include "includes/header.php";

// === Time Filter ===
$filter = $_GET['filter'] ?? 'month';

switch ($filter) {
    case 'day':
        $dateCondition = "DATE(created_at) = CURDATE()";
        break;
    case 'week':
        $dateCondition = "YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)";
        break;
    default:
        $dateCondition = "MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
        break;
}

// === Queries ===
$totalClients = mysqli_fetch_assoc(mysqli_query(
    $con,
    "SELECT COUNT(*) AS total FROM clients WHERE status <> 'deleted' AND $dateCondition"
))['total'];

$expiredClients = mysqli_fetch_assoc(mysqli_query(
    $con,
    "SELECT COUNT(*) AS total FROM clients 
     WHERE status <> 'deleted' 
       AND approved_date IS NOT NULL 
       AND (renewed_date IS NULL OR renewed_date < CURDATE()) 
       AND $dateCondition"
))['total'];

$totalChaplains = mysqli_fetch_assoc(mysqli_query(
    $con,
    "SELECT COUNT(*) AS total FROM chaplains WHERE status <> 'deleted'"))['total'];

$recentClients = mysqli_query(
    $con,
    "SELECT fullname, created_at 
     FROM clients 
     WHERE status <> 'deleted'
     ORDER BY created_at DESC 
     LIMIT 5"
);
?>

<div class="page-body">
    <div class="container-fluid py-5">

        <!-- Filter Buttons -->
        <div class="d-flex justify-content-end mb-4">
            <div class="btn-group">
                <a href="?filter=day" class="btn btn-outline-primary <?= $filter=='day'?'active':'' ?>">Day</a>
                <a href="?filter=week" class="btn btn-outline-primary <?= $filter=='week'?'active':'' ?>">Week</a>
                <a href="?filter=month" class="btn btn-outline-primary <?= $filter=='month'?'active':'' ?>">Month</a>
            </div>
        </div>

        <!-- KPI Cards -->
        <div class="row g-4 mb-4">

            <div class="col-md-4">
                <div class="card stat-card bg-light-primary text-center p-4">
                    <div class="stat-icon mb-2">
                        <svg width="26" height="26" class="text-primary">
                            <use href="assets/svg/icon-sprite.svg#user"></use>
                        </svg>
                    </div>
                    <h2><?= $totalClients ?></h2>
                    <p class="text-muted mb-0">Clients</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card bg-light-success text-center p-4">
                    <div class="stat-icon mb-2">
                        <svg width="26" height="26" class="text-success">
                            <use href="assets/svg/icon-sprite.svg#users"></use>
                        </svg>
                    </div>
                    <h2><?= $totalChaplains ?></h2>
                    <p class="text-muted mb-0">Chaplains</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card bg-light-danger text-center p-4">
                    <div class="stat-icon mb-2">
                        <svg width="26" height="26" class="text-danger">
                            <use href="assets/svg/icon-sprite.svg#alert-circle"></use>
                        </svg>
                    </div>
                    <h2><?= $expiredClients ?></h2>
                    <p class="text-muted mb-0">Expired Clients</p>
                </div>
            </div>

        </div>

        <!-- Recent Registrations -->
            <div class="col-xl-12 col-md-12 box-col-12 proorder-md-4">
                <div class="card">
                    <div class="card-header card-no-border">
                        <div class="header-top">
                            <h4>Recent Registration</h4>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive custom-scrollbar">
                            <table class=" table" id="last-orders">
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
                                    $query = mysqli_query($con,"SELECT * FROM clients WHERE status <> 'deleted' ORDER BY id DESC LIMIT 5");
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

<style>
.stat-card {
    transition: transform 0.3s ease;
    border: 1px solid transparent;
    border-radius: 12px;
}
.stat-card:hover {
    transform: translateY(-3px);
    border-color: var(--bs-primary);
}
.stat-icon {
    width: 40px;
    height: 40px;
    margin: 0 auto 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
}
</style>

<?php include "includes/footer.php"; ?>

<script>
document.querySelectorAll('.delete-client-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        if (confirm('Are you sure you want to delete this client?')) {
            window.location.href = 'php/delete_client.php?id=' + btn.dataset.id+'&route=chaplain-coaching';
        }
    });
});
</script>
