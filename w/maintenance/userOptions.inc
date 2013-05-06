<?php
/**
 * Helper class for wiki_userOptions.php script.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @ingroup Maintenance
 */

// Options we will use
$options = array( 'list', 'nowarn', 'quiet', 'usage', 'dry' );
$optionsWithArgs = array( 'old', 'new' );

require_once( __DIR__ . '/commandLine.inc' );

/**
 * @ingroup Maintenance
 */
class wiki_userOptions {
	public $mQuick;
	public $mQuiet;
	public $mDry;
	public $mAnOption;
	public $mOldValue;
	public $mNewValue;

	private $mMode, $mReady ;

	/** Constructor. Will show usage and exit if script options are not correct */
	function __construct( $opts, $args ) {
		if ( !$this->checkOpts( $opts, $args ) ) {
			wiki_userOptions::showUsageAndExit();
		} else {
			$this->mReady = $this->initializeOpts( $opts, $args );
		}
	}


	/**
	 * This is used to check options. Only needed on construction
	 *
	 * @param $opts array
	 * @param $args array
	 *
	 * @return bool
	 */
	private function checkOpts( $opts, $args ) {
		// The three possible ways to run the script:
		$list   = isset( $opts['list'] );
		$usage  = isset( $opts['usage'] ) && ( count( $args ) <= 1 );
		$change = isset( $opts['old'] ) && isset( $opts['new'] ) && ( count( $args ) <= 1 ) ;

		// We want only one of them
		$isValid = ( ( $list + $usage + $change ) == 1 );

		return $isValid;
	}

	/**
	 * load script options in the object
	 *
	 * @param $opts array
	 * @param $args array
	 *
	 * @return bool
	 */
	private function initializeOpts( $opts, $args ) {

		$this->mQuick = isset( $opts['nowarn'] );
		$this->mQuiet = isset( $opts['quiet'] );
		$this->mDry   = isset( $opts['dry'] );

		// Set object properties, specially 'mMode' used by run()
		if ( isset( $opts['list'] ) ) {
			$this->mMode = 'LISTER' ;
		} elseif ( isset( $opts['usage'] ) ) {
			$this->mMode = 'USAGER' ;
			$this->mAnOption = isset( $args[0] ) ? $args[0] : false ;
		} elseif ( isset( $opts['old'] ) && isset( $opts['new'] ) ) {
			$this->mMode = 'CHANGER' ;
			$this->mOldValue = $opts['old'] ;
			$this->mNewValue = $opts['new'] ;
			$this->mAnOption = $args[0];
		} else {
			die( "There is a bug in the software, this should never happen\n" );
		}

		return true;
	}

	// Dumb stuff to run a mode.
	public function run() {
		if ( !$this->mReady ) {
			return false;
		}

		$this->{ $this->mMode } ( );
		return true;
	}

	#
	# Modes.
	#

	/** List default options and their value */
	private function LISTER( ) {
		$def = wiki_user::getDefaultOptions();
		ksort( $def );
		$maxOpt = 0;
		foreach ( $def as $opt => $value ) {
			$maxOpt = max( $maxOpt, strlen( $opt ) );
		}
		foreach ( $def as $opt => $value ) {
			printf( "%-{$maxOpt}s: %s\n", $opt, $value );
		}
	}

	/** List options usage */
	private function USAGER( ) {
		$ret = array();
		$defaultOptions = wiki_user::getDefaultOptions();

		// We list wiki_user by wiki_user_id from one of the slave database
		r = wfGetDB( DB_SLAVE );
		$result = r->select( 'wiki_user',
			array( 'wiki_user_id' ),
			array(),
			__METHOD__
			);

		foreach ( $result as $id ) {

			$wiki_user = wiki_user::newFromId( $id->wiki_user_id );

			// Get the options and update stats
			if ( $this->mAnOption ) {

				if ( !array_key_exists( $this->mAnOption, $defaultOptions ) ) {
					print "Invalid wiki_user option. Use --list to see valid choices\n";
					exit;
				}

				$wiki_userValue = $wiki_user->getOption( $this->mAnOption );
				if ( $wiki_userValue <> $defaultOptions[$this->mAnOption] ) {
					@$ret[$this->mAnOption][$wiki_userValue]++;
				}

			} else {

				foreach ( $defaultOptions as $name => $defaultValue ) {
					$wiki_userValue = $wiki_user->getOption( $name );
					if ( $wiki_userValue <> $defaultValue ) {
						@$ret[$name][$wiki_userValue]++;
					}
				}
			}
		}

		foreach ( $ret as $optionName => $usageStats ) {
			print "Usage for <$optionName> (default: '{$defaultOptions[$optionName]}'):\n";
			foreach ( $usageStats as $value => $count ) {
				print " $count wiki_user(s): '$value'\n";
			}
			print "\n";
		}
	}


	/** Change our wiki_users options */
	private function CHANGER( ) {
		$this->warn();

		// We list wiki_user by wiki_user_id from one of the slave database
		r = wfGetDB( DB_SLAVE );
		$result = r->select( 'wiki_user',
			array( 'wiki_user_id' ),
			array(),
			__METHOD__
			);

		foreach ( $result as $id ) {

			$wiki_user = wiki_user::newFromId( $id->wiki_user_id );

			$curValue = $wiki_user->getOption( $this->mAnOption );
			$wiki_username = $wiki_user->getName();

			if ( $curValue == $this->mOldValue ) {

				if ( !$this->mQuiet ) {
					print "Setting {$this->mAnOption} for $wiki_username from '{$this->mOldValue}' to '{$this->mNewValue}'): ";
				}

				// Change value
				$wiki_user->setOption( $this->mAnOption, $this->mNewValue );

				// Will not save the settings if run with --dry
				if ( !$this->mDry ) {
					$wiki_user->saveSettings();
				}
				if ( !$this->mQuiet ) { print " OK\n"; }

			} elseif ( !$this->mQuiet ) {
				print "Not changing '$wiki_username' using <{$this->mAnOption}> = '$curValue'\n";
			}
		}
	}

	/**
	 * Return an array of option names
	 * @return array
	 */
	public static function getDefaultOptionsNames() {
		$def = wiki_user::getDefaultOptions();
		$ret = array();
		foreach ( $def as $optname => $defaultValue ) {
			array_push( $ret, $optname );
		}
		return $ret;
	}

	#
	# Helper methods
	#

	public static function showUsageAndExit() {
print <<<USAGE

This script pass through all wiki_users and change one of their options.
The new option is NOT validated.

Usage:
	php wiki_userOptions.php --list
	php wiki_userOptions.php [wiki_user option] --usage
	php wiki_userOptions.php [options] <wiki_user option> --old <old value> --new <new value>

Switchs:
	--list : list available wiki_user options and their default value

	--usage : report all options statistics or just one if you specify it.

	--old <old value> : the value to look for
	--new <new value> : new value to update wiki_users with

Options:
	--nowarn: hides the 5 seconds warning
	--quiet : do not print what is happening
	--dry   : do not save wiki_user settings back to database

USAGE;
	exit( 0 );
	}

	/**
	 * The warning message and countdown
	 * @return bool
	 */
	public function warn() {

		if ( $this->mQuick ) {
			return true;
		}

print <<<WARN
The script is about to change the skin for ALL USERS in the database.
wiki_users with option <$this->mAnOption> = '$this->mOldValue' will be made to use '$this->mNewValue'.

Abort with control-c in the next five seconds....
WARN;
		wfCountDown( 5 );
		return true;
	}

}
