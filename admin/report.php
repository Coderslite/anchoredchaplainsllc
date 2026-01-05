<?php
// report.php - Simplified version

// Check if we're doing an export first (before any output)
include "php/db_config.php";
if (isset($_GET['export']) && $_GET['export'] == 'csv') {
    include "includes/db_connection.php"; // Include only database connection
    
    // Get filter parameters
    $start_date = $_GET['start_date'] ?? date('Y-m-01');
    $end_date = $_GET['end_date'] ?? date('Y-m-d');
    $program_filter = $_GET['program'] ?? 'all';
    
    // Validate dates
    if (strtotime($start_date) > strtotime($end_date)) {
        $temp = $start_date;
        $start_date = $end_date;
        $end_date = $temp;
    }
    
    // Base WHERE clause
    $dateCondition = "created_at BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'";
    $whereClause = "status <> 'deleted' AND $dateCondition";
    
    // Program filter
    if ($program_filter != 'all') {
        $whereClause .= " AND program_applied = '$program_filter'";
    }
    
    // CSV Export
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="client_report_' . date('Y-m-d') . '.csv"');
    
    $output = fopen('php://output', 'w');
    
    // Write headers
    fputcsv($output, [
        'ID', 'Full Name', 'Email', 'Phone', 'Program Applied', 'Status', 
        'Applied Date', 'Approved Date', 'Renewed Date', 'Created At'
    ]);
    
    // Write data
    $query = mysqli_query($con,
        "SELECT id, fullname, email, phone, program_applied, status, 
                applied_date, approved_date, renewed_date, created_at
         FROM clients 
         WHERE $whereClause
         ORDER BY created_at DESC"
    );
    
    while ($row = mysqli_fetch_assoc($query)) {
        fputcsv($output, $row);
    }
    
    fclose($output);
    exit;
}


