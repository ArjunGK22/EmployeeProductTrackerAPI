<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use \Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;

class PDFGenerationController extends Controller
{
    //

    public function generatePDF(\Codedge\Fpdf\Fpdf\Fpdf $pdf)
    {
        // Fetch the transaction with the given ID, including user and products
        $transaction = Transaction::with(['user', 'products'])->findOrFail(2);

        // Create a new PDF document
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 12);

        // Add header
        $this->addHeader($pdf);

        // Add transaction and user details
        $this->addTransactionDetails($pdf, $transaction);

        // Add products table
        $this->addProductsTable($pdf, $transaction->products);

        // Add footer
        $this->addFooter($pdf);

        // Output the PDF
        $pdf->Output('D', 'transaction_' . $transaction->id . '.pdf');
    }

    private function addHeader($pdf)
    {
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'PageSoft Private Limited', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 5, 'No. 17, 2nd Floor, 2nd Main Srinidhi Layout, ', 0, 1, 'C');
        $pdf->Cell(0, 5, 'KSRTC Layout, Herohalli,', 0, 1, 'C');
        $pdf->Cell(0, 5, 'Bengaluru - 91, Karnataka', 0, 1, 'C');
        $pdf->Cell(0, 5, 'India', 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->SetTextColor(61, 145, 61);
        $pdf->Cell(0, 10, 'INVOICE', 0, 1, 'R');
        $pdf->Ln(10);
    }

    private function addTransactionDetails($pdf, $transaction)
    {
        // Invoice details
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 5, 'Invoice# :' .$transaction->id, 0, 1);
        $pdf->Cell(0, 5, 'Invoice Date : ' . $transaction->created_at->format('d M Y'), 0, 1);
        $pdf->Cell(0, 5, 'Terms : Due on Receipt', 0, 1);
        $pdf->Ln(10);

        // Billing and shipping details
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(95, 5, 'Bill To', 1, 0);
        $pdf->Cell(95, 5, 'Ship To', 1, 1);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(95, 5, 'Name: '.$transaction->user->name, 1, 0);
        $pdf->Cell(95, 5, 'Name: '.$transaction->user->name, 1, 1);
        $pdf->Cell(95, 5, 'Email: '.$transaction->user->email, 1, 0);
        $pdf->Cell(95, 5, 'Email: '.$transaction->user->email, 1, 1);
        $pdf->Cell(95, 5, 'Phone: '.$transaction->user->phone, 1, 0);
        $pdf->Cell(95, 5, 'Phone: '.$transaction->user->phone, 1, 1);
        $pdf->Ln(10);
    }

    private function addProductsTable($pdf, $products)
    {
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(61, 145, 61);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(10, 10, 'Sl#', 1, 0, 'C', true);
        $pdf->Cell(90, 10, 'Description of Item', 1, 0, 'C', true);
        $pdf->Cell(20, 10, 'Qty', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'Rate', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'Total Amount', 1, 1, 'C', true);

        // Table body
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(240, 240, 240);
        $fill = false;
        $i = 1;
        $totalAmount = 0;

        foreach ($products as $product) {
            $pdf->Cell(10, 10, $i++, 1, 0, 'C', $fill);
            $pdf->Cell(90, 10, $product->productname, 1, 0, 'L', $fill);
            $pdf->Cell(20, 10, $product->pivot->quantity . ' Piece', 1, 0, 'C', $fill);
            $pdf->Cell(35, 10, number_format($product->price, 2), 1, 0, 'R', $fill);
            $pdf->Cell(35, 10, number_format($product->pivot->total_price, 2), 1, 1, 'R', $fill);
            $fill = !$fill;
            $totalAmount += $product->pivot->total_price;
        }

        // Sub Total
        $pdf->Cell(155, 10, 'Sub Total', 1, 0, 'R');
        $pdf->Cell(35, 10, number_format($totalAmount, 2), 1, 1, 'R');

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(173, 216, 230);
        $pdf->Cell(0, 10, 'GST Rate: 18.00%', 0, 1, 'R', true);
        $pdf->Cell(0, 10, 'Grand Total: ' . number_format($totalAmount * 1.18, 2), 0, 1, 'R', true);
    }

    private function addFooter($pdf)
    {
        $pdf->Ln(20);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 5, 'Thanks you!.', 0, 1);
        $pdf->Cell(0, 5, 'Terms & Conditions', 0, 1);
    }
}
