<?php
$title = $c['name'];
$subtitle = "Edit category.";
?>



<?php $__env->startSection('title',$title); ?>

<?php $__env->startSection('scripts'); ?>
  <!-- DataTables CSS -->
  <link href="<?php echo e(asset('lib/datatables/css/buttons.bootstrap.min.css')); ?>" rel="stylesheet" /> 
  <link href="<?php echo e(asset('lib/datatables/css/buttons.dataTables.min.css')); ?>" rel="stylesheet" /> 
  <link href="<?php echo e(asset('lib/datatables/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" /> 
  
      <!-- DataTables js -->
       <script src="<?php echo e(asset('lib/datatables/js/datatables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/datatables/js/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/datatables/js/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/datatables/js/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/datatables/js/datatables-init.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
<?php echo $__env->make('page-header',['title' => "Categories",'subtitle' => $title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Edit Category</h5>
                                <div class="card-body">
                                    <form action="<?php echo e(url('category')); ?>" id="update-category-form" method="post">
										<?php echo csrf_field(); ?>

										<input type="hidden" name="xf" value="<?php echo e($c['id']); ?>">
										<div class="row">
										<div class="col-md-6">
										<div class="form-group">
                                            <label>Name <span class="text-danger text-bold">*</span></label>
                                            <input id="add-category-name" type="text" name="name" placeholder="Category name e.g Tablets" class="form-control" value="<?php echo e($c['name']); ?>">
                                        </div>
										</div>
										<div class="col-md-6">
										<div class="form-group">
                                            <label>Tag <span class="text-danger text-bold">*</span></label>
                                            <input id="add-category-tag" type="text" name="category" placeholder="Tag e.g tablets" class="form-control" value="<?php echo e($c['category']); ?>">
                                        </div>
										</div>
										</div>
										
										<div class="row">
										  <div class="col-md-12">
										    <div class="form-group">
                                              <label>Status <span class="text-danger text-bold">*</span></label>
                                              <select id="add-category-status" name="status" class="form-control">
											   <option value="none">Select status</option>
											    <?php
												  $ss = [
												   'enabled' => "Enabled",
												   'disabled' => "Disabled"
												  ];
												  
												  foreach($ss as $k => $v)
												  {
													  $ss = $k == $c['status'] ? " selected='selected'" : "";
												?>
												<option value="<?php echo e($k); ?>"<?php echo e($ss); ?>><?php echo e($v); ?></option>
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
                                                    <button class="btn btn-space btn-secondary" id="update-category-submit">Submit</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>		
</div>		
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\chstore-admin\resources\views/category.blade.php ENDPATH**/ ?>