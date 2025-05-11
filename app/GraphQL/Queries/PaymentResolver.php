<?php 
namespace App\GraphQL\Queries;

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
    public function getPayment($_, array $args)
    {
        // $orderId = $args['order_id'] ?? null;
        $user = auth('api')->user();

        $payment = $user->payments()
            ->where('id', $args['id'])
            ->first();
        if (!$payment) {
            return $this->error('Payment not found', 404);
        }

        return $this->success([
            'payment' => $payment,
        ], 'Success', 200);
    }

    public function getPayments($_, array $args)
    {
        $user = auth('api')->user();

        $payments = $user->payments()
            ->get();
        if ($payments->isEmpty()) {
            return $this->error('No payments found', 404);
        }

        return $this->success([
            'payments' => $payments,
        ], 'Success', 200);
    }
    
    public function getPaymentByOrderId($_, array $args)
    {
        $user = auth('api')->user();

        $payment = $user->payments()
            ->where('order_id', $args['order_id'])
            ->first();
        if (!$payment) {
            return $this->error('Payment not found', 404);
        }

        return $this->success([
            'payment' => $payment,
        ], 'Success', 200);
    }

    public function getPaymentByTransactionRef($_, array $args)
    {
        $user = auth('api')->user();

        $payment = $user->payments()
            ->where('transaction_ref', $args['transaction_ref'])
            ->first();
        if (!$payment) {
            return $this->error('Payment not found', 404);
        }

        return $this->success([
            'payment' => $payment,
        ], 'Success', 200);
    }

    public function getPaymentStatus($_, array $args)
    {
        $user = auth('api')->user();

        $payment = $user->payments()
            ->where('id', $args['id'])
            ->first();
        if (!$payment) {
            return $this->error('Payment not found', 404);
        }

        return $this->success([
            'status' => $payment->status,
        ], 'Success', 200);
    }
}
