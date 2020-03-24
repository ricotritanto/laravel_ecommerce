(function( $ ) {

	const _PLUGIN_  = 'dmenu';
	const _BLOCK_	= 'submenu';
	const _MODIF_	= 'border';


	$[ _PLUGIN_ ].options[ _BLOCK_ ][ _MODIF_ ] = false;


	var _c = $[ _PLUGIN_ ]._c,
		_d = $[ _PLUGIN_ ]._d,
		_e = $[ _PLUGIN_ ]._e,
		_g = $[ _PLUGIN_ ]._g;


	$[ _PLUGIN_ ].code[ _BLOCK_ + '_' + _MODIF_ ] = {

		'setup': function()
		{
			if ( this.vars.submenus &&
				this.opts[ _BLOCK_ ][ _MODIF_ ] 
			) {
				this.$menu.addClass( _c.menu + '_' + _BLOCK_ + '-' + _MODIF_ );
			}
		}
	};


})( jQuery );
