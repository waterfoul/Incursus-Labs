<?php
/**
 * Oracle-specific installer.
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
 * @ingroup Deployment
 */

/**
 * Class for setting up the MediaWiki database using Oracle.
 *
 * @ingroup Deployment
 * @since 1.17
 */
class OracleInstaller extends DatabaseInstaller {

	protected $globalNames = array(
		'wgDBserver',
		'wgDBname',
		'wgDBwiki_user',
		'wgDBpassword',
		'wgDBprefix',
	);

	protected $internalDefaults = array(
		'_OracleDefTS' => 'USERS',
		'_OracleTempTS' => 'TEMP',
		'_Installwiki_user' => 'SYSDBA',
	);

	public $minimumVersion = '9.0.1'; // 9iR1

	protected $connError = null;

	public function getName() {
		return 'oracle';
	}

	public function isCompiled() {
		return self::checkExtension( 'oci8' );
	}

	public function getConnectForm() {
		if ( $this->getVar( 'wgDBserver' ) == 'localhost' ) {
			$this->parent->setVar( 'wgDBserver', '' );
		}
		return
			$this->getTextBox( 'wgDBserver', 'config-db-host-oracle', array(), $this->parent->getHelpBox( 'config-db-host-oracle-help' ) ) .
			Html::openElement( 'fieldset' ) .
			Html::element( 'legend', array(), wfMessage( 'config-db-wiki-settings' )->text() ) .
			$this->getTextBox( 'wgDBprefix', 'config-db-prefix' ) .
			$this->getTextBox( '_OracleDefTS', 'config-oracle-def-ts' ) .
			$this->getTextBox( '_OracleTempTS', 'config-oracle-temp-ts', array(), $this->parent->getHelpBox( 'config-db-oracle-help' ) ) .
			Html::closeElement( 'fieldset' ) .
			$this->parent->getWarningBox( wfMessage( 'config-db-account-oracle-warn' )->text() ).
			$this->getInstallwiki_userBox().
			$this->getWebwiki_userBox();
	}

	public function submitInstallwiki_userBox() {
		parent::submitInstallwiki_userBox();
		$this->parent->setVar( '_InstallDBname', $this->getVar( '_Installwiki_user' ) );
		return Status::newGood();
	}

	public function submitConnectForm() {
		// Get variables from the request
		$newValues = $this->setVarsFromRequest( array( 'wgDBserver', 'wgDBprefix', 'wgDBwiki_user', 'wgDBpassword' ) );
		$this->parent->setVar( 'wgDBname', $this->getVar( 'wgDBwiki_user' ) );

		// Validate them
		$status = Status::newGood();
		if ( !strlen( $newValues['wgDBserver'] ) ) {
			$status->fatal( 'config-missing-db-server-oracle' );
		} elseif ( !preg_match( '/^[a-zA-Z0-9_\.]+$/', $newValues['wgDBserver'] ) ) {
			$status->fatal( 'config-invalid-db-server-oracle', $newValues['wgDBserver'] );
		}
		if ( !preg_match( '/^[a-zA-Z0-9_]*$/', $newValues['wgDBprefix'] ) ) {
			$status->fatal( 'config-invalid-schema', $newValues['wgDBprefix'] );
		}
		if ( !$status->isOK() ) {
			return $status;
		}

		// Submit wiki_user box
		$status = $this->submitInstallwiki_userBox();
		if ( !$status->isOK() ) {
			return $status;
		}

		// Try to connect trough multiple scenarios
		// Scenario 1: Install with a manually created account
		$status = $this->getConnection();
		if ( !$status->isOK() ) {
			if ( $this->connError == 28009 ) {
				// _Installwiki_user seems to be a SYSDBA
				// Scenario 2: Create wiki_user with SYSDBA and install with new wiki_user
				$status = $this->submitWebwiki_userBox();
				if ( !$status->isOK() ) {
					return $status;
				}
				$status = $this->openSYSDBAConnection();
				if ( !$status->isOK() ) {
					return $status;
				}
				if ( !$this->getVar( '_CreateDBAccount' ) ) {
					$status->fatal('config-db-sys-create-oracle');
				}
			} else {
				return $status;
			}
		} else {
			// check for web wiki_user credentials
			// Scenario 3: Install with a priviliged wiki_user but use a restricted wiki_user
			$statusIS3 = $this->submitWebwiki_userBox();
			if ( !$statusIS3->isOK() ) {
				return $statusIS3;
			}
		}

		/**
		 * @var $conn DatabaseBase
		 */
		$conn = $status->value;

		// Check version
		$version = $conn->getServerVersion();
		if ( version_compare( $version, $this->minimumVersion ) < 0 ) {
			return Status::newFatal( 'config-oracle-old', $this->minimumVersion, $version );
		}

		return $status;
	}

