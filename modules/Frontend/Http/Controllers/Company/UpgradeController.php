<?php

namespace Modules\Frontend\Http\Controllers\Company;

use Exception;
use Illuminate\Http\JsonResponse;
use Log;
use Modules\Frontend\Http\Controllers\Controller;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Stripe;

class UpgradeController extends Controller
{
    use HasCompany;

    public function page()
    {
        $this->seo()->setTitle('Subscription');

        $company = $this->company();
        $subscription = $company->subscription();

        $plans = collect(config('simbok.plans'));
        $plans->transform(function (array $plan) use ($company, $subscription) {
            $plan['isActive'] = $company->subscribedToPlan($plan['stripe_plan']) && $subscription->valid();
            return $plan;
        });

        $card = [];
        if ($subscription) {
            $card['brand'] = $company->card_brand;
            $card['lastFour'] = $company->card_last_four;
        }

        share([
            'plans' => $plans,
            'hasTrial' => $subscription === null,
            'card' => $card,
            'stripeAPIToken' => config('services.stripe.key')
        ]);

        return view('frontend::company.subscribe.plans');
    }

    public function checkout(string $plan)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $company = $this->company();
        $subscription = $company->subscription();

        if ($company->subscribedToPlan($plan)) {
            return response()->noContent(403);
        }

        $session = CheckoutSession::create([
            'payment_method_types' => ['card'],
            'subscription_data' => [
                'items' => [['plan' => $plan]],
                'trial_period_days' => $subscription && $subscription->trial_ends_at ? 15 : null,
            ],
            'allow_promotion_codes' => true,
            'mode' => 'subscription',
            'customer' => $company->createOrGetStripeCustomer()->id,
            'success_url' => route('frontend.company.board'),
            'cancel_url' => route('frontend.company.upgrade.page'),
        ]);
        return response()->json(['session' => $session->id]);
    }

    public function cancel(): JsonResponse
    {
        $company = $this->company();
        if (($subscription = $company->subscription()) && $subscription->valid()) {
            try {
                $subscription->noProrate()->cancelNow();
                return response()->json(['message' => 'Subscription has been canceled.']);
            } catch (Exception $e) {
                Log::error('Can\'t cancel subscription: ' . $e->getMessage() . $e->getTraceAsString());
            }
        }
        return response()->json(['message' => 'No current subscription was found.'], 404);
    }

    /*
    public function intent(): SetupIntent
    {
        return $this->company()->createSetupIntent();
    }

    public function updatePlan(Request $request): JsonResponse
    {
        $company = $this->company();
        $planID = $request->get('plan');
        $paymentID = $request->get('payment');

        if (!$company->subscribed()) {
            $company->newSubscription('default', $planID)->create($paymentID);
        } else {
            $company->subscription()->swap($planID);
        }

        return response()->json([
            'subscription_updated' => true
        ]);
    }

    public function createPaymentMethod(Request $request): JsonResponse
    {
        $company = $this->company();
        $paymentMethodID = $request->get('payment_method');

        if ($company->stripe_id === null) {
            $company->createAsStripeCustomer();
        }

        $company->addPaymentMethod($paymentMethodID);
        $company->updateDefaultPaymentMethod($paymentMethodID);

        return response()->json(null, 204);
    }

    public function getPaymentMethods(Request $request): JsonResponse
    {
        $company = $this->company();

        $methods = [];

        if ($company->hasPaymentMethod()) {
            foreach ($company->paymentMethods() as $method) {
                $methods[] = [
                    'id' => $method->id,
                    'brand' => $method->card->brand,
                    'lastFour' => $method->card->last4,
                    'expMonth' => $method->card->exp_month,
                    'expYear' => $method->card->exp_year,
                    'isDefault' =>
                        ($company->card_last_four === $method->card->last4)
                        &&
                        ($company->card_brand === $method->card->brand)
                ];
            }
        }

        return response()->json($methods);
    }

    public function removePaymentMethod(Request $request): JsonResponse
    {
        $company = $this->company();
        $paymentMethodID = $request->get('id');

        $paymentMethods = $company->paymentMethods();

        foreach ($paymentMethods as $method) {
            if ($method->id == $paymentMethodID) {
                $method->delete();
                break;
            }
        }

        return response()->json(null, 204);
    }
    */
}
