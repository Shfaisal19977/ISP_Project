<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string|in:ADSL,IPTV',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::find($request->user_id);
        $amount = $request->amount;

        if ($user->balance < $amount) {
            return response()->json(['error' => 'Insufficient balance'], 400);
        }

        $payment = Payment::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'payment_date' => now(),
            'status' => 'completed',
            'type' => $request->type,
        ]);

        $user->balance -= $amount;
        $user->save();

        return response()->json(['message' => 'Payment successful', 'payment' => $payment], 201);
    }

    public function getPayments(Request $request, $userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $payments = $user->payments()->get(['id', 'amount', 'payment_date', 'status', 'type']);

        return response()->json(['payments' => $payments]);
    }

    public function deletePayment($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        $payment->delete();

        return response()->json(['message' => 'Payment deleted successfully']);
    }

    public function updatePayment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        $payment->update([
            'amount' => $request->amount,
            'status' => $request->status,
        ]);
        return response()->json(['message' => 'Payment updated successfully', 'payment' => $payment]);
    }
}
