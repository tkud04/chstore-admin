<?php
namespace App\Helpers;

use App\Helpers\Contracts\HelperContract; 
use Crypt;
use Carbon\Carbon; 
use Mail;
use Auth;
use Illuminate\Http\Request;
use App\ShippingDetails;
use App\User;
use App\Carts;
use App\Manufacturers;
use App\Categories;
use App\CategoryData;
use App\Products;
use App\Discounts;
use App\ProductData;
use App\ProductImages;
use App\Reviews;
use App\Ads;
use App\Banners;
use App\Orders;
use App\OrderItems;
use App\Trackings;
use App\Wishlists;
use App\Senders;
use App\Settings;
use App\Plugins;
use App\Couriers;
use App\Comparisons;
use \Swift_Mailer;
use \Swift_SmtpTransport;
use \Cloudinary\Api;
use \Cloudinary\Api\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use Codedge\Fpdf\Fpdf\Fpdf;



class Helper implements HelperContract
{

 public $signals = ['okays'=> ["login-status" => "Sign in successful",            
                     "signup-status" => "Account created successfully! You can now login to complete your profile.",
                     "add-product-status" => "Product added!",
                     "add-category-status" => "Category added!",
                     "update-product-status" => "Product updated!",
                     "remove-category-status" => "Category removed!",
                     "remove-product-status" => "Product removed!",
                     "update-category-status" => "Category updated!",
                     "update-status" => "Account updated!",
                     "update-user-status" => "User account updated!",
                     "config-status" => "Config added/updated!",
                     "add-ad-status" => "Ad added!",
                     "edit-ad-status" => "Ad updated!",
					 "ad-banner-status" => "Banner added!",
                     "edit-banner-status" => "Banner updated!",
                     "edit-review-status" => "Review info updated!",
                     "edit-order-status" => "Order info updated!",
                     "contact-status" => "Message sent! Our customer service representatives will get back to you shortly.",
                     "create-tracking-status" => "Tracking info updated.",
                     "update-discount-status" => "Discount updated.",
                     "create-discount-status" => "Discount created.",
                     "delete-discount-status" => "Discount deleted.",
                     "no-sku-status" => "Please select a product for single discount.",
                     "set-cover-image-status" => "Product image updated",
                     "delete-image-status" => "Image deleted",
                     "delete-order-status" => "Order deleted",
                     "bulk-update-tracking-status" => "Trackings updated",
                     "bulk-confirm-payment-status" => "Payments confirmed",
                     "bulk-update-products-status" => "Products updated",
                     "bulk-upload-products-status" => "Products uploaded",
                     "no-validation-status" => "Please fill all required fields",
                     "add-plugin-status" => "Plugin added",
                     "update-plugin-status" => "Plugin updated",
                     "remove-plugin-status" => "Plugin removed",
                     "add-sender-status" => "Sender added",
                     "remove-sender-status" => "Sender removed",
                     "mark-sender-status" => "Sender updated",
					 "add-catalog-status" => "Item(s) added to catalog",
                     "remove-catalog-status" => "Item(s) removed from catalog",
                     "update-catalog-status" => "Catalog updated",
					 "add-manufacturer-status" => "Manufacturer added",
                     "remove-manufacturer-status" => "Manufacturer removed",
                     "update-manufacturer-status" => "Manufacturer updated",
                     
					 //ERRORS
					 "login-status-error" => "There was a problem signing in, please contact support.",
					 "signup-status-error" => "There was a problem signing in, please contact support.",
					 "duplicate-user-status-error" => "An account with this email already exists.",
					 "update-status-error" => "There was a problem updating the account, please contact support.",
					 "update-user-status-error" => "There was a problem updating the user account, please contact support.",
					 "validation-status-error" => "Please fill all required fields.",
					 "duplicate-status-error" => "Already exists.",
					 "contact-status-error" => "There was a problem sending your message, please contact support.",
					 "create-product-status-error" => "There was a problem adding the product, please try again.",
					 "add-category-status-error" => "There was a problem adding the category, please try again.",
					 "update-product-status-error" => "There was a problem updating product info, please try again.",
					 "update-category-status-error" => "There was a problem updating category, please try again.",
					 "create-ad-status-error" => "There was a problem adding new ad, please try again.",
					 "edit-ad-status-error" => "There was a problem updating the ad, please try again.",
					 "create-banner-status-error" => "There was a problem adding new banner, please try again.",
					 "edit-banner-status-error" => "There was a problem updating the banner, please try again.",
					 "edit-order-status-error" => "There was a problem updating the order, please try again.",
					 "create-tracking-status-error" => "There was a problem updating tracking information, please try again.",
					 "create-discount-status-error" => "There was a problem creating the discount, please try again.",
					 "update-discount-status-error" => "There was a problem updating the discount, please try again.",
					 "delete-image-status-error" => "There was a problem deleting the image, please try again.",
					 "set-cover-image-status-error" => "There was a problem updating the product image, please try again.",
					 "delete-discount-status-error" => "There was a problem deleting the discount, please try again.",
					"bulk-update-tracking-status-error" => "There was a problem updating trackings, please try again.",
					"bulk-confirm-payment-status-error" => "There was a problem confirming payments, please try again.",
					"bulk-update-products-status-error" => "There was a problem updating products, please try again.",
					"bulk-upload-products-status-error" => "There was a problem uploading products, please try again.",
					"add-manufacturer-status-error" => "There was a problem adding the manufacturer, please try again.",
                     "remove-manufacturer-status-error" => "There was a problem removing the manufacturer, please try again.",
                     "update-manufacturer-status-error" => "There was a problem updating the manufacturer, please try again."
                   ],
				   'errors' => []
				   ];
  

  public $countries = [
'afghanistan' => "Afghanistan",
'albania' => "Albania",
'algeria' => "Algeria",
'andorra' => "Andorra",
'angola' => "Angola",
'antigua-barbuda' => "Antigua and Barbuda",
'argentina' => "Argentina",
'armenia' => "Armenia",
'australia' => "Australia",
'austria' => "Austria",
'azerbaijan' => "Azerbaijan",
'bahamas' => "The Bahamas",
'bahrain' => "Bahrain",
'bangladesh' => "Bangladesh",
'barbados' => "Barbados",
'belarus' => "Belarus",
'belgium' => "Belgium",
'belize' => "Belize",
'benin' => "Benin",
'bhutan' => "Bhutan",
'bolivia' => "Bolivia",
'bosnia' => "Bosnia and Herzegovina",
'botswana' => "Botswana",
'brazil' => "Brazil",
'brunei' => "Brunei",
'bulgaria' => "Bulgaria",
'burkina-faso' => "Burkina Faso",
'burundi' => "Burundi",
'cambodia' => "Cambodia",
'cameroon' => "Cameroon",
'canada' => "Canada",
'cape-verde' => "Cape Verde",
'caf' => "Central African Republic",
'chad' => "Chad",
'chile' => "Chile",
'china' => "China",
'colombia' => "Colombia",
'comoros' => "Comoros",
'congo-1' => "Congo, Republic of the",
'congo-2' => "Congo, Democratic Republic of the",
'costa-rica' => "Costa Rica",
'cote-divoire' => "Cote DIvoire",
'croatia' => "Croatia",
'cuba' => "Cuba",
'cyprus' => "Cyprus",
'czech' => "Czech Republic",
'denmark' => "Denmark",
'djibouti' => "Djibouti",
'dominica' => "Dominica",
'dominica-2' => "Dominican Republic",
'timor' => "East Timor (Timor-Leste)",
'ecuador' => "Ecuador",
'egypt' => "Egypt",
'el-salvador' => "El Salvador",
'eq-guinea' => "Equatorial Guinea",
'eritrea' => "Eritrea",
'estonia' => "Estonia",
'ethiopia' => "Ethiopia",
'fiji' => "Fiji",
'finland' => "Finland",
'france' => "France",
'gabon' => "Gabon",
'gambia' => "The Gambia",
'georgia' => "Georgia",
'germany' => "Germany",
'ghana' => "Ghana",
'greece' => "Greece",
'grenada' => "Grenada",
'guatemala' => "Guatemala",
'guinea' => "Guinea",
'guinea-bissau' => "Guinea-Bissau",
'guyana' => "Guyana",
'haiti' => "Haiti",
'honduras' => "Honduras",
'hungary' => "Hungary",
'iceland' => "Iceland",
'india' => "India",
'indonesia' => "Indonesia",
'iran' => "Iran",
'iraq' => "Iraq",
'ireland' => "Ireland",
'israel' => "Israel",
'italy' => "Italy",
'jamaica' => "Jamaica",
'japan' => "Japan",
'jordan' => "Jordan",
'kazakhstan' => "Kazakhstan",
'kenya' => "Kenya",
'kiribati' => "Kiribati",
'nk' => "Korea, North",
'sk' => "Korea, South",
'kosovo' => "Kosovo",
'kuwait' => "Kuwait",
'kyrgyzstan' => "Kyrgyzstan",
'laos' => "Laos",
'latvia' => "Latvia",																																																																																							
'lebanon' => "Lebanon",
'lesotho' => "Lesotho",
'liberia' => "Liberia",
'libya' => "Libya",
'liechtenstein' => "Liechtenstein",
'lithuania' => "Lithuania",
'luxembourg' => "Luxembourg",
'macedonia' => "Macedonia",
'madagascar' => "Madagascar",
'malawi' => "Malawi",
'malaysia' => "Malaysia",
'maldives' => "Maldives",
'mali' => "Mali",
'malta' => "Malta",
'marshall' => "Marshall Islands",
'mauritania' => "Mauritania",
'mauritius' => "Mauritius",
'mexico' => "Mexico",
'micronesia' => "Micronesia, Federated States of",
'moldova' => "Moldova",
'monaco' => "Monaco",
'mongolia' => "Mongolia",
'montenegro' => "Montenegro",
'morocco' => "Morocco",
'mozambique' => "Mozambique",
'myanmar' => "Myanmar (Burma)",
'namibia' => "Namibia",
'nauru' => "Nauru",
'nepal' => "Nepal",
'netherlands' => "Netherlands",
'nz' => "New Zealand",
'nicaragua' => "Nicaragua",
'niger' => "Niger",
'nigeria' => "Nigeria",
'norway' => "Norway",
'oman' => "Oman",
'pakistan' => "Pakistan",
'palau' => "Palau",
'panama' => "Panama",
'png' => "Papua New Guinea",
'paraguay' => "Paraguay",
'peru' => "Peru",
'philippines' => "Philippines",
'poland' => "Poland",
'portugal' => "Portugal",
'qatar' => "Qatar",
'romania' => "Romania",
'russia' => "Russia",
'rwanda' => "Rwanda",
'st-kitts' => "Saint Kitts and Nevis",
'st-lucia' => "Saint Lucia",
'svg' => "Saint Vincent and the Grenadines",
'samoa' => "Samoa",
'san-marino' => "San Marino",
'sao-tome-principe' => "Sao Tome and Principe",
'saudi -arabia' => "Saudi Arabia",
'senegal' => "Senegal",
'serbia' => "Serbia",
'seychelles' => "Seychelles",
'sierra-leone' => "Sierra Leone",
'singapore' => "Singapore",
'slovakia' => "Slovakia",
'slovenia' => "Slovenia",
'solomon-island' => "Solomon Islands",
'somalia' => "Somalia",
'sa' => "South Africa",
'ss' => "South Sudan",
'spain' => "Spain",
'sri-lanka' => "Sri Lanka",
'sudan' => "Sudan",
'suriname' => "Suriname",
'swaziland' => "Swaziland",
'sweden' => "Sweden",
'switzerland' => "Switzerland",
'syria' => "Syria",
'taiwan' => "Taiwan",
'tajikistan' => "Tajikistan",
'tanzania' => "Tanzania",
'thailand' => "Thailand",
'togo' => "Togo",
'tonga' => "Tonga",
'trinidad-tobago' => "Trinidad and Tobago",
'tunisia' => "Tunisia",
'turkey' => "Turkey",
'turkmenistan' => "Turkmenistan",
'tuvalu' => "Tuvalu",
'uganda' => "Uganda",
'ukraine' => "Ukraine",
'uae' => "United Arab Emirates",
'uk' => "United Kingdom",
'usa' => "United States of America",
'uruguay' => "Uruguay",
'uzbekistan' => "Uzbekistan",
'vanuatu' => "Vanuatu",
'vatican' => "Vatican City",
'venezuela' => "Venezuela",
'vietnam' => "Vietnam",
'yemen' => "Yemen",
'zambia' => "Zambia",
'zimbabwe' => "Zimbabwe"
];


public $smtpp = [
       'gmail' => [
       'ss' => "smtp.gmail.com",
       'sp' => "587",
       'sec' => "tls",
       ],
       'yahoo' => [
       'ss' => "smtp.mail.yahoo.com",
       'sp' => "587",
       'sec' => "ssl",
       ],
  ];
	
