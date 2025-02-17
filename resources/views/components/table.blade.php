@props([
    'tableName'        => null,
    'title'            => null,
    'createUrl'        => null,
    'createText'       => null,
    'columns'          => [],
    'bankers'          => [],
    'editRouteName'    => null,
    'destroyRouteName' => null,
])
<div class="row">
    <div class="col-xl-12">
        <div class="">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">{{ $title }}</h4>
                <h4>
                    <a href="{{ $createUrl }}" class="btn btn-primary">{{ $createText }}</a>
                </h4>
            </div>
            <div class="card-body">
                <div class="live-preview">
                    <div class="table-responsive table-card">
                        <table id="{{ $tableName }}" class="table align-middle table-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    @foreach($columns as $column)
                                        <th>{{ $column }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bankers as $data)
                                    <tr>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->email }}</td>
                                        <td>
                                            <a href="{{ route($editRouteName, $data) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route($destroyRouteName, $data) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
