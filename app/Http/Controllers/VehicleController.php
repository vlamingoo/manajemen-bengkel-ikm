<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Customer;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with('customer')->latest()->paginate(10);
        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $customers = Customer::all();
        return view('vehicles.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'merk' => 'required',
            'model' => 'required',
            'no_plat' => 'required|unique:vehicles',
            'tahun' => 'required|numeric',
        ]);

        Vehicle::create($request->all());

        return redirect()->route('vehicles.index')
            ->with('success', 'Data kendaraan berhasil ditambahkan!');
    }

    public function show(Vehicle $vehicle)
    {
        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        $customers = Customer::all();
        return view('vehicles.edit', compact('vehicle', 'customers'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'merk' => 'required',
            'model' => 'required',
            'no_plat' => 'required|unique:vehicles,no_plat,' . $vehicle->id,
            'tahun' => 'required|numeric',
        ]);

        $vehicle->update($request->all());

        return redirect()->route('vehicles.index')
            ->with('success', 'Data kendaraan berhasil diupdate!');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('vehicles.index')
            ->with('success', 'Data kendaraan berhasil dihapus!');
    }
}