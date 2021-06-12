<?php

namespace App\Models;

use App\Http\Filters\ClientsFilter;
use App\Http\Filters\StocksFilter;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * \Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon $email_verified_at
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @mixin \Eloquent
 */

class Client extends Model implements MustVerifyEmail
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
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
        // TODO: Implement hasVerifiedEmail() method.
    }

    public function markEmailAsVerified()
    {
        // TODO: Implement markEmailAsVerified() method.
    }

    public function sendEmailVerificationNotification()
    {
        // TODO: Implement sendEmailVerificationNotification() method.
    }

    public function getEmailForVerification()
    {
        // TODO: Implement getEmailForVerification() method.
    }
}
