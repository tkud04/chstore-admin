<?php
$title = "Add Order";
$subtitle = "Add an order.";
?>



<?php $__env->startSection('title',$title); ?>


<?php $__env->startSection('page-header'); ?>
<?php echo $__env->make('page-header',['title' => $title,'subtitle' => $subtitle], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<script>
let products = [], pCover = "none", tkAddOrder = "<?php echo e(csrf_token()); ?>"; orderProducts = [];

$(document).ready(() => {
	hideElem(["#ao-loading"]);
	
	 <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	  products.push({
		  id: "<?php echo e($p['id']); ?>", 
		  name: "<?php echo e($p['name']); ?>", 
		  model: "<?php echo e($p['model']); ?>", 
		  qty: "<?php echo e($p['qty']); ?>", 
		  amount: "<?php echo e($p['data']['amount']); ?>"
		  });
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
});
</script>
<div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3">
	    <div class="text-left" >
		  <h4 id="ao-loading">Processing.. <img src="<?php echo e(asset('images/loading.gif')); ?>" class="img img-fluid" alt="Processing.."></h4>
		</div>
		<div class="text-right" id="ao-submit">
	      <a href="javascript:void(0)" id="add-order-submit" class="btn btn-primary"><i class="fas fa-save"></i></a>
	      <a href="<?php echo e(url('orders')); ?>" class="btn btn-danger"><i class="fas fa-reply"></i></a>
	    </div>
	    
	  </div>
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="tab-vertical">
                                <ul class="nav nav-tabs" id="myTab3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active show" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">General</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="payment-tab" data-toggle="tab" href="#payment" role="tab" aria-controls="payment" aria-selected="false">Payment Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="shipping-tab" data-toggle="tab" href="#shipping" role="tab" aria-controls="shipping" aria-selected="false">Shipping</a>
                                    </li>
									<li class="nav-item">
                                        <a class="nav-link" id="totals-tab" data-toggle="tab" href="#totals" role="tab" aria-controls="totals" aria-selected="false">Totals</a>
                                    </li>
									
                                </ul>
                                <div class="tab-content" id="myTabContent3">
                                    <div class="tab-pane active show" id="general" role="tabpanel" aria-labelledby="general-tab">
                                      <h5 class="card-header">General</h5>
                                       <div class="card-body">
									   
									    <div class="row">
										  <div class="col-md-12">
										    <div class="form-group">
                                              <label>Customer <span class="req">*</span></label>
                                              <select id="add-order-customer" class="form-control">
											    <option value="none">Select customer</option>
												<?php											      
												  foreach($customers as $c)
												  {
												 ?>
											     <option value="<?php echo e($c['id']); ?>"><?php echo e($c['fname']." ".$c['lname']); ?></option>
												 <?php
												  }
												 ?>
											   </select>
                                            </div>
											<div class="mt-5">
                                             <table class="table table-striped table-bordered first etuk-table">
                                              <thead>
                                                <tr>
                                                  <th>Product</th>
                                                  <th>Model</th>
												  <th>Quantity</th>
                                                  <th>Unit price</th>
                                                  <th>Total</th>
                                                  <th>Action</th>
                                                </tr>
                                              </thead>
                                              <tbody id="add-order-products">
										      
									    	  </tbody>
											 </table>
										     </div>
											 <div class="row mt-5">
											   <div class="col-md-6">
											     <div class="form-group">
                                                   <label>Product <span class="req">*</span></label>
                                                   <select id="add-order-product" class="form-control">
											         <option value="none">Select product</option>
												      <?php											      
												        foreach($products as $p)
												        {
												      ?>
											          <option value="<?php echo e($p['id']); ?>"><?php echo e(ucwords($p['name'])); ?></option>
												      <?php
												        }
												       ?>
											       </select>
                                                 </div>
											   </div>
											   <div class="col-md-6">
											     <div class="form-group">
                                                   <label>Quantity <span class="req">*</span></label>
                                                   <input id="add-order-qty" type="number" placeholder="Quantity" class="form-control">
                                                 </div>
											   </div>
											   <div class="col-sm-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="add-order-product-submit"><i class="fas fa-plus"></i> Add</button>
                                                </p>
                                               </div>
											 </div>
										   </div>
										  </div>
                                       </div>
                                    </div>
									<div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                                       <h5 class="card-header">Payment Details</h5>
                                       <div class="card-body">
									   
									    <div class="row">
										  <div class="col-md-12">
										   <div class="row">
										    <div class="col-md-6">
										      <div class="form-group">
                                                <label>First Name <span class="req">*</span></label>
                                                <input id="add-order-fname" type="text" placeholder="First name" class="form-control">
                                              </div>
                                            </div>
											<div class="col-md-6">
											  <div class="form-group mt-2">
                                                 <label>Last Name <span class="req">*</span></label>
                                                 <input id="add-order-lname" type="text" placeholder="Last name" class="form-control">
                                              </div>
											</div>
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
											<div class="form-group mt-2">
                                               <label>Location</label>
                                               <input id="add-product-location" type="text" placeholder="Location" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                               <label> Price</label>
                                               <input id="add-product-price" type="text" placeholder="Price" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                               <label>Tax class</label>
                                               <select id="add-product-tax-class" class="form-control">
											    <?php
											     $tcs = ['none' => "Select tax class",'taxable-goods' => "Taxable goods", 'downloadable-products' => "Downloadable products"];
												  
												  foreach($tcs as $k => $v)
												  {
												  ?>
											     <option value="<?php echo e($k); ?>"><?php echo e($v); ?></option>
												 <?php
												  }
												 ?>
											   </select>
                                            </div>
											<div class="form-group mt-2">
                                               <label>Quantity </label>
                                               <input id="add-product-qty" type="number" placeholder="Quantity" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                               <label>
											   Minimum quantity <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Force a minimum ordered amount"><i class="fas fa-question-circle"></i> </a>
											   </label>
                                               <input id="add-product-min-qty" type="text" placeholder="MPN" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                               <label>Requires shipping</label>
                                               <select id="add-product-shipping" class="form-control">
											     <option value="none">Requires shipping?</option>
											     <option value="yes">Yes</option>
											     <option value="no">No</option>
											   </select>
                                            </div>
											<div class="form-group mt-2">
                                               <label>Date available</label>
                                               <input id="add-product-date-available" type="date" placeholder="Date available" class="form-control">
                                            </div>
											<div class="row">
											  <div class="col-md-12">
											    <h5>Dimensions</h5>
											  </div>
											  <div class="col-md-4">
											    <div class="form-group mt-2">
                                                  <label>Length</label>
                                                  <input id="add-product-length" type="text" placeholder="0.0000000" class="form-control">
                                               </div>
                                              </div>
											  <div class="col-md-4">
											    <div class="form-group mt-2">
                                                  <label>Width</label>
                                                  <input id="add-product-width" type="text" placeholder="0.0000000" class="form-control">
                                               </div>
                                              </div>
											  <div class="col-md-4">
											    <div class="form-group mt-2">
                                                  <label>Height</label>
                                                  <input id="add-product-height" type="text" placeholder="0.0000000" class="form-control">
                                               </div>
                                              </div>
                                           </div>
										   <div class="form-group mt-2">
                                               <label>Status</label>
                                               <select id="add-product-status" class="form-control">
											     <option value="none">Select status</option>
											     <option value="enabled" selected="selected">Enabled</option>
											     <option value="disabled">Disabled</option>
											   </select>
                                            </div>
										  </div>
										</div>
                                        
                                       </div>
                                    </div>
                                    <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                                        <h5 class="card-header">Shipping Details</h5>
                                       <div class="card-body">
									   
									    <div class="row">
										  <div class="col-md-12">
										    <div class="form-group">
											<?php
											$manufacturers = [];
											?>
                                              <label>Manufacturer <span class="req">*</span></label>
                                              <select id="add-product-manufacturer" class="form-control">
											     <option value="none">Select manufacturer</option>
												 <?php
												  foreach($manufacturers as $m)
												  {
												 ?>
											     <option value="<?php echo e($m['id']); ?>"><?php echo e(ucwords($m['name'])); ?></option>
											     <?php
												  }
												 ?>
											  </select>
                                            </div>
											<div class="form-group mt-2">
                                              <label>Category <span class="req">*</span></label>
                                              <select id="add-product-category" class="form-control">
											     <option value="none">Select category</option>
												 <?php
												 $categories = [];
												  foreach($categories as $c)
												  {
												 ?>
											     <option value="<?php echo e($c['id']); ?>"><?php echo e(ucwords($c['name'])); ?></option>
											     <?php
												  }
												 ?>
											  </select>
                                            </div>
										  </div>
										</div>
                                       </div>
                                    </div>
									<div class="tab-pane fade" id="totals" role="tabpanel" aria-labelledby="totals-tab">
                                        <h5 class="card-header">Totals</h5>
                                       <div class="card-body">
									   
									    <div class="row">
										  <div class="col-md-12">
										    <div class="form-group">
												<label>Images<i class="req">*</i></label>
												<div id="add-product-images">
												<div id="add-product-image-div-0" class="row">
												  <div class="col-md-7">
												    <input type="file" class="form-control" onchange="readURL2(this,{id: 'add-product',ctr: '0'})" id="add-product-image-0" name="add-product-images[]">												    
												  </div>
												  <div class="col-md-5">
												    <img id="add-product-preview-0" src="#" alt="preview" style="width: 50px; height: 50px;"/>
													<a href="javascript:void(0)" onclick="aptSetCoverImage(0)" class="btn btn-primary btn-sm">Set as cover image</a>
												    <a href="javascript:void(0)" onclick="aptRemoveImage({id: 'add-product',ctr: '0'})" class="btn btn-warning btn-sm">Remove</a>
												  </div>
												</div>
												</div>
											</div>
											<div class="form-group">
											    <a href="javascript:void(0)" onclick="aptAddImage({id: 'add-product'})" class="btn btn-warning btn-sm">Add image</a>
											    <ol class="form-control-plaintext">
												  <li>Recommended dimensions: Your images should not exceed <b>1280x880</b></li>
												  <li>Maximum file size: Your images must not be more than <b>1.5MB</b></li>
												</ol>
											</div>
										  </div>
										</div>
                                       </div>
                                    </div>
									<div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                                      <h5 class="card-header">SEO</h5>
                                       <div class="card-body">
									   
									    <div class="row">
										  <div class="col-md-12">
										    <div class="form-group">
                                              <label>
											   Keywords <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Do not use spaces, instead replace spaces with - and make sure the SEO URL is globally unique."><i class="fas fa-question-circle"></i> </a>
											   </label>
                                              <input id="add-product-seo-keywords" type="text" placeholder="Keywords" class="form-control">
                                            </div>
											
										  </div>
										</div>
                                       </div>
                                    </div>
                                </div>
                                    
                                </div>
                            </div>
      </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\chstore-admin\resources\views/add-order.blade.php ENDPATH**/ ?>