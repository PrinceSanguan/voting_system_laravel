<!DOCTYPE html>

<html lang="en" class="material-style layout-fixed">

@include('subadmin.files.head')
<style>
    .reminder-text {
        color: black; /* Default color for the text */
        font-size: 1.5em; /* Large text size */
        font-weight: bold;
    }

    .reminder-highlight {
        color: red; /* "Reminder:" is red */
    }
</style>

<body>
    <!-- [ Preloader ] Start -->
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <!-- [ Preloader ] Ebd -->
    
    <!-- [ Layout wrapper ] Start -->
    <div class="layout-wrapper layout-2">
        <div class="layout-inner">
            <!-- [ Layout sidenav ] Start -->
            @include('subadmin.files.sidebar')
            <!-- [ Layout sidenav ] End -->
            <!-- [ Layout container ] Start -->
            <div class="layout-container">
                <!-- [ Layout navbar ( Header ) ] Start -->
                @include('subadmin.files.navbar')
                <!-- [ Layout navbar ( Header ) ] End -->

                <!-- [ Layout content ] Start -->
                <div class="layout-content">
                <div class="form-group position-relative mt-3">
    <!-- Styled placeholder -->
                        <div class="layout-content">
                        <div class="container-fluid flex-grow-1 container-p-y"
                            @if($data->isEmpty()) <!-- Check if there are no elections -->
                                <div class="alert alert-danger text-center">
                                    <strong>Note:</strong> You cannot register candidates because no elections have been added. Please add an election first.
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- [ content ] Start -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <h4 class="font-weight-bold py-3 mb-0">{{ $label }}</h4>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item active">{{ $label }}</li>
                            </ol>
                        </div>
                        <div>
                            <!-- HOW TO ADD POSITION Button -->
                            <button type="button" class="btn btn-info my-3" id="howToAddPositionBtn">
    HOW TO ADD CANDIDATE
</button>

<div id="instructionsCard" class="card mt-3"  style="display: none;">
    <div class="card-header bg-primary text-white style" >
        <strong>How to Add Candidate</strong>
    </div>
    <div class="card-body">
        <p>
        Click the<span style="color: black;"><strong>"Continue ->"</strong></span>  button.
        </p>
        

                        </div>
                        </div>
</div>
                        
                        <hr class="border-light container-m--x my-0">
                        <div class="row mt-4">
                            @forelse($data as $key)
                            <div class="col-lg-4 my-2">
                                <div class="card shadow-lg">
                                    <div class="card-header bg-dark py-3 text-light font-weight-bold">
                                    {{ $key->tbl_year }} {{ $key->election_title }} 
                                    </div>
                                    <a href="{{ route('subadmin.to_candidate', [

                                        'id' => $key->id,
                                        'election_title' => $key->election_title,
                                                                              

                                        ]) }}" class="text-center text-dark py-3 font-weight-semibold">
                                        <p>
                                            Continue <i class="fa fa-arrow-right"></i>
                                        </p>
                                    </a>
                                </div>
                            </div>
                            @empty
                            
                            <div class="py-3 alert alert-danger text-center w-100 text-danger font-weight-bold">
                                No Upcomming Election
                            </div>
                            <div class="card col-12">
                                
                                          
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>

                            @endforelse
                        </div>
                        

                    </div>
                    <!-- [ content ] End -->

                    <!-- [ Layout footer ] Start -->
                    @include('subadmin.files.footer')
                    <!-- [ Layout footer ] End -->

                </div>
                <!-- [ Layout content ] Start -->

            </div>
            <!-- [ Layout container ] End -->
        </div>
        <!-- Overlay -->
        <div class="layout-overlay layout-sidenav-toggle"></div>
    </div>
    <!-- [ Layout wrapper ] end -->

    <!-- Core scripts -->
@include('subadmin.files.scripts')
<script>
        document.getElementById('howToAddPositionBtn').addEventListener('click', function () {
            const instructionsCard = document.getElementById('instructionsCard');
            instructionsCard.style.display = instructionsCard.style.display === 'none' ? 'block' : 'none';
        });
    </script>
</body>

</html>
