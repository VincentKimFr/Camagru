<?php
	require('control/controler.php');

	//phpinfo();
	//return;

	if (isset($_GET['page'])) {
	    if ($_GET['page'] == 'register_page')
	        register_page();
	    else if ($_GET['page'] == 'login_page')
	        login_page();
	    else if ($_GET['page'] == 'user_options')
	        options_page();
	    else if ($_GET['page'] == 'forgetpassword')
	        forgetpassword_page();
	    else if ($_GET['page'] == 'webcam')
	        webcam_page();
	    else {
	    	home();
	    }
	}
	else if (isset($_GET['control']) && isset($_GET['action'])) {
	    if ($_GET['control'] == 'account') {
	        if ($_GET['action'] == 'register') {
	            register_action();
	        } else if ($_GET['action'] == 'confirm') {
	        	confirm_account_action();
	        } else if ($_GET['action'] == 'login') {
	        	login_action();
	        } else if ($_GET['action'] == 'disconect') {
	        	disconect_action();
	        } else if ($_GET['action'] == 'modif_account') {
	        	modif_account_options();
	        } else if ($_GET['action'] == 'forgetpassword') {
	        	forgetpassword();
	        } else {
	        	home();
	        }
	    } else if ($_GET['control'] == 'image') {
			if ($_GET['action'] == 'uploadGallery') {
				uploadGallery();
			} else if ($_GET['action'] == 'delImage') {
				delImg();
			} else {
	        	home();
	        }
	    }
	    else {
	    	home();
	    }
	}
	else {
	    home();
	}