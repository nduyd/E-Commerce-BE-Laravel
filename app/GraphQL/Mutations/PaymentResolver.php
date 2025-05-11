<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Payment;
use Illuminate\Support\Facades\Validator;
use App\Services\AuthService;
use App\GraphQL\Traits\GraphQLResponse;

final readonly class PaymentResolver
{

    use GraphQLResponse;

    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        // TODO implement the resolver
    }

    public function createPayment($_, array $args)
    {
        $validator=Validator::make($args,[
            'order_id'=>'required|exists:orders,id',
            'payment_method_id'=>'required|"cod"|"bank_transfer"',
            'amount'=>'required|numeric',
            'status'=>'required|"pending"|"completed"|"failed"|"refunded"',
            'transaction_ref'=>'required|string',
        ]);
        if($validator->fails()){
            return $this->error($validator->errors()->first(), 400);
        }

        $user = auth('api')->user();

        try {
            $payment = Payment::create([
                'order_id' => $args['order_id'],
                'payment_method_id' => $args['payment_method_id'],
                'amount' => $args['amount'],
                'paid_date' => now(),
                'status' => $args['status'],
                'transaction_ref' => $args['transaction_ref'],
            ]);
    
            return $this->success([
                'payment' => $payment,
            ], 'Payment created successfully', 200);
    
        } catch (\Exception $e) {
            return $this->error('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    public function updatePayment($_, array $args)
    {
        $validator=Validator::make($args,[
            'id'=>'required|exists:payments,id',
            'order_id'=>'required|exists:orders,id',
            'payment_method_id'=>'required|"cod"|"bank_transfer"',
            'amount'=>'required|numeric',
            'paid_date'=>'required|date',
            'status'=>'required|"pending"|"completed"|"failed"|"refunded"',
            'transaction_ref'=>'required|string',
        ]);
        if($validator->fails()){
            return $this->error($validator->errors()->first(), 400);
        }

        $user = auth('api')->user();

        try {
            $payment = $user->payment()->where('id', $args['id'])->first();
            if (!$payment) {
                return $this->error('Payment not found', 404);
            }
    
            $payment->update([
                'payment_method_id' => $args['payment_method_id'],
                'paid_date' => $args['paid_date'],
                'amount' => $args['amount'],
                'status' => $args['status'],
                'transaction_ref' => $args['transaction_ref'],
            ]);
    
            return $this->success([
                'payment' => $payment,
            ], 'Payment updated successfully', 200);
    
        } catch (\Exception $e) {
            return $this->error('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    public function updatePaymentStatus($_, array $args)
    {
        $validator=Validator::make($args,[
            'id'=>'required|exists:payments,id',
            'status'=>'required|"pending"|"completed"|"failed"|"refunded"',
        ]);
        if($validator->fails()){
            return $this->error($validator->errors()->first(), 400);
        }

        $user = auth('api')->user();
        
        try {
            $payment = $user->payment()->where('id', $args['id'])->first();
            if (!$payment) {
                return $this->error('Payment not found', 404);
            }
    
            $payment->update([
                'status' => $args['status'],
            ]);
    
            return $this->success([
                'payment' => $payment,
            ], 'Payment status updated successfully', 200);
    
        } catch (\Exception $e) {
            return $this->error('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    public function deletePayment($_, array $args)
    {
        $validator=Validator::make($args,[
            'id'=>'required|exists:payments,id',
        ]);
        if($validator->fails()){
            return $this->error($validator->errors()->first(), 400);
        }

        $user = auth('api')->user();

        try {
            $order = $user->order()->where('payment_id', $args['id'])->first();
            if(!$order){
                return $this->error('Order not found', 404);
            }

            $payment = $order->payment();
            if (!$payment) {
                return $this->error('Payment not found', 404);
            }
    
            $payment->delete();
    
            return $this->success(null, 'Payment deleted successfully', 200);
    
        } catch (\Exception $e) {
            return $this->error('An error occurred: ' . $e->getMessage(), 500);
        }
    }
}
