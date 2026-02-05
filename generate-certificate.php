<?php
ob_start(); // VERY IMPORTANT: prevent output
session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

include("../db/connection.php");

$id = $_SESSION['student_id'];

$data = mysqli_fetch_assoc(
    mysqli_query($conn,
        "SELECT s.*, c.*
         FROM students s
         JOIN clearances c ON s.id = c.student_id
         WHERE s.id=$id")
);

if (
    $data['academic_status'] != 'Cleared' ||
    $data['library_status'] != 'Cleared' ||
    $data['dsa_status'] != 'Cleared' ||
    $data['fine_status'] != 'Cleared'
) {
    die("Clearance not completed yet.");
}

require('../fpdf/fpdf.php');

class PDF extends FPDF {

    public $angle = 0; // 🔥 FIX #1

    function Header() {
        // Watermark
        $this->SetFont('Arial','B',40);
        $this->SetTextColor(200,200,200);
        $this->RotatedText(35,190,'UNIVERSITY OF ENGINEERING & TECHNOLOGY',45);
    }

    function RotatedText($x, $y, $txt, $angle) {
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

    function Rotate($angle, $x = -1, $y = -1) {
        if ($x == -1)
            $x = $this->x;
        if ($y == -1)
            $y = $this->y;

        if ($this->angle != 0)
            $this->_out('Q');

        $this->angle = $angle;

        if ($angle != 0) {
            $angle *= M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;

            $this->_out(sprintf(
                'q %.5F %.5F %.5F %.5F %.5F %.5F cm 1 0 0 1 %.5F %.5F cm',
                $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy
            ));
        }
    }

    function Footer() {
        if ($this->angle != 0) {
            $this->angle = 0;
            $this->_out('Q');
        }
    }
}

$pdf = new PDF();
$pdf->AddPage();

// Reset color
$pdf->SetTextColor(0,0,0);

$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'UNIVERSITY CLEARANCE CERTIFICATE',0,1,'C');
$pdf->Ln(10);

$pdf->SetFont('Arial','',12);
$pdf->MultiCell(0,10,'This is to certify that the following student has successfully cleared all university dues.');

$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,'Name: '.$data['full_name'],0,1);
$pdf->Cell(0,10,'Roll No: '.$data['roll_number'],0,1);
$pdf->Cell(0,10,'Department: '.$data['department'],0,1);
$pdf->Cell(0,10,'Session: '.$data['session'],0,1);

$pdf->Ln(15);
$pdf->SetFont('Arial','',12);
$pdf->MultiCell(0,10,'All dues including Academic, Library, DSA and Fine departments have been verified and cleared.');

$pdf->Ln(20);

// Admin signature
$pdf->Image('../assets/signature/admin-signature.png',130,210,40);
$pdf->Ln(35);

$pdf->Cell(130);
$pdf->Cell(60,5,'_________________________',0,1,'C');
$pdf->Cell(130);
$pdf->Cell(60,5,'Admin Signature',0,1,'C');

$pdf->Ln(10);
$pdf->Cell(0,10,'Date: '.date('d-m-Y'),0,1,'L');

$pdf->Output();
ob_end_flush(); // 🔥 FIX #2
