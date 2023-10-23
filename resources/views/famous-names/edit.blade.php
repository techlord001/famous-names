@extends('layouts.famous-names')

@section('content')
<div class="container vh-100">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('famous-names.update', $id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $name['name'] }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="number" step="any" class="form-control" id="latitude" name="location[lat]" value="{{ $name['location']['lat'] }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="number" step="any" class="form-control" id="longitude" name="location[lng]" value="{{ $name['location']['lng'] }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
