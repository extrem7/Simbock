@if($errors->has($error))
    @foreach($errors->get($error) as $message)
        <span class="invalid-feedback {{isset($center)?'text-center':'text-left'}} d-block"
              role="alert">{{ $message }}</span>
    @endforeach
@endif
