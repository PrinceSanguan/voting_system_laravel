<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
      <div class="offcanvas-header text-center bg-dark text-light">
      <img src="{{ asset('Elevotelogo.png') }}" width="50" height="50" class="rounded-circle" alt=""> EleVote
        <button type="button" class="btn-close bg-light" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body d-flex flex-column justify-content-start">
        <ul>
          <li>
            <a href="{{ route('voter.index') }}" class="link link-light text-decoration-none fw-bold">
              <i class="fa-solid fa-hand-point-right"></i> Ballot 
            </a>
          </li>
          <li>
            <a href="{{ route('voter.info') }}" class="link link-light text-decoration-none fw-bold">
              <i class="fa-solid fa-hand-point-right"></i> My Info
            </a>
          </li>
          <li>
            <a  class="link link-light text-decoration-none fw-bold">
            <i></i> <h5><strong><span style="color:rgb(15, 228, 79);">HOW TO VOTE:</span></strong></h5><br>
            <span style="color:  #D3D3D3;">
                1. Review the list of Candidates.<br>
                2. Click on the circle, before to your chosen candidate's name.<br>
                3. Click "Previous" if you want to go back, and "Next" if you want to proceed.<br>
                4. After making selections for all positions, click the "Submit".<br>
                <span style="color: red;">!</span>A confirmation message will appear, displaying all your selected candidates.<span style="color: red;">!</span><br>
                5. If there is changes in your selection, click the "Close".<br>
                6. Once sure, click the "Vote".
            </span>
              
             
            </a>
          </li>
          <!-- Add more items as needed -->
        </ul>
      </div>
    </div>