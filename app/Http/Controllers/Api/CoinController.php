<?php

namespace App\Http\Controllers\Api;

use App\Services\CommonService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CoinController extends Controller
{
    //deduct user coin
    public function deductCoin(Request $request)
    {
        $data = ['success' => false, 'message' => __('Something Went wrong.')];
        $rules=[
            'coin' => 'required|numeric',
        ];
        $messages = [
            'coin.required' => 'The Coin field can not empty'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errors = [];
            $e = $validator->errors()->all();
            foreach ($e as $error) {
                $errors[] = $error;
            }
            $response = ['success' => false, 'message' => $errors];

            return response()->json($response);
        }
        $type= 1;
        $response = app(CommonService::class)->addOrDeductCoin($request->coin, $type);

        if (isset($response['status']) && isset($response['message'])) {
            $data['success'] = $response['status'];
            $data['available_coin'] = $response['available_coin'];
            $data['message'] = $response['message'];
        }

        return response()->json($data);

    }

    //earn coin process
    public function earnCoin(Request $request)
    {
        $data = ['success' => false, 'message' => __('Something Went wrong.')];
        $rules=[
            'coin' => 'required|numeric',
        ];
        $messages = [
            'coin.required' => 'The Coin field can not empty'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errors = [];
            $e = $validator->errors()->all();
            foreach ($e as $error) {
                $errors[] = $error;
            }
            $response = ['success' => false, 'message' => $errors];

            return response()->json($response);
        }
        $type= 2;
        $response = app(CommonService::class)->addOrDeductCoin($request->coin, $type);

        if (isset($response['status']) && isset($response['message'])) {
            $data['success'] = $response['status'];
            $data['message'] = $response['message'];
            $data['available_coin'] = $response['available_coin'];
        }

        return response()->json($data);

    }
}
