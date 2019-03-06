<?php

namespace App\Http\Controllers\Api\Clothing;

use App\Clothing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class ClothingController extends Controller
{

    public function index()
    {
        $clothes=  Clothing::all();
        return response()->json( [
            'result' => true,
            'message' => '',
            'response' => $clothes
        ] );
    }

    public function show( $id )
    {
        $clothing = Clothing::findOrFail( $id );
        return response()->json( [
            'result' => true,
            'message' => '',
            'response' => $clothing
        ] );

    }

    public function store( Request $request )
    {
        $validator = Validator::make( $request->all(), [
            'title' => 'required|max:128',
            'color' => 'required|max:8',
            'size' => 'required',
            'material' => 'nullable|max:128',
            'usage_degree' => 'required',
            'image' => 'nullable',
            'gallery' => 'nullable',
            'description' => 'nullable',
            'brand' => 'nullable',
            'daily_price' => 'required_without_all:weekly_price,monthly_price|numeric',
            'weekly_price' => 'required_without_all:weekly_price,daily_price|numeric',
            'monthly_price' => 'required_without_all:daily_price,monthly_price|numeric',
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
            $clothing = Clothing::create( $request->all() );
            return response()->json( [
                'result' => true,
                'لباس با موفقیت اضافه شد',
                'response' => $clothing
            ] );
        }

    }

    public function update( Request $request, $id )
    {

        $validator = Validator::make( $request->all(), [
            'title' => 'required|max:128',
            'color' => 'required|max:8',
            'size' => 'required',
            'material' => 'nullable|max:128',
            'usage_degree' => 'required',
            'image' => 'nullable',
            'gallery' => 'nullable',
            'description' => 'nullable',
            'brand' => 'nullable',
            'daily_price' => 'required_without_all:weekly_price,monthly_price|numeric',
            'weekly_price' => 'required_without_all:weekly_price,daily_price|numeric',
            'monthly_price' => 'required_without_all:daily_price,monthly_price|numeric',
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
            $clothing = Clothing::findOrFail( $id );
            $clothing->update( $request->all() );
            return response()->json( [
                'result' => true,
                'message' => "لباس '" . $clothing->title . "' با موفقیت ویرایش شد",
                'response' => $clothing
            ] );
        }

    }

    public function destroy( Request $request )
    {
        $ids = $request[ 'ids' ];
            try {
                Clothing::whereIn( 'id', explode( ",", $ids ) )->delete();
        } catch ( \Exception $e ) {
            return response()->json( [
                'result' => false,
                'message' => "در حذف لباس های انتخاب شده، خطایی رخ داده است."
            ] );
        }
        return response()->json( [
            'result' => true,
            'message' => "لباس های انتخاب شده با موفقیت حذف شدند."
        ] );
    }

}
