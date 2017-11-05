<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

	<!-- body -->
  	<body>

	<div class="corner-ribbon top-right sticky grey shadow"><?php echo $version;?></div>
	<div class="preloader-background"></div>
	<div class="progress active">
	 	<div class="indeterminate"></div>
	</div>  	

		<!-- nav -->
		<nav class="light-blue darken-4" role="navigation">
			<div class="nav-wrapper ">
				<a id="logo-container" href="http://www.agence.com.br/" class="brand-logo" target="_blank">
					<img src="<?php echo base_url();?>static/images/logo.png">
				</a>
				<ul class="right">
					<li><a href="#" class='dropdown-button light-blue darken-4' id="close-app"><i class="material-icons">exit_to_app</i></a></li>
				</ul>
	  			<a href="#" data-activates="nav-mobile" class="button-collapse top-nav hide-on-large-only"><i class="material-icons">menu</i></a>
			</div>
		</nav>
		<!-- fin nav -->

		<!-- header -->
		<header>

		  	<!-- side-nav -->
		  	<ul id="nav-mobile" class="side-nav fixed">

				<div class="user-info">
					<div class="image">
						<img src="<?php echo base_url();?>static/images/user.png" alt="User" width="64" height="64">
					</div>
					<div class="info-container">
						<div class="name" ><?php echo $author;?></div>
						<div class="email" ><?php echo $email;?></div>
					</div>
				</div>

			    <!-- option-menu -->
				<div class="option-menu">
					<li><a class="subheader">Menu Opciones</a></li>
					<li><a href="<?php echo base_url();?>" class="waves-effect option-active"><i class="material-icons">home</i>Agence</a></li>
					<li><a href="#" class="waves-effect option-disable"><i class="material-icons">assignment_turned_in</i>Projetos</a></li>
					<li><a href="#" class="waves-effect option-disable"><i class="material-icons">description</i>Administrativo</a></li>
					<li>
						<ul class="collapsible collapsible-accordion">
							<li class="bold">
								<a class="collapsible-header waves-effect option-active"><i class="material-icons">group</i>Comercial
									<div class="option-dropdown">
										<i class="material-icons">keyboard_arrow_down</i>
									</div>
								</a>
								<div class="collapsible-body">
									<ul>
										<li><a href="#">Performance Comercial</a></li>
									</ul>
								</div>
							</li>
						</ul>    
					</li>  
					<li><a href="#" class="waves-effect option-disable"><i class="material-icons">domain</i>Financeiro</a></li>
					<li><a href="#" class="waves-effect option-disable"><i class="material-icons">person</i>Usuário</a></li>
				</div>
			    <!-- fin option-menu -->			

		 	 </ul>
		  	<!-- fin side-nav -->	  

		</header>
		<!-- fin header -->


		<!-- main -->
		<main>
			<div class="container">
			  <div class="row">
				<div class="col s12 m12 l12">
					<?php echo $view;?>
				</div>
			  </div>
			</div> 
		</main>    
		<!-- fin main -->
