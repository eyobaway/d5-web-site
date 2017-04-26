<?php

/**
 * Builds a string to load required stylesheet files
 *
 * @param       array  $data    Input array
 * @return      string
 */
function load_css($data)
{
	foreach ($data as $style) 
	{
		echo '<link rel="stylesheet" href="'.base_url().'css/'.$style.'.css" />';
	}
}

/**
 * Builds a string to load required javascript files
 *
 * @param       array  $data    Input array
 * @return      string
 */
function load_js($data)
{
	foreach ($data as $script)
	{
		echo '<script type="text/javascript" src="'.base_url().'js/'.$script.'.js"></script>';
	}
}