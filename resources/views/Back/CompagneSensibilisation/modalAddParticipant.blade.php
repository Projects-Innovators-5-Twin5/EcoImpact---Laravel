<script src="{{ asset('js/participation.js') }}"></script>

<div class="modal fade" id="modal-createP-form" tabindex="-1" role="dialog" aria-labelledby="modal-createP-form" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <div class="card p-3 p-lg-4">
                                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                                            <div class="text-center text-md-center mb-4 mt-md-0">
                                                <h1 class="mb-0 h4">Add Participant</h1>
                                            </div>
                                            <form action="" class="mt-4"  method="POST">

                                               @csrf
                                                <!-- Form -->
                                                <div class="form-group mb-4">
                                                    <label for="users">users</label>
                                                    <div class="input-group">
                                                            <select class="form-select" id="users" name="users[]" aria-label="Default select example">
                                                            
                                                            </select>
                                                    </div>  
                                                   
                                                </div>
                                                <input type="hidden" id="error-exist" value="{{ $errors->any() ? 'true' : 'false' }}">


                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-gray-800">Submit</button>
                                                </div>
                                            </form> 
                                        </div>
                                    </div>
                                </div>
                            </div>                      
</div>

