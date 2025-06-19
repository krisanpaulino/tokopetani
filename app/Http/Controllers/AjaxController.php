<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    function cekStok(Request $request)
    {
        $id = $request->id;
        $qty = $request->qty;
        $data['available'] = true;
        if (!Produk::where('produk_id', '=', $id)->where('stok', '>=', $qty)->exists()) {
            $data['available'] = false;
        }
        echo json_encode($data);
    }
    function lokasi(Request $request)
    {
        $search = urlencode($request->search);
        $curl = curl_init();
        //         curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://rajaongkir.komerce.id/api/v1/destination/domestic-destination?search=" . $search,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 6f236992378c17b751f3b051fbe73779"
            )
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        }
        $array_response = json_decode($response, TRUE);
        $result = [];
        foreach ($array_response['data'] as $key => $res) {
            $result[$key] = [
                'id' => $res['id'] . '|' . $res['city_name'],
                'text' => $res['label']
            ];
        }
        $data['results'] = $result;
        echo json_encode($data);
    }
    function cost(Request $request)
    {
        $destination = urlencode($request->destination);
        $curl = curl_init();
        //         curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_POSTFIELDS => array(
                'origin' => '34462',
                'destination' => $destination,
                'weight' => 1000,
                'courier' => 'jne'
            ),
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "key: 6f236992378c17b751f3b051fbe73779"
            )
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        }
        $array_response = json_decode($response, TRUE);
        // $result = [];
        // foreach ($array_response['data'] as $key => $res) {
        //     $result[$key] = [
        //         'id' => $res['id'],
        //         'text' => $res['label']
        //     ];
        // }
        // $data['results'] = $result;
        echo json_encode($array_response['data']);
    }
}
