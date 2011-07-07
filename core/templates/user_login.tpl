{extends file="layout_main.tpl"}
{block name="page_title" append} - Login{/block}
{block name="body"}
<div id="content">
<h1>Login</h1>
{if isset($error)}<p class="error">{$error}</p>{/if}
<form action="{$smarty.server.PHP_SELF}" method="post">
{if !empty($smarty.get.redirect)}<input type="hidden" name="redirect" value="{$smarty.get.redirect}" />{/if}
<table class="form">
<tr><th>Username:</th><td><input type="text" name="username" {if isset($smarty.post.username)}value="{$smarty.post.username}" {/if}/></td></tr>
<tr><th>Password:</th><td><input type="password" name="passwd" /></td></tr>
<tr><th>&nbsp;</th><td><input type="submit" value="Login" /></td></tr>
</table>
</form>
</div>
{/block}