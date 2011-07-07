{* Smarty Template *}
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 
<head>
	<title>{block name='page_title'}{$app_name}{/block}</title>
{block name="head_meta"}
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta http-equiv="content-style-type" content="text/css" />
	<meta name="ROBOTS" content="{if !empty($meta_robots)}{$meta_robots}{else}INDEX,FOLLOW{/if}" />{if !empty($meta_desc)}
	<meta name="description" content="{$meta_desc}" />{/if}
{/block}
	<link rel="shortcut icon" type="image/x-icon" href="{$web_root}/img/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.3.0/build/cssreset/reset-min.css">
	<link rel="stylesheet" href="{$web_root}/inc/main.css" />
	{block name='head_content'}{/block}
</head>
<body{if !empty($body_class)} class="{$body_class}"{/if}>
{include file='interface_nav.tpl'}
{block name="body"}{/block}

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script>!window.jQuery && document.write(unescape('%3Cscript src="{$web_root}inc/jquery-1.6.2.min.js"%3E%3C/script%3E'))</script>
{block name='foot_content'}{/block}
</body>
</html>