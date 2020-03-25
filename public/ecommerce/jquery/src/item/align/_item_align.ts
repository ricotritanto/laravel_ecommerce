(function( $ ) {

	const _PLUGIN_  = 'dmenu';
	const _BLOCK_	= 'item';
	const _MODIF_	= 'align';


	$[ _PLUGIN_ ].configuration.classNames[ _BLOCK_ ][ _MODIF_ + '-right' ] = 'AlignRight';


	var _c = $[ _PLUGIN_ ]._c,
		_d = $[ _PLUGIN_ ]._d,
		_e = $[ _PLUGIN_ ]._e,
		_g = $[ _PLUGIN_ ]._g;


	$[ _PLUGIN_ ].code[ _BLOCK_ + '_' + _MODIF_ ] = {

		'resize:after': function()
		{
			if ( !this.opts.menu[ _MODIF_ ] ||
				this.opts.menu[ _MODIF_ ] == 'left'
			) {
				this.$items
					.filter( '.' + _c[ _BLOCK_ ] + '_' + _MODIF_ + '-right' )
					.css( 'margin-left', '' )
					.not( '.' + _c.hidden )
					.first()
					.css( 'margin-left', 'auto' );
			}
		}
	};


})( jQuery );
