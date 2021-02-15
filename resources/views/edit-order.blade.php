<?php
$title = "Order #".$o['reference'];
$subtitle = "Edit order.";
?>

@extends('layout')

@section('title',$title)


@section('page-header')
@include('page-header',['title' => $title,'subtitle' => $subtitle])
@stop


@section('content')

<?php
$pd = $o['pd'];
$sd = $o['sd'];
?>

<script>
let xf = "{{$o['id']}}", products = [], pCover = "none", tkOrder = "{{csrf_token()}}",
    orderProducts = [], eoPaymentXF = "{{$pd['id']}}", eoShippingXF = "{{$sd['id']}}";

  

$(document).ready(() => {
	hideElem(["#eo-loading"]);
	
	 @foreach($products as $p)
	  products.push({
		  id: "{{$p['id']}}", 
		  name: "{{$p['name']}}", 
		  model: "{{$p['model']}}", 
		  qty: "{{$p['qty']}}", 
		  amount: "{{$p['data']['amount']}}"
		  });
 @endforeach
 
 @foreach($o['items'] as $i)
	  orderProducts.push({p: {{$i['product_id']}}, q: {{$i['qty']}}});
	  @endforeach
	  
	  refreshProducts({type: "normal", target: "#order-products", t: 'order'});
		   refreshProducts({type: "review", target: "#order-products-review", t: 'order'});
});
</script>