 public $banks = [
      'access' => "Access Bank", 
      'citibank' => "Citibank", 
      'diamond-access' => "Diamond-Access Bank", 
      'ecobank' => "Ecobank", 
      'fidelity' => "Fidelity Bank", 
      'fbn' => "First Bank", 
      'fcmb' => "FCMB", 
      'globus' => "Globus Bank", 
      'gtb' => "GTBank", 
      'heritage' => "Heritage Bank", 
      'jaiz' => "Jaiz Bank", 
      'keystone' => "KeyStone Bank", 
      'polaris' => "Polaris Bank", 
      'providus' => "Providus Bank", 
      'stanbic' => "Stanbic IBTC Bank", 
      'standard-chartered' => "Standard Chartered Bank", 
      'sterling' => "Sterling Bank", 
      'suntrust' => "SunTrust Bank", 
      'titan-trust' => "Titan Trust Bank", 
      'union' => "Union Bank", 
      'uba' => "UBA", 
      'unity' => "Unity Bank", 
      'wema' => "Wema Bank", 
      'zenith' => "Zenith Bank"
 ];			

  public $ip = "";
  
    public $permissions = [
	   'view_users','edit_users',
	   'view_apartments','edit_apartments',
	   'view_reviews','edit_reviews',
	   'view_transactions','edit_transactions',
	   'view_tickets','edit_tickets',
	   'view_banners','edit_banners',
	   'view_plugins','edit_plugins',
	    'view_senders','edit_senders',
	    'view_posts','edit_posts'
	   ];

  public $suEmail = "kudayisitobi@gmail.com";

           
		   #{'msg':msg,'em':em,'subject':subject,'link':link,'sn':senderName,'se':senderEmail,'ss':SMTPServer,'sp':SMTPPort,'su':SMTPUser,'spp':SMTPPass,'sa':SMTPAuth};
           function sendEmailSMTP($data,$view,$type="view")
           {
           	    // Setup a new SmtpTransport instance for new SMTP
                $transport = "";
if($data['sec'] != "none") $transport = new Swift_SmtpTransport($data['ss'], $data['sp'], $data['sec']);

else $transport = new Swift_SmtpTransport($data['ss'], $data['sp']);

   if($data['sa'] != "no"){
                  $transport->setUsername($data['su']);
                  $transport->setPassword($data['spp']);
     }
// Assign a new SmtpTransport to SwiftMailer
$smtp = new Swift_Mailer($transport);

// Assign it to the Laravel Mailer
Mail::setSwiftMailer($smtp);

$se = $data['se'];
$sn = $data['sn'];
$to = $data['em'];
$subject = $data['subject'];
                   if($type == "view")
                   {
                     Mail::send($view,$data,function($message) use($to,$subject,$se,$sn){
                           $message->from($se,$sn);
                           $message->to($to);
                           $message->subject($subject);
                          if(isset($data["has_attachments"]) && $data["has_attachments"] == "yes")
                          {
                          	foreach($data["attachments"] as $a) $message->attach($a);
                          } 
						  $message->getSwiftMessage()
						  ->getHeaders()
						  ->addTextHeader('x-mailgun-native-send', 'true');
                     });
                   }

                   elseif($type == "raw")
                   {
                     Mail::raw($view,$data,function($message) use($to,$subject,$se,$sn){
                            $message->from($se,$sn);
                           $message->to($to);
                           $message->subject($subject);
                           if(isset($data["has_attachments"]) && $data["has_attachments"] == "yes")
                          {
                          	foreach($data["attachments"] as $a) $message->attach($a);
                          } 
                     });
                   }
           }

           function bomb($data) 
           {
             $url = $data['url'];
               
			       $client = new Client([
                 // Base URI is used with relative requests
                 'base_uri' => 'http://httpbin.org',
                 // You can set any number of default request options.
                 //'timeout'  => 2.0,
				 'headers' => $data['headers']
                 ]);
                  
				 
				 $dt = [
				    
				 ];
				 
				 if(isset($data['data']))
				 {
					if(isset($data['type']) && $data['type'] == "raw")
					{
					  $dt = ['body' => $data['data']];
					}
					else
					{
					  $dt['multipart'] = [];
					  foreach($data['data'] as $k => $v)
				      {
					    $temp = [
					      'name' => $k,
						  'contents' => $v
					     ];
						 
					     array_push($dt['multipart'],$temp);
				      }
					}
				   
				 }
				 
				 try
				 {
					if($data['method'] == "get") $res = $client->request('GET', $url);
					else if($data['method'] == "post") $res = $client->request('POST', $url,$dt);
			  
                   $ret = $res->getBody()->getContents(); 
			       //dd($ret);

				 }
				 catch(RequestException $e)
				 {
					 $mm = (is_null($e->getResponse())) ? null: Psr7\str($e->getResponse());
					 $ret = json_encode(["status" => "error","message" => $mm]);
				 }
			     $rett = json_decode($ret);
           return $ret; 
           }
		   
		   
		   function text($data) 
           {
           	//form query string
              // $qs = "sn=".$data['sn']."&sa=".$data['sa']."&subject=".$data['subject'];

               $lead = $data['to'];
			   
			   if($lead == null || $lead == "")
			   {
				    $ret = json_encode(["status" => "error","message" => "Invalid number"]);
			   }
			   else
			    { 
                  
			       $url = "https://smartsmssolutions.com/api/?";
			       $url .= "message=".urlencode($data['msg'])."&to=".$data['to'];
			       $url .= "&sender=Etuk+NG&type=0&routing=3&token=".env('SMARTSMS_API_X_KEY', '');
			      #dd($url);
				  
                  $dt = [
				       'headers' => [
					     'Content-Type' => "text/html"
					   ],
                       'method' => "get",
                       'url' => $url
                  ];
				
				 $ret = $this->bomb($dt);
				 #dd($ret);
				 $smsData = explode("||",$ret);
				 if(count($smsData) == 2)
				 {
					 $status = $smsData[0];
					 $dt = $smsData[1];
					 
					 if($status == "1000")
					 {
						$rett = json_decode($dt);
			            if($rett->code == "1000")
			            {
					      $ret = json_encode(["status" => "ok","message" => "Message sent!"]); 			
			             }
				         else
			             {
			         	   $ret = json_encode(["status" => "error","message" => "Error sending message."]); 
			             } 
					 }
					 else
					 {
						 $ret = json_encode(["status" => "error","message" => "Error sending message."]); 
					 }
				 }
				 else
				 {
					$ret = json_encode(["status" => "error","message" => "Malformed response from SMS API"]); 
				 }
			     
			    }
				
              return $ret; 
           }
		   
		   function isDuplicateUser($dt)
		   {
			   $ret = false;
			   $u = User::where($dt)->first();
			   if($u != null) $ret = true;
			   return $ret;
		   }
		   
		   function createUser($data)
           {
			   $avatar = isset($data['avatar']) ? $data['avatar'] : "";
			   $avatarType = isset($data['avatar_type']) ? $data['avatar_type'] : "cloudinary";
			   $pass = (isset($data['password']) && $data['password'] != "") ? bcrypt($data['password']) : "";
			   
           	   $ret = User::create(['fname' => $data['fname'], 
                                                      'lname' => $data['lname'], 
                                                      'email' => $data['email'], 
                                                      'phone' => "", 
                                                      'role' => $data['role'], 
                                                      'mode' => "", 
                                                      'mode_type' => "", 
                                                      'avatar' => $avatar, 
                                                      'avatar_type' => "", 
                                                      'currency' => "gbp", 
                                                      'host_upgraded' => "", 
                                                      'status' => $data['status'], 
                                                      'verified' => $data['verified'], 
                                                      'password' => $pass, 
                                                      ]);
                                                      
                return $ret;
           }
		   
		     function getUsers($all=false)
           {
           	$ret = [];
              $users = User::where('id','>',"0")->get();
             
              if($users != null)
               {
				  foreach($users as $u)
				  {
					  $uu = $this->getUser($u->id,$all);
					  array_push($ret,$uu);
				  }
               }                         
                                                      
                return $ret;
           }
		   
