/* ----------------------------------------------------- */
/* This file for register button insert shortcode to TinyMCE
 /* ----------------------------------------------------- */
(function () {
	tinymce.create( 'tinymce.plugins.penci_pre_shortcodes_button', {
		init         : function ( ed, url ) {
			title = 'penci_pre_shortcodes_button';
			tinymce.plugins.penci_pre_shortcodes_button.theurl = url;
			ed.addButton( 'penci_pre_shortcodes_button', {
				title: 'Select Shortcode',
				icon : 'wp_code',
				type : 'menubutton',
				/* List Button */
				menu : [

					/* --- Blockquote --- */
					{
						text   : 'Blockquote',
						value  : 'Blockquote',
						onclick: function () {
							ed.windowManager.open( {
								title   : 'Blockquote',
								body    : [
									{ type    : 'listbox', name    : 'align', label   : 'Quote Align', 'values': [{ text: 'None', value: 'none' }, { text: 'Aligh Left', value: 'left' }, { text: 'Aligh Right', value: 'right' }] },
									{ type: 'textbox', name: 'author', label: 'Quote Author', value: '' },
								],
								onsubmit: function ( e ) {
									content = ed.selection.getContent();
									ed.insertContent( '[blockquote align="' + e.data.align + '" author="' + e.data.author + '"]' + content + '[/blockquote]' );
								}
							} );
						}
					},

					/* -----------	Columns Simple	-----------	*/
					{
						text   : 'Columns',
						value  : 'Columns',
						onclick: function () {
							ed.windowManager.open( {
								title   : 'Column',
								body    : [
									{ type    : 'listbox', name    : 'size', label   : 'Select type of column', 'values': [{ text: '1/2', value: '1/2' }, { text: '1/3', value: '1/3' }, { text: '2/3', value: '2/3' }, { text: '1/4', value: '1/4' }, { text: '3/4', value: '3/4' },] },
									{ type: 'checkbox', name: 'last', label: 'Last column?', checked: false, }
								],
								onsubmit: function ( e ) {
									content = ed.selection.getContent();
									ed.insertContent( '[columns size="' + e.data.size + '" last="' + e.data.last + '"]' + content + '[/columns]' );
								}
							} );
						}

					},
					
					/* --- Portfolio--- */
					{
						text   : 'Portfolio',
						value  : 'Portfolio',
						onclick: function () {
							ed.windowManager.open( {
								title   : 'Portfolio',
								body    : [
									{ type    : 'listbox', name    : 'style', label   : 'Portfolio Style', 'values': [{ text: 'Masonry', value: 'masonry' }, { text: 'Grid', value: 'grid' }] },
									{ type : 'textbox', name : 'cat', label: 'Portfolio Categories Slug To Display. E.g: cat-1, cat-2' },
									{ type : 'textbox', name : 'number', label: 'Numbers Post to Show? If you want display all, fill -1', value: '-1' },
									{ type    : 'listbox', name    : 'filter', label   : 'Display Filter?', 'values': [{ text: 'Yes', value: 'true' }, { text: 'No', value: 'false' }] },
									{ type    : 'listbox', name    : 'column', label   : 'Number Columns?', 'values': [{ text: '3 Columns', value: '3' }, { text: '2 Columns', value: '2' }] },
									{ type: 'textbox', name: 'all_text', label: 'All text', value: 'All' },
								],
								onsubmit: function ( e ) {
									ed.insertContent( '[portfolio style="' + e.data.style + '" cat="' + e.data.cat + '" number="' + e.data.number + '" filter="' + e.data.filter + '" column="' + e.data.column + '" all_text="' + e.data.all_text + '" /]' );
								}
							} );
						}
					},
					
					/* --- Penci Recipe --- */
					{
						text   : 'Penci Recipe',
						value  : 'Penci Recipe',
						onclick: function () {
							ed.insertContent( '[penci_recipe]' );
						}
					},

					/* --- Penci Recipe Index--- */
					{
						text   : 'Penci Recipe Index',
						value  : 'Penci Recipe Index',
						onclick: function () {
							ed.windowManager.open( {
								title   : 'Penci Recipe Index',
								body    : [
									{ type : 'textbox', name : 'title', label: 'Recipe Index Title', value: 'My Recipe Index' },
									{ type : 'textbox', name : 'cat', label: 'Recipe Index Category Slug' },
									{ type : 'textbox', name : 'numbers_posts', label: 'Numbers Posts to Show?', value: '3' },
									{ type    : 'listbox', name    : 'columns', label   : 'Select Columns', 'values': [{ text: '3 Columns', value: '3' }, { text: '2 Columns', value: '2' }, { text: '4 Columns', value: '4' }] },
									{ type    : 'listbox', name    : 'display_title', label   : 'Display Posts Title?', 'values': [{ text: 'Yes', value: 'yes' }, { text: 'No', value: 'no' }] },
									{ type    : 'listbox', name    : 'display_cat', label   : 'Display Posts Categories?', 'values': [{ text: 'No', value: 'no' }, { text: 'Yes', value: 'yes' }] },
									{ type    : 'listbox', name    : 'display_date', label   : 'Display Posts Date?', 'values': [{ text: 'Yes', value: 'yes' }, { text: 'No', value: 'no' }] },
									{ type    : 'listbox', name    : 'display_image', label   : 'Display Posts Featured Image?', 'values': [{ text: 'Yes', value: 'yes' }, { text: 'No', value: 'no' }] },
									{ type    : 'listbox', name    : 'image_size', label   : 'Images Size for Featured Image', 'values': [{ text: 'Square', value: 'square' }, { text: 'Vertical', value: 'vertical' }, { text: 'Horizontal', value: 'horizontal' }] },
									{ type    : 'listbox', name    : 'cat_link', label   : 'Display View All Posts ( Category Link )?', 'values': [{ text: 'Yes', value: 'yes' }, { text: 'No', value: 'no' }] },
									{ type : 'textbox', name : 'cat_link_text', label: 'Custom "View All" button text', value: 'View All' }
								],
								onsubmit: function ( e ) {
									ed.insertContent( '[penci_index title="' + e.data.title + '" cat="' + e.data.cat + '" numbers_posts="' + e.data.numbers_posts + '" columns="' + e.data.columns + '" display_title="' + e.data.display_title + '" display_cat="' + e.data.display_cat + '" display_date="' + e.data.display_date + '" display_image="' + e.data.display_image + '" image_size="' + e.data.image_size + '" cat_link="' + e.data.cat_link + '" cat_link_text="' + e.data.cat_link_text + '" /]' );
								}
							} );
						}
					},
				]
			} );

		},
		createControl: function ( n, cm ) {
			return null;
		}
	} );

	tinymce.PluginManager.add( 'penci_pre_shortcodes_button', tinymce.plugins.penci_pre_shortcodes_button );

})();