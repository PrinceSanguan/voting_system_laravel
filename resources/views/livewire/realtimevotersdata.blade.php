<div>
    <select class="form-control" wire:change="handleChange($event.target.value)">
        <option value="all">All</option>
        <option value="voted">Voted</option>
        <option value="not voted">Not Voted</option>
    </select>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Age</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($votersList as $index => $voter)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $voter['first_name'] }}</td>
                    <td>{{ $voter['age'] }}</td>
                    <td>{{ $voter['status'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