<div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3">
	    <div class="text-left" >
		  <h4 id="eo-loading">Processing.. <img src="{{asset('images/loading.gif')}}" class="img img-fluid" alt="Processing.."></h4>
		</div>
		<div class="text-right" id="eo-submit">
	      <a href="javascript:void(0)" id="order-submit" class="btn btn-primary"><i class="fas fa-save"></i></a>
	      <a href="{{url('orders')}}" class="btn btn-danger"><i class="fas fa-reply"></i></a>
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
                                              <select id="order-customer" class="form-control">
											    <option value="none">Select customer</option>
												<?php											      
												  foreach($customers as $c)
												  {
													  $ss = $c['id'] == $o['user_id'] ? " selected='selected'" : "";
												 ?>
											     <option value="{{$c['id']}}"{{$ss}}>{{$c['fname']." ".$c['lname']}}</option>
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
                                              <tbody id="order-products">
										      
									    	  </tbody>
											 </table>
										     </div>
											 <div class="row mt-5">
											   <div class="col-md-6">
											     <div class="form-group">
                                                   <label>Product <span class="req">*</span></label>
                                                   <input id="order-product" type="text" placeholder="Select product" class="form-control" list="add-order-product-list">
												   <datalist id="order-product-list"> 
													<?php											      
												        foreach($products as $p)
												        {
												      ?>
											          <option value="{{$p['id']}}">{{ucwords($p['name'])}}</option>
												      <?php
												        }
												       ?>
											       </datalist>
                                                 </div>
											   </div>
											   <div class="col-md-6">
											     <div class="form-group">
                                                   <label>Quantity <span class="req">*</span></label>
                                                   <input id="order-qty" type="number" placeholder="Quantity" class="form-control">
                                                 </div>
											   </div>
											   <div class="col-sm-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="order-product-submit"><i class="fas fa-plus"></i> Add</button>
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
                                                <input id="order-payment-fname" type="text" value="{{$pd['fname']}}" placeholder="First name" class="form-control">
                                              </div>
                                            </div>
											<div class="col-md-6">
											  <div class="form-group mt-2">
                                                 <label>Last Name <span class="req">*</span></label>
                                                 <input id="order-payment-lname" type="text" value="{{$pd['lname']}}" placeholder="Last name" class="form-control">
                                              </div>
											</div>
										   </div>
											<div class="form-group mt-2">
                                              <label>Company </label>
                                               <input id="order-payment-company" type="text" value="{{$pd['company']}}" placeholder="Company" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>Address 1 <span class="req">*</span></label>
                                               <input id="order-payment-address-1" type="text" value="{{$pd['address_1']}}" placeholder="Address line 1" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>Address 2</label>
                                               <input id="order-payment-address-2" type="text" value="{{$pd['address_2']}}" placeholder="Address line 2" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>City <span class="req">*</span></label>
                                               <input id="order-payment-city" type="text" value="{{$pd['city']}}" placeholder="City" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>Region/State <span class="req">*</span></label>
                                               <input id="order-payment-region" type="text" value="{{$pd['region']}}" placeholder="Region or state" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>Postcode</label>
                                               <input id="order-payment-postcode" type="text" value="{{$pd['zip']}}" placeholder="Postcode" class="form-control">
                                            </div>
											
											<div class="form-group mt-2">
                                               <label>Country <span class="req">*</span></label>
                                               <select id="order-payment-country" class="form-control">
											    <option value="none">Select country</option>
											    <?php
											      foreach($countries as $k => $v)
												  {
													  $ss = $k == $pd['country'] ? " selected='selected'" : "";
												  ?>
											     <option value="{{$k}}"{{$ss}}>{{ucwords($v)}}</option>
												 <?php
												  }
												 ?>
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
										   <div class="row">
										    <div class="col-md-6">
										      <div class="form-group">
                                                <label>First Name <span class="req">*</span></label>
                                                <input id="order-shipping-fname" type="text" value="{{$sd['fname']}}" placeholder="First name" class="form-control">
                                              </div>
                                            </div>
											<div class="col-md-6">
											  <div class="form-group mt-2">
                                                 <label>Last Name <span class="req">*</span></label>
                                                 <input id="order-shipping-lname" type="text" value="{{$sd['lname']}}" placeholder="Last name" class="form-control">
                                              </div>
											</div>
										   </div>
											<div class="form-group mt-2">
                                              <label>Company </label>
                                               <input id="order-shipping-company" type="text" value="{{$sd['company']}}" placeholder="Company" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>Address 1 <span class="req">*</span></label>
                                               <input id="order-shipping-address-1" type="text" value="{{$sd['address_1']}}" placeholder="Address line 1" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>Address 2</label>
                                               <input id="order-shipping-address-2" type="text" value="{{$sd['address_2']}}" placeholder="Address line 2" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>City <span class="req">*</span></label>
                                               <input id="order-shipping-city" type="text" value="{{$sd['city']}}" placeholder="City" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>Region/State <span class="req">*</span></label>
                                               <input id="order-shipping-region" type="text" value="{{$sd['region']}}" placeholder="Region or state" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>Postcode</label>
                                               <input id="order-shipping-postcode" type="text" value="{{$sd['zip']}}" placeholder="Postcode" class="form-control">
                                            </div>
											
											<div class="form-group mt-2">
                                               <label>Country <span class="req">*</span></label>
                                               <select id="order-shipping-country" class="form-control">
											    <option value="none">Select country</option>
											    <?php
											      foreach($countries as $k => $v)
												  {
												  $ss = $k == $sd['country'] ? " selected='selected'" : "";
												  ?>
											     <option value="{{$k}}"{{$ss}}>{{ucwords($v)}}</option>
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
										   <div class="mt-5 mb-5">
                                             <table class="table table-striped table-bordered first etuk-table">
                                              <thead>
                                                <tr>
                                                  <th>Product</th>
                                                  <th>Model</th>
												  <th>Quantity</th>
                                                  <th>Unit price</th>
                                                  <th>Total</th>
                                                </tr>
                                              </thead>
                                              <tbody id="order-products-review">
										      
									    	  </tbody>
											 </table>
										     </div>
											 <div class="form-group mt-2">
                                               <label>Payment type <span class="req">*</span></label>
                                               <select id="order-payment-type" class="form-control">
											     <option value="none">Select payment type</option>
											     <option value="card" selected="selected">Credit/debit card</option>
											   </select>
                                            </div>
											<div class="form-group mt-2">
                                               <label>Shipping type <span class="req">*</span></label>
                                               <select id="order-shipping-type" class="form-control">
											     <option value="none">Select shipping type</option>
											     <option value="free" selected="selected">Free shipping</option>
											   </select>
                                            </div>
											<div class="form-group mt-2">
                                                <label>Comment</label>
                                               <textarea rows="8" id="order-comment" type="text" placeholder="Comment" class="form-control">{!! $o['comment'] !!}</textarea>
                                            </div>
											<div class="form-group mt-2">
                                               <label>Status <span class="req">*</span></label>
                                               <select id="order-status" class="form-control">											   
											     <option value="none">Select status</option>
											     <?php
												   $statuses = [
												     'cancelled' => "Cancelled",
												     'canceled-reversal' => "Cancelled Reversal",
												     'chargeback' => "Chargeback",
												     'completed' => "Completed",
												     'denied' => "Denied",
												     'expired' => "Expired",
												     'failed' => "Failed",
												     'pending' => "Pending",
												     'processed' => "Processed",
												     'processing' => "Processing",
												     'refunded' => "Refunded",
												     'reversed' => "Reversed",
												     'shipped' => "Shipped",
												     'voided' => "Voided",
												   ];
												   
												   foreach($statuses as $k => $v)
												   {
													 $ss = $k == $o['status'] ? " selected='selected'" : "";   
												 ?>
												  <option value="{{$k}}"{{$ss}}>{{$v}}</option>
												 <?php
												   }
												 ?>
											   </select>
                                            </div>
											
										  </div>
										</div>
                                       </div>
                                    </div>
                                </div>
                                    
                                </div>
                            </div>
      </div>
@stop
