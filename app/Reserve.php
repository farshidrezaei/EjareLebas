<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Reserve
 *
 * @property int $id
 * @property int $user_id
 * @property int $clothing_id
 * @property string $status
 * @property string|null $start_at
 * @property string|null $end_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Clothing $clothing
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reserve newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reserve newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reserve query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reserve whereClothingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reserve whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reserve whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reserve whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reserve whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reserve whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reserve whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reserve whereUserId($value)
 * @mixin \Eloquent
 */
class Reserve extends Model
{
    protected $guarded = [];

    public function clothing()
    {
        return $this->belongsTo( Clothing::class );
    }

    public function user()
    {
        return $this->belongsTo( User::class );
    }
}
