<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Testing\Fluent\Concerns\Has;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        // $users=User::all()->where('customer');
        return view('dashboard.customers.index', compact('customers'));
    }

     public function create()
    {
        $users = User::whereIn('role', ['admin', 'employee', 'manager'])->get();
        return view('dashboard.customers.create', compact('users'));
    }

    public function store(Request $request)
    {
        $vaildation = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'password' => 'required|min:8',
            'birthdate' => 'nullable|date',
            'gender' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|boolean',
             'phone' => 'nullable|string',
        ]);
       $vaildation['password'] = Hash::make($vaildation['password']);
        if ($request->hasFile('photo')) {
             $vaildation['photo'] = $request->file('photo')->store('customers', 'public');
        }
        $customer=Customer::create($vaildation);

         User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>  $request->password,
            'role' => 'customer', // Add this field to users table if needed
        ]);



        return redirect()->route('customers.index');
    }
    public function edit(int $id)
{
    $customer = Customer::findOrFail($id);
    $users = User::all();
    return view('dashboard.customers.edit', compact('customer', 'users'));
}

public function update(Request $request, $id)
{
    $customer = Customer::findOrFail($id);
    $data = $request->all();

    if ($request->hasFile('photo')) {
        $data['photo'] = $request->file('photo')->store('customers', 'public');
    }

    $customer->update($data);

    return redirect()->route('customers.index');
}

public function destroy(int $id)
{
    Customer::findOrFail($id)->delete();
    return redirect()->route('customers.index');
}
}
