<?php
$title = "Add Product";
$subtitle = "Add a product to the catalog.";
?>

@extends('layout')

@section('title',$title)


@section('page-header')
@include('page-header',['title' => $title,'subtitle' => $subtitle])
@stop


@section('content')
<script>
$(document).ready(() => {
	tkAddApartment = "{{csrf_token()}}";
	
	let addProductDescriptionEditor = new Simditor({
		textarea: $('#add-product-description'),
		toolbar: toolbar,
		placeholder: `Enter your description here. Maximum of 2000 words..`
	});	
});
</script>
<div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="tab-vertical">
                                <ul class="nav nav-tabs" id="myTab3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active show" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">General</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="data-tab" data-toggle="tab" href="#data" role="tab" aria-controls="data" aria-selected="false">Data</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="links-tab" data-toggle="tab" href="#links" role="tab" aria-controls="links" aria-selected="false">Links</a>
                                    </li>
									<li class="nav-item">
                                        <a class="nav-link" id="images-tab" data-toggle="tab" href="#images" role="tab" aria-controls="links" aria-selected="false">Images</a>
                                    </li>
									<li class="nav-item">
                                        <a class="nav-link" id="seo-tab" data-toggle="tab" href="#seo" role="tab" aria-controls="links" aria-selected="false">SEO</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent3">
                                    <div class="tab-pane fade" id="general" role="tabpanel" aria-labelledby="general-tab">
                                      <h5 class="card-header">General</h5>
                                       <div class="card-body">
									   
									    <div class="row">
										  <div class="col-md-12">
										    <div class="form-group">
                                              <label>Product name <span class="req">*</span></label>
                                              <input id="add-product-name" type="text" placeholder="Enter a title for your tip" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                               <label for="aat-message">Description</label>
                                               <textarea class="form-control" placeholder="Your message" id="add-product-description"></textarea>
                                            </div>
											<div class="form-group mt-2">
                                              <label>Meta tag title <span class="req">*</span></label>
                                              <input id="add-product-meta-title" type="text" placeholder="Meta tag title" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                               <label>Meta tag Description</label>
                                               <textarea id="add-product-meta-description" class="form-control" placeholder="Meta tag description" rows="8"></textarea>
                                            </div>
											<div class="form-group mt-2">
                                              <label>Meta tag keywords</label>
                                              <input id="add-product-meta-keywords" type="text" placeholder="Meta tag keywords" class="form-control">
                                            </div>
										  </div>
										</div>
                                        <div class="row">
                                            <div class="col-sm-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="aat-form-btn">Submit</button>
                                                </p>
                                            </div>
                                        </div>
                                       </div>
                                    </div>
									<div class="tab-pane fade" id="data" role="tabpanel" aria-labelledby="data-tab">
                                       <h5 class="card-header">Data</h5>
                                       <div class="card-body">
									   
									    <div class="row">
										  <div class="col-md-12">
										    <div class="form-group">
                                              <label>Model <span class="req">*</span></label>
                                              <input id="add-product-model" type="text" placeholder="Model" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                               <label>
											   SKU <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Store Keeping Unit"><i class="fas fa-question-circle"></i> </a>
											   </label>
                                               <input id="add-product-sku" type="text" placeholder="SKU" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                              <label>
											   UPC <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Universal Product Code"><i class="fas fa-question-circle"></i> </a>
											   </label>
                                               <input id="add-product-upc" type="text" placeholder="UPC" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>
											   EAN <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="" data-original-title="European Article Number"><i class="fas fa-question-circle"></i> </a>
											   </label>
                                               <input id="add-product-ean" type="text" placeholder="EAN" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                               <label>
											   JAN <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Japanese Article Number"><i class="fas fa-question-circle"></i> </a>
											   </label>
                                               <input id="add-product-jan" type="text" placeholder="JAN" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                               <label>
											   ISBN <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="" data-original-title="International Standard Book Number"><i class="fas fa-question-circle"></i> </a>
											   </label>
                                               <input id="add-product-isbn" type="text" placeholder="ISBN" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                               <label>
											   MPN <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Manufacturer Part Number"><i class="fas fa-question-circle"></i> </a>
											   </label>
                                               <input id="add-product-mpn" type="text" placeholder="MPN" class="form-control">
                                            </div>
										  </div>
										</div>
                                        <div class="row">
                                            <div class="col-sm-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="aat-form-btn">Submit</button>
                                                </p>
                                            </div>
                                        </div>
                                       </div>
                                    </div>
                                    <div class="tab-pane fade active show" id="contact-vertical" role="tabpanel" aria-labelledby="contact-vertical-tab">
                                        <h3>Tab Heading Vertical Title</h3>
                                        <p>Vivamus pellentesque vestibulum lectus vitae auctor. Maecenas eu sodales arcu. Fusce lobortis, libero ac cursus feugiat, nibh ex ultricies tortor, id dictum massa nisl ac nisi. Fusce a eros pellentesque, ultricies urna nec, consectetur dolor. Nam dapibus scelerisque risus, a commodo mi tempus eu.</p>
                                        <p> Fusce a eros pellentesque, ultricies urna nec, consectetur dolor. Nam dapibus scelerisque risus, a commodo mi tempus eu.</p>
                                    </div>
                                </div>
                                    
                                </div>
                            </div>
      </div>
</div>
@stop