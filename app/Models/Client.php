<?php

namespace App\Models;

use App\Http\Filters\ClientsFilter;
use App\Http\Filters\StocksFilter;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notifiable;
/**
 * \Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $image
 * @property Carbon $email_verified_at
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @mixin \Eloquent
 */

class Client extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'image',
        'email_verified_at'
    ];

    public function scopeFilter($query, ClientsFilter $filters): Builder
    {
        return $filters->apply($query);
    }

    public function count($days){
        return $this->where('created_at', '>', Carbon::now()->subDays($days))
            ->count();
    }
    public function hasVerifiedEmail()
    {
        return ! is_null($this->email_verified_at);
    }

    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail());
    }

    public function getEmailForVerification()
    {
        return $this->email;
    }
}

