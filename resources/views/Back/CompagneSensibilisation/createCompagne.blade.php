

<div class="modal fade" id="modal-createC-form" tabindex="-1" role="dialog" aria-labelledby="modal-createC-form" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <div class="card p-3 p-lg-4">
                                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                                            <div class="text-center text-md-center mb-4 mt-md-0">
                                                <h1 class="mb-0 h4">Add Campaign</h1>
                                            </div>
                                            <form action="{{ route('campaigns.store') }}" class="mt-4"  method="POST" enctype="multipart/form-data">

                                               @csrf
                                                <!-- Form -->
                                                <div class="form-group mb-4">
                                                    <label for="title">Title</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="title" placeholder="Enter Title" id="title" autofocus required>
                                                    </div>  
                                                </div>
                                              
                                                <div class="form-group mb-4">
                                                    <label for="start_date">Start Date</label>
                                                    <div class="input-group">
                                                      
                                                       <input data-datepicker="" class="form-control" id="start_date" name="start_date" type="date" placeholder="dd/mm/yyyy" required>   
                                                
                                                    </div>  
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label for="end_date">End Date</label>
                                                    <div class="input-group">
                                                       <input data-datepicker="" class="form-control" id="end_date" type="date" name="end_date" placeholder="dd/mm/yyyy" required>   
                                                      
                                                    </div>  
                                                </div>


                                                <div class="form-group mb-4">
                                                    <label for="image" class="form-label">Image</label>
                                                    <input class="form-control" name="image" type="file" id="image">
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label for="target_audience">Target audience</label>
                                                    <div class="input-group">
                                                        <select class="form-select" id="target_audience" name="target_audience[]" aria-label="Default select example" multiple>
                                                            <option value="Grand Public" selected>Grand Public</option>
                                                            <option value="Jeunes et Etudiants">Jeunes et Étudiants</option>
                                                            <option value="Professionnels et Travailleurs">Professionnels et Travailleurs</option>
                                                            <option value="Institutions et Organisations">Institutions et Organisations</option>
                                                            <option value="Communautes Locales">Communautés Locales</option>
                                                        </select>
                                                    </div>  
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label for="description">Description</label>
                                                    <div class="input-group">
                                                        <textarea class="form-control" name="description" placeholder="Enter description..." id="description" rows="4"></textarea>
                                                    </div>  
                                                </div>


                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-gray-800">Submit</button>
                                                </div>
                                            </form> 
                                        </div>
                                    </div>
                                </div>
                            </div>                      
</div>

