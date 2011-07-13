{extends file="layout_dialog.tpl"}
{block name="page_title" append} - New{/block}
{block name="title"}Character created!{/block}
{block name="text"}Character {$label} has been created. <a href="{$web_root}/index.php/characters?id={$char_id}">Edit {$label}</a>, or <a href="{$web_root}/index.php/characters/mine">list all my characters</a>.{/block}
