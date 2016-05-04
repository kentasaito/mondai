<?php

require_once FCPATH.'vendor/autoload.php';
use \Michelf\MarkdownExtra;

function h($string, $callback = NULL)
{
	$output = htmlspecialchars($string, ENT_QUOTES);
	if (is_callable($callback))
	{
		$output = $callback($output);
	}
	echo $output;
}

function href($url)
{
	h(site_url($url));
}

function direct($url)
{
	href('application/direct/'.$url);
}

function load_view($view = NULL, $vars = NULL)
{
	$CI =& get_instance();
	if ($view === NULL)
	{
		$view = "{$CI->uri->rsegment(1)}/{$CI->uri->rsegment(2)}";
	}
	if($vars === NULL)
	{
		$vars = $CI->vars;
	}
	if ($CI->config->item('use_ajax') === TRUE && $CI->input->is_ajax_request() === TRUE && $view === 'template')
	{
		load_view('contents');
		return;
	}
	$string = $CI->load->view($view, ['vars' => $vars], TRUE);
	if (preg_match('/^docs\//', $view))
	{
		$string = MarkdownExtra::defaultTransform($string);
		$string =str_replace('<table>', '<table class="table">', $string);
	}
	echo $string;
}

function append_flash($name, $type = 'success', $data = [])
{
	$CI =& get_instance();
	$CI->session->flash = array_merge($CI->session->flash, [['name' => $name, 'type' => $type, 'data' => $data]]);
}