// Handle PDF Export separately
if (isset($_GET['export']) && $_GET['export'] == 'pdf') {
    include "php/db_config.php"; // Include only database connection
    
    // Get filter parameters
    $start_date = $_GET['start_date'] ?? date('Y-m-01');
    $end_date = $_GET['end_date'] ?? date('Y-m-d');
    $program_filter = $_GET['program'] ?? 'all';
    
    // Validate dates
    if (strtotime($start_date) > strtotime($end_date)) {
        $temp = $start_date;
        $start_date = $end_date;
        $end_date = $temp;
    }
    
    // Base WHERE clause
    $dateCondition = "created_at BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'";
    $whereClause = "status <> 'deleted' AND $dateCondition";
    
    // Program filter
    if ($program_filter != 'all') {
        $whereClause .= " AND program_applied = '$program_filter'";
    }
    
    // Generate PDF report
    require_once('php/vendor/tecnickcom/tcpdf/tcpdf.php');
    
    // Create new PDF document
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    
    // Set document information
    $pdf->SetCreator('Client Management System');
    $pdf->SetAuthor('System Admin');
    $pdf->SetTitle('Client Report - ' . date('Y-m-d'));
    $pdf->SetSubject('Client Statistics Report');
    
    // Remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    
    // Add a page
    $pdf->AddPage();
    
    // Set font
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'Client Statistics Report', 0, 1, 'C');
    
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 10, 'Period: ' . date('M d, Y', strtotime($start_date)) . ' to ' . date('M d, Y', strtotime($end_date)), 0, 1, 'C');
    
    if ($program_filter != 'all') {
        $pdf->Cell(0, 10, 'Program: ' . $program_filter, 0, 1, 'C');
    }
    
    $pdf->Cell(0, 10, 'Generated on: ' . date('M d, Y H:i:s'), 0, 1, 'C');
    
    $pdf->Ln(10);
    
    // Get statistics
    $stats = mysqli_fetch_assoc(mysqli_query($con,
        "SELECT 
            COUNT(*) as total_clients,
            SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected,
            SUM(CASE WHEN renewed_date IS NULL OR renewed_date < CURDATE() THEN 1 ELSE 0 END) as expired
         FROM clients 
         WHERE $whereClause"
    ));
    
    // Add summary table
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Summary Statistics', 0, 1);
    $pdf->SetFont('helvetica', '', 10);
    
    $summaryData = array(
        array('Metric', 'Value'),
        array('Total Clients', $stats['total_clients'] ?? 0),
        array('Approved Clients', $stats['approved'] ?? 0),
        array('Pending Clients', $stats['pending'] ?? 0),
        array('Rejected Clients', $stats['rejected'] ?? 0),
        array('Expired Clients', $stats['expired'] ?? 0)
    );
    
    // Create table
    $html = '<table border="1" cellpadding="5">
        <tr style="background-color:#f2f2f2;">
            <th width="70%"><b>Metric</b></th>
            <th width="30%"><b>Value</b></th>
        </tr>';
    
    foreach ($summaryData as $row) {
        $html .= '<tr>';
        $html .= '<td>' . $row[0] . '</td>';
        $html .= '<td>' . $row[1] . '</td>';
        $html .= '</tr>';
    }
    
    $html .= '</table>';
    $pdf->writeHTML($html, true, false, true, false, '');
    
    // Program types for breakdown
    $programTypes = ['Life Coaching', 'Chaplain Training', 'Chaplain Coaching', 'Business Coaching', 'Book Coaching', 'Affiliate Program'];
    
    // Add program breakdown if showing all programs
    if ($program_filter == 'all') {
        $pdf->Ln(10);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 10, 'Program Breakdown', 0, 1);
        
        $html = '<table border="1" cellpadding="5">
            <tr style="background-color:#f2f2f2;">
                <th width="50%"><b>Program</b></th>
                <th width="25%"><b>Count</b></th>
                <th width="25%"><b>Percentage</b></th>
            </tr>';
        
        $totalClients = $stats['total_clients'] ?? 1; // Avoid division by zero
        
        foreach ($programTypes as $program) {
            $programQuery = mysqli_query($con,
                "SELECT COUNT(*) as count
                 FROM clients 
                 WHERE status <> 'deleted' 
                   AND program_applied = '$program'
                   AND $dateCondition"
            );
            
            $programData = mysqli_fetch_assoc($programQuery);
            $count = $programData['count'] ?? 0;
            $percentage = $totalClients > 0 ? round(($count / $totalClients) * 100, 1) : 0;
            
            $html .= '<tr>';
            $html .= '<td>' . $program . '</td>';
            $html .= '<td>' . $count . '</td>';
            $html .= '<td>' . $percentage . '%</td>';
            $html .= '</tr>';
        }
        
        $html .= '</table>';
        $pdf->writeHTML($html, true, false, true, false, '');
    }
    
    // Add recent clients table
    $pdf->Ln(10);
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Recent Registrations', 0, 1);
    
    $clientQuery = mysqli_query($con,
        "SELECT id, fullname, email, program_applied, status, created_at
         FROM clients 
         WHERE $whereClause
         ORDER BY created_at DESC 
         LIMIT 20"
    );
    
    $html = '<table border="1" cellpadding="5" style="font-size: 9px;">
        <tr style="background-color:#f2f2f2;">
            <th width="10%"><b>ID</b></th>
            <th width="25%"><b>Name</b></th>
            <th width="25%"><b>Email</b></th>
            <th width="20%"><b>Program</b></th>
            <th width="10%"><b>Status</b></th>
            <th width="10%"><b>Date</b></th>
        </tr>';
    
    while ($client = mysqli_fetch_assoc($clientQuery)) {
        $html .= '<tr>';
        $html .= '<td>' . $client['id'] . '</td>';
        $html .= '<td>' . htmlspecialchars($client['fullname']) . '</td>';
        $html .= '<td>' . htmlspecialchars($client['email']) . '</td>';
        $html .= '<td>' . $client['program_applied'] . '</td>';
        $html .= '<td>' . ucfirst($client['status']) . '</td>';
        $html .= '<td>' . date('M d, Y', strtotime($client['created_at'])) . '</td>';
        $html .= '</tr>';
    }
    
    $html .= '</table>';
    $pdf->writeHTML($html, true, false, true, false, '');
    
    // Output PDF
    $pdf->Output('client_report_' . date('Y-m-d') . '.pdf', 'D');
    exit;
}

// If not exporting, show the normal HTML page
include "includes/header.php";

// Date range filter for HTML page
$start_date = $_GET['start_date'] ?? date('Y-m-01');
$end_date = $_GET['end_date'] ?? date('Y-m-d');
$program_filter = $_GET['program'] ?? 'all';
$generate = isset($_GET['generate']) ? true : false;

// Validate dates
if (strtotime($start_date) > strtotime($end_date)) {
    $temp = $start_date;
    $start_date = $end_date;
    $end_date = $temp;
}

// Base WHERE clause
$dateCondition = "created_at BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'";
$whereClause = "status <> 'deleted' AND $dateCondition";

