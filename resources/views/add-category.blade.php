<?php
$title = "Add Category";
$subtitle = "Add a new category.";
?>

@extends('layout')

@section('title',$title)

@section('scripts')
  <!-- DataTables CSS -->
  <link href="{{asset('lib/datatables/css/buttons.bootstrap.min.css')}}" rel="stylesheet" /> 
  <link href="{{asset('lib/datatables/css/buttons.dataTables.min.css')}}" rel="stylesheet" /> 
  <link href="{{asset('lib/datatables/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" /> 
  
      <!-- DataTables js -->
       <script src="{{asset('lib/datatables/js/datatables.min.js')}}"></script>
    <script src="{{asset('lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('lib/datatables/js/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js')}}"></script>
    <script src="{{asset('lib/datatables/js/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js')}}"></script>
    <script src="{{asset('lib/datatables/js/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js')}}"></script>
    <script src="{{asset('lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('lib/datatables/js/datatables-init.js')}}"></script>
@stop

@section('page-header')
@include('page-header',['title' => "Categories",'subtitle' => $title])
@stop

@section('content')
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Add Category</h5>
                                <div class="card-body">
                                    <form action="{{url('add-category')}}" id="add-category-form" method="post">
										{!! csrf_field() !!}
										<div class="row">
										<div class="col-md-12">
										<div class="form-group">
                                            <label>Name <span class="text-danger text-bold">*</span></label>
                                            <input id="add-category-name" type="text" name="name" placeholder="Category name e.g Tablets" class="form-control">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label>Tag</label>
                                            <input id="add-category-tag" type="text" name="category" value="" placeholder="Tag e.g tablets" class="form-control">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label>Parent</label>
                                           <select id="add-category-parent" name="parent" class="form-control">
											     <option value="0">None</option>
												 <?php
												  foreach($categories as $c)
												  {
												 ?>
											     <option value="{{$c['id']}}">{{ucwords($c['name'])}}</option>
											     <?php
												  }
												 ?>
											  </select>
                                        </div>
										</div>
										</div>
										
                                        <div class="row">
                                            <div class="col-sm-6 pb-2 pb-sm-4 pb-lg-0 pr-0">
                                                <label class="be-checkbox custom-control custom-checkbox">
                                                   <span class="custom-control-label">Categories help you group similar products in one logical section.</span>
                                                </label>
                                            </div>
                                            <div class="col-sm-6 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="add-category-submit">Submit</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>		
</div>		
@stop