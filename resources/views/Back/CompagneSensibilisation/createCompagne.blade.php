

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
                                                        <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" placeholder="Enter Title" value="{{ old('title') }}" id="title" autofocus>
                                                    </div>  
                                                    @if ($errors->has('title'))
                                                        @foreach ($errors->get('title') as $error)
                                                            @if ($error == 'The title field is required.')
                                                                <div class="text-danger h6 mt-1" id="error-title">Title is required</div>
                                                            @elseif ($error == 'The title must be at least 5 characters.')
                                                                <div class="text-danger h6 mt-1" id="error-title">The title must be at least 5 characters long</div>
                                                            @elseif ($error == 'The title may not be greater than 255 characters.')
                                                                <div class="text-danger h6 mt-1" id="error-title">The title cannot be more than 255 characters long</div>
                                                            @else
                                                                <div class="text-danger h6 mt-1" id="error-title">{{ $error }}</div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                              

                                                <div class="form-group mb-4">
                                                    <label for="start_date">Start Date</label>
                                                    <div class="input-group">
                                                      
                                                       <input data-datepicker=""  class="form-control {{ $errors->has('start_date') ? 'is-invalid' : '' }}" id="start_date" name="start_date" value="{{ old('start_date') }}" type="date" placeholder="dd/mm/yyyy">   
                                                
                                                    </div>  
                                                    @if ($errors->has('start_date'))
                                                        @foreach ($errors->get('start_date') as $error)
                                                            @if ($error == 'The start date field is required.')
                                                                <div class="text-danger h6 mt-1" id="error-startdate">Start date is required</div>
                                                            @elseif ($error == 'The start date must be a date after or equal to the current date.')
                                                                <div class="text-danger h6 mt-1" id="error-startdate">Start date must be a date after or equal to the current date.</div>
                                                            @elseif ($error == 'The start date is not a valid date.')
                                                                <div class="text-danger h6 mt-1" id="error-startdate">Please provide a valid start date.</div>
                                                            @else
                                                                <div class="text-danger h6 mt-1" id="error-startdate">{{ $error }}</div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label for="end_date">End Date</label>
                                                    <div class="input-group">
                                                       <input data-datepicker=""  class="form-control {{ $errors->has('end_date') ? 'is-invalid' : '' }}" id="end_date" type="date" name="end_date" value="{{ old('end_date') }}" placeholder="dd/mm/yyyy">   
                                                      
                                                    </div>  
                                                    @if ($errors->has('end_date'))
                                                        @foreach ($errors->get('end_date') as $error)
                                                            @if ($error == 'The end date field is required.')
                                                                <div class="text-danger h6 mt-1" id="error-enddate">End date is required</div>
                                                            @elseif ($error == 'The end date must be a date after the start date.')
                                                                <div class="text-danger h6 mt-1" id="error-enddate">End date must be after the start date.</div>
                                                            @elseif ($error == 'The end date is not a valid date.')
                                                                <div class="text-danger h6 mt-1" id="error-enddate">Please provide a valid date.</div>
                                                            @else
                                                                <div class="text-danger h6 mt-1" id="error-enddate">{{ $error }}</div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>


                                                <div class="form-group mb-4">
                                                    <label for="image" class="form-label">Image</label>
                                                    <input  class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" name="image" value="{{ old('image') }}" type="file" id="image">
                                                    @if ($errors->has('image'))
                                                        @foreach ($errors->get('image') as $error)
                                                            @if ($error == 'The image field is required.')
                                                                <div class="text-danger h6 mt-1" id="error-image">Image is required</div>
                                                            @elseif ($error == 'The image must be a file of type: jpeg, png, jpg, gif.')
                                                                <div class="text-danger h6 mt-1" id="error-image">Only JPEG, PNG, JPG, and GIF file types are allowed</div>
                                                            @elseif ($error == 'The image must not be larger than 2MB.')
                                                                <div class="text-danger h6 mt-1" id="error-image">The image size should not exceed 2MB</div>
                                                            @else
                                                                <div class="text-danger h6 mt-1" id="error-image">{{ $error }}</div>
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                </div>

                                                <div class="form-group mb-4">
                                                    <label for="target_audience">Target audience</label>
                                                    <div class="input-group">
                                                        <select  class="form-select {{ $errors->has('target_audience') ? 'is-invalid' : '' }}" id="target_audience" name="target_audience[]" aria-label="Default select example" multiple>
                                                        <option value="General Public" selected>General Public</option>
                                                            <option value="Youth and Students">Youth and Students</option>
                                                            <option value="Professionals and Workers">Professionals and Workers</option>
                                                            <option value="Institutions and Organizations">Institutions and Organizations</option>
                                                            <option value="Local Communities">Local Communities</option>
                                                        </select>
                                                    </div>  
                                                    @if ($errors->has('target_audience'))
                                                        <div class="text-danger h6 mt-1">Target audience is required</div>
                                                    @endif
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label for="description">Description</label>
                                                    <div class="input-group">
                                                        <textarea  class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" placeholder="Enter description..." id="description" rows="4">{{ old('description') }}</textarea>
                                                    </div>  

                                                    @if ($errors->has('description'))
                                                        @foreach ($errors->get('description') as $error)
                                                            @if ($error == 'The description field is required.')
                                                                <div class="text-danger h6 mt-1" id="error-description">Description is required</div>
                                                            @elseif ($error == 'The description must be at least 150 characters.')
                                                                <div class="text-danger h6 mt-1" id="error-description">The description must be at least 150 characters long</div>
                                                            @elseif ($error == 'The description may not be greater than 1000 characters.')
                                                                <div class="text-danger h6 mt-1" id="error-description">The description cannot be more than 1000 characters long</div>
                                                            @else
                                                                <div class="text-danger h6 mt-1" id="error-description">{{ $error }}</div>
                                                            @endif
                                                        @endforeach
                                                    @endif
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

