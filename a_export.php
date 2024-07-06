<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('dbconn.php');

require 'vendor/autoload.php'; // Include the PhpSpreadsheet autoload file

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;

if (isset($_POST['export'])) {
    $date_month = $_POST['month'];
    $datename = date('F Y',strtotime($date_month));

    $sql = "SELECT 
                employee_id, 
                employee_name,
                SUM(hours_of_work) AS hours_worked,
                SUM(hours_of_overtime) AS hours_ot,
                COUNT(CASE WHEN marked = 'Present' THEN 1 END) AS present_count,
                SUM(CASE WHEN marked = 'Late' THEN late_min ELSE 0 END) AS total_late,
                COUNT(CASE WHEN marked = 'Absent' THEN 1 END) AS absent_count,
                COUNT(CASE WHEN marked = 'Half Day' THEN 1 END) AS halfday_count
            FROM `bergs_attendance`
            WHERE DATE_FORMAT(`date`, '%Y-%m') = '$date_month'
            GROUP BY employee_id, employee_name
            ORDER BY employee_id ASC";

    $result = $conn->query($sql);

    if (mysqli_num_rows($result) > 0) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Define the column headers
        $headers = array(
            'employee_id' => 'Employee ID',
            'employee_name' => 'Employee Name',
            'hours_worked' => 'Hours of Work',
            'hours_ot' => 'Hours of OT',
            'present_count' => 'Number of Present',
            'total_late' => 'Hours of Late',
            'absent_count' => 'Number of Absent',
            'halfday_count' => 'Number of Half Days'
        );

        // Set the column headers in the spreadsheet
        $columnIndex = 1;
        foreach ($headers as $column => $header) {
            $sheet->setCellValueByColumnAndRow($columnIndex, 1, $header);
            $columnIndex++;
        }

        $rowIndex = 2;
        while ($row = mysqli_fetch_assoc($result)) {
            $columnIndex = 1;
            foreach ($headers as $column => $header) {
                $value = $row[$column];

                if ($column === 'total_late') {
                    $late = $value;
                    $hours_late = floor($late / 60);
                    $minutes_late = $late % 60;
                    $value = ($hours_late > 0 ? $hours_late . " " . ($hours_late == 1 ? "hour" : "hours") : "--");

                    if ($late > 0) {
                        $value = "";
                        if ($hours_late > 0) {
                            $value .= $hours_late . " " . ($hours_late == 1 ? "hour" : "hours");
                        }
                        if ($minutes_late > 0) {
                            $value .= ($hours_late > 0 ? " & " : "") . $minutes_late . " minutes";
                        }
                    } else {
                        $value = "--";
                    }
                }

                $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
                $columnIndex++;
            }

            $rowIndex++;
        }

        // Apply styles, auto-size columns, and save the spreadsheet

        // Set column and row styles
        $style = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                )
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true
            )
        );

        $lastColumn = $sheet->getHighestColumn();
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:' . $lastColumn . '1')->applyFromArray($style); // Apply style to header row
        $sheet->getStyle('A2:' . $lastColumn . $lastRow)->applyFromArray($style); // Apply style to data rows

        // Auto-size columns
        foreach (range('A', $lastColumn) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Create a new Xlsx writer object and save the spreadsheet to a file
        $writer = new Xlsx($spreadsheet);
        $filename = 'attendance_summary_'. $datename .'.xlsx';
        $writer->save($filename);

        // Set headers for Excel file download
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment; filename=" . $filename);
        header("Cache-Control: max-age=0");

        // Read the saved file and output it to the response
        readfile($filename);

        // Delete the saved file
        unlink($filename);
    } else {
        // No data found
        echo "No data available for the selected month.";
    }

    $conn->close();
} else {
    exit();
}
?>