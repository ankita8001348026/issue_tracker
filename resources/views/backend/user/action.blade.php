<div class="btn-group">
    <button type="button" class="btn btn-sm btn-default border-0 bg-transparent" data-toggle="dropdown"><i
            class='fa fa-ellipsis-v'></i></button>
    <ul class="dropdown-menu dropdown-menu-right">
        <li><a class="dropdown-item" href="{{ route('user.edit', $item) }}">Edit</a></li>
        <li><a class="dropdown-item" href="#"
                onclick="event.preventDefault(); if(confirm('Are you sure want to delete?'))$('#delete-form-{{ $item->id }}').submit();">Delete</a>
        </li>
    </ul>
</div>

<form method="POST" action="{{ route('user.destroy', [$item]) }}" id="delete-form-{{ $item->id }}"
    style="display: none;">
    @csrf
    @method('DELETE')
</form>