		   function getUser($id,$all=false)
           {
           	$ret = [];
               $u = User::where('email',$id)
			            ->orWhere('id',$id)->first();
 
              if($u != null)
               {
                   	$temp['fname'] = $u->fname; 
                       $temp['lname'] = $u->lname; 
                       //$temp['wallet'] = $this->getWallet($u);
                       $temp['phone'] = $u->phone; 
                       $temp['email'] = $u->email; 
                       $temp['role'] = $u->role;
                       if($all)
					   {
						   $sd =  $this->getShippingDetails($u);
						   $temp['sd'] = count($sd) > 0 ? $sd[0] : $sd;
					   }					   
                       $temp['status'] = $u->status; 
                       $temp['verified'] = $u->verified; 
                       $temp['id'] = $u->id; 
                       $temp['date'] = $u->created_at->format("jS F, Y h:i"); 
                       $ret = $temp; 
               }                          
                                                      
                return $ret;
           }
		   
		   
		    function getCarts()
           {
           	$ret = [];

			  $carts = Carts::where('id','>',"0")->get();
			  #dd($uu);
              if($carts != null)
               {
               	foreach($carts as $c) 
                    {
                    	$temp = [];
               	     $temp['id'] = $c->id; 
               	     $temp['user_id'] = $c->user_id; 
                        $temp['product'] = $this->getProduct($c->sku); 
                        $temp['qty'] = $c->qty; 
                        $temp['date'] = $c->created_at->format("jS F,Y h:i A"); 
                        array_push($ret, $temp); 
                   }
               }                                 
              			  
                return $ret;
           }
		   
		   
		   function getProducts()
           {
           	$ret = [];
              $products = Products::where('id','>',"0")->get();
              $products = $products->sortByDesc('created_at');
			  
              if($products != null)
               {
				  foreach($products as $p)
				  {
					  $pp = $this->getProduct($p->id);
					  array_push($ret,$pp);
				  }
               }                         
                                                      
                return $ret;
           }
		   
		   function getProduct($id,$imgId=false)
           {
           	$ret = [];
              $product = Products::where('id',$id)
			                 ->orWhere('sku',$id)->first();
       
              if($product != null)
               {
				  $temp = [];
				  $temp['id'] = $product->id;
				  $temp['name'] = $product->name;
				  $temp['sku'] = $product->sku;
				  $temp['qty'] = $product->qty;
				  $temp['in_catalog'] = $product->in_catalog;
				  $temp['status'] = $product->status;
				  $temp['pd'] = $this->getProductData($product->sku);
				  $temp['discounts'] = $this->getDiscounts($product->sku);
				  $imgs = $this->getImages($product->sku);
				  if($imgId) $temp['imgs'] = $imgs;
				  $temp['imggs'] = $this->getCloudinaryImages($imgs);
				  $temp['date'] = $product->created_at->format("jS F,Y h:i A"); 
				  $ret = $temp;
               }                         
                                                      
                return $ret;
           }

		   function getProductData($sku)
           {
           	$ret = [];
              $pd = ProductData::where('sku',$sku)->first();
 
              if($pd != null)
               {
				  $temp = [];
				  $temp['id'] = $pd->id;
				  $temp['sku'] = $pd->sku;
				  $temp['amount'] = $pd->amount;
				  $temp['description'] = $pd->description;
				  $temp['in_stock'] = $pd->in_stock;
				  $temp['category'] = $pd->category;
				  $ret = $temp;
               }                         
                                                      
                return $ret;
           }
		   
		   function getProductImages($sku)
           {
           	$ret = [];
              $pis = ProductImages::where('sku',$sku)->get();
 
            
              if($pis != null)
               {
				  foreach($pis as $pi)
				  {
				    $temp = [];
				    $temp['id'] = $pi->id;
				    $temp['sku'] = $pi->sku;
				    $temp['cover'] = $pi->cover;
				    $temp['url'] = $pi->url;
				    array_push($ret,$temp);
				  }
               }                         
                                                      
                return $ret;
           }
		   
		   function isCoverImage($img)
		   {
			   return $img['cover'] == "yes";
		   }
		   
		   function getImage($pi)
           {
       	         $temp = [];
				 $temp['id'] = $pi->id;
				 $temp['sku'] = $pi->sku;
			     $temp['cover'] = $pi->cover;
				 $temp['url'] = $pi->url;
				 
                return $temp;
           }
		   
		   function getImages($sku)
		   {
			   $ret = [];
			   $records = $this->getProductImages($sku);
			   
			   $coverImage = ProductImages::where('sku',$sku)
			                              ->where('cover',"yes")->first();
										  
               $otherImages = ProductImages::where('sku',$sku)
			                              ->where('cover',"!=","yes")->get();
			  
               if($coverImage != null)
			   {
				   $temp = $this->getImage($coverImage);
				   array_push($ret,$temp);
			   }

               if($otherImages != null)
			   {
				   foreach($otherImages as $oi)
				   {
					   $temp = $this->getImage($oi);
				       array_push($ret,$temp);
				   }
			   }
			   
			   return $ret;
		   }

		  
		   function setCoverImage($id)
           {
              $pi = ProductImages::where('id',$id)->first();
            
              if($pi != null)
               {
				   $formerPi = ProductImages::where('sku',$pi->sku)
			              ->where('cover',"yes")->first();
                   
				   if($formerPi != null)
				   {
					   $formerPi->update(['cover' => "no"]);
				   }
				   
				  $pi->update(['cover' => "yes"]);
               }                         
                                                      
           }
		   
		   function getCloudinaryImage($dt)
		   {
			   $ret = [];
                  //dd($dt);       
               if(is_null($dt)) { $ret = "img/no-image.png"; }
               
			   else
			   {
				    $ret = "https://res.cloudinary.com/dkrf5ih0l/image/upload/v1585236664/".$dt;
                }
				
				return $ret;
		   }
		   
		   function getCloudinaryImages($dt)
		   {
			   $ret = [];
                 # dd($dt);       
               if(count($dt) < 1) { $ret = ["img/no-image.png"]; }
               
			   else
			   {
                   $ird = isset($dt[0]['url']) ? $dt[0]['url'] : $dt[0];
				   if($ird == "none")
					{
					   $ret = ["img/no-image.png"];
					}
				   else
					{
                       for($x = 0; $x < count($dt); $x++)
						 {
							 $ird = isset($dt[$x]['url']) ? $dt[$x]['url'] : $dt[$x];
                            $imgg = "https://res.cloudinary.com/dkrf5ih0l/image/upload/v1585236664/".$ird;
                            array_push($ret,$imgg); 
                         }
					}
                }
				
				return $ret;
		   }
		
		   
		     function updateUser($data)
           {		

				$uu = User::where('id', $data['xf'])->first();
				
				if(!is_null($uu))				
				{
					$uu->update(['fname' => $data['fname'], 
                                                      'lname' => $data['lname'],
                                                     'email' => $data['email'],
                                                'phone' => $data['phone'],
                                              'status' => $data['status'] 
                                                      ]);	
				}
					
           }
		   
		   function isAdmin($user)
           {
           	$ret = false; 
               if($user->role === "admin" || $user->role === "su") $ret = true; 
           	return $ret;
           }
		   
		   function generateSKU()
           {
           	$ret = "MBZ".rand(1,9999)."LX".rand(1,999);
                                                      
                return $ret;
           }
		   
		   
		   function createProduct($data)
           {
           	$sku = $this->generateSKU();
               
           	$ret = Products::create(['name' => $data['name'],                                                                                                          
                                                      'sku' => $sku, 
                                                      'qty' => $data['qty'],                                                       
                                                      'added_by' => $data['user_id'],                                                       
                                                      'in_catalog' => "no", 
                                                      'status' => "enabled", 
                                                      ]);
                                                      
                 $data['sku'] = $ret->sku;                         
                $pd = $this->createProductData($data);
				$ird = "none";
				$irdc = 0;
				if(isset($data['ird']) && count($data['ird']) > 0)
				{
					foreach($data['ird'] as $i)
                    {
                    	$this->createProductImage([
						                           'sku' => $data['sku'],
												   								   'url' => $i['public_id'],
								   'delete_token' => $i['delete_token'],
								   'deleted' => $i['deleted'],
								   'cover' => $i['ci'],
								   'type' => $i['type'],
								   'src_type' => "cloudinary"
						                         ]);
                    }
				}
                
                return $ret;
           }
           function createProductData($data)
           {
           	$in_stock = (isset($data["in_stock"])) ? "new" : $data["in_stock"];
           
           	$ret = ProductData::create(['sku' => $data['sku'],                                                                                                          
                                                      'description' => $data['description'], 
                                                      'amount' => $data['amount'],                                                      
                                                      'category' => $data['category'],                                                       
                                                      'in_stock' => $in_stock                                              
                                                      ]);
                                                      
                return $ret;
           }
         
           function createProductImage($data)
           {
			   $cover = isset($data['cover']) ? $data['cover'] : "no";
           	$ret = ProductImages::create(['sku' => $data['sku'],                                                                                                          
                                                      'url' => $data['url'],                                                       
                                                      'cover' => $data['cover'],                                                    
                                                      'type' => $data['type'],                                                      
                                                      'src_type' => $data['src_type'],                                                      
                                                      'delete_token' => $data['delete_token'],                                                 
                                                      'deleted' => $data['deleted']                                                      
                                                      ]);
                                                      
                return $ret;
           }
		   
		   function createDiscount($data)
           {
			   $sku = ($data['type'] == "single") ? $data['type'] : "";
			   
           	$ret = Discounts::create(['sku' => $data['sku'],                                                                                                          
                                                      'discount_type' => $data['discount_type'], 
                                                      'discount' => $data['discount'], 
                                                      'type' => $data['type'], 
                                                      'status' => $data['status'], 
                                                      ]);
                                                      
                return $ret;
           }
		   
		   function getDiscounts($id,$type="product")
           {
           	$ret = [];
			
			 if($id == "all")
			 {
				 $discounts = Discounts::where('id','>',"0")->get();
             }
			 else
			 {
               if($type == "product")
			   {
				  $discounts = Discounts::where('sku',$id)
			                 ->orWhere('type',"general")
							 ->where('status',"enabled")->get(); 
			   }
			   elseif($type == "user")
			   {
			  	  $discounts = Discounts::where('sku',$id)
			                 ->where('type',"user")
							 ->where('status',"enabled")->get();
               }
			 }
			 
			 
              if($discounts != null)
               {
				  foreach($discounts as $d)
				  {
					$temp = [];
				    $temp['id'] = $d->id;
				    $temp['sku'] = $d->sku;
				    $temp['discount_type'] = $d->discount_type;
				    $temp['discount'] = $d->discount;
				    $temp['type'] = $d->type;
				    $temp['status'] = $d->status;
				    array_push($ret,$temp);  
				  }
               }                         
                                                      
                return $ret;
           }
		   
		     function getDiscountPrices($amount,$discounts)
		   {
			   $newAmount = 0;
						$dsc = [];
                     
					 if(count($discounts) > 0)
					 { 
						 foreach($discounts as $d)
						 {
							 $temp = 0;
							 $val = $d['discount'];
							 
							 switch($d['discount_type'])
							 {
								 case "percentage":
								   $temp = floor(($val / 100) * $amount);
								 break;
								 
								 case "flat":
								   $temp = $val;
								 break;
							 }
							 
							 array_push($dsc,$temp);
						 }
					 }
				   return $dsc;
		   }

