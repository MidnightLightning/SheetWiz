{extends file="layout_main.tpl"}
{block name="page_title" append} - Register{/block}
{block name="body"}
<div id="content">
<h1>Create new user</h1>
{if isset($error)}<p class="error">{$error}</p>{/if}
<form action="{$smarty.server.PHP_SELF}" method="post">
<table class="form">
<tr><th>Username:</th><td><input type="text" name="username" {if isset($smarty.post.username)}value="{$smarty.post.username}" {/if}/></td></tr>
<tr><th>Password:</th><td><input type="password" name="passwd" /></td></tr>
<tr><th>Password Confirm:</th><td><input type="password" name="passwd_verify" /></td></tr>
<tr><th>Email:</th><td><input type="text" name="email" /></td></tr>
<tr><th>&nbsp;</th><td><input type="submit" value="Register" /></td></tr>
</table>
</form>
</div>
{/block}