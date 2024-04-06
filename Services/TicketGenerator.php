<?php

require 'vendor/autoload.php';
require  'vendor/tecnickcom/tcpdf/tcpdf.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class PDF extends TCPDF {
    function Header() {

    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, '©' . date('Y') . ' Tisat. All rights reserved.', 0, 1, 'C');
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

function generateTicket($ticketInfo, $action) {
    $ticketId = $ticketInfo['ticketId'];
    $eventName = $ticketInfo['eventName'];
    $eventDate = $ticketInfo['eventDate'];
    $eventVenue = $ticketInfo['eventVenue'];
    $purchaseDate = $ticketInfo['purchaseDate'];
    $buyerName = $ticketInfo['buyerName'];
    $ticketHolderName = $ticketInfo['ticketHolderName'];
    $price = $ticketInfo['price'];

    $pdf = new PDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator('Someone');
    $pdf->SetAuthor('Someone');
    $pdf->SetTitle('Event Ticket');
    $pdf->SetHeaderData('', 0, '', '');
    $pdf->SetHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->SetFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    $pdf->AddPage();
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
    $pdf->ImageSVG('C:\xampp\htdocs\TicketingPlatform\Static\other\pic.svg', $x=30, $y=6, $w=25, $h=25, $align='', $palign='', $border=1, $fitonpage=false);
    $pdf->Ln(15);
    $pdf->SetTextColor(0, 0, 0);

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

    if ($action === 'view') {
        $pdf->Output('event_ticket.pdf', 'I');
    } elseif ($action === 'download') {
        $pdf->Output('event_ticket.pdf', 'D');
    }
}



