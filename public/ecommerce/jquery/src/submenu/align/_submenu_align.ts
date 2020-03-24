(function( $ ) {

	const _PLUGIN_  = 'dmenu';
	const _BLOCK_	= 'submenu';
	const _MODIF_	= 'align';


	$[ _PLUGIN_ ].configuration.classNames.item[ 	_BLOCK_ + '-' + _MODIF_ + '-right' ] = 'SubmenuAlignRight';
	$[ _PLUGIN_ ].configuration.classNames.subitem[ _BLOCK_ + '-' + _MODIF_ + '-right' ] = 'SubSubmenuAlignRight';


	var _c = $[ _PLUGIN_ ]._c,
		_d = $[ _PLUGIN_ ]._d,
		_e = $[ _PLUGIN_ ]._e,
		_g = $[ _PLUGIN_ ]._g;


	$[ _PLUGIN_ ].prototype._submenuOverflowsLeft = function( $submenu )
	{
		return $submenu.offset().left < 0;
	};
	$[ _PLUGIN_ ].prototype._submenuOverflowsRight = function( $submenu )
	{
		return $submenu.offset().left + $submenu.outerWidth() > _g.$wndw.width();
	};


	$[ _PLUGIN_ ].code[ _BLOCK_ + '_' + _MODIF_ ] = {
	
		'setup': function()
		{
			var that = this;

			//	Submenus
			(function() {
				var cls_sub_right = _c.item + '_' + _BLOCK_ + '-' + _MODIF_ + '-right',
					cls_sub_fullw = _c.item + '_' + _BLOCK_ + '-fullwidth';

				that.$menu.on( 
					_e.mouseenter,
					' > ul > li.' + _c.item + '_parent',
					function( e )
					{
						var $item = $(this),
							$submenu = $item.children( 'ul' );

						// Fullwidth submenus always fit :)
						if ( $item.hasClass( cls_sub_fullw ) )
						{
							return;
						}

						var changed = false;

						//	If aligned right
						if ( $item.hasClass( cls_sub_right ) )
						{
							//	Doesn't fit left when aligned right
							//		-> align left
							if ( that._submenuOverflowsLeft( $submenu ) )
							{
								$item.removeClass( cls_sub_right );
								changed = true;
							}
						}

						//	If aligned left
						else
						{
							//	Doesn't fit right when aligned left
							//		-> align right
							if ( that._submenuOverflowsRight( $submenu ) )
							{
								$item.addClass( cls_sub_right );
								changed = true;
							}
						}

						//	Doesn't fit aligned left or right
						//		-> make full width
						if ( changed )
						{
							if ( that._submenuOverflowsLeft( $submenu ) || that._submenuOverflowsRight( $submenu ) )
							{
								$item.addClass( cls_sub_fullw );
							}
						}
					}
				);

				that.$menu.on( 
					_e.mouseleave,
					' > ul > li.' + _c.item + '_parent',
					function( e )
					{
						var $item = $(this);

						if ( $item.is( '[data-' + _d.class + '*="' + cls_sub_right + '"]' ) )
						{
							$item.addClass( cls_sub_right );
						}
						else
						{
							$item.removeClass( cls_sub_right );
						}

						if ( !$item.is( '[data-' + _d.class + '*="' + cls_sub_fullw + '"]' ) )
						{
							$item.removeClass( cls_sub_fullw );
						}
					}
				);
			})();


			//	Sub-submenus
			(function() {

				var cls_sub_right = _c.subitem + '_' + _BLOCK_ + '-' + _MODIF_ + '-right';

				that.$menu.on( 
					_e.mouseenter,
					' li li.' + _c.item + '_parent',
					function( e )
					{
						var $item = $(this),
							$submenu = $item.children( 'ul' );

						//	If aligned right
						if ( $item.hasClass( cls_sub_right ) )
						{
							//	Doesn't fit left when aligned right
							//		-> align left
							if ( that._submenuOverflowsLeft( $submenu ) )
							{
								$item.removeClass( cls_sub_right );
							}
						}

						//	If aligned left
						else
						{
							//	Doesn't fit right when aligned left
							//		-> align right
							if ( that._submenuOverflowsRight( $submenu ) )
							{
								$item.addClass( cls_sub_right );
							}
						}
					}
				);

				that.$menu.on( 
					_e.mouseleave,
					'li li.' + _c.item + '_parent',
					function( e )
					{
						var $item = $(this);

						if ( $item.is( '[data-' + _d.class + '*="' + cls_sub_right + '"]' ) )
						{
							$item.addClass( cls_sub_right );
						}
						else
						{
							$item.removeClass( cls_sub_right );
						}
					}
				);

			})();
		}
	};


})( jQuery );
