/* global NProgress */
( function () {
  "use strict";

  var Market = {

    /**
     * Start your engines!
     */
    init: function () {
      this.scrollListeners();
      this.styleTitles();
    },

    /**
     * Style article titles
     *
     * @method  styleTitles
     *
     * @return  nil
     */
    styleTitles: function () {
      var title = document.querySelector( ".article-title" ),
        bits = title.innerHTML.split( " " );

      if ( bits.length > 5 )
        bits[ Math.floor( bits.length / 2 ) ] = bits[ Math.floor( bits.length / 2 ) ] + "<br />";

      title.innerHTML = bits.join( " " );
    },

    /**
     * Add listeners for scroll events
     *
     * @method  scrollListeners
     *
     * @return  nil
     */
    scrollListeners: function () {
      var self = this,
        scroll_pos = 0,
        header = document.querySelector( ".top" ),
        scroll_time, current_scroll;

      window.addEventListener( "scroll", function () {
        clearTimeout( scroll_time );

        current_scroll = window.pageYOffset;

        window.requestAnimationFrame( function () {
          self.hideHeader( header, current_scroll, scroll_pos );
          self.scrollHeader( header, current_scroll );
        } );

        scroll_time = setTimeout( function () {
          scroll_pos = window.pageYOffset;
        }, 50 );
      } );
    },

    scrollHeader: function ( target, current_scroll ) {
      if ( current_scroll > 25 ) {
        header.classList.add( "scrolled" );
      } else {
        header.classList.remove( "scrolled" );
      }
    },

    hideHeader: function ( target, current_scroll, scroll_pos ) {
      if ( current_scroll <= scroll_pos - 25 || current_scroll <= 0 ) {
        // If the user is scrolling UP, show the header
        target.classList.remove( "hidden" );
      } else if ( current_scroll > scroll_pos + 25 && current_scroll >= 100 ) {
        // If the user is scrolling DOWN, hide the header
        target.classList.add( "hidden" );
      }
    },

  };

  document.addEventListener( "page:fetch", function () {
    NProgress.start();
  } );
  document.addEventListener( "page:change", function () {
    Branch.init();
    NProgress.done();
  } );
  document.addEventListener( "page:restore", function () {
    NProgress.remove();
  } );
  document.addEventListener( "page:load", function () {
    NProgress.done();
  } );

} )();