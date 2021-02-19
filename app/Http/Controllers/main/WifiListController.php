<?php

namespace App\Http\Controllers\main;

use App\Http\Controllers\Controller;
use App\Models\WifiList;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Devtools360\MacAddressLookup;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

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
        $wifi_arr = preg_split ('/\r\n|\n|\r/', $request->input('data'));
        foreach ($wifi_arr as  &$wifi) {
            $wifi = preg_split ('/:/m', $wifi);
        }
        unset($wifi);
        array_unique($wifi_arr, SORT_REGULAR);
        $data = [];
        foreach ($wifi_arr as $wifi) {
            $data[] = [
                'ap_mac' => $wifi[array_key_last($wifi)-3],
                'client_mac' => $wifi[array_key_last($wifi)-2],
                'ssid' => $wifi[array_key_last($wifi)-1],
                'password' => $wifi[array_key_last($wifi)],
            ];
        }
        WifiList::insert($data);
        return redirect()->route('main.wifi.index');
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

    /**
     * Remove the duplicate resource from storage.
     *
     *
     * @return redirect()
     */
    public function destroyDuplicate()
    {
        $delete = DB::delete('DELETE t1 FROM wifi_list t1 INNER JOIN wifi_list t2 WHERE t1.id < t2.id AND t1.ap_mac = t2.ap_mac');
        return redirect()->route('main.wifi.index')->with('noti_del_duplicate', $delete);
    }

    public function exportPotfile() {
        $data = WifiList::all();
        $textData = "";
        for ($i=0; $i < count($data); $i++) {
            // $textData = $textData.$data[$i]['ap_mac'].":".$data[$i]['client_mac'].":".$data[$i]['ssid'].":".$data[$i]['password']."{PHP_EOF}";
            $textData = $textData."{$data[$i]['ap_mac']}:{$data[$i]['client_mac']}:{$data[$i]['ssid']}:{$data[$i]['password']}".PHP_EOL;
        }
        $myName = "0x2f0713.potfile";
        $headers = ['Content-type'=>'text/plain', 'test'=>'YoYo', 'Content-Disposition'=>sprintf('attachment; filename="%s"', $myName),'X-BooYAH'=>'WorkyWorky','Content-Length'=>strlen($textData)];
        return response($textData,200,$headers);
    }
}