		   function getDiscount($id)
           {
           	
				$disc = Discounts::where('id',$id)->first();              
							 
					if($disc != null)
					{
					
							$temp = [];
				            $temp['id'] = $disc->id;
				            $temp['sku'] = $disc->sku;
				            $temp['discount_type'] = $disc->discount_type;
				            $temp['discount'] = $disc->discount;
				            $temp['type'] = $disc->type;
				            $temp['status'] = $disc->status;
							$ret = $temp;
					}                      
                                                      
                return $ret;
           }
		   
		   function updateProduct($data)
           {
           	$ret = [];
              $p = Products::where('id',$data['xf'])
			                 ->orWhere('sku',$data['xf'])->first();
              
			  //dd($data);
              if($p != null)
               {
				  $p->update([
				  'qty' => $data['qty'],
				    'status' => $data['status']
				  ]);
				  
				  $pd = ProductData::where('sku',$p->sku)->first();
				  if($pd != null)
				  {
					  $pd->update([
					    'category' => $data['category'],
					    'in_stock' => $data['in_stock'],
					    'amount' => $data['amount'],
					    'description' => $data['description'],
					  ]);
				  }
				  
				  //images
				  if(isset($data['ird']) && count($data['ird']) > 0)
				{
					foreach($data['ird'] as $url)
                    {
                    	$this->createProductImage(['sku' => $p->sku, 'url' => $url, 'irdc' => "1"]);
                    }
				}

                  //discounts
                  if($data['add_discount'] == "yes")
				  {
					  $disc = ['sku' => $p->sku,
					           'discount_type' => $data['discount_type'],
							   'discount' => $data['discount'],
							   'type' => 'single',
							   'status' => "enabled"
							   ];
					  $discount = $this->createDiscount($disc);
				  }				  
				 
				 
				 //update catalog here
				 
				 $cid = env('FACEBOOK_CATALOG_ID');
		        $url = "https://graph.facebook.com/v8.0/".$cid."/batch";
				$reqs = [];
				 
				 $temp = [
		                  'method' => "UPDATE",
			              'retailer_id' => $p->sku,
			              'data' => [
			                'amount' => $data['amount'] * 100,
			                'description' => $data['description']
			              ]
			           ];
					   array_push($reqs,$temp);
					   
					   $dtt = [
		           'access_token' => $tk,
		           'requests' => $reqs
		       ]; 
			   $data = [
		        'type' => "json",
		        'data' => $dtt
		       ];
		       $ret = $this->callAPI($url,"POST",$data);
			   $rt = json_decode($ret);
			   #dd($rt);
			   if(isset($rt->handles))
			   {
				   $handles = $rt->handles;
				   /**
				   foreach($products as $p)
				   {
					   $pp = Products::where('sku',$p->sku)->first();
					   if($pp != null) $pp->update(['in_catalog' => "yes"]);
				   }
				  **/
			   }
               }                         
                                                      
                return "ok";
           }

		   function disableProduct($id,$def=false)
           {
           	$ret = [];
              $p = Products::where('id',$id)
			                 ->orWhere('sku',$id)->first();
              
			  //dd($data);
              if($p != null)
               {
				  $p->update([		
				    'status' => "disabled"
				  ]);
               }                         
                                                      
                return "ok";
           } 
		   
		   function deleteProduct($id,$def=false)
           {
           	$ret = [];
              $p = Products::where('id',$id)
			                 ->orWhere('sku',$id)->first();
              
			  //dd($data);
              if($p != null)
               {
				  $pis = ProductImages::where('sku',$id)->get();
				  
				  if($pis != null)
				  {
					foreach($pis as $pi) $pi->delete();  
				  }
				  
				  $pd = ProductData::where('sku',$id)->first();
				  
				  if($pd != null) $pd->delete();
				  
				  $p->delete();
               }                         
                                                      
                return "ok";
           } 
		   
		    function updateDiscount($data)
           {
           	$ret = [];
              $disc = Discounts::where('id',$data['xf'])->first();
              
			  //dd($data);
              if($disc != null)
               {
				  $disc->update([
				  'type' => $data['type'],
				  'sku' => $data['sku'],
				  'discount_type' => $data['discount_type'],
				  'discount' => $data['discount'],
				    'status' => $data['status']
				  ]);
				  
				 
               }                         
                                                      
                return "ok";
           }
		   
		   function deleteDiscount($xf)
           {
           	$ret = [];
              $d = Discounts::where('id',$xf)->first();
              
			  //dd($data);
              if($d != null)
               {
				 $d->delete();
               }                         
                                                      
                return "ok";
           }
		   
		   function deleteProductImage($xf)
           {
           	$ret = [];
              $pi = ProductImages::where('id',$xf)->first();
              
			  //dd($data);
              if($pi != null)
               {
				  //$this->deleteCloudImage($pi->delete_token);
				 $pi->delete();
               }                         
                                                      
                return "ok";
           }
		   
		  function deleteCloudImage($id)
          {
          	$dt = ['cloud_name' => "dkrf5ih0l",'invalidate' => true];
          	$rett = \Cloudinary\Uploader::destroy($id,$dt);
                                                     
             return $rett; 
         }
		 
		 function resizeImage($res,$size)
		 {
			  $ret = Image::make($res)->resize($size[0],$size[1])->save(sys_get_temp_dir()."/upp");			   
              // dd($ret);
			   $fname = $ret->dirname."/".$ret->basename;
			   $fsize = getimagesize($fname);
			  return $fname;		   
		 }
		   
		    function uploadCloudImage($path)
          {
          	$ret = [];
          	$dt = ['cloud_name' => "dkrf5ih0l"];
              $preset = "fk6fcwlg";
          	$rett = \Cloudinary\Uploader::unsigned_upload($path,$preset,$dt);
                                                      
             return $rett; 
         }
		 
		  function addCategory($data)
           {
			   $img = ""; $delete_token = "";
			   
			   if(isset($data['image']) && isset($data['delete_token']))
			   {
				   $img = $data['image'];
				   $delete_token = $data['delete_token'];
			   }
			   
			   foreach($data as $k => $v)
			   {
				   if($v == null) $data[$k] = "";
			   }
			   
           	$category = Categories::create([
			   'name' => ucwords($data['name']),
			   'category' => $data['category'],
			   'image' => $img,
			   'delete_token' => $delete_token,
			   'parent_id' => $data['parent'],
			   'status' => "enabled"
			]);      
            
           $data['category_id'] = $category->id;
           $cd = $this->addCategoryData($data);		   
            return $category;
           }
		   
		   function addCategoryData($d)
		   {
			   CategoryData::create([
			     'category_id' => $d['category_id'],
			     'description' => $d['description'],
			     'meta_title' => $d['meta_title'],
			     'meta_description' => $d['meta_description'],
			     'meta_keywords' => $d['meta_keywords'],
			     'seo_keywords' => $d['seo_keywords'],
			   ]);
		   }
		   
		   function getCategories()
           {
           	$ret = [];
           	$categories = Categories::where('id','>','0')->get();
              // dd($cart);
			  
              if($categories != null)
               {           	
               	foreach($categories as $c) 
                    {
						$temp = $this->getCategory($c->id);
						array_push($ret,$temp);
                    }
               }                                 
                                                      
                return $ret;
           }
		   
		   function getCategory($id)
           {
           	$ret = [];
           	$c = Categories::where('id',$id)->first();
              // dd($cart);
			  
              if($c != null)
               {           	
						$temp = [];
						$temp['id'] = $c->id;
						$temp['name'] = $c->name;
						$temp['category'] = $c->category;
						$temp['data'] = $this->getCategoryData($c->id);
						$temp['image'] = $this->getCloudinaryImages([$c->image]);
						$temp['parent_id'] = $c->parent_id;
						$temp['parent'] = $this->getCategory($c->parent_id);
						$temp['status'] = $c->status;
						$temp['date'] = $c->created_at->format("jS F, Y"); 
						$ret = $temp;
               }                                 
                                                      
                return $ret;
           }
		   function getCategoryData($id)
           {
           	$ret = [];
           	$c = CategoryData::where('category_id',$id)->first();
              // dd($cart);
			  
              if($c != null)
               {           	
						$temp = [];
						$temp['id'] = $c->id;
						$temp['category_id'] = $c->category_id;
						$temp['description'] = $c->description;
						$temp['meta_title'] = $c->meta_title;
						$temp['meta_description'] = $c->meta_description;
						$temp['meta_keywords'] = $c->meta_keywords; 
						$temp['seo_keywords'] = $c->seo_keywords; 
						$ret = $temp;
               }                                 
                                                      
                return $ret;
           }
		   
		   function updateCategory($data)
           {
			  $c = Categories::where('id',$data['xf'])->first();
			  
			  $ret = [];
			  if(isset($data['name'])) $ret['name'] = $data['name'];
			  if(isset($data['category'])) $ret['category'] = $data['category'];
			  if(isset($data['parent'])) $ret['parent_id'] = $data['parent'];
			  if(isset($data['image'])) $ret['image'] = $data['image'];
			  if(isset($data['delete_token'])) $ret['delete_token'] = $data['delete_token'];
			  if(isset($data['status'])) $ret['status'] = $data['status'];
			  
			if($c != null)
			{
				$c->update($ret);
				$cd = CategoryData::where('category_id',$c->id)->first();
				
				$ret = [];
			    if(isset($data['description'])) $ret['description'] = $data['description'];
			    if(isset($data['meta_title'])) $ret['meta_title'] = $data['meta_title'];
			    if(isset($data['meta_description'])) $ret['meta_description'] = $data['meta_description'];
			    if(isset($data['meta_keywords'])) $ret['meta_keywords'] = $data['meta_keywords'];
			    if(isset($data['seo_keywords'])) $ret['seo_keywords'] = $data['seo_keywords'];
				$cd->update($ret);
			}

                return "ok";
           }
		   
		   function removeCategory($dt)
		   {
			   $ret = [];
			   $c = Categories::where('id',$dt)->first();
			   
			   if(!is_null($c))
			   {
				   $cd = CategoryData::where('category_id',$c->id)->first();
				   if($cd != null) $cd->delete();
				  $c->delete();
			   }
		   }

		   function addManufacturer($data)
           {
			   $img = ""; $delete_token = "";
			   if(isset($data['image']) && isset($data['delete_token']))
			   {
				   $img = $data['image'];
				   $delete_token = $data['delete_token'];
			   }
           	$m = Manufacturers::create([
			   'name' => $data['name'],
			   'image' => $img,
			   'delete_token' => $delete_token,
			]);                          
            return $m;
           }
		   
