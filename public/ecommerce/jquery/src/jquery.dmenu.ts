/*
 * jQuery dmenu v1.0.1
 * @requires jQuery 1.7.0 or later
 *
 * mmenu.frebsite.nl/dmenu-plugin
 *	
 * Copyright (c) Fred Heusschen
 * www.frebsite.nl
 *
 * License: CC-BY-4.0
 * http://creativecommons.org/licenses/by/4.0/
 */

(function( $ ) {

	const _PLUGIN_  = 'dmenu';
	const _VERSION_	= '1.0.1';


	//	Newer version of the plugin already excists
	if ( $[ _PLUGIN_ ] && $[ _PLUGIN_ ].version > _VERSION_ )
	{
		return;
	}


	/*
		Class
	*/
	$[ _PLUGIN_ ] = function( $menu, opts, conf )
	{
		var that = this;


		this.$menu  = $menu;
		this.opts 	= opts;
		this.conf 	= conf;
		this.vars	= {};


		//	Setup
		this._code( 'setup:start' );
		this._code( 'setup:before' );
		this._code( 'setup' );
		this._code( 'setup:after' );
		this._code( 'setup:finish' );


		//	Resize (also called immediately and on load)
		this._code( 'resize:start' );
		this._code( 'resize:before' );
		this._code( 'resize' );
		this._code( 'resize:after' );
		this._code( 'resize:finish' );

		function resize()
		{
			that._code( 'resize:start' );
			that._code( 'resize:before' );
			that._code( 'resize' );
			that._code( 'resize:after' );
			that._code( 'resize:finish' );
		}

		_g.$wndw.on( _e.load, resize );

		var to = null;
		_g.$wndw.on( _e.resize,
			function( e )
			{
				if ( to )
				{
					clearTimeout( to );
				}
				to = setTimeout( resize, 100 );
			}
		);


		return this;
	};

	$[ _PLUGIN_ ].version 		= _VERSION_;
	$[ _PLUGIN_ ].code  		= {};
	$[ _PLUGIN_ ].fitters		= {};
	$[ _PLUGIN_ ].options		= {};
	$[ _PLUGIN_ ].configuration = {
		classNames	: {}
	};


	$[ _PLUGIN_ ].prototype = {
		_code: function( fn )
		{
			var c, f;
			for ( c in $[ _PLUGIN_ ].code )
			{
				f = $[ _PLUGIN_ ].code[ c ][ fn ];
				if ( typeof f == 'function' )
				{
					f.call( this );
				}
			}
		}
	};


	$[ _PLUGIN_ ].code[ _PLUGIN_ ] = {

		'setup': function()
		{

			//	Refactor LI classes
			var $li = this.$menu.find( 'li' );
			function recursiveRefactor( clsn, prefix )
			{
				for ( var c in clsn )
				{
					if ( typeof clsn[ c ] == 'string' )
					{
						$li.filter( '.' + clsn[ c ] )
							.removeClass( clsn[ c ] )
							.addClass( prefix + c );
					}
					else
					{
						recursiveRefactor( clsn[ c ], _c[ c ] + '_' );
					}
				}
			}
			recursiveRefactor( this.conf.classNames, _c.dm( '' ) );
		}
	};


	/*
		jQuery plugin
	*/
	$.fn[ _PLUGIN_ ] = function( opts, conf )
	{

		//	Extend options
		opts = $.extend( true, {}, $[ _PLUGIN_ ].options, opts );
		conf = $.extend( true, {}, $[ _PLUGIN_ ].configuration, conf );

		return this.each(
			function()
			{
				var $menu = $(this);
				if ( $menu.data( _PLUGIN_ ) )
				{
					return;
				}

				var _menu = new $[ _PLUGIN_ ]( $menu, opts, conf );
				$menu.data( _PLUGIN_, _menu );
			}
		);
	};


	/*
		SUPPORT
	*/
	$[ _PLUGIN_ ].support = {

		touch: 'ontouchstart' in window || navigator.msMaxTouchPoints || false
	};


	//	Global variables
	var _c, _d, _e, _g;
	(function() {

		_g = {
			$wndw : $(window),
			$docu : $(document),
			$html : $('html'),
			$body : $('body')
		};


		//	Classnames, Datanames, Eventnames
		_c = {};
		_d = {};
		_e = {};

		$.each( [ _c, _d, _e ],
			function( i, o )
			{
				o.add = function( a )
				{
					a = a.split( ' ' );
					for ( var b = 0, l = a.length; b < l; b++ )
					{
						o[ a[ b ] ] = o.dm( a[ b ] );
					}
				};
			}
		);

		//	Classnames
		_c.dm = function( c ) { return 'dm-' + c; };
		_c.add( 'selected hidden' );

		//	Datanames
		_d.dm = function( d ) { return 'dm-' + d; };
		_d.add( 'class' );

		//	Eventnames
		_e.dm = function( e ) { return e + '.dm'; };
		_e.add( 'load resize mouseenter mouseleave' );


		$[ _PLUGIN_ ]._c = _c;
		$[ _PLUGIN_ ]._d = _d;
		$[ _PLUGIN_ ]._e = _e;
		$[ _PLUGIN_ ]._g = _g;
	})();

})( jQuery );
