(function( $ ) {

	const _PLUGIN_  = 'dmenu';
	const _BLOCK_	= 'item';


	$[ _PLUGIN_ ].options[ _BLOCK_ ] = {
		fit: []
	};
	$[ _PLUGIN_ ].configuration.classNames.selected = 'Selected';
	$[ _PLUGIN_ ].configuration.classNames[ _BLOCK_ ] = {};
	$[ _PLUGIN_ ]._c.add( _BLOCK_ );


	var _c = $[ _PLUGIN_ ]._c,
		_d = $[ _PLUGIN_ ]._d,
		_e = $[ _PLUGIN_ ]._e,
		_g = $[ _PLUGIN_ ]._g;


	$[ _PLUGIN_ ].prototype._itemsOverflow = function()
	{
		return this.$menu.children( 'ul' ).height() > this.$items.not( '.' + _c.hidden ).outerHeight();
	};


	$[ _PLUGIN_ ].code[ _BLOCK_ ] = {

		'setup:before': function()
		{
			this.$items = this.$menu.children( 'ul' ).children( 'li' );
		},

		'setup': function()
		{

			//	Add "selected" class to parents
			this.$menu.find( 'li' )
				.filter( '.' + _c.selected )
				.parentsUntil( this.$menu, 'li' )	
				.addClass( _c.selected );

			//	Add "parent" class for submenus
			if ( this.vars.submenus )
			{
				this.$menu
					.find( 'ul ul' )
					.parent()
					.addClass( _c[ _BLOCK_ ] + '_parent' );
			}
		},

		'setup:finish': function()
		{
			//	Store classnames in data attribute
			this.$menu
				.find( 'li' )
				.each(
					function()
					{
						$(this).attr( 'data-' + _d.class, $(this).attr( 'class' ) );
					}
				);
		},

		'resize:before': function()
		{
			for ( var f in $[ _PLUGIN_ ].fitters )
			{
				var fitter = $[ _PLUGIN_ ].fitters[ f ];
				if ( !fitter || !fitter.reset )
				{
					continue;
				}

				fitter.reset.call( this, this.$items );
			}
		},

		'resize': function()
		{
			if ( !this.$menu.is( ':visible' ) )
			{
				return;
			}
			for ( var f = 0; f < this.opts.item.fit.length; f++ )
			{
				var fitter = $[ _PLUGIN_ ].fitters[ this.opts.item.fit[ f ].fitter ];
				if ( !fitter || !fitter.fit )
				{
					continue
				}
				
				var $items  = this.$items,
					options = this.opts.item.fit[ f ];

				if ( options.items )
				{
					$items = $items.filter( options.items );
				}
				if ( !options.order )
				{
					options.order = fitter.order;
				}
				if ( options.order == 'rtl' )
				{
					$items = $( $items.get().reverse() );
				}
				fitter.fit.call( this, $items, options );
			}
		}
	};


	$[ _PLUGIN_ ].fitters[ _BLOCK_ ] = {

		'reset': function( $items )
		{

			$items.each(
				function()
				{
					$(this).attr( 'class', $(this).attr( 'data-' + _d.class ) );
				}
			);
		}
	};


	$[ _PLUGIN_ ].fitters[ 'hide' ] = {

		'order': 'rtl',

		'reset': function( $items )
		{
			$items.removeClass( _c.hidden );
		},

		'fit': function( $items, options )
		{

			if ( this._itemsOverflow() )
			{
				var that = this,
					all  = options.order == 'all';
				
				$items.each(
					function()
					{
						if ( all || that._itemsOverflow() )
						{
							$(this).addClass( _c.hidden );
						}
					}
				);
			}
		}
	};


})( jQuery );
