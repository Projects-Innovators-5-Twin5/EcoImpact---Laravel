
<script src="{{ asset('js/participation.js') }}"></script>


<div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2 class="h6 modal-title">Participant Details</h2>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <div class="card card-body border-0 shadow mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <!-- Avatar -->
                                                <img class="rounded avatar-xl" src="{{ '/assets/img/team/profile-picture-2.jpg' }}"
                                                    alt="change avatar">
                                            </div>
                                            <div class="file-field">
                                                <div class="d-flex justify-content-xl-center ms-xl-3">
                                                    <div class="d-flex">
                                                    
                                                        <div class="d-md-block text-left">
                                                            <div class="fw-bold text-dark mb-1" id="name"></div>
                                                            <div class="text-gray mb-1" id="email"></div>
                                                            <div class="text-gray" id="phone"></div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                       </div>    
                                    </div class="card card-body border-0 shadow mb-4">
                                        <div class="d-md-block text-left">
                                            <div class="fw-bold text-dark mb-1">Reasons to join our campaign</div>
                                            <div class="text-gray mb-1" id="reasons"></div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                    <form id="reject-form" action="" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-gray-400" id="reject"><span style="color:white;">Reject</span></button>
                                    </form>
                                    <form id="accept-form" action="" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary" id="accept"><span style="color:white;">Accept</span></button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>