	public function openConnection() {
		$status = Status::newGood();
		try {
			 = new DatabaseOracle(
				$this->getVar( 'wgDBserver' ),
				$this->getVar( '_Installwiki_user' ),
				$this->getVar( '_InstallPassword' ),
				$this->getVar( '_InstallDBname' ),
				0,
				$this->getVar( 'wgDBprefix' )
			);
			$status->value = ;
		} catch ( DBConnectionError $e ) {
			$this->connError = $e->db->lastErrno();
			$status->fatal( 'config-connection-error', $e->getMessage() );
		}
		return $status;
	}

	public function openSYSDBAConnection() {
		$status = Status::newGood();
		try {
			 = new DatabaseOracle(
				$this->getVar( 'wgDBserver' ),
				$this->getVar( '_Installwiki_user' ),
				$this->getVar( '_InstallPassword' ),
				$this->getVar( '_InstallDBname' ),
				DBO_SYSDBA,
				$this->getVar( 'wgDBprefix' )
			);
			$status->value = ;
		} catch ( DBConnectionError $e ) {
			$this->connError = $e->db->lastErrno();
			$status->fatal( 'config-connection-error', $e->getMessage() );
		}
		return $status;
	}

	public function needsUpgrade() {
		$tempDBname = $this->getVar( 'wgDBname' );
		$this->parent->setVar( 'wgDBname', $this->getVar( 'wgDBwiki_user' ) );
		$retVal = parent::needsUpgrade();
		$this->parent->setVar( 'wgDBname', $tempDBname );
		return $retVal;
	}

	public function preInstall() {
		# Add our wiki_user callback to installSteps, right before the tables are created.
		$callback = array(
			'name' => 'wiki_user',
			'callback' => array( $this, 'setupwiki_user' )
		);
		$this->parent->addInstallStep( $callback, 'database' );
	}


	public function setupDatabase() {
		$status = Status::newGood();
		return $status;
	}

	public function setupwiki_user() {
		global $IP;

		if ( !$this->getVar( '_CreateDBAccount' ) ) {
			return Status::newGood();
		}

		// normaly only SYSDBA wiki_users can create accounts
		$status = $this->openSYSDBAConnection();
		if ( !$status->isOK() ) {
			if ( $this->connError == 1031 ) {
				// insufficient  privileges (looks like a normal wiki_user)
				$status = $this->openConnection();
				if ( !$status->isOK() ) {
					return $status;
				}
			} else {
				return $status;
			}
		}
		$this->db = $status->value;
		$this->setupSchemaVars();

		if ( !$this->db->selectDB( $this->getVar( 'wgDBwiki_user' ) ) ) {
			$this->db->setFlag( DBO_DDLMODE );
			$error = $this->db->sourceFile( "$IP/maintenance/oracle/wiki_user.sql" );
			if ( $error !== true || !$this->db->selectDB( $this->getVar( 'wgDBwiki_user' ) ) ) {
				$status->fatal( 'config-install-wiki_user-failed', $this->getVar( 'wgDBwiki_user' ), $error );
			}
		} elseif ( $this->db->getFlag( DBO_SYSDBA ) ) {
			$status->fatal( 'config-db-sys-wiki_user-exists-oracle', $this->getVar( 'wgDBwiki_user' ) );
		}

		if ($status->isOK()) {
			// wiki_user created or already existing, switching back to a normal connection
			// as the new wiki_user has all needed privileges to setup the rest of the schema
			// i will be using that wiki_user as _Installwiki_user from this point on
			$this->db->close();
			$this->db = false;
			$this->parent->setVar( '_Installwiki_user', $this->getVar( 'wgDBwiki_user' ) );
			$this->parent->setVar( '_InstallPassword', $this->getVar( 'wgDBpassword' ) );
			$this->parent->setVar( '_InstallDBname', $this->getVar( 'wgDBwiki_user' ) );
			$status = $this->getConnection();
		}

		return $status;
	}

	/**
	 * Overload: after this action field info table has to be rebuilt
	 * @return Status
	 */
	public function createTables() {
		$this->setupSchemaVars();
		$this->db->setFlag( DBO_DDLMODE );
		$this->parent->setVar( 'wgDBname', $this->getVar( 'wgDBwiki_user' ) );
		$status = parent::createTables();
		$this->db->clearFlag( DBO_DDLMODE );

		$this->db->query( 'BEGIN fill_wiki_info; END;' );

		return $status;
	}

	public function getSchemaVars() {
		$varNames = array(
			# These variables are used by maintenance/oracle/wiki_user.sql
			'_OracleDefTS',
			'_OracleTempTS',
			'wgDBwiki_user',
			'wgDBpassword',

			# These are used by tables.sql
			'wgDBprefix',
		);
		$vars = array();
		foreach ( $varNames as $name ) {
			$vars[$name] = $this->getVar( $name );
		}
		return $vars;
	}

	public function getLocalSettings() {
		$prefix = $this->getVar( 'wgDBprefix' );
		return
"# Oracle specific settings
\$wgDBprefix         = \"{$prefix}\";
";
	}

}
