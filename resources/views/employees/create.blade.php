@extends('layouts.app')
@section('content')

<div class="pcoded-content container">
    <div class="pcoded-inner-content">

        <div class="main-body">
            <div class="page-wrapper">

                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="page-title">{{$Employees->id ? 'Edit' : 'Add new' }}</h5>
                            
                            <div class="float-right">
                                <a href="{{route('employees.index')}}"><button class="btn btn-primary pull-right box-title" type="submit">Back</button></a>
                                    
                                @if(session()->has('message'))
                                    <div class="alert alert-success" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        {{ session()->get('message') }}
                                    </div>
                                @endif
                      
                                @if(session()->has('errorMessage'))
                                    <div class="alert alert-danger" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        {{ session()->get('errorMessage') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        
                        <div class="card-block">
                                  
                            <div class="container row p-5">
                                <div class="col-sm-12">
                                            <form method="post" action="{{route('employees.save')}}" enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                
                                                <input class="form-control" type = "hidden" name="id" value="{{$Employees->id ? $Employees->id : 0 }}">
                                                
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">First Name<span style="color: red">*</span></label>
                                                    <div class="col-sm-10">
                                                        <input type="text"  class="form-control" name="first_name" value="{{$Employees->first_name ? $Employees->first_name : '' }}" id="" title="enter first name" required="" >
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Last Name<span style="color: red">*</span></label>
                                                    <div class="col-sm-10">
                                                        <input type="text"  class="form-control" name="last_name" value="{{$Employees->last_name ? $Employees->last_name : '' }}" id="" title="enter last name" required="" >
                                                    </div>
                                                </div>
                                               
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Compnies<span style="color: red">*</span></label>
                                                    <div class="col-sm-10">
                                                        <select name="company_id" required="" class="form-control select2">
                                                            @forelse($compniesList as $compniesList)
                                                            <option value="{{ $compniesList->id }}" 
                                                                @if(isset($Employees->company_id) && $Employees->company_id == $compniesList->id)selected="selected" 
                                                                @endif
                                                                >
                                                                {{ $compniesList->name }}
                                                            </option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Email</label>
                                                    <div class="col-sm-10">
                                                        <input type="email"  class="form-control" name="email" value="{{$Employees->email ? $Employees->email : '' }}" id="" title="enter email" >
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Phone</label>
                                                    <div class="col-sm-10">
                                                        <input type="text"  class="form-control" name="phone" value="{{$Employees->phone ? $Employees->phone : '' }}" id="" title="enter mobile" required="" >
                                                    </div>
                                                </div>
                                                
                                               
                                                <div class="form-group row">
                                                    <label class="col-sm-2"></label>
                                                    <div class="col-sm-10">
                                                        <input type="submit" class="btn btn-primary m-b-0" name="submit" value="Save" />
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection 