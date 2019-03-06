<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Clothing
 *
 * @property int                             $id
 * @property int|null                        $user_id
 * @property int|null                        $category_id
 * @property string                          $title
 * @property string|null                     $color
 * @property string                          $size
 * @property string|null                     $material
 * @property string                          $usage_degree
 * @property string|null                     $image
 * @property string|null                     $gallery
 * @property string|null                     $description
 * @property string|null                     $brand
 * @property float|null                      $daily_price
 * @property float|null                      $weekly_price
 * @property float|null                      $monthly_price
 * @property float|null                      $cash_collateral
 * @property string|null                     $non_cash_collateral
 * @property string                          $confirmation_status
 * @property int                             $is_leased
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Category|null         $category
 * @property-read \App\User|null             $owner
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clothing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clothing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clothing query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clothing whereBrand( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clothing whereCashCollateral( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clothing whereCategoryId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clothing whereColor( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clothing whereConfirmationStatus( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clothing whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clothing whereDailyPrice( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clothing whereDescription( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clothing whereGallery( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clothing whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clothing whereImage( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clothing whereIsLeased( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clothing whereMaterial( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clothing whereMonthlyPrice( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clothing whereNonCashCollateral( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clothing whereSize( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clothing whereTitle( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clothing whereUpdatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clothing whereUsageDegree( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clothing whereUserId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clothing whereWeeklyPrice( $value )
 * @mixin \Eloquent
 * @property-read mixed                      $confirmation_status_fa
 * @property-read mixed                      $created_at_jalali
 * @property-read mixed                      $is_leased_fa
 * @property-read mixed                      $updated_at_jalali
 */
class Clothing extends Model
{
    protected $guarded = [];

    protected $casts = [
        'gallery' => 'array',
        'non_cash_collateral' => 'array'
    ];

    protected $table = 'clothes';

    public function owner()
    {
        return $this->belongsTo( User::class, 'user_id', 'id' )->withDefault( function ( $category ) {
            $category->fullName = 'ناشناس';
        } );
    }

    public function category()
    {
        return $this->belongsTo( Category::class )->withDefault( function ( $category ) {
            $category->title = 'بدون دسته بندی';
        } );
    }

    public function comments()
    {
        return $this->hasMany( Comment::class, 'clothing_id', 'id' );
    }


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

    public function getIsLeasedFaAttribute()
    {
        if ( $this->attributes[ 'is_leased' ] == true )
            return "اجاره داده شده";
        else
            return 'اجاره داده نشده';
    }

    public function getConfirmationStatusFaAttribute()
    {
        switch ( $this->attributes[ 'confirmation_status' ] ) {
            case "pending":
                return 'درحال بررسی';
                break;
            case "confirmed":
                return 'تایید شده';
                break;
            case "unconfirmed":
                return 'تایید نشده';
                break;
        }

    }
}
