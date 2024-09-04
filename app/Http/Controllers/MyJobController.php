<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Models\Joob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class MyJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAnyEmployer', Joob::class);
        $jobs = Auth::user()->employer->joobs()
            ->with(['employer', 'jobAplications', 'jobAplications.user'])->withTrashed()->get();
        return view('my_job.index', ['jobs' => $jobs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Joob::class);
        return view('my_job.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobRequest $request)
    {

        // $data = $request->all();
        // $rules = [
        //     'title' => 'required|string',
        //     'location' => 'required|string',
        //     'salary' => 'required|numeric|min:1|max:1000000',
        //     'description' => 'required|min:50',
        //     'experience' => 'required|in:' . implode(',', Joob::$experience),
        //     'categories' => 'required|in:' . implode(',', Joob::$category),
        // ];
        // $messages = [
        //     'title.required' => 'The title field is required.',
        //     'location.required' => 'The location field is required.',
        //     'salary.required' => 'The salary field is required.',
        //     'description.required' => 'The description field is required.',
        //     'experience.required' => 'The experience field is required.',
        //     'experience.in' => 'The selected experience level is invalid. Please choose a valid option.',
        //     'categories.required' => 'The categories field is required.',
        //     'categories.in' => 'The selected category is invalid. Please choose a valid option.',
        //     'salary.min' => 'The salary must be at least 1.',
        //     'salary.max' => 'The salary may not be greater than 1,000,000.',
        //     'description.min' => 'The description must be at least 50 characters long.'
        // ];
        // $validation = Validator::make($data, $rules, $messages);
        // if ($validation->fails()) {
        //     return redirect()->back()->withErrors($validation)->withInput();
        // }

        // $newJob = Auth::user()->employer->joobs()->create([
        //     'title' => $request->title,
        //     'location' => $request->location,
        //     'salary' => $request->salary,
        //     'description' => $request->description,
        //     'experience' => $request->experience,
        //     'category' => $request->categories,
        // ]);
        // bu sekilde de yapabilirz
        // $validatedData = $validation->validated();
        // $newJob = Auth::user()->employer->joobs()->create($validatedData);

        Gate::authorize('create', Joob::class);
        $newJob = Auth::user()->employer->joobs()->create($request->validated());
        if ($newJob) {
            return redirect()->route('my-jobs.index')->with([
                'success' => 'The job has been successfully created.'
            ]);
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Joob $myJob)
    {
        Gate::authorize('update', $myJob);
        return view('my_job.edit', [
            'job' => $myJob
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobRequest $request, Joob $myJob)
    {
        Gate::authorize('update', $myJob);
        $myJob->update($request->validated());
        return redirect()->route('my-jobs.index')->with(['success' => 'The job has been successfully updated.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Joob $myJob)
    {
        $myJob->delete();
        return redirect()->route('my-jobs.index')->with([
            'success' => 'Job deleted.'
        ]);
    }
}
