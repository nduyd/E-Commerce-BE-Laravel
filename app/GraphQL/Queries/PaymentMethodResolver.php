<?php

namespace App\GraphQL\Queries;
/**
 * paymentMethod:
 * create
 * update delete
 * 
 * 
 * payment:
 * update
 * delete
 * create
 */

use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Validator;
use App\GraphQL\Traits\GraphQLResponse;
final readonly class PaymentMethodResolver
{
    use GraphQLResponse;

    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        // TODO implement the resolver
    }

    public function getPaymentMethods($_, array $args): array
    {
        $user = auth('api')->user();

        try {
            $paymentMethods = PaymentMethod::where('user_id', $user->id)->get();

            return $this->success([
                'paymentMethods' => $paymentMethods,
            ], 'Payment methods retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->error('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    public function getPaymentMethod($_, array $args): array
    {
        $validator = Validator::make($args, [
            'id' => 'required|exists:payment_methods,id',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 400);
        }

        try {
            $user = auth('api')->user();
            $paymentMethod = PaymentMethod::where('id', $args['id'])
                ->where('user_id', $user->id)
                ->first();
                
            if (!$paymentMethod) {
                return $this->error('Payment method not found or does not belong to the user', 404);
            }

            return $this->success([
                'paymentMethod' => $paymentMethod,
            ], 'Payment method retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->error('An error occurred: ' . $e->getMessage(), 500);
        }
    }
}