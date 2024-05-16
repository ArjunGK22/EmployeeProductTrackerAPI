<?php

namespace App\Http\Controllers;

use App\Exports\TransactionsExport;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;

class ProdTransExportController extends Controller
{
    public function exportTransactions()
    {
        return Excel::download(new TransactionsExport(), 'transactions.xlsx');
    }

    public function exportProducts()
    {
        return Excel::download(new ProductsExport(), 'products.xlsx');
    }
}
