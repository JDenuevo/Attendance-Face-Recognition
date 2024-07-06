<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require 'vendor/autoload.php'; // Include the PhpSpreadsheet autoload file

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;


if (!isset($_SESSION["loggedinasstaff"]) || $_SESSION["loggedinasstaff"] !== true) {
        header("location: index.php");
        exit;
    }
    
if (isset($_POST['print'])) {
    
    require('fpdf.php');

    // MySQL database configuration
    $host = 'localhost';
    $username = 'ruhslzsa_bsit3b2022';
    $password = '5fwaTmrW{[EX';
    $database = 'ruhslzsa_bsit3b';

    // Connect to MySQL database
    $mysqli = new mysqli($host, $username, $password, $database);
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }
    
    // Fetch data from MySQL table
    $tableName = 'bergs_attendance';
    $tableNameRegistration = 'bergs_registration';
    
        if (isset($_POST['by_employee'])) {
            $selected_employee_id = $_POST['by_employee_select'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $start_date_format = date('Y-m-d', strtotime($start_date));
            $end_date_format = date('Y-m-d', strtotime($end_date));
            $selectedColumns = implode(", ", $_POST['columns']);
        
            $sql = "SELECT $selectedColumns
                        FROM $tableName a
                        JOIN $tableNameRegistration r ON a.employee_id = r.id
                        WHERE a.employee_id = '$selected_employee_id'
                        AND a.date BETWEEN '$start_date_format' AND '$end_date_format'
                        ORDER BY a.date ASC";
            $result = $mysqli->query($sql);
        } else if (isset($_POST['by_department'])) {
            $selected_department_id = $_POST['by_department_select'];
            $selected_employee_by_department = $_POST['by_department_employee'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $start_date_format = date('Y-m-d', strtotime($start_date));
            $end_date_format = date('Y-m-d', strtotime($end_date));
            $selectedColumns = implode(", ", $_POST['columns']);
        
            $sql = "SELECT $selectedColumns
                    FROM $tableName a
                    JOIN $tableNameRegistration r ON a.employee_id = r.idnone
                    WHERE r.department = '$selected_department_id'
                    AND a.date BETWEEN '$start_date_format' AND '$end_date_format'";
        
            if ($selected_employee_by_department !== 'all') {
                $sql .= " AND r.id = '$selected_employee_by_department'";
            }
        
            $sql .= " ORDER BY a.date ASC";
            $result = $mysqli->query($sql);
        }  else if (isset($_POST['by_guest'])) {
            $selected_guest_id = $_POST['by_guest_select'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $start_date_format = date('Y-m-d', strtotime($start_date)); // convert date to MySQL date format
            $end_date_format = date('Y-m-d', strtotime($end_date)); // convert date to MySQL date format
            
            if ($selected_guest_id == 'all_guest') {
                // Fetch data from MySQL table
                $selectedColumns = implode(", ", $_POST['columns']);
                $sql = "SELECT $selectedColumns
                        FROM $tableName a
                        JOIN $tableNameRegistration r ON a.employee_id = r.id
                        WHERE r.privilege = 'Guest'
                        AND a.date BETWEEN '$start_date_format' AND '$end_date_format'
                        ORDER BY a.date ASC";
                
                $result = $mysqli->query($sql);
            }
            else {
                // Fetch data from MySQL table
                $selectedColumns = implode(", ", $_POST['columns']);
                $sql = "SELECT $selectedColumns
                        FROM $tableName a
                        JOIN $tableNameRegistration r ON a.employee_id = r.id
                        WHERE a.employee_id = '$selected_guest_id'
                        AND a.date BETWEEN '$start_date_format' AND '$end_date_format'
                        ORDER BY a.date ASC";
                $result = $mysqli->query($sql);
            }
        } else if (isset($_POST['by_all'])) {
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $start_date_format = date('Y-m-d', strtotime($start_date));
            $end_date_format = date('Y-m-d', strtotime($end_date));
            $selectedColumns = implode(", ", $_POST['columns']);
            
            $sql = "SELECT $selectedColumns
                        FROM $tableName a
                        JOIN $tableNameRegistration r ON a.employee_id = r.id
                        AND a.date BETWEEN '$start_date_format' AND '$end_date_format'
                        ORDER BY a.date ASC";
            $result = $mysqli->query($sql);
        }

    
    
    class PDF extends FPDF
    {
        // Header
        function Header()
        {
              // set the timezone to Manila
            date_default_timezone_set('Asia/Manila');
            
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            // get the start and end dates in the desired format
            $start_date_format = date('F j, Y', strtotime($start_date));
            $end_date_format = date('F j, Y', strtotime($end_date));
            $date_range = $start_date_format . ' - ' . $end_date_format;
        
        
            $date = new DateTime();
            $this->Image('photos/bergslogo.png', 120, 6, 15);
            
            $this->SetFont('Arial','B',18);
            $this->Cell(0,10,'BERGS',0,1,'C');
            $this->Ln(5);
            
            if ($start_date != $end_date){
            // display the date in the desired format
            $this->SetFont('Arial','',15);
            $this->Cell(0,10,'Attendance Information | ' . $date_range, 0, 1, 'C');
            $this->Ln(5);
            
            $this->Line(0, 40, $this->GetPageWidth(), 40);
            
            $this->Ln(5);
            }else{
                 // display the date in the desired format
                $this->SetFont('Arial','',15);
                $this->Cell(0,10,'Attendance Information | ' . $start_date_format, 0, 1, 'C');
                $this->Ln(5);
                
                $this->Line(0, 40, $this->GetPageWidth(), 40);
                
                $this->Ln(5);
            }
        }
        function Body() {
            global $result;
        
            // Table header
            $this->SetFont('Arial', 'B', 9);
            $header = $_POST['columns'];
            foreach ($header as $column) {
                 if ($column === 'employee_id') {
                    if (isset($_POST['by_guest'])) {
                    $this->Cell(25, 6, "Guest ID", 1, 0, 'C');
                    }else {
                    $this->Cell(25, 6, "Employee ID", 1, 0, 'C');
                    }
                } 
                else if ($column === 'employee_name') {
                    if (isset($_POST['by_guest'])) {
                    $this->Cell(50, 6, "Guest Name", 1, 0, 'C');
                    }else {
                    $this->Cell(50, 6, "Employee Name", 1, 0, 'C');
                    }
                }
                else if ($column === 'date') {
                    $this->Cell(25, 6, "Date", 1, 0, 'C');
                } 
                else if ($column === 'time_in') {
                    $this->Cell(25, 6, "Time In", 1, 0, 'C');
                } 
                else if ($column === 'time_out') {
                    $this->Cell(25, 6, "Time Out", 1, 0, 'C');
                }
                else if ($column === 'time_in_OT') {
                    $this->Cell(25, 6, "Time In OT", 1, 0, 'C');
                }
                else if ($column === 'time_out_OT') {
                    $this->Cell(25, 6, "Time Out OT", 1, 0, 'C');
                } 
                else if ($column === 'late_min') {
                    $this->Cell(30, 6, "Late in Minutes", 1, 0, 'C');
                } 
                else if ($column === 'early') {
                    $this->Cell(30, 6, "Early in Minutes", 1, 0, 'C');
                }
                else if ($column === 'marked') {
                    $this->Cell(20, 6, "Marked As", 1, 0, 'C');
                }
                else if ($column === 'company_name') {
                    $this->Cell(40, 6, "Company Name", 1, 0, 'C');
                }
                
            }
            $this->Ln();
        
            // Table data
            $this->SetFont('Arial', '', 10);
            while ($row = $result->fetch_assoc()) {
                foreach ($header as $column) {
                     if ($column === 'employee_id') {
                        $this->Cell(25, 6, $row['employee_id'], 1, 0, 'C');
                    } 
                    else if ($column === 'employee_name') {
                        // Employee Name
                        $this->SetFont('Arial', '', 10);
                        $cellWidth = 50;
                        $cellText = !empty($row['employee_name']) ? ' ' . $row['employee_name'] . ' ' : "--";
                        $cellHeight = 6;
                        if ($this->GetStringWidth($cellText) > $cellWidth) {
                            // Text is too long for the cell, reduce font size
                            $this->SetFont('Arial', '', 7.5);
                            $cellHeight = 6;
                        }
                        $this->Cell($cellWidth, $cellHeight, $cellText, 1, 0, 'C');
                        $this->SetFont('Arial', '', 10);
                    }
                    
                    else if ($column === 'date') {
                        $this->Cell(25, 6, $row['date'], 1, 0, 'C');
                    }
                    else if ($column === 'time_in') {
                        $time_in = $row['time_in'] ? DateTime::createFromFormat('Y-m-d H:i:s', $row['time_in'])->format('g:i A') : '--';
                        $this->Cell(25, 6, $time_in, 1, 0, 'C');
                    } 
                    else if ($column === 'time_out') {
                        $time_out = $row['time_out'] ? DateTime::createFromFormat('Y-m-d H:i:s', $row['time_out'])->format('g:i A') : '--';
                        $this->Cell(25, 6, $time_out, 1, 0, 'C');
                    } 
                    else if ($column === 'time_in_OT') {
                        $time_in_OT = $row['time_in_OT'] ? DateTime::createFromFormat('Y-m-d H:i:s', $row['time_in_OT'])->format('g:i A') : '--';
                        $this->Cell(25, 6, $time_in_OT, 1, 0, 'C');
                    } 
                    else if ($column === 'time_out_OT') {
                        $time_out_OT = $row['time_out_OT'] ? DateTime::createFromFormat('Y-m-d H:i:s', $row['time_out_OT'])->format('g:i A') : '--';
                        $this->Cell(25, 6, $time_out_OT, 1, 0, 'C');
                    } 
                    else if ($column === 'late_min') {
                        $value = $row['late_min'] ? $row['late_min'] . ' mins.' : '--';
                        $this->Cell(30, 6, $value, 1, 0, 'C');
                    } else if ($column === 'early') {
                        $value = $row['early'] ? $row['early'] . ' mins.' : '--';
                        $this->Cell(30, 6, $value, 1, 0, 'C');
                    }                                            
                      else if ($column === 'marked') {
                        $this->Cell(20, 6, $row['marked'], 1, 0, 'C');
                    }
                      else if ($column === 'company_name') {
                        $this->Cell(40, 6, $row['company_name'], 1, 0, 'C');
                    }
                    
                }
                $this->Ln();
            }
        }

    function Footer(){
		
		//Go to 1.5 cm from bottom
		$this->SetY(-15);
				
		$this->SetFont('Arial','',8);
		
		//width = 0 means the cell is extended up to the right margin
		$this->Cell(0,10,'Page '.$this->PageNo()." / {pages}",0,0,'C');
	}

}

$pdf = new PDF('P','mm','A4'); //use new class
//define new alias for total page numbers
$pdf->AliasNbPages('{pages}');

$pdf->SetAutoPageBreak(true,15);
$pdf->AddPage('L');
$pdf->Body();
$pdf->SetTitle("BERGS_ATTENDANCE");
$pdf->SetAuthor('BERGS');

// Close MySQL connection
$mysqli->close();
    
$pdf->Output();
} elseif (isset($_POST['export'])){

    include('dbconn.php');

        // Fetch data from MySQL table
    $tableName = 'bergs_attendance';
    $tableNameRegistration = 'bergs_registration';
    
     if (isset($_POST['by_employee'])) {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $start_date_format = date('Y-m-d', strtotime($start_date)); // convert date to MySQL date format
        $end_date_format = date('Y-m-d', strtotime($end_date)); // convert date to MySQL date format
        
        $selected_employee_id = $_POST['by_employee_select'];
        // Fetch data from MySQL table
        $selectedColumns = implode(", ", $_POST['columns']);
        $result = $conn->query("SELECT $selectedColumns FROM $tableName JOIN $tableNameRegistration r ON a.employee_id COLLATE utf8mb4_general_ci = r.id WHERE a.employee_id = '$selected_employee_id' AND date BETWEEN '$start_date_format' AND '$end_date_format' ORDER BY date ASC");
    } else if (isset($_POST['by_department'])) {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $start_date_format = date('Y-m-d', strtotime($start_date)); // convert date to MySQL date format
        $end_date_format = date('Y-m-d', strtotime($end_date)); // convert date to MySQL date format
        
        $selected_department_id = $_POST['by_department_select'];

       
        $selectedColumns = implode(", ", $_POST['columns']);
        
        $sql = "SELECT $selectedColumns
                FROM $tableName a
                JOIN $tableNameRegistration r ON a.employee_id COLLATE utf8mb4_general_ci = r.id
                WHERE r.department = '$selected_department_id'
                AND a.date BETWEEN '$start_date_format' AND '$end_date_format' ORDER BY date ASC";
        
        $result = $conn->query($sql);
    } else if (isset($_POST['by_guest'])) {
            $selected_guest_id = $_POST['by_guest_select'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $start_date_format = date('Y-m-d', strtotime($start_date)); // convert date to MySQL date format
            $end_date_format = date('Y-m-d', strtotime($end_date)); // convert date to MySQL date format
            
            if ($selected_guest_id == 'all_guest') {
                // Fetch data from MySQL table
                $selectedColumns = implode(", ", $_POST['columns']);
                $sql = "SELECT $selectedColumns
                        FROM $tableName a
                        JOIN $tableNameRegistration r ON a.employee_id COLLATE utf8mb4_general_ci = r.id
                        WHERE r.privilege = 'Guest'
                        AND a.date BETWEEN '$start_date_format' AND '$end_date_format'
                        ORDER BY a.date ASC";
                
                $result = $conn->query($sql);
            }
            else {
                // Fetch data from MySQL table
                $selectedColumns = implode(", ", $_POST['columns']);
                $sql = "SELECT $selectedColumns
                        FROM $tableName a
                        JOIN $tableNameRegistration r ON a.employee_id COLLATE utf8mb4_general_ci = r.id
                        WHERE a.employee_id = '$selected_guest_id'
                        AND a.date BETWEEN '$start_date_format' AND '$end_date_format'
                        ORDER BY a.date ASC";
                $result = $conn->query($sql);
            }
        }else if (isset($_POST['by_all'])) {
         $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $start_date_format = date('Y-m-d', strtotime($start_date)); // convert date to MySQL date format
        $end_date_format = date('Y-m-d', strtotime($end_date)); // convert date to MySQL date format
        
        $selectedColumns = implode(", ", $_POST['columns']);
        $result = $conn->query("SELECT $selectedColumns FROM $tableName a JOIN $tableNameRegistration r ON a.employee_id COLLATE utf8mb4_general_ci = r.id  WHERE date BETWEEN '$start_date_format' AND '$end_date_format' ORDER BY date ASC");
    }
            if (!$result) {
            // Display the error message
            echo "Error: " . mysqli_error($conn);
            // You can also log the error for further investigation
            // error_log("MySQL Error: " . mysqli_error($connection));
        }
        if (mysqli_num_rows($result) > 0) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
        
            // Add the selected columns as table headers
            $columns = explode(", ", $selectedColumns);
            $headers = array(
                'employee_id' => 'Employee ID',
                'employee_name' => 'Employee Name',
                'date' => 'Date',
                'time_in' => 'Time In',
                'time_out' => 'Time Out',
                'time_in_OT' => 'Time In Overtime',
                'time_out_OT' => 'Time Out Overtime',
                'late_min' => 'Late (Minutes)',
                'early' => 'Early (Minutes)',
                'marked' => 'Marked As',
                'company_name' => 'Company Name'
                // Add more column names and corresponding headers as needed
            );
        
            $columnIndex = 1;
            foreach ($columns as $column) {
                // Use the column name as the key to fetch the corresponding header from the $headers array
                $header = isset($headers[$column]) ? $headers[$column] : $column;
                $sheet->setCellValueByColumnAndRow($columnIndex, 1, $header);
                $columnIndex++;
            }
        
            $rowIndex = 2;
            while ($row = mysqli_fetch_assoc($result)) {
                $columnIndex = 1;
                foreach ($columns as $column) {
                    $value = $row[$column];
        
                    // Convert datetime to time format
                    if ($column == 'time_in' || $column == 'time_out' || $column == 'time_in_OT' || $column == 'time_out_OT') {
                        $value = date('g:i A', strtotime($value));
                    }
                    // Convert datetime to time format
                    if ($column == 'date') {
                        $value = date('F j, Y', strtotime($value));
                    }
        
                    $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
                    $columnIndex++;
                }
        
                $rowIndex++;
            }
        
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
            foreach(range('A', $lastColumn) as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }
        
            // Create a new Xlsx writer object and save the spreadsheet to a file
            $writer = new Xlsx($spreadsheet);
            $writer->save('attendance_summary.xlsx');
        
            // Clear output buffer
            ob_clean();
        
            // Set headers for Excel file download
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header("Content-Disposition: attachment; filename=attendance_summary.xlsx");
            header("Cache-Control: max-age=0");
        
            // Read the saved file and output it to the response
            readfile('attendance_summary.xlsx');
        
            // Delete the saved file
            unlink('attendance_summary.xlsx');
    }
    
}else{
    exit();
}
?>