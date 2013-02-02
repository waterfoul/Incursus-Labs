<?php if (!defined('IN_PHPBB')) exit; ?>Subject: Inactive account reminder

Hello <?php echo (isset($this->_rootref['USERNAME'])) ? $this->_rootref['USERNAME'] : ''; ?>,

This notification is a reminder that your account at "<?php echo (isset($this->_rootref['SITENAME'])) ? $this->_rootref['SITENAME'] : ''; ?>", created on <?php echo (isset($this->_rootref['REGISTER_DATE'])) ? $this->_rootref['REGISTER_DATE'] : ''; ?>, remains inactive. If you would like to activate this account, please visit the following link:

<?php echo (isset($this->_rootref['U_ACTIVATE'])) ? $this->_rootref['U_ACTIVATE'] : ''; ?>


Thank you for registering at "<?php echo (isset($this->_rootref['SITENAME'])) ? $this->_rootref['SITENAME'] : ''; ?>", we look forward to your participation.

<?php echo (isset($this->_rootref['EMAIL_SIG'])) ? $this->_rootref['EMAIL_SIG'] : ''; ?>