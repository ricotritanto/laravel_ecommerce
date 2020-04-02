@extends('layouts.ecommerce')

@section('title')
	<title>About Us</title>
@endsection

@section('content')
@include('layouts.ecommerce.module.navigation')
<!-- banner -->
<div class="banner banner10">
		<div class="container">
			<h2>Contact Us</h2>
		</div>
	</div>
	<!-- //banner -->   
	<!-- breadcrumbs -->
	<div class="breadcrumb_dress">
		<div class="container">
			<ul>
				<li><a href="{{url('/')}}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home</a> <i>/</i></li>
				<li>Contact</li>
			</ul>
		</div>
	</div>
    <!-- //breadcrumbs -->  

    <!-- mail -->
	<div class="mail">
		<div class="container">
			<h3>Mail Us</h3>
			<div class="agile_mail_grids">
				<div class="col-md-5 contact-left">
					<h4>Address</h4>
					<p>Ngemplak Barat III No 17
						<span>Tembalang, Semarang.</span></p>
					<ul>
						<li>Telephone :(+62) 81 220 888 990</li>
						<li><a href="mailto:info@example.com">info@starcctv.net</a></li>
					</ul>
				</div>
				<div class="col-md-7 contact-left">
					<h4>Contact Form</h4>
					<form action="#" method="post">
						<input type="text" name="Name" placeholder="Your Name" required="">
						<input type="email" name="Email" placeholder="Your Email" required="">
						<input type="text" name="Telephone" placeholder="Telephone No" required="">
						<textarea name="message" placeholder="Message..." required=""></textarea>
						<input type="submit" value="Submit" >
					</form>
				</div>
				<div class="clearfix"> </div>
			</div>

			<div class="contact-bottom">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1017.0561617480591!2d110.44595042918422!3d-7.01576236861973!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708c61ce8e60cf%3A0x61b66ac5560df28b!2sJl.%20Ngemplak%20Buntu%2018-12%2C%20Tandang%2C%20Kec.%20Tembalang%2C%20Kota%20Semarang%2C%20Jawa%20Tengah%2050274!5e1!3m2!1sen!2sid!4v1585642216445!5m2!1sen!2sid" frameborder="0" style="border:0" allowfullscreen></iframe>
			</div>
		</div>
	</div>
	<!-- //mail -->



@endsection