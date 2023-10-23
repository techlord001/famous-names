<div class="d-inline-block">
    <form method="POST" action="{{ url('famous-names/' . $id) }}" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
</div>