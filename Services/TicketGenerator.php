<?php

require 'vendor/tecnickcom/tcpdf/tcpdf.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class PDF extends TCPDF {
    function Header() {

    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, '©' . date('Y') . ' Dali Guerfali tickets Business. All rights reserved.', 0, 1, 'C');
    }
}

function generateQrCode($id) {
    $qrCode = new QrCode($id);
    $writer = new PngWriter();
    $result = $writer->write($qrCode);
    $tmpFile = tempnam(sys_get_temp_dir(), 'qr_code');
    $result->saveToFile($tmpFile);
    return $tmpFile;
}

// possible actions for single ticket: download or view in browser
function generateSingleTicket($ticketInfo, $action) {
    $pdf = createPDF();
    $pdf->AddPage();
    addTicketContent($pdf, $ticketInfo);
    outputPDF($pdf, $action);
}

// the combined tickets pdf file is created to be saved and sent via email then deleted
function generateCombinedTickets($ticketInfoArray, $fileName) {
    $pdf = createPDF();
    foreach ($ticketInfoArray as $ticketInfo) {
        $pdf->AddPage();
        addTicketContent($pdf, $ticketInfo);
    }
    savePDF($pdf, $fileName . '.pdf');
}

function createPDF() {
    $pdf = new PDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator('Someone');
    $pdf->SetAuthor('Someone');
    $pdf->SetTitle('Event Ticket');
    $pdf->SetHeaderData('', 0, '', '');
    $pdf->SetHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->SetFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    return $pdf;
}


function addTicketContent($pdf, $ticketInfo) {
    $eventName = $ticketInfo['eventName'];
    $eventDate = $ticketInfo['eventDate'];
    $eventVenue = $ticketInfo['eventVenue'];
    $purchaseDate = $ticketInfo['purchaseDate'];
    $buyerName = $ticketInfo['buyerName'];
    $ticketHolderName = $ticketInfo['ticketHolderName'];
    $price = $ticketInfo['price'];
    $ticketId = $ticketInfo['ticketId'];


    $pdf->SetFillColor(255, 255, 255);

    // Title
    $margin = 50;
    $pdf->SetTextColor(24, 41, 135);
    $pdf->SetFont('helvetica', 'B', 26);
    $titleWidth = $pdf->GetStringWidth($eventName . ' Ticket');
    $availableWidth = $pdf->getPageWidth() - $margin - $margin;
    $pdf->SetXY($margin, $pdf->GetY());
    if ($titleWidth > $availableWidth) {
        $pdf->MultiCell($availableWidth, 15, $eventName . ' Ticket', 0, 'C', true);
    } else {
        $pdf->Cell($availableWidth, 15, $eventName . ' Ticket', 0, 1, 'C', true);
    }

    $pdf->Image('qrcode.png', 160, 60, 30);
    $pdf->ImageSVG(__DIR__ . "/../Static/other/pic.svg", $x=30, $y=6, $w=25, $h=25, $align='', $palign='', $border=1, $fitonpage=false);

    // Company Name
    $pdf->SetFont('helvetica', 'I', 12);
    $companyNameY = $pdf->GetY() ;
    $pdf->SetXY($margin, $companyNameY);
    $pdf->Cell($availableWidth, 10, "Dali Guerfali tickets business", 0, 1, 'C');


    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln(15);

    // Event Information
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(95, 10, 'Event Information', 0, 0, 'L');
    $pdf->Cell(95, 10, '', 0, 1, 'R');
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(95, 10, "Event: $eventName", 0, 1, 'L', true);
    $pdf->Ln(5);
    $pdf->Cell(95, 10, "Date: $eventDate", 0, 1, 'L', true);
    $pdf->Ln(5);
    $pdf->Cell(95, 10, "Venue: $eventVenue", 0, 1, 'L', true);
    $pdf->Ln(5);

    // QR Code
    $tmpFile = generateQrCode($ticketId);
    $pdf->Image($tmpFile, 145, $pdf->GetY() - 55, 50);
    $pdf->Ln(10);

    // Some bold Line
    $pdf->SetDrawColor(24, 41, 135);
    $pdf->SetLineWidth(1.5);
    $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
    $pdf->Ln(10);

    // Ticket Information
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(95, 10, 'Ticket Information', 0, 0, 'L');
    $pdf->Cell(95, 10, '', 0, 1, 'R');
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(95, 10, "Purchase Date: $purchaseDate", 0, 1, 'L', true);
    $pdf->Ln(5);
    $pdf->Cell(95, 10, "Buyer: $buyerName", 0, 1, 'L', true);
    $pdf->Ln(5);
    $pdf->Cell(95, 10, "Ticket Holder: $ticketHolderName", 0, 1, 'L', true);
    $pdf->Ln(5);
    $pdf->Cell(95, 10, "Price: " . $price . " $", 0, 1, 'L', true);
}

function outputPDF($pdf, $action) {
    if ($action === 'view') {
        $pdf->Output('event_ticket.pdf', 'I');
    } elseif ($action === 'download') {
        $pdf->Output('event_ticket.pdf', 'D');
    }
}

function savePDF($pdf, $filename) {
    if (!file_exists(__DIR__ . '/../Static/attachments')) {
        mkdir(__DIR__ . '/../Static/attachments', 0777, true);
    }
    $filePath = __DIR__ . '/../Static/attachments/' . $filename;
    $pdf->Output($filePath, 'F');
}

