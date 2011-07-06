{extends file="layout.tpl"}
{block name="body"}
<h1>Create new user</h1>
{if isset($error)}<p class="error">{$error}</p>{/if}
<form action="{$smarty.server.PHP_SELF}" method="post">
Username: <input type="text" name="username" {if isset($smarty.post.username)}value="{$smarty.post.username}" {/if}/><br />
Password: <input type="password" name="passwd" /><br />
Password Confirm: <input type="password" name="passwd_verify" /><br />
<input type="submit" value="Register" />
</form>
{/block}