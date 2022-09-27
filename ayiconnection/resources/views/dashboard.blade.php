@extends('layout')
  
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
  
                <div class="card-body">
                    
                    
                    <div class="form-group row">
                              <label for="email_address" class="col-md-4 col-form-label text-md-right">{{__('message.Full Name')}} :</label>
                              <div class="col-md-6">
                                  {{ session('name') }}                                 
                              </div>
                          </div>
  
                          <div class="form-group row">
                              <label for="password" class="col-md-4 col-form-label text-md-right">{{__('message.Email Address')}}:</label>
                              <div class="col-md-6">
                                  {{ session('email') }}                                 
                              </div>
                          </div> 
                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                            {{ session('success') }}                           
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection