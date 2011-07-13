{extends file="layout_dialog.tpl"}
{block name="page_title" append} - New{/block}
{block name="title"}Must be logged in!{/block}
{block name="text"}You must <a href="{$web_root}/index.php/user/login?redirect={$smarty.server.PHP_SELF|escape:'url'}">log in</a> before you can create a character.{/block}
