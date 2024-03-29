  <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
      <div class="nav-left-sidebar sidebar-dark" style="overflow-y: scroll;">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="javascript:void(0)">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                General
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="<?php echo e(url('/')); ?>"><i class="fa fa-fw fa-user-circle"></i>Dashboard <span class="badge badge-success">6</span></a>
                            </li>
							<li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1" aria-controls="submenu-1"><i class="fa fa-fw fa-users"></i>Users</a>
                                <div id="submenu-1" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo e(url('users')); ?>">View users</a>                             
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2" aria-controls="submenu-2"><i class="fa fa-fw fa-shopping-bag"></i>Catalog</a>
                                <div id="submenu-2" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo e(url('categories')); ?>">Categories</a>
                                            <a class="nav-link" href="<?php echo e(url('products')); ?>">Products</a>
                                            <a class="nav-link" href="<?php echo e(url('manufacturers')); ?>">Manufacturers</a>
                                            <a class="nav-link" href="<?php echo e(url('information')); ?>">Information</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
							<li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" data-toggle="collapse" aria-expanded="false" data-target="#submenu-21" aria-controls="submenu-2"><i class="fa fa-fw fa-tags"></i>Discounts</a>
                                <div id="submenu-21" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo e(url('discounts')); ?>">View discounts</a>
                                            <a class="nav-link" href="<?php echo e(url('new-discount')); ?>">Add new discount</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
							<li class="nav-item">
                                 <a class="nav-link" href="<?php echo e(url('orders')); ?>"><i class="fa fa-fw fa-shopping-bag"></i>Orders</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="javascript:void(0)" data-toggle="collapse" aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="fas fa-fw fa-bed"></i>Reviews</a>
                                <div id="submenu-4" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo e(url('reviews')); ?>">View reviews</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                          
                            <li class="nav-divider">
                                Site Maintenance
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" data-toggle="collapse" aria-expanded="false" data-target="#submenu-9" aria-controls="submenu-6"><i class="fas fa-fw fa-question-circle"></i>FAQs</a>
                                <div id="submenu-9" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo e(url('faqs')); ?>">View FAQs</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo e(url('faq-tags')); ?>">View FAQ tags</a>
                                        </li> 
                                    </ul>
                                </div>
                            </li>
							<li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" data-toggle="collapse" aria-expanded="false" data-target="#submenu-6" aria-controls="submenu-6"><i class="fas fa-fw fa-image"></i>Banners</a>
                                <div id="submenu-6" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo e(url('banners')); ?>">Landing page banners</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
			    <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" data-toggle="collapse" aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-fw fa-plug"></i>Plugins</a>
                                <div id="submenu-7" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo e(url('plugins')); ?>">View plugins</a>
                                        </li>     
                                    </ul>
                                </div>
                            </li>
			                
                            
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
<?php /**PATH C:\bkupp\lokl\repo\chstore-admin\resources\views/sidebar.blade.php ENDPATH**/ ?>