		   function getManufacturers()
           {
           	$ret = [];
           	$manufacturers = Manufacturers::where('id','>','0')->get();
              // dd($cart);
			  
              if($manufacturers != null)
               {           	
               	foreach($manufacturers as $m) 
                    {
						$temp = $this->getManufacturer($m->id);
						array_push($ret,$temp);
                    }
               }                                 
                                                      
                return $ret;
           }
		   
		   function getManufacturer($id)
           {
           	$ret = [];
           	$m = Manufacturers::where('id',$id)->first();
              // dd($cart);
			  
              if($m != null)
               {           	
						$temp = [];
						$temp['id'] = $m->id;
						$temp['name'] = $m->name;
						$temp['image'] = $this->getCloudinaryImages([$m->image]);
						$temp['date'] = $m->created_at->format("jS F, Y"); 
						$ret = $temp;
               }                                 
                                                      
                return $ret;
           }
		   
		   function updateManufacturer($data)
           {
			  $m = Manufacturers::where('id',$data['xf'])->first();
			  
			  $ret = [];
			  if(isset($data['name'])) $ret['name'] = $data['name'];
			  if(isset($data['image'])) $ret['image'] = $data['image'];
			  if(isset($data['delete_token'])) $ret['delete_token'] = $data['delete_token'];
			  
			if($m != null)
			{
				$m->update($ret);
			}

                return "ok";
           }
		   
		   function removeManufacturer($dt)
		   {
			   $ret = [];
			   $m = Manufacturers::where('id',$dt)->first();
			   
			   if(!is_null($m))
			   {
				  $m->delete();
			   }
		   }
		   
		   function createAd($data)
           {
           	$ret = Ads::create(['img' => $data['img'], 
                                                      'type' => $data['type'], 
                                                      'status' => $data['status'] 
                                                      ]);
                                                      
                return $ret;
           }

            function getAds($type="wide-ad")
		   {
			   $ret = [];
			   $ads = Ads::where('id',">",'0')->get();
			   #dd($ads);
			   if(!is_null($ads))
			   {
				   foreach($ads as $ad)
				   {
					   $temp = [];
					   $temp['id'] = $ad->id;
					   $img = $ad->img;
					   $temp['img'] = $this->getCloudinaryImage($img);
					   $temp['type'] = $ad->type;
					   $temp['status'] = $ad->status;
					   array_push($ret,$temp);
				   }
			   }
			   
			   return $ret;
		   }	   

		   function getAd($id)
		   {
			   $ret = [];
			   $ad = Ads::where('id',$id)->first();
			   #dd($ads);

			   if(!is_null($ad))
			   {
					   $temp = [];
					   $temp['id'] = $ad->id;
					   $img = $ad->img;
					   $temp['img'] = $this->getCloudinaryImage($img);
					   $temp['type'] = $ad->type;
					   $temp['status'] = $ad->status;
					   $ret = $temp;
			   }
			   
			   return $ret;
		   }	 

            function updateAd($data)
           {
			  $ad = Ads::where('id',$data['xf'])->first();
			 
			 
			if($ad != null)
			{
				$ad->update(['type' => $data['type'],                                                                                                                                                               
                                                      'status' => $data['status']
				
				]);
			}

                return "ok";
           }		   
		  
		  
		    function createReview($user,$data)
           {
			   $userId = $user == null ? $this->generateTempUserID() : $user->id;
           	$ret = Reviews::create(['user_id' => $userId, 
                                                      'sku' => $data['sku'], 
                                                      'rating' => $data['rating'],
                                                      'name' => $data['name'],
                                                      'review' => $data['review'],
													  'status' => "pending",
                                                      ]);
                                                      
                return $ret;
           }
		   
		  function getReviews()
           {
           	$ret = [];
              $reviews = Reviews::where('id','>',"0")->get();
              $reviews = $reviews->sortByDesc('created_at');
			  
              if($reviews != null)
               {
				  foreach($reviews as $r)
				  {
					  $temp = [];
					  $temp['id'] = $r->id;
					  $temp['user_id'] = $r->user_id;
					  $temp['sku'] = $r->sku;
					  $temp['rating'] = $r->rating;
					  $temp['name'] = $r->name;
					  $temp['review'] = $r->review;
					  $temp['status'] = $r->status;
					  array_push($ret,$temp);
				  }
               }                         
                                  
                return $ret;
           }
		   
		   function getReview($id)
           {
           	$ret = [];
              $r = Reviews::where('id',$id)->first();
 
              if($r != null)
               {
				  
					  $temp = [];
					  $temp['id'] = $r->id;
					  $temp['user_id'] = $r->user_id;
					  $temp['sku'] = $r->sku;
					  $temp['rating'] = $r->rating;
					  $temp['name'] = $r->name;
					  $temp['review'] = $r->review;
					  $temp['status'] = $r->status;
					  $ret = $temp;
               }                         
                                  
                return $ret;
           }
		   
		    function updateReview($data)
           {
			  $r = Reviews::where('id',$data['xf'])->first();
			   #dd($data);
			 
			if($r != null)
			{
				$r->update(['name' => $data['name'],                                                                                                                                                               
                                                      'status' => $data['status']
				
				]);
			}

                return "ok";
           }
		   
		    function createBanner($data)
           {
			   $copy = isset($data['copy']) ? $data['copy'] : "";
           	$ret = Banners::create(['img' => $data['img'], 
                                                      'title' => $data['title'], 
                                                      'subtitle' => $data['subtitle'], 
                                                      'copy' => $copy, 
                                                      'status' => $data['status'] 
                                                      ]);
                                                      
                return $ret;
           }

            function getBanners()
		   {
			   $ret = [];
			   $banners = Banners::where('id',">",'0')->get();
			   #dd($ads);
			   if(!is_null($banners))
			   {
				   foreach($banners as $b)
				   {
					   $temp = [];
					   $temp['id'] = $b->id;
					   $img = $b->img;
					   $temp['img'] = $this->getCloudinaryImage($img);
					   $temp['title'] = $b->title;
					   $temp['subtitle'] = $b->subtitle;
					   $temp['copy'] = $b->copy;
					   $temp['status'] = $b->status;
					   array_push($ret,$temp);
				   }
			   }
			   
			   return $ret;
		   }	   

		   function getBanner($id)
		   {
			   $ret = [];
			   $b = Banners::where('id',$id)->first();
			   #dd($banners);
			   if(!is_null($b))
			   {
					   $temp = [];
					   $temp['id'] = $b->id;
					   $img = $b->img;
					   $temp['img'] = $this->getCloudinaryImage($img);
					   $temp['title'] = $b->title;
					   $temp['subtitle'] = $b->subtitle;
					   $temp['copy'] = $b->copy;
					   $temp['status'] = $b->status;
					   $ret = $temp;
			   }
			   
			   return $ret;
		   }	 

            function updateBanner($data)
           {
			  $b = Banners::where('id',$data['xf'])->first();
			 
			 
			if($b != null)
			{
				$rr = ['status' => $data['status']];
				if(isset($data['img'])) $rr['img'] = $data['img'];
				$b->update($rr);
			}

                return "ok";
           }
		   
		   function deleteBanner($xf)
           {
           	$ret = [];
              $b = Banners::where('id',$xf)->first();
              
			  //dd($data);
              if($b != null)
               {
				 // $this->deleteCloudImage($pi->url);
				 $b->delete();
               }                         
                                                      
                return "ok";
           }

		   function getDashboardStats()
           {
			   $ret = [];
			   
			  //total products
			  $ret['total'] = Products::where('id','>',"0")->count();
			  $ret['enabled'] = Products::where('status',"enabled")->count();
			  $ret['disabled'] = Products::where('status',"disabled")->count();
			  $ret['o_total'] = Orders::where('id','>',"0")->count();
			  $ret['o_paid'] = Orders::where('id','>',"0")->where('status',"paid")->count();
			  $ret['o_unpaid'] = Orders::where('id','>',"0")->where('status',"unpaid")->count();
			  $ret['o_today'] = Orders::whereDate('created_at',date("Y-m-d"))->count();
			  $ret['o_month'] = Orders::whereMonth('created_at',date("m"))->count();
			
              return $ret;
           }
		   
		   function getProfits()
		   {
			   $ret = [];
			   
			    //total profits
				$ret['total'] = Orders::where('id','>',"0")->where('status',"paid")->sum('amount');
				$ret['today'] = Orders::whereDate('created_at',date("Y-m-d"))->where('status',"paid")->sum('amount');
				$ret['month'] = Orders::whereMonth('created_at',date("m"))->where('status',"paid")->sum('amount');
				
				return $ret;
		   }
		   
		   
		   function createTracking($dt)
		   {
			   $status = $dt['status'];
			   $description = $this->deliveryStatuses[$status];
			   $ret = Trackings::create(['user_id' => $dt['user_id'],
			                          'reference' => $dt['reference'],
			                          'description' => $description,
			                          'status' => $status
			                 ]);
			  return $ret;
		   }

           function getTrackings($reference="")
		   {
			   $ret = [];
			   if($reference == "") $trackings = Trackings::where('id','>',"0")->get();
			   else $trackings = Trackings::where('reference',$reference)->get();
			   
			   if(!is_null($trackings))
			   {
				  $trackings = $trackings->sortByDesc('created_at');
				   foreach($trackings as $t)
				   {
					   $temp = [];
					   $temp['id'] = $t->id;
					   $temp['user_id'] = $t->user_id;
					   $temp['reference'] = $t->reference;
					   $temp['description'] = $t->description;
					   $temp['status'] = $t->status;
					   $temp['date'] = $t->created_at->format("jS F, Y h:i A");
					   array_push($ret,$temp);
				   }
			   }
			   
			   return $ret;
		   }

		   function updateStock($s,$q)
		   {
			   $p = Products::where('sku',$s)->first();
			   
			   if($p != null)
			   {
				   $oldQty = ($p->qty == "" || $p->qty < 0) ? 0: $p->qty;
				   $qty = $p->qty - $q;
				   if($qty < 0) $qty = 0;
				   $p->update(['qty' => $qty]);
			   }
			   
			   //update product stock on catalog here
		   }
		   
		   function clearNewUserDiscount($u)
		   {
			  # dd($user);
			  if(!is_null($u))
			  {
			     $d = Discounts::where('sku',$u->id)
			                 ->where('type',"user")
							 ->where('discount',$this->newUserDiscount)->first();
			   
			     if(!is_null($d))
			     {
				   $d->delete();
			     }
			  }
		   }		   


