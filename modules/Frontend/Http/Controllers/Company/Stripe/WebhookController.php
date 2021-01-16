<?php

namespace Modules\Frontend\Http\Controllers\Company\Stripe;

use App\Models\Company;
use Carbon\Carbon;
use Debugbar;
use Exception;
use Illuminate\Http\Request;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Log;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentMethod;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Response;

class WebhookController extends CashierController
{
    public function handleWebhook(Request $request): Response
    {
        Debugbar::disable();
        $payload = json_decode($request->getContent(), true);
        Log::debug($payload['type']);
        return parent::handleWebhook($request);
    }

    protected function handleCustomerSubscriptionCreated(array $payload): Response
    {
        return $this->createOrUpdateSubscription($payload);
    }

    protected function createOrUpdateSubscription(array $payload): Response
    {
        /* @var $company Company */
        $company = $this->getUserByStripeId($payload['data']['object']['customer']);
        Log::debug($payload);
        if ($company) {
            $data = $payload['data']['object'];

            if (!$company->subscriptions->contains('stripe_id', $data['id'])) {

                if (isset($data['trial_end'])) {
                    $trialEndsAt = Carbon::createFromTimestamp($data['trial_end']);
                } else {
                    $trialEndsAt = null;
                }

                $update = [
                    'name' => 'default',
                    'stripe_id' => $data['id'],
                    'stripe_status' => $data['status'],
                    'stripe_plan' => $data['plan']['id'] ?? null,
                    'quantity' => $data['quantity'],
                    'trial_ends_at' => $trialEndsAt,
                    'ends_at' => null,
                ];
                $subscription = null;
                if ($subscription = $company->subscription()) {
                    try {
                        $subscription->noProrate()->cancelNow();
                    } catch (Exception $e) {
                        Log::error('Can\'t cancel subscription: ' . $e->getMessage() . $e->getTraceAsString());
                    }
                    $subscription->items()->delete();
                    $subscription->update($update);
                } else {
                    $subscription = $company->subscriptions()->create($update);
                }

                foreach ($data['items']['data'] as $item) {
                    $subscription->items()->create([
                        'stripe_id' => $item['id'],
                        'stripe_plan' => $item['plan']['id'],
                        'quantity' => $item['quantity'],
                    ]);
                }

                try {
                    Stripe::setApiKey(config('services.stripe.secret'));
                    $paymentMethod = PaymentMethod::retrieve($data['default_payment_method']);
                    $company->update([
                        'card_brand' => $paymentMethod->card->brand,
                        'card_last_four' => $paymentMethod->card->last4
                    ]);
                } catch (ApiErrorException $e) {
                    Log::error('Can\'t retrieve payment method: ' . $e->getMessage() . $e->getTraceAsString());
                }

            }
        }

        return $this->successMethod();
    }

    protected function handleCustomerSubscriptionUpdated(array $payload): Response
    {
        return $this->createOrUpdateSubscription($payload);
    }

    protected function handleInvoicePaymentSucceeded($payload): Response
    {
        $data = $payload['data']['object'];
        $company = $this->getUserByStripeId($data['customer']);
        Log::debug('Invoice for :' . $company->name);
        if ($company) {
            Log::debug('Views for :' . $company->resume_views);
            $company->update(['resume_views' => 0]);
        }
        return $this->updateSubscriptionStatus($payload);
    }

    protected function updateSubscriptionStatus($payload): Response
    {
        $data = $payload['data']['object'];
        $company = $this->getUserByStripeId($data['customer']);
        if ($company) {
            if ($subscription = $company->subscription()) {
                $subscription->syncStripeStatus();
            }
        }

        return $this->successMethod();
    }

    protected function handleInvoicePaymentFailed($payload): Response
    {
        return $this->updateSubscriptionStatus($payload);
    }
}
