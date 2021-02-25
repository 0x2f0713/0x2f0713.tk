<?php

namespace App\Http\Controllers\main;

use App\Http\Controllers\Controller;
use App\Models\WifiList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class WifiListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.main.wifilist')->with('wifis', WifiList::all()->sortBy([
            ['ap_mac', 'asc'],
            ['type', 'asc'],
        ]));
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
        switch ($request->input('data_type')) {
            case '0':
                $wifi_arr = preg_split('/\r\n|\n|\r/', $request->input('data'));
                foreach ($wifi_arr as  &$wifi) {
                    $wifi = preg_split('/:/m', $wifi);
                }
                unset($wifi);
                array_unique($wifi_arr, SORT_REGULAR);
                $data = [];
                foreach ($wifi_arr as $wifi) {
                    $data[] = [
                        'ap_mac' => $wifi[array_key_last($wifi) - 3],
                        'client_mac' => $wifi[array_key_last($wifi) - 2],
                        'ssid' => $wifi[array_key_last($wifi) - 1],
                        'password' => $wifi[array_key_last($wifi)],
                        'type' => 0,
                        'created_at'        => Carbon::now(),
                        'updated_at'        => Carbon::now(),
                    ];
                }
                WifiList::insert($data);
                return redirect()->route('main.wifi.index');
                break;
            case '1':
                $wifi_arr = preg_split('/\r\n|\n|\r/', $request->input('data'));
                $hash_arr = $wifi_arr;
                foreach ($wifi_arr as  &$wifi) {
                    $wifi = preg_split('/\*/m', $wifi);
                }
                unset($wifi);
                array_unique($wifi_arr, SORT_REGULAR);
                $data = [];
                foreach ($wifi_arr as $key => $wifi) {
                    if ($wifi[1] == "01") {
                        $hash_type = 1;
                    } else {
                        $hash_type = 2;
                    }
                    $data[] = [
                        'ap_mac' => $wifi[3],
                        'client_mac' => $wifi[4],
                        'ssid' => hex2bin($wifi[5]),
                        'type' =>  $hash_type,
                        'hash' => $hash_arr[$key],
                        'created_at'        => Carbon::now(),
                        'updated_at'        => Carbon::now(),
                    ];
                }
                $res = WifiList::insert($data);
                return redirect()->route('main.wifi.index')->with(($res) ? "success" : 'danger', ($res) ? "Upload success" : "Upload failed");
                break;
            default:
                return redirect()->route('main.wifi.index')->with('danger', "Not found data type");
                break;
        }
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
        $delete = DB::delete('DELETE t1 FROM wifi_list t1 INNER JOIN wifi_list t2 WHERE t1.id > t2.id AND t1.id == t2.id AND t1.ap_mac = t2.ap_mac AND ((t1.type = 0 AND t2.type = 0))');
        return redirect()->route('main.wifi.index')->with('info', "Deleted {$delete} line(s).");
    }

    public function exportPotfile()
    {
        $data = WifiList::where("type", 0)->get();
        $textData = "";
        for ($i = 0; $i < count($data); $i++) {
            $textData = $textData . "{$data[$i]['ap_mac']}:{$data[$i]['client_mac']}:{$data[$i]['ssid']}:{$data[$i]['password']}" . PHP_EOL;
        }
        $myName = "0x2f0713_cracked.potfile";
        $headers = ['Content-type' => 'text/plain', 'Content-Disposition' => sprintf('attachment; filename="%s"', $myName), 'Content-Length' => strlen($textData)];
        return response($textData, 200, $headers);
    }
    public function exportPassword()
    {
        $data = WifiList::where("type", 0)->get();
        $textData = "";
        for ($i = 0; $i < count($data); $i++) {
            $textData = $textData . "{$data[$i]['password']}" . PHP_EOL;
        }
        $myName = "0x2f0713_password.txt";
        $headers = ['Content-type' => 'text/plain', 'Content-Disposition' => sprintf('attachment; filename="%s"', $myName), 'Content-Length' => strlen($textData)];
        return response($textData, 200, $headers);
    }
    public function exportHashes()
    {
        $data = WifiList::where("type", ">", 0)->get();
        $textData = "";
        for ($i = 0; $i < count($data); $i++) {
            $textData = $textData . "{$data[$i]['hash']}" . PHP_EOL;
        }
        $myName = "0x2f0713_hashes.22000";
        $headers = ['Content-type' => 'text/plain', 'Content-Disposition' => sprintf('attachment; filename="%s"', $myName), 'Content-Length' => strlen($textData)];
        return response($textData, 200, $headers);
    }
}
