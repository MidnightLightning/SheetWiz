{if $cur_user == "Anonymous"}<a href="{$web_root}/index.php/user/login?redirect={$smarty.server.PHP_SELF|escape:'url'}">Log in</a> <a href="{$web_root}/index.php/user/register">Register</a>{else}{$cur_user} <a href="{$web_root}/index.php/user/logout">Logout</a>{/if}