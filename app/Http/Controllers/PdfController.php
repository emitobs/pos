<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\Client;

class PdfController extends Controller
{
    public function generatePDF(Request $request)
    {
        $client = Client::find($request->session()->get('client_id'));
        $pdf = PDF::loadView('pdfs.invoice_monthly', ['selected_client' => $client]);
        return $pdf->stream('itsolutionstuff.pdf');
    }
}
