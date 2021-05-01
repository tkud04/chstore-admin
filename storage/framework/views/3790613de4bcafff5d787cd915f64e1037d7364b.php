<?php
$title = "Add Banner";
$subtitle = "Upload a new banner for the landing page.";
?>



<?php $__env->startSection('title',$title); ?>


<?php $__env->startSection('page-header'); ?>
<?php echo $__env->make('page-header',['title' => "Banners",'subtitle' => $title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Add Banner</h5>
                                <div class="card-body">
                                    <form action="<?php echo e(url('add-banner')); ?>" id="ab-form" method="post" enctype="multipart/form-data">
										<?php echo csrf_field(); ?>

										
										<div class="row">
										<div class="col-md-12">
										<div class="form-group">
                                            <label>Subtitle 1</label>
                                            <input id="ab-subtitle-1" type="text" placeholder="Subtitle 1" name="subtitle_1" class="form-control">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label>Subtitle 2</label>
                                            <input id="ab-subtitle-2" type="text" placeholder="Subtitle 2" name="subtitle_2" class="form-control">
                                        </div>
										</div><div class="col-md-12">
										<div class="form-group">
                                            <label>Title 1</label>
                                            <input id="ab-title-1" type="text" placeholder="Title 1" name="title_1" class="form-control">
                                        </div>
										</div><div class="col-md-12">
										<div class="form-group">
                                            <label>Title 2</label>
                                            <input id="ab-title-2" type="text" placeholder="Title 2" name="title_2" class="form-control">
                                        </div>
										</div><div class="col-md-12">
										<div class="form-group">
                                            <label>Caption</label>
                                            <input id="ab-caption" type="text" placeholder="Caption" name="caption" class="form-control">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label>Button text</label>
                                            <input id="ab-button-text" type="text" placeholder="Button text" name="button_text" class="form-control">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label>Button UR</label>
                                            <input id="ab-button-url" type="text" placeholder="Button text" name="url" class="form-control">
                                        </div>
										</div>
										
										<div class="col-md-12">
										<div class="form-group">
                                            <h4>Status</h4>
                                            <select class="form-control" name="status" id="ap-status" style="margin-bottom: 5px;">
							                  <option value="none">Select status</option>
								           <?php
								            $secs = ['enabled' => "Enabled",'disabled' => "Disabled"];
								            foreach($secs as $key => $value){
									      	 
								           ?>
								              <option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
								           <?php
								           }
								           ?>
							                </select>
                                        </div>
										</div>
										</div>
										
										
                                        <div class="row">
                                            <div class="col-sm-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="apl-form-btn">Save</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\chstore-admin\resources\views/add-banner.blade.php ENDPATH**/ ?>