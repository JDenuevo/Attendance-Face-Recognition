<?php

session_start();
Class dbObj{
/* Database connection start */
var $dbhost = "localhost";
var $username = "ruhslzsa_bsit3b2022";
var $password = "5fwaTmrW{[EX";
var $dbname = "ruhslzsa_bsit3b";
var $conn;
function getConnstring() {
$con = mysqli_connect($this->dbhost, $this->username, $this->password, $this->dbname)
or die("Connection failed: " . mysqli_connect_error());

/* check connection */
if (mysqli_connect_errno()) {
  printf("Connect failed: %s\n", mysqli_connect_error());
  exit();
  } else {
  $this->conn = $con;
  }
  return $this->conn;
  }
}

if(!isset($_SESSION["loggedinasadmin"]) || $_SESSION["loggedinasadmin"] !== true){
    header("location: index.php");
    exit;
}

?>
<?php
require('fpdf.php');
include_once("dbconn.php");

class PDF extends FPDF
{
  function Header()
  {
    date_default_timezone_set('Asia/Manila');
    $date_month = $_GET['date_month'];
    $date = DateTime::createFromFormat('Y-m', $date_month);
    $this->Image('photos/bergslogo.png', 120, 6, 15);
            
    $this->SetFont('Arial','B',18);
    $this->Cell(0,10,'BERGS',0,1,'C');
    $this->Ln(5);
    
    $this->SetFont('Arial','',15);
    $this->Cell(0,10,'Attendance Summary | ' . $date->format('F Y'), 0, 1, 'C');
    $this->Ln(5);
    
    $this->Line(0, 40, $this->GetPageWidth(), 40);
    
    $this->Ln(5);


  }
  function Body()
  {
        date_default_timezone_set('Asia/Manila');
      
        $db = new dbObj();
        $con = $db->getConnstring();
        $date_month = $_GET['date_month'];
        $date = date('Y-m', strtotime($date_month . '-01'));
        
        $sql = "SELECT employee_id, employee_name,
        COUNT(CASE WHEN marked = 'Absent' THEN 1 END) AS absent_count,
        COUNT(CASE WHEN marked = 'Late' THEN 1 END) AS late_count,
        COUNT(CASE WHEN marked = 'Present' THEN 1 END) AS present_count,
        COUNT(CASE WHEN marked = 'Half Day' THEN 1 END) AS halfday_count,
        SUM(hours_of_work) AS total_hours_worked,
        SUM(hours_of_overtime) AS total_hours_overtime,
        SUM(late_min) AS total_late
        FROM `bergs_attendance`
        WHERE `date` LIKE ?
        GROUP BY employee_id, employee_name
        ORDER BY employee_id ASC";
        $searchDate = "%$date%";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "s", $searchDate);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

    
        $this->SetFont('Arial','',10);
        // Employee ID
        $this->Cell(30,6,'Employee ID',1,0,'C');
        
        // Employee Name
        $this->Cell(50,6,'Employee Name',1,0,'C');
        
        // Hours of Work
        $this->Cell(30,6,'Hours of Work',1,0,'C');
        
        // Hours of Overtime
        $this->Cell(30,6,'Hours of OT',1,0,'C');
        
        // Number of Presents
        $this->Cell(35,6,'Number of Presents',1,0,'C');
        
        // Hours of Late
        $this->Cell(35,6,'Hours of Late',1,0,'C');
        
        // Number of Absents
        $this->Cell(35,6,'Number of Absents',1,0,'C');
        
        // Number of Halfdays
        $this->Cell(35,6,'Number of Halfdays',1,1,'C');

        // loop through the query results
        while ($row = mysqli_fetch_assoc($result)) {
            $employee_id = $row['employee_id'];
            $employee_name = $row['employee_name'];
            $hours_worked = $row['total_hours_worked'];
            $hours_ot = $row['total_hours_overtime'];
            $total_late = $row['late_count'];
            $total_absent = $row['absent_count'];
            $total_present = $row['present_count'];
            $total_halfday = $row['halfday_count'];
            $minutes_worked = $row['total_hours_worked'] * 60;
            $minutes_ot = $row['total_hours_overtime'] * 60;
            
            $late = $row['total_late'];
            
            // Calculate the total late minutes and format the display
            $hours_late = floor($late / 60);
            $minutes_late = $late % 60;
            $total_late = ($hours_late > 0 ? $hours_late . " " . ($hours_late == 1 ? "hour" : "hours") : "--");
            
            
            // Calculate the total minutes worked and format the display
            $total_minutes_worked = ($minutes_worked + $minutes_ot) - $late;
            $hrsworked = floor($total_minutes_worked / 60);
            $minutesworked = $total_minutes_worked % 60;
            $total_hours_worked = ($hrsworked > 0 ? $hrsworked . " " . ($hrsworked == 1 ? "hour" : "hours") : "--");
            
            if ($late > 0) {
            $total_late = "";
            if ($hours_late > 0) {
                $total_late .= $hours_late . " " . ($hours_late == 1 ? "hour" : "hours");
            }
            if ($minutes_late > 0) {
                $total_late .= ($hours_late > 0 ? " & " : "") . $minutes_late . " minutes";
            }
            } else {
                $total_late = "--";
            }
            
            if ($total_minutes_worked > 0) {
                $total_hours_worked = "";
                if ($hrsworked > 0) {
                    $total_hours_worked .= $hrsworked . " " . ($hrsworked == 1 ? "hour" : "hours");
                }
                if ($minutesworked > 0) {
                    $total_hours_worked .= ($hrsworked > 0 ? " & " : "") . $minutesworked . " minutes";
                }
            } else {
                $total_hours_worked = "--";
            }

        
        
        // Employee ID
        $this->Cell(30, 6, !empty($employee_id) ? $employee_id : "--", 1, 0, 'C');
    
        // Employee Name
        $this->SetFont('Arial', '', 10);
        $cellWidth = 50;
        $cellText = !empty($employee_name) ? $employee_name : "--";
        $cellHeight = 6;
        if ($this->GetStringWidth($cellText) > $cellWidth) {
            // Text is too long for the cell, reduce font size
            $this->SetFont('Arial', '', 8);
            $cellHeight = 6;
        }
        $this->Cell($cellWidth, $cellHeight, $cellText, 1, 0, 'C');
        
        $this->SetFont('Arial', '', 10);
        
        // Hours of Work
        $this->Cell(30, 6, !empty($hours_worked) ? $hours_worked : "--", 1, 0, 'C');
    
        // Hours of Overtime
        $this->Cell(30, 6, !empty($hours_ot) ? $hours_ot : "--", 1, 0, 'C');
        
        // Number of Presents
        $this->Cell(35, 6, !empty($total_present) ? $total_present  : "--", 1, 0, 'C');
        
        // Number of Lates
        $this->Cell(35, 6, !empty($total_late) ? $total_late  : "--", 1, 0, 'C');
        
        // Number of Absents
        $this->Cell(35, 6, !empty($total_absent) ? $total_absent  : "--", 1, 0, 'C');
        
        // Number of Half Day
        $this->Cell(35, 6, !empty($total_halfday) ? $total_halfday  : "--", 1, 1, 'C');
        
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
$pdf->SetTitle("BERGS_SUMMARY");
$pdf->SetAuthor('BERGS');

$pdf->Output();
?>