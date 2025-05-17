@extends('layouts.app')

@section('content')
<div class="container">
    <h2>🏆 Leaderboard ({{ ucfirst($scope) }})</h2>

    <form method="GET" action="{{ route('leaderboard.index') }}" class="mb-3 d-flex gap-2">
        <select name="scope" onchange="this.form.submit()">
            <option value="daily" {{ $scope == 'daily' ? 'selected' : '' }}>Day</option>
            <option value="monthly" {{ $scope == 'monthly' ? 'selected' : '' }}>Month</option>
            <option value="yearly" {{ $scope == 'yearly' ? 'selected' : '' }}>Year</option>
        </select>

        <input type="text" name="search" value="{{ $searchId }}" placeholder="User ID" class="form-control" />
        <button class="btn btn-primary">Search</button>
    </form>

    <form method="POST" action="{{ route('leaderboard.recalculate') }}">
        @csrf
        <button type="submit" class="btn btn-warning mb-3">🔁 Recalculate</button>
    </form>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="this.parentElement.remove();"></button>
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Rank</th>
                <th>User ID</th>
                <th>Name</th>
                <th>Total Points</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leaderboard as $user)
            <tr>
                <td>{{ $user->rank }}</td>
                <td>{{ $user->user_id }}</td>
                <td>{{ $user->user->full_name }}</td>
                <td>{{ $user->total_points }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">No data found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
