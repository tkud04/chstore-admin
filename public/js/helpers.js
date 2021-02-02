let BUPlist = [], BUUPlist = [];

const showElem = (name) => {
	let names = [];
	
	if(Array.isArray(name)){
	  names = name;
	}
	else{
		names.push(name);
	}
	
	for(let i = 0; i < names.length; i++){
		$(names[i]).fadeIn();
	}
}

const hideElem = (name) => {
	let names = [];
	
	if(Array.isArray(name)){
	  names = name;
	}
	else{
		names.push(name);
	}
	
	for(let i = 0; i < names.length; i++){
		$(names[i]).hide();
	}
}

const hideInputErrors = type => {
	let ret = [], types = [];
	
	if(Array.isArray(type)){
	  types = type;
	}
	else{
		types.push(type);
	}
	
	for(let i = 0; i < types.length; i++){
	  switch(types[i]){
		case "signup":
		  $('#signup-finish').html(`<b>Signup successful!</b><p class='text-primary'>Redirecting you to the home page.</p>`);
		  ret = ['#s-fname-error','#s-lname-error','#s-email-error','#s-phone-error','#s-pass-error','#s-pass2-error','#signup-finish'];	 
		break;
		
		case "login":
		  $('#login-finish').html(`<b>Signin successful!</b><p class='text-primary'>Redirecting you to your dashboard.</p>`);
	      ret = ['#l-id-error','#l-pass-error','#login-finish'];	 
		break;
		
		case "forgot-password":
		  $('#fp-finish').html(`<b>Request received!</b><p class='text-primary'>Please check your email for your password reset link.</p>`);
	      ret = ['#fp-id-error','#fp-finish'];	 
		break;
		
		case "reset-password":
		  $('#rp-finish').html(`<b>Password reset!</b><p class='text-primary'>You can now <a href="#" data-toggle="modal" data-target="#login">sign in</a>.</p>`);
	      ret = ['#rp-pass-error','#rp-pass2-error','#rp-finish'];	 
		break;
		
		case "oauth-sp":
		  ret = ['#osp-pass-error','#osp-pass2-error'];	 
		break;
	  }
	  hideElem(ret);
	}
}

