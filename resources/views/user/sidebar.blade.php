<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
      <div class="offcanvas-header text-center bg-dark text-light">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Nexus' E-Voting</h5>
        <button type="button" class="btn-close bg-light" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body d-flex flex-column justify-content-start">
        <ul>
          <li>
            <a href="{{ route('voter.index') }}" class="link link-light text-decoration-none fw-bold">
              <i class="fa-solid fa-hand-point-right"></i> Ballot Box
            </a>
          </li>
          <li>
            <a href="{{ route('voter.info') }}" class="link link-light text-decoration-none fw-bold">
              <i class="fa-solid fa-hand-point-right"></i> My Info
            </a>
          </li>
          <!-- Add more items as needed -->
        </ul>
      </div>
    </div>