            function addOrder($user,$data,$gid=null)
           {
			   $cart = [];
			   $gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";  
           	   $order = $this->createOrder($user, $data);
			   
                if($user == null && $gid != null) $cart = $this->getCart($user,$gid);
			 else $cart = $this->getCart($user);
			 #dd($cart);
			 
               #create order details
               foreach($cart as $c)
               {
				   $dt = [];
                   $dt['sku'] = $c['product']['sku'];
				   $dt['qty'] = $c['qty'];
				   $dt['order_id'] = $order->id;
				   $this->updateStock($dt['sku'],$dt['qty']);
                   $oi = $this->createOrderItems($dt);                    
               }

               #send transaction email to admin
               //$this->sendEmail("order",$order);  
               
			   
			   //clear cart
			   //$this->clearCart($user);
			   
			   //if new user, clear discount
			   $this->clearNewUserDiscount($user);
			   return $order;
           }

           function createOrder($user, $dt)
		   {
			   #dd($dt);
			   //$ref = $this->helpers->getRandomString(5);
			   $psref = isset($dt['ps_ref']) ? $dt['ps_ref'] : "";
			   $c = isset($dt['courier_id']) ? $dt['courier_id'] : "";
			   $pt = isset($dt['payment_type']) ? $dt['payment_type'] : "";
			  
			  if(is_null($user))
			   {
				   $gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
				   $anon = AnonOrders::create(['email' => $dt['email'],
				                     'reference' => $dt['ref'],
				                     'name' => $dt['name'],
				                     'phone' => $dt['phone'],
				                     'address' => $dt['address'],
				                     'city' => $dt['city'],
				                     'state' => $dt['state'],
				             ]);
				   
				   $ret = Orders::create(['user_id' => "anon",
			                          'reference' => $dt['ref'],
			                          'ps_ref' => $psref,
			                          'amount' => $dt['amount'],
			                          'type' => $dt['type'],
			                          'courier_id' => $c,
			                          'payment_type' => $pt,
			                          'notes' => $dt['notes'],
			                          'status' => $dt['status'],
			                 ]); 
			   }
			   
			   else
			   {
				 $ret = Orders::create(['user_id' => $user->id,
			                          'reference' => $dt['ref'],
			                          'ps_ref' => $psref,
			                          'amount' => $dt['amount'],
			                          'type' => $dt['type'],
			                          'courier_id' => $c,
			                          'payment_type' => $pt,
			                          'notes' => $dt['notes'],
			                          'status' => $dt['status'],
			                 ]);   
			   }
			   
			  return $ret;
		   }

		   function createOrderItems($dt)
		   {
			   $ret = OrderItems::create(['order_id' => $dt['order_id'],
			                          'sku' => $dt['sku'],
			                          'qty' => $dt['qty']
			                 ]);
			  return $ret;
		   }
		   
		

           function getOrderTotals($items)
           {
           	$ret = ["subtotal" => 0, "delivery" => 0, "items" => 0];
              #dd($items);
              if($items != null && count($items) > 0)
               {    
		          $oid = $items[0]['order_id'];
                 $o = Orders::where('id',$oid)->first();		   
               	foreach($items as $i) 
                    {
                    	if(count($i['product']) > 0)
                        {
						  $amount = $i['product']['pd']['amount'];
						  $qty = $i['qty'];
                      	$ret['items'] += $qty;
						  $ret['subtotal'] += ($amount * $qty);
                       }	
                    }
                   
				   $c = $this->getCourier($o->courier_id);
				   	$ret['delivery'] = isset($c['price']) ? $c['price'] : "1000";
                  
               }                                 
                                                      
                return $ret;
           }

           function getOrders()
           {
           	$ret = [];

			  $orders = Orders::where('id','>',"0")->get();
			  $orders = $orders->sortByDesc('created_at');
			  #dd($uu);
              if($orders != null)
               {
               	  foreach($orders as $o) 
                    {
                    	$temp = $this->getOrder($o->reference);
                        array_push($ret, $temp); 
                    }
               }                                 
              			  
                return $ret;
           }
		   
		   function getOrder($ref)
           {
           	$ret = [];

			  $o = Orders::where('id',$ref)
			                  ->orWhere('reference',$ref)->first();
			  #dd($uu);
              if($o != null)
               {
				  $temp = [];
                  $temp['id'] = $o->id;
                  $temp['user_id'] = $o->user_id;
                  $temp['reference'] = $o->reference;
                  $temp['amount'] = $o->amount;
                  $temp['type'] = $o->type;
				  $temp['courier_id'] = $o->courier_id;
				  $c = $this->getCourier($o->courier_id);
                  $temp['courier'] = $c;
                  $temp['payment_type'] = $o->payment_type;
                  $temp['notes'] = $o->notes;
                  $temp['status'] = $o->status;
                  $temp['current_tracking'] = $this->getCurrentTracking($o->reference);
                  $temp['items'] = $this->getOrderItems($o->id);
                  $temp['totals'] = $this->getOrderTotals( $temp['items']);
				  if($o->user_id == "anon")
				  {
						$anon = $this->getAnonOrder($o->reference,false);
						$temp['anon'] = $anon;
						$temp['totals']['delivery'] = isset($c['price']) ? $c['price'] : "1000";;  
				  }
				  else
				  {
					  $temp['user'] = $this->getUser($o->user_id);
				  }
                  $temp['date'] = $o->created_at->format("jS F, Y");
                  $ret = $temp; 
               }                                 
              		#dd($ret);	  
                return $ret;
           }


           function getOrderItems($id)
           {
           	$ret = [];

			  $items = OrderItems::where('order_id',$id)->get();
			  #dd($uu);
              if($items != null)
               {
               	  foreach($items as $i) 
                    {
						$temp = [];
                    	$temp['id'] = $i->id; 
                    	$temp['order_id'] = $i->order_id; 
                        $temp['product'] = $this->getProduct($i->sku); 
                        $temp['qty'] = $i->qty; 
                        array_push($ret, $temp); 
                    }
               }                                 
              			  
                return $ret;
           }

           function updateOrder($data)
           {
			  $o = Orders::where('id',$data['xf'])->first();
			 
			 
			if($o != null)
			{
				$dt = [
				 'status' => $data['status']
				];
				
				if($data['email'] != $data['fxx'])
				{
					$em = $data['email'];
					
					if($o->user_id == "anon")
					{
						$ao = AnonOrders::where('reference',$o->reference)->first();
						if($ao != null) $ao->update(['email' => $em]);
					}
					else
					{
						#$u = 
					}
				}
				
				$o->update($dt);
			}

                return "ok";
           }		   
		
		
		 function getPasswordResetCode($user)
           {
           	$u = $user; 
               
               if($u != null)
               {
               	//We have the user, create the code
                   $code = bcrypt(rand(125,999999)."rst".$u->id);
               	$u->update(['reset_code' => $code]);
               }
               
               return $code; 
           }
           
           function verifyPasswordResetCode($code)
           {
           	$u = User::where('reset_code',$code)->first();
               
               if($u != null)
               {
               	//We have the user, delete the code
               	$u->update(['reset_code' => '']);
               }
               
               return $u; 
           }
		   
		   function confirmPayment($id)
           {
            $o = $this->getOrder($id);
            $items = [];
            
             # dd($o);
               if(count($o) > 0)
               {
               	$items = $o['items'];
				   if($o['user_id'] == "anon")
				   {
					   $u = $o['anon'];
					   $shipping = [
					     'address' => $u['address'],
					     'city' => $u['city'],
					     'state' => $u['state']
					   ];
				   }
				   else
				   {
					   $u = $this->getUser($o['user_id']);
					   $sd = $this->getShippingDetails($u['id']);
					   $shipping = $sd[0];
				   }
				   
				  # dd($u);
               	//We have the user, update the status and notify the customer
				$oo = Orders::where('reference',$o['reference'])->first();
               	if(!is_null($oo)) $oo->update(['status' => 'paid']);
				
				//update each product stock for bank payments
				if($o["type"] == "bank")
				{
				foreach($items as $i)
               {
               	if(count($i['product']) > 0)
                   {
                   	$sku = $i['product']['sku'];
				       $qty = $i['qty'];
				       $this->updateStock($sku,$qty);                   
                   }
                   
               }
               }
               
				//$ret = $this->smtp;
				$ret = $this->getCurrentSender();
				$ret['order'] = $o;
				$ret['shipping'] = $shipping;
				$ret['name'] = $o['user_id'] == "anon" ? $u['name'] : $u['fname'];
				$ret['subject'] = "Your order has been placed via bank payment. Reference #: ".$o['reference'];
				if($o['type'] == "pod") $ret['subject'] = "Your POD order has been delivered and fully paid. Reference #: ".$o['reference'];
		        $ret['phone'] = $u['phone'];
		        $ret['em'] = $u['email'];
		        $this->sendEmailSMTP($ret,"emails.confirm-payment");
				
				//$ret = $this->smtp;
				$ret = $this->getCurrentSender();
				$ret['order'] = $o;
				$ret['shipping'] = $shipping;
				$ret['user'] = $u['email'];
				$ret['name'] = $o['user_id'] == "anon" ? $u['name'] : $u['fname']." ".$u['lname'];
				$ret['phone'] = $u['phone'];
		        $ret['subject'] = "URGENT: Received payment for order ".$o['reference']." via bank";
		        if($o['type'] == "pod") $ret['subject'] = "URGENT: Received balance for order ".$o['reference']." via POD";
		        
		        $ret['em'] = $this->adminEmail;
		        $this->sendEmailSMTP($ret,"emails.payment-alert");
				$ret['em'] = $this->suEmail;
		        $this->sendEmailSMTP($ret,"emails.payment-alert");
               }
               
               return $o; 
           }
		   
		   function deleteOrder($id)
           {
			  $o = Orders::where('id',$id)
			           ->OrWhere('reference',$id)->first();
					   
			  $a = AnonOrders::where('id',$id)
			           ->OrWhere('reference',$id)->first();
			 
			 
			if($o != null)
			{
				$items = OrderItems::where('order_id',$o->id)->get();
			    if($items != null)
                 {
                   foreach($items as $i) 
                    {
                    	$i->delete();
                    }
                }
                
                $o->delete();
				if($a != null) $a->delete();
			}

                return "ok";
           }


          function manageUserStatus($dt)
		  {
			  $user = User::where('id',$dt['id'])
			              ->orWhere('email',$dt['id'])->first();
			  
			  if($user != null)
			  {
				  $val = $dt['action'] == "enable" ? "enabled" : "disabled";
				  $user->update(['status' => $val]);
			  }
			  
			  return "ok";
		  }
		
		  function updateTracking($o,$action)
         {
         	$order = $this->getOrder($o->reference);
                    if(count($order) > 0)
                    {
                    	if($order['user_id'] == "anon")
                        {
                        	$u = $order['anon'];
                        }
                        else
                        {
                        	$u = $this->getUser($order['user_id']);
                        }
                    	$t = [
                         'user_id' => $order['user_id'],
                         'reference' => $o->reference,
                         'status' => $action
                         ];
                         
                         $this->createTracking($t);
                         
                         //$ret = $this->smtp;
						 $ret = $this->getCurrentSender();
						 #dd($ret);
				         $ret['order'] = $order;
				        $ret['tracking'] = $this->deliveryStatuses[$action];
				       $ret['name'] = $order['user_id'] == "anon" ? $u['name'] : $u['fname']." ".$u['lname'];
		               $ret['subject'] = "New update for order #".$o->reference;
		        $ret['em'] = $u['email'];
		        $this->sendEmailSMTP($ret,"emails.tracking-alert");
                    }
         }

