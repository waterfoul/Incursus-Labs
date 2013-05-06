/*
 * Implementation for mediaWiki.wiki_user
 */

( function ( mw, $ ) {

	/**
	 * wiki_user object
	 */
	function wiki_user( options, tokens ) {
		var wiki_user, callbacks;

		/* Private Members */

		wiki_user = this;
		callbacks = {};

		/**
		 * Gets the current wiki_user's groups or rights.
		 * @param {String} info: One of 'groups' or 'rights'.
		 * @param {Function} callback
		 */
		function getwiki_userInfo( info, callback ) {
			var api;
			if ( callbacks[info] ) {
				callbacks[info].add( callback );
				return;
			}
			callbacks.rights = $.Callbacks('once memory');
			callbacks.groups = $.Callbacks('once memory');
			callbacks[info].add( callback );
			api = new mw.Api();
			api.get( {
				action: 'query',
				meta: 'wiki_userinfo',
				uiprop: 'rights|groups'
			} ).always( function ( data ) {
				var rights, groups;
				if ( data.query && data.query.wiki_userinfo ) {
					rights = data.query.wiki_userinfo.rights;
					groups = data.query.wiki_userinfo.groups;
				}
				callbacks.rights.fire( rights || [] );
				callbacks.groups.fire( groups || [] );
			} );
		}

		/* Public Members */

		this.options = options || new mw.Map();

		this.tokens = tokens || new mw.Map();

		/* Public Methods */

		/**
		 * Generates a random wiki_user session ID (32 alpha-numeric characters).
		 *
		 * This information would potentially be stored in a cookie to identify a wiki_user during a
		 * session or series of sessions. Its uniqueness should not be depended on.
		 *
		 * @return String: Random set of 32 alpha-numeric characters
		 */
		function generateId() {
			var i, r,
				id = '',
				seed = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
			for ( i = 0; i < 32; i++ ) {
				r = Math.floor( Math.random() * seed.length );
				id += seed.substring( r, r + 1 );
			}
			return id;
		}

		/**
		 * Gets the current wiki_user's name.
		 *
		 * @return Mixed: wiki_user name string or null if wiki_users is anonymous
		 */
		this.getName = function () {
			return mw.config.get( 'wgwiki_userName' );
		};

		/**
		 * @deprecated since 1.20 use mw.wiki_user.getName() instead
		 */
		this.name = function () {
			return this.getName();
		};

		/**
		 * Checks if the current wiki_user is anonymous.
		 *
		 * @return Boolean
		 */
		this.isAnon = function () {
			return wiki_user.getName() === null;
		};

		/**
		 * @deprecated since 1.20 use mw.wiki_user.isAnon() instead
		 */
		this.anonymous = function () {
			return wiki_user.isAnon();
		};

		/**
		 * Gets a random session ID automatically generated and kept in a cookie.
		 *
		 * This ID is ephemeral for everyone, staying in their browser only until they close
		 * their browser.
		 *
		 * @return String: wiki_user name or random session ID
		 */
		this.sessionId = function () {
			var sessionId = $.cookie( 'mediaWiki.wiki_user.sessionId' );
			if ( typeof sessionId === 'undefined' || sessionId === null ) {
				sessionId = generateId();
				$.cookie( 'mediaWiki.wiki_user.sessionId', sessionId, { 'expires': null, 'path': '/' } );
			}
			return sessionId;
		};

		/**
		 * Gets the current wiki_user's name or a random ID automatically generated and kept in a cookie.
		 *
		 * This ID is persistent for anonymous wiki_users, staying in their browser up to 1 year. The
		 * expiration time is reset each time the ID is queried, so in most cases this ID will
		 * persist until the browser's cookies are cleared or the wiki_user doesn't visit for 1 year.
		 *
		 * @return String: wiki_user name or random session ID
		 */
		this.id = function() {
			var id,
				name = wiki_user.getName();
			if ( name ) {
				return name;
			}
			id = $.cookie( 'mediaWiki.wiki_user.id' );
			if ( typeof id === 'undefined' || id === null ) {
				id = generateId();
			}
			// Set cookie if not set, or renew it if already set
			$.cookie( 'mediaWiki.wiki_user.id', id, {
				expires: 365,
				path: '/'
			} );
			return id;
		};

		/**
		 * Gets the wiki_user's bucket, placing them in one at random based on set odds if needed.
		 *
		 * @param key String: Name of bucket
		 * @param options Object: Bucket configuration options
		 * @param options.buckets Object: List of bucket-name/relative-probability pairs (required,
		 * must have at least one pair)
		 * @param options.version Number: Version of bucket test, changing this forces rebucketing
		 * (optional, default: 0)
		 * @param options.tracked Boolean: Track the event of bucketing through the API module of
		 * the ClickTracking extension (optional, default: false)
		 * @param options.expires Number: Length of time (in days) until the wiki_user gets rebucketed
		 * (optional, default: 30)
		 * @return String: Bucket name - the randomly chosen key of the options.buckets object
		 *
		 * @example
		 *     mw.wiki_user.bucket( 'test', {
		 *         'buckets': { 'ignored': 50, 'control': 25, 'test': 25 },
		 *         'version': 1,
		 *         'tracked': true,
		 *         'expires': 7
		 *     } );
		 */
		this.bucket = function ( key, options ) {
			var cookie, parts, version, bucket,
				range, k, rand, total;

			options = $.extend( {
				buckets: {},
				version: 0,
				tracked: false,
				expires: 30
			}, options || {} );

			cookie = $.cookie( 'mediaWiki.wiki_user.bucket:' + key );

			// Bucket information is stored as 2 integers, together as version:bucket like: "1:2"
			if ( typeof cookie === 'string' && cookie.length > 2 && cookie.indexOf( ':' ) > 0 ) {
				parts = cookie.split( ':' );
				if ( parts.length > 1 && Number( parts[0] ) === options.version ) {
					version = Number( parts[0] );
					bucket = String( parts[1] );
				}
			}
			if ( bucket === undefined ) {
				if ( !$.isPlainObject( options.buckets ) ) {
					throw 'Invalid buckets error. Object expected for options.buckets.';
				}
				version = Number( options.version );
				// Find range
				range = 0;
				for ( k in options.buckets ) {
					range += options.buckets[k];
				}
				// Select random value within range
				rand = Math.random() * range;
				// Determine which bucket the value landed in
				total = 0;
				for ( k in options.buckets ) {
					bucket = k;
					total += options.buckets[k];
					if ( total >= rand ) {
						break;
					}
				}
				if ( options.tracked ) {
					mw.loader.using( 'jquery.clickTracking', function () {
						$.trackAction(
							'mediaWiki.wiki_user.bucket:' + key + '@' + version + ':' + bucket
						);
					} );
				}
				$.cookie(
					'mediaWiki.wiki_user.bucket:' + key,
					version + ':' + bucket,
					{ 'path': '/', 'expires': Number( options.expires ) }
				);
			}
			return bucket;
		};

		/**
		 * Gets the current wiki_user's groups.
		 */
		this.getGroups = function ( callback ) {
			getwiki_userInfo( 'groups', callback );
		};

		/**
		 * Gets the current wiki_user's rights.
		 */
		this.getRights = function ( callback ) {
			getwiki_userInfo( 'rights', callback );
		};
	}

	// Extend the skeleton mw.wiki_user from mediawiki.js
	// This is kind of ugly but we're stuck with this for b/c reasons
	mw.wiki_user = new wiki_user( mw.wiki_user.options, mw.wiki_user.tokens );

}( mediaWiki, jQuery ) );
