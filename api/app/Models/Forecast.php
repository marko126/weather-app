<?php

namespace App\Models;

use App\Services\Dtos\ForecastDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Forecast
 *
 * @property int $id
 * @property int $user_id
 * @property ForecastDto|string $data
 * @property-read User $user
 *
 * @package App\Models
 */
class Forecast extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'data'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
