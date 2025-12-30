<?php
// includes/export_pdf.php
require_once 'vendor/autoload.php'; // You need to install TCPDF or similar

use TCPDF;

// Create PDF instance
$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('Client Management System');
$pdf->SetAuthor('System Admin');
$pdf->SetTitle('Client Analytics Report');
$pdf->SetSubject('Report Generated ' . date('Y-m-d'));

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Client Analytics Report', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 10, 'Period: ' . date('M d, Y', strtotime($start_date)) . ' to ' . date('M d, Y', strtotime($end_date)), 0, 1, 'C');
$pdf->Cell(0, 10, 'Generated on: ' . date('M d, Y H:i:s'), 0, 1, 'C');

// Add a line break
$pdf->Ln(10);

// Overall Statistics
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Overall Statistics', 0, 1);
$pdf->SetFont('helvetica', '', 10);

$overallData = [
    ['Total Clients', $overallStats['total_clients'] ?? 0],
    ['Approved Clients', $overallStats['approved_clients'] ?? 0],
    ['Pending Clients', $overallStats['pending_clients'] ?? 0],
    ['Rejected Clients', $overallStats['rejected_clients'] ?? 0],
    ['Expired Clients', $overallStats['expired_clients'] ?? 0],
    ['Average Approval Days', round($overallStats['avg_approval_days'] ?? 0)]
];

// Create table for overall stats
$html = '<table border="1" cellpadding="5">
    <tr style="background-color:#f2f2f2;">
        <th width="50%"><b>Metric</b></th>
        <th width="50%"><b>Value</b></th>
    </tr>';

foreach ($overallData as $row) {
    $html .= '<tr>';
    $html .= '<td>' . $row[0] . '</td>';
    $html .= '<td>' . $row[1] . '</td>';
    $html .= '</tr>';
}

$html .= '</table>';
$pdf->writeHTML($html, true, false, true, false, '');

// Program-wise Statistics
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Program-wise Statistics', 0, 1);

$html = '<table border="1" cellpadding="5">
    <tr style="background-color:#f2f2f2;">
        <th><b>Program</b></th>
        <th><b>Total</b></th>
        <th><b>Approved</b></th>
        <th><b>Pending</b></th>
        <th><b>Rejected</b></th>
        <th><b>Expired</b></th>
    </tr>';

foreach ($programTypes as $program) {
    $stats = $programStats[$program] ?? [];
    $html .= '<tr>';
    $html .= '<td>' . $program . '</td>';
    $html .= '<td>' . ($stats['total'] ?? 0) . '</td>';
    $html .= '<td>' . ($stats['approved'] ?? 0) . '</td>';
    $html .= '<td>' . ($stats['pending'] ?? 0) . '</td>';
    $html .= '<td>' . ($stats['rejected'] ?? 0) . '</td>';
    $html .= '<td>' . ($stats['expired'] ?? 0) . '</td>';
    $html .= '</tr>';
}

$html .= '</table>';
$pdf->writeHTML($html, true, false);

?>