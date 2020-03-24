(function( $ ) {

	const _PLUGIN_  = 'dmenu';
	const _BLOCK_	= 'submenu';
	const _MODIF_	= 'tabs';


	$[ _PLUGIN_ ].configuration.classNames.item[ _BLOCK_ + '-' + _MODIF_ ] = 'SubmenuTabs';


	var _c = $[ _PLUGIN_ ]._c,
		_d = $[ _PLUGIN_ ]._d,
		_e = $[ _PLUGIN_ ]._e,
		_g = $[ _PLUGIN_ ]._g;


	$[ _PLUGIN_ ].code[ _BLOCK_ + '_' + _MODIF_ ] = {

		'setup:after': function()
		{
			this.$items
				.filter( '.' + _c.item + '_' + _BLOCK_ + '-' + _MODIF_ )
				.addClass( _c.item + '_' + _BLOCK_ + '-fullwidth' );
		},

		'setup': function()
		{
			var that = this;

			//	Submenus
			(function() {

				that.$menu.on( 
					_e.mouseenter,
					' > ul > li.' + _c.item + '_' + _BLOCK_ + '-' + _MODIF_,
					function( e )
					{
						var $item = $(this).children( 'ul' ).children( '.' + _c.selected );
						if ( !$item.length )
						{
							$item = $(this).children( 'ul' ).children( 'li' ).first();
						}
						that[ _BLOCK_ + '-' + _MODIF_ + '-set' ]( $item );
					}
				);
				that.$menu.on( 
					_e.mouseleave,
					' > ul > li.' + _c.item + '_' + _BLOCK_ + '-' + _MODIF_,
					function( e )
					{
						that[ _BLOCK_ + '-' + _MODIF_ + '-reset' ]( $(this) );
					}
				);

				that.$menu.on( 
					_e.mouseenter,
					' > ul > li.' + _c.item + '_' + _BLOCK_ + '-' + _MODIF_ + ' > ul > li',
					function( e )
					{
						that[ _BLOCK_ + '-' + _MODIF_ + '-set' ]( $(this) );
					}
				);

			})();
		}
	}


	$[ _PLUGIN_ ].prototype[ _BLOCK_ + '-' + _MODIF_ + '-reset' ] = function( $item )
	{
		$item
			.children( 'ul' )
			.children( 'li' )
			.removeClass( _c.selected )
			.filter( '[data-' + _d.class + '*="' + _c.selected + '"]' )
			.addClass( _c.selected );
	};
	$[ _PLUGIN_ ].prototype[ _BLOCK_ + '-' + _MODIF_ + '-set' ] = function( $item )
	{
		var $list 		= $item.parent( 'ul' ),
			$submenu 	= $item.children( 'ul' );

		$list.children( 'li' )
			.removeClass( _c.selected );

		$item.addClass( _c.selected );
		

		$list.css( 'minHeight', '' );
		$submenu.css( 'minHeight', '' );

		var submenu_height 	= $submenu.outerHeight() ,
			list_height 	= $list.outerHeight();

		var height = Math.max( submenu_height, list_height );

		$list.css({
			'minHeight': height + parseInt( $list.css( 'border-top-width' ), 10 )
		});
		$submenu.css({
			'minHeight': height 
		});
	};


})( jQuery );
