<?php

namespace App\Http\Controllers;

use App\Http\Requests\StationsRequest;
use App\Stations;

class StationsController extends Controller
{
    public function index()
    {
        $stations = Stations::latest()->get();

        return response(['data' => $stations ], 200);
    }

    public function store(StationsRequest $request)
    {
        $stations = Stations::create($request->all());

        return response(['data' => $stations ], 201);

    }

    public function show($id)
    {
        $stations = Stations::findOrFail($id);

        return response(['data', $stations ], 200);
    }

    public function update(StationsRequest $request, $id)
    {
        $stations = Stations::findOrFail($id);
        $stations->update($request->all());

        return response(['data' => $stations ], 200);
    }

    public function destroy($id)
    {
        Stations::destroy($id);

        return response(['data' => null ], 204);
    }
}
