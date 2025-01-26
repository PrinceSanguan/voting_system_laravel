<!DOCTYPE html>
<html lang="en" class="material-style layout-fixed">

@include('admin.files.head')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.css">

<body>
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>

    <div class="layout-wrapper layout-2">
        <div class="layout-inner">
            @include('admin.files.sidebar')

            <div class="layout-container">
                @include('admin.files.navbar')

                <div class="layout-content">
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <h4 class="font-weight-bold py-3 mb-0">{{ $label }}</h4>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item active">{{ $label }}</li>
                            </ol>
                        </div>
                        <hr class="border-light container-m--x my-0">
                        <div class="font-weight-bold my-3">Election Title: {{ $election_title }} for Year {{ $election_year }}</div>
                        @if(session()->has('response'))
                            <div class="alert {{ session()->get('response') == 1 ? 'alert-success' : 'alert-danger' }}">
                                {{ session()->get('message') }}
                            </div>
                        @endif

                        <div class="card my-3 p-3">
                            <h5 class="font-weight-bold text-center mb-4">Candidates Ranking</h5>
                            @php
                                // Rank candidates based on votes
                                $rankings = [];
                                foreach($data as $position => $candidates) {
                                    // Sort candidates by vote descending
                                    usort($candidates, function ($a, $b) {
                                        return $b['vote'] <=> $a['vote'];
                                    });
                                    $rankings[$position] = $candidates;
                                }
                            @endphp

                            <!-- Display the rankings in a grid -->
                            <div class="row">
                                @foreach($rankings as $position => $candidates)
                                    <div class="col-md-4">
                                        <div class="card mb-4 shadow-sm">
                                            <div class="card-header text-center bg-primary text-white">
                                                <strong>{{ $position }}</strong>
                                            </div>
                                            <div class="card-body">
                                                @foreach($candidates as $index => $candidate)
                                                    @if($index < 3) <!-- Display top 3 candidates -->
                                                        <div class="d-flex justify-content-between align-items-center my-2">
                                                            <div>
                                                                <span class="badge badge-pill {{ $index == 0 ? 'badge-success' : ($index == 1 ? 'badge-warning' : 'badge-info') }}">
                                                                    Rank {{ $index + 1 }}
                                                                </span>
                                                                <strong>{{ $candidate['first_name'] }} {{ $candidate['last_name'] }}</strong>
                                                            </div>
                                                            <div>
                                                                <span class="badge badge-primary">
                                                                    {{ $candidate['vote'] }} Votes
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="card p-3">

                            @php
                                // Calculate rankings based on votes, and handle ties
                                $rankings = [];
                                foreach ($data as $position => $candidates) {
                                    // Sort candidates by votes (descending order)
                                    usort($candidates, function($a, $b) {
                                        return $b['vote'] <=> $a['vote'];
                                    });
                                    $rankings[$position] = $candidates;
                                }
                            @endphp

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>First Name</th>
                                            <th>Middle Name</th>
                                            <th>Last Name</th>
                                            <th>Position</th>
                                            <th>Election Title</th>
                                            <th>Election Year</th>
                                            <th>Votes</th>
                                            <th>Rank</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $count = 1;

                                            function getOrdinalSuffix($number) {
                                                $suffixes = ['th', 'st', 'nd', 'rd'];
                                                $value = $number % 100;
                                                if ($value >= 11 && $value <= 13) return $number . 'th';
                                                return $number . ($suffixes[$number % 10] ?? 'th');
                                            }

                                            foreach($rankings as $position => $candidates) {
                                                $currentRank = 1;
                                                $previousVote = null;
                                                $rankedCandidates = []; // Store rank positions for candidates with same votes

                                                @endphp
                                                <!-- Position header row with colspan -->
                                                <tr>
                                                    <td colspan="9" class="text-center font-weight-bold bg-light">{{ $position }}</td>
                                                </tr>
                                                @foreach($candidates as $index => $candidate)
                                                    @php
                                                        // If the current vote is the same as the previous, use the same rank
                                                        if ($previousVote !== null && $candidate['vote'] === $previousVote) {
                                                            $rankedCandidates[] = $currentRank; // Store the same rank for the tie
                                                        } else {
                                                            // Set rank for candidates and increase rank counter
                                                            $currentRank += count($rankedCandidates); // Move rank forward
                                                            $rankedCandidates = [$currentRank]; // Set rank for this candidate
                                                        }
                                                        $previousVote = $candidate['vote']; // Store current vote count for next iteration
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $count++ }}</td>
                                                        <td>{{ $candidate['first_name'] }}</td>
                                                        <td>{{ $candidate['middle_name'] }}</td>
                                                        <td>{{ $candidate['last_name'] }}</td>
                                                        <td>{{ $candidate['position'] }}</td>
                                                        <td class="text-center">{{ $candidate['election_title'] }}</td>
                                                        <td class="text-center">{{ $candidate['election_year'] }}</td>
                                                        <td class="text-center">{{ $candidate['vote'] ?? 0 }}</td> <!-- Handle null votes -->
                                                        <td class="font-weight-bold">
                                                            {{ getOrdinalSuffix($rankedCandidates[0]) }} <!-- Display rank with ordinal suffix -->
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @php
                                            }
                                        @endphp
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                    @include('admin.files.footer')

                </div>

            </div>
        </div>
        <div class="layout-overlay layout-sidenav-toggle"></div>
    </div>

    @include('admin.files.scripts')
</body>
</html>
