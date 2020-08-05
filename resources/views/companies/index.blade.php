@extends('layouts.app')
@section('content')
    
<div class="pcoded-content container">
    <div class="pcoded-inner-content">

        <div class="main-body">
            <div class="page-wrapper">

                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="{{ url('/admin/dashboard') }}"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    
                                    <!--<li class="breadcrumb-item"><a href="#!">Sub Admin</a>
                                    </li>-->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="page-title">Companies List</h5>
                            <div class="float-right">
                                        <a href="{{ route('companies.form',['id'=>0])}}" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i>Add New </a>
                                        
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
                            
                            <div class="table-responsive dt-responsive">
                                <table id="example" class="table table-striped table-bordered nowrap" style="width:100%" role="grid" aria-describedby="tabarticleid_info" style="width: 100%px;">
                                    <thead>
                                        <tr role="row">
                                            
                                            
                                            <th class="sorting" tabindex="0" aria-controls="tabarticleid" rowspan="1" colspan="1" style="width: 100px;" aria-label="Id:activate to sort column ascending">ID</th>
                                            <th class="sorting" tabindex="0" aria-controls="tabarticleid" rowspan="1" colspan="1" style="width: 220px;" aria-label="company_name:activate to sort column ascending">Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="tabarticleid" rowspan="1" colspan="1" style="width: 220px;" aria-label="company_name:activate to sort column ascending">Email</th>

                                            <th class="sorting" tabindex="0" aria-controls="tabarticleid" rowspan="1" colspan="1" style="width: 220px;" aria-label="company_name:activate to sort column ascending">Image</th>
                                            
                                            <th  tabindex="0" aria-controls="tabarticleid" rowspan="1" colspan="1" style="width: 200px;" aria-label="Action:activate to sort column ascending">Action</th>
                                        
                                        </tr>
                                    </thead>                
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                
<script type="text/javascript">
        $(document).ready(function()
        {
            $('#example').DataTable({
                  
               "processing": true,
               "serverSide": true,
               "rowId": 'id',
               "ajax":{
                    "url": "{{ route('companies.list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"},
                },
       
                "columns": [
                    
                    { "data": "id"},
                    { "data": "name"},
                    { "data": "email"},
                    { "data": "logo"},
                    { "data": "action","orderable":false,"bSortable": true },                
                ]  
            });
        });

    </script>

@endsection
