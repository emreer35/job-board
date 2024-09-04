{{-- <div>
    <label for="{{$name}}_all" class="mb-1 flex items-center">
        <input type="radio" name="{{$name}}" id="{{$name}}_all" value="" 
        @checked(!request($name))>
        <span class="ml-2">All</span>
    </label>
    @foreach ($options as $option)
    <label for="{{$name}}_{{Str::slug($option)}}" class="mb-1 flex items-center">
        <input type="radio" id="{{$name}}_{{Str::slug($option)}}" name="{{$name}}"  value="{{$option}}"
        @checked($option === request($name))>
        <span class="ml-2">{{Str::ucfirst($option)}}</span>
    </label>
    @endforeach
</div> --}}
<div>
    @if ($allOption)
        <label for="{{ $name }}_all" class="mb-1 flex items-center">
            <input type="radio" name="{{ $name }}" id="{{ $name }}_all" value=""
                @checked(!request($name))>
            <span class="ml-2">All</span>
        </label>
    @endif
    @foreach ($optionsWithLabels as $label => $option)
        <label for="{{ $name }}_{{ Str::slug($option) }}" class="mb-1 flex items-center">
            <input type="radio" id="{{ $name }}_{{ Str::slug($option) }}" name="{{ $name }}"
                value="{{ $option }}" @checked($option === ($value ?? request($name)))> 
                {{-- varsayilan degeri aldik $value ile  --}}
            <span class="ml-2">{{ $label }}</span>
        </label>
    @endforeach
    @error($name)
    <div class="mt-1 text-xs text-red-500">
        {{ $message }}
    </div>
    @enderror
</div>
