<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $data = Transaction::where('user_id', $request->user()->id)
                ->orderBy('id', 'DESC')
                ->paginate(50);

        return Inertia::render('Transactions', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // $request->validate([
        //     'total_price' => 'required|min:0|not_in:0',
        // ]);

        // Start Transaction
        DB::beginTransaction();

        try {
            // (string)Str::uuid()
            // Create
            $transaction = Transaction::create([
                'user_id' => $request->user()->id,
                'name' => $request->name,
                'trx_code' => 'INV/'.Carbon::now()->format('Ymd').'/MVS/'.Str::random(16),
                'total_price' => intval(str_replace('.','',$request->total_price)),
                'total_payment' => intval(str_replace('.','',$request->total_payment))
            ]);

            // Update URL Public
            $short_url = route('sh', ['code' => Str::random(16)]);
            $full_url = URL::signedRoute(
                'invoice', ['id' => $transaction->id]
            );
            $transaction->update([
                'short_url' => $short_url,
                'full_url' => $full_url
            ]);
            
            // Create orders
            foreach ($request->orders as $order) {
                $create_order = Order::create([
                    'transaction_id' => $transaction->id,
                    'name' => $order['name'],
                    'total_price' => intval(str_replace('.','',$order['total_price']))
                ]);

                // Create order detail
                if ($order['temp']['is_detail'])
                    foreach ($order['detail'] as $detail) {
                        OrderDetail::create([
                            'order_id' => $create_order->id,
                            'name' => $detail['name'],
                            'qty' => intval(str_replace('.','',$detail['qty'])),
                            'price' => intval(str_replace('.','',$detail['price']))
                        ]);
                    }
            }

            // All success
            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            // something went wrong
            DB::rollback();
        }

        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        // Start Transaction
        DB::beginTransaction();
        try {
            // Create
            $transaction = Transaction::create([
                'user_id' => $request->user()->id,
                'trx_code' => 'INV/'.Carbon::now()->format('Ymd').'/MVS/'.(string)Str::uuid(),
                'total_price' => intval(str_replace('.','',$request->total_price)),
                'total_payment' => intval(str_replace('.','',$request->total_payment))
            ]);

            // Update URL Public
            $short_url = route('sh', ['code' => Str::random(16)]);
            $full_url = URL::signedRoute(
                'invoice', ['id' => $transaction->id]
            );
            $transaction->update([
                'short_url' => $short_url,
                'full_url' => $full_url
            ]);
            
            // Create orders
            foreach ($request->orders as $order) {
                $create_order = Order::create([
                    'transaction_id' => $transaction->id,
                    'name' => $order['name'],
                    'total_price' => intval(str_replace('.','',$order['total_price']))
                ]);

                // Create order detail
                if ($order['temp']['is_detail'])
                    foreach ($order['detail'] as $detail) {
                        OrderDetail::create([
                            'order_id' => $create_order->id,
                            'name' => $detail['name'],
                            'qty' => intval(str_replace('.','',$detail['qty'])),
                            'price' => intval(str_replace('.','',$detail['price']))
                        ]);
                    }
            }

            // All success
            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            // something went wrong
            DB::rollback();
        }

        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
