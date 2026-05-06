<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
     public function index()
    {
        $employees = Employee::with('user')->get();
        return view('dashboard.employees.index', compact('employees'));
    }

      public function show(int $id)
    {
            $employees = Employee::findOrFail($id);
                  return view('dashboard.employees.show', compact('employees'));


    }
    // ── STORE ────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:8',
            'birthdate'  => 'nullable|date',
            'job'        => 'nullable|string|max:255',
            'gender'     => 'required|boolean',
            'salary'     => 'nullable|numeric|min:0',
            'commission' => 'nullable|numeric|min:0',
            'photo'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone'      => 'nullable|string|max:20',
            'status'     => 'required|boolean',
        ]);

        // 1. Create User account
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'employee',
        ]);

        // 2. Handle photo
        $photo = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('employees', 'public');
        }

        // 3. Create Employee record linked to User
        $user->employee()->create([
            'birthdate'  => $request->birthdate,
            'job'        => $request->job,
            'gender'     => $request->gender,
            'salary'     => $request->salary ?? 0,
            'commission' => $request->commission,
            'photo'      => $photo,
            'phone'      => $request->phone,
            'status'     => $request->status,
        ]);

       return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

 public function edit(int $id)
    {
         $employees = Employee::findOrFail($id);

        return view('dashboard.employees.edit', compact('employees'));
    }



    // ── UPDATE ───────────────────────────────────────────────
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $employee->user_id,
            'password'   => 'nullable|min:8',
            'birthdate'  => 'nullable|date',
            'job'        => 'nullable|string|max:255',
            'gender'     => 'required|boolean',
            'salary'     => 'nullable|numeric|min:0',
            'commission' => 'nullable|numeric|min:0',
            'photo'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone'      => 'nullable|string|max:20',
            'status'     => 'required|boolean',
        ]);

        // 1. Update User (name, email, optional password)
        $userData = [
            'name'  => $request->name,
            'email' => $request->email,
        ];
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }
        $employee->user()->update($userData);

        // 2. Handle photo
        $photo = $employee->photo;
        if ($request->hasFile('photo')) {
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
            }
            $photo = $request->file('photo')->store('employees', 'public');
        }

        // 3. Update Employee record
        $employee->update([
            'birthdate'  => $request->birthdate,
            'job'        => $request->job,
            'gender'     => $request->gender,
            'salary'     => $request->salary ?? 0,
            'commission' => $request->commission,
            'photo'      => $photo,
            'phone'      => $request->phone,
            'status'     => $request->status,
        ]);

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    // ── DESTROY ──────────────────────────────────────────────
    public function destroy(Employee $employee)
    {
        if ($employee->photo) {
            Storage::disk('public')->delete($employee->photo);
        }

        // Deleting User triggers FK cascade → deletes Employee row too
        $employee->user()->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }
}
