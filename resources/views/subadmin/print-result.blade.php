<!DOCTYPE html>
<html lang="en">
<head>
    <title>Print Election Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .position-header {
            background-color: #d1cfc9 !important; /* Ensure it's applied */
        }
        .fs-6{
          font-size: 12px !important;
          font-weight: 700;
        }
        .fs-7{
          font-weight: bold !important;
          font-size: 14px !important;
          letter-spacing: 2px;
        }
        div{
          padding: 0px !important;
        }
        th{
          font-size: 11px !important;
          font-weight: bold;
        }
        td{

          font-size: 10px !important;
/*          font-weight: bold;*/

        }
    </style>
</head>
<body>

    <div class="container mb-5">
      <div class="d-flex justify-content-center">
        <img src="{{ asset('print/logo.png') }}" height="100px" width="100px" >
        <div class="text-center">
          <div class="fs-7">West Visayas State University</div>
          <div class="fs-6">(Formerly Iloilo Normal School)</div>
          <div class="fs-7">HIMAMAYLAN CITY CAMPUS</div>
          <div class="fs-6">Brgy. Caradio-an Himamaylan City, Negros Occidental, 6108</div>
          <div class="fs-6">* Tel. No. (034)-388-3300</div>
          <div class="fs-6">* Official Page <a href="https:www.facebook.com/westhimamaylan/">https:www.facebook.com/westhimamaylan/</a></div>
          <div class="fs-6">Email Address: himamaylan@wvsu.edu.ph</div>
        </div>
        <img src="{{ asset('print/logo.png') }}" height="100px" width="100px" >
      </div>

      <div class="my-3 text-center">
        <div class="fw-bold fs-7">{{ $electionYear }} {{ $electionTitle }}</div>
        <div class="fw-bold fs-7">CERTIFICATE OF CANVASS</div>
        <div class="fw-bold fs-7">FOR ORGANIZATION</div>
        <div class="fw-bold fs-7">COC NO.: 1 of 1</div>
      </div>

      <div class="my-2 fw-semibold">
      <!-- <div>TOTAL NUMBERS OF COC's REPORTED: <b>5</b></div> -->
      <div>TOTAL NUMBERS OF COC's ELECTORATES: <b>{{ $votersCount }}</b></div>
      <div>TOTAL NUMBERS OF COC's ELECTORATES THAT ACTUALLY VOTED: <b>{{ $uniqueBallotsCount }}</b></div>
      <div>VOTER's TURNOUT (%): <b>{{ $percentage }}</b></div>
    </div>

    </div>
    
    <div class="container mb-5">
        <table class="table table-bordered mt-4" style="border: 1px solid black">
            <thead>
              <tr class="text-center">
                <th colspan="5">{{ $electionTitle }}</th>
              </tr>
                <tr>
                    <th class="text-center">NAME OF CANDIDATES/POSITION</th>
                    <th class="text-center">TOTAL GARRNERED VOTES</th>
                    <th class="text-center">PERCENTAGE OF VOTES (%)</th>
                    <th class="text-center">RANKING</th>
                </tr>
            </thead>
            <tbody>
                  @php
                      // To manage ranks
                      $rank = 1;
                      $lastVoteCount = null;
                  @endphp
                  @foreach($candidatesByPosition as $position => $candidates)
                      <tr class="position-header">
                          <td colspan="5" style="background-color: #bdb7b7" class="text-center fw-semibold">{{ $position }}</td>
                      </tr>

                      @foreach($candidates as $index => $candidate)
                          @if ($lastVoteCount !== $candidate['vote'])
                              @php
                                  $rank = $index + 1; // Update rank if the vote count has changed
                              @endphp
                          @endif
                          <tr>
                              <td class="text-center">{{ $candidate['last_name'] ?? 'N/A' }}, {{ $candidate['first_name'] ?? 'N/A' }}</td>
                              <td class="text-center">{{ $candidate['vote'] ?? 0 }}</td>
                              <td class="text-center">
                                  @php
                                      $percentage = $votersCount > 0 ? ($candidate['vote'] / $votersCount) * 100 : 0; // Calculate percentage
                                  @endphp
                                  {{ number_format($percentage, 2) }}%
                              </td>
                              <td class="text-center">{{ $rank }}</td>
                          </tr>
                          @php
                              $lastVoteCount = $candidate['vote']; // Update last vote count
                          @endphp
                      @endforeach
                  @endforeach
              </tbody>

        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="text/javascript">
      window.print()
    </script>
</body>
</html>
