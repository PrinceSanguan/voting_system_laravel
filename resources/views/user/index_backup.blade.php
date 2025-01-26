<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EleVote</title>
    <link rel="icon" type="image/x-icon" href="{{asset('Elevotelogo.png')}}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @include('user.styles')

  </head>
  <body>
    @include('user.navbar')

    @include('user.sidebar')

    <section class="container my-5">
      <h1 class="text-center fw-bold election-title">Election Title: {{ session()->get('election_title') }}</h1>
      <div class="row mt-5 justify-content-center">
          <!-- Voting form -->
          <form class="col-lg-6 col-12 d-none" id="isVoted" method="post" action="{{ route('submit.vote') }}">
            @csrf
            <input type="hidden" value="{{ session()->get('organization') }}" name="organization">
            <div id="positions-container">
              <!-- Candidate positions will be rendered here dynamically -->
            </div>
            <button type="submit" class="btn btn-primary col-12 d-none" id="submit">Submit</button>
          </form>
        <div class="col-lg-6 col-12">
          <div class="card p-5 shadow-lg border-0 border-top border-5 border-dark mb-5">
            <div class="fw-bold mb-2 fs-5">Voting Results:</div>
            <div id="realtime-result">
              <p class="text-danger">Loading Results Please Wait....</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script type="text/javascript">
      $(document).ready(function(){

        const fetchData = async () => {
  try {
    const url = `http://127.0.0.1:8000/api/voting_start?organization={{ session()->get('organization') }}&fingerprint={{ session()->get('user_fingerprint') }}`;
    const response = await fetch(url);

    if (!response.ok) {
      throw new Error(`Network Connection Error: ${response.status}`);
    }

    const result = await response.json();
    console.log(result);

    // Container for all positions
    const positionsContainer = document.getElementById('positions-container');

    // Categorize and render the candidates by position
    for (const [position, { candidates, maxVotes }] of Object.entries(result.data)) {
      let positionHtml = `<div class="col-lg-12">
                            <div class="card p-lg-5 p-1 shadow-lg border-0 border-top border-5 border-dark mb-5">
                              <h3 class="fw-bold">${position} (Max Votes: ${maxVotes})</h3>`;

      candidates.forEach(candidate => {
        positionHtml += `
          <ul class="my-5">
            <li class="mb-4">PartyList: ${candidate.partylist ? candidate.partylist : 'Independent'}</li>
            <li class="d-block">
              <a href="{{ asset('images/${candidate.candidate_image}') }}" class="text-decoration-none">
                <img class="rounded-2" src="{{ asset('images/${candidate.candidate_image}') }}" height="100px" width="100px" alt="${candidate.first_name}">
              </a>
              <div class="form-check border border-1 p-2 mt-3">
                <input class="form-check-input mx-2" type="radio" name="${position}" value="${candidate.id}" required>
                <label class="form-check-label">
                  ${candidate.first_name} ${candidate.last_name}
                </label>
              </div>
            </li>
          </ul>`;
      });

      positionHtml += `</div></div>`;

      // Append the position and its candidates to the container
      positionsContainer.innerHTML += positionHtml;
    }

    // Handle radio button selection with maxVotes
    $(document).on('change', `input[name="${position}"]`, function () {
    const positionVotes = votes[position] || [];
    const candidateId = $(this).val();

    if ($(this).is(':checked')) {
        if (positionVotes.length < maxvote) {
            positionVotes.push({ id: candidateId });
            votes[position] = positionVotes;
        } else {
            $(this).prop('checked', false);
            alert(`You can only select up to ${maxvote} candidates for ${position}.`);
        }
    } else {
        votes[position] = positionVotes.filter(v => v.id != candidateId);
    }
});

  } catch (e) {
    console.error(`Error Message: ${e}`);


          }
        }
        setTimeout(fetchData, 3000);
        // fetchData();
      });
    </script>
    <script type="text/javascript">
      $(document).ready(function(){
        const realtime_result = async () => {
          try {
            const url = `http://127.0.0.1:8000/api/realtime_result?organization={{ session()->get('organization') }}&fingerprint={{ session()->get('user_fingerprint') }}`;
            const response = await fetch(url);
            console.log(url);
            if (!response.ok) {
              throw new Error(`Network Connection Error: ${response.status}`);
            }

            const result = await response.json();
            const resultsContainer = $('#realtime-result');
            resultsContainer.empty();

            // Render the real-time voting results
            for (const [position, candidates] of Object.entries(result.data)) {
              let positionHtml = `<h4 class="fw-bold">${position}</h4>`;

              candidates.forEach(candidate => {
                let percentage = candidate.votes_percentage || 0; // Assume there's a percentage value in the API
                positionHtml += `
                  <div class="mb-3">
                    <span class="text-secondary">${candidate.first_name} ${candidate.last_name} (${candidate.vote == null ? 0 : candidate.vote} votes)</span>
                    <div class="progress mt-1" style="height: 20px;">
                      <div class="progress-bar bg-success" role="progressbar" style="width: ${candidate.vote == null ? 0 : candidate.vote}%" aria-valuenow="${candidate.vote == null ? 0 : candidate.vote}" aria-valuemin="0" aria-valuemax="100">${candidate.vote == null ? 0 : candidate.vote}</div>
                    </div>
                  </div>`;
              });

              // Append the position results to the container
              resultsContainer.append(positionHtml);
            }
          } catch (e) {
            console.error(`Error Message: ${e}`);
          }
        }

        // Fetch the results every 5 seconds
        setInterval(realtime_result, 4000);
      });
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
      const isVoted = async () => {

        try {
          const url = `http://127.0.0.1:8000/api/isVoted?fingerprint={{ session()->get('user_fingerprint') }}&election_year={{ session()->get('election_year') }}&election_title={{ session()->get('election_title') }}`;
          console.log(url);
          const response = await fetch(url);

          if (!response.ok) {
            throw new Error(`Network Connection Error: ${response.status}`);
          }

          const result = await response.json();
          const isVotedElement = $("#isVoted");
          const submit = $("#submit");

          if (result.response != 1) {
            setTimeout(()=> {
              submit.removeClass('d-none');
            }, 4000);
            
            isVotedElement.removeClass('d-none');
          }else{
            isVotedElement.addClass('d-none');
            submit.addClass('d-none');
          }

        } catch (e) {
          console.error(`Error Message: ${e}`);
        }
      };

      const intervalId = setInterval(isVoted, 4000);

      // Optionally clear the interval when not needed
      // $(window).on('beforeunload', () => clearInterval(intervalId));
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function() {

      let alertShown = false; // Flag to prevent repeated alerts

      const checkOrg = async () => {
        try {
          const url = `http://127.0.0.1:8000/api/checkIfstarted?organization={{ session()->get('organization') }}`;
          const response = await fetch(url);
          console.log(url);

          if (!response.ok) {
            throw new Error(`Network Error ${response.status}`);
          }

          const result = await response.json();
          console.log(result);

          if (result.response == 2 && !alertShown) {
            alertShown = true; // Set the flag to true
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Something went wrong!",
              confirmButtonText: "Ok",
            }).then((result) => {
              if(result.isConfirmed) {
                window.location.href = "/user-logout";
              }
            });
            clearInterval(checkInterval); // Stop further checks
          }

        } catch (e) {
          console.error(`Error Message: ${e}`);
        }
      }

      // Set an interval to run the checkOrg function every 2 seconds
      const checkInterval = setInterval(checkOrg, 2000);

    });
</script>
  <script type="text/javascript">
    $(document).ready(function(){

      let result = {{ session()->get('response') }};

      if (result == 1) {

          Swal.fire({
            icon: "success",
            title: "Success",
            text: "Your vote has been counted. Thank you!"
          });


      }

    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </body>
</html>
