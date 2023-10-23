@extends('layouts.famous-names')

@section('content')
    <div class="container vh-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="d-flex flex-wrap justify-content-center">
                @foreach ($names as $name)
                <div class="mb-3 mx-2">
                    <div class="card text-center" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title mb-4">{{ $name['name'] }}</h5>
                            <p class="mb-1">Latitude: {{ $name['location']['lat'] }}</p>
                            <p class="mb-3">Longitude: {{ $name['location']['lng'] }}</p>
                            <x-view-button :name="$name" />
                            <x-edit-button :id="$name['id']" />
                            <x-delete-button :id="$name['id']" />
                        </div>
                    </div>
                </div>
                
                @endforeach
            </div>
        </div>
        <!-- Modal -->
        <x-modal />
    </div>
@endsection

<script>
    var googleMapsApiKey = @json(config('services.googlemaps.key'));
</script>
