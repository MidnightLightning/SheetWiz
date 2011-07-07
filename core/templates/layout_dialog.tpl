{extends file='layout_main.tpl'}
{block name="head_meta" prepend}{assign var="body_class" value="modal_dialog"}{/block}
{block name="body"}
<div id="dialog_wrapper">
<div class="dialog">
	<h2>{block name="title"}{/block}</h2>
	<p>{block name="text"}{/block}</p>
</div>
</div>
{/block}