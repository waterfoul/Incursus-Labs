<?php if (!defined('IN_PHPBB')) exit; ?>The following is an e-mail sent to you by an administrator of "<?php echo (isset($this->_rootref['SITENAME'])) ? $this->_rootref['SITENAME'] : ''; ?>". If this message is spam, contains abusive or other comments you find offensive please contact the webmaster of the board at the following address:

<?php echo (isset($this->_rootref['CONTACT_EMAIL'])) ? $this->_rootref['CONTACT_EMAIL'] : ''; ?>


Include this full e-mail (particularly the headers). 

Message sent to you follows:
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

<?php echo (isset($this->_rootref['MESSAGE'])) ? $this->_rootref['MESSAGE'] : ''; ?>



<?php echo (isset($this->_rootref['EMAIL_SIG'])) ? $this->_rootref['EMAIL_SIG'] : ''; ?>