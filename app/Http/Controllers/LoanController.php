<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function index()
    {
        // On this page you can even get all loans and then you will filter them on view
        $allloans = Loan::all();
        $loanrequests = Loan::where('status', 'pending')->get();
        $loanrejected = Loan::where('status', 'declined')->get();
        $loanapproved = Loan::where('status', 'approved')->get();
        return view('dashboards.loan.index', compact('loanrequests', 'loanapproved', 'loanrejected', 'allloans'));
    }

    public function userLoans($user_id)
    {
        $loan = Loan::where('user_id', $user_id)->get();

        return view('dashboards.loan.user', compact($loan));
    }

    public function apply(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'amount' => 'required',
            'monthly_income' => 'required',
            'status' => 'required|in:pending,approved,declined',
        ]);

        $loan = Loan::where('user_id', $user->id)->first();

        // Verify if user amount request is not exceding the third of his or her monthly salary

        if ($request->amount > $loan->monthly_income / 3) {
            return redirect()->back()->with('error', 'The loan amount must not exceed third of your monthly income');
        }

        // Create a new loan record
        $user = Loan::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        // You can notify and admin here that there is new loan application sent using laravel mail

        return redirect()->back()->with('success', 'Loan Applied successfully.');
    }

    public function update(Request $request, $loan_id)
    {
        // Validate the request
        $request->validate([
            'status' => 'required|in:pending,approved,declined',
        ]);

        // Find the loan by its id as the user can have more than one loan
        $loan = Loan::findOrFail($loan_id);

        if (!$loan->status == 'pending') {
            // the loan has been already updated, either approved or rejected
            return redirect()->back()->with('error', 'Loan is already updated!');
        }

        $loan->status = $request->status;
        $loan->update();

        // You can also use mailing notifiication to notify the user anytime there is change on his/her loan

        if ($request->status == 'approved') {
            return redirect()->back()->with('success', 'The loan request is approved successfully`');
        } else {
            return redirect()->back()->with('success', 'The loan request is rejected');
        }
    }
}
