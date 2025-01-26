<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EleVote</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @include('user.styles')

  </head>
  <body>
    @include('user.navbar')

    @include('user.sidebar')
    

<section class="container my-5">
  <!-- {{ session()->get('hasVoting') }} -->
  <div class="alert alert-danger border-0 fs-5 fw-bold text-center col-12 d-none py-5 rounded-3" id="message"></div>
    <div id="hasVoting">
        <div class="row justify-content-center">
            <!-- Voting form -->
            <form class="col-lg-6 col-12 d-none" id="isVoted" method="post" action="{{ route('submit.vote') }}">
                @csrf
                <input type="hidden" value="{{ session()->get('organization') }}" name="organization">
                <div id="positions-container">
                    <!-- Candidate positions will be rendered here dynamically, one by one -->
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary d-none px-4" id="previous-btn"><i class="fa fa-arrow-left"></i>Previous</button>
                    <button type="button" class="btn btn-primary d-none px-5" id="next-btn">Next <i class="fa fa-arrow-right"></i></button>
                    <button type="button" class="btn btn-success d-none px-5" id="submit-btn">Submit</button>
                </div>
            </form>

            <div class="col-lg-6 col-12 mt-5 d-none" id="realtime_votes">
                <div class="card p-5 shadow-lg border-0 border-top border-5 border-dark mb-5">
                    <div class="fw-bold mb-2 fs-5">Voting Results:</div>
                    <div id="realtime-result">
                        <p class="text-danger">Loading Results Please Wait....</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Modal for Confirmation -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Your Votes. You can Only Vote Once!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form method="post" action="{{ route('submit.vote') }}">
                    @csrf
                    <div id="modal-content">
                        <!-- Votes will be displayed here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="confirm-submit">Vote</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        const ip  = `{{ session()->get('ip') }}`;
        console.log(ip)
    </script>
    <script>
      $(document).ready(function(){

        const hasVoting = async () => {
          try {
            const response = await fetch(`${ip}/api/hasVoting?organization={{ session()->get('organization') }}`);
            if (!response.ok) {
              throw new Error(`Network Error: ${response.status}`);
            }
            const result = await response.json();
            
            if (!result.response) {
              console.log(result.message);
              $("#hasVoting").hide();
              $('#message').removeClass('d-none').text(result.message);
              $("#realtime_votes").addClass('d-none');
            }else{
              console.log(result.response);
              $("#hasVoting").show();
              $('#message').addClass('d-none');
              $("#realtime_votes").removeClass('d-none');
            }
            
          } catch (error) {
            console.error(`Error Message: ${error}`);
          }
        }

        setInterval(() => {
          hasVoting();
        }, 1000);
        
      });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            let currentPositionIndex = 0;
            let positionsData = [];
            let votes = {}; // Object to store votes for each position

            const fetchData = async () => {
                try {
                    const url = `${ip}/api/voting_start?organization={{ session()->get('organization') }}&fingerprint={{ session()->get('user_fingerprint') }}`;
                    const response = await fetch(url);

                    if (!response.ok) {
                        throw new Error(`Network Connection Error: ${response.status}`);
                    }

                    const result = await response.json();
                    console.log(result);
                    positionsData = Object.entries(result.data); // Store all positions

                    renderPosition(); // Render the first position
                } catch (e) {
                    console.error(`Error Message: ${e}`);
                }
            };

            const renderPosition = () => {
    const positionsContainer = document.getElementById('positions-container');
    positionsContainer.innerHTML = ''; // Clear the previous position

    if (positionsData.length > 0) {
        const [position, candidates] = positionsData[currentPositionIndex];

        let positionHtml = `<div class="col-lg-12 mt-5">
                            <div class="card p-lg-5 p-1 shadow-lg border-0 border-top border-5 border-dark mb-5">
                                <h3 class="fw-bold">${position}</h3>`;

        candidates.forEach(candidate => {
            const isSelected = votes[position]?.id == candidate.id ? 'checked' : ''; // Check if already selected
            positionHtml += `
                <ul class="my-2">
                    <li class="mb-4">PartyList: ${candidate.partylist ? candidate.partylist : 'Independent'}</li>
                    <li class="d-block">
                        <a href="{{ asset('images/${candidate.candidate_image}') }}" class="text-decoration-none">
                            <img class="rounded-2" src="{{ asset('images/${candidate.candidate_image}') }}" height="100px" width="100px" alt="${candidate.first_name}">
                        </a>
                        <div class="form-check border border-1 py-2 mt-3">
                            <input class="form-check-input mx-2" type="radio" name="${position}" value="${candidate.id}" ${isSelected} required>
                            <label class="form-check-label">
                                ${candidate.first_name} ${candidate.last_name}
                            </label>
                        </div>
                    </li>
                </ul>`;
        });

        positionHtml += `</div></div>`;

        positionsContainer.innerHTML = positionHtml;

        // Update button visibility based on current position
        updateButtonVisibility();
    }
};

            

            // Function to update button visibility based on the current position
            const updateButtonVisibility = () => {
                const previousBtn = document.getElementById('previous-btn');
                const nextBtn = document.getElementById('next-btn');
                const submitBtn = document.getElementById('submit-btn');

                // If on the first position, show only "Next" button
                if (currentPositionIndex === 0) {
                    previousBtn.classList.add('d-none');
                    nextBtn.classList.remove('d-none');
                    submitBtn.classList.add('d-none');
                }
                // If on the last position, show only "Submit" and "Previous" button
                else if (currentPositionIndex === positionsData.length - 1) {
                    previousBtn.classList.remove('d-none');
                    nextBtn.classList.add('d-none');
                    submitBtn.classList.remove('d-none');
                }
                // For any middle positions, show both "Next" and "Previous" buttons
                else {
                    previousBtn.classList.remove('d-none');
                    nextBtn.classList.remove('d-none');
                    submitBtn.classList.add('d-none');
                }
            };

            // Event listener for the Next button
            $('#next-btn').on('click', () => {
                if (currentPositionIndex < positionsData.length - 1) {
                    currentPositionIndex++;
                    renderPosition();
                }
            });

            // Event listener for the Previous button
            $('#previous-btn').on('click', () => {
                if (currentPositionIndex > 0) {
                    currentPositionIndex--;
                    renderPosition();
                }
            });

            // Event listener for radio button selection
            $(document).on('change', 'input[type="radio"]', function () {
                const positionName = $(this).attr('name'); // Get the position name from the radio button
                const candidateId = $(this).val(); // Get the selected candidate ID
                const candidateName = $(this).next('label').text(); // Get the candidate's name from the label

                // Store the selected vote for the position (candidate ID and name)
                votes[positionName] = {
                    id: candidateId,
                    name: candidateName
                };
            });

            // Event listener for the Submit button
            $('#submit-btn').on('click', () => {
                // Populate the modal with the selected votes
                const modalContent = document.getElementById('modal-content');
                modalContent.innerHTML = ''; // Clear previous content
                for (const position in votes) {
                    modalContent.innerHTML += `
                        <p>${position}: ${votes[position].name}</p>
                        <input class="form-control" type="hidden" name="${position}" value="${votes[position].id}" required>
                    `; // Display candidate name and include radio input
                }
                // Show the modal
                $('#confirmationModal').modal('show');
            });
            fetchData();
        });
    </script>
    <script type="text/javascript">
      $(document).ready(function(){
        const realtime_result = async () => {
          try {
            const url = `${ip}/api/realtime_result?organization={{ session()->get('organization') }}&fingerprint={{ session()->get('id') }}`;
            const response = await fetch(url);
            console.log(url);
            if (!response.ok) {
              throw new Error(`Network Connection Error: ${response.status}`);
            }

            const result = await response.json();
            console.log(result);
            const resultsContainer = $('#realtime-result');
            resultsContainer.empty();

            // Render the real-time voting results
            for (const [position, candidates] of Object.entries(result.data)) {
              candidates.sort((a, b) => (b.vote || 0) - (a.vote || 0));
              let positionHtml = `<h4 class="fw-bold">${position}</h4>`;

              candidates.forEach(candidate => {

                let percent = (candidate.vote / result.voters) * 100;
                    percent = percent.toFixed(2);


                let percentage = candidate.votes_percentage || 0; // Assume there's a percentage value in the API
                positionHtml += `
                  <div class="my-3">
                    <span class="text-secondary m">
                    <i class="fa-regular fa-user fa-2x text-danger"></i>
                      Unknown (${candidate.vote == null ? 0 : percent}% vote)
                    </span>
                    <div class="progress mt-1" style="height: 30px;">
                      <div 
                      class="progress-bar bg-success" role="progressbar" 
                      style="width: ${percent == null ? 0 : percent}%" 
                      aria-valuenow="${percent == null ? 0 : percent}" 
                      aria-valuemin="0" 
                      aria-valuemax="100"
                      >${candidate.vote == null ? 0 : percent}</div>
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
          
          let election_year = "{{ session()->get('election_year') }}";
          let election_title = "{{ session()->get('election_title') }}";
          
          if (!election_year && !election_title) {
            election_year = 'nodata';
            election_title = "nodata"
          }

          console.log(election_year + election_title);

          try {
            const url = `${ip}/api/isVoted?id={{ session()->get('id') }}&election_year=${election_year}&election_title=${election_title}`;
            console.log(encodeURI(url));
            const response = await fetch(encodeURI(url));

            if (!response.ok) {
              throw new Error(`Network Connection Error: ${response.status}`);
            }

            const result = await response.json();
            console.log(result);

            const isVotedElement = $("#isVoted");
            const submit = $("#submit");

            if (result.response == 1) {

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
