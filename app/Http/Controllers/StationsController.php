<?php

namespace App\Http\Controllers;

use App\Http\Requests\StationsRequest;
use App\Stations;

class StationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $na = Stations::orderBy('id', 'desc')->paginate(5);
        return view('stations.index',compact('na'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('stations.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'station_name' => 'required',
            'station_mon_ip' => 'required',
            'station_max_cpe' => 'required',
            'station_max_ap' => 'required',
            'connection_type' => 'required',
            'server' => 'required',
            'community' => 'required',
        ]);
        Nas::create($request->all());

        return redirect()->route('stations.index')
            ->with('success','istasyon has been successfully added.');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stations  $stations
     * @return \Illuminate\Http\Response
     */
    public function edit(Stations $na)
    {
        return view('stations.edit', compact('na'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Nas  $stations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stations $na)
    {
        $request->validate([
            'station_name' => 'required',
            'station_mon_ip' => 'required',
            'station_max_cpe' => 'required',
            'station_max_ap' => 'required',
            'connection_type' => 'required',
            'server' => 'required',
            'community' => 'required',
        ]);

        $na->update($request->all());

        return redirect()->route('stations.index')
            ->with('success','Nas updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stations  $stations
     * @return \Illuminate\Http\Response
     */
    public function destroy(stations $na)
    {
        $na->delete();
        return redirect()->route('stations.index')->with('success', 'Nas deleted successfully');

    }
}
