@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (Session::has('success'))
    <div class="alert alert-success">
        <div>
            {{ Session::get('success') }}
        </div>
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger">
        <div>
            {{ Session::get('error') }}
        </div>
    </div>
@endif
@if (Session::has('message'))
      <div class="alert alert-success" role="alert">
          {{ Session::get('message') }}
      </div>
    @endif