          function bulkUpdateTracking($data)
		  {
			$dt = json_decode($data['dt']);
			$action = $data['action'];
			
			#dd($dt);
			 
			foreach($dt as $o)
            {
            	if($o->selected)
                {
                	$this->updateTracking($o,$action);
                }
            }
			  
			  
			  return "ok";
		  }	

         function getCurrentTracking($reference)
         {
         	$ret = null;
         	$trackings = $this->getTrackings($reference);
             
             if(count($trackings) > 0)
             {
             	$ret = $trackings[0];
             }
             
             return $ret;
        }

         function bulkConfirmPayment($data)
		  {
			$dt = json_decode($data['dt']);
			$action = $data['action'];
			
			#dd($dt);
			 
			foreach($dt as $o)
            {
            	if($o->selected)
                {
                	$this->confirmPayment($o->reference);
                }
            }
			  
			  
			  return "ok";
		  }		
		  
		 function bulkUpdateProducts($data)
		  {
			$dt = json_decode($data['dt']);
			$tk = $data['ftk'];
			#dd($dt);
			 $cid = env('FACEBOOK_CATALOG_ID');
		        $url = "https://graph.facebook.com/v8.0/".$cid."/batch";
				$reqs = [];
				
			foreach($dt as $p)
            {
                	$product = Products::where('sku',$p->sku)->first();
					
					if($product != null)
					{
						$dt = [];
						
						if(isset($p->qty)) $dt['qty'] = $p->qty;
						if(isset($p->name) || isset($p->origName))
						{
							if(isset($p->name)) $dt['name'] = $p->name;
							else if(isset($p->origName)) $dt['name'] = $p->origName;
						}
						$product->update($dt);
						
						//update product on catalog here
						$temp = [
		                  'method' => "UPDATE",
			              'retailer_id' => $p->sku,
			              'data' => [
			                'name' => $dt['name']
			              ]
			           ];
			           array_push($reqs,$temp);
					}
            }
			
			$dtt = [
		           'access_token' => $tk,
		           'requests' => $reqs
		       ]; 
			   $data = [
		        'type' => "json",
		        'data' => $dtt
		       ];
		       $ret = $this->callAPI($url,"POST",$data);
			   $rt = json_decode($ret);
			   #dd($rt);
			   if(isset($rt->handles))
			   {
				   $handles = $rt->handles;
				   /**
				   foreach($products as $p)
				   {
					   $pp = Products::where('sku',$p->sku)->first();
					   if($pp != null) $pp->update(['in_catalog' => "yes"]);
				   }
				  **/
			   }

			  return "ok";
		  }		  
		  
		  
	 function getAnonOrder($id,$all=true)
           {
           	$ret = [];
			if($all)
			{
				$o = AnonOrders::where('reference',$id)
			            ->orWhere('id',$id)->first();
						
               $o2 = Orders::where('reference',$id)
			            ->orWhere('id',$id)->first();
						#dd([$o,$o2]);
              if($o != null || $o2 != null)
               {
				   if($o != null)
				   {
					 $temp['name'] = $o->name; 
                       $temp['reference'] = $o->reference; 
                       //$temp['wallet'] = $this->getWallet($u);
                       $temp['phone'] = $o->phone; 
                       $temp['email'] = $o->email; 
                       $temp['address'] = $o->address; 
                       $temp['city'] = $o->city; 
                       $temp['state'] = $o->state; 
                       $temp['id'] = $o->id; 
                       #dd($o2);
                       if($o2 != null) $temp['order'] = $this->getOrder($id);
                       $temp['date'] = $o->created_at->format("jS F, Y"); 
                       $ret = $temp;  
				   }
				   else if($o2 != null)
				   {
					   $u = $this->getUser($o2->user_id);
					   $sd = $this->getShippingDetails($u['id']);
					   $shipping = $sd[0];
					   
					  if(count($u) > 0)
					   {
						 $temp['name'] = $u['fname']." ".$u['lname']; 
                         $temp['reference'] = $o2->reference;                 
                         $temp['phone'] = $u['phone']; 
                         $temp['email'] = $u['email']; 
                         $temp['address'] = $shipping['address']; 
                         $temp['city'] = $shipping['city']; 
                         $temp['state'] = $shipping['state']; 
                         $temp['id'] = $o2->id; 
                         $temp['order'] = $this->getOrder($id);
                         $temp['date'] = $o2->created_at->format("jS F, Y"); 
                         $ret = $temp;  
					   }  
				   }
                   	 
               }
			}
			
			else
			{
				$o = AnonOrders::where('reference',$id)
			            ->orWhere('id',$id)->first();
						
				if($o != null)
				   {
					 $temp['name'] = $o->name; 
                       $temp['reference'] = $o->reference; 
                       //$temp['wallet'] = $this->getWallet($u);
                       $temp['phone'] = $o->phone; 
                       $temp['email'] = $o->email; 
                       $temp['address'] = $o->address; 
                       $temp['city'] = $o->city; 
                       $temp['state'] = $o->state; 
                       $temp['id'] = $o->id; 
                       $temp['date'] = $o->created_at->format("jS F, Y"); 
                       $ret = $temp;  
				   }
			}
                                         
                                                      
                return $ret;
           }
		   
function getRandomString($length_of_string) 
           { 
  
              // String of all alphanumeric character 
              $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
  
              // Shufle the $str_result and returns substring of specified length 
              return substr(str_shuffle($str_result),0, $length_of_string); 
            } 
		   
		   function getPaymentCode($r=null)
		   {
			   $ret = "";
			   
			   if(is_null($r))
			   {
				   $ret = "ACE_".rand(1,99)."LX".rand(1,99);
			   }
			   else
			   {
				   $ret = "ACE_".$r;
			   }
			   return $ret;
		   }

    function computeTotals($items)
           {
			   //	items: "[{"ctr":0,"sku":"ACE6870LX226","qty":"5"},{"ctr":"1","sku":"ACE281LX516","qty":"4"}]",
           	$ret = 0;
			  
              if($items != null && count($items) > 0)
               {           	
               	foreach($items as $i) 
                    {
						$product = $this->getProduct($i->sku);
						$amount = $product['pd']['amount'];
						$discounts = $product['discounts'];
						#dd($discounts);
						$dsc = $this->getDiscountPrices($amount,$discounts);
						
						$newAmount = 0;
						if(count($dsc) > 0)
			            {
				          foreach($dsc as $d)
				          {
					        if($newAmount < 1)
					        {
						      $newAmount = $amount - $d;
					        }
					        else
					        {
						      $newAmount -= $d;
					        }
				          }
					      $amount = $newAmount;
			            }
						$qty = $i->qty;
                    	$ret += ($amount * $qty);
                       					
                    }
					
               }                                 
                   #dd($ret);                                  
                return $ret;
           }		   
		
	function bulkAddOrder($order)
	{
		$dt = [];
		/**
		order: 
				 {
					items: "[{"ctr":0,"sku":"ACE6870LX226","qty":"5"},{"ctr":"1","sku":"ACE281LX516","qty":"4"}]",
                    notes: "test notes",
                    user: "{"id":"anon","name":"Tobi Hay","email":"aquarius4tkud@yahoo.com","phone":"08079284917","address":"6 alfred rewane rd","city":"lokoja","state":"kogi"}" 
				 }
		**/
		$u = json_decode($order->user);
		$items = json_decode($order->items);
		$notes = $order->notes;
		
		$ref = $this->getRandomString(5);
		$dt['ref'] = $ref;
		$dt['amount'] = $this->computeTotals($items);
		$dt['notes'] = is_null($notes) ? "" : $notes;
		$dt['payment_code'] = $this->getPaymentCode($ref);
		$dt['type'] = "admin";
		$dt['payment_type'] = "admin";
		$dt['status'] = "paid";
		
		if($u->id == "anon")
		{
			$dt['name'] = $u->name;
					$dt['email'] = $u->email;
					$dt['phone'] = $u->phone;
					$dt['address'] = $u->address;
					$dt['city'] = $u->city;
					$dt['state'] = $u->state;
			$uu = null;
		}
		else
		{
			//"{"id":"16","name":"Tobi Lay","email":"testing2@yahoo.com","state":"Lagos"}",
			$uu = $u;
			$uuu = $this->getUser($u->id);
			$sd = $this->getShippingDetails($u->id);
		}
		
		 $o = $this->createOrder($uu, $dt);
		 
		 #dd($oo);
		 #create order details
               foreach($items as $i)
               {
				   $dt = [];
                   $dt['sku'] = $i->sku;
				   $dt['qty'] = $i->qty;
				   $dt['order_id'] = $o->id;
				   $this->updateStock($i->sku,$i->qty);
                   $oi = $this->createOrderItems($dt);                    
               }
               $oo = $this->getOrder($o->reference);
			   
		/*******************************************************
         //We have the user, update the status and notify the customer
				if(!is_null($o)) $o->update(['status' => 'paid']);
				//$ret = $this->smtp;
				$ret = $this->getCurrentSender();
				$ret['order'] = $oo;
				$ret['name'] = $u->name;
				$ret['subject'] = "Your payment for order ".$o->payment_code." has been confirmed!";
		        $ret['phone'] = $u->id == "anon" ? $u->phone : $uuu['phone'];
		        $ret['em'] = $u->email;
		        $this->sendEmailSMTP($ret,"emails.confirm-payment");
				*/
				//$ret = $this->smtp;
				$ret = $this->getCurrentSender();
				$ret['order'] = $oo;
				$ret['user'] = $u->email;
				$ret['name'] = $u->name;
				 $ret['phone'] = $u->id == "anon" ? $u->phone : $uuu['phone'];
		        $ret['subject'] = "URGENT: Received payment for order ".$o->reference;
		        $ret['shipping'] = $u->id == "anon" ? ['address' =>$u->address,'city' =>$u->city,'state' =>$u->state] : $sd[0];
		        $ret['em'] = $this->adminEmail;
		        $this->sendEmailSMTP($ret,"emails.bao-alert");
				$ret['em'] = $this->suEmail;
		        $this->sendEmailSMTP($ret,"emails.bao-alert");		
		/*******************************************************/ 
			   
			   
	     return $o;
	}
	
	function createSetting($data)
           {
			   #dd($data);
			 $ret = null;
			 
			 
				 $ret = Settings::create(['name' => $data['k'], 
                                                      'value' => $data['v'],                                                      
                                                      'status' => "enabled", 
                                                      ]);
			  return $ret;
           }
	
