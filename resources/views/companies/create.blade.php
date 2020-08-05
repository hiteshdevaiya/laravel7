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
                            <h5 class="page-title">{{$Companies->id ? 'Edit' : 'Add new' }}</h5>
                            
                            <div class="float-right">
                                <a href="{{route('companies.index')}}"><button class="btn btn-primary pull-right box-title" type="submit">Back</button></a>
                                    
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
                                            <form method="post" action="{{route('companies.save')}}" enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <input class="form-control" type = "hidden" name="id" value="{{$Companies->id ? $Companies->id : 0 }}">
                                                
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label"> Name<span style="color: red">*</span></label>
                                                    <div class="col-sm-10">
                                                        <input type="text"  class="form-control" name="name" value="{{$Companies->name ? $Companies->name : '' }}" id="" title="enter category name" required="" >
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label"> Email</label>
                                                    <div class="col-sm-10">
                                                        <input type="email"  class="form-control" name="email" value="{{$Companies->email ? $Companies->email : '' }}" id="" title="enter email "  >
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="logo" class="col-sm-2 col-form-label">Image</label>
                                                    <div class="col-sm-10">
                                                        <input type="file" name="logo" class="form-control" >
                            
                                                        <?php 
                                                            if($Companies->id)
                                                            {
                                
                                                                $image = $Companies->logo ? URL::To('public/companies_image/'.$Companies->logo) : 
                                                                         URL::To('public/default.jpg');
                                                                echo "<img src=".$image." alt='' width='100px'>";
                                                            }
                                                        ?>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Web site</label>
                                                    <div class="col-sm-10">
                                                        <input type="text"  class="form-control" name="website" value="{{$Companies->website ? $Companies->website : '' }}" id="" title="enter website"  >
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
<script src="{!! asset('plugins/jQuery/jQuery-2.2.0.min.js') !!}"></script>
<script src="{!! asset('dist/js/pages/dashboard2.js') !!}"></script>
@endsection 