<?php
/**
*
* @package ucp
* @version $Id$
* @copyright (c) 2005 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
* ucp_profile
* Changing profile settings
*
* @todo what about pertaining user_sig_options?
* @package ucp
*/
class ucp_profile
{
	var $u_action;

	function main($id, $mode)
	{
		global $config, $db, $user, $auth, $template, $phpbb_root_path, $phpEx;

		$user->add_lang('posting');
		// Start Sep Login Name Mod
		$user->add_lang('mods/info_acp_separate_login_username');
		// Emd Sep Login Name Mod

		$preview	= (!empty($_POST['preview'])) ? true : false;
		$submit		= (!empty($_POST['submit'])) ? true : false;
		$delete		= (!empty($_POST['delete'])) ? true : false;
		$error = $data = array();
		$s_hidden_fields = '';

		switch ($mode)
		{
			case 'reg_details':
				
				$data = array(
					'username'			=> utf8_normalize_nfc(request_var('username', $user->data['username'], true)),
					// Start Sep Login Name Mod
					'loginname'			=> utf8_normalize_nfc(request_var('loginname', $user->data['loginname'], true)),
					// End Sep Login Name Mod	
					'email'				=> strtolower(request_var('email', $user->data['user_email'])),
					'email_confirm'		=> strtolower(request_var('email_confirm', '')),
					'new_password'		=> request_var('new_password', '', true),
					'cur_password'		=> request_var('cur_password', '', true),
					'password_confirm'	=> request_var('password_confirm', '', true),
				);

				add_form_key('ucp_reg_details');

				if ($submit)
				{
					// Do not check cur_password, it is the old one.
					$check_ary = array(
						'new_password'		=> array(
							array('string', true, $config['min_pass_chars'], $config['max_pass_chars']),
							array('password')),
						'password_confirm'	=> array('string', true, $config['min_pass_chars'], $config['max_pass_chars']),
						'email'				=> array(
							array('string', false, 6, 60),
							array('email')),
						'email_confirm'		=> array('string', true, 6, 60),
					);
					
					$pair = split(":",$data["username"]);
	           			if(count($pair) == 2)
					{
						$sql_arr = array(
		                                    'SELECT'    => 'd.pf_api_key',
                                		    'FROM'        => array(
                		                        PROFILE_FIELDS_DATA_TABLE => 'd'
		                                        ),
                                		    'WHERE'        => 'd.user_id = ' . $user->data['user_id'],
                		                    );
		
                        		        $sql = $db->sql_build_query('SELECT', $sql_arr);
        		                        $result = $db->sql_query($sql);
	                        	        $row = $db->sql_fetchrow($result);
                	        	        $key = explode(":", $row["pf_api_key"]);
		                                $key = $key[0];

						$name_ok = false;
						$sql_arr = array(
						    'SELECT'    => 'c.characterID,c.characterName',
						    'FROM'        => array(
						        "naa_yapeal.accountKeyBridge" => 'b',
						        "naa_yapeal.accountCharacters" => 'c',
						        ),
						    'WHERE'        => 'b.characterID = c.characterID AND b.keyID = "' . $key . '"',
						    );
						$sql = $db->sql_build_query('SELECT', $sql_arr);
						$result = $db->sql_query($sql);
				            	while($row = $db->sql_fetchrow($result))
							if($row["characterName"] == $pair[1] && $row["characterID"] == $pair[0])
								$name_ok = true;
						if($name_ok)
           						$data["username"] = $pair[1] . "&#01;";
						else 
						{
							$data["username"] = $data["loginname"] . " Unconfirmed";
							$pair = array();
						}
					}
					else 
						$data["username"] = $data["loginname"] . " Unconfirmed";
					//if ($auth->acl_get('u_chgname') && $config['allow_namechange'])
					//{
						$check_ary['username'] = array(
							array('string', false, $config['min_name_chars'], $config['max_name_chars']),
							array('username'),
						);
					//}

					// Start Sep Login Name Mod
					if ($auth->acl_get('u_chgloginname') && $config['allow_loginnamechange'])
					{
						$check_ary['loginname'] = array(
							array('string', false, $config['min_loginname_chars'], $config['max_loginname_chars']),
							array('loginname'),
						);
					}
					// End Sep Login Name Mod
					
					$error = validate_data($data, $check_ary);

					if ($auth->acl_get('u_chgemail') && $data['email'] != $user->data['user_email'] && $data['email_confirm'] != $data['email'])
					{
						$error[] = ($data['email_confirm']) ? 'NEW_EMAIL_ERROR' : 'NEW_EMAIL_CONFIRM_EMPTY';
					}

					if ($auth->acl_get('u_chgpasswd') && $data['new_password'] && $data['password_confirm'] != $data['new_password'])
					{
						$error[] = ($data['password_confirm']) ? 'NEW_PASSWORD_ERROR' : 'NEW_PASSWORD_CONFIRM_EMPTY';
					}

					// Only check the new password against the previous password if there have been no errors
					if (!sizeof($error) && $auth->acl_get('u_chgpasswd') && $data['new_password'] && phpbb_check_hash($data['new_password'], $user->data['user_password']))
					{
						$error[] = 'SAME_PASSWORD_ERROR';
					}

					if (!phpbb_check_hash($data['cur_password'], $user->data['user_password']))
					{
						$error[] = ($data['cur_password']) ? 'CUR_PASSWORD_ERROR' : 'CUR_PASSWORD_EMPTY';
					}

					if (!check_form_key('ucp_reg_details'))
					{
						$error[] = 'FORM_INVALID';
					}

					if (!sizeof($error))
					{
						if(count($pair) == 2)
						{
							$sqldata = array(
                                	            'user_avatar'     => 'http://image.eveonline.com/Character/' . $pair[0] . '_128.jpg',
                        	                    'user_avatar_type'     => 2,
                	                            'user_avatar_width'     => 128,
        	                                    'user_avatar_height'     => 128,
	                                        );
							$sql = 'UPDATE ' . USERS_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $sqldata) . ' WHERE user_id = ' . (int) $user->data['user_id'];
                            $db->sql_query($sql);
						}

						$sql_ary = array(
							'username'			=> /*($auth->acl_get('u_chgname') && $config['allow_namechange']) ?*/ $data['username'] /*: $user->data['username']*/,
							'username_clean'	=> /*($auth->acl_get('u_chgname') && $config['allow_namechange']) ?*/ utf8_clean_string($data['username']) /*: $user->data['username_clean']*/,
							// Start Sep Login Name Mod
							'loginname'	=> ($auth->acl_get('u_chgloginname') && $config['allow_loginnamechange']) ? $data['loginname'] : $user->data['loginname'],					
							'loginname_clean'	=> ($auth->acl_get('u_chgloginname') && $config['allow_loginnamechange']) ? utf8_clean_string($data['loginname']) : $user->data['loginname_clean'],	
							// End Sep Login Name Mod
							'user_email'		=> ($auth->acl_get('u_chgemail')) ? $data['email'] : $user->data['user_email'],
							'user_email_hash'	=> ($auth->acl_get('u_chgemail')) ? phpbb_email_hash($data['email']) : $user->data['user_email_hash'],
							'user_password'		=> ($auth->acl_get('u_chgpasswd') && $data['new_password']) ? phpbb_hash($data['new_password']) : $user->data['user_password'],
							'user_passchg'		=> ($auth->acl_get('u_chgpasswd') && $data['new_password']) ? time() : 0,
						);

						if ($auth->acl_get('u_chgname') && $config['allow_namechange'] && $data['username'] != $user->data['username'])
						{
							add_log('user', $user->data['user_id'], 'LOG_USER_UPDATE_NAME', $user->data['username'], $data['username']);
						}

						// Start Sep Login Name Mod
						if ($auth->acl_get('u_chgloginname') && $config['allow_loginnamechange'] && $data['loginname'] != $user->data['loginname'])
						{
							add_log('user', $user->data['user_id'], 'LOG_USER_UPDATE_LOGINNAME', $user->data['loginname'], $data['loginname']);
						}
						// End Sep Login Name Mod

						if ($auth->acl_get('u_chgpasswd') && $data['new_password'] && !phpbb_check_hash($data['new_password'], $user->data['user_password']))
						{
							$user->reset_login_keys();
							add_log('user', $user->data['user_id'], 'LOG_USER_NEW_PASSWORD', $data['username']);
						}

						if ($auth->acl_get('u_chgemail') && $data['email'] != $user->data['user_email'])
						{
							add_log('user', $user->data['user_id'], 'LOG_USER_UPDATE_EMAIL', $data['username'], $user->data['user_email'], $data['email']);
						}

						$message = 'PROFILE_UPDATED';

						if ($auth->acl_get('u_chgemail') && $config['email_enable'] && $data['email'] != $user->data['user_email'] && $user->data['user_type'] != USER_FOUNDER && ($config['require_activation'] == USER_ACTIVATION_SELF || $config['require_activation'] == USER_ACTIVATION_ADMIN))
						{
							$message = ($config['require_activation'] == USER_ACTIVATION_SELF) ? 'ACCOUNT_EMAIL_CHANGED' : 'ACCOUNT_EMAIL_CHANGED_ADMIN';

							include_once($phpbb_root_path . 'includes/functions_messenger.' . $phpEx);

							$server_url = generate_board_url();

							$user_actkey = gen_rand_string(mt_rand(6, 10));

							$messenger = new messenger(false);

							$template_file = ($config['require_activation'] == USER_ACTIVATION_ADMIN) ? 'user_activate_inactive' : 'user_activate';
							$messenger->template($template_file, $user->data['user_lang']);

							$messenger->to($data['email'], $data['username']);

							$messenger->anti_abuse_headers($config, $user);

							$messenger->assign_vars(array(
								'USERNAME'		=> htmlspecialchars_decode($data['username']),
								'U_ACTIVATE'	=> "$server_url/ucp.$phpEx?mode=activate&u={$user->data['user_id']}&k=$user_actkey")
							);

							$messenger->send(NOTIFY_EMAIL);

							if ($config['require_activation'] == USER_ACTIVATION_ADMIN)
							{
								// Grab an array of user_id's with a_user permissions ... these users can activate a user
								$admin_ary = $auth->acl_get_list(false, 'a_user', false);
								$admin_ary = (!empty($admin_ary[0]['a_user'])) ? $admin_ary[0]['a_user'] : array();

								// Also include founders
								$where_sql = ' WHERE user_type = ' . USER_FOUNDER;

								if (sizeof($admin_ary))
								{
									$where_sql .= ' OR ' . $db->sql_in_set('user_id', $admin_ary);
								}

								$sql = 'SELECT user_id, username, user_email, user_lang, user_jabber, user_notify_type
									FROM ' . USERS_TABLE . ' ' .
									$where_sql;
								$result = $db->sql_query($sql);

								while ($row = $db->sql_fetchrow($result))
								{
									$messenger->template('admin_activate', $row['user_lang']);
									$messenger->to($row['user_email'], $row['username']);
									$messenger->im($row['user_jabber'], $row['username']);

									$messenger->assign_vars(array(
										'USERNAME'			=> htmlspecialchars_decode($data['username']),
										'U_USER_DETAILS'	=> "$server_url/memberlist.$phpEx?mode=viewprofile&u={$user->data['user_id']}",
										'U_ACTIVATE'		=> "$server_url/ucp.$phpEx?mode=activate&u={$user->data['user_id']}&k=$user_actkey")
									);

									$messenger->send($row['user_notify_type']);
								}
								$db->sql_freeresult($result);
							}

							user_active_flip('deactivate', $user->data['user_id'], INACTIVE_PROFILE);

							// Because we want the profile to be reactivated we set user_newpasswd to empty (else the reactivation will fail)
							$sql_ary['user_actkey'] = $user_actkey;
							$sql_ary['user_newpasswd'] = '';
						}

						if (sizeof($sql_ary))
						{
							$sql = 'UPDATE ' . USERS_TABLE . '
								SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
								WHERE user_id = ' . $user->data['user_id'];
							$db->sql_query($sql);
						}

						// Need to update config, forum, topic, posting, messages, etc.
						if ($data['username'] != $user->data['username'] && $auth->acl_get('u_chgname') && $config['allow_namechange'])
						{
							user_update_name($user->data['username'], $data['username']);
						}

						// Now, we can remove the user completely (kill the session) - NOT BEFORE!!!
						if (!empty($sql_ary['user_actkey']))
						{
							meta_refresh(5, append_sid($phpbb_root_path . 'index.' . $phpEx));
							$message = $user->lang[$message] . '<br /><br />' . sprintf($user->lang['RETURN_INDEX'], '<a href="' . append_sid($phpbb_root_path . 'index.' . $phpEx) . '">', '</a>');

							// Because the user gets deactivated we log him out too, killing his session
							$user->session_kill();
						}
						else
						{
							meta_refresh(3, $this->u_action);
							$message = $user->lang[$message] . '<br /><br />' . sprintf($user->lang['RETURN_UCP'], '<a href="' . $this->u_action . '">', '</a>');
						}

						trigger_error($message);
					}

					// Replace "error" strings with their real, localised form
					$error = preg_replace('#^([A-Z_]+)$#e', "(!empty(\$user->lang['\\1'])) ? \$user->lang['\\1'] : '\\1'", $error);
				}
				
				$sql_arr = array(
				    'SELECT'    => 'd.pf_api_key',
				    'FROM'        => array(
				        PROFILE_FIELDS_DATA_TABLE => 'd'
				        ),
				    'WHERE'        => 'd.user_id = ' . $user->data['user_id'],
				    );
				
				$sql = $db->sql_build_query('SELECT', $sql_arr);
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$key = explode(":", $row["pf_api_key"]);
				$key = $key[0];
				$sql_arr = array(
				    'SELECT'    => 'c.characterID,c.characterName',
				    'FROM'        => array(
				        "naa_yapeal.accountKeyBridge" => 'b',
				        "naa_yapeal.accountCharacters" => 'c',
				        ),
				    'WHERE'        => 'b.characterID = c.characterID AND b.keyID = "' . $key . '"',
				    );
				$sql = $db->sql_build_query('SELECT', $sql_arr);
				$result = $db->sql_query($sql);
	             while($row = $db->sql_fetchrow($result))
                        $template->assign_block_vars('characters', array("ID"=>$row["characterID"],"NAME"=>$row["characterName"],"NAMECOMPARE"=>$row["characterName"]."&#01;"));


				$template->assign_vars(array(
					'ERROR'				=> (sizeof($error)) ? implode('<br />', $error) : '',

					'USERNAME'			=> $data['username'],
					'LOGINNAME'			=> $data['loginname'],
					'EMAIL'				=> $data['email'],
					'PASSWORD_CONFIRM'	=> $data['password_confirm'],
					'NEW_PASSWORD'		=> $data['new_password'],
					'CUR_PASSWORD'		=> '',

					'L_USERNAME_EXPLAIN'		=> sprintf($user->lang[$config['allow_name_chars'] . '_EXPLAIN'], $config['min_name_chars'], $config['max_name_chars']),
					// Start Sep Login Name Mod
					'L_LOGINNAME_EXPLAIN'		=> sprintf($user->lang[$config['allow_loginname_chars'] . '_EXPLAIN'], $config['min_loginname_chars'], $config['max_loginname_chars']) . "(Will only display if no eve character is selected)",
					// End Sep Login Name Mod
					'L_CHANGE_PASSWORD_EXPLAIN'	=> sprintf($user->lang[$config['pass_complex'] . '_EXPLAIN'], $config['min_pass_chars'], $config['max_pass_chars']),

					'S_FORCE_PASSWORD'	=> ($auth->acl_get('u_chgpasswd') && $config['chg_passforce'] && $user->data['user_passchg'] < time() - ($config['chg_passforce'] * 86400)) ? true : false,
					'S_CHANGE_USERNAME' => $config['allow_namechange'] ? true : false,
					// Start Sep Login Name Mod
					'S_CHANGE_LOGINNAME' => $config['allow_loginnamechange'] ? true : false,
					// End Sep Login Name Mod	
					'S_CHANGE_EMAIL'	=> ($auth->acl_get('u_chgemail')) ? true : false,
					'S_CHANGE_PASSWORD'	=> ($auth->acl_get('u_chgpasswd')) ? true : false)
				);
			break;

			case 'profile_info':

				include($phpbb_root_path . 'includes/functions_profile_fields.' . $phpEx);

				$cp = new custom_profile();

				$cp_data = $cp_error = array();

				$data = array(
					'icq'			=> request_var('icq', $user->data['user_icq']),
					'aim'			=> request_var('aim', $user->data['user_aim']),
					'msn'			=> request_var('msn', $user->data['user_msnm']),
					'yim'			=> request_var('yim', $user->data['user_yim']),
					'jabber'		=> utf8_normalize_nfc(request_var('jabber', $user->data['user_jabber'], true)),
					'website'		=> request_var('website', $user->data['user_website']),
					'location'		=> utf8_normalize_nfc(request_var('location', $user->data['user_from'], true)),
					'occupation'	=> utf8_normalize_nfc(request_var('occupation', $user->data['user_occ'], true)),
					'interests'		=> utf8_normalize_nfc(request_var('interests', $user->data['user_interests'], true)),
				);

				if ($config['allow_birthdays'])
				{
					$data['bday_day'] = $data['bday_month'] = $data['bday_year'] = 0;

					if ($user->data['user_birthday'])
					{
						list($data['bday_day'], $data['bday_month'], $data['bday_year']) = explode('-', $user->data['user_birthday']);
					}

					$data['bday_day'] = request_var('bday_day', $data['bday_day']);
					$data['bday_month'] = request_var('bday_month', $data['bday_month']);
					$data['bday_year'] = request_var('bday_year', $data['bday_year']);
					$data['user_birthday'] = sprintf('%2d-%2d-%4d', $data['bday_day'], $data['bday_month'], $data['bday_year']);
				}

				add_form_key('ucp_profile_info');

				if ($submit)
				{
					$validate_array = array(
						'icq'			=> array(
							array('string', true, 3, 15),
							array('match', true, '#^[0-9]+$#i')),
						'aim'			=> array('string', true, 3, 255),
						'msn'			=> array('string', true, 5, 255),
						'jabber'		=> array(
							array('string', true, 5, 255),
							array('jabber')),
						'yim'			=> array('string', true, 5, 255),
						'website'		=> array(
							array('string', true, 12, 255),
							array('match', true, '#^http[s]?://(.*?\.)*?[a-z0-9\-]+\.[a-z]{2,4}#i')),
						'location'		=> array('string', true, 2, 100),
						'occupation'	=> array('string', true, 2, 500),
						'interests'		=> array('string', true, 2, 500),
					);

					if ($config['allow_birthdays'])
					{
						$validate_array = array_merge($validate_array, array(
							'bday_day'		=> array('num', true, 1, 31),
							'bday_month'	=> array('num', true, 1, 12),
							'bday_year'		=> array('num', true, 1901, gmdate('Y', time()) + 50),
							'user_birthday' => array('date', true),
						));
					}

					$error = validate_data($data, $validate_array);

					// validate custom profile fields
					$cp->submit_cp_field('profile', $user->get_iso_lang_id(), $cp_data, $cp_error);

					if (sizeof($cp_error))
					{
						$error = array_merge($error, $cp_error);
					}

					if (!check_form_key('ucp_profile_info'))
					{
						$error[] = 'FORM_INVALID';
					}

					if (!sizeof($error))
					{
						$data['notify'] = $user->data['user_notify_type'];

						if ($data['notify'] == NOTIFY_IM && (!$config['jab_enable'] || !$data['jabber'] || !@extension_loaded('xml')))
						{
							// User has not filled in a jabber address (Or one of the modules is disabled or jabber is disabled)
							// Disable notify by Jabber now for this user.
							$data['notify'] = NOTIFY_EMAIL;
						}

						$sql_ary = array(
							'user_icq'		=> $data['icq'],
							'user_aim'		=> $data['aim'],
							'user_msnm'		=> $data['msn'],
							'user_yim'		=> $data['yim'],
							'user_jabber'	=> $data['jabber'],
							'user_website'	=> $data['website'],
							'user_from'		=> $data['location'],
							'user_occ'		=> $data['occupation'],
							'user_interests'=> $data['interests'],
							'user_notify_type'	=> $data['notify'],
						);

						if ($config['allow_birthdays'])
						{
							$sql_ary['user_birthday'] = $data['user_birthday'];
						}

						$sql = 'UPDATE ' . USERS_TABLE . '
							SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
							WHERE user_id = ' . $user->data['user_id'];
						$db->sql_query($sql);

						// Update Custom Fields
						$cp->update_profile_field_data($user->data['user_id'], $cp_data);

						meta_refresh(3, $this->u_action);
						$message = $user->lang['PROFILE_UPDATED'] . '<br /><br />' . sprintf($user->lang['RETURN_UCP'], '<a href="' . $this->u_action . '">', '</a>');
						trigger_error($message);
					}

					// Replace "error" strings with their real, localised form
					$error = preg_replace('#^([A-Z_]+)$#e', "(!empty(\$user->lang['\\1'])) ? \$user->lang['\\1'] : '\\1'", $error);
				}

				if ($config['allow_birthdays'])
				{
					$s_birthday_day_options = '<option value="0"' . ((!$data['bday_day']) ? ' selected="selected"' : '') . '>--</option>';
					for ($i = 1; $i < 32; $i++)
					{
						$selected = ($i == $data['bday_day']) ? ' selected="selected"' : '';
						$s_birthday_day_options .= "<option value=\"$i\"$selected>$i</option>";
					}

					$s_birthday_month_options = '<option value="0"' . ((!$data['bday_month']) ? ' selected="selected"' : '') . '>--</option>';
					for ($i = 1; $i < 13; $i++)
					{
						$selected = ($i == $data['bday_month']) ? ' selected="selected"' : '';
						$s_birthday_month_options .= "<option value=\"$i\"$selected>$i</option>";
					}
					$s_birthday_year_options = '';

					$now = getdate();
					$s_birthday_year_options = '<option value="0"' . ((!$data['bday_year']) ? ' selected="selected"' : '') . '>--</option>';
					for ($i = $now['year'] - 100; $i <= $now['year']; $i++)
					{
						$selected = ($i == $data['bday_year']) ? ' selected="selected"' : '';
						$s_birthday_year_options .= "<option value=\"$i\"$selected>$i</option>";
					}
					unset($now);

					$template->assign_vars(array(
						'S_BIRTHDAY_DAY_OPTIONS'	=> $s_birthday_day_options,
						'S_BIRTHDAY_MONTH_OPTIONS'	=> $s_birthday_month_options,
						'S_BIRTHDAY_YEAR_OPTIONS'	=> $s_birthday_year_options,
						'S_BIRTHDAYS_ENABLED'		=> true,
					));
				}

				$template->assign_vars(array(
					'ERROR'		=> (sizeof($error)) ? implode('<br />', $error) : '',

					'ICQ'		=> $data['icq'],
					'YIM'		=> $data['yim'],
					'AIM'		=> $data['aim'],
					'MSN'		=> $data['msn'],
					'JABBER'	=> $data['jabber'],
					'WEBSITE'	=> $data['website'],
					'LOCATION'	=> $data['location'],
					'OCCUPATION'=> $data['occupation'],
					'INTERESTS'	=> $data['interests'],
				));

				// Get additional profile fields and assign them to the template block var 'profile_fields'
				$user->get_profile_fields($user->data['user_id']);

				$cp->generate_profile_fields('profile', $user->get_iso_lang_id());

			break;

			case 'signature':

				if (!$auth->acl_get('u_sig'))
				{
					trigger_error('NO_AUTH_SIGNATURE');
				}

				include($phpbb_root_path . 'includes/functions_posting.' . $phpEx);
				include($phpbb_root_path . 'includes/functions_display.' . $phpEx);

				$enable_bbcode	= ($config['allow_sig_bbcode']) ? (bool) $user->optionget('sig_bbcode') : false;
				$enable_smilies	= ($config['allow_sig_smilies']) ? (bool) $user->optionget('sig_smilies') : false;
				$enable_urls	= ($config['allow_sig_links']) ? (bool) $user->optionget('sig_links') : false;

				$signature		= utf8_normalize_nfc(request_var('signature', (string) $user->data['user_sig'], true));

				add_form_key('ucp_sig');

				if ($submit || $preview)
				{
					include($phpbb_root_path . 'includes/message_parser.' . $phpEx);

					$enable_bbcode	= ($config['allow_sig_bbcode']) ? ((request_var('disable_bbcode', false)) ? false : true) : false;
					$enable_smilies	= ($config['allow_sig_smilies']) ? ((request_var('disable_smilies', false)) ? false : true) : false;
					$enable_urls	= ($config['allow_sig_links']) ? ((request_var('disable_magic_url', false)) ? false : true) : false;

					if (!sizeof($error))
					{
						$message_parser = new parse_message($signature);

						// Allowing Quote BBCode
						$message_parser->parse($enable_bbcode, $enable_urls, $enable_smilies, $config['allow_sig_img'], $config['allow_sig_flash'], true, $config['allow_sig_links'], true, 'sig');

						if (sizeof($message_parser->warn_msg))
						{
							$error[] = implode('<br />', $message_parser->warn_msg);
						}

						if (!check_form_key('ucp_sig'))
						{
							$error[] = 'FORM_INVALID';
						}

						if (!sizeof($error) && $submit)
						{
							$user->optionset('sig_bbcode', $enable_bbcode);
							$user->optionset('sig_smilies', $enable_smilies);
							$user->optionset('sig_links', $enable_urls);

							$sql_ary = array(
								'user_sig'					=> (string) $message_parser->message,
								'user_options'				=> $user->data['user_options'],
								'user_sig_bbcode_uid'		=> (string) $message_parser->bbcode_uid,
								'user_sig_bbcode_bitfield'	=> $message_parser->bbcode_bitfield
							);

							$sql = 'UPDATE ' . USERS_TABLE . '
								SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
								WHERE user_id = ' . $user->data['user_id'];
							$db->sql_query($sql);

							$message = $user->lang['PROFILE_UPDATED'] . '<br /><br />' . sprintf($user->lang['RETURN_UCP'], '<a href="' . $this->u_action . '">', '</a>');
							trigger_error($message);
						}
					}

					// Replace "error" strings with their real, localised form
					$error = preg_replace('#^([A-Z_]+)$#e', "(!empty(\$user->lang['\\1'])) ? \$user->lang['\\1'] : '\\1'", $error);
				}

				$signature_preview = '';
				if ($preview)
				{
					// Now parse it for displaying
					$signature_preview = $message_parser->format_display($enable_bbcode, $enable_urls, $enable_smilies, false);
					unset($message_parser);
				}

				decode_message($signature, $user->data['user_sig_bbcode_uid']);

				$template->assign_vars(array(
					'ERROR'				=> (sizeof($error)) ? implode('<br />', $error) : '',
					'SIGNATURE'			=> $signature,
					'SIGNATURE_PREVIEW'	=> $signature_preview,

					'S_BBCODE_CHECKED' 		=> (!$enable_bbcode) ? ' checked="checked"' : '',
					'S_SMILIES_CHECKED' 	=> (!$enable_smilies) ? ' checked="checked"' : '',
					'S_MAGIC_URL_CHECKED' 	=> (!$enable_urls) ? ' checked="checked"' : '',

					'BBCODE_STATUS'			=> ($config['allow_sig_bbcode']) ? sprintf($user->lang['BBCODE_IS_ON'], '<a href="' . append_sid("{$phpbb_root_path}faq.$phpEx", 'mode=bbcode') . '">', '</a>') : sprintf($user->lang['BBCODE_IS_OFF'], '<a href="' . append_sid("{$phpbb_root_path}faq.$phpEx", 'mode=bbcode') . '">', '</a>'),
					'SMILIES_STATUS'		=> ($config['allow_sig_smilies']) ? $user->lang['SMILIES_ARE_ON'] : $user->lang['SMILIES_ARE_OFF'],
					'IMG_STATUS'			=> ($config['allow_sig_img']) ? $user->lang['IMAGES_ARE_ON'] : $user->lang['IMAGES_ARE_OFF'],
					'FLASH_STATUS'			=> ($config['allow_sig_flash']) ? $user->lang['FLASH_IS_ON'] : $user->lang['FLASH_IS_OFF'],
					'URL_STATUS'			=> ($config['allow_sig_links']) ? $user->lang['URL_IS_ON'] : $user->lang['URL_IS_OFF'],
					'MAX_FONT_SIZE'			=> (int) $config['max_sig_font_size'],

					'L_SIGNATURE_EXPLAIN'	=> sprintf($user->lang['SIGNATURE_EXPLAIN'], $config['max_sig_chars']),

					'S_BBCODE_ALLOWED'		=> $config['allow_sig_bbcode'],
					'S_SMILIES_ALLOWED'		=> $config['allow_sig_smilies'],
					'S_BBCODE_IMG'			=> ($config['allow_sig_img']) ? true : false,
					'S_BBCODE_FLASH'		=> ($config['allow_sig_flash']) ? true : false,
					'S_LINKS_ALLOWED'		=> ($config['allow_sig_links']) ? true : false)
				);

				// Build custom bbcodes array
				display_custom_bbcodes();

			break;
		}

		$template->assign_vars(array(
			'L_TITLE'	=> $user->lang['UCP_PROFILE_' . strtoupper($mode)],

			'S_HIDDEN_FIELDS'	=> $s_hidden_fields,
			'S_UCP_ACTION'		=> $this->u_action)
		);

		// Set desired template
		$this->tpl_name = 'ucp_profile_' . $mode;
		$this->page_title = 'UCP_PROFILE_' . strtoupper($mode);
	}
}

?>
