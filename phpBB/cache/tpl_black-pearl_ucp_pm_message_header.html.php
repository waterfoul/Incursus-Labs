<?php if (!defined('IN_PHPBB')) exit; ?><div><div class="tbl-h-l"><div class="tbl-h-r"><div class="tbl-h-c"><div class="tbl-title">&nbsp;</div></div></div></div>
<table class="tablebg" width="100%" cellpadding="0" cellspacing="0">
<tr>
	<td class="row1">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_BEGIN'])) ? $this->_rootref['S_CONTENT_FLOW_BEGIN'] : ''; ?>">
			<?php if ($this->_rootref['TOTAL_MESSAGES']) {  ?>

				<table width="100%" cellspacing="1">
				<tr>
					<td class="nav" valign="middle" nowrap="nowrap">&nbsp;<?php echo (isset($this->_rootref['PAGE_NUMBER'])) ? $this->_rootref['PAGE_NUMBER'] : ''; ?><br /></td>
					<?php if ($this->_rootref['FOLDER_MAX_MESSAGES'] != 0) {  ?>

						<td class="gensmall" nowrap="nowrap" width="100%">&nbsp;[ <b><?php echo (isset($this->_rootref['FOLDER_CUR_MESSAGES'])) ? $this->_rootref['FOLDER_CUR_MESSAGES'] : ''; ?></b>/<?php echo (isset($this->_rootref['FOLDER_MAX_MESSAGES'])) ? $this->_rootref['FOLDER_MAX_MESSAGES'] : ''; ?> <?php echo ((isset($this->_rootref['L_MESSAGES'])) ? $this->_rootref['L_MESSAGES'] : ((isset($user->lang['MESSAGES'])) ? $user->lang['MESSAGES'] : '{ MESSAGES }')); ?> (<?php echo (isset($this->_rootref['FOLDER_PERCENT'])) ? $this->_rootref['FOLDER_PERCENT'] : ''; ?>%) ]&nbsp;</td>
					<?php } else { ?>

						<td class="gensmall" nowrap="nowrap" width="100%">&nbsp;[ <b><?php echo (isset($this->_rootref['FOLDER_CUR_MESSAGES'])) ? $this->_rootref['FOLDER_CUR_MESSAGES'] : ''; ?></b> <?php echo ((isset($this->_rootref['L_MESSAGES'])) ? $this->_rootref['L_MESSAGES'] : ((isset($user->lang['MESSAGES'])) ? $user->lang['MESSAGES'] : '{ MESSAGES }')); ?> ]&nbsp;</td>
					<?php } ?>

				</tr>
				</table>
			<?php } if ($this->_rootref['S_VIEW_MESSAGE']) {  ?>

				<span class="gensmall">
				<?php if ($this->_rootref['S_DISPLAY_HISTORY']) {  if ($this->_rootref['U_VIEW_PREVIOUS_HISTORY']) {  ?><a href="<?php echo (isset($this->_rootref['U_VIEW_PREVIOUS_HISTORY'])) ? $this->_rootref['U_VIEW_PREVIOUS_HISTORY'] : ''; ?>"><?php echo ((isset($this->_rootref['L_VIEW_PREVIOUS_HISTORY'])) ? $this->_rootref['L_VIEW_PREVIOUS_HISTORY'] : ((isset($user->lang['VIEW_PREVIOUS_HISTORY'])) ? $user->lang['VIEW_PREVIOUS_HISTORY'] : '{ VIEW_PREVIOUS_HISTORY }')); ?></a> | <?php } if ($this->_rootref['U_VIEW_NEXT_HISTORY']) {  ?><a href="<?php echo (isset($this->_rootref['U_VIEW_NEXT_HISTORY'])) ? $this->_rootref['U_VIEW_NEXT_HISTORY'] : ''; ?>"><?php echo ((isset($this->_rootref['L_VIEW_NEXT_HISTORY'])) ? $this->_rootref['L_VIEW_NEXT_HISTORY'] : ((isset($user->lang['VIEW_NEXT_HISTORY'])) ? $user->lang['VIEW_NEXT_HISTORY'] : '{ VIEW_NEXT_HISTORY }')); ?></a> | <?php } } ?><a href="<?php echo (isset($this->_rootref['U_PREVIOUS_PM'])) ? $this->_rootref['U_PREVIOUS_PM'] : ''; ?>"><?php echo ((isset($this->_rootref['L_VIEW_PREVIOUS_PM'])) ? $this->_rootref['L_VIEW_PREVIOUS_PM'] : ((isset($user->lang['VIEW_PREVIOUS_PM'])) ? $user->lang['VIEW_PREVIOUS_PM'] : '{ VIEW_PREVIOUS_PM }')); ?></a> | <a href="<?php echo (isset($this->_rootref['U_NEXT_PM'])) ? $this->_rootref['U_NEXT_PM'] : ''; ?>"><?php echo ((isset($this->_rootref['L_VIEW_NEXT_PM'])) ? $this->_rootref['L_VIEW_NEXT_PM'] : ((isset($user->lang['VIEW_NEXT_PM'])) ? $user->lang['VIEW_NEXT_PM'] : '{ VIEW_NEXT_PM }')); ?></a>&nbsp;
				</span>
			<?php } ?>

			</td>
			<td align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>"><?php $this->_tpl_include('pagination.html'); ?></td>
		</tr>
		</table>
	</td>
</tr>
<tr><td class="cat-bottom">&nbsp;</td></tr>
</table>
<div class="tbl-f-l"><div class="tbl-f-r"><div class="tbl-f-c">&nbsp;</div></div></div></div>