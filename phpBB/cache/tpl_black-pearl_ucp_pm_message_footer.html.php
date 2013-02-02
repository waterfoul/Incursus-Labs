<?php if (!defined('IN_PHPBB')) exit; if (! $this->_rootref['S_VIEW_MESSAGE']) {  ?>

	<?php echo (isset($this->_rootref['S_FORM_TOKEN'])) ? $this->_rootref['S_FORM_TOKEN'] : ''; ?>

	</form>
<?php } ?>


<div><div class="tbl-h-l"><div class="tbl-h-r"><div class="tbl-h-c"><div class="tbl-title">&nbsp;<?php echo (isset($this->_rootref['PAGE_TITLE'])) ? $this->_rootref['PAGE_TITLE'] : ''; ?>&nbsp;</div></div></div></div>
<table class="tablebg" width="100%" cellpadding="0" cellspacing="0">
<tr>
	<td class="row1">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_BEGIN'])) ? $this->_rootref['S_CONTENT_FLOW_BEGIN'] : ''; ?>"><?php $this->_tpl_include('pagination.html'); if ($this->_rootref['S_VIEW_MESSAGE']) {  ?>

					<span class="gensmall">
						<?php if ($this->_rootref['U_PRINT_PM']) {  ?><a href="<?php echo (isset($this->_rootref['U_PRINT_PM'])) ? $this->_rootref['U_PRINT_PM'] : ''; ?>" title="<?php echo ((isset($this->_rootref['L_PRINT_PM'])) ? $this->_rootref['L_PRINT_PM'] : ((isset($user->lang['PRINT_PM'])) ? $user->lang['PRINT_PM'] : '{ PRINT_PM }')); ?>"><?php echo ((isset($this->_rootref['L_PRINT_PM'])) ? $this->_rootref['L_PRINT_PM'] : ((isset($user->lang['PRINT_PM'])) ? $user->lang['PRINT_PM'] : '{ PRINT_PM }')); ?></a><?php if ($this->_rootref['U_FORWARD_PM']) {  ?>&nbsp;|&nbsp;<?php } } if ($this->_rootref['U_FORWARD_PM']) {  ?><a href="<?php echo (isset($this->_rootref['U_FORWARD_PM'])) ? $this->_rootref['U_FORWARD_PM'] : ''; ?>" title="<?php echo ((isset($this->_rootref['L_FORWARD_PM'])) ? $this->_rootref['L_FORWARD_PM'] : ((isset($user->lang['FORWARD_PM'])) ? $user->lang['FORWARD_PM'] : '{ FORWARD_PM }')); ?>"><?php echo ((isset($this->_rootref['L_FORWARD_PM'])) ? $this->_rootref['L_FORWARD_PM'] : ((isset($user->lang['FORWARD_PM'])) ? $user->lang['FORWARD_PM'] : '{ FORWARD_PM }')); ?></a><?php } if ($this->_rootref['U_POST_REPLY_PM']) {  ?>&nbsp;|&nbsp;<a href="<?php echo (isset($this->_rootref['U_POST_REPLY_PM'])) ? $this->_rootref['U_POST_REPLY_PM'] : ''; ?>" title="<?php echo ((isset($this->_rootref['L_POST_REPLY_PM'])) ? $this->_rootref['L_POST_REPLY_PM'] : ((isset($user->lang['POST_REPLY_PM'])) ? $user->lang['POST_REPLY_PM'] : '{ POST_REPLY_PM }')); ?>"><?php echo ((isset($this->_rootref['L_POST_REPLY_PM'])) ? $this->_rootref['L_POST_REPLY_PM'] : ((isset($user->lang['POST_REPLY_PM'])) ? $user->lang['POST_REPLY_PM'] : '{ POST_REPLY_PM }')); ?></a><?php } if ($this->_rootref['U_POST_REPLY_PM'] && $this->_rootref['S_PM_RECIPIENTS'] > (1)) {  if ($this->_rootref['U_PRINT_PM'] || $this->_rootref['U_FORWARD_PM']) {  ?>&nbsp;|&nbsp;<?php } ?><a title="<?php echo ((isset($this->_rootref['L_REPLY_TO_ALL'])) ? $this->_rootref['L_REPLY_TO_ALL'] : ((isset($user->lang['REPLY_TO_ALL'])) ? $user->lang['REPLY_TO_ALL'] : '{ REPLY_TO_ALL }')); ?>" href="<?php echo (isset($this->_rootref['U_POST_REPLY_ALL'])) ? $this->_rootref['U_POST_REPLY_ALL'] : ''; ?>"><?php echo ((isset($this->_rootref['L_REPLY_TO_ALL'])) ? $this->_rootref['L_REPLY_TO_ALL'] : ((isset($user->lang['REPLY_TO_ALL'])) ? $user->lang['REPLY_TO_ALL'] : '{ REPLY_TO_ALL }')); ?></a><?php } ?>

					</span>
				<?php } ?>

			</td>
			<td align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>" nowrap="nowrap">
				<?php if ($this->_rootref['S_VIEW_MESSAGE']) {  if (! $this->_rootref['S_SPECIAL_FOLDER']) {  ?>

						<form name="movepm" method="post" action="<?php echo (isset($this->_rootref['S_PM_ACTION'])) ? $this->_rootref['S_PM_ACTION'] : ''; ?>" style="margin:0px">
							<input type="hidden" name="marked_msg_id[]" value="<?php echo (isset($this->_rootref['MSG_ID'])) ? $this->_rootref['MSG_ID'] : ''; ?>" />
							<input type="hidden" name="cur_folder_id" value="<?php echo (isset($this->_rootref['CUR_FOLDER_ID'])) ? $this->_rootref['CUR_FOLDER_ID'] : ''; ?>" />
							<input type="hidden" name="p" value="<?php echo (isset($this->_rootref['MSG_ID'])) ? $this->_rootref['MSG_ID'] : ''; ?>" />
							<select name="dest_folder"><?php echo (isset($this->_rootref['S_TO_FOLDER_OPTIONS'])) ? $this->_rootref['S_TO_FOLDER_OPTIONS'] : ''; ?></select>&nbsp;<input class="btnlite" type="submit" name="move_pm" value="<?php echo ((isset($this->_rootref['L_MOVE_TO_FOLDER'])) ? $this->_rootref['L_MOVE_TO_FOLDER'] : ((isset($user->lang['MOVE_TO_FOLDER'])) ? $user->lang['MOVE_TO_FOLDER'] : '{ MOVE_TO_FOLDER }')); ?>" />
						<?php echo (isset($this->_rootref['S_FORM_TOKEN'])) ? $this->_rootref['S_FORM_TOKEN'] : ''; ?>

						</form>
					<?php } } else { ?>

					<form name="sortmsg" method="post" action="<?php echo (isset($this->_rootref['S_PM_ACTION'])) ? $this->_rootref['S_PM_ACTION'] : ''; ?>" style="margin:0px">
						<span class="gensmall"><?php echo ((isset($this->_rootref['L_DISPLAY_MESSAGES'])) ? $this->_rootref['L_DISPLAY_MESSAGES'] : ((isset($user->lang['DISPLAY_MESSAGES'])) ? $user->lang['DISPLAY_MESSAGES'] : '{ DISPLAY_MESSAGES }')); ?>:</span> <?php echo (isset($this->_rootref['S_SELECT_SORT_DAYS'])) ? $this->_rootref['S_SELECT_SORT_DAYS'] : ''; ?> <span class="gensmall"><?php echo ((isset($this->_rootref['L_SORT_BY'])) ? $this->_rootref['L_SORT_BY'] : ((isset($user->lang['SORT_BY'])) ? $user->lang['SORT_BY'] : '{ SORT_BY }')); ?></span> <?php echo (isset($this->_rootref['S_SELECT_SORT_KEY'])) ? $this->_rootref['S_SELECT_SORT_KEY'] : ''; ?> <?php echo (isset($this->_rootref['S_SELECT_SORT_DIR'])) ? $this->_rootref['S_SELECT_SORT_DIR'] : ''; ?> <input class="btnlite" type="submit" name="sort" value="<?php echo ((isset($this->_rootref['L_GO'])) ? $this->_rootref['L_GO'] : ((isset($user->lang['GO'])) ? $user->lang['GO'] : '{ GO }')); ?>" />
					<?php echo (isset($this->_rootref['S_FORM_TOKEN'])) ? $this->_rootref['S_FORM_TOKEN'] : ''; ?>

					</form>
				<?php } ?>

			</td>
		</tr>
		</table>
	</td>
</tr>
<tr><td class="cat-bottom">&nbsp;</td></tr>
</table>
<div class="tbl-f-l"><div class="tbl-f-r"><div class="tbl-f-c">&nbsp;</div></div></div></div>

<?php if (! $this->_rootref['S_VIEW_MESSAGE']) {  ?>

	<div style="float: <?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>;"><b class="gensmall"><a href="#" onclick="marklist('viewfolder', 'marked_msg_id', true); return false;"><?php echo ((isset($this->_rootref['L_MARK_ALL'])) ? $this->_rootref['L_MARK_ALL'] : ((isset($user->lang['MARK_ALL'])) ? $user->lang['MARK_ALL'] : '{ MARK_ALL }')); ?></a> :: <a href="#" onclick="marklist('viewfolder', 'marked_msg_id', false); return false;"><?php echo ((isset($this->_rootref['L_UNMARK_ALL'])) ? $this->_rootref['L_UNMARK_ALL'] : ((isset($user->lang['UNMARK_ALL'])) ? $user->lang['UNMARK_ALL'] : '{ UNMARK_ALL }')); ?></a></b></div>
<?php } ?>