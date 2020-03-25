(function( $ ) {

	const _PLUGIN_  = 'dmenu';
	const _BLOCK_	= 'submenu';
	const _MODIF_	= 'mega'


	$[ _PLUGIN_ ].configuration.classNames.item[ _BLOCK_ + '-' + _MODIF_ ] = 'SubmenuMega';


	var _c = $[ _PLUGIN_ ]._c,
		_d = $[ _PLUGIN_ ]._d,
		_e = $[ _PLUGIN_ ]._e,
		_g = $[ _PLUGIN_ ]._g;


	$[ _PLUGIN_ ].code[ _BLOCK_ + '_' + _MODIF_ ] = {

		'setup:after': function()
		{
			this.$menu.find( 'li' )
				.filter( '.' + _c.item + '_' + _BLOCK_ + '-' + _MODIF_ )
				.children( 'ul' )
				.children( 'li' )
				.addClass( _c.subitem + '_' + _BLOCK_ + '-inline' );
		}
	};


})( jQuery );
