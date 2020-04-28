<?php 

namespace Nikservik\Subscriptions\Traits;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Nikservik\Subscriptions\Models\Payment;
use Nikservik\Subscriptions\Models\Subscription as SubscriptionModel;

trait Subscription
{
    public function __construct(array $attributes = [])
    {
        $this->appends[] = 'subscription';
        $this->appends[] = 'features';
        $this->appends[] = 'hadTrial';
        $this->appends[] = 'cardLastFour';
        parent::__construct($attributes);
    }
    
    public function subscriptions()
    {
        return $this->hasMany(SubscriptionModel::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function subscription()
    {
        return $this->subscriptions()->where('status', 'Active')
            ->orWhere(function($query) {
                $query->where('status', 'Cancelled')
                      ->where('next_transaction_date', '>', Carbon::now());
            })->orderBy('status')->orderBy('next_transaction_date', 'desc')->first();
    }

    public function getFeaturesAttribute() 
    {
        if ($this->subscription() and $this->subscription()->features)
            return $this->subscription()->features;

        return [];
    }   

    public function getHadTrialAttribute() 
    {
        return (boolean) $this->subscriptions()
            ->where('price', 0)
            ->where('prolongable', false)
            ->where('period', '<>', 'endless')
            ->where('status', 'Ended')
            ->count();
    }   

    public function getSubscriptionAttribute() 
    {
        if ($this->subscription())
            return $this->subscription()->toArray();

        return [];
    }   

    public function getTokenAttribute() 
    {
        return Arr::get($this->settings, 'token', '');
    }   

    public function setTokenAttribute($token) 
    {
        $settings = $this->settings;
        $settings['token'] = $token;
        $this->settings = $settings;
    }   

    public function getCardLastFourAttribute() 
    {
        return Arr::get($this->settings, 'cardLastFour', '');
    }   

    public function setCardLastFourAttribute($cardLastFour) 
    {
        $settings = $this->settings;
        $settings['cardLastFour'] = $cardLastFour;
        $this->settings = $settings;
    }   
}