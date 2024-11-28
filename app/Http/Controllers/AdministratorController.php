<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use App\Http\Requests\StoreAdministratorRequest;
use App\Http\Requests\UpdateAdministratorRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdministratorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admins.admins');
    }

    public function adminData()
    {
        $admins = Administrator::with('user.roles')->get();
        return response()->json($admins, 201);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admins.addAdmin');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdministratorRequest $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'sirname' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'alt_phone' => 'nullable|string|max:20',
            'street_address' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'role' => 'nullable|string|in:it_admin,hr_admin,finance_admin,super_admin',
            'email' => 'required|email|unique:users,email|max:255',
            'username' => 'required|string|unique:users,username|max:255',
            'password' => 'required|string|min:8',
            //'is_active' => 'nullable|boolean',
        ]);

        // Handle profile picture upload if provided
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $path = $file->store('profile_pictures', 'public'); // Save to the `storage/app/public/profile_pictures` directory
            $validated['profile_picture'] = $path;
        }

        // Ensure 'is_active' is set correctly
        $validated['is_active'] = $request->has('is_active');

        // Create the Administrator record
        $admin = Administrator::create($validated);

        // Create a corresponding User record
        $user = User::create([
            'name' => "{$validated['first_name']} {$validated['sirname']}",
            'username' => "{$validated['username']}",
            'email' => $validated['email'], // Example email format
            'password' => Hash::make($validated['password']), // Set a default password (should be changed later)
            'administrator_id' => $admin->id, // Associate with Administrator
        ]);

        // Assign role to the user
        try {
            $user->assignRole($validated['role'] ?? 'it_admin');
        } catch (\Spatie\Permission\Exceptions\RoleDoesNotExist $e) {
            // Handle the error, e.g., log it or notify the admin
            return back()->withErrors(['role' => 'The specified role does not exist.']);
        } // Use 'it_admin' as the default role if none provided

        // Return success response
        return response()->json(['message' => 'Administrator created successfully!'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Administrator $administrator)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Administrator $administrator)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdministratorRequest $request, Administrator $administrator)
    {

        // Validate input data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'sirname' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'alt_phone' => 'nullable|string|max:20',
            'street_address' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'role' => 'nullable|string|in:it_admin,hr_admin,finance_admin,super_admin',
            'password' => 'nullable|string|min:8',  // Make password optional during update
            'is_active' => 'nullable|boolean',  // Optional, will be handled if provided
        ]);

        // Handle profile picture upload if provided
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $path = $file->store('profile_pictures', 'public'); // Save to `storage/app/public/profile_pictures`
            $validated['profile_picture'] = $path;
        }

        // Update the administrator record
        $administrator->update($validated);

        // Update the corresponding User record
        $user = $administrator->user;

        // Update the user attributes (excluding password if not provided)
        $user->name = "{$validated['first_name']} {$validated['sirname']}";
        $user->email = $validated['email'];
        $user->username = $validated['username'];

        // If a new password is provided, hash it and update it
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        // Update the role if provided
        try {
            if (isset($validated['role'])) {
                $user->syncRoles($validated['role']);  // Use syncRoles to update the user's role
            }
        } catch (\Spatie\Permission\Exceptions\RoleDoesNotExist $e) {
            return back()->withErrors(['role' => 'The specified role does not exist.']);
        }

        $user->save();

        // Update the is_active field if provided
        if (isset($validated['is_active'])) {
            $administrator->is_active = $validated['is_active'];
            $administrator->save();
        }

        // Return success response
        return response()->json(['message' => 'Administrator updated successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($administrator)
    {
        $administrator = Administrator::find($administrator);

        // Check if the currently authenticated administrator is trying to delete themselves
        if (Auth::user()->administrator_id === $administrator->id) {
            return response()->json(['message' => 'You cannot delete your own account'], 403);
        }

        // Check if the administrator exists
        if (!$administrator) {
            return response()->json(['message' => 'Administrator not found'], 404);
        }

        // Optionally delete associated user or other related records
        $administrator->user()->delete();  // If an associated user exists

        // Delete the administrator record
        $administrator->delete();

        // Return a success response
        return response()->json(['message' => 'Administrator deleted successfully'], 200);
    }

}
