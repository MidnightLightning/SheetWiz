{extends file="layout_main.tpl"}
{block name="page_title" append} - New{/block}
{block name="body"}
<div id="content">
<h1>Create new character</h1>
{if isset($error)}<p class="error">{$error}</p>{/if}
<form action="{$smarty.server.PHP_SELF}" method="post">
<table class="form">
<tr><th>Label:</th><td><input type="text" name="label" {if isset($smarty.post.label)}value="{$smarty.post.label}" {/if}/></td></tr>
<tr><th>System:</th><td>{html_options options=$systems name="system"}</td></tr>
<tr><th>&nbsp;</th><td><input type="submit" value="Create" /></td></tr>
</table>
</form>
</div>
{/block}