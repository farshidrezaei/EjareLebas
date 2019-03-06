<?php

namespace App\Http\Controllers\Admin\Clothing;

use App\Category;
use App\Clothing;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class ClothingController extends Controller
{

    public function index()
    {
        $items = Clothing::query()->with( [
            'category' => function (  $category ) {
                $category->select( [ 'id', 'title' ] );
            },
            'owner' => function (  $owner ) {
                $owner->select( [ 'id', 'first_name', 'last_name','avatar' ] );
            }
        ] )->latest();

        $items = $items->get();

        $items->each( function ( $item ) {
            $item->created_at_fa = $item->created_at_jalali;
            $item->is_leased_farsi = $item->is_leased_fa;
            $item->confirmation_status_farsi = $item->confirmation_status_fa;
        } );


        return response()->json( [
            'result' => true,
            'response' => $items
        ], 200 );
    }

    public function show( $id )
    {

        $item = Clothing::with( 'owner','category' )->findOrFail( $id );
        $item->created_at_fa = $item->created_at_jalali;
        return response()->json( [
            'result' => true,
            'response' => $item
        ] );
    }

    public function store( Request $request )
    {

        $validator = Validator::make( $request->all(), [
            'title' => 'required|max:128',
            'size' => 'required',
            'image' => 'nullable',
            'gallery' => 'nullable',
            'description' => 'nullable',
            'daily_price' => 'required_without_all:weekly_price,monthly_price',
            'weekly_price' => 'required_without_all:weekly_price,daily_price',
            'monthly_price' => 'required_without_all:daily_price,monthly_price',
            'cash_collateral' => 'nullable|numeric',
            'non_cash_collateral' => 'nullable',
        ] );
        if ( $validator->fails() ) {
            return response()->json( [
                'result' => false,
                'message' => 'خطا در اعتبار سنجی',
                'response' => $validator->messages()
            ] );
        } else {
            $item = Clothing::create( $request->all() );
            return response()->json( [
                'result' => true,
                'لباس با موفقیت اضافه شد',
                'response' => $item
            ] );
        }

    }

    public function update( Request $request, $id )
    {

        $validator = Validator::make( $request->all(), [
            'title' => 'required|max:128',
            'size' => 'required',
            'image' => 'nullable',
            'gallery' => 'nullable',
            'description' => 'nullable',
            'daily_price' => 'required_without_all:weekly_price,monthly_price',
            'weekly_price' => 'required_without_all:weekly_price,daily_price',
            'monthly_price' => 'required_without_all:daily_price,monthly_price',
            'cash_collateral' => 'nullable|numeric',
            'non_cash_collateral' => 'nullable',
        ] );
        if ( $validator->fails() ) {
            return response()->json( [
                'result' => false,
                'message' => 'خطا در اعتبار سنجی',
                'response' => $validator->messages()
            ] );
        } else {
            $item = Clothing::findOrFail( $id );
            $item->update( $request->except([
                '_token','created_at_fa','created_at','update_at','category','is_leased_farsi','confirmation_status_farsi','owner'
            ]) );
            return response()->json( [
                'result' => true,
                'message' => "لباس '" . $item->title . "' با موفقیت ویرایش شد",
                'response' => $item
            ] );
        }

    }

    public function destroy( Request $request )
    {
        $ids = collect( $request[ 'ids' ] );
        $ids = $ids->pluck( 'id' );
        try {
            Clothing::whereIn( 'id', $ids )->delete();
            return response()->json( [
                'result' => true,
                'message' => "لباس های انتخاب شده با موفقیت حذف شدند."
            ] );
        } catch ( \Exception $e ) {
            return response()->json( [
                'result' => false,
                'message' => "در حذف لباس های انتخاب شده، خطایی رخ داده است."
            ] );
        }
    }

}
