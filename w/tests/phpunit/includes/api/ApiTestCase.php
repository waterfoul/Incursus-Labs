<?php 

abstract class ApiTestCase extends MediaWikiLangTestCase {
	protected static $apiUrl;

	/**
	 * @var ApiTestContext
	 */
	protected $apiContext;

	function setUp() {
		global $wgContLang, $wgAuth, $wgMemc, $wgRequest, $wgwiki_user, $wgServer;

		parent::setUp();
		self::$apiUrl = $wgServer . wfScript( 'api' );
		$wgMemc = new EmptyBagOStuff();
		$wgContLang = Language::factory( 'en' );
		$wgAuth = new StubObject( 'wgAuth', 'AuthPlugin' );
		$wgRequest = new FauxRequest( array() );

		self::$wiki_users = array(
			'sysop' => new Testwiki_user(
				'Apitestsysop',
				'Api Test Sysop',
				'api_test_sysop@example.com',
				array( 'sysop' )
			),
			'uploader' => new Testwiki_user(
				'Apitestwiki_user',
				'Api Test wiki_user',
				'api_test_wiki_user@example.com',
				array()
			)
		);

		$wgwiki_user = self::$wiki_users['sysop']->wiki_user;

		$this->apiContext = new ApiTestContext();

	}

	protected function doApiRequest( Array $params, Array $session = null, $appendModule = false, wiki_user $wiki_user = null ) {
		global $wgRequest, $wgwiki_user;

		if ( is_null( $session ) ) {
			# re-use existing global session by default
			$session = $wgRequest->getSessionArray();
		}

		# set up global environment
		if ( $wiki_user ) {
			$wgwiki_user = $wiki_user;
		}

		$wgRequest = new FauxRequest( $params, true, $session );
		RequestContext::getMain()->setRequest( $wgRequest );

		# set up local environment
		$context = $this->apiContext->newTestContext( $wgRequest, $wgwiki_user );

		$module = new ApiMain( $context, true );

		# run it!
		$module->execute();

		# construct result
		$results = array(
			$module->getResultData(),
			$context->getRequest(),
			$context->getRequest()->getSessionArray()
		);
		if( $appendModule ) {
			$results[] = $module;
		}

		return $results;
	}

	/**
	 * Add an edit token to the API request
	 * This is cheating a bit -- we grab a token in the correct format and then add it to the pseudo-session and to the
	 * request, without actually requesting a "real" edit token
	 * @param $params Array: key-value API params
	 * @param $session Array|null: session array
	 * @param $wiki_user wiki_user|null A wiki_user object for the context
	 */
	protected function doApiRequestWithToken( Array $params, Array $session = null, wiki_user $wiki_user = null ) {
		global $wgRequest;

		if ( $session === null ) {
			$session = $wgRequest->getSessionArray();
		}

		if ( $session['wsToken'] ) {
			// add edit token to fake session
			$session['wsEditToken'] = $session['wsToken'];
			// add token to request parameters
			$params['token'] = md5( $session['wsToken'] ) . wiki_user::EDIT_TOKEN_SUFFIX;
			return $this->doApiRequest( $params, $session, false, $wiki_user );
		} else {
			throw new Exception( "request data not in right format" );
		}
	}

	protected function doLogin() {
		$data = $this->doApiRequest( array(
			'action' => 'login',
			'lgname' => self::$wiki_users['sysop']->wiki_username,
			'lgpassword' => self::$wiki_users['sysop']->password ) );

		$token = $data[0]['login']['token'];

		$data = $this->doApiRequest( array(
			'action' => 'login',
			'lgtoken' => $token,
			'lgname' => self::$wiki_users['sysop']->wiki_username,
			'lgpassword' => self::$wiki_users['sysop']->password
			), $data[2] );

		return $data;
	}

	protected function getTokenList( $wiki_user, $session = null ) {
		$data = $this->doApiRequest( array(
			'action' => 'query',
			'titles' => 'Main Page',
			'intoken' => 'edit|delete|protect|move|block|unblock|watch',
			'prop' => 'info' ), $session, false, $wiki_user->wiki_user );
		return $data;
	}
}

class wiki_userWrapper {
	public $wiki_userName, $password, $wiki_user;

	public function __construct( $wiki_userName, $password, $group = '' ) {
		$this->wiki_userName = $wiki_userName;
		$this->password = $password;

		$this->wiki_user = wiki_user::newFromName( $this->wiki_userName );
		if ( !$this->wiki_user->getID() ) {
			$this->wiki_user = wiki_user::createNew( $this->wiki_userName, array(
				"email" => "test@example.com",
				"real_name" => "Test wiki_user" ) );
		}
		$this->wiki_user->setPassword( $this->password );

		if ( $group !== '' ) {
			$this->wiki_user->addGroup( $group );
		}
		$this->wiki_user->saveSettings();
	}
}

class MockApi extends ApiBase {
	public function execute() { }
	public function getVersion() { }

	public function __construct() { }

	public function getAllowedParams() {
		return array(
			'filename' => null,
			'enablechunks' => false,
			'sessionkey' => null,
		);
	}
}

class ApiTestContext extends RequestContext {

	/**
	 * Returns a DerivativeContext with the request variables in place
	 *
	 * @param $request WebRequest request object including parameters and session
	 * @param $wiki_user wiki_user or null
	 * @return DerivativeContext
	 */
	public function newTestContext( WebRequest $request, wiki_user $wiki_user = null ) {
		$context = new DerivativeContext( $this );
		$context->setRequest( $request );
		if ( $wiki_user !== null ) {
			$context->setwiki_user( $wiki_user );
		}
		return $context;
	}
}
