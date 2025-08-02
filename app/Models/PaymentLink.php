<?php
namespace App\Models;

use App\Models\WelcomeCall;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'user_id',
        'plan_id',
        'currency',
        'price',
        'discount',
        'final_amount',
        'payment_link',
        'token',
        'gateway',
        'transaction_id',
        'gateway_response',
        'sent_at',
        'status',
        'start_date',
        'end_date',
    ];

    // Relationship to profile (prospect)
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'plan_id');
    }

    //using for adding welcome call when payment is done
    protected static function booted()
    {
        static::updated(function ($payment) {
            $profileId = $payment->profile_id;

            if ($payment->isDirty('status')) {
                $newStatus = strtolower($payment->status);
                $oldStatus = strtolower($payment->getOriginal('status'));

                // Create WelcomeCall only once per payment if moving to "Paid"
                if ($newStatus === 'paid') {
                    if (!WelcomeCall::where('profile_id', $profileId)->exists()) {
                        WelcomeCall::create([
                            'profile_id'      => $profileId,
                            'user_id'         => auth()->id() ?? 1,
                            'call_time'       => now(),
                            'status'          => 'New',
                            'outcome'         => null,
                            'notes'           => 'Auto-generated after payment',
                            'payment_link_id' => $payment->id,
                        ]);
                    }
                }

                // Delete only if this specific payment created the welcome call
                if ($oldStatus === 'paid' && $newStatus !== 'paid') {
                    $welcomeCall = WelcomeCall::where('payment_link_id', $payment->id)->first();
                    if ($welcomeCall) {
                        $welcomeCall->delete();
                    }
                }
            }
        });
    }

}
