<x-layout>
    <x-bread-crumbs class="mb-4" :links="['Jobs' => route('jobs.index')]" />

    <x-card class="mb-4 text-sm">
        <form id="form-id" action="{{route('jobs.index')}}" method="get">
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <div class="mb-1 font-semibold">Search</div>
                    <x-text-input name="search" value="{{request('search')}}" placeholder="Search for any text, location" form-id="form-id" />
                </div>
                <div>
                    <div class="mb-1 font-semibold">Salary</div>
                    <div class="flex space-x-2">
                        <x-text-input name="min_salary" value="{{request('min_salary')}}" placeholder="From" form-id="form-id"/>
                        <x-text-input name="max_salary" value="{{request('max_salary')}}" placeholder="To" form-id="form-id"/>
                    </div>
                </div>
                <div>
                    <div class="mb-1 font-semibold">Experience </div>
                    <x-radio-group name="experience" :options="array_combine(array_map('ucfirst' ,\App\Models\Joob::$experience), \App\Models\Joob::$experience)"/>
                </div>
                <div>
                    <div class="mb-1 font-semibold">Categories</div>
                    <x-radio-group name="category" :options="\App\Models\Joob::$category"  />
                </div>
            </div>

            <x-button class="w-full">Filter</x-button>
        </form>
    </x-card>
    @foreach ($jobs as $job)
        {{-- burada :job yapmamiz dinamik bir degisken olmasindan dolayi 
    href kisminda sabit, statik bir degisken oldugundan doalyi string 
    deger alabilir  --}}
        <x-job-card :job="$job">
            <div>
                <x-link-button href="{{ route('jobs.show', $job) }}">
                    Show
                </x-link-button>
            </div>
        </x-job-card>
    @endforeach
</x-layout>
