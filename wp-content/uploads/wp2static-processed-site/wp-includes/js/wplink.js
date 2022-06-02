/**
 * @output wp-includes/js/wplink.js
 */

 /* global wpLink */

( function( $, wpLinkL10n, wp ) {
	var editor, searchTimer, River, Query, correctedURL,
		emailRegexp = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,63}$/i,
		urlRegexp = /^(https?|ftp):\/\/[A-Z0-9.-]+\.[A-Z]{2,63}[^ "]*$/i,
		inputs = {},
		rivers = {},
		isTouch = ( 'ontouchend' in document );

	function getLink() {
		if ( editor ) {
			return editor.$( 'a[data-wplink-edit="true"]' );
		}

		return null;
	}

	window.wpLink = {
		timeToTriggerRiver: 150,
		minRiverAJAXDuration: 200,
		riverBottomThreshold: 5,
		keySensitivity: 100,
		lastSearch: '',
		textarea: '',
		modalOpen: false,

		init: function() {
			inputs.wrap = $('#wp-link-wrap');
			inputs.dialog = $( '#wp-link' );
			inputs.backdrop = $( '#wp-link-backdrop' );
			inputs.submit = $( '#wp-link-submit' );
			inputs.close = $( '#wp-link-close' );

			// Input.
			inputs.text = $( '#wp-link-text' );
			inputs.url = $( '#wp-link-url' );
			inputs.nonce = $( '#_ajax_linking_nonce' );
			inputs.openInNewTab = $( '#wp-link-target' );
			inputs.search = $( '#wp-link-search' );

			// Build rivers.
			rivers.search = new River( $( '#search-results' ) );
			rivers.recent = new River( $( '#most-recent-results' ) );
			rivers.elements = inputs.dialog.find( '.query-results' );

			// Get search notice text.
			inputs.queryNotice = $( '#query-notice-message' );
			inputs.queryNoticeTextDefault = inputs.queryNotice.find( '.query-notice-default' );
			inputs.queryNoticeTextHint = inputs.queryNotice.find( '.query-notice-hint' );

			// Bind event handlers.
			inputs.dialog.on( 'keydown', wpLink.keydown );
			inputs.dialog.on( 'keyup', wpLink.keyup );
			inputs.submit.on( 'click', function( event ) {
				event.preventDefault();
				wpLink.update();
			});

			inputs.close.add( inputs.backdrop ).add( '#wp-link-cancel button' ).on( 'click', function( event ) {
				event.preventDefault();
				wpLink.close();
			});

			rivers.elements.on( 'river-select', wpLink.updateFields );

			// Display 'hint' message when search field or 'query-results' box are focused.
			inputs.search.on( 'focus.wplink', function() {
				inputs.queryNoticeTextDefault.hide();
				inputs.queryNoticeTextHint.removeClass( 'screen-reader-text' ).show();
			} ).on( 'blur.wplink', function() {
				inputs.queryNoticeTextDefault.show();
				inputs.queryNoticeTextHint.addClass( 'screen-reader-text' ).hide();
			} );

			inputs.search.on( 'keyup input', function() {
				window.clearTimeout( searchTimer );
				searchTimer = window.setTimeout( function() {
					wpLink.searchInternalLinks();
				}, 500 );
			});

			inputs.url.on( 'paste', function() {
				setTimeout( wpLink.correctURL, 0 );
			} );

			inputs.url.on( 'blur', wpLink.correctURL );
		},

		// If URL wasn't corrected last time and doesn't start with http:, https:, ? # or /, prepend http://.
		correctURL: function () {
			var url = inputs.url.val().trim();

			if ( url && correctedURL !== url && ! /^(?:[a-z]+:|#|\?|\.|\/)/.test( url ) ) {
				inputs.url.val( 'http://' + url );
				correctedURL = url;
			}
		},

		open: function( editorId, url, text ) {
			var ed,
				$body = $( document.body );

			$body.addClass( 'modal-open' );
			wpLink.modalOpen = true;

			wpLink.range = null;

			if ( editorId ) {
				window.wpActiveEditor = editorId;
			}

			if ( ! window.wpActiveEditor ) {
				return;
			}

			this.textarea = $( '#' + window.wpActiveEditor ).get( 0 );

			if ( typeof window.tinymce !== 'undefined' ) {
				// Make sure the link wrapper is the last element in the body,
				// or the inline editor toolbar may show above the backdrop.
				$body.append( inputs.backdrop, inputs.wrap );

				ed = window.tinymce.get( window.wpActiveEditor );

				if ( ed && ! ed.isHidden() ) {
					editor = ed;
				} else {
					editor = null;
				}
			}

			if ( ! wpLink.isMCE() && document.selection ) {
				this.textarea.focus();
				this.range = document.selection.createRange();
			}

			inputs.wrap.show();
			inputs.backdrop.show();

			wpLink.refresh( url, text );

			$( document ).trigger( 'wplink-open', inputs.wrap );
		},

		isMCE: function() {
			return editor && ! editor.isHidden();
		},

		refresh: function( url, text ) {
			var linkText = '';

			// Refresh rivers (clear links, check visibility).
			rivers.search.refresh();
			rivers.recent.refresh();

			if ( wpLink.isMCE() ) {
				wpLink.mceRefresh( url, text );
			} else {
				// For the Text editor the "Link text" field is always shown.
				if ( ! inputs.wrap.hasClass( 'has-text-field' ) ) {
					inputs.wrap.addClass( 'has-text-field' );
				}

				if ( document.selection ) {
					// Old IE.
					linkText = document.selection.createRange().text || text || '';
				} else if ( typeof this.textarea.selectionStart !== 'undefined' &&
					( this.textarea.selectionStart !== this.textarea.selectionEnd ) ) {
					// W3C.
					text = this.textarea.value.substring( this.textarea.selectionStart, this.textarea.selectionEnd ) || text || '';
				}

				inputs.text.val( text );
				wpLink.setDefaultValues();
			}

			if ( isTouch ) {
				// Close the onscreen keyboard.
				inputs.url.trigger( 'focus' ).trigger( 'blur' );
			} else {
				/*
				 * Focus the URL field and highlight its contents.
				 * If this is moved above the selection changes,
				 * IE will show a flashing cursor over the dialog.
				 */
				window.setTimeout( function() {
					inputs.url[0].select();
					inputs.url.trigger( 'focus' );
				} );
			}

			// Load the most recent results if this is the first time opening the panel.
			if ( ! rivers.recent.ul.children().length ) {
				rivers.recent.ajax();
			}

			correctedURL = inputs.url.val().replace( /^http:\/\//, '' );
		},

		hasSelectedText: function( linkNode ) {
			var node, nodes, i, html = editor.selection.getContent();

			// Partial html and not a fully selected anchor element.
			if ( /</.test( html ) && ( ! /^<a [^>]+>[^<]+<\/a>$/.test( html ) || html.indexOf('href=') === -1 ) ) {
				return false;
			}

			if ( linkNode.length ) {
				nodes = linkNode[0].childNodes;

				if ( ! nodes || ! nodes.length ) {
					return false;
				}

				for ( i = nodes.length - 1; i >= 0; i-- ) {
					node = nodes[i];

					if ( node.nodeType != 3 && ! window.tinymce.dom.BookmarkManager.isBookmarkNode( node ) ) {
						return false;
					}
				}
			}

			return true;
		},

		mceRefresh: function( searchStr, text ) {
			var linkText, href,
				linkNode = getLink(),
				onlyText = this.hasSelectedText( linkNode );

			if ( linkNode.length ) {
				linkText = linkNode.text();
				href = linkNode.attr( 'href' );

				if ( ! linkText.trim() ) {
					linkText = text || '';
				}

				if ( searchStr && ( urlRegexp.test( searchStr ) || emailRegexp.test( searchStr ) ) ) {
					href = searchStr;
				}

				if ( href !== '_wp_link_placeholder' ) {
					inputs.url.val( href );
					inputs.openInNewTab.prop( 'checked', '_blank' === linkNode.attr( 'target' ) );
					inputs.submit.val( wpLinkL10n.update );
				} else {
					this.setDefaultValues( linkText );
				}

				if ( searchStr && searchStr !== href ) {
					// The user has typed something in the inline dialog. Trigger a search with it.
					inputs.search.val( searchStr );
				} else {
					inputs.search.val( '' );
				}

				// Always reset the search.
				window.setTimeout( function() {
					wpLink.searchInternalLinks();
				} );
			} else {
				linkText = editor.selection.getContent({ format: 'text' }) || text || '';
				this.setDefaultValues( linkText );
			}

			if ( onlyText ) {
				inputs.text.val( linkText );
				inputs.wrap.addClass( 'has-text-field' );
			} else {
				inputs.text.val( '' );
				inputs.wrap.removeClass( 'has-text-field' );
			}
		},

		close: function( reset ) {
			$( document.body ).removeClass( 'modal-open' );
			wpLink.modalOpen = false;

			if ( reset !== 'noReset' ) {
				if ( ! wpLink.isMCE() ) {
					wpLink.textarea.focus();

					if ( wpLink.range ) {
						wpLink.range.moveToBookmark( wpLink.range.getBookmark() );
						wpLink.range.select();
					}
				} else {
					if ( editor.plugins.wplink ) {
						editor.plugins.wplink.close();
					}

					editor.focus();
				}
			}

			inputs.bac