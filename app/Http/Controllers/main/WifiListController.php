<?php

namespace App\Http\Controllers\main;

use App\Http\Controllers\Controller;
use App\Models\WifiList;
use Facade\FlareClient\View;
use Illuminate\Http\Request;

class WifiListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.main.wifilist')->with('wifis',WifiList::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeMany(Request $request)
    {
        function findVendors($mac_add) {
            $url = "https://api.macaddress.io/v1?apiKey=at_LjfDu6vs8zrGkNvppHNfCdsyQPCfE&search=" .$mac_add;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            if($response) {
              return $response;
            } else {
              return "Not Found";
            }
        }
        $wifi_arr = preg_split ('/\r\n|\n|\r/', $request->input('data'));
        foreach ($wifi_arr as  &$wifi) {
            $wifi = preg_split ('/:/m', $wifi);
            array_push($wifi,findVendors($wifi[array_key_first($wifi)]));
        }
        unset($wifi);
        array_unique($wifi_arr, SORT_REGULAR);
        $data = [];
        foreach ($wifi_arr as $wifi) {
            $data[] = [
                'ap_mac' => $wifi[0],
                'client_mac' => $wifi[1],
                'ssid' => $wifi[2],
                'password' => $wifi[3],
                'ap_vendor' => $wifi[4]
            ];
        }
        WifiList::insert($data);
        return $this->index();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WifiList  $wifiList
     * @return \Illuminate\Http\Response
     */
    public function show(WifiList $wifiList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WifiList  $wifiList
     * @return \Illuminate\Http\Response
     */
    public function edit(WifiList $wifiList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WifiList  $wifiList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WifiList $wifiList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WifiList  $wifiList
     * @return \Illuminate\Http\Response
     */
    public function destroy(WifiList $wifiList)
    {
        //
    }
}
