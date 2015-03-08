﻿<!DOCTYPE html>
<html>
<head>
    <title>socialReads</title>
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
	<style>
		.rating:hover label{
			background-position:left bottom;
		}
		label{
			background:url('http://img833.imageshack.us/img833/5959/stard.png') no-repeat left bottom;
			float:right;
			line-height:20px;	
			padding-left:20px;
			height:15px;
		}
		input:checked+label,.rating:hover label:hover,.rating:hover label:hover~label{
			background-position:0px -1px;
		}
		input:checked~label{
			background-position:0px -1px;
		}	
		input{
			display:none;
		}
		.rating{
			float:left;
		}
		
		.btn-facebook {
		  color: #ffffff;
		  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
		  background-color: #2b4b90;
		  *background-color: #133783;
		  background-image: -moz-linear-gradient(top, #3b5998, #133783);
		  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#3b5998), to(#133783));
		  background-image: -webkit-linear-gradient(top, #3b5998, #133783);
		  background-image: -o-linear-gradient(top, #3b5998, #133783);
		  background-image: linear-gradient(to bottom, #3b5998, #133783);
		  background-repeat: repeat-x;
		  border-color: #133783 #133783 #091b40;
		  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
		  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff3b5998', endColorstr='#ff133783', GradientType=0);
		  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
		}

		.btn-facebook:hover,
		.btn-facebook:focus,
		.btn-facebook:active,
		.btn-facebook.active,
		.btn-facebook.disabled,
		.btn-facebook[disabled] {
		  color: #ffffff;
		  background-color: #133783;
		  *background-color: #102e6d;
		}

		.btn-facebook:active,
		.btn-facebook.active {
		  background-color: #0d2456 \9;
		}

		.btn-twitter {
		  color: #ffffff;
		  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
		  background-color: #1c95d0;
		  *background-color: #0271bf;
		  background-image: -moz-linear-gradient(top, #2daddc, #0271bf);
		  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#2daddc), to(#0271bf));
		  background-image: -webkit-linear-gradient(top, #2daddc, #0271bf);
		  background-image: -o-linear-gradient(top, #2daddc, #0271bf);
		  background-image: linear-gradient(to bottom, #2daddc, #0271bf);
		  background-repeat: repeat-x;
		  border-color: #0271bf #0271bf #014473;
		  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
		  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff2daddc', endColorstr='#ff0271bf', GradientType=0);
		  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
		}

		.btn-twitter:hover,
		.btn-twitter:focus,
		.btn-twitter:active,
		.btn-twitter.active,
		.btn-twitter.disabled,
		.btn-twitter[disabled] {
		  color: #ffffff;
		  background-color: #0271bf;
		  *background-color: #0262a6;
		}

		.btn-twitter:active,
		.btn-twitter.active {
		  background-color: #01538d \9;
		}

		.btn-github {
		  color: #000000;
		  text-shadow: 0 0.7px 0 rgba(0, 0, 0, 0.1);
		  background-color: #f2f2f2;
		  *background-color: #e6e6e6;
		  background-image: -moz-linear-gradient(top, #fafafa, #e6e6e6);
		  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#fafafa), to(#e6e6e6));
		  background-image: -webkit-linear-gradient(top, #fafafa, #e6e6e6);
		  background-image: -o-linear-gradient(top, #fafafa, #e6e6e6);
		  background-image: linear-gradient(to bottom, #fafafa, #e6e6e6);
		  background-repeat: repeat-x;
		  border-color: #e6e6e6 #e6e6e6 #c0c0c0;
		  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
		  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fffafafa', endColorstr='#ffe6e6e6', GradientType=0);
		  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
		}

		.btn-github:hover,
		.btn-github:focus,
		.btn-github:active,
		.btn-github.active,
		.btn-github.disabled,
		.btn-github[disabled] {
		  color: #000000;
		  background-color: #e6e6e6;
		  *background-color: #d9d9d9;
		}

		.btn-github:active,
		.btn-github.active {
		  background-color: #cdcdcd \9;
		}

		.btn-pinterest {
		  color: #ffffff;
		  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
		  background-color: #c51e25;
		  *background-color: #ab171e;
		  background-image: -moz-linear-gradient(top, #d62229, #ab171e);
		  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#d62229), to(#ab171e));
		  background-image: -webkit-linear-gradient(top, #d62229, #ab171e);
		  background-image: -o-linear-gradient(top, #d62229, #ab171e);
		  background-image: linear-gradient(to bottom, #d62229, #ab171e);
		  background-repeat: repeat-x;
		  border-color: #ab171e #ab171e #680e12;
		  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
		  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffd62229', endColorstr='#ffab171e', GradientType=0);
		  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
		}

		.btn-pinterest:hover,
		.btn-pinterest:focus,
		.btn-pinterest:active,
		.btn-pinterest.active,
		.btn-pinterest.disabled,
		.btn-pinterest[disabled] {
		  color: #ffffff;
		  background-color: #ab171e;
		  *background-color: #95141a;
		}

		.btn-pinterest:active,
		.btn-pinterest.active {
		  background-color: #7e1116 \9;
		}

		.btn-linkedin {
		  color: #ffffff;
		  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
		  background-color: #60a9ce;
		  *background-color: #4393bb;
		  background-image: -moz-linear-gradient(top, #73b8db, #4393bb);
		  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#73b8db), to(#4393bb));
		  background-image: -webkit-linear-gradient(top, #73b8db, #4393bb);
		  background-image: -o-linear-gradient(top, #73b8db, #4393bb);
		  background-image: linear-gradient(to bottom, #73b8db, #4393bb);
		  background-repeat: repeat-x;
		  border-color: #4393bb #4393bb #2f6783;
		  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
		  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff73b8db', endColorstr='#ff4393bb', GradientType=0);
		  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
		}

		.btn-linkedin:hover,
		.btn-linkedin:focus,
		.btn-linkedin:active,
		.btn-linkedin.active,
		.btn-linkedin.disabled,
		.btn-linkedin[disabled] {
		  color: #ffffff;
		  background-color: #4393bb;
		  *background-color: #3c84a8;
		}

		.btn-linkedin:active,
		.btn-linkedin.active {
		  background-color: #367595 \9;
		}

		.btn-google-plus {
		  color: #ffffff;
		  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
		  background-color: #d34332;
		  *background-color: #c53727;
		  background-image: -moz-linear-gradient(top, #dd4b39, #c53727);
		  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#dd4b39), to(#c53727));
		  background-image: -webkit-linear-gradient(top, #dd4b39, #c53727);
		  background-image: -o-linear-gradient(top, #dd4b39, #c53727);
		  background-image: linear-gradient(to bottom, #dd4b39, #c53727);
		  background-repeat: repeat-x;
		  border-color: #c53727 #c53727 #85251a;
		  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
		  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffdd4b39', endColorstr='#ffc53727', GradientType=0);
		  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
		}

		.btn-google-plus:hover,
		.btn-google-plus:focus,
		.btn-google-plus:active,
		.btn-google-plus.active,
		.btn-google-plus.disabled,
		.btn-google-plus[disabled] {
		  color: #ffffff;
		  background-color: #c53727;
		  *background-color: #b03123;
		}

		.btn-google-plus:active,
		.btn-google-plus.active {
		  background-color: #9a2b1f \9;
		}

		.btn-instagram {
		  color: #ffffff;
		  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
		  background-color: #5c88ab;
		  *background-color: #3f729b;
		  background-image: -moz-linear-gradient(top, #6f97b6, #3f729b);
		  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#6f97b6), to(#3f729b));
		  background-image: -webkit-linear-gradient(top, #6f97b6, #3f729b);
		  background-image: -o-linear-gradient(top, #6f97b6, #3f729b);
		  background-image: linear-gradient(to bottom, #6f97b6, #3f729b);
		  background-repeat: repeat-x;
		  border-color: #3f729b #3f729b #294a65;
		  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
		  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff6f97b6', endColorstr='#ff3f729b', GradientType=0);
		  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
		}

		.btn-instagram:hover,
		.btn-instagram:focus,
		.btn-instagram:active,
		.btn-instagram.active,
		.btn-instagram.disabled,
		.btn-instagram[disabled] {
		  color: #ffffff;
		  background-color: #3f729b;
		  *background-color: #386589;
		}

		.btn-instagram:active,
		.btn-instagram.active {
		  background-color: #305777 \9;
		}

	</style>
</head>
<body>
	<?php if(!$this->session->userdata('validated')) redirect('login'); ?>
	<div id="navbarExample" class="navbar navbar-fixed-top">
	  <div class="navbar-inner">
		<div class="container" style="width: auto; margin-left: 20%; margin-right: 20%;">
		  <a class="brand" href="<?php echo base_url(); ?>home">socialReads</a>
		  <ul class="nav">
			<li><a href="<?php echo base_url(); ?>home"><i class="icon-home"></i> Početna</a></li>
			<li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Prijatelji<b class="caret"></b></a>
			  <ul class="dropdown-menu">
				<li><a href="<?php echo base_url(); ?>users">Novi korisnici</a></li>
				<li><a href="<?php echo base_url(); ?>users/friends">Moji prijatelji</a></li>
				<li><a href="<?php echo base_url(); ?>users/requests">Zahtjevi za prijateljstvo</a></li>
				<li><a href="<?php echo base_url(); ?>users/recommendations">Preporuke</a></li>
			  </ul>
			</li>
			<li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Knjige <b class="caret"></b></a>
			  <ul class="dropdown-menu">
				<li><a href="<?php echo base_url(); ?>books">Nove knjige</a></li>
				<li><a href="<?php echo base_url(); ?>books/recommendations">Preporuke</a></li>
			  </ul>
			</li>
			<li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Recenzije <b class="caret"></b></a>
			  <ul class="dropdown-menu">
				<li><a href="<?php echo base_url(); ?>reviews">Nove recenzije</a></li>
				<li><a href="<?php echo base_url(); ?>reviews/friends_reviews">Recenzije prijatelja</a></li>
				<li><a href="<?php echo base_url(); ?>reviews/my_reviews">Moje recenzije</a></li>
			  </ul>
			</li>
		</ul>
		<ul class="nav pull-right">
			<li>
				<form class="navbar-search" action="<?php echo base_url(); ?>books/search" method="POST">
					<input type="text" id="search" name="search" class="search-query" placeholder="Pretraga...">
				</form>
			</li>
			<li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> <?php echo $this->session->userdata('username'); ?> <b class="caret"></b></a>
			  <ul class="dropdown-menu">
				<li><a href="<?php echo base_url(); ?>users/inbox">Dolazne poruke</a></li>
				<li><a href="<?php echo base_url(); ?>users/outbox">Odlazne poruke</a></li>
				<li><a href="<?php echo base_url(); ?>users/write_message">Pošalji poruku</a></li>
				<li class="divider"></li>
				<li><a href="<?php echo base_url()."login/do_logout"; ?>">Odjava</a></li>
			  </ul>
			</li>
		 </ul>
		</div>
	  </div>
	</div>
	<br /><br /><br />