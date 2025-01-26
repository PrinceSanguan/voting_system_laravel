<!DOCTYPE html>
<html lang="en" class="material-style layout-fixed">

@include('subadmin.files.head')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.css">

<body>
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>

    <div class="layout-wrapper layout-2">
        <div class="layout-inner">
            @include('subadmin.files.sidebar')

            <div class="layout-container">
                @include('subadmin.files.navbar')

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
                        <div class="font-weight-bold my-3">{{ $election_title }} for {{ $election_year }}</div>
                        @if(session()->has('response'))
                            <div class="alert {{ session()->get('response') == 1 ? 'alert-success' : 'alert-danger' }}">
                                {{ session()->get('message') }}
                            </div>
                        @endif

                        

                        <div class="card p-3">

                            <button onclick="printData()" class="btn btn-primary col-2 my-3">
                                <i class="fa fa-print"></i> Print
                            </button>

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
                                            <th>Middle Initial</th>
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

                    @include('subadmin.files.footer')

                </div>

            </div>
        </div>
        <div class="layout-overlay layout-sidenav-toggle"></div>
    </div>

    @include('subadmin.files.scripts')

    <script>
        function printData() {
            // Gather the data you want to send
            const electionTitle = "{{ $election_title }}";
            const electionYear = "{{ $election_year }}";
            const data = @json($data); // Use Laravel's json directive

            // Create a query string
            const queryString = new URLSearchParams({
                election_title: electionTitle,
                election_year: electionYear,
                data: JSON.stringify(data)
            }).toString();

            // Redirect to the target page with query parameters
            window.location.href = `print-report?${queryString}`;
        }
    </script>
</body>
</html>
