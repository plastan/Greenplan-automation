<x-filament-panels::page>

<form action="{{ route('run.command') }}" method="POST">
    @csrf
<x-filament::button type="submit">
 Assign meals
</x-filament::button>

</form>

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

</x-filament-panels::page>
