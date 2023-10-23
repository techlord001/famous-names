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
                                <button type="button" class="btn btn-primary view-btn" data-bs-toggle="modal"
                                        data-bs-target="#viewModal" data-name="{{ $name['name'] }}"
                                        data-lat="{{ $name['location']['lat'] }}" data-lng="{{ $name['location']['lng'] }}">
                                    View
                                </button>
                                <button type="button" class="btn btn-secondary" disabled>Edit</button>
                                <button type="button" class="btn btn-danger" disabled>Delete</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Famous Name Location</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Map will be loaded here -->
                        <div id="map" style="height: 400px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    var googleMapsApiKey = @json(config('services.googlemaps.key'));
</script>
