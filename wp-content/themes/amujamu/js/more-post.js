jQuery( document ).ready( function ( $ ) {
	var offset;
	jQuery( 'body' ).on( 'click', '.penci-ajax-more-click .penci-ajax-more-button', function ( event ) {
		if ( !$( this ).hasClass( 'loading-posts' ) ) {
			var $this = $( this ),
				layout = $this.data( 'layout' ),
				ppp = $this.data( 'number' ),
				mes = $this.data( 'mes' ),
				offset = $( this ).attr( 'data-offset' ),
				exclude = $this.data( 'exclude' ),
				from = $this.data( 'from' ),
				template = $this.data( 'template' );

			$this.addClass( 'loading-posts' );

			$.ajax( {
				type    : "POST",
				dataType: "html",
				url     : ajax_var_more.url,
				data    : 'offset=' + offset + '&layout=' + layout + '&exclude=' + exclude + '&from=' + from + '&template=' + template + '&ppp=' + ppp + '&action=penci_more_post_ajax&nonce=' + ajax_var_more.nonce,
				success : function ( data ) {
					if ( data ) {
						var data_offset = parseInt( offset ) + ppp,
							$wrap_content = $this.parent().parent().find('.penci-wrapper-data');

						$this.attr( 'data-offset', data_offset );
						if ( layout === 'masonry' || layout === 'masonry-2' ) {
							var $data = $( data );
							$wrap_content.append( $data ).isotope( 'appended', $data ).imagesLoaded( function () {
								$wrap_content.isotope( 'layout' );
							} );

							$( ".container" ).fitVids();

                            $('.penci-wrapper-data .penci-owl-carousel-slider').each(function () {
                                var $this = $(this),
	                                $rtl = false;
	                            if( $('html').attr('dir') === 'rtl' ) {
		                            $rtl = true;
	                            }
                                var owl_args = {
	                                rtl               : $rtl,
	                                loop              : true,
	                                margin            : 0,
	                                items             : 1,
	                                navSpeed          : 600,
	                                lazyLoad          : true,
	                                dotsSpeed         : 600,
	                                nav               : true,
	                                dots              : false,
	                                navText           : ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
	                                autoplay          : true,
	                                autoplayTimeout   : 5000,
	                                autoHeight        : true,
	                                autoplayHoverPause: true,
	                                autoplaySpeed     : 600
                                };

                                $this.owlCarousel(owl_args);
                            });

							if( $().easyPieChart ) {
								$( '.penci-piechart' ).each( function () {
									var $this = $( this );
									$this.one( 'inview', function ( event, isInView, visiblePartX, visiblePartY ) {
										var chart_args = {
											barColor  : $this.data( 'color' ),
											trackColor: $this.data( 'trackcolor' ),
											scaleColor: false,
											lineWidth : $this.data( 'thickness' ),
											size      : $this.data( 'size' ),
											animate   : 1000
										};
										$this.easyPieChart( chart_args );
									} ); // bind inview
								} ); // each
							}

						} else {
							var $data = $( data );
							$wrap_content.append( $data );

							$('.penci-lazy').Lazy({
								effect: 'fadeIn',
								effectTime: 300,
								scrollDirection: 'both'
							});

							$( ".container" ).fitVids();

							$('.penci-wrapper-data .penci-owl-carousel-slider').each(function () {
								var $this = $(this),
									$datalazy = false,
									$rtl = false;

									if( $('html').attr('dir') === 'rtl' ) {
										$rtl = true;
									}
									if ( $this.attr('data-lazy') ) {
										$datalazy = true;
									}
								var owl_args = {
									rtl               : $rtl,
									loop              : true,
									margin            : 0,
									items             : 1,
									navSpeed          : 600,
									dotsSpeed         : 600,
									lazyLoad          : $datalazy,
									nav               : true,
									dots              : false,
									navText           : ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
									autoplay          : true,
									autoplayTimeout   : 5000,
									autoHeight        : true,
									autoplayHoverPause: true,
									autoplaySpeed     : 600
								};

								$this.imagesLoaded(function () {
									$this.owlCarousel(owl_args);
								});

								$this.on('changed.owl.carousel', function(event) {
									$('.penci-lazy').Lazy({
										effect: 'fadeIn',
										effectTime: 300,
										scrollDirection: 'both'
									});
								});
							});

							if( $().easyPieChart ) {
								$( '.penci-piechart' ).each( function () {
									var $this = $( this );
									$this.one( 'inview', function ( event, isInView, visiblePartX, visiblePartY ) {
										var chart_args = {
											barColor  : $this.data( 'color' ),
											trackColor: $this.data( 'trackcolor' ),
											scaleColor: false,
											lineWidth : $this.data( 'thickness' ),
											size      : $this.data( 'size' ),
											animate   : 1000
										};
										$this.easyPieChart( chart_args );
									} ); // bind inview
								} ); // each
							}

							if ( $().theiaStickySidebar ) {
								var top_margin = 90;
								if( $('body' ).hasClass('admin-bar') ) {
									top_margin = 122;
								}
								$('#main.penci-main-sticky-sidebar, #sidebar.penci-sticky-sidebar' ).theiaStickySidebar({
									// settings
									additionalMarginTop: top_margin
								});
							} // if sticky
						}

						$this.removeClass( 'loading-posts' );

					} else {
						$( ".penci-ajax-more-button .ajax-more-text" ).text( mes );
						$( ".penci-ajax-more-button i" ).remove();
						$this.removeClass( 'loading-posts' );
						setTimeout(function(){
							$this.remove();
						}, 1200);
					}
				},
				error   : function ( jqXHR, textStatus, errorThrown ) {
					$loader.html( jqXHR + " :: " + textStatus + " :: " + errorThrown );
				}

			} );
		}
	} );

} );