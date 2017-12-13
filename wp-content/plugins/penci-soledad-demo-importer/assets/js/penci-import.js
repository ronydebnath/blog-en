jQuery( document ).ready( function( $ ) {
	"use strict";

	var penci_soledaddi = {
		init: function() {
			this.$progress = $( '#penci-soledad-demo-import-progress' );
			this.$log = $( '#penci-soledad-demo-import-log' );
			this.$importer = $( '#penci-soledad-demo-importer' );
			this.steps = ['content', 'customizer', 'widgets', 'sliders'];

			if ( ! this.$importer.length ) {
				return;
			}

			/**
			 * The first step: download content file
			 */
			this.download( penci_soledaddi.steps.shift() );
		},

		download: function( type ) {
			penci_soledaddi.log( 'Downloading ' + type + ' file' );

			$.get(
				ajaxurl,
				{
					action: 'penci_soledad_download_file',
					type: type,
					demo: penci_soledaddi.$importer.find( 'input[name="demo"]' ).val(),
					_wpnonce: penci_soledaddi.$importer.find( 'input[name="_wpnonce"]' ).val()
				},
				function( response ) {
					if ( response.success ) {
						penci_soledaddi.import( type );
					} else {
						penci_soledaddi.log( response.data );

						if ( penci_soledaddi.steps.length ) {
							penci_soledaddi.download( penci_soledaddi.steps.shift() );
						} else {
							penci_soledaddi.configTheme();
						}
					}
				}
			).fail( function() {
				penci_soledaddi.log( 'Failed' );
			} );
		},

		import: function( type ) {
			penci_soledaddi.log( 'Importing ' + type );

			var data = {
					action: 'penci_soledad_import',
					type: type,
					_wpnonce: penci_soledaddi.$importer.find( 'input[name="_wpnonce"]' ).val()
				};
			var url = ajaxurl + '?' + $.param( data );
			var evtSource = new EventSource( url );

			evtSource.addEventListener( 'message', function ( message ) {
				var data = JSON.parse( message.data );

				switch ( data.action ) {
					case 'updateTotal':
						console.log( data.delta );
						break;

					case 'updateDelta':
						console.log(data.delta);
						break;

					case 'complete':
						evtSource.close();
						penci_soledaddi.log( type + ' has been imported successfully!' );

						if ( penci_soledaddi.steps.length ) {
							penci_soledaddi.download( penci_soledaddi.steps.shift() );
						} else {
							penci_soledaddi.configTheme();
						}

						break;
				}
			} );

			evtSource.addEventListener( 'log', function ( message ) {
				var data = JSON.parse( message.data );
				penci_soledaddi.log( data.message );
			});
		},

		configTheme: function() {
			$.get(
				ajaxurl,
				{
					action: 'penci_soledad_config_theme',
					demo: penci_soledaddi.$importer.find( 'input[name="demo"]' ).val(),
					_wpnonce: penci_soledaddi.$importer.find( 'input[name="_wpnonce"]' ).val()
				},
				function( response ) {
					if ( response.success ) {
						penci_soledaddi.generateImages();
					}

					penci_soledaddi.log( response.data );
				}
			).fail( function() {
				penci_soledaddi.log( 'Failed' );
			} );
		},

		generateImages: function() {
			$.get(
				ajaxurl,
				{
					action: 'penci_soledad_get_images',
					_wpnonce: penci_soledaddi.$importer.find( 'input[name="_wpnonce"]' ).val()
				},
				function( response ) {
					if ( ! response.success ) {
						penci_soledaddi.log( response.data );
						penci_soledaddi.log( 'Import completed!' );
						penci_soledaddi.$progress.find( '.spinner' ).hide();
						return;
					} else {
						var ids = response.data;

						if ( ! ids.length ) {
							penci_soledaddi.log( 'Import completed!' );
							penci_soledaddi.$progress.find( '.spinner' ).hide();
						}

						penci_soledaddi.log( 'Starting generate ' + ids.length + ' images' );

						penci_soledaddi.generateSingleImage( ids );
					}
				}
			);
		},

		generateSingleImage: function( ids ) {
			if ( ! ids.length ) {
				penci_soledaddi.log( 'Import completed!' );
				penci_soledaddi.$progress.find( '.spinner' ).hide();
				return;
			}

			var id = ids.shift();

			$.get(
				ajaxurl,
				{
					action: 'penci_soledad_generate_image',
					id: id,
					_wpnonce: penci_soledaddi.$importer.find( 'input[name="_wpnonce"]' ).val()
				},
				function( response ) {
					penci_soledaddi.log( response.data + ' (' + ids.length + ' images left)' );

					penci_soledaddi.generateSingleImage( ids );
				}
			);
		},

		log: function( message ) {
			penci_soledaddi.$progress.find( '.text' ).text( message );
			penci_soledaddi.$log.prepend( '<p>' + message + '</p>' );
		}
	};


	penci_soledaddi.init();
} );
