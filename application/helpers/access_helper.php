<?php

function is_login()
{
	$isLogin = get_instance();
	if (!$isLogin->session->userdata("user_email")) {
		redirect("auth");
	}
}

function is_admin()
{
	$isAdmin = get_instance();
	if (!$isAdmin->session->userdata("user_role") == "admin") {
		redirect(base_url());
	}
}
