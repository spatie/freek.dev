<form action="{{ $url }}" method="POST">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}

    <button type="submit" class="btn btn-danger">
        Delete
    </button>
</form>