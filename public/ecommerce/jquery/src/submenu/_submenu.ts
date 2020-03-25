(function( $ ) {

	const _PLUGIN_  = 'dmenu';
	const _BLOCK_	= 'submenu';


	$[ _PLUGIN_ ].options[ _BLOCK_ ] = {};
	$[ _PLUGIN_ ]._c.add( _BLOCK_ );


	var _c = $[ _PLUGIN_ ]._c,
		_d = $[ _PLUGIN_ ]._d,
		_e = $[ _PLUGIN_ ]._e,
		_g = $[ _PLUGIN_ ]._g;


	$[ _PLUGIN_ ].code[ _BLOCK_ ] = {

		'setup:before': function()
		{
			this.vars.submenus = this.opts.submenu && this.$menu.find( 'ul ul' ).length;
		},

		'setup': function()
		{
			if ( !this.vars.submenus )
			{
				return;
			}

			this.$menu.addClass( _c.menu + '_' + _BLOCK_ );
		}
	};


	$[ _PLUGIN_ ].fitters[ 'submenu' ] = {

		'order': 'rtl',

		'reset': function( $items )
		{
			this.$menu.find( '.' + _c.item + '_' + _BLOCK_ + '-overflow' ).remove();
			$items.each(
				function()
				{
					$(this).removeClass( _c.hidden );
				}
			);
		},

		'fit': function( $items, options )
		{
			if ( this._itemsOverflow() )
			{
				var that = this,
					all  = options.order == 'all',
					ltr  = options.order != 'rtl';

				var $dropdown = $('<li class="' + _c.item + '_' + _BLOCK_ + '-overflow ' + _c.item + '_parent"><span>&hellip;</span></li>');
				this.$menu.children( 'ul' ).append( $dropdown );

				$dropdown = $('<ul />').appendTo( $dropdown );

				$items.each(
					function()
					{
						if ( all || that._itemsOverflow() )
						{
							var $clone = $(this).clone();
							$(this).addClass( _c.hidden );

							var _class = ( $clone.attr( 'class' ) || '' ).split( ' ' );
							for ( var c = 0; c < _class.length; c++ )
							{
								if ( _class[ c ].slice( 0, 3 ) == _c.dm( '' ) )
								{
									if ( _class[ c ] != _c.selected &&
										 _class[ c ] != _c.item + '_parent'
									) {
										$clone.removeClass( _class[ c ] );
									}
								}
							}

							if ( typeof that[ 'icon-hide' ] == 'function' )
							{
								that[ 'icon-hide' ]( $clone );
							}

							$clone.find( 'li' )
								.removeClass( _c.item + '_' + _BLOCK_ + '-mega' )
								.removeClass( _c.subitem + '_' + _BLOCK_ + '-inline' );

							$dropdown[ ltr ? 'append' : 'prepend' ]( $clone );
						}
					}
				);
			}
		}
	};



})( jQuery );
