<table class="table table-responsive" id="plans-table">
    <thead>
        <tr>
            <th>Hotspot Id</th>
        <th>Name</th>
        <th>Price</th>
        <th>Shared Users</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($plans as $plan)
        <tr>
            <td>{!! $plan->hotspot_id !!}</td>
            <td>{!! $plan->name !!}</td>
            <td>{!! $plan->price !!}</td>
            <td>{!! $plan->shared_users !!}</td>
            <td>
                {!! Form::open(['route' => ['plans.destroy', $plan->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('plans.show', [$plan->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('plans.edit', [$plan->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>