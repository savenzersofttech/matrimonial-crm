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
        'paid_at',
        'gateway',
        'transaction_id',
        'gateway_response',
        'sent_at',
        'status',
        'start_date',
        'end_date',
    ];

    protected static function booted()
    {
        parent::booted();

        static::created(function ($model) {
            self::logModelChange($model, 'created');
        });

        static::updated(function ($model) {
            $changes = $model->getChanges();
            unset($changes['updated_at']); // optional

            if (! empty($changes)) {
                self::logModelChange($model, 'updated', $changes);
            }

            // ✅ If status changed to "Paid" AND WelcomeCall doesn't already exist
            if (
                array_key_exists('status', $changes)
                && $changes['status'] === 'Paid'
                && ! WelcomeCall::where('profile_id', $model->profile_id)->exists()
            ) {
                WelcomeCall::create([
                    'profile_id'      => $model->profile_id,
                    'payment_link_id' => $model->id,
                    'user_id'         => $model->user_id ?? auth()->id(),
                    'status'          => 'Pending',
                    'call_time'       => now()->addDay(),
                    'outcome'         => null,
                    'notes'           => 'Auto-created after status manually set to Paid.',
                ]);
            }
        });

        static::deleting(function ($model) {
            $snapshot = $model->toArray();
            self::logModelChange($model, 'deleted', $snapshot);
        });

        // Existing WelcomeCall logic can also stay here...
    }

    /**
     * Log changes to payment link actions (create/update/delete)
     */
    protected static function logModelChange($model, $action, $changes = null)
    {
        PaymentLinkLog::create([
            'payment_link_id' => $model->id,
            'action'          => $action,
            'changes'         => $changes ? json_encode($changes) : null,
            'user_id'         => auth()->id() ?? null,
        ]);
    }

    // Relationship to profile (prospect)
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'plan_id');
    }

}
