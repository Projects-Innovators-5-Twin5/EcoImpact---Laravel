@extends('back.layout')
<link rel="stylesheet" href="{{ asset('css/compaign.css') }}">
<script src="{{ asset('js/compaign.js') }}"></script>


@section('content')

<div class="d-block mb-4 mb-md-0 mt-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="#">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#">EcoImpact</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="/campaigns">Awareness Campaigns</a></li>
            </ol>
        </nav>        
    </div>

<div class=" p-0 d-flex justify-content-center ">
<div class="card col-md-12  p-3 p-lg-4">
<div class="text-start text-md-start mb-4 mt-md-0">
                                                <h1 class="mb-0 h4">Edit Campaign</h1>
                                            </div>
                                           
                                            <form action="{{ route('campaigns.update' ,$campaign->id) }}"  method="POST" enctype="multipart/form-data">

                                                @csrf
                                                @method('PUT')
                                                <!-- Form -->
                                                <div class="form-group mb-4">
                                                    <label for="title">Title</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" value="{{ old('title', $campaign->title) }}" placeholder="Enter Title" id="title" autofocus >
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
                                                      
                                                       <input data-datepicker="" class="form-control {{ $errors->has('start_date') ? 'is-invalid' : '' }}" id="start_date" value="{{ old('start_date', $campaign->start_date) }}" name="start_date" type="date" placeholder="dd/mm/yyyy" >   
                                                
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
                                                       <input data-datepicker=""  class="form-control {{ $errors->has('end_date') ? 'is-invalid' : '' }}" id="end_date" type="date" value="{{ old('end_date', $campaign->end_date) }}" name="end_date" placeholder="dd/mm/yyyy" >   
                                                      
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
                                                    <input class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" name="image"  type="file" id="image">
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
                                                    <select class="form-select {{ $errors->has('target_audience') ? 'is-invalid' : '' }}" id="target_audience" name="target_audience[]" aria-label="Default select example" multiple>
                                                    @foreach (['General Public', 'Youth and Students', 'Professionals and Workers', 'Institutions and Organizations', 'Local Communities'] as $option)
                                                    <option value="{{ $option }}" {{ in_array($option, $campaign->target_audience ) ? 'selected' : '' }}>
                                                            {{ $option }}
                                                    </option>
                                                        @endforeach
                                                    </select>
                                                    </div>  
                                                    @if ($errors->has('target_audience'))
                                                        <div class="text-danger h6 mt-1">Target audience is required</div>
                                                    @endif
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label for="target_audience">Status</label>

                                                    <div class="input-group">

                                                        <select class="form-select" id="status" name="status" aria-label="Message select example 2">
                                                            @if($campaign->status == 'active')
                                                              <option value="active" selected>active</option>
                                                              <option value="upcoming">upcoming</option>
                                                              <option value="completed">completed</option>
                                                              <option value="archived">archived</option>
                                                            @elseif($campaign->status == 'upcoming')  
                                                               <option value="active">active</option>
                                                               <option value="upcoming" selected>upcoming</option>
                                                               <option value="completed">completed</option>
                                                               <option value="archived">archived</option>
                                                            @elseif($campaign->status == 'completed')  
                                                                <option value="active">active</option>
                                                                <option value="upcoming">upcoming</option>
                                                                <option value="completed" selected>completed</option>
                                                                <option value="archived">archived</option>
                                                            @else  
                                                                <option value="active">active</option>
                                                                <option value="upcoming">upcoming</option>
                                                                <option value="completed">completed</option>
                                                                <option value="archived" selected>archived</option>
                                                            @endif   
                                                        </select>
                                                    </div>  
                                                </div>


                                                <div class="form-group mb-4">
                                                    <label for="link_fb">Campaign facebook</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="link_fb" value="{{ old('link_fb', $campaign->link_fb) }}" placeholder="Enter facebook link" id="link_fb" autofocus >
                                                    </div>  
                                                    @if ($errors->has('link_fb'))
                                                        @foreach ($errors->get('link_fb') as $error)
                                                            @if ($error == 'The link fb field is required.')
                                                                <div class="text-danger h6 mt-1" id="error-link-fb">Facebook link is required</div>
                                                            @elseif ($error == 'The link fb must be a valid URL.')
                                                                <div class="text-danger h6 mt-1" id="error-link-fb">The Facebook link must be a valid URL</div>
                                                            @elseif ($error == 'The link fb may not be greater than 5000 characters.')
                                                                <div class="text-danger h6 mt-1" id="error-link-fb">The Facebook link cannot be more than 5000 characters long</div>
                                                            @else
                                                                <div class="text-danger h6 mt-1" id="error-link-fb">{{ $error }}</div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>


                                                <div class="form-group mb-4">
                                                    <label for="link_insta">Campaign instagram</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="link_insta" value="{{ old('link_insta', $campaign->link_insta) }}" placeholder="Enter instagram link" id="link_insta" autofocus >
                                                    </div>  
                                                    @if ($errors->has('link_insta'))
                                                        @foreach ($errors->get('link_insta') as $error)
                                                            @if ($error == 'The link_insta field is required.')
                                                                <div class="text-danger h6 mt-1" id="error-link-fb">Instagram link is required</div>
                                                            @elseif ($error == 'The link_insta must be a valid URL.')
                                                                <div class="text-danger h6 mt-1" id="error-link-fb">The instagram link must be a valid URL</div>
                                                            @elseif ($error == 'The link_insta may not be greater than 5000 characters.')
                                                                <div class="text-danger h6 mt-1" id="error-link-fb">The instagram link cannot be more than 5000 characters long</div>
                                                            @else
                                                                <div class="text-danger h6 mt-1" id="error-link-fb">{{ $error }}</div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>


                                                <div class="form-group mb-4">
                                                    <label for="link_web">Campaign website</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="link_web" value="{{ old('link_web', $campaign->link_web) }}" placeholder="Enter website link" id="link_web" autofocus >
                                                    </div>  
                                                    @if ($errors->has('link_web'))
                                                        @foreach ($errors->get('link_web') as $error)
                                                            @if ($error == 'The link_web field is required.')
                                                                <div class="text-danger h6 mt-1" id="error-link-fb">Website link is required</div>
                                                            @elseif ($error == 'The link_web must be a valid URL.')
                                                                <div class="text-danger h6 mt-1" id="error-link-fb">The website link must be a valid URL</div>
                                                            @elseif ($error == 'The link_web may not be greater than 5000 characters.')
                                                                <div class="text-danger h6 mt-1" id="error-link-fb">The website link cannot be more than 5000 characters long</div>
                                                            @else
                                                                <div class="text-danger h6 mt-1" id="error-link-fb">{{ $error }}</div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>


                                                <div class="form-group mb-4">
                                                    <label for="description">Description</label>
                                                    <div class="input-group">
                                                        <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" placeholder="Enter description..."  id="description" rows="4">{{ old('description', $campaign->description) }}</textarea>
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

                                                <div class="form-group mb-4">
                                                    <label for="reasons_join_campaign">Reasons to join the campaign </label>
                                                    <div class="input-group">
                                                        <textarea class="form-control" name="reasons_join_campaign" placeholder="Enter reasons to join the campaign..."  id="reasons_join_campaign" rows="4">{{ old('reasons_join_campaign', $campaign->reasons_join_campaign) }}</textarea>
                                                    </div>  
                                                    @if ($errors->has('reasons_join_campaign'))
                                                        @foreach ($errors->get('reasons_join_campaign') as $error)
                                                            @if ($error == 'The reasons_join_campaign field is required.')
                                                                <div class="text-danger h6 mt-1" id="error-description">Reasons to join campaign field is required</div>
                                                            @elseif ($error == 'The reasons_join_campaignfield must be at least 300 characters.')
                                                                <div class="text-danger h6 mt-1" id="error-description">The reasons to join campaign field must be at least 300 characters long</div>
                                                            @elseif ($error == 'The reasons_join_campaign field may not be greater than 1000 characters.')
                                                                <div class="text-danger h6 mt-1" id="error-description">The reasons to join campaign field cannot be more than 1000 characters long</div>
                                                            @else
                                                                <div class="text-danger h6 mt-1" id="error-description">{{ $error }}</div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>


                                                <div class="d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-gray-800">Submit</button>
                                                </div>
                                            </form> 
                                        </div>                                      
</div>

                                   
                            

@endsection