<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WifiList extends Model
{
    use HasFactory;
    protected $table = 'wifi_list';
    protected $fillable = [
        'ap_mac', 'client_mac', 'ssid', 'password','ap_vendor','hash'
    ];
}
