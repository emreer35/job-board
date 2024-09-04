<?php

namespace App\Http\Controllers;

use App\Models\JobAplications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyJobAplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        return view('MyJobApplication.index', [
            'applications' => auth()->user()->JobAplications()->with([
                'job' => fn($query) => $query->withCount('jobAplications')->withAvg('jobAplications', 'expected_salary')
                ->withTrashed(),
                'job.employer'
            ])->latest()->get()
        ]);
    }

    public function destroy(JobAplications $my_job_application)
    {

        $my_job_application->delete();

        return redirect()->back()->with(['success' => 'Job application removed']);
    }
}
