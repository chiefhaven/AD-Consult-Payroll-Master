@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $e)
            <li><strong>{{ $e }}</strong></li>
        @endforeach
    </ul>
</div>
@endif
