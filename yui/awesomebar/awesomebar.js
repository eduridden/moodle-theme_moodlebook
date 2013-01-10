YUI.add('moodle-theme_moodlebook-awesomebar', function(Y) {

/**
 * Splash theme colour switcher class.
 * Initialise this class by calling M.theme_splash.init
 */
var AwesomeBar = function() {
    AwesomeBar.superclass.constructor.apply(this, arguments);
};
AwesomeBar.prototype = {
    prev : [],
    initializer : function(config) {
        Y.all('.moodlebook-awesome-bar ul.dropdown li > span').each(this.enhanceAwesomeBar, this);
        Y.all('.moodlebook-awesome-bar ul.dropdown li.clickable-with-children > a').each(this.enhanceAwesomeBar, this);
    },
    enhanceAwesomeBar : function(menuitem) {
        var level = 0;
        try {
            level = menuitem.ancestors('ul')._nodes.length;
        } catch(x) {
            // Old version of YUI - no ancestors() method
            var temp = menuitem;
            while(temp) {
                level++;
                temp = temp.ancestor('ul');
            }
        }
        menuitem = menuitem.ancestor('li');
        menuitem.on('mouseover', function(e, item) {
            if(this.prev[level]) {
                window.clearTimeout(this.prev[level].hovertimer);
                this.prev[level].removeClass('extended-hover');
            }
            this.prev[level] = menuitem;
            if(item.hovertimer) window.clearTimeout(item.hovertimer);
            item.addClass('extended-hover');
            if(level >= 2) { // don't try shifting initial dropdown
                var submenu = menuitem.one('ul');
                if(submenu == null) return;
                submenu.setStyle('top', '');
                var winbottom = Y.one("body").get("winHeight");
                var scroll = document.documentElement.scrollTop || document.body.scrollTop;
                var bottom = submenu.getY() + submenu.get('clientHeight') - scroll;
                if(bottom > winbottom) {
                    submenu.setStyle('top', (-1*(bottom-winbottom)-1)+'px');
                }
            }
        }, this, menuitem);
        menuitem.on('mouseout', function(e, item) {
            item.hovertimer = window.setTimeout(function(){item.removeClass('extended-hover')}, 500);
        }, this, menuitem);
    }
};
// Make the AwesomeBar enhancer a fully fledged YUI module
Y.extend(AwesomeBar, Y.Base, AwesomeBar.prototype, {
    NAME : 'moodlebook theme AwesomeBar enhancer',
    ATTRS : {
        // No attributes at present
    }
});
// Our splash theme namespace
M.theme_moodlebook = M.theme_moodlebook || {};
// Initialisation function for the AwesomeBar enhancer
M.theme_moodlebook.initAwesomeBar = function(cfg) {
    return new AwesomeBar(cfg);
}

}, '@VERSION@', {requires:['base','node']});