	function getSetting($id)
	{
		$temp = [];
		$s = Settings::where('id',$id)
		             ->orWhere('name',$id)->first();
 
              if($s != null)
               {
				      $temp['name'] = $s->name; 
                       $temp['value'] = $s->value;                  
                       $temp['id'] = $s->id; 
                       $temp['date'] = $s->created_at->format("jS F, Y"); 
                       $temp['updated'] = $s->updated_at->format("jS F, Y"); 
                   
               }      
       return $temp;            	   
   }
		
    function getSettings()
           {
           	$ret = [];
			  $settings = Settings::where('id','>',"0")->get();
 
              if($settings != null)
               {
				   foreach($settings as $s)
				   {
				      $temp = $this->getSetting($s->id);
                       array_push($ret,$temp); 
				   }
               }                         
                                                      
                return $ret;
           }
		   
	  function updateSetting($a,$b)
           {
			
				 $s = Settings::where('name',$a)
				              ->orWhere('id',$a)->first();
			 
			 
			 if(!is_null($s))
			 {
				 $s->update(['value' => $b]);
			  
			 }
           	
           }
		   
		function updateBank($data)
           {
			 $ret = $data->bname.",".$data->acname.",".$data->acnum;
				 $b = Settings::where('name',"bank")->first();
			 
			 
			 if(is_null($b))
			 {
				 Settings::create(['name' => "bank",'value' => $ret]);
				 
			  
			 }
			 else
			 {
				 $b->update(['value' => $ret]);
			 }
           	
           }
           
           
           function createSender($data)
           {
			   #dd($data);
			 $ret = null;
			 
			 
				 $ret = Senders::create(['ss' => $data['ss'], 
                                                      'type' => $data['type'], 
                                                      'sp' => $data['sp'], 
                                                      'sec' => $data['sec'], 
                                                      'sa' => $data['sa'], 
                                                      'su' => $data['su'], 
                                                      'current' => $data['current'], 
                                                      'spp' => $data['spp'], 
                                                      'sn' => $data['sn'], 
                                                      'se' => $data['se'], 
                                                      'status' => "enabled", 
                                                      ]);
			  return $ret;
           }

   function getSenders()
   {
	   $ret = [];
	   
	   $senders = Senders::where('id','>',"0")->get();
	   
	   if(!is_null($senders))
	   {
		   foreach($senders as $s)
		   {
		     $temp = $this->getSender($s->id);
		     array_push($ret,$temp);
	       }
	   }
	   
	   return $ret;
   }
   
   function getSender($id)
           {
           	$ret = [];
               $s = Senders::where('id',$id)->first();
 
              if($s != null)
               {
                   	$temp['ss'] = $s->ss; 
                       $temp['sp'] = $s->sp; 
                       $temp['se'] = $s->se;
                       $temp['sec'] = $s->sec; 
                       $temp['sa'] = $s->sa; 
                       $temp['su'] = $s->su; 
                       $temp['current'] = $s->current; 
                       $temp['spp'] = $s->spp; 
					   $temp['type'] = $s->type;
                       $sn = $s->sn;
                       $temp['sn'] = $sn;
                        $snn = explode(" ",$sn);					   
                       $temp['snf'] = $snn[0]; 
                       $temp['snl'] = count($snn) > 0 ? $snn[1] : ""; 
					   
                       $temp['status'] = $s->status; 
                       $temp['id'] = $s->id; 
                       $temp['date'] = $s->created_at->format("jS F, Y"); 
                       $ret = $temp; 
               }                          
                                                      
                return $ret;
           }
		   
		   
		  function updateSender($data,$user=null)
           {
			   #dd($data);
			 $ret = "error";
			 if($user == null)
			 {
				 $s = Senders::where('id',$data['xf'])->first();
			 }
			 else
			 {
				$s = Senders::where('id',$data['xf'])
			             ->where('user_id',$user->id)->first(); 
			 }
			 
			 
			 if(!is_null($s))
			 {
				 $s->update(['ss' => $data['ss'], 
                                                      'type' => $data['type'], 
                                                      'sp' => $data['sp'], 
                                                      'sec' => $data['sec'], 
                                                      'sa' => $data['sa'], 
                                                      'su' => $data['su'], 
                                                      'spp' => $data['spp'], 
                                                      'sn' => $data['sn'], 
                                                      'se' => $data['se'], 
                                                      'status' => "enabled", 
                                                      ]);
			   $ret = "ok";
			 }
           	
                                                      
                return $ret;
           }

		   function removeSender($xf,$user=null)
           {
			   #dd($data);
			 $ret = "error";
			 if($user == null)
			 {
				 $s = Senders::where('id',$xf)->first();
			 }
			 else
			 {
				$s = Senders::where('id',$xf)
			             ->where('user_id',$user->id)->first(); 
			 }
			 
			 
			 if(!is_null($s))
			 {
				 $s->delete();
			   $ret = "ok";
			 }
           
           }
		   
		   function setAsCurrentSender($id)
		   {
			   $s = Senders::where('id',$id)->first();
			   
			   if($s != null)
			   {
				   $prev = Senders::where('current',"yes")->first();
				   if($prev != null) $prev->update(['current' => "no"]);
				   $s->update(['current' => "yes"]);
			   }
		   }
		   
		   function getCurrentSender()
		   {
			   $ret = [];
			   $s = Senders::where('current',"yes")->first();
			   
			   if($s != null)
			   {
				   $ret = $this->getSender($s['id']);
			   }
			   
			   return $ret;
		   }
		   
		   function getCurrentBank()
		   {
			   $ret = [];
			   $s = Settings::where('name',"bank")->first();
			   
			   if($s != null)
			   {
				   $val = explode(',',$s->value);
				   $ret = [
				     'bname' => $val[0],
					 'acname' => $val[1],
					 'acnum' => $val[2]
				   ];
			   }
			   
			   return $ret;
		   }
		   
		   
		 function createPlugin($data)
           {
			   #dd($data);
			 $ret = null;
			 
			 
				 $ret = Plugins::create(['name' => $data['name'], 
                                                      'value' => $data['value'], 
                                                      'status' => $data['status'], 
                                                      ]);
			  return $ret;
           }

   function getPlugins()
   {
	   $ret = [];
	   
	   $plugins = Plugins::where('id','>',"0")->get();
	   
	   if(!is_null($plugins))
	   {
		   foreach($plugins as $p)
		   {
		     $temp = $this->getPlugin($p->id);
		     array_push($ret,$temp);
	       }
	   }
	   
	   return $ret;
   }
   
   function getPlugin($id)
           {
           	$ret = [];
               $p = Plugins::where('id',$id)->first();
 
              if($p != null)
               {
                   	$temp['name'] = $p->name; 
                       $temp['value'] = $p->value; 	   
                       $temp['status'] = $p->status; 
                       $temp['id'] = $p->id; 
                       $temp['date'] = $p->created_at->format("jS F, Y"); 
                       $temp['updated'] = $p->updated_at->format("jS F, Y"); 
                       $ret = $temp; 
               }                          
                                                      
                return $ret;
           }
		   
		   
		  function updatePlugin($data,$user=null)
           {
			   #dd($data);
			 $ret = "error";
			  $p = Plugins::where('id',$data['xf'])->first();
			 
			 
			 if(!is_null($p))
			 {
				 $p->update(['name' => $data['name'], 
                                                      'value' => $data['value'], 
                                                      'status' => $data['status']
                                                      ]);
			   $ret = "ok";
			 }
           	
                                                      
                return $ret;
           }

		   function removePlugin($xf,$user=null)
           {
			   #dd($data);
			 $ret = "error";
			 $p = Plugins::where('id',$xf)->first();

			 
			 if(!is_null($p))
			 {
				 $p->delete();
			   $ret = "ok";
			 }
           
           }
		   
		    function getSiteStats()
		   {
			   $totalOrders = Orders::where('id','>','0')->count();
			   $totalProducts = Products::where('id','>','0')->count();
			   $totalUsers = User::where('id','>','0')->count();
			   
			   //revenue by room category
			    $opts4 = [
								'studio' => "Studio",
												    '1bed' => "1 bedroom",
												    '2bed' => "2 bedrooms",
												    '3bed' => "3 bedrooms",
												    'penthouse' => "Penthouse apartment",
					  ];
					  
			   $rbrcData = [
			      'studio' => 0,
				  '1bed' => 0,
				  '2bed' => 0,
				  '3bed' => 0,
				  'penthouse' => 0
			   ];
			   
			   $trmData = [
			      'January' => 0,
				  'February' => 0,
				  'March' => 0,
				  'April' => 0,
				  'June' => 0,
				  'July' => 0,
				  'August' => 0,
				  'September' => 0,
				  'October' => 0,
				  'November' => 0,
				  'December' => 13000
			   ];
			   
			   $trmData3 = [];
			   
			   
			   $orders = $this->getOrders(['numeric_date' => true]);
			   
			   #dd($orders);
			   $c = 0; 
			   foreach($orders as $o)
			   {
				    #dd($o);
					++$c;
				   $items = $o['items'];
				  # $amount = $o['amount'];
				   
				   foreach($items['data'] as $i)
				   {
					   $a = $i['apartment']; $adt = $a['data'];
					   $c = $adt['category']; $amount = $i['amount'];
					   $rbrcData[$c] += $amount;
				   }
				   
				   $d = new \DateTime($o['date']); 
				   $m = $d->format("Y-m-d");
				  # dd($m);
				   if(isset($trmData3[$m]))
				   {
					   $trmData3[$m] += $o['amount'];
				   }
				   else{
					   $trmData3[$m] = $o['amount'];
				   }
			   }
			   
			   #dd($trmData3);
			   $trmData2 = [
			     '2016 Q1' => 0,
			     '2016 Q2' => 7500,
			     '2017 Q3' => 15000,
			     '2017 Q4' => 22500,
			     '2018 Q5' => 30000,
			     '2016 Q6' => 40000,
			   ];
			   /**
               { x: '2016 Q1', y: 0, },
               { x: '2016 Q2', y: 7500, },
               { x: '2017 Q3', y: 15000, },
                { x: '2017 Q4', y: 22500, },
                { x: '2018 Q5', y: 30000, },
                { x: '2018 Q6', y: 40000, }
                 **/
			   
			   $ret = [
			     'total_products' => $totalProducts,
			     'total_orders' => $totalOrders,
			     'total_users' => $totalUsers,
			     'rbrcData' => [],
			     'trmData' => [],
			     'trmData2' => [],
			     'avg_revenue' => 0,
			     'former_avg_revenue' => 0
			   ];
			   
			   return $ret;
		   }
		   
		   function hasPermission($user_id,$ps)
		   {
			   return true;
		   }
		   
   
}
?>
