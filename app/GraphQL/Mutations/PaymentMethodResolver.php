<?php

namespace App\GraphQL\Mutations;
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

    public function createPaymentMethod($_, array $args): array
    {
        $validator = Validator::make($args, [
            'method' => 'required|string',
            'is_default' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 400);
        }

        $user = auth('api')->user();

        try{
            $paymentMethod = PaymentMethod::create([
                'user_id' => $user->id,
                'method' => $args['method'],
                'is_default' => $args['is_default'],
            ]);

            return $this->success([
                'paymentMethod' => $paymentMethod,
            ], 'Payment method created successfully', 200);

        } catch (\Exception $e) {
            return $this->error('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    public function updatePaymentMethod($_, array $args): array
    {
        $validator = Validator::make($args, [
            'id' => 'required|exists:payment_methods,id',
            'method' => 'required|string',
            'is_default' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 400);
        }

        $user = auth('api')->user();

        try{
            $paymentMethod = PaymentMethod::where('id', $args['id'])
                ->where('user_id', $user->id)
                ->first();

            if (!$paymentMethod) {
                return $this->error('Payment method not found or does not belong to the user', 404);
            }

            $paymentMethod->update([
                'method' => $args['method'],
                'is_default' => $args['is_default'],
            ]);

            return $this->success([
                'paymentMethod' => $paymentMethod,
            ], 'Payment method updated successfully', 200);

        } catch (\Exception $e) {
            return $this->error('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    public function deletePaymentMethod($_, array $args): array
    {
        $validator = Validator::make($args, [
            'id' => 'required|exists:payment_methods,id',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 400);
        }

        $user = auth('api')->user();

        try{
            $paymentMethod = PaymentMethod::where('id', $args['id'])
                ->where('user_id', $user->id)
                ->first();

            if (!$paymentMethod) {
                return $this->error('Payment method not found or does not belong to the user', 404);
            }

            $paymentMethod->delete();

            return $this->success([], 'Payment method deleted successfully', 200);

        } catch (\Exception $e) {
            return $this->error('An error occurred: ' . $e->getMessage(), 500);
        }
    }
}