const signup = dt => {

     let fd = new FormData();
		 fd.append("dt",JSON.stringify(dt));
		 fd.append("_token",$('#tk-signup').val());
		 
	//create request
	let url = "signup";
	const req = new Request(url,{method: 'POST', body: fd});
	
	//fetch request
	fetch(req)
	   .then(response => {
		   
		   if(response.status === 200){   
			   return response.json();
		   }
		   else{
			   return {status: "error", message: "Technical error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to sign you up: " + error);			
			hideElem('#signup-loading');
		     showElem('#signup-submit');
	   })
	   .then(res => {
		   console.log(res);
				 
		   if(res.status == "ok"){
              hideElem(['#signup-loading','#signup-submit']); 
              showElem('#signup-finish');
              window.location = "/"; 			   
		   }
		   else if(res.status == "error"){
		     alert("An unknown error has occured, please try again.");			
			hideElem('#signup-loading');
		     showElem('#signup-submit');					 
		   }
		   		   
		  
	   }).catch(error => {
		    alert("Failed to sign you up: " + error);	
            hideElem('#signup-loading');
		     showElem('#signup-submit');		
	   });
}

const fp = dt => {

     let fd = new FormData();
		 fd.append("dt",JSON.stringify(dt));
		 fd.append("_token",$('#tk-fp').val());
		 
	//create request
	let url = "forgot-password";
	const req = new Request(url,{method: 'POST', body: fd});
	
	//fetch request
	fetch(req)
	   .then(response => {
		   if(response.status === 200){
			   return response.json();
		   }
		   else{
			   return {status: "error", message: "Technical error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to send new password request: " + error);			
			hideElem('#fp-loading');
		     showElem('#fp-submit');
	   })
	   .then(res => {
		   console.log(res);
			 hideElem(['#fp-loading','#fp-submit']); 
             	 
		   if(res.status == "ok"){
               $('#fp-finish').html(`<b>Request received!</b><p class='text-primary'>Please check your email for your password reset link.</p>`);
				 showElem(['#fp-finish','#fp-submit']);			   
		   }
		   else if(res.status == "error"){
			   console.log(res.message);
			 if(res.message == "auth"){
				 $('#fp-finish').html(`<p class='text-primary'>No user exists with that email address.</p>`);
				 showElem(['#fp-finish','#fp-submit']);
			 }
			 else if(res.message == "validation" || res.message == "dt-validation"){
				 $('#fp-finish').html(`<p class='text-primary'>Please enter a valid email address.</p>`);
				 showElem(['#fp-finish','#fp-submit']);
			 }
			 else{
			   alert("An unknown error has occured, please try again.");			
			   hideElem('#fp-loading');
		       showElem('#fp-submit');	 
			 }					 
		   }
		   		   
		  
	   }).catch(error => {
		    alert("Failed to sign you in: " + error);	
            hideElem('#login-loading');
		     showElem('#login-submit');		
	   });
}

const rp = dt => {

     let fd = new FormData();
		 fd.append("dt",JSON.stringify(dt));
		 fd.append("_token",$('#tk-rp').val());
		 
	//create request
	let url = "reset";
	const req = new Request(url,{method: 'POST', body: fd});
	
	//fetch request
	fetch(req)
	   .then(response => {
		   if(response.status === 200){
			   return response.json();
		   }
		   else{
			   return {status: "error", message: "Technical error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to send new password request: " + error);			
			hideElem('#rp-loading');
		     showElem('#rp-submit');
	   })
	   .then(res => {
		   console.log(res);
			 hideElem(['#rp-loading','#rp-submit']); 
             	 
		   if(res.status == "ok"){
               $('#rp-finish').html(`<b>Password reset!</b><p class='text-primary'>You can now <a href="hello">sign in</a>.</p>`);
				 showElem(['#rp-finish','#rp-submit']);			   
		   }
		   else if(res.status == "error"){
			   console.log(res.message);
			 if(res.message == "auth"){
				 $('#rp-finish').html(`<p class='text-primary'>No user exists with that email address.</p>`);
				 showElem(['#rp-finish','#rp-submit']);
			 }
			 else if(res.message == "validation" || res.message == "dt-validation"){
				 $('#rp-finish').html(`<p class='text-primary'>Please enter a valid email address.</p>`);
				 showElem(['#rp-finish','#rp-submit']);
			 }
			 else{
			   alert("An unknown error has occured, please try again.");			
			   hideElem('#rp-loading');
		       showElem('#rp-submit');	 
			 }					 
		   }
		   		     
	   }).catch(error => {
		    alert("Failed to sign you in: " + error);	
            hideElem('#rp-loading');
		     showElem('#rp-submit');		
	   });
}


const switchMode = dt => {
    let url = `sm?m=${dt.mode}`;
	window.location = url;
}

const toggleFacility = dt => {
	 // console.log(`selecting facility ${dt}`);
	  f = $(`a#apt-service-${dt}`);
	  i = $(`i#apt-service-icon-${dt}`);
	  ft = f.attr('data-check');
	  ret = {id: dt, selected: false};
	  ih = "Check", rc = 'btn-warning', ac = 'btn-primary', iac = "ti-control-stop", idc = "ti-check-box",  dc = "unchecked";
	  
	  if(f){
		  if(ft == "unchecked"){
			ih = "Uncheck", rc = 'btn-primary', ac = 'btn-warning',iac = "ti-check-box", idc = "ti-control-stop", dc = "checked";
	        ret.selected = true;
		  } 
		   let ss = facilities.find(i => i.id == dt);
		  //console.log('us: ',us);
		  if(ss){
			ss.selected = ret.selected;  
		  }
		  else{
			facilities.push(ret);  
		  }
		  
		 // f.html(ih);
		  f.removeClass(rc);
		  f.addClass(ac);
		  i.removeClass(idc);
		  i.addClass(iac);
		  f.attr({'data-check':dc});
	  }
}


const aptAddImage = dt => {
	let i = $(`#${dt.id}-images`), ctr = $(`#${dt.id}-images div.row`).length;
	let sciText = `<a href='javascript:void(0)' onclick="aptSetCoverImage('${ctr}')" class='btn btn-primary btn-sm'>Set as cover image</a>`;
	
	i.append(`
			  <div id="${dt.id}-image-div-${ctr}" class="row">
				<div class="col-md-7">
					<input type="file" class="form-control" data-ic="${ctr}" onchange="readURL2(this,{id: '${dt.id}',ctr: '${ctr}'})" id="${dt.id}-image-${ctr}" name="${dt.id}-images[]">												    
				</div>
			    <div class="col-md-5">
					<img id="${dt.id}-preview-${ctr}" src="#" alt="preview" style="width: 50px; height: 50px;"/>
					${sciText}
					<a href="javascript:void(0)" onclick="aptRemoveImage({id: '${dt.id}', ctr: '${ctr}'})"class="btn btn-warning btn-sm">Remove</a>
				</div>
			  </div>
	  `);
}

const aptRemoveImage = dt => {
	let r = $(`#${dt.id}-image-div-${dt.ctr}`);
	//console.log(r);
	r.remove();
}

const aptSetCoverImage = ctr => {
	aptCover = ctr;
	//r.remove();
}

const readURL2 = (input,dt) => {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
		let pv = input.getAttribute("data-ic");
      $(`#${dt.id}-preview-${dt.ctr}`).attr({
	      'src': e.target.result,
	      'width': "50",
	      'height': "50"
	  });
    }
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

function readURL(input,ctr) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
		let pv = input.getAttribute("data-ic");
      $(`#add-product-${ctr}-preview-${pv}`).attr({
	      'src': e.target.result,
	      'width': "50",
	      'height': "50"
	  });
    }
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}


const updateApartmentPreference = (dt) => {
	//create request
	const req = new Request("apartment-preferences",{method: 'POST', body: dt});
	//console.log(req);
	
	
	//fetch request
	fetch(req)
	   .then(response => {
		   if(response.status === 200){
			   //console.log(response);
			   
			   return response.json();
		   }
		   else{
			   return {status: "error", message: "Technical error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to update apartment preferences: " + error);			
			$('#apartment-preference-loading').hide();
		     $('#apartment-preference-submit').fadeIn();
	   })
	   .then(res => {
		   console.log(res);
          
		   if(res.status == "ok"){
              Swal.fire({
			     icon: 'success',
                 title: "Apartment preferences updated!"
               }).then((result) => {
               if (result.value) {                 
			     window.location = `apartment-preferences`;
                }
              });
		   }
		   else if(res.status == "error"){
			   let hh = ``;
			   if(res.message == "validation"){
				 hh = `Please fill all required fields and try again.`;  
			   }
			   else if(res.message == "Technical error"){
				 hh = `A technical error has occured, please try again.`;  
			   }
			   Swal.fire({
			     icon: 'error',
                 title: hh
               });					 
		   }
		    $('#apartment-preference-loading').hide();
		     $('#apartment-preference-submit').fadeIn();
		   
		  
	   }).catch(error => {
		     alert("Failed to update apartment preferences: " + error);			
			$('#apartment-preference-loading').hide();
		     $('#apartment-preference-submit').fadeIn();			
	   });
}

const addApartment = (dt) => {
	//create request
	const req = new Request("post-apartment",{method: 'POST', body: dt});
	//console.log(req);
	
	
	//fetch request
	fetch(req)
	   .then(response => {
		   if(response.status === 200){
			   //console.log(response);
			   
			   return response.json();
		   }
		   else{
			   return {status: "error", message: "Technical error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to add apartment: " + error);			
			$('#pa-loading').hide();
		     $('#pa-submit').fadeIn();
	   })
	   .then(res => {
		   console.log(res);
          
		   if(res.status == "ok"){
              Swal.fire({
			     icon: 'success',
                 title: "Apartment added!"
               }).then((result) => {
               if (result.value) {                 
			     window.location = `apartments`;
                }
              });
		   }
		   else if(res.status == "error"){
			   let hh = ``;
			   if(res.message == "validation"){
				 hh = `Please fill all required fields and try again.`;  
			   }
			   else if(res.message == "network"){
				 hh = `A network error has occured, please check your connection and try again.`;  
			   }
			   else if(res.message == "Technical error"){
				 hh = `A technical error has occured, please try again.`;  
			   }
			   Swal.fire({
			     icon: 'error',
                 title: hh
               }).then((result) => {
               if (result.value) {
                  $('#pa-loading').hide();
		          $('#pa-submit').fadeIn();	
                }
              });					 
		   }
		  
		   
		  
	   }).catch(error => {
		     alert("Failed to add apartment: " + error);			
			$('#pa-loading').hide();
		     $('#pa-submit').fadeIn();			
	   });
}

const aptShowGrid = () => {
	viewType = "grid";
	perPage = 8;
	//$('apartments-list').hide();
	//$('apartments-grid').fadeIn();
	showPage(page,true);
}

const aptShowList = () => {
	viewType = "list";
	perPage = 5;
	//$('apartments-grid').hide();
	//$('apartments-list').fadeIn();
	showPage(page,true);
}

const showPage = (p,changeViewType=false) => {
	//console.log("arr length: ",productsLength);
	//console.log("show per page: ",perPage);
	$('#pagination-row').hide();
	$('#products').html("");
	let start = 0, end = 0;
	
	if(apartmentsLength < perPage){
		end = apartmentsLength;
	}
	else{
		start = (p * perPage) - perPage;
		end = p * perPage;
	}
	
	console.log(`start: ${start}, end: ${end},page: ${page}, p: ${p}, changeViewType: ${changeViewType}`);

	let hh = "", cids = [];
    
	
	if(page != p || changeViewType){
		$('#apartments').hide();
        $('#apartments').html(``);
		for(let i = start; i < end; i++){
		if(i < apartmentsLength)
		{
		let a = apartments[i];
	    //console.log(a);
	
		cids.push(a.apartment_id);
		let nnn = a.name;
		if(a.name.length > 12){
			nnn = `${a.name.substr(0,12)}..`;
		}
		
		let facilities = JSON.parse(a.facilities);
		let description = `${a.description}`;
		let starsText = "";

		for(let x = 0; x < a.stars; x++){
			starsText += "<i class='fa fa-star filled'></i>";
		}
		for(let y = 0; y < 5 - a.stars; y++){
			starsText += "<i class='fa fa-star'></i>";
		}
 	
	    if(viewType == "grid"){
			hh = `
				    <!-- Single Place -->
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="singlePlaceitem">
										<figure class="singlePlacewrap">
											<a class="place-link" href="${a.uu}">
												<img class="cover" src="${a.img}" alt="room">
											</a>
										</figure>
										<div class="placeDetail">
											<span class="onsale-section"><span class="onsale">45% Off</span></span>
											<div class="placeDetail-left">
												<div class="item-rating">
													${starsText}
													<span>${a.reviews} Reviews</span>
												</div>
												<h4 class="title"><a href="${a.uu}">${nnn}</a></h4>
												<span class="placeDetail-detail"><i class="ti-location-pin"></i>${a.location}</span>
											</div>
											<div class="pricedetail-box">
											<h6 class="price-title-cut">&#8358;0.00</h6>
											<h4 class="price-title">&#8358;${a.amount}</h4>
											</div>
										</div>
									</div>
								</div>
		   `;
		}
		else if(viewType == "list"){
			hh = `
			    <!-- Single List -->
								<div class="book_list_box popular_item">
									<div class="row no-gutters">
										
										<div class="col-lg-4 col-md-4">
											<figure>
												<a href="${a.uu}"><img src="${a.img}" class="img-responsive" alt=""></a>
											</figure>
										</div>
										
										<div class="col-lg-6 col-md-6 pl-5 side-br">
											<div class="book_list_header">
												<div class="view-ratting">
													${starsText}
												</div>
												<h4 class="book_list_title"><a href="${a.uu}">${a.name}</a></h4>
												<span class="location"><i class="ti-location-pin"></i>${a.location}</span>
											</div>
											<div class="book_list_description">
												<p>${a.description}</p>
											</div>
											<div class="book_list_rate">
												<h5 class="over_all_rate high"><span class="rating_status">${a.stars}</span>Very Good<small>(${a.reviews} Reviews)</small></h5>
											</div>
											<div class="book_list_offers">
												<ul>
													<li><i class="ti-location-pin"></i>Free WiFi</li>
													<li><i class="ti-car"></i>Parking</li>
													<li><i class="ti-cup"></i>Breakfast</li>
												</ul>
											</div>
										</div>
										
										<div class="col-lg-2 col-md-2 padd-l-0">
											<div class="book_list_foot">
												<span class="off-status theme-cl">${a.status}</span>
												<h4 class="book_list_price">&#8358;${a.amount}</h4>
												<span class="booking-time">per night</span>
												<a href="${a.uu}" class="book_list_btn btn-theme">View</a>
											</div>
										</div>
										
									</div>
								</div>
			`;
		}
		
		$('#apartments').append(hh);
	  }
	}
	
	page = p;
	$('#apartments').fadeIn();
	//fbq('track', 'ViewContent', {content_ids: cids, currency: "NGN", content_type: 'product'});
	
	}
	
	
}

const showPreviousPage = () => {
	let sp = apartmentsLength < perPage ? 1 : Math.ceil(apartmentsLength / perPage), pp = page - 1;
	//console.log(`page: ${page},sp: ${sp},pp: ${pp}`);
	if(pp < 1) pp = 1;
	if(sp > pp && pp > 0){
		showPage(pp);
	}
	
}

const showNextPage = () => {

		let sp = apartmentsLength < perPage ? 1 : Math.ceil(apartmentsLength / perPage), pp = page - 1;
		if(pp < 1) pp = 1;
	console.log(`page: ${page},sp: ${sp},pp: ${pp}`);
	
	if(sp >= pp){
		showPage(pp);
	}

}

const changePerPage = () =>{
	       perPage = $('#per-page').val();
		   if(perPage == "none") perPage = 3;

}

const isMobile = () =>{
	let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
	return isMobile;
}


function printElem(html)
{
    let mywindow = window.open('', 'PRINT');
    let content = `
<html><head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>${document.title}</title>
<!-- Google fonts -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
<!-- Ionicons font -->
<link href="css/ionicons.min.css" rel="stylesheet">
<!-- Bootstrap styles-->
<link href="css/bootstrap.min.css" rel="stylesheet">
<!--custom styles-->
<link href="css/custom.css" rel="stylesheet" />
<link href="css/custom-pink.css" rel="stylesheet"/>
<link href="css/custom-turquoise.css" rel="stylesheet" />
<link href="css/custom-purple.css" rel="stylesheet" />
<link href="css/custom-orange.css" rel="stylesheet" />
<link href="css/custom-blue.css" rel="stylesheet" />
<link href="css/custom-green.css" rel="stylesheet" />
<link href="css/custom-red.css" rel="stylesheet" />
<link href="css/custom-gold.css" rel="stylesheet" id="style">
<!--tooltiop-->
<link href="css/hint.css" rel="stylesheet">
<!-- animation -->
<link href="css/animate.css" rel="stylesheet" />
<!--select-->
<link href="css/bootstrap-select.min.css" rel="stylesheet">
<!--color picker-->
<link href="css/jquery.simplecolorpicker.css" rel="stylesheet">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
<!-- favicon -->

<link rel="icon" type="image/png" href="images/favicon.png" sizes="16x16">

<!--jQuery--> 
<script src="js/jquery.min.js"></script> 
<!--SweetAlert--> 
<script src="lib/sweet-alert/all.js"></script>
</head><body>
${html}
</body></html>
	`;
    
	mywindow.document.write(content);
    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    //mywindow.print();
    //mywindow.close();

    return true;
}

function supportsLocalStorage(){
	try{
	  return 'localStorage' in window && window['localStorage'] !== null;
	}
	catch(e){
		return false;
	}
}

const generateRandomString = (length) => {
	let chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	let ret = '';
	
	for(let i = length; i > 0; --i){
		ret += chars[Math.floor(Math.random() * chars.length)];
	}
	return ret;
}

const BUUPAddRow = () => {
	
	let str = `
	 <tr id="buup-${buupCounter}" style="margin-bottom: 20px; border-bottom: 1px solid #fff;">
	 <td><input type="text" placeholder="Product name" class="form-control name"></td>
	   <td><input type="text" placeholder="Product description" class="form-control desc"></td>
	   <td><input type="number"  placeholder="Price in NGN" class="form-control price"></td>
	   <td><input type="number"  placeholder="Stock" class="form-control stock"></td>
	   <td>
	     <select class="category" >
		 <option value="none">Select category</option>
		  ${categories.map(k => "<option value='" + k + "'>" + k.toUpperCase() + "</option>").join("")}
		 </select>
	   </td>
	   <td>
	    <select class="status" >
		<option value="none">Select status</option>
		 <option value="in_stock">In stock</option>
		 <option value="new">New</option>
		 <option value="out_of_stock">Out of stock</option>
		</select>
	   </td>
	   <td style="margin-top: 20px;" width="20%">
	    <div>
		  <div id="buup-${buupCounter}-images-div" class="row">
	        <div class="col-md-6">
	         <input type="file" placeholder="Upload image"  data-ic="0" class="form-control images" onchange="readURL(this,'${buupCounter}')" name="buup-${buupCounter}-images[]">
		    </div>
			<div class="col-md-6">
			    <div class="row">
			      <div class="col-md-7">
	                <img id="buup-${buupCounter}-preview-0" src="#" alt="preview" style="width: 50px; height: 50px;"/>
			      </div>
			      <div class="col-md-5">
			        <input type="radio" style="display: inline !important;" name="buup-${buupCounter}-cover" value="0">
			      </div>
			    </div>
			  </div>
		  </div>
	    </div>
	   </td>
	   <td>
	   <button onclick="BUUPAddImage('${buupCounter}'); return false;" class="btn btn-primary">Add image</button>
	   <button onclick="BUUPRemoveRow('${buupCounter}'); return false;" class="btn btn-danger">Cancel</button>
	  
	   </td>
	 </tr>
	`;
	++buupCounter;
	$('#buup-table').append(str);
}

const BUUPRemoveRow = (ctr) => {
	let r = $(`#buup-${ctr}`);
	console.log(r);
	r.remove();
	--buupCounter;
}

const BUUPAddImage = (ctr) => {
	let i = $(`#buup-${ctr}-images-div`), imgCount = $(`#buup-${ctr}-images-div input[type=file]`).length;
	console.log(imgCount);
	i.append(`<div class="col-md-6">
	          <input type="file" placeholder="Upload image" data-ic="${imgCount}" onchange="readURL(this,'${ctr}')" class="form-control images" name="buup-${ctr}-images[]">
			  </div>
			  <div class="col-md-6">
			    <div class="row">
			      <div class="col-md-7">
	                <img id="buup-${ctr}-preview-${imgCount}" src="#" alt="preview" style="width: 50px; height: 50px;"/>
			      </div>
			      <div class="col-md-5">
			        <input type="radio" style="display: inline !important;" name="buup-${ctr}-cover" value="${imgCount}">
			      </div>
			    </div>
			  </div>
	  `);
}

const showSelectError = (type,err) => {
	$(`#${type}-select-${err}-error`).fadeIn();
}

const hideElems = (cls) => {
	switch(cls){
		case 'bup':
		  $('#bup-select-product-error').hide();
		  $('#bup-select-qty-error').hide();
		break;
		
		case 'buup':
		  $('#buup-select-product-error').hide();
		  $('#buup-select-qty-error').hide();
		break;
	}
}

const BUUP = () => {
	hideElems('buup');
	console.log("BUUPlist length: ",buupCounter);
	
	
	if(buupCounter < 1){
		showSelectError('buup','product');
	}
	else{
	ret = [], hasUnfilledQty = false;

	for(let i = 0; i < buupCounter; i++){
		let BUPitem = `#buup-${i}`;
		name = $(`${BUPitem} input.name`).val();
		desc = $(`${BUPitem} input.desc`).val();
		price = $(`${BUPitem} input.price`).val();
		stock = $(`${BUPitem} input.stock`).val();
		category = $(`${BUPitem} select.category`).val();
		status = $(`${BUPitem} select.status`).val();
		
			if(name != "" && desc != "" && parseInt(price) > 0 && parseInt(stock) > 0 && category != "none" && status != "none"){
				let temp = {
					id: BUPitem,
					data:{
					  name: name,
					  desc: desc,
					  price: price,
					  stock: stock,
					  category: category,
					  status: status,
					}
				};
				BUUPlist.push(temp);
			}
			else{
				hasUnfilledQty = true;
			}		
	}
	
	   if(hasUnfilledQty){
		   showSelectError('buup','validation');
	   }
	   else{
		 //console.log("ret: ",ret);
		 
		 /**
		 $('#buup-dt').val(JSON.stringify(ret));
		$('#buup-form').submit();
		
		 **/
		 $('#button-box').hide();
		 $('#result-box').fadeIn();
		 
		 buupFire();
	   }
  }
}

const buupFire = () => {
	 let bc = localStorage.getItem("buupCtr");
	     if(!bc) bc = "0";
		 
		 
		
		 let fd = new FormData();
		 fd.append("dt",JSON.stringify(BUUPlist[bc]));
		 imgs = []; covers = [];
		
		//imgs = $(`${BUPitem}-image`)[0].files;
		imgs = $(`${BUUPlist[bc].id}-images-div input[type=file]`);
		cover = $(`${BUUPlist[bc].id}-images-div input[type=radio]:checked`);
		console.log("imgs: ",imgs);
		console.log("cover: ",cover);
		
		for(let r = 0; r < imgs.length; r++)
		 {
		    let imgg = imgs[r];
			let imgName = imgg.getAttribute("name");
            console.log("imgg name: ",imgName);			
            console.log("cover: ",cover.val());
            fd.append(imgName,imgg.files[0]);   			   			
		 }
		 
		 fd.append(cover.attr("name"),cover.val());
		 
		 
		 fd.append("_token",$('#tk').val());
		 console.log("fd: ",fd);
         
	
	//create request
	const req = new Request("buup",{method: 'POST', body: fd});
	//console.log(req);
	
	
	//fetch request
	fetch(req)
	   .then(response => {
		   if(response.status === 200){
			   //console.log(response);
			   
			   return response.json();
		   }
		   else{
			   return {status: "error:", message: "Network error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to upload product: " + error);			
	   })
	   .then(res => {
		   console.log(res);
          bc = parseInt(bc) + 1;
			     localStorage.setItem("buupCtr",bc);
				 
		   if(res.status == "ok"){
                  $('#result-ctr').html(bc);
		   }
		   else if(res.status == "error"){
				     alert("An unknown network error has occured. Please refresh the app or try again later");			   
		   }
		   
		    setTimeout(function(){
			       if(bc >= buupCounter){
					  $('#result-box').hide();
					  $("#finish-box").fadeIn();
					  window.location = "buup";
				  }
                  else{
					 buupFire();
				  }				  
		    },4000);
		   
		  
	   }).catch(error => {
		    alert("Failed to send message: " + error);			
	   });
}
