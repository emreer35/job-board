<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class EmployerController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Employer $employer)
    {
        Gate::authorize('create', $employer);
        return view('employer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'company_name' => 'required|unique:employers,company_name'
        ]);

        Auth::user()->employer()->create([
            'company_name' => $validation['company_name']
        ]);

        return redirect()->route('jobs.index')->with(['success'=>'Your employer account was created!']);
    }

    
}
