(function( $ ) {

	const _PLUGIN_  = 'dmenu';
	const _BLOCK_	= 'item';
	const _MODIF_ 	= 'icon';


	$[ _PLUGIN_ ].configuration.classNames[ _BLOCK_ ][ _MODIF_ + '-hide' ] = 'IconHidden';
	$[ _PLUGIN_ ].configuration.classNames[ _BLOCK_ ][ _MODIF_ + '-only' ] = 'IconOnly';


	var _c = $[ _PLUGIN_ ]._c,
		_d = $[ _PLUGIN_ ]._d,
		_e = $[ _PLUGIN_ ]._e,
		_g = $[ _PLUGIN_ ]._g;


	$[ _PLUGIN_ ].code[ _BLOCK_ + '_' + _MODIF_  ] = {

		'setup': function()
		{

			//	Add classes for icons
			this.$items
				.children( 'a, span' )
				.children( '.fa, .fab, .fas, .far, .fal, [data-icon]' )
				.each(
					function()
					{
						var $a = $(this).parent(),
							$i = $a.parent();

						if ( !$i.hasClass( _c[ _BLOCK_ ] + '_' + _MODIF_ + '-hide' ) &&
							 !$i.hasClass( _c[ _BLOCK_ ] + '_' + _MODIF_ + '-only' ) &&
							 !$i.hasClass( _c[ _BLOCK_ ] + '_' + _MODIF_ + '-text' )
						) {
							$i.addClass( _c[ _BLOCK_ ] + '_' + _MODIF_ + '-' + ( $a.text().length ? 'text' : 'only' ) );
						}
					}
				);
		}
	};


	//	Make the menu fit
	//		by  hiding the icon, only showing the text
	$[ _PLUGIN_ ].fitters[ _MODIF_ + '-hide' ] = {

		'order': 'all',

		'reset': function( $items )
		{
			this[ _MODIF_ + '-hide' ]( $items.filter( '[data-' + _d.class + '*="' + _c[ _BLOCK_ ] + '_' + _MODIF_ + '-hide"]' ) );
			this[ _MODIF_ + '-only' ]( $items.filter( '[data-' + _d.class + '*="' + _c[ _BLOCK_ ] + '_' + _MODIF_ + '-only"]' ) );
			this[ _MODIF_ + '-text' ]( $items.filter( '[data-' + _d.class + '*="' + _c[ _BLOCK_ ] + '_' + _MODIF_ + '-text"]' ) );
		},

		'fit': function( $items, all )
		{
			if ( this._itemsOverflow() )
			{
				var that = this;
				$items
					.filter( '[data-' + _d.class + '*="' + _c[ _BLOCK_ ] + '_' + _MODIF_ + '-text"]' )
					.each(function() {
						if ( all || that._itemsOverflow() )
						{
							that[ _MODIF_ + '-hide' ]( $(this) );
						}
					});
			}
		}
	};


	//	Make the menu fit
	//		by  hiding the text, only showing the icon
	$[ _PLUGIN_ ].fitters[ _MODIF_ + '-only' ] = {

		'order': 'all',

		'fit': function( $items, options )
		{
			if ( this._itemsOverflow() )
			{
				var that = this,
					all  = options.order == 'all';

				$items
					.filter( '[data-' + _d.class + '*="' + _c[ _BLOCK_ ] + '_' + _MODIF_ + '-"]' )
					.each(function() {
						if ( all || that._itemsOverflow() )
						{
							that[ _MODIF_ + '-only' ]( $(this) );
						}
					});
			}
		}
	};


	$[ _PLUGIN_ ].prototype[ _MODIF_ + '-reset' ] = function( $items )
	{
		$items
			.filter( '[data-' + _d.class + '*="' + _c[ _BLOCK_ ] + '_' + _MODIF_ + '-"]' )
			.removeClass( _c[ _BLOCK_ ] + '_' + _MODIF_ + '-text' )
			.removeClass( _c[ _BLOCK_ ] + '_' + _MODIF_ + '-only' )
			.removeClass( _c[ _BLOCK_ ] + '_' + _MODIF_ + '-hide' )
			.find( 'del' )
			.contents()
			.unwrap();
	};
	$[ _PLUGIN_ ].prototype[ _MODIF_ + '-hide' ] = function( $items )
	{
		this[ _MODIF_ + '-reset' ]( $items );
		$items
			.filter( '[data-' + _d.class + '*="' + _c[ _BLOCK_ ] + '_' + _MODIF_ + '-"]' )
			.addClass( _c[ _BLOCK_ ] + '_' + _MODIF_ + '-hide' )
			.each(
				function()
				{
					var $link = $(this).children( 'a, span' );
					$link
						.children( '.fa, .fab, .fas, .far, .fal, [data-icon]' )
						.wrap( '<del class="' + _c.hidden + '" />' );
				}
			);
	};
	$[ _PLUGIN_ ].prototype[ _MODIF_ + '-only' ] = function( $items )
	{
		this[ _MODIF_ + '-reset' ]( $items );
		$items
			.filter( '[data-' + _d.class + '*="' + _c[ _BLOCK_ ] + '_' + _MODIF_ + '-"]' )
			.addClass( _c[ _BLOCK_ ] + '_' + _MODIF_ + '-only' )
			.each(
				function()
				{
					var $link = $(this).children( 'a, span' );
					$link
						.contents()
						.not( $link.children( '.fa, .fab, .fas, .far, .fal, [data-icon]' ) )
						.wrap( '<del class="' + _c.hidden + '" />' );
				}
			);
	};
	$[ _PLUGIN_ ].prototype[ _MODIF_ + '-text' ] = function( $items )
	{
		this[ _MODIF_ + '-reset' ]( $items );
		$items
			.filter( '[data-' + _d.class + '*="' + _c[ _BLOCK_ ] + '_' + _MODIF_ + '-"]' )
			.addClass( _c[ _BLOCK_ ] + '_' + _MODIF_ + '-text' );
	};


})( jQuery );
