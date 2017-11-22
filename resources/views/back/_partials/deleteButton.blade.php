<form action="{{ $url }}" method="POST">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}

    <button type="submit" class="text-blue text-sm font-normal" title="Delete">
        Delete
    </button>
</form>