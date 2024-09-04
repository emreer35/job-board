<x-layout>
    <x-bread-crumbs class="mb-4" :links="['Jobs' => route('jobs.index'), $job->title => '#']" />

    <x-job-card :$job>
        {{-- nlbr acikalamsi  --}}
        {{-- https://chatgpt.com/c/58e26cb3-f2fd-4ada-826b-d86427f0ceaa --}}
        <p class="text-sm text-slate-500 mb-4">
            {!! nl2br(e($job->description)) !!}
        </p>
        @can('apply', $job)
            <x-link-button :href="route('jobs.aplication.create', $job)">Apply</x-link-button>
        @else
            <div class="text-center text-sm font-medium text-slate-500">
                You already applied to this job
            </div>
        @endcan
    </x-job-card>

    <x-card class="mb-4">
        <h2 class="font-medium mb-4 text-lg">
            More {{ $job->employer->company_name }} Jobs
        </h2>
        <div class="text-sm text-slate-500">
            @foreach ($job->employer->joobs as $otherJob)
                <div class="mb-4 flex justify-between">
                    <div>
                        <div class="text-slate-700">
                            <a href="{{ route('jobs.show', $otherJob) }}">{{ $otherJob->title }}</a>
                        </div>
                        <div class="text-xs">
                            {{-- {{ $otherJob->created_at->translatedFormat('j F Y') }} --}}
                            {{-- kac saat once eklendigni gosteriyor  --}}
                            {{ $otherJob->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <div class="text-xs">
                        ${{ number_format($otherJob->salary) }}
                    </div>
                </div>
            @endforeach
        </div>
    </x-card>


</x-layout>
