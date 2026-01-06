<?php 
include "includes/header.php";

// =====================
// Time Filter (DEFAULT = ALL)
// =====================
$filter = $_GET['filter'] ?? 'all';

switch ($filter) {
    case 'day':
        $dateCondition = "DATE(created_at) = CURDATE()";
        $groupBy = "HOUR(created_at)";
        $xAxisTitle = "Hour of Day";
        break;

    case 'week':
        $dateCondition = "YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)";
        $groupBy = "DATE(created_at)";
        $xAxisTitle = "Day of Week";
        break;

    case 'month':
        $dateCondition = "MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
        $groupBy = "DATE(created_at)";
        $xAxisTitle = "Date";
        break;

    case 'year':
        $dateCondition = "YEAR(created_at) = YEAR(CURDATE())";
        $groupBy = "MONTH(created_at)";
        $xAxisTitle = "Month";
        break;

    default: // ALL TIME
        $dateCondition = "1";
        $groupBy = "YEAR(created_at)";
        $xAxisTitle = "Year";
        break;
}

// =====================
// KPI QUERIES
// =====================
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
    "SELECT COUNT(*) AS total FROM chaplains WHERE status <> 'deleted'"
))['total'];

// =====================
// PROGRAM SETUP
// =====================
$programTypes = [
    'Life Coaching',
    'Chaplain Training',
    'Chaplain Coaching',
    'Business Coaching',
    'Book Coaching',
    'Affiliate Program'
];

$programColors = [
    'Life Coaching' => '#FF6384',
    'Chaplain Training' => '#36A2EB',
    'Chaplain Coaching' => '#FFCE56',
    'Business Coaching' => '#4BC0C0',
    'Book Coaching' => '#9966FF',
    'Affiliate Program' => '#FF9F40'
];

// =====================
// LINE / BAR DATA
// =====================
$programData = [];
foreach ($programTypes as $program) {
    $query = mysqli_query($con,
        "SELECT $groupBy AS date_group, COUNT(*) AS count
         FROM clients
         WHERE status <> 'deleted'
           AND program_applied = '$program'
           AND $dateCondition
         GROUP BY $groupBy
         ORDER BY date_group ASC"
    );

    while ($row = mysqli_fetch_assoc($query)) {
        $programData[$program][] = $row;
    }
}

// =====================
// PIE DATA
// =====================
$pieChartData = [];
foreach ($programTypes as $program) {
    $q = mysqli_query($con,
        "SELECT COUNT(*) AS total FROM clients
         WHERE status <> 'deleted'
           AND program_applied = '$program'
           AND $dateCondition"
    );
    $pieChartData[$program] = mysqli_fetch_assoc($q)['total'] ?? 0;
}

// =====================
// LABELS
// =====================
$labels = [];
$labelsQuery = mysqli_query($con,
    "SELECT $groupBy AS date_group
     FROM clients
     WHERE status <> 'deleted' AND $dateCondition
     GROUP BY $groupBy
     ORDER BY date_group ASC"
);

while ($row = mysqli_fetch_assoc($labelsQuery)) {
    switch ($filter) {
        case 'day':
            $labels[] = sprintf('%02d:00', $row['date_group']);
            break;
        case 'week':
            $labels[] = date('D', strtotime($row['date_group']));
            break;
        case 'month':
            $labels[] = date('M j', strtotime($row['date_group']));
            break;
        case 'year':
            $labels[] = date('M', mktime(0, 0, 0, $row['date_group'], 1));
            break;
        default:
            $labels[] = $row['date_group'];
    }
}

if (empty($labels)) {
    $labels = ['No Data'];
}
?>

<div class="page-body">
<div class="container-fluid py-5">

<!-- ===================== FILTER ===================== -->
<div class="d-flex justify-content-end mb-4">
    <div class="btn-group">
        <?php
        $filters = ['all'=>'All','day'=>'Day','week'=>'Week','month'=>'Month','year'=>'Year'];
        foreach ($filters as $key=>$label):
        ?>
        <a href="?filter=<?= $key ?>"
           class="btn btn-outline-primary <?= $filter==$key?'active':'' ?>">
            <?= $label ?>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- ===================== KPI ===================== -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card stat-card bg-light-primary text-center p-4">
            <h2><?= $totalClients ?></h2>
            <p class="mb-0 text-muted">Clients (<?= ucfirst($filter) ?>)</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card bg-light-success text-center p-4">
            <h2><?= $totalChaplains ?></h2>
            <p class="mb-0 text-muted">Total Chaplains</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card bg-light-danger text-center p-4">
            <h2><?= $expiredClients ?></h2>
            <p class="mb-0 text-muted">Expired Clients</p>
        </div>
    </div>
</div>

<!-- ===================== CHARTS ===================== -->
<div class="row mb-4">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <h5>Client Registration Trends</h5>
                <span><?= ucfirst($filter) ?> view</span>
            </div>
            <div class="card-body">
                <canvas id="programAnalyticsChart" height="350"></canvas>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <h5>Program Distribution</h5>
            </div>
            <div class="card-body">
                <canvas id="programDistributionChart" height="350"></canvas>
            </div>
        </div>
    </div>
</div>

</div>
</div>

<!-- ===================== CHART JS ===================== -->
<script>
const labels = <?= json_encode($labels) ?>;
const programData = <?= json_encode($programData) ?>;
const programColors = <?= json_encode($programColors) ?>;

const datasets = [];
Object.keys(programData).forEach(program => {
    const counts = labels.map(label => {
        const found = programData[program].find(p => p.date_group == label);
        return found ? parseInt(found.count) : 0;
    });

    datasets.push({
        label: program,
        data: counts,
        borderColor: programColors[program],
        backgroundColor: programColors[program] + '55',
        tension: 0.4,
        fill: true
    });
});

new Chart(document.getElementById('programAnalyticsChart'), {
    type: 'line',
    data: { labels, datasets },
    options: {
        responsive: true,
        scales: {
            x: { title: { display: true, text: '<?= $xAxisTitle ?>' } },
            y: { beginAtZero: true }
        }
    }
});

new Chart(document.getElementById('programDistributionChart'), {
    type: 'doughnut',
    data: {
        labels: Object.keys(<?= json_encode($pieChartData) ?>),
        datasets: [{
            data: Object.values(<?= json_encode($pieChartData) ?>),
            backgroundColor: Object.values(programColors)
        }]
    }
});
</script>

<?php include "includes/footer.php"; ?>
