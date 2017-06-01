@if (session('info'))
    <div class="alert alert-info">
        <strong>Heads-up!</strong><br><br>
        {{ session('info.message') }}<br><br>
        @foreach (session('info.options') as $option)
            {!! $option !!}
        @endforeach
    </div>
@endif