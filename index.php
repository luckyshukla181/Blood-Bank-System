<?php
?>
<?php

session_start ();
// if user has come here after completing a shopping, clear session data
if (isset ( $_SESSION ['order_pending'] ) && $_SESSION ['order_pending'] == "false") {
	unset ( $_SESSION ['order_pending'] );
	unset ( $_SESSION ['products'] );
}
include_once 'utils/DB.php';
include_once 'utils/config.php';
function feat_product($id, $name, $description) {
	echo '<div class="feat_prod_box">';
	echo '<div class="prod_det_box">';
	echo '<div class="box_top"></div>';
	echo '<div class="box_center">';
	echo '<div class="prod_title">' . $name . '</div>';
	echo '<p class="details">' . $description . '</p>';
	echo '<a href="view_product.php?product_id=' . $id . '" class="more">- Add to cart -</a>';
	echo '<div class="clear"></div>';
	echo '</div>';
	echo '<div class="box_bottom"></div>';
	echo '</div>';
	echo '<div class="clear"></div>';
	echo '</div>';
}
?>
 <!DOCTYPE html>
  <html lang="en-US">
     <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
        <title>donatelife.com</title>
		<link rel="stylesheet" href="css/components.css">
        <link rel="stylesheet" href="css/cool.css">
      <link rel="stylesheet" href="owl-carousel/owl.carousel.css">
        <link rel="stylesheet" href="owl-carousel/owl.theme.css">
        <link rel="stylesheet" href="css/jquery-ui.min.css">
		
        <link rel="stylesheet" type="text/css" href="style.css" />

        <!-- CUSTOM STYLE -->
        <link rel="stylesheet" href="css/rj-style.css">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
      <script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui.min.js"></script>
         <script type="text/javascript" src="js/modernizr.js"></script>
        <script type="text/javascript" src="js/cool.js"></script>
         <script type="text/javascript" src="js/rj-scripts.js"></script>
        <script type="text/javascript" src="js/jquery.min.js"></script>
         <script type="text/javascript" src="js/jquery-ui.min.js"></script>




     </head>
     <body class="size-1140" style="font-size:15px" >

    <div id="bg">
    <img style="background-color: #00283a; alt="">
  </div>

        <!-- TOP NAV WITH LOGO -->
        <header>
           <div id="topbar">
              <div class="line" style=" ">
                 <div class="s-12 m-6 l-6">
                    <p>CONTACT US: <strong>9791037530</strong> | <strong>rahul.shu999@gmail.com</strong></p>
                 </div>
                 <div class="s-12 m-6 l-6">
                    <div class="social right">
                       <a><i class="icon-facebook_circle"></i></a> <a><i class="icon-twitter_circle"></i></a> <a><i class="icon-google_plus_circle"></i></a> <a><i class="icon-instagram_circle"></i></a>
                    </div>
                 </div>
              </div>
           </div>
           <nav>
              <div class="line">
                 <div class="s-12 l-2">
                    <p class="logo"><strong>DONATE </strong> LIFE</p>
                 </div>
                 <div class="top-nav s-12 l-10">
                    <p class="nav-text"> Menu</p>
                     <ul class="right">
                       <li class="active-item"><a href="#carousel">Home</a></li>
                       <li><a href="#Donating-Blood">Donating <br/> Blood</a></li>
                       <li><a href="#needblood">Need <br/> Blood </a></li>
                       <li><a href="#blood-stock">Blood <br/> Stock </a></li>
                      <li><a href="#latest-news">News <br/> Events</a> </li>
                       <li><a href="#about-us">About <br/> Us</a></li>
                       <li><a href="#first-block">Join <br/>Us</a></li>  <!-- for hospital registration-->
                       <li><a href="#contact">Contact <br/> Us</a></li>
                     </ul>
                 </div>
              </div>
           </nav>
        </header>  
        <section>
           <!-- CAROUSEL  -->
           <div id="carousel">
              <div id="owl-demo" class="owl-carousel owl-theme"> 
                 <div class="item" style="background-color:#281F9A">
                    <img src="img/first.jpg" alt="">
                    <div class="line"> 
                       <div class="text hide-s">
                          <div class="line"> 
                            <div class="prev-arrow hide-s hide-m">
                               <i class="icon-chevron_left"></i>
                            </div>
                            <div class="next-arrow hide-s hide-m">
                               <i class="icon-chevron_right"></i>
                            </div>
                          </div> 
                          <h2> A Way For Safer Tommorrow.</h2>
                          <p>Safer, by bringing blood donors and those in need to a common platform.</p>
                       </div>
                    </div>
                 </div>
                 <div class="item">
                    <img src="img/second.jpg" alt="">
                    <div class="line">
                       <div class="text hide-s"> 
                          <div class="line"> 
                            <div class="prev-arrow hide-s hide-m">
                               <i class="icon-chevron_left"></i>
                            </div>
                            <div class="next-arrow hide-s hide-m">
                               <i class="icon-chevron_right"></i>
                            </div>
                          </div>
                          <h2>Our aim in next 5 years,</h2>
                          <p>To be the real hope of every Indian in search of a voluntary blood donor and blood banks.</p>
                       </div>
                    </div>
                 </div>
                 <div class="item">
                    <img src="img/third.jpg" alt="">
                    <div class="line">
                       <div class="text hide-s">
                          <div class="line"> 
                            <div class="prev-arrow hide-s hide-m">
                               <i class="icon-chevron_left"></i>
                            </div>
                            <div class="next-arrow hide-s hide-m">
                               <i class="icon-chevron_right"></i>
                            </div>
                          </div>
                          <h2>We have a mission:</h2>
                          <p>To make the best use of contemporary technologies in delivering a promising web portal to bring together all the blood donors and blood banks in India; thereby fulfilling every blood request in the country.</p>
                       </div>
                    </div>
                 </div>
              </div>
           </div>

           <!-- Donating Blood -->
           <div id="Donating-Blood">
              <div class="line">
                 <!-- <h2 class="section-title">Donating Blood Myth And Truth</h2> -->
                 <div class="tabs">
                    <div class="tab-item tab-active">
                      <a class="tab-label active-btn">Why Give Blood?</a>
                      <div class="tab-content">
                        <div class="margin">

                        <div class="s-12 m-6 l-3"><a class="Donating-Blood-container lightbox margin-bottom"><img src="img/por3.jpg" alt=""></a></div>
                          <div class="s-12 m-6 l-3"><a class="Donating-Blood-container lightbox margin-bottom">Donated blood is a lifeline for many people needing long-term treatments, not just in emergencies. Your blood's main components: red cells, plasma and platelets are vital for many different uses.</a></div>
                          <div class="s-12 m-6 l-3"><a class="Donating-Blood-container lightbox margin-bottom"><p>Red cells are used predominantly in treatments for cancer and blood diseases, as well as for treating anaemia and in surgeries for transplants and burns. Plasma provides proteins, nutrients and a clotting agent that is vital to stop bleeding - it is the most versatile component of your blood. Platelets are tiny cells used to help patients at a high risk of bleeding. They also contribute to the repair of damaged body tissue.</p></a></div>
                          <div class="s-12 m-6 l-3"><a class="Donating-Blood-container lightbox margin-bottom"><p> Maintaining a regular supply of blood to all the people who need it is not easy. Blood components have a short shelf life and predicting demand can be difficult.
  <br/><br/>
  Red cells - up to 35 days
  <br/>

  Plasma - up to one year
  <br/>Platelets - up to seven days </p></a></div>
                          
                        </div>
                      </div>  
                    </div>
                    <div class="tab-item">
                      <a class="tab-label">Who can give blood?</a>
                      <div class="tab-content">
                        <div class="margin">
                          <div class="s-12 m-6 l-3"><a class="Donating-Blood-container lightbox margin-bottom"><img src="img/por7.jpg" alt=""></a></div>
                          <div class="s-12 m-6 l-3"><a class="Donating-Blood-container lightbox margin-bottom"><p>Most people can give blood. As long as you are fit and healthy, weigh over 7 stone 12 lbs (50kg) and are aged between 17 and 66 (up to 70 if you have given blood before) you should be able to give blood. If you are over 70, you need to have given blood in the last two years to continue donating.</p></a></div>
                          <div class="s-12 m-6 l-3"><a class="Donating-Blood-container lightbox margin-bottom"><p> If you are female, aged under 20 years old and weigh under 65kg (10st 3lb) and are under 168cm (5' 6") in height, we need to estimate your blood volume before donating.
                          </p></a></div>
                          <div class="s-12 m-6 l-3"><a class="Donating-Blood-container lightbox margin-bottom"><p>Male donors can give blood every 12 weeks. That's approximately every 3 months or 4 times in a 12 month period. Female donors can give every 16 weeks or approximately every 4 months.</p></a></div>
                        </div>
                      </div>  
                    </div>
                    <div class="tab-item">
                      <a class="tab-label"> Who Can't Give Blood?</a>
                      <div class="tab-content">
                        <div class="margin">
                          <div class="s-12 m-6 l-3"><a class="Donating-Blood-container lightbox margin-bottom"><img src="img/por4.jpg" alt=""></a></div>
                          <div class="s-12 m-6 l-3"><a class="Donating-Blood-container lightbox margin-bottom"><p> if evidence suggests that donating blood could potentially harm you, then to protect your safety we would recommend you not to donate.</p></a></div>
                          <div class="s-12 m-6 l-3"><a class="Donating-Blood-container lightbox margin-bottom"><p> if evidence suggests that your donation could potentially harm the patient receiving it, then we would ask you not to donate. </p></a></div>
                          <div class="s-12 m-6 l-3"><a class="Donating-Blood-container lightbox margin-bottom"><p> If you are not able to give blood we know this can be disappointing. However, we hope you will understand that our overriding responsibility is to ensure the safety of donors and the safety of blood for patients.</p></a></div>
                        </div>
                      </div>  
                    </div>
                    <div class="tab-item">
                      <a class="tab-label"> Putting safety first</a>
                      <div class="tab-content">
                        <div class="margin">
                          <div class="s-12 m-6 l-3"><a class="Donating-Blood-container lightbox margin-bottom"><img src="img/por4.jpg" alt=""></a></div>
                         <div class="s-12 m-6 l-3"><a class="Donating-Blood-container lightbox margin-bottom"><p>The Donor Health Check (DHC) is designed to helps us spot potential problems for donor and patient. Together with the medical screening we carry out at every session, we can assess if it's safe for someone to donate that day.</p></a></div>       
                          <div class="s-12 m-6 l-3"><a class="Donating-Blood-container lightbox margin-bottom"><P>  Next line of defence is ensuring the staff follow best practice guidelines on things such as arm cleaning. And of course, back in labs ,test every donation to pick up any dangerous infections.</P></a></div>
                          
                          <div class="s-12 m-6 l-3"><a class="Donating-Blood-container lightbox margin-bottom"><P> scientists check every donation for a number of different infections. Very occasionally the tests fail to detect one that is present, especially if it's very recent. The blood may be infectious to a patient, but tests could not find the infection (it's called the window period). That's why the DHC questions are so vital to help us spot the risk.</P></a></div>
                        </div>
                      </div>
                    </div>

                    
                 </div>
              </div>
           </div> 

           <!-- needblood -->
           <div id="needblood">
                   <div class="margin " style="">
                         <div class="line">
                 <!-- <h2 class="section-title">Donating Blood Myth And Truth</h2> -->
                           <div class="tabs">
                  
                    <div class="tab-item tab-active">
                      <a class="tab-label active-btn">Post Your Blood Request</a>
                      <div class="tab-content">
                               
                                       <div class="line">

                                 <div class="s-12 l-12 " style="padding:1em 1em;" >
                                       <div class="box" align="center" style="background-color: #6f9600; color: #FFFFFF;" >
                                           <h1 class=" s-12" style="color: #F8F7F7; text-transform: uppercase; align-content:center" > Blood request form </h1>

                                          



                                           
                                           <p style="padding:0em 2em; color: #F8F7F7; font-size:16px;"> Fill the Blood Request Form Completely to post your blood request. We will find  the best way to fullfill your request <br/> 
  <strong> Our responce deadline is 48 hours.  <br/>For updates : login with your genrated Request ID and name as password .   </strong>      <br/>  <br/>                      For finding a Blood Bank or a Donor Manually please switch to respective tabs.
                                           
                                           </p>
                                           
                                           <a class="white-btn" href="myaccount.php" style="font-size:14px" > Click For Blood Request Form </a>
                                       </div>
                                 </div>
                               
                        </div>

                               


                      </div>
                    </div>
                 
                            </div>
                         </div>
                  </div>   
                         
           </div>


           <!-- Blood Stock -->
           <div id="blood-stock">
               <div class="line">

                       <h1 > THIS IS OUR BLOOD STOCK </h1>
                        <!--<div class="s-12 m-4 l-2 center">-->

                                   <?php
				$sql = "select productID,name,description from product limit 6 ";
				$conn = Database::connect ();
				$stmt = $conn->prepare ( $sql );
				$result = $stmt->execute ();
				if ($result) {
					foreach ( $stmt->fetchAll ( PDO::FETCH_FUNC, 'feat_product' ) as $row ) {
						echo $row;
					}
				}
				
				?>

                </div>

               </div>
           </div>

           <!-- LATEST NEWS -->
           <div id="latest-news">
              <div class="line">
              <div class="margin">
                <h2 class="section-title">Latest News</h2>

                  <div class="s-12 m-6 l-6">
                    <div class="s-12 l-2">
                      <div class="news-date">
                        <p class="day">20</p><p class="month">SEPTEMBER</p><p class="year">2015</p>
                      </div>
                    </div>
                    <div class="s-12 l-10">     <div class="news-text"  >   <h4>First latest News</h4>
                        <p>We organized our first blood donation camp in Noida Sector 19A.</p>
                      </div>
                    </div>
               </div>

                  <div class="s-12 m-6 l-6">
                    <div class="s-12 l-2">
                      <div class="news-date">
                        <p class="day">12</p><p class="month">NOVEMBER</p><p class="year">2015</p>
                      </div>
                    </div>
                    <div class="s-12 l-10">
                      <div class="news-text">
                        <h4>Second latest News</h4>
                        <p>Do Not take blood without testing.</p>
                      </div>
                    </div>   
                  </div>
                </div>
              </div>
            </div>
           <!-- About-Us -->
           <div id="about-us">
              <div class="s-12 m-6 l-6 media-container">
                 <img src="img/about.jpg" alt="">
              </div>
              <article class="s-12 m-12 l-6">
                 <h2>We are<br> Social <br> Heroes</h2>
                 <p>Have you at anytime witnessed a relative of yours or a close friend searching frantically for a blood donor,
                  when blood banks say out of stock, the donors in mind are out of reach and the time keeps ticking? Have you 
                  witnessed loss of life for the only reason that a donor was not available at the most needed hour? 
                  Is it something that we as a society can do nothing to prevent? This thought laid our foundation.

