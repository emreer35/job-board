<?php

namespace App\Http\Controllers;

use App\Models\Joob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request )
    {
        Gate::authorize('viewAny',Joob::class);
        $filters = request()->only(
            'search',
            'min_salary',
            'max_salary',
            'experience',
            'category'
        );
        $jobs = Joob::with('employer')->filter($filters);
        
        // $jobs = Joob::query(); 
        //Bu yapı, koşulların birbirinden bağımsız olarak uygulanmasını sağlar.
        // Koşullar arasında herhangi bir öncelik tanınmadan, her biri var olan
        // koşullara göre sorguya eklenir. Bu yüzden bu yapı, istediğiniz gibi
        // çalışacaktır.
        // $jobs->when($request->search, function ($query) use ($request){
        //     $query->where(function ($query) use ($request) {
        //         $query->where('title', 'LIKE', '%' . $request->search . '%')
        //             ->orWhere('description', 'LIKE', '%' . $request->search . '%')
        //             ->orWhere('location', 'LIKE', '%' . $request->search . '%');
        //     });
        // })->when($request->min_salary , function($query) use ($request){
        //     $query->where('salary','>=', $request->min_salary);
        // })->when($request->max_salary , function($query) use($request){
        //     $query->where('salary', '<=', $request->max_salary);
        // })->when($request->experience, function($query) use($request){
        //     $query->where('experience', $request->experience);
        // })->when($request->category , function($query) use($request){
        //     $query->where('category',$request->category);
        // });

        $jobs = $jobs->latest()->get();
        return view('job.index',['jobs'=>$jobs]);
    }

    
    public function show(Joob $job)
    {
        Gate::authorize('view',$job);
        return view('job.show',['job'=>$job->load('employer.joobs')]);
    }

    
}
