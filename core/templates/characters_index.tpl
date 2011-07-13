{extends file="layout_main.tpl"}
{block name="page_title" append} - Characters{/block}
{block name="body"}
<div id="content">
<h1>Characters</h1>
<ul>
	<li><a href="{$web_root}/index.php/characters/mine">My characters</a></li>
	<li><a href="{$web_root}/index.php/characters/visible">Public characters</a></li>
	<li><a href="{$web_root}/index.php/characters/new">New character</a></li>
</ul>
</div>
{/block}