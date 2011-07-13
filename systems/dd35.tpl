{extends file="layout_character.tpl"}
{block name="page_title"}{$char->get('name')}{/block}
{block name='head_content'}<link rel="stylesheet" href="{$system_root}/main.css" />{/block}
{block name='foot_content'}<script type="text/javascript" src="{$system_root}/main.js" />{/block}
{block name="body"}
<div id="content">
D&D 3.5 character
</div>
{/block}