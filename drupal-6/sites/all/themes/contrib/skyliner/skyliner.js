/* $Id: skyliner.js,v 1.1.2.3 2007/10/18 14:18:32 dvessel Exp $ */

$(document).ready(function() {
  $('#sidebar-right').slide_blocks({ fade: 1800, fadeDelay: 7000, slide: 370 });
  $('#search-theme-form').alter_search();
  $('#content-content .node .content > p').leader();
  $('#main a[@href^=http://]').mark({ useClass: 'external', filter: window.location.hostname });
});

jQuery.fn.extend({
  // Slide block behavior.
  slide_blocks : function (settings) {
    var parentRegion = this;
    settings = jQuery.extend({fade: 2000, fadeDelay: 9000, slide: 'medium'}, settings);
    $('.block', this).each(function() {
      // Process header clicks and it's behavior.
      // Just so it looks like a link.
      $('> h2', this).wrapInner('<a href="#"></a>').click(function(e){
        e.preventDefault();
        // Hide everything.
        $('.content.expanded', parentRegion).slideUp(settings.slide, function() {
          $(this).addClass('hide').removeClass('expanded');
        });
        // This determins which content block the click belonged to.
        var contentMatch = $('.content', $(this).parents('.block')).get(0);
        if ($(contentMatch).hasClass('hide')) {
          // Show the block.
          $(contentMatch).slideDown(settings.slide, function() {
            $(this).addClass('expanded').removeClass('hide');
          });
        }
        else {
          // This toggles the block contents.
          $(contentMatch).slideUp(settings.slide, function() {
            $(this).addClass('hide').removeClass('expanded');
          });
        }
      });
      // Look for the active class in blocks. When not present, just hide.
      if ($('a.active', this).length < 1) {
        $('.content', this).addClass('hide');
      }
      else {
        // Referrer and current page compared to fade or hide immediately since the fade animation isn't always wanted.
        // window.location.search looks for strings after "?" so it depends on clean urls being enabled.
        if (document.referrer != document.URL && document.referrer.indexOf(window.location.search) !== -1) {
          // This is meant to give the user a chance to keep drilling in the navigation
          // but a kill switch or 'gesture' would be nice since it obscures too.
          var fadeTimer = ($('li.expanded > a.active', this).length < 1) ? settings.fade : settings.fadeDelay;
          $('.content', this).fadeOut(fadeTimer, function() {
            $(this).addClass('hide');
            $('h2 a', this.parentNode).addClass('active');
          });
        }
        else {
          $('.content', this).addClass('hide');
          $('h2 a', this).addClass('active');
        }
      }
    });
    return this;
  },
  // Adds a class to the first occurring element and character for styling.
  leader : function() {
    $(this).each(function() {
      if ($(this).siblings('.leader').length == 0) {
        $(this).addClass('leader');
        var first = this.innerHTML.substr(0,1);
        if (/[a-zA-Z0-9]/.test(first)) {
          var node = this.firstChild;
          node.nodeValue = node.nodeValue.slice(1);
          // "first-c" = first character. Each character gets a class also for possible kerning.
          // It's recommended you set rule for all upper or lowercase if you do any letter spacing adjustments. (kerning)
          // Note: the classes for each character are all lowercase.
          $('<span class="first-c fc-'+first.toLowerCase()+'">'+first+'</span>').prependTo(this);
        }
      }
    });
    return this;
  },
  // Mark external links and add class.
  mark : function(settings) {
    settings = jQuery.extend({ useClass: '', filter: '' }, settings);
    if (settings.useClass) {
      this.each(function() {
        if ($(this).attr('href').indexOf(settings.filter) === -1) {
          $(this).addClass(settings.useClass);
        }
      });
    }
    return this;
  },
  // Alter search box.
  alter_search : function() {
    this.each(function() {
      var button_val = $('input:submit:eq(0)', this).val();
      $('input:text', this)
        .before('<span class="sbox-l"></span>')
        .after('<span class="sbox-r"></span>')
        .wrap('<span class="sbox"></span>')
        .addClass('place-holder')
        .attr('value', button_val)
        .focus(function() {
          // Clear values and set color when it's the place holder.
          if ($(this).attr('value') == button_val) {
            $(this).attr('value', '').removeClass('place-holder');
          }
        })
        .blur(function() {
          // If value is the place holder or if it's empty.
          if ($(this).attr('value') == button_val || !$(this).attr('value')) {
            $(this).addClass('place-holder').attr('value', button_val);
          }
        })
        .keyup(function(e) {
          if ($(this).attr('value')) { // Has value? Then show clear button.
            $('~.sbox-r', this.parentNode).addClass('can-clear');
          }
          else { // No value? Then hide clear button.
            $('~.sbox-r', this.parentNode).removeClass('can-clear');
          }
        });
        $('.sbox-r', this).click(function() { // Clear button click. Clears then focuses on input box.
          $('.sbox input:text', this.parentNode).attr('value', '').get(0).focus();
          $(this).removeClass('can-clear');
        });
        $('.sbox-l', this).click(function() { // Magnifying glass click. Selects text.
          $('.sbox input:text', this.parentNode).get(0).select();
        });
    });
    return this;
  }
});
