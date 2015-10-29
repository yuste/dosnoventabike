/*global window: false, document: false */
(function ($) {
    'use strict';

    var jsj_gallery_slideshow = window.createJSJGallerySlideshow(),
        utilities = jsj_gallery_slideshow.utilities,
        settings = jsj_gallery_slideshow.settings;

    /*jslint unparam: true*/
    $(document)
        .on('cycle-initialized', settings.autoSelector + '.jsj-gallery-slideshow-classic', function (event, optionHash) {
            var $this_gallery = $(this),
                $this_numbering = $this_gallery.parent().find(settings.numbering), // settings.numbering is the css class used for our numbering. Find it in our gallerie's container
                $this_pager = $this_gallery.parent().find(settings.pager); // settings.pager is the css class used for our page. Find it in our gallerie's container

            utilities
                .updateNumberingString($this_gallery, $this_numbering, optionHash) // Pass on our first slide);
                .setInitialHeight($this_gallery)
                .addImagePagination($this_gallery, $this_pager);
        })
        .on('cycle-before', settings.autoSelector, function (event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag) {
            var $this_gallery = $(this),
                $this_numbering = $this_gallery.parent().find(settings.numbering); // settings.numbering is the css class used for our numbering. Find it in our gallerie's container

            utilities
                .updateGalleryHeight($this_gallery, incomingSlideEl)
                .updateNumberingString($this_gallery, $this_numbering, optionHash);
        });
    /*jslint unparam: false*/

}(window.jQuery));