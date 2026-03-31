<?php
require_once 'db_config.php';
require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Handle selected IDs (optional bulk export)
$selected_ids = [];
$where_clause = "WHERE program_applied = 'Chaplain Training' AND status <> 'deleted'";

if (isset($_GET['ids']) && !empty($_GET['ids'])) {
    $selected_ids = explode(',', $_GET['ids']);
    $selected_ids = array_map('intval', $selected_ids);
    $ids_string = implode(',', $selected_ids);

    $where_clause .= " AND id IN ($ids_string)";
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Document properties
$spreadsheet->getProperties()
    ->setCreator("Client Management System")
    ->setTitle("Chaplain Training Clients Export");

// ✅ Headers
$headers = [
    'ID',
    'Full Name',
    'Email',
    'Phone',
    'Applied Date',
    'Approved Date',
    'Renewed Date',
    'Status'
];

$sheet->fromArray($headers, NULL, 'A1');

// ✅ Fetch data
$query = "SELECT * FROM clients 
          $where_clause
          ORDER BY id DESC";

$result = mysqli_query($con, $query);

if (!$result) {
    die('Database error: ' . mysqli_error($con));
}

// ✅ Fill data
$rowNumber = 2;
$today = date('Y-m-d');

while ($row = mysqli_fetch_assoc($result)) {

    // Status logic (same as your dashboard)
    if ($row['approved_date'] && (!$row['renewed_date'] || $row['renewed_date'] < $today)) {
        $status = 'Expired';
    } else {
        $status = 'Active';
    }

    $sheet->setCellValue('A'.$rowNumber, $row['id']);
    $sheet->setCellValue('B'.$rowNumber, $row['fullname']);
    $sheet->setCellValue('C'.$rowNumber, $row['email']);
    $sheet->setCellValue('D'.$rowNumber, $row['phone']);
    $sheet->setCellValue('E'.$rowNumber, $row['applied_date']);
    $sheet->setCellValue('F'.$rowNumber, $row['approved_date']);
    $sheet->setCellValue('G'.$rowNumber, $row['renewed_date']);
    $sheet->setCellValue('H'.$rowNumber, $status);

    $rowNumber++;
}

// ✅ Auto-size columns
foreach (range('A', 'H') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// ✅ Header styling
$sheet->getStyle('A1:H1')->applyFromArray([
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF']
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '007bff']
    ]
]);

// ✅ Alternate row styling
for ($i = 2; $i < $rowNumber; $i++) {
    if ($i % 2 == 0) {
        $sheet->getStyle('A'.$i.':H'.$i)->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'F5F5F5']
            ]
        ]);
    }
}

// ✅ File name
$filename = empty($selected_ids) 
    ? 'chaplain_clients_' . date('Y-m-d') . '.xlsx'
    : 'selected_chaplain_clients_' . date('Y-m-d') . '.xlsx';

// ✅ Output
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;