// Program filter
if ($program_filter != 'all') {
    $whereClause .= " AND program_applied = '$program_filter'";
}

// Program types
$programTypes = ['Life Coaching', 'Chaplain Training', 'Chaplain Coaching', 'Business Coaching', 'Book Coaching', 'Affiliate Program'];

// Only query data if generate button was clicked
$reportData = [];
if ($generate) {
    // Get overall statistics
    $reportData['stats'] = mysqli_fetch_assoc(mysqli_query($con,
        "SELECT 
            COUNT(*) as total_clients,
            SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected,
            SUM(CASE WHEN renewed_date IS NULL OR renewed_date < CURDATE() THEN 1 ELSE 0 END) as expired
         FROM clients 
         WHERE $whereClause"
    ));
    
    // Get program breakdown
    $reportData['programs'] = [];
    foreach ($programTypes as $program) {
        $query = mysqli_query($con,
            "SELECT COUNT(*) as count
             FROM clients 
             WHERE status <> 'deleted' 
               AND program_applied = '$program'
               AND $dateCondition"
        );
        
        $result = mysqli_fetch_assoc($query);
        $reportData['programs'][$program] = $result['count'] ?? 0;
    }
    
    // Get recent clients
    $reportData['recent'] = [];
    $recentQuery = mysqli_query($con,
        "SELECT id, fullname, email, program_applied, status, created_at
         FROM clients 
         WHERE $whereClause
         ORDER BY created_at DESC 
         LIMIT 10"
    );
    
    while ($row = mysqli_fetch_assoc($recentQuery)) {
        $reportData['recent'][] = $row;
    }
}
?>

