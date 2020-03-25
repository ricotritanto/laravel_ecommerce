(function( $ ) {

	const _PLUGIN_  = 'dmenu';
	const _BLOCK_	= 'menu';


	$[ _PLUGIN_ ].options[ _BLOCK_ ] = {};
	$[ _PLUGIN_ ]._c.add( _BLOCK_ );


	var _c = $[ _PLUGIN_ ]._c,
		_d = $[ _PLUGIN_ ]._d,
		_e = $[ _PLUGIN_ ]._e,
		_g = $[ _PLUGIN_ ]._g;


	$[ _PLUGIN_ ].code[ _BLOCK_ ] = {

		'setup': function()
		{
			this.$menu.addClass( _c[ _BLOCK_ ] );
		}
	};

})( jQuery );
