<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stations extends Model
{
    protected $table = 'stations';
    protected $fillable = [
        'station_name', 'station_mon_ip', 'station_max_cpe', 'station_max_ap', 'connection_type','server', 'community'
    ];

}