<div class="page-body">
    <div class="container-fluid py-5">
        
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-title">
                    <h3>Generate Report</h3>
                    <p class="text-muted">Filter and generate statistical reports for clients</p>
                </div>
            </div>
        </div>

        <!-- Report Filters -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Report Filters</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="" class="row g-3">
                            <div class="col-md-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" 
                                       value="<?= $start_date ?>" max="<?= date('Y-m-d') ?>" required>
                            </div>
                            <div class="col-md-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" 
                                       value="<?= $end_date ?>" max="<?= date('Y-m-d') ?>" required>
                            </div>
                            <div class="col-md-3">
                                <label for="program" class="form-label">Program</label>
                                <select class="form-select" id="program" name="program">
                                    <option value="all" <?= $program_filter == 'all' ? 'selected' : '' ?>>All Programs</option>
                                    <?php foreach ($programTypes as $program): ?>
                                    <option value="<?= $program ?>" <?= $program_filter == $program ? 'selected' : '' ?>>
                                        <?= $program ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" name="generate" value="1" class="btn btn-primary w-100">
                                    <i class="fas fa-chart-bar me-2"></i>Generate Report
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($generate && isset($reportData['stats'])): ?>
        
        <!-- Report Results -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Report Results</h5>
                        <div class="btn-group">
                            <a href="?<?= http_build_query(array_merge($_GET, ['export' => 'csv'])) ?>" 
                               class="btn btn-success btn-sm">
                                <i class="fas fa-file-csv me-1"></i>Export CSV
                            </a>
                            <a href="?<?= http_build_query(array_merge($_GET, ['export' => 'pdf'])) ?>" 
                               class="btn btn-danger btn-sm">
                                <i class="fas fa-file-pdf me-1"></i>Export PDF
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        <!-- Summary Statistics -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="mb-3">Summary Statistics</h6>
                                <div class="row">
                                    <div class="col-md-2 col-6 mb-3">
                                        <div class="card bg-light-primary border-primary">
                                            <div class="card-body text-center p-3">
                                                <h3 class="mb-1"><?= $reportData['stats']['total_clients'] ?></h3>
                                                <p class="mb-0 text-muted" style="font-size: 0.9rem;">Total Clients</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-6 mb-3">
                                        <div class="card bg-light-success border-success">
                                            <div class="card-body text-center p-3">
                                                <h3 class="mb-1"><?= $reportData['stats']['approved'] ?></h3>
                                                <p class="mb-0 text-muted" style="font-size: 0.9rem;">Approved</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-6 mb-3">
                                        <div class="card bg-light-warning border-warning">
                                            <div class="card-body text-center p-3">
                                                <h3 class="mb-1"><?= $reportData['stats']['pending'] ?></h3>
                                                <p class="mb-0 text-muted" style="font-size: 0.9rem;">Pending</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-6 mb-3">
                                        <div class="card bg-light-danger border-danger">
                                            <div class="card-body text-center p-3">
                                                <h3 class="mb-1"><?= $reportData['stats']['rejected'] ?></h3>
                                                <p class="mb-0 text-muted" style="font-size: 0.9rem;">Rejected</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-6 mb-3">
                                        <div class="card bg-light-secondary border-secondary">
                                            <div class="card-body text-center p-3">
                                                <h3 class="mb-1"><?= $reportData['stats']['expired'] ?></h3>
                                                <p class="mb-0 text-muted" style="font-size: 0.9rem;">Expired</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Program Breakdown (only if showing all programs) -->
                        <?php if ($program_filter == 'all'): ?>
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="mb-3">Program Breakdown</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Program</th>
                                                <th>Count</th>
                                                <th>Percentage</th>
                                                <th>Progress</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $total = $reportData['stats']['total_clients'];
                                            foreach ($reportData['programs'] as $program => $count): 
                                                $percentage = $total > 0 ? round(($count / $total) * 100, 1) : 0;
                                            ?>
                                            <tr>
                                                <td><strong><?= $program ?></strong></td>
                                                <td><?= $count ?></td>
                                                <td><?= $percentage ?>%</td>
                                                <td>
                                                    <div class="progress" style="height: 20px;">
                                                        <div class="progress-bar" 
                                                             style="width: <?= $percentage ?>%; background-color: #<?= substr(md5($program), 0, 6) ?>;">
                                                            <?= $percentage ?>%
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Recent Registrations -->
                        <div class="row">
                            <div class="col-12">
                                <h6 class="mb-3">Recent Registrations (Last 10)</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Program</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($reportData['recent'] as $client): ?>
                                            <tr>
                                                <td>#<?= $client['id'] ?></td>
                                                <td><?= htmlspecialchars($client['fullname']) ?></td>
                                                <td><?= htmlspecialchars($client['email']) ?></td>
                                                <td>
                                                    <span class="badge" style="background-color: #<?= substr(md5($client['program_applied']), 0, 6) ?>; color: white;">
                                                        <?= $client['program_applied'] ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php
                                                    $statusColors = [
                                                        'approved' => 'success',
                                                        'pending' => 'warning',
                                                        'rejected' => 'danger',
                                                        'expired' => 'secondary'
                                                    ];
                                                    ?>
                                                    <span class="badge bg-<?= $statusColors[$client['status']] ?? 'secondary' ?>">
                                                        <?= ucfirst($client['status']) ?>
                                                    </span>
                                                </td>
                                                <td><?= date('M d, Y', strtotime($client['created_at'])) ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        
        <?php else: ?>
        
        <!-- Placeholder when no report generated -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-chart-bar fa-4x text-muted"></i>
                        </div>
                        <h5 class="mb-3">No Report Generated</h5>
                        <p class="text-muted mb-4">
                            Select your date range and program filter, then click "Generate Report" to view statistics.
                        </p>
                        <div class="text-muted small">
                            <p>You can export reports in CSV or PDF format after generation.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php endif; ?>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Date validation
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    
    startDate.addEventListener('change', function() {
        endDate.min = this.value;
        if (endDate.value && new Date(endDate.value) < new Date(this.value)) {
            endDate.value = this.value;
        }
    });
    
    endDate.addEventListener('change', function() {
        startDate.max = this.value;
        if (startDate.value && new Date(startDate.value) > new Date(this.value)) {
            startDate.value = this.value;
        }
    });
});
</script>

<style>
.page-title {
    border-bottom: 1px solid #dee2e6;
    padding-bottom: 1rem;
    margin-bottom: 2rem;
}

.card.bg-light-primary {
    background-color: rgba(13, 110, 253, 0.1) !important;
}
.card.bg-light-success {
    background-color: rgba(25, 135, 84, 0.1) !important;
}
.card.bg-light-warning {
    background-color: rgba(255, 193, 7, 0.1) !important;
}
.card.bg-light-danger {
    background-color: rgba(220, 53, 69, 0.1) !important;
}
.card.bg-light-secondary {
    background-color: rgba(108, 117, 125, 0.1) !important;
}

.badge {
    font-size: 0.75em;
    font-weight: 500;
    padding: 0.25em 0.65em;
}

.table-sm th,
.table-sm td {
    padding: 0.5rem;
}

.progress {
    border-radius: 10px;
    overflow: hidden;
}

.progress-bar {
    border-radius: 10px;
    font-size: 0.75rem;
    line-height: 20px;
}
</style>

<?php include "includes/footer.php"; ?>