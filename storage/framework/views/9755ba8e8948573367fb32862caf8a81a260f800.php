<?php
$title = "FAQs";
$subtitle = "View all Frequently Asked Questions";
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
<?php echo $__env->make('page-header',['title' => $title,'subtitle' => $subtitle], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">FAQs</h5>
			    <a href="<?php echo e(url('add-faq')); ?>" class="btn btn-outline-secondary">Add FAQ</a>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first etuk-table">
                                        <thead>
                                            <tr>
                                                <th>Tag</th>
                                                <th>Question</th>
                                                <th>Answer</th>
                                                <th>Date Added</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										  <?php
										   if(count($faqs) > 0)
										   {
											  foreach($faqs as $f)
											   {
												   
											   $uu = "javascript:void(0)";
											   $du = url('remove-faq')."?xf=".$f['id'];
									        ?>
                                            <tr>
                                               <td><?php echo e($f['tag']); ?></td>
												<td><?php echo e($f['question']); ?></td>
                                                <td><em><?php echo e($f['answer']); ?></em></td>
                                                <td><?php echo e($f['date']); ?></td>
                                                <td>
												 <a class="btn btn-outline-primary" href="<?php echo e($uu); ?>">Edit</a>
												 <a class="btn btn-outline-danger" href="<?php echo e($du); ?>">Remove</a>
												 </td>
                                            </tr>
									     <?php
											   }
										   }
										 ?>
									   </tbody>
									</table>
							    </div>
							 </div>
						</div>
                    </div>
                </div>			
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\etuk-admin\resources\views/faqs.blade.php ENDPATH**/ ?>