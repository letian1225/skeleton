<?php

namespace Nikservik\Subscriptions;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Nikservik\Subscriptions\Facades\Payments;
use Nikservik\Subscriptions\Mail\SubscriptionAboutToRenew;
use Nikservik\Subscriptions\Mail\SubscriptionActivated;
use Nikservik\Subscriptions\Mail\SubscriptionCancelled;
use Nikservik\Subscriptions\Mail\SubscriptionEnded;
use Nikservik\Subscriptions\Mail\SubscriptionPastDue;
use Nikservik\Subscriptions\Mail\SubscriptionRejected;
use Nikservik\Subscriptions\Mail\SubscriptionRenewed;
use Nikservik\Subscriptions\Models\Subscription;
use Nikservik\Subscriptions\Models\Tariff;


class SubscriptionsManager 
{
    protected $warnBefore;
    protected $warnTime;

    public function __construct()
    {
        $this->warnBefore = config('subscriptions.before_charge.warn');
        $this->warnTime = config('subscriptions.before_charge.before');
    }

    public function activate(User $user, Tariff $tariff)
    {
        if ($tariff->price == 0)
            return $this->activateFree($user, $tariff);
        else
            return $this->activatePaid($user, $tariff);
    }

    public function activateDefault(User $user)
    {
        return $this->activateFree($user, $this->defaultTariff());
    }

    public function defaultTariff()
    {
        return Tariff::where('availability->default', true)->first();
    }

    public function needActivation(Subscription $subscription)
    {
        return $subscription->status == 'Awaiting';
    }
    
    public function confirmActivation(Subscription $subscription)
    {
        $subscription->last_transaction_date = Carbon::now();
        $subscription->status = 'Active';
        $subscription->save();
        $this->endPreviousSubscription($subscription);
        Mail::to($subscription->user->email)->queue(new SubscriptionActivated($subscription));
        return $subscription;
    }

    public function cancel(Subscription $subscription)
    {
        if ($subscription->next_transaction_date) 
            $subscription->status = 'Cancelled';
        else
            $subscription->status = 'Ended';
        $subscription->save();
        Mail::to($subscription->user->email)->queue(new SubscriptionCancelled($subscription));
        return $subscription;
    }

    public function chargePaid()
    {
        $toCharge = Subscription::where('next_transaction_date', '<', Carbon::now())
            ->where('status', 'Active')->where('price', '>', 0)->where('prolongable', true)->get();

        foreach ($toCharge as $subscription) {
            $this->charge($subscription);
        }
    }

    public function warnBeforeCharge()
    {
        if (! $this->warnBefore)
            return;

        $toWarn = Subscription::where('next_transaction_date', '>', 
                Carbon::now()->add($this->warnTime)->sub('12 hours'))
            ->where('next_transaction_date', '<', 
                Carbon::now()->add($this->warnTime)->add('12 hours'))
            ->where('status', 'Active')->where('price', '>', 0)
            ->where('prolongable', true)->get();

        foreach ($toWarn as $subscription) {
            Mail::to($subscription->user->email)->queue(new SubscriptionAboutToRenew($subscription));
        }
    }

    public function endOutdated()
    {
        $outdated = Subscription::where('next_transaction_date', '<', Carbon::now())
            ->where('prolongable', false)->get();

        foreach ($outdated as $subscription) {
            $subscription->status = 'Ended';
            $subscription->save();
            $this->activateDefault($subscription->user);
        }
    }

    public function endCancelled()
    {
        $outdated = Subscription::where('next_transaction_date', '<', Carbon::now())
            ->where('status', 'Cancelled')->get();

        foreach ($outdated as $subscription) {
            $subscription->status = 'Ended';
            $subscription->save();
            Mail::to($subscription->user->email)->queue(new SubscriptionEnded($subscription));
            $this->activateDefault($subscription->user);
        }
    }

    protected function activateFree(User $user, Tariff $tariff)
    {
        $subscription = $this->createSubscriptionFromTariff($tariff);
        $user->subscriptions()->save($subscription);
        $this->endPreviousSubscription($subscription);
        return $subscription;
    }

    protected function activatePaid(User $user, Tariff $tariff)
    {
        $subscription = $this->createSubscriptionFromTariff($tariff);
        $subscription->status = 'Awaiting';
        $user->subscriptions()->save($subscription);
        return $subscription;
    }

    protected function createSubscriptionFromTariff(Tariff $tariff)
    {
        $subscription = Subscription::make($tariff->toArray());
        $subscription->tariff_id = $tariff->id;
        $subscription->status = 'Active';
        $subscription->features = $tariff->features;

        if ($tariff->period != 'endless') 
            $subscription->next_transaction_date = Carbon::now()->add($tariff->period);

        return $subscription;
    }

    protected function endPreviousSubscription(Subscription $newSubscription)
    {
        $newSubscription->user->subscriptions()->where('status', 'Active')
            ->where('id', '<>', $newSubscription->id)
            ->update(['status' => 'Ended']);
    }

    protected function charge(Subscription $subscription)
    {
        if (Payments::charge($subscription)) {
            $subscription->next_transaction_date = 
                $subscription->next_transaction_date->add($subscription->period);
            $subscription->save();
            Mail::to($subscription->user->email)->queue(new SubscriptionRenewed($subscription));
        } else {
            if ($subscription->next_transaction_date < Carbon::now()->sub(config('subscriptions.past_due.reject'))) {
                $subscription->status = 'Rejected';
                $subscription->save();
                $this->activateDefault($subscription->user);
                Mail::to($subscription->user->email)->queue(new SubscriptionRejected($subscription));
            } else {
                $subscription->status = 'PastDue';
                $subscription->save();
                Mail::to($subscription->user->email)->queue(new SubscriptionPastDue($subscription));
            }
        }
    }
}