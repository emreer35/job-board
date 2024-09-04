<x-layout>
    <x-breadcrumbs class="mb-4" :links="['My Jobs' => '#']" />
    <div class="mb-8 text-right">
        <x-link-button href="{{ route('my-jobs.create') }}">Add New</x-link-button>
    </div>
    @forelse ($jobs as $job)
        <x-job-card :$job>
            <div class="text-slate-500 text-xs">
                <div class="flex items-center justify-between font-semibold text-sm text-slate-900 mb-2">
                    <div>Information</div>
                    <div>Expected Salary</div>
                </div>
                @forelse ($job->jobAplications as $application)
                    <div class="flex mb-4 items-center justify-between ">
                        <div>
                            <div>{{ $application->user->name }}</div>
                            <div>
                                Applied {{ $application->created_at->diffForHumans() }}
                            </div>
                            <div>
                                Download CV
                            </div>
                        </div>
                        <div>
                            ${{ number_format($application->expected_salary) }}
                        </div>
                    </div>

                @empty
                    <div class="mb-4">No applications yet</div>
                @endforelse
                <div class="flex space-x-2">
                    <x-link-button href="{{ route('my-jobs.edit', $job) }}">Edit</x-link-button>
                    @if ($job->deleted_at)
                        
                    @else
                        <form action="{{ route('my-jobs.destroy', $job) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-button>Delete</x-button>
                        </form>
                    @endif

                </div>
            </div>

        </x-job-card>
    @empty
        <div class="rounded-md border border-dashed border-slate-300 p-8">
            <div class="text-center font-medium ">
                No jobs yet
            </div>
            <div class="text-center">
                Post your first job <a class="text-indigo-500 hover:underline"
                    href="{{ route('my-jobs.create') }}">here!</a>
            </div>
        </div>
    @endforelse
</x-layout>
