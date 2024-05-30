<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Dashboard/Dashboard');
    }

    /**
     * Redirect from short url.
     */
    public function redirect_url(Request $request)
    {
        $transaction = Transaction::select('short_url', 'full_url')
                        ->where('short_url', $request->url())
                        ->first();

        if (!$transaction)
            abort(404);

        return redirect($transaction->full_url);
    }

    /**
     * Display invoice public.
     */
    public function invoice(Request $request, $id): Response
    {
        if (!$request->hasValidSignature())
            abort(404);

        $data = Transaction::with(['user', 'orders', 'orders.orderDetails'])
            ->whereId($id)
            ->first();
    
        if (!$data) {
            abort(404);
        }

        return Inertia::render('Transaction/Invoice', [
            'data' => $data,
            'public' => true
        ]);
    }
}
