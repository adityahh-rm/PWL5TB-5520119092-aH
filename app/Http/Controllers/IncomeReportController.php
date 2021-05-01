<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\facades\Storage;

use App\Models\Product;
use App\Models\IncomeReport;
use PDF;

class IncomeReportController extends Controller
{
    // views
    public function income_reports()
    {
        $user = Auth::user();
        $products = Product::all();
        $income_reports = IncomeReport::all();
            return view('income_reports', compact('user', 'products', 'income_reports'));
    }

    public function print_incomes()
    {
        $income_reports = IncomeReport::all();

        $pdf = PDF::loadview('print_incomes', ['income_reports' => $income_reports]);
        return $pdf->download('Income-report.pdf');
    }


}
