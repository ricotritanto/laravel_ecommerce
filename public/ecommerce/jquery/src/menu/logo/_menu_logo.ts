(function( $ ) {

	const _PLUGIN_  = 'dmenu';
	const _BLOCK_	= 'menu';
	const _MODIF_ 	= 'logo';


	$[ _PLUGIN_ ].options[ _BLOCK_ ][ _MODIF_ ] = true;


	var _c = $[ _PLUGIN_ ]._c,
		_d = $[ _PLUGIN_ ]._d,
		_e = $[ _PLUGIN_ ]._e,
		_g = $[ _PLUGIN_ ]._g;


	$[ _PLUGIN_ ].code[ _BLOCK_ + '_' + _MODIF_ ] = {

		'setup': function()
		{
			if ( this.opts[ _BLOCK_ ][ _MODIF_ ] && 
				this.$menu.children().first().is( 'a[style*=background-image:]' )
			) {
				this.$menu.addClass( _c[ _BLOCK_ ] + '_' + _MODIF_ );
			}
		}
	};


})( jQuery );
