/**
 * lrz3
 * https://github.com/think2011/localResizeIMG3
 * @author think2011
 */
;
(function () {
    window.URL = window.URL || window.webkitURL;
    var ua     = detect.parse(navigator.userAgent);

    /**
     * 瀹㈡埛绔帇缂╁浘鐗�
     * @param file
     * @param [options]
     * @param callback
     * @constructor
     */
    function Lrz(file, options, callback) {
        this.file     = file;
        this.callback = callback;
        this.defaults = {
            quality: 1
        };

        // 閫傚簲浼犲叆鐨勫弬鏁�
        if (callback) {
            for (var p in options) {
                this.defaults[p] = options[p];
            }
            if (this.defaults.quality > 1) this.defaults.quality = 1;
        } else {
            this.callback = options;
        }

        this.results = {
            origin   : null,
            base64   : null,
            base64Len: null,
            realw    : null,
            realh    : null
        };

        this.init();
    }

    Lrz.prototype = {
        constructor: Lrz,

        /**
         * 鍒濆鍖�
         */
        init: function () {
            var that = this;

            that.create(that.file, that.callback);
        },

        /**
         * 鐢熸垚base64
         * @param file
         * @param callback
         */
        create: function (file, callback) {
            var that    = this,
                img     = new Image(),
                results = that.results,
                blob    = (typeof file === 'string') ? file : URL.createObjectURL(file);

            img.crossOrigin = "*";
            img.onload      = function () {
                // 鑾峰緱鍥剧墖缂╂斁灏哄
                var resize = that.resize(this);

                // 鍒濆鍖朿anvas
                var canvas = document.createElement('canvas'), ctx;

                results.realw = canvas.width  = resize.w;
                results.realh = canvas.height = resize.h;
                console.log('canvas.w',canvas.width);
                console.log('canvas.h',canvas.height);
                ctx           = canvas.getContext('2d');

                // 娓叉煋鐢诲竷
                ctx.fillStyle = '#fff';
                ctx.fillRect(0, 0, resize.w, resize.h);

                // 鐢熸垚缁撴灉
                results.origin = file;

                // 鍏煎 Android
                if (ua.os.family === 'Android') {
                    ctx.drawImage(img, 0, 0, resize.w, resize.h);

                    // 浣庝簬4.5鐗堟墠浣跨敤绠楁硶鍘嬬缉
                    if (+ua.os.version < 4.5) {
                        var encoder    = new JPEGEncoder();
                        results.base64 = encoder.encode(ctx.getImageData(0, 0, canvas.width, canvas.height), that.defaults.quality * 100);
                    } else {
                        results.base64 = canvas.toDataURL('image/jpeg', that.defaults.quality);
                    }

                    // 鎵ц鍥炶皟
                    _callback(results);
                }

                // 鍏煎IOS7-IOS6
                else if (ua.os.family === 'iOS' && +ua.os.version < 8) {
                    EXIF.getData(img, function () {
                        var orientation = EXIF.getTag(this, "Orientation"),
                            mpImg       = new MegaPixImage(img);

                        mpImg.render(canvas, {
                            width      : canvas.width,
                            height     : canvas.height,
                            orientation: orientation
                        });

                        results.base64 = canvas.toDataURL('image/jpeg', that.defaults.quality);

                        // 鎵ц鍥炶皟
                        _callback(results);
                    });
                }

                // 鍏朵粬璁惧&IOS8+
                else {
                    EXIF.getData(img, function () {
                        var orientation = EXIF.getTag(this, "Orientation");

                        switch (orientation) {
                            case 3:
                                ctx.rotate(180 * Math.PI / 180);
                                ctx.drawImage(img, -resize.w, -resize.h, resize.w, resize.h);
                                break;

                            case 6:
                                canvas.width  = resize.h;
                                canvas.height = resize.w;
                                ctx.rotate(90 * Math.PI / 180);
                                ctx.drawImage(img, 0, -resize.h, resize.w, resize.h);
                                break;

                            case 8:
                                canvas.width  = resize.h;
                                canvas.height = resize.w;
                                ctx.rotate(270 * Math.PI / 180);
                                ctx.drawImage(img, -resize.w, 0, resize.w, resize.h);
                                break;

                            default:
                                ctx.drawImage(img, 0, 0, resize.w, resize.h);
                        }

                        results.base64 = canvas.toDataURL('image/jpeg', that.defaults.quality);

                        // 鎵ц鍥炶皟
                        _callback(results);
                    });
                }

                /**
                 * 鍖呰鍥炶皟
                 */
                function _callback(results) {
                    // 閲婃斁鍐呭瓨
                    canvas = null;
                    img    = null;
                    URL.revokeObjectURL(blob);

                    // 鍔犲叆base64Len锛屾柟渚垮悗鍙版牎楠屾槸鍚︿紶杈撳畬鏁�
                    results.base64Len = results.base64.length;

                    callback(results);
                }
            };

            img.src = blob;
        },

        /**
         * 鑾峰緱鍥剧墖鐨勭缉鏀惧昂瀵�
         * @param img
         * @returns {{w: (Number), h: (Number)}}
         */
        resize: function (img) {
            var w  =   h   = this.defaults.width,
                // h     = this.defaults.height,
                scale = img.width / img.height,
                ret   = {
                    w: img.width,
                    h: img.height
                };
                // console.log('ret',ret);
            if(scale>1){
                ret.w = w;
                ret.h = Math.ceil(w / scale);
            }else{
                ret.w = Math.ceil(h * scale);
                ret.h = h;
            }
            // if (w & h) {
            //     ret.w = w;
            //     ret.h = h;
            // } else if (w) {
            //     ret.w = w;
            //     ret.h = Math.ceil(w / scale);
            // } else if (h) {
            //     ret.w = Math.ceil(h * scale);
            //     ret.h = h;
            // }

            // 瓒呰繃杩欎釜鍊糱ase64鏃犳硶鐢熸垚锛屽湪IOS涓�
            if(ret.w >= 3264 || ret.h >= 2448) {
                ret.w *= 0.8;
                ret.h *= 0.8;
            }

            return ret;
        }
    };

    // 鏆撮湶鎺ュ彛
    window.lrz = function (file, options, callback) {
        return new Lrz(file, options, callback);
    };
})();