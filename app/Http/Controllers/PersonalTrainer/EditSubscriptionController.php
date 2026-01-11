<?php

namespace App\Http\Controllers\PersonalTrainer;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class EditSubscriptionController extends Controller
{
    /**
     * Display the edit subscription page
     */
    public function index(Request $request)
    {
        // Get all members (DataTables will handle pagination)
        $results = User::where('role', 'member')->get();
        
        return view('personal_training.edit_subscription.index', compact('results'));
    }

    /**
     * Show the form to edit subscription for a specific member
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        
        // Get active membership
        $membership = Membership::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();
        
        // Get all membership packages for reference
        $packages = DB::table('gym_membership_packages')
            ->select('id', 'name', 'duration_in_days', 'price')
            ->get();
        
        return view('personal_training.edit_subscription.edit', compact('user', 'membership', 'packages'));
    }

    /**
     * Update the subscription period
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'required|boolean',
        ]);

        $user = User::findOrFail($id);
        
        // Get or create membership
        $membership = Membership::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();
        
        if ($membership) {
            // Update existing membership
            $membership->start_date = $request->start_date;
            $membership->end_date = $request->end_date;
            $membership->is_active = $request->is_active;
            $membership->save();
        } else {
            // Create new membership if doesn't exist
            $membership = Membership::create([
                'user_id' => $user->id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'is_active' => $request->is_active,
                'gym_membership_packages' => $request->gym_membership_package_id ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Update user status based on membership
        if ($request->is_active) {
            $user->status = 'active';
        } else {
            $user->status = 'inactive';
        }
        $user->save();

        return redirect()->route('pt_edit_subscription')->with('success', 'Subscription period updated successfully!');
    }
}
