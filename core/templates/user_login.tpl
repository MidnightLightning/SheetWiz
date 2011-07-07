{extends file="layout_main.tpl"}
{block name="body"}
<h1>Login</h1>
{if isset($error)}<p class="error">{$error}</p>{/if}
<form action="{$smarty.server.PHP_SELF}" method="post">
{if !empty($smarty.get.redirect)}<input type="hidden" name="redirect" value="{$smarty.get.redirect}" />{/if}
Username: <input type="text" name="username" {if isset($smarty.post.username)}value="{$smarty.post.username}" {/if}/><br />
Password: <input type="password" name="passwd" /><br />
<input type="submit" value="Login" />
</form>
{/block}