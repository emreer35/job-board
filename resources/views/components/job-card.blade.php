<x-card class="mb-4">
    <div class="mb-4 flex justify-between">
        <h2 class="text-lg font-medium">{{ $job->title }}</h2>
        <div class="text-slate-500">
            ${{ number_format($job->salary) }}
        </div>
    </div>
    <div class="mb-1 flex justify-between text-sm text-slate-500 items-center">
        <div class="flex space-x-4 items-center">
            <div>{{ $job->employer->company_name }}</div>
            <div>{{ $job->location }}</div>
            @if ($job->deleted_at)
                <span class="text-sm text-red-400">Deleted</span>
            @endif
        </div>
        <div class="flex space-x-1 text-xs">
            <x-tag><a
                    href="{{ route('jobs.index', ['experience' => $job->experience]) }}">{{ Str::ucfirst($job->experience) }}</a></x-tag>
            <x-tag><a href="{{ route('jobs.index', ['category' => $job->category]) }}">{{ $job->category }}</a></x-tag>
        </div>
    </div>
    <div class="flex mb-4 justify-start space-x-1 text-xs">
        <x-tag>{{ Str::ucfirst('date') }}</x-tag>
        <x-tag>{{ $job->created_at->translatedFormat('j F Y') }}</x-tag>
    </div>

    {{ $slot }}

</x-card>
