<?php

namespace App;

use Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Passport\HasApiTokens;
use phpDocumentor\Reflection\Types\Integer;

/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @mixin \Eloquent
 * @property int                                                                                                            $id
 * @property int                                                                                                            $city_id
 * @property string                                                                                                         $first_name
 * @property string                                                                                                         $last_name
 * @property string                                                                                                         $gender
 * @property string                                                                                                         $national_code
 * @property string                                                                                                         $mobile
 * @property string                                                                                                         $address
 * @property float|null                                                                                                     $x
 * @property float|null                                                                                                     $y
 * @property string                                                                                                         $email
 * @property string|null                                                                                                    $brand
 * @property string|null                                                                                                    $avatar
 * @property string|null                                                                                                    $biography
 * @property string|null                                                                                                    $email_verified_at
 * @property string                                                                                                         $password
 * @property string|null                                                                                                    $remember_token
 * @property \Illuminate\Support\Carbon|null                                                                                $created_at
 * @property \Illuminate\Support\Carbon|null                                                                                $updated_at
 * @property-read \App\City                                                                                                 $city
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Clothing[]                                                  $clothes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Favorite[]                                                  $favorites
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Reserve[]                                                   $reserves
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAddress( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAvatar( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBiography( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBrand( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCityId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFirstName( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGender( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastName( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMobile( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereNationalCode( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereX( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereY( $value )
 * @property-read mixed                                                                                                     $created_at_jalali
 * @property-read mixed                                                                                                     $full_name
 * @property-read mixed                                                                                                     $updated_at_jalali
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Permission[]                                                $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Role[]                                                      $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User orWherePermissionIs( $permission = '' )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User orWhereRoleIs( $role = '', $team = null )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePermissionIs( $permission = '', $boolean = 'and' )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRoleIs( $role = '', $team = null, $boolean = 'and' )
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use LaratrustUserTrait;
    use Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $appends = [
        'full_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFullNameAttribute( $value )
    {
        return ucfirst( $this->first_name ) . ' ' . ucfirst( $this->last_name );
    }

    //relations
    public function city()
    {
        return $this->belongsTo( City::class );
    }

    public function clothes()
    {
        return $this->hasMany( Clothing::class );
    }


    public function favorites()
    {
        return $this->hasMany( Favorite::class );
    }

    public function reserves()
    {
        return $this->hasMany( Reserve::class );
    }

    public function comments()
    {
        return $this->hasMany( Comment::class, 'user_id', 'id' );
    }

    //getters
    public function getCreatedAtJalaliAttribute()
    {
        if ( $this->attributes[ 'created_at' ] )
            return jdate( $this->attributes[ 'created_at' ] )->format( 'Y/m/d H:i:s' );
        else
            return '';
    }

    public function getUpdatedAtJalaliAttribute()
    {
        if ( $this->attributes[ 'updated_at' ] )
            return jdate( $this->attributes[ 'updated_at' ] )->format( 'Y/m/d H:i:s' );
        else
            return '';
    }

    public function getGenderFaAttribute()
    {
        if ( $this->attributes[ 'gender' ] === 'male' )
            return 'مرد';
        else
            return 'زن';
    }


    //setter

    /**
     * bcrypt User's Password whenever it wants to save.
     *
     * @param $password
     */
    public function setPasswordAttribute( $password )
    {
        $this->attributes[ 'password' ] = bcrypt( $password );
    }


    //methods

    /**
     * @param int | string $clothing_id
     * @param string       $text
     * @param int  |string $rate
     *
     * @return Comment|\Illuminate\Database\Eloquent\Model
     */
    public function comment( int $clothing_id, string $text, int $rate = 1 )
    {
        $user = Auth::user();
        $comment = $user->comments()->create( [
            'clothing_id' => $clothing_id,
            'body' => $text,
            'rate' => $rate
        ] );

        return $comment;
    }


}