<br/> "DonateLife" is an organization that brings different blood bank and those in need of blood on to a common platform.  
Through this website, provide the timeliest support to those in frantic need of blood.
                 </p>
                 <div class="about-us-icons">
                    <i class="icon-paperplane_ico"></i> <i class="icon-trophy"></i> <i class="icon-clock"></i>
                 </div>
              </article>
           </div>

           <!-- FIRST BLOCK -->
           <div id="first-block" style="">
              <div class="line">
                 
                 <p style="color: #F8F8F8; font-size: 20px;">You can be one of 100000000 registered donors on DonateLife.com </p>
                 <!--<p>DonateLife.com is a non-profit, non-commercial interface was born out of our social commitment and our desire to use the power of the Internet to help common people.</p> -->
                 <h1>Are you ready to save a life?</h1>
                 <div class="s-12 m-4 l-2 center"><a class="white-btn" href="supplier/supp_home.php">Register Here</a></div>
              </div>
           </div>

           <!-- CONTACT -->
           <div id="contact">
              <div class="line">
                 <h2 class="section-title">Contact Us</h2>
                 <div class="margin">
                    <div class="s-12 m-12 l-3 hide-m hide-s margin-bottom right-align">
                      <img src="img/contact.jpg" alt="">
                    </div>
                    <div class="s-12 m-12 l-4 margin-bottom right-align">
                       <h3>DONATELIFE-TEAM</h3>
                       <address>
                          <p><span>Adress:  </span> Sectro 19A, Noida</p>
                          <p><span>Country:  </span> INDIA - ASIA</p>
                          <p><span>E-mail:  </span> rahul.shu999@gmail.com</p>
                       </address>
                       <br />
                       <h3>Social</h3>
                       <p><i class="icon-facebook icon"></i> <a href="https://www.facebook.com/">DonateLife@.facebook.com</a></p>
                       <p><i class="icon-facebook icon"></i> <a href="https://www.googleplus.com/">DonateLife@googleplus</a></p>
                       <p class="margin-bottom"><i class="icon-twitter icon"></i> <a href="https://twitter.com/rakesh609">DonateLife@twitter.com 'A Social Organisation'</a></p>
                    </div>
                    <div class="s-12 m-12 l-5">
                      <h3>   CONTACT 
                           -FEEDBACK </h3>
                      <form class="customform" action="">
                        <div class="s-12"><input name="" placeholder="Your e-mail" title="Your e-mail" type="text" /></div>
                        <div class="s-12"><input name="" placeholder="Your name" title="Your name" type="text" /></div>
                        <div class="s-12"><textarea placeholder="Your massage" name="" rows="5"></textarea></div>
                        <div class="s-12 m-12 l-4"><button class="color-btn" type="submit">Submit Button</button></div>
                      </form>
                    </div>
                 </div>
              </div>
           </div>
        </section>
        <!-- FOOTER -->
        <footer>
           <div class="line">
              <div class="s-12 l-6" style="color:#FFFFFF">
                 <p>Copyright 2017, DonateLife-Team </p>
                 <p>All right reserved</p>
              </div>
              <div class="s-12 l-6">
                 <a class="right" href="#" title="#" style="color:#FFFFFF">Design and coding<br> by Rahul </a>
              </div>
           </div>
        </footer>
        
        <script type="text/javascript" src="owl-carousel/owl.carousel.js"></script>
        <script type="text/javascript">
                   jQuery(document).ready(function($) {



              var theme_slider = $("#owl-demo");
              $("#owl-demo").owlCarousel({
                  navigation: false,
                  slideSpeed: 300,
                  paginationSpeed: 400,
                  autoPlay: 6000,
                  addClassActive: true,
                  transitionStyle: "fade",
                  singleItem: true
              });
             

              // Custom Navigation Events
              $(".next-arrow").click(function() {
                  theme_slider.trigger('owl.next');
              })
              $(".prev-arrow").click(function() {
                  theme_slider.trigger('owl.prev');
              })

                       

          });






        </script>
     </body>
  </html>
