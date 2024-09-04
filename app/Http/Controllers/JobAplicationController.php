<?php

namespace App\Http\Controllers;

use App\Models\Joob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class JobAplicationController extends Controller
{


    /**
     * Show the form for creating a new resource.
     */
    public function create(Joob $job)
    {
        Gate::authorize('apply',$job);
        return view('job_aplication.create', [
            'job' => $job
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Joob $job, Request $request) 
    {
        Gate::authorize('apply',$job);
        $validatedData = $request->validate([
            'expected_salary' => 'required|min:1|max:1000000',
            'cv' => 'required|file|mimes:pdf|max:2048'
        ]);

        $file = $request->file('cv');
        $path = $file->store('cvs','private');

        $job->jobAplications()->create([
            'user_id' => Auth::user()->id,
            // normalde job yazmamiza gerek yok cunku zaten o job un icerisinden gonderiyoruz
            'expected_salary' => $validatedData['expected_salary'],
            'cv_path' => $path 
            
             
        ]);
        
        return redirect()->route('jobs.show',$job)->with(['success'=>'Job application submitted']);
    }

    public function destroy(string $id)
    {
        //
    }
}
