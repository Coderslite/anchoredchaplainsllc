<?php 
include "includes/header.php";

// === Time Filter ===
$filter = $_GET['filter'] ?? 'month';

switch ($filter) {
    case 'day':
        $dateCondition = "DATE(created_at) = CURDATE()";
        $groupBy = "DATE_FORMAT(created_at, '%H:00')";
        $labelsFormat = "H:00";
        $xAxisTitle = "Hour of Day";
        break;
    case 'week':
        $dateCondition = "YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)";
        $groupBy = "DATE(created_at)";
        $labelsFormat = "D";
        $xAxisTitle = "Day of Week";
        break;
    default:
        $dateCondition = "MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
        $groupBy = "DATE(created_at)";
        $labelsFormat = "M j";
        $xAxisTitle = "Date";
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

// === Get Program Data for Graph ===
$programTypes = ['Life Coaching', 'Chaplain Training', 'Chaplain Coaching', 'Business Coaching', 'Book Coaching', 'Affiliate Program'];
$programData = [];
$programColors = [
    'Life Coaching' => '#FF6384',     // Red
    'Chaplain Training' => '#36A2EB', // Blue
    'Chaplain Coaching' => '#FFCE56', // Yellow
    'Business Coaching' => '#4BC0C0', // Teal
    'Book Coaching' => '#9966FF',     // Purple
    'Affiliate Program' => '#FF9F40'  // Orange
];

// Get line chart data for each program
foreach ($programTypes as $program) {
    $query = mysqli_query($con,
        "SELECT $groupBy as date_group, COUNT(*) as count
         FROM clients 
         WHERE status <> 'deleted' 
           AND program_applied = '$program'
           AND $dateCondition
         GROUP BY $groupBy
         ORDER BY date_group ASC");
    
    $programData[$program] = [];
    while($row = mysqli_fetch_assoc($query)) {
        $programData[$program][] = $row;
    }
}

// Get pie chart data (total per program)
$pieChartData = [];
foreach ($programTypes as $program) {
    $query = mysqli_query($con,
        "SELECT COUNT(*) as total
         FROM clients 
         WHERE status <> 'deleted' 
           AND program_applied = '$program'
           AND $dateCondition");
    
    $result = mysqli_fetch_assoc($query);
    $pieChartData[$program] = $result['total'] ?? 0;
}

// Get labels (dates) for line chart
$labelsQuery = mysqli_query($con,
    "SELECT $groupBy as date_group
     FROM clients 
     WHERE status <> 'deleted' AND $dateCondition
     GROUP BY $groupBy
     ORDER BY date_group ASC");

$labels = [];
while($row = mysqli_fetch_assoc($labelsQuery)) {
    if ($filter == 'day') {
        $labels[] = date('H:00', strtotime($row['date_group']));
    } elseif ($filter == 'week') {
        $labels[] = date('D', strtotime($row['date_group']));
    } else {
        $labels[] = date('M j', strtotime($row['date_group']));
    }
}

// If no data for current period, show placeholder
if (empty($labels)) {
    $labels = ['No Data'];
}

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
                    <p class="text-muted mb-0">Clients (<?= $filter ?>)</p>
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
                    <p class="text-muted mb-0">Total Chaplains</p>
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

        <!-- Analytics Section -->
        <div class="row mb-4">
            <!-- Line/Bar Chart -->
            <div class="col-xl-8 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Client Registrations Trend by Program Type</h5>
                        <span>Showing <?= ucfirst($filter) ?>ly data (Total: <?= $totalClients ?> clients)</span>
                    </div>
                    <div class="card-body">
                        <div class="chart-type-toggle mb-3">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-primary active" data-chart-type="line">Line Chart</button>
                                <button type="button" class="btn btn-outline-primary" data-chart-type="bar">Bar Chart</button>
                            </div>
                        </div>
                        <div class="chart-container" style="position: relative; height:350px; width:100%">
                            <canvas id="programAnalyticsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Program Distribution</h5>
                        <span>Percentage breakdown of program applications</span>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="position: relative; height:350px; width:100%">
                            <canvas id="programDistributionChart"></canvas>
                        </div>
                        <div class="pie-legend mt-3" id="pieChartLegend"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Program Summary Cards -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Program Summary (<?= ucfirst($filter) ?>ly)</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php 
                            $totalAllPrograms = array_sum($pieChartData);
                            foreach ($programTypes as $program): 
                                $count = $pieChartData[$program];
                                $percentage = $totalAllPrograms > 0 ? round(($count / $totalAllPrograms) * 100, 1) : 0;
                            ?>
                            <div class="col-md-4 col-lg-2 mb-3">
                                <div class="program-summary-card text-center p-3" style="border-left: 4px solid <?= $programColors[$program] ?>; background: <?= $programColors[$program] ?>10;">
                                    <h4 class="mb-1"><?= $count ?></h4>
                                    <p class="mb-1 text-muted" style="font-size: 0.9rem;"><?= $program ?></p>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar" role="progressbar" 
                                             style="width: <?= $percentage ?>%; background-color: <?= $programColors[$program] ?>" 
                                             aria-valuenow="<?= $percentage ?>" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100"></div>
                                    </div>
                                    <small class="text-muted"><?= $percentage ?>%</small>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Registrations Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Recent Registrations</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Program</th>
                                        <th>Applied Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $recentQuery = mysqli_query($con,
                                        "SELECT * FROM clients 
                                         WHERE status <> 'deleted' 
                                         ORDER BY created_at DESC 
                                         LIMIT 10");
                                    
                                    while($row = mysqli_fetch_assoc($recentQuery)):
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-placeholder me-2" 
                                                     style="width: 32px; height: 32px; background-color: <?= $programColors[$row['program_applied']] ?? '#6c757d' ?>; 
                                                            border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                                    <?= substr($row['fullname'], 0, 1) ?>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0"><?= htmlspecialchars($row['fullname']) ?></h6>
                                                    <small class="text-muted">ID: <?= $row['id'] ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($row['email']) ?></td>
                                        <td><?= htmlspecialchars($row['phone']) ?></td>
                                        <td>
                                            <span class="badge" style="background-color: <?= $programColors[$row['program_applied']] ?? '#6c757d' ?>; color: white;">
                                                <?= $row['program_applied'] ?>
                                            </span>
                                        </td>
                                        <td><?= date('M d, Y', strtotime($row['created_at'])) ?></td>
                                        <td>
                                            <?php 
                                            $status = $row['status'] ?? 'pending';
                                            $statusColors = [
                                                'approved' => 'success',
                                                'pending' => 'warning',
                                                'rejected' => 'danger',
                                                'expired' => 'secondary'
                                            ];
                                            ?>
                                            <span class="badge bg-<?= $statusColors[$status] ?? 'secondary' ?>">
                                                <?= ucfirst($status) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="view-client.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- JavaScript for Charts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart colors
    const programColors = <?= json_encode($programColors) ?>;
    const programTypes = <?= json_encode($programTypes) ?>;
    const pieChartData = <?= json_encode($pieChartData) ?>;
    
    // ===== LINE/BAR CHART =====
    const ctx = document.getElementById('programAnalyticsChart').getContext('2d');
    let chartType = 'line';
    let currentChart = null;
    
    function createChart(type) {
        chartType = type;
        
        // Destroy existing chart if it exists
        if (currentChart) {
            currentChart.destroy();
        }
        
        // Prepare datasets for each program
        const datasets = [];
        
        <?php foreach($programTypes as $program): ?>
        {
            const programName = '<?= $program ?>';
            const color = programColors[programName];
            const data = [];
            
            // Create array matching labels length
            const programData = <?= json_encode($programData[$program]) ?>;
            const labels = <?= json_encode($labels) ?>;
            
            // Match data to labels
            labels.forEach((label) => {
                // Find corresponding data point
                let found = false;
                programData.forEach(item => {
                    if (chartType === 'line' || chartType === 'bar') {
                        const date = new Date(item.date_group);
                        let formattedDate;
                        
                        if ('<?= $filter ?>' === 'day') {
                            formattedDate = date.getHours() + ':00';
                        } else if ('<?= $filter ?>' === 'week') {
                            formattedDate = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'][date.getDay()];
                        } else {
                            formattedDate = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                        }
                        
                        if (formattedDate === label) {
                            data.push(parseInt(item.count));
                            found = true;
                        }
                    }
                });
                
                if (!found) {
                    data.push(0);
                }
            });
            
            datasets.push({
                label: programName,
                data: data,
                borderColor: color,
                backgroundColor: type === 'bar' ? color + '80' : color + '20',
                tension: type === 'line' ? 0.4 : 0,
                fill: type === 'line',
                pointRadius: 4,
                pointHoverRadius: 6,
                borderWidth: type === 'line' ? 2 : 1
            });
        }
        
        <?php endforeach; ?>
        
        // Create the chart
        currentChart = new Chart(ctx, {
            type: type,
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            boxWidth: 12,
                            padding: 15
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.parsed.y + ' client(s)';
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: '<?= $xAxisTitle ?>'
                        },
                        grid: {
                            display: true
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Clients'
                        },
                        ticks: {
                            stepSize: 1,
                            precision: 0
                        }
                    }
                }
            }
        });
    }
    
    // Initialize with line chart
    createChart('line');
    
    // Chart type toggle
    document.querySelectorAll('[data-chart-type]').forEach(button => {
        button.addEventListener('click', function() {
            const type = this.getAttribute('data-chart-type');
            
            // Update active button
            document.querySelectorAll('[data-chart-type]').forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');
            
            // Recreate chart with new type
            createChart(type);
        });
    });
    
    // ===== PIE CHART =====
    const pieCtx = document.getElementById('programDistributionChart').getContext('2d');
    
    // Filter out programs with zero clients
    const pieLabels = [];
    const pieData = [];
    const pieColors = [];
    
    programTypes.forEach(program => {
        const count = pieChartData[program];
        if (count > 0) {
            pieLabels.push(program);
            pieData.push(count);
            pieColors.push(programColors[program]);
        }
    });
    
    // Create pie chart
    const pieChart = new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: pieLabels,
            datasets: [{
                data: pieData,
                backgroundColor: pieColors,
                borderColor: '#fff',
                borderWidth: 2,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} clients (${percentage}%)`;
                        }
                    }
                }
            },
            cutout: '60%'
        }
    });
    
    // Create custom legend for pie chart
    const pieLegend = document.getElementById('pieChartLegend');
    let legendHTML = '<div class="row">';
    
    programTypes.forEach((program, index) => {
        const count = pieChartData[program];
        if (count > 0) {
            const percentage = <?= array_sum($pieChartData) > 0 ? '(' . array_sum($pieChartData) . ')' : 0 ?>;
            const actualPercentage = percentage > 0 ? Math.round((count / <?= array_sum($pieChartData) ?>) * 100) : 0;
            
            legendHTML += `
                <div class="col-6 mb-2">
                    <div class="d-flex align-items-center">
                        <div class="legend-color-box me-2" 
                             style="background-color: ${programColors[program]}; width: 12px; height: 12px; border-radius: 2px;"></div>
                        <div style="flex: 1;">
                            <div class="d-flex justify-content-between">
                                <span style="font-size: 0.85rem;">${program}</span>
                                <span style="font-size: 0.85rem; font-weight: bold;">${count}</span>
                            </div>
                            <div class="progress" style="height: 4px;">
                                <div class="progress-bar" role="progressbar" 
                                     style="width: ${actualPercentage}%; background-color: ${programColors[program]};"></div>
                            </div>
                            <small class="text-muted" style="font-size: 0.75rem;">${actualPercentage}%</small>
                        </div>
                    </div>
                </div>
            `;
        }
    });
    
    legendHTML += '</div>';
    pieLegend.innerHTML = legendHTML;
});
</script>

<style>
.stat-card {
    transition: transform 0.3s ease;
    border: 1px solid transparent;
    border-radius: 12px;
}
.stat-card:hover {
    transform: translateY(-3px);
    border-color: var(--bs-primary);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
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
.program-summary-card {
    border-radius: 8px;
    transition: all 0.3s ease;
    cursor: pointer;
}
.program-summary-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.chart-type-toggle .btn-group .btn {
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
}
.avatar-placeholder {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: white;
}
.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,0.02);
}
</style>

<?php include "includes/footer.php"; ?>