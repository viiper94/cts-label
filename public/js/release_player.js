/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/release_player.js":
/*!****************************************!*\
  !*** ./resources/js/release_player.js ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   ReleasePlayer: () => (/* binding */ ReleasePlayer)
/* harmony export */ });
/* harmony import */ var wavesurfer_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! wavesurfer.js */ "./node_modules/wavesurfer.js/dist/wavesurfer.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }

var ReleasePlayer = /*#__PURE__*/function () {
  function ReleasePlayer(data) {
    var _this = this;
    _classCallCheck(this, ReleasePlayer);
    this.id = data.id;
    this.waveform = data.waveform;
    this.sampleStart = data.sampleStart;
    this.length = data.length;
    this.url = data.url;
    this.el = data.el;
    this.volume = data.volume;
    this.muted = data.muted;
    this.player = wavesurfer_js__WEBPACK_IMPORTED_MODULE_0__["default"].create({
      container: '#waveform',
      height: 70,
      waveColor: 'rgba(255,206,0,0)',
      progressColor: '#eee',
      peaks: [0, 0],
      cursorWidth: 1,
      url: this.url
    });
    this.player.on('timeupdate', function () {
      _this.updateTime();
    });
    this.player.on('finish', function () {
      _this.stopPlayer();
    });
    this.player.on('ready', function () {
      _this.initializeUI();
      _this.playPause();
    });
  }
  _createClass(ReleasePlayer, [{
    key: "updateTime",
    value: function updateTime() {
      var currentTime = this.player.getCurrentTime();
      $('.preview-player .current').text(this.convertDuration(currentTime, this.sampleStart));
      $('.preview-player .player-progress').css('right', this.getProgressBarRight() + '%');
    }
  }, {
    key: "initializeUI",
    value: function initializeUI() {
      var _this2 = this;
      var volumeBar = $('.preview-player .volume-bar');
      var playPauseButton = $('.preview-player .play-pause');
      var closeButton = $('.preview-player .close');
      var muteButton = $('.preview-player .mute');
      $('.preview-player .volume-bar-value').css({
        width: this.player.getVolume() * 100 + '%'
      });
      $('.preview-player .current').text(this.convertDuration(this.getStartTime()));
      volumeBar.click(function (e) {
        _this2.setVolume(e, volumeBar);
      });
      playPauseButton.click(function () {
        _this2.playPause();
      });
      closeButton.click(function () {
        _this2.stopPlayer();
      });
      muteButton.click(function () {
        _this2.toggleMute();
      });
      $('.preview-player').show();
    }
  }, {
    key: "playPause",
    value: function playPause() {
      if (!this.player.isPlaying()) {
        this.player.play();
      } else {
        this.player.pause();
      }
      this.togglePlayPauseIcons();
    }
  }, {
    key: "togglePlayPauseIcons",
    value: function togglePlayPauseIcons() {
      var mainPlayPauseIcon = $(".preview-player .play-pause i");
      mainPlayPauseIcon.toggleClass('fa-play fa-pause');
      this.el.find('i').toggleClass('fa-play fa-pause');
    }
  }, {
    key: "stopPlayer",
    value: function stopPlayer() {
      this.player.pause();
      this.player.destroy();
      this.togglePlayPauseIcons();
      $('.preview-player').remove();
    }
  }, {
    key: "setVolume",
    value: function setVolume(e, el) {
      var clickedPositionPercent = this.getBarClickPercent(e, el);
      $('.preview-player .volume-bar-value').css({
        width: clickedPositionPercent + '%'
      });
      this.player.setVolume(clickedPositionPercent / 100);
    }
  }, {
    key: "toggleMute",
    value: function toggleMute() {
      var isMuted = this.player.getMuted();
      this.player.setMuted(!isMuted);
      var muteIcon = $('.preview-player .mute i');
      muteIcon.toggleClass('fa-volume-high fa-volume-xmark');
    }
  }, {
    key: "getBarClickPercent",
    value: function getBarClickPercent(e, el) {
      return (e.pageX - $(el).offset().left) / $(el).width() * 100;
    }
  }, {
    key: "convertDuration",
    value: function convertDuration(duration) {
      var offset = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;
      duration += offset / 1000;
      var minutes = Math.floor(duration / 60);
      var seconds = Math.floor(duration - minutes * 60);
      return "".concat(minutes.toString().padStart(2, '0'), ":").concat(seconds.toString().padStart(2, '0'));
    }
  }, {
    key: "getStartTime",
    value: function getStartTime() {
      return this.convertDuration(this.sampleStart);
    }
  }, {
    key: "getProgressBarRight",
    value: function getProgressBarRight() {
      return 100 - (parseInt(this.sampleStart) + this.player.getCurrentTime() * 1000) / this.length * 100;
    }
  }, {
    key: "destroy",
    value: function destroy() {
      this.player.destroy();
    }
  }]);
  return ReleasePlayer;
}();

/***/ }),

/***/ "./resources/sass/admin.scss":
/*!***********************************!*\
  !*** ./resources/sass/admin.scss ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./node_modules/wavesurfer.js/dist/decoder.js":
/*!****************************************************!*\
  !*** ./node_modules/wavesurfer.js/dist/decoder.js ***!
  \****************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
var __awaiter = (undefined && undefined.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
/** Decode an array buffer into an audio buffer */
function decode(audioData, sampleRate) {
    return __awaiter(this, void 0, void 0, function* () {
        const audioCtx = new AudioContext({ sampleRate });
        const decode = audioCtx.decodeAudioData(audioData);
        return decode.finally(() => audioCtx.close());
    });
}
/** Normalize peaks to -1..1 */
function normalize(channelData) {
    const firstChannel = channelData[0];
    if (firstChannel.some((n) => n > 1 || n < -1)) {
        const length = firstChannel.length;
        let max = 0;
        for (let i = 0; i < length; i++) {
            const absN = Math.abs(firstChannel[i]);
            if (absN > max)
                max = absN;
        }
        for (const channel of channelData) {
            for (let i = 0; i < length; i++) {
                channel[i] /= max;
            }
        }
    }
    return channelData;
}
/** Create an audio buffer from pre-decoded audio data */
function createBuffer(channelData, duration) {
    // If a single array of numbers is passed, make it an array of arrays
    if (typeof channelData[0] === 'number')
        channelData = [channelData];
    // Normalize to -1..1
    normalize(channelData);
    return {
        duration,
        length: channelData[0].length,
        sampleRate: channelData[0].length / duration,
        numberOfChannels: channelData.length,
        getChannelData: (i) => channelData === null || channelData === void 0 ? void 0 : channelData[i],
        copyFromChannel: AudioBuffer.prototype.copyFromChannel,
        copyToChannel: AudioBuffer.prototype.copyToChannel,
    };
}
const Decoder = {
    decode,
    createBuffer,
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Decoder);


/***/ }),

/***/ "./node_modules/wavesurfer.js/dist/draggable.js":
/*!******************************************************!*\
  !*** ./node_modules/wavesurfer.js/dist/draggable.js ***!
  \******************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   makeDraggable: () => (/* binding */ makeDraggable)
/* harmony export */ });
function makeDraggable(element, onDrag, onStart, onEnd, threshold = 5) {
    let unsub = () => {
        return;
    };
    if (!element)
        return unsub;
    const down = (e) => {
        // Ignore the right mouse button
        if (e.button === 2)
            return;
        e.preventDefault();
        e.stopPropagation();
        element.style.touchAction = 'none';
        let startX = e.clientX;
        let startY = e.clientY;
        let isDragging = false;
        const move = (e) => {
            e.preventDefault();
            e.stopPropagation();
            const x = e.clientX;
            const y = e.clientY;
            if (isDragging || Math.abs(x - startX) >= threshold || Math.abs(y - startY) >= threshold) {
                const { left, top } = element.getBoundingClientRect();
                if (!isDragging) {
                    isDragging = true;
                    onStart === null || onStart === void 0 ? void 0 : onStart(startX - left, startY - top);
                }
                onDrag(x - startX, y - startY, x - left, y - top);
                startX = x;
                startY = y;
            }
        };
        const click = (e) => {
            if (isDragging) {
                e.preventDefault();
                e.stopPropagation();
            }
        };
        const up = () => {
            element.style.touchAction = '';
            if (isDragging) {
                onEnd === null || onEnd === void 0 ? void 0 : onEnd();
            }
            unsub();
        };
        document.addEventListener('pointermove', move);
        document.addEventListener('pointerup', up);
        document.addEventListener('pointerleave', up);
        document.addEventListener('click', click, true);
        unsub = () => {
            document.removeEventListener('pointermove', move);
            document.removeEventListener('pointerup', up);
            document.removeEventListener('pointerleave', up);
            setTimeout(() => {
                document.removeEventListener('click', click, true);
            }, 10);
        };
    };
    element.addEventListener('pointerdown', down);
    return () => {
        unsub();
        element.removeEventListener('pointerdown', down);
    };
}


/***/ }),

/***/ "./node_modules/wavesurfer.js/dist/event-emitter.js":
/*!**********************************************************!*\
  !*** ./node_modules/wavesurfer.js/dist/event-emitter.js ***!
  \**********************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/** A simple event emitter that can be used to listen to and emit events. */
class EventEmitter {
    constructor() {
        this.listeners = {};
        /** Subscribe to an event. Returns an unsubscribe function. */
        this.on = this.addEventListener;
        /** Unsubscribe from an event */
        this.un = this.removeEventListener;
    }
    /** Add an event listener */
    addEventListener(event, listener, options) {
        if (!this.listeners[event]) {
            this.listeners[event] = new Set();
        }
        this.listeners[event].add(listener);
        if (options === null || options === void 0 ? void 0 : options.once) {
            const unsubscribeOnce = () => {
                this.removeEventListener(event, unsubscribeOnce);
                this.removeEventListener(event, listener);
            };
            this.addEventListener(event, unsubscribeOnce);
            return unsubscribeOnce;
        }
        return () => this.removeEventListener(event, listener);
    }
    removeEventListener(event, listener) {
        var _a;
        (_a = this.listeners[event]) === null || _a === void 0 ? void 0 : _a.delete(listener);
    }
    /** Subscribe to an event only once */
    once(event, listener) {
        return this.on(event, listener, { once: true });
    }
    /** Clear all events */
    unAll() {
        this.listeners = {};
    }
    /** Emit an event */
    emit(eventName, ...args) {
        if (this.listeners[eventName]) {
            this.listeners[eventName].forEach((listener) => listener(...args));
        }
    }
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (EventEmitter);


/***/ }),

/***/ "./node_modules/wavesurfer.js/dist/fetcher.js":
/*!****************************************************!*\
  !*** ./node_modules/wavesurfer.js/dist/fetcher.js ***!
  \****************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
var __awaiter = (undefined && undefined.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
function watchProgress(response, progressCallback) {
    return __awaiter(this, void 0, void 0, function* () {
        if (!response.body || !response.headers)
            return;
        const reader = response.body.getReader();
        const contentLength = Number(response.headers.get('Content-Length')) || 0;
        let receivedLength = 0;
        // Process the data
        const processChunk = (value) => __awaiter(this, void 0, void 0, function* () {
            // Add to the received length
            receivedLength += (value === null || value === void 0 ? void 0 : value.length) || 0;
            const percentage = Math.round((receivedLength / contentLength) * 100);
            progressCallback(percentage);
        });
        const read = () => __awaiter(this, void 0, void 0, function* () {
            let data;
            try {
                data = yield reader.read();
            }
            catch (_a) {
                // Ignore errors because we can only handle the main response
                return;
            }
            // Continue reading data until done
            if (!data.done) {
                processChunk(data.value);
                yield read();
            }
        });
        read();
    });
}
function fetchBlob(url, progressCallback, requestInit) {
    return __awaiter(this, void 0, void 0, function* () {
        // Fetch the resource
        const response = yield fetch(url, requestInit);
        // Read the data to track progress
        watchProgress(response.clone(), progressCallback);
        return response.blob();
    });
}
const Fetcher = {
    fetchBlob,
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Fetcher);


/***/ }),

/***/ "./node_modules/wavesurfer.js/dist/player.js":
/*!***************************************************!*\
  !*** ./node_modules/wavesurfer.js/dist/player.js ***!
  \***************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _event_emitter_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./event-emitter.js */ "./node_modules/wavesurfer.js/dist/event-emitter.js");

class Player extends _event_emitter_js__WEBPACK_IMPORTED_MODULE_0__["default"] {
    constructor(options) {
        super();
        this.isExternalMedia = false;
        if (options.media) {
            this.media = options.media;
            this.isExternalMedia = true;
        }
        else {
            this.media = document.createElement('audio');
        }
        // Controls
        if (options.mediaControls) {
            this.media.controls = true;
        }
        // Autoplay
        if (options.autoplay) {
            this.media.autoplay = true;
        }
        // Speed
        if (options.playbackRate != null) {
            this.onceMediaEvent('canplay', () => {
                if (options.playbackRate != null) {
                    this.media.playbackRate = options.playbackRate;
                }
            });
        }
    }
    onMediaEvent(event, callback, options) {
        this.media.addEventListener(event, callback, options);
        return () => this.media.removeEventListener(event, callback);
    }
    onceMediaEvent(event, callback) {
        return this.onMediaEvent(event, callback, { once: true });
    }
    getSrc() {
        return this.media.currentSrc || this.media.src || '';
    }
    revokeSrc() {
        const src = this.getSrc();
        if (src.startsWith('blob:')) {
            URL.revokeObjectURL(src);
        }
    }
    setSrc(url, blob) {
        const src = this.getSrc();
        if (src === url)
            return;
        this.revokeSrc();
        const newSrc = blob instanceof Blob ? URL.createObjectURL(blob) : url;
        this.media.src = newSrc;
        this.media.load();
    }
    destroy() {
        this.media.pause();
        if (this.isExternalMedia)
            return;
        this.media.remove();
        this.revokeSrc();
        this.media.src = '';
        // Load resets the media element to its initial state
        this.media.load();
    }
    setMediaElement(element) {
        this.media = element;
    }
    /** Start playing the audio */
    play() {
        return this.media.play();
    }
    /** Pause the audio */
    pause() {
        this.media.pause();
    }
    /** Check if the audio is playing */
    isPlaying() {
        return !this.media.paused && !this.media.ended;
    }
    /** Jumpt to a specific time in the audio (in seconds) */
    setTime(time) {
        this.media.currentTime = time;
    }
    /** Get the duration of the audio in seconds */
    getDuration() {
        return this.media.duration;
    }
    /** Get the current audio position in seconds */
    getCurrentTime() {
        return this.media.currentTime;
    }
    /** Get the audio volume */
    getVolume() {
        return this.media.volume;
    }
    /** Set the audio volume */
    setVolume(volume) {
        this.media.volume = volume;
    }
    /** Get the audio muted state */
    getMuted() {
        return this.media.muted;
    }
    /** Mute or unmute the audio */
    setMuted(muted) {
        this.media.muted = muted;
    }
    /** Get the playback speed */
    getPlaybackRate() {
        return this.media.playbackRate;
    }
    /** Set the playback speed, pass an optional false to NOT preserve the pitch */
    setPlaybackRate(rate, preservePitch) {
        // preservePitch is true by default in most browsers
        if (preservePitch != null) {
            this.media.preservesPitch = preservePitch;
        }
        this.media.playbackRate = rate;
    }
    /** Get the HTML media element */
    getMediaElement() {
        return this.media;
    }
    /** Set a sink id to change the audio output device */
    setSinkId(sinkId) {
        // See https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/setSinkId
        const media = this.media;
        return media.setSinkId(sinkId);
    }
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Player);


/***/ }),

/***/ "./node_modules/wavesurfer.js/dist/renderer.js":
/*!*****************************************************!*\
  !*** ./node_modules/wavesurfer.js/dist/renderer.js ***!
  \*****************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _draggable_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./draggable.js */ "./node_modules/wavesurfer.js/dist/draggable.js");
/* harmony import */ var _event_emitter_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./event-emitter.js */ "./node_modules/wavesurfer.js/dist/event-emitter.js");


class Renderer extends _event_emitter_js__WEBPACK_IMPORTED_MODULE_1__["default"] {
    constructor(options, audioElement) {
        super();
        this.timeouts = [];
        this.isScrolling = false;
        this.audioData = null;
        this.resizeObserver = null;
        this.isDragging = false;
        this.options = options;
        const parent = this.parentFromOptionsContainer(options.container);
        this.parent = parent;
        const [div, shadow] = this.initHtml();
        parent.appendChild(div);
        this.container = div;
        this.scrollContainer = shadow.querySelector('.scroll');
        this.wrapper = shadow.querySelector('.wrapper');
        this.canvasWrapper = shadow.querySelector('.canvases');
        this.progressWrapper = shadow.querySelector('.progress');
        this.cursor = shadow.querySelector('.cursor');
        if (audioElement) {
            shadow.appendChild(audioElement);
        }
        this.initEvents();
    }
    parentFromOptionsContainer(container) {
        let parent;
        if (typeof container === 'string') {
            parent = document.querySelector(container);
        }
        else if (container instanceof HTMLElement) {
            parent = container;
        }
        if (!parent) {
            throw new Error('Container not found');
        }
        return parent;
    }
    initEvents() {
        const getClickPosition = (e) => {
            const rect = this.wrapper.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientX - rect.left;
            const relativeX = x / rect.width;
            const relativeY = y / rect.height;
            return [relativeX, relativeY];
        };
        // Add a click listener
        this.wrapper.addEventListener('click', (e) => {
            const [x, y] = getClickPosition(e);
            this.emit('click', x, y);
        });
        // Add a double click listener
        this.wrapper.addEventListener('dblclick', (e) => {
            const [x, y] = getClickPosition(e);
            this.emit('dblclick', x, y);
        });
        // Drag
        if (this.options.dragToSeek) {
            this.initDrag();
        }
        // Add a scroll listener
        this.scrollContainer.addEventListener('scroll', () => {
            const { scrollLeft, scrollWidth, clientWidth } = this.scrollContainer;
            const startX = scrollLeft / scrollWidth;
            const endX = (scrollLeft + clientWidth) / scrollWidth;
            this.emit('scroll', startX, endX);
        });
        // Re-render the waveform on container resize
        const delay = this.createDelay(100);
        this.resizeObserver = new ResizeObserver(() => {
            delay(() => this.reRender());
        });
        this.resizeObserver.observe(this.scrollContainer);
    }
    initDrag() {
        (0,_draggable_js__WEBPACK_IMPORTED_MODULE_0__.makeDraggable)(this.wrapper, 
        // On drag
        (_, __, x) => {
            this.emit('drag', Math.max(0, Math.min(1, x / this.wrapper.getBoundingClientRect().width)));
        }, 
        // On start drag
        () => (this.isDragging = true), 
        // On end drag
        () => (this.isDragging = false));
    }
    getHeight() {
        const defaultHeight = 128;
        if (this.options.height == null)
            return defaultHeight;
        if (!isNaN(Number(this.options.height)))
            return Number(this.options.height);
        if (this.options.height === 'auto')
            return this.parent.clientHeight || defaultHeight;
        return defaultHeight;
    }
    initHtml() {
        const div = document.createElement('div');
        const shadow = div.attachShadow({ mode: 'open' });
        shadow.innerHTML = `
      <style>
        :host {
          user-select: none;
          min-width: 1px;
        }
        :host audio {
          display: block;
          width: 100%;
        }
        :host .scroll {
          overflow-x: auto;
          overflow-y: hidden;
          width: 100%;
          position: relative;
        }
        :host .noScrollbar {
          scrollbar-color: transparent;
          scrollbar-width: none;
        }
        :host .noScrollbar::-webkit-scrollbar {
          display: none;
          -webkit-appearance: none;
        }
        :host .wrapper {
          position: relative;
          overflow: visible;
          z-index: 2;
        }
        :host .canvases {
          min-height: ${this.getHeight()}px;
        }
        :host .canvases > div {
          position: relative;
        }
        :host canvas {
          display: block;
          position: absolute;
          top: 0;
          image-rendering: pixelated;
        }
        :host .progress {
          pointer-events: none;
          position: absolute;
          z-index: 2;
          top: 0;
          left: 0;
          width: 0;
          height: 100%;
          overflow: hidden;
        }
        :host .progress > div {
          position: relative;
        }
        :host .cursor {
          pointer-events: none;
          position: absolute;
          z-index: 5;
          top: 0;
          left: 0;
          height: 100%;
          border-radius: 2px;
        }
      </style>

      <div class="scroll" part="scroll">
        <div class="wrapper" part="wrapper">
          <div class="canvases"></div>
          <div class="progress" part="progress"></div>
          <div class="cursor" part="cursor"></div>
        </div>
      </div>
    `;
        return [div, shadow];
    }
    /** Wavesurfer itself calls this method. Do not call it manually. */
    setOptions(options) {
        if (this.options.container !== options.container) {
            const newParent = this.parentFromOptionsContainer(options.container);
            newParent.appendChild(this.container);
            this.parent = newParent;
        }
        if (options.dragToSeek && !this.options.dragToSeek) {
            this.initDrag();
        }
        this.options = options;
        // Re-render the waveform
        this.reRender();
    }
    getWrapper() {
        return this.wrapper;
    }
    getScroll() {
        return this.scrollContainer.scrollLeft;
    }
    destroy() {
        var _a;
        this.container.remove();
        (_a = this.resizeObserver) === null || _a === void 0 ? void 0 : _a.disconnect();
    }
    createDelay(delayMs = 10) {
        const context = {};
        this.timeouts.push(context);
        return (callback) => {
            context.timeout && clearTimeout(context.timeout);
            context.timeout = setTimeout(callback, delayMs);
        };
    }
    // Convert array of color values to linear gradient
    convertColorValues(color) {
        if (!Array.isArray(color))
            return color || '';
        if (color.length < 2)
            return color[0] || '';
        const canvasElement = document.createElement('canvas');
        const ctx = canvasElement.getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, canvasElement.height);
        const colorStopPercentage = 1 / (color.length - 1);
        color.forEach((color, index) => {
            const offset = index * colorStopPercentage;
            gradient.addColorStop(offset, color);
        });
        return gradient;
    }
    renderBarWaveform(channelData, options, ctx, vScale) {
        const topChannel = channelData[0];
        const bottomChannel = channelData[1] || channelData[0];
        const length = topChannel.length;
        const { width, height } = ctx.canvas;
        const halfHeight = height / 2;
        const pixelRatio = window.devicePixelRatio || 1;
        const barWidth = options.barWidth ? options.barWidth * pixelRatio : 1;
        const barGap = options.barGap ? options.barGap * pixelRatio : options.barWidth ? barWidth / 2 : 0;
        const barRadius = options.barRadius || 0;
        const barIndexScale = width / (barWidth + barGap) / length;
        const rectFn = barRadius && 'roundRect' in ctx ? 'roundRect' : 'rect';
        ctx.beginPath();
        let prevX = 0;
        let maxTop = 0;
        let maxBottom = 0;
        for (let i = 0; i <= length; i++) {
            const x = Math.round(i * barIndexScale);
            if (x > prevX) {
                const topBarHeight = Math.round(maxTop * halfHeight * vScale);
                const bottomBarHeight = Math.round(maxBottom * halfHeight * vScale);
                const barHeight = topBarHeight + bottomBarHeight || 1;
                // Vertical alignment
                let y = halfHeight - topBarHeight;
                if (options.barAlign === 'top') {
                    y = 0;
                }
                else if (options.barAlign === 'bottom') {
                    y = height - barHeight;
                }
                ctx[rectFn](prevX * (barWidth + barGap), y, barWidth, barHeight, barRadius);
                prevX = x;
                maxTop = 0;
                maxBottom = 0;
            }
            const magnitudeTop = Math.abs(topChannel[i] || 0);
            const magnitudeBottom = Math.abs(bottomChannel[i] || 0);
            if (magnitudeTop > maxTop)
                maxTop = magnitudeTop;
            if (magnitudeBottom > maxBottom)
                maxBottom = magnitudeBottom;
        }
        ctx.fill();
        ctx.closePath();
    }
    renderLineWaveform(channelData, _options, ctx, vScale) {
        const drawChannel = (index) => {
            const channel = channelData[index] || channelData[0];
            const length = channel.length;
            const { height } = ctx.canvas;
            const halfHeight = height / 2;
            const hScale = ctx.canvas.width / length;
            ctx.moveTo(0, halfHeight);
            let prevX = 0;
            let max = 0;
            for (let i = 0; i <= length; i++) {
                const x = Math.round(i * hScale);
                if (x > prevX) {
                    const h = Math.round(max * halfHeight * vScale) || 1;
                    const y = halfHeight + h * (index === 0 ? -1 : 1);
                    ctx.lineTo(prevX, y);
                    prevX = x;
                    max = 0;
                }
                const value = Math.abs(channel[i] || 0);
                if (value > max)
                    max = value;
            }
            ctx.lineTo(prevX, halfHeight);
        };
        ctx.beginPath();
        drawChannel(0);
        drawChannel(1);
        ctx.fill();
        ctx.closePath();
    }
    renderWaveform(channelData, options, ctx) {
        ctx.fillStyle = this.convertColorValues(options.waveColor);
        // Custom rendering function
        if (options.renderFunction) {
            options.renderFunction(channelData, ctx);
            return;
        }
        // Vertical scaling
        let vScale = options.barHeight || 1;
        if (options.normalize) {
            const max = Array.from(channelData[0]).reduce((max, value) => Math.max(max, Math.abs(value)), 0);
            vScale = max ? 1 / max : 1;
        }
        // Render waveform as bars
        if (options.barWidth || options.barGap || options.barAlign) {
            this.renderBarWaveform(channelData, options, ctx, vScale);
            return;
        }
        // Render waveform as a polyline
        this.renderLineWaveform(channelData, options, ctx, vScale);
    }
    renderSingleCanvas(channelData, options, width, height, start, end, canvasContainer, progressContainer) {
        const pixelRatio = window.devicePixelRatio || 1;
        const canvas = document.createElement('canvas');
        const length = channelData[0].length;
        canvas.width = Math.round((width * (end - start)) / length);
        canvas.height = height * pixelRatio;
        canvas.style.width = `${Math.floor(canvas.width / pixelRatio)}px`;
        canvas.style.height = `${height}px`;
        canvas.style.left = `${Math.floor((start * width) / pixelRatio / length)}px`;
        canvasContainer.appendChild(canvas);
        const ctx = canvas.getContext('2d');
        this.renderWaveform(channelData.map((channel) => channel.slice(start, end)), options, ctx);
        // Draw a progress canvas
        if (canvas.width > 0 && canvas.height > 0) {
            const progressCanvas = canvas.cloneNode();
            const progressCtx = progressCanvas.getContext('2d');
            progressCtx.drawImage(canvas, 0, 0);
            // Set the composition method to draw only where the waveform is drawn
            progressCtx.globalCompositeOperation = 'source-in';
            progressCtx.fillStyle = this.convertColorValues(options.progressColor);
            // This rectangle acts as a mask thanks to the composition method
            progressCtx.fillRect(0, 0, canvas.width, canvas.height);
            progressContainer.appendChild(progressCanvas);
        }
    }
    renderChannel(channelData, options, width) {
        // A container for canvases
        const canvasContainer = document.createElement('div');
        const height = this.getHeight();
        canvasContainer.style.height = `${height}px`;
        this.canvasWrapper.style.minHeight = `${height}px`;
        this.canvasWrapper.appendChild(canvasContainer);
        // A container for progress canvases
        const progressContainer = canvasContainer.cloneNode();
        this.progressWrapper.appendChild(progressContainer);
        // Determine the currently visible part of the waveform
        const { scrollLeft, scrollWidth, clientWidth } = this.scrollContainer;
        const len = channelData[0].length;
        const scale = len / scrollWidth;
        let viewportWidth = Math.min(Renderer.MAX_CANVAS_WIDTH, clientWidth);
        // Adjust width to avoid gaps between canvases when using bars
        if (options.barWidth || options.barGap) {
            const barWidth = options.barWidth || 0.5;
            const barGap = options.barGap || barWidth / 2;
            const totalBarWidth = barWidth + barGap;
            if (viewportWidth % totalBarWidth !== 0) {
                viewportWidth = Math.floor(viewportWidth / totalBarWidth) * totalBarWidth;
            }
        }
        const start = Math.floor(Math.abs(scrollLeft) * scale);
        const end = Math.floor(start + viewportWidth * scale);
        const viewportLen = end - start;
        // Draw a portion of the waveform from start peak to end peak
        const draw = (start, end) => {
            this.renderSingleCanvas(channelData, options, width, height, Math.max(0, start), Math.min(end, len), canvasContainer, progressContainer);
        };
        // Draw the waveform in viewport chunks, each with a delay
        const headDelay = this.createDelay();
        const tailDelay = this.createDelay();
        const renderHead = (fromIndex, toIndex) => {
            draw(fromIndex, toIndex);
            if (fromIndex > 0) {
                headDelay(() => {
                    renderHead(fromIndex - viewportLen, toIndex - viewportLen);
                });
            }
        };
        const renderTail = (fromIndex, toIndex) => {
            draw(fromIndex, toIndex);
            if (toIndex < len) {
                tailDelay(() => {
                    renderTail(fromIndex + viewportLen, toIndex + viewportLen);
                });
            }
        };
        renderHead(start, end);
        if (end < len) {
            renderTail(end, end + viewportLen);
        }
    }
    render(audioData) {
        // Clear previous timeouts
        this.timeouts.forEach((context) => context.timeout && clearTimeout(context.timeout));
        this.timeouts = [];
        // Clear the canvases
        this.canvasWrapper.innerHTML = '';
        this.progressWrapper.innerHTML = '';
        this.wrapper.style.width = '';
        // Width
        if (this.options.width != null) {
            this.scrollContainer.style.width =
                typeof this.options.width === 'number' ? `${this.options.width}px` : this.options.width;
        }
        // Determine the width of the waveform
        const pixelRatio = window.devicePixelRatio || 1;
        const parentWidth = this.scrollContainer.clientWidth;
        const scrollWidth = Math.ceil(audioData.duration * (this.options.minPxPerSec || 0));
        // Whether the container should scroll
        this.isScrolling = scrollWidth > parentWidth;
        const useParentWidth = this.options.fillParent && !this.isScrolling;
        // Width of the waveform in pixels
        const width = (useParentWidth ? parentWidth : scrollWidth) * pixelRatio;
        // Set the width of the wrapper
        this.wrapper.style.width = useParentWidth ? '100%' : `${scrollWidth}px`;
        // Set additional styles
        this.scrollContainer.style.overflowX = this.isScrolling ? 'auto' : 'hidden';
        this.scrollContainer.classList.toggle('noScrollbar', !!this.options.hideScrollbar);
        this.cursor.style.backgroundColor = `${this.options.cursorColor || this.options.progressColor}`;
        this.cursor.style.width = `${this.options.cursorWidth}px`;
        // Render the waveform
        if (this.options.splitChannels) {
            // Render a waveform for each channel
            for (let i = 0; i < audioData.numberOfChannels; i++) {
                const options = Object.assign(Object.assign({}, this.options), this.options.splitChannels[i]);
                this.renderChannel([audioData.getChannelData(i)], options, width);
            }
        }
        else {
            // Render a single waveform for the first two channels (left and right)
            const channels = [audioData.getChannelData(0)];
            if (audioData.numberOfChannels > 1)
                channels.push(audioData.getChannelData(1));
            this.renderChannel(channels, this.options, width);
        }
        this.audioData = audioData;
        this.emit('render');
    }
    reRender() {
        // Return if the waveform has not been rendered yet
        if (!this.audioData)
            return;
        // Remember the current cursor position
        const oldCursorPosition = this.progressWrapper.clientWidth;
        // Set the new zoom level and re-render the waveform
        this.render(this.audioData);
        // Adjust the scroll position so that the cursor stays in the same place
        const newCursortPosition = this.progressWrapper.clientWidth;
        this.scrollContainer.scrollLeft += newCursortPosition - oldCursorPosition;
    }
    zoom(minPxPerSec) {
        this.options.minPxPerSec = minPxPerSec;
        this.reRender();
    }
    scrollIntoView(progress, isPlaying = false) {
        const { clientWidth, scrollLeft, scrollWidth } = this.scrollContainer;
        const progressWidth = scrollWidth * progress;
        const center = clientWidth / 2;
        const minScroll = isPlaying && this.options.autoCenter && !this.isDragging ? center : clientWidth;
        if (progressWidth > scrollLeft + minScroll || progressWidth < scrollLeft) {
            // Scroll to the center
            if (this.options.autoCenter && !this.isDragging) {
                // If the cursor is in viewport but not centered, scroll to the center slowly
                const minDiff = center / 20;
                if (progressWidth - (scrollLeft + center) >= minDiff && progressWidth < scrollLeft + clientWidth) {
                    this.scrollContainer.scrollLeft += minDiff;
                }
                else {
                    // Otherwise, scroll to the center immediately
                    this.scrollContainer.scrollLeft = progressWidth - center;
                }
            }
            else if (this.isDragging) {
                // Scroll just a little bit to allow for some space between the cursor and the edge
                const gap = 10;
                this.scrollContainer.scrollLeft =
                    progressWidth < scrollLeft ? progressWidth - gap : progressWidth - clientWidth + gap;
            }
            else {
                // Scroll to the beginning
                this.scrollContainer.scrollLeft = progressWidth;
            }
        }
        // Emit the scroll event
        {
            const { scrollLeft } = this.scrollContainer;
            const startX = scrollLeft / scrollWidth;
            const endX = (scrollLeft + clientWidth) / scrollWidth;
            this.emit('scroll', startX, endX);
        }
    }
    renderProgress(progress, isPlaying) {
        if (isNaN(progress))
            return;
        const percents = progress * 100;
        this.canvasWrapper.style.clipPath = `polygon(${percents}% 0, 100% 0, 100% 100%, ${percents}% 100%)`;
        this.progressWrapper.style.width = `${percents}%`;
        this.cursor.style.left = `${percents}%`;
        this.cursor.style.marginLeft = Math.round(percents) === 100 ? `-${this.options.cursorWidth}px` : '';
        if (this.isScrolling && this.options.autoScroll) {
            this.scrollIntoView(progress, isPlaying);
        }
    }
}
Renderer.MAX_CANVAS_WIDTH = 4000;
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Renderer);


/***/ }),

/***/ "./node_modules/wavesurfer.js/dist/timer.js":
/*!**************************************************!*\
  !*** ./node_modules/wavesurfer.js/dist/timer.js ***!
  \**************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _event_emitter_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./event-emitter.js */ "./node_modules/wavesurfer.js/dist/event-emitter.js");

class Timer extends _event_emitter_js__WEBPACK_IMPORTED_MODULE_0__["default"] {
    constructor() {
        super(...arguments);
        this.unsubscribe = () => undefined;
    }
    start() {
        this.unsubscribe = this.on('tick', () => {
            requestAnimationFrame(() => {
                this.emit('tick');
            });
        });
        this.emit('tick');
    }
    stop() {
        this.unsubscribe();
    }
    destroy() {
        this.unsubscribe();
    }
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Timer);


/***/ }),

/***/ "./node_modules/wavesurfer.js/dist/wavesurfer.js":
/*!*******************************************************!*\
  !*** ./node_modules/wavesurfer.js/dist/wavesurfer.js ***!
  \*******************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _decoder_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./decoder.js */ "./node_modules/wavesurfer.js/dist/decoder.js");
/* harmony import */ var _fetcher_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./fetcher.js */ "./node_modules/wavesurfer.js/dist/fetcher.js");
/* harmony import */ var _player_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./player.js */ "./node_modules/wavesurfer.js/dist/player.js");
/* harmony import */ var _renderer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./renderer.js */ "./node_modules/wavesurfer.js/dist/renderer.js");
/* harmony import */ var _timer_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./timer.js */ "./node_modules/wavesurfer.js/dist/timer.js");
/* harmony import */ var _webaudio_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./webaudio.js */ "./node_modules/wavesurfer.js/dist/webaudio.js");
var __awaiter = (undefined && undefined.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};






const defaultOptions = {
    waveColor: '#999',
    progressColor: '#555',
    cursorWidth: 1,
    minPxPerSec: 0,
    fillParent: true,
    interact: true,
    dragToSeek: false,
    autoScroll: true,
    autoCenter: true,
    sampleRate: 8000,
};
class WaveSurfer extends _player_js__WEBPACK_IMPORTED_MODULE_2__["default"] {
    /** Create a new WaveSurfer instance */
    static create(options) {
        return new WaveSurfer(options);
    }
    /** Create a new WaveSurfer instance */
    constructor(options) {
        const media = options.media ||
            (options.backend === 'WebAudio' ? new _webaudio_js__WEBPACK_IMPORTED_MODULE_5__["default"]() : undefined);
        super({
            media,
            mediaControls: options.mediaControls,
            autoplay: options.autoplay,
            playbackRate: options.audioRate,
        });
        this.plugins = [];
        this.decodedData = null;
        this.subscriptions = [];
        this.mediaSubscriptions = [];
        this.options = Object.assign({}, defaultOptions, options);
        this.timer = new _timer_js__WEBPACK_IMPORTED_MODULE_4__["default"]();
        const audioElement = media ? undefined : this.getMediaElement();
        this.renderer = new _renderer_js__WEBPACK_IMPORTED_MODULE_3__["default"](this.options, audioElement);
        this.initPlayerEvents();
        this.initRendererEvents();
        this.initTimerEvents();
        this.initPlugins();
        // Load audio if URL or an external media with an src is passed,
        // of render w/o audio if pre-decoded peaks and duration are provided
        const url = this.options.url || this.getSrc() || '';
        if (url || (this.options.peaks && this.options.duration)) {
            this.load(url, this.options.peaks, this.options.duration);
        }
    }
    initTimerEvents() {
        // The timer fires every 16ms for a smooth progress animation
        this.subscriptions.push(this.timer.on('tick', () => {
            const currentTime = this.getCurrentTime();
            this.renderer.renderProgress(currentTime / this.getDuration(), true);
            this.emit('timeupdate', currentTime);
            this.emit('audioprocess', currentTime);
        }));
    }
    initPlayerEvents() {
        this.mediaSubscriptions.push(this.onMediaEvent('timeupdate', () => {
            const currentTime = this.getCurrentTime();
            this.renderer.renderProgress(currentTime / this.getDuration(), this.isPlaying());
            this.emit('timeupdate', currentTime);
        }), this.onMediaEvent('play', () => {
            this.emit('play');
            this.timer.start();
        }), this.onMediaEvent('pause', () => {
            this.emit('pause');
            this.timer.stop();
        }), this.onMediaEvent('emptied', () => {
            this.timer.stop();
        }), this.onMediaEvent('ended', () => {
            this.emit('finish');
        }), this.onMediaEvent('seeking', () => {
            this.emit('seeking', this.getCurrentTime());
        }));
    }
    initRendererEvents() {
        this.subscriptions.push(
        // Seek on click
        this.renderer.on('click', (relativeX, relativeY) => {
            if (this.options.interact) {
                this.seekTo(relativeX);
                this.emit('interaction', relativeX * this.getDuration());
                this.emit('click', relativeX, relativeY);
            }
        }), 
        // Double click
        this.renderer.on('dblclick', (relativeX, relativeY) => {
            this.emit('dblclick', relativeX, relativeY);
        }), 
        // Scroll
        this.renderer.on('scroll', (startX, endX) => {
            const duration = this.getDuration();
            this.emit('scroll', startX * duration, endX * duration);
        }), 
        // Redraw
        this.renderer.on('render', () => {
            this.emit('redraw');
        }));
        // Drag
        {
            let debounce;
            this.subscriptions.push(this.renderer.on('drag', (relativeX) => {
                if (!this.options.interact)
                    return;
                // Update the visual position
                this.renderer.renderProgress(relativeX);
                // Set the audio position with a debounce
                clearTimeout(debounce);
                debounce = setTimeout(() => {
                    this.seekTo(relativeX);
                }, this.isPlaying() ? 0 : 200);
                this.emit('interaction', relativeX * this.getDuration());
                this.emit('drag', relativeX);
            }));
        }
    }
    initPlugins() {
        var _a;
        if (!((_a = this.options.plugins) === null || _a === void 0 ? void 0 : _a.length))
            return;
        this.options.plugins.forEach((plugin) => {
            this.registerPlugin(plugin);
        });
    }
    unsubscribePlayerEvents() {
        this.mediaSubscriptions.forEach((unsubscribe) => unsubscribe());
        this.mediaSubscriptions = [];
    }
    /** Set new wavesurfer options and re-render it */
    setOptions(options) {
        this.options = Object.assign({}, this.options, options);
        this.renderer.setOptions(this.options);
        if (options.audioRate) {
            this.setPlaybackRate(options.audioRate);
        }
        if (options.mediaControls != null) {
            this.getMediaElement().controls = options.mediaControls;
        }
    }
    /** Register a wavesurfer.js plugin */
    registerPlugin(plugin) {
        plugin.init(this);
        this.plugins.push(plugin);
        // Unregister plugin on destroy
        this.subscriptions.push(plugin.once('destroy', () => {
            this.plugins = this.plugins.filter((p) => p !== plugin);
        }));
        return plugin;
    }
    /** For plugins only: get the waveform wrapper div */
    getWrapper() {
        return this.renderer.getWrapper();
    }
    /** Get the current scroll position in pixels */
    getScroll() {
        return this.renderer.getScroll();
    }
    /** Get all registered plugins */
    getActivePlugins() {
        return this.plugins;
    }
    loadAudio(url, blob, channelData, duration) {
        return __awaiter(this, void 0, void 0, function* () {
            this.emit('load', url);
            if (!this.options.media && this.isPlaying())
                this.pause();
            this.decodedData = null;
            // Fetch the entire audio as a blob if pre-decoded data is not provided
            if (!blob && !channelData) {
                const onProgress = (percentage) => this.emit('loading', percentage);
                blob = yield _fetcher_js__WEBPACK_IMPORTED_MODULE_1__["default"].fetchBlob(url, onProgress, this.options.fetchParams);
            }
            // Set the mediaelement source
            this.setSrc(url, blob);
            // Wait for the audio duration
            // It should be a promise to allow event listeners to subscribe to the ready and decode events
            const audioDuration = (yield Promise.resolve(duration || this.getDuration())) ||
                (yield new Promise((resolve) => {
                    this.onceMediaEvent('loadedmetadata', () => resolve(this.getDuration()));
                }));
            // Decode the audio data or use user-provided peaks
            if (channelData) {
                this.decodedData = _decoder_js__WEBPACK_IMPORTED_MODULE_0__["default"].createBuffer(channelData, audioDuration || 0);
            }
            else if (blob) {
                const arrayBuffer = yield blob.arrayBuffer();
                this.decodedData = yield _decoder_js__WEBPACK_IMPORTED_MODULE_0__["default"].decode(arrayBuffer, this.options.sampleRate);
            }
            if (this.decodedData) {
                this.emit('decode', this.getDuration());
                this.renderer.render(this.decodedData);
            }
            this.emit('ready', this.getDuration());
        });
    }
    /** Load an audio file by URL, with optional pre-decoded audio data */
    load(url, channelData, duration) {
        return __awaiter(this, void 0, void 0, function* () {
            yield this.loadAudio(url, undefined, channelData, duration);
        });
    }
    /** Load an audio blob */
    loadBlob(blob, channelData, duration) {
        return __awaiter(this, void 0, void 0, function* () {
            yield this.loadAudio('blob', blob, channelData, duration);
        });
    }
    /** Zoom the waveform by a given pixels-per-second factor */
    zoom(minPxPerSec) {
        if (!this.decodedData) {
            throw new Error('No audio loaded');
        }
        this.renderer.zoom(minPxPerSec);
        this.emit('zoom', minPxPerSec);
    }
    /** Get the decoded audio data */
    getDecodedData() {
        return this.decodedData;
    }
    /** Get decoded peaks */
    exportPeaks({ channels = 2, maxLength = 8000, precision = 10000 } = {}) {
        if (!this.decodedData) {
            throw new Error('The audio has not been decoded yet');
        }
        const maxChannels = Math.min(channels, this.decodedData.numberOfChannels);
        const peaks = [];
        for (let i = 0; i < maxChannels; i++) {
            const channel = this.decodedData.getChannelData(i);
            const data = [];
            const sampleSize = Math.round(channel.length / maxLength);
            for (let i = 0; i < maxLength; i++) {
                const sample = channel.slice(i * sampleSize, (i + 1) * sampleSize);
                const max = Math.max(...sample);
                data.push(Math.round(max * precision) / precision);
            }
            peaks.push(data);
        }
        return peaks;
    }
    /** Get the duration of the audio in seconds */
    getDuration() {
        let duration = super.getDuration() || 0;
        // Fall back to the decoded data duration if the media duration is incorrect
        if ((duration === 0 || duration === Infinity) && this.decodedData) {
            duration = this.decodedData.duration;
        }
        return duration;
    }
    /** Toggle if the waveform should react to clicks */
    toggleInteraction(isInteractive) {
        this.options.interact = isInteractive;
    }
    /** Seek to a percentage of audio as [0..1] (0 = beginning, 1 = end) */
    seekTo(progress) {
        const time = this.getDuration() * progress;
        this.setTime(time);
    }
    /** Play or pause the audio */
    playPause() {
        return __awaiter(this, void 0, void 0, function* () {
            return this.isPlaying() ? this.pause() : this.play();
        });
    }
    /** Stop the audio and go to the beginning */
    stop() {
        this.pause();
        this.setTime(0);
    }
    /** Skip N or -N seconds from the current position */
    skip(seconds) {
        this.setTime(this.getCurrentTime() + seconds);
    }
    /** Empty the waveform */
    empty() {
        this.load('', [[0]], 0.001);
    }
    /** Set HTML media element */
    setMediaElement(element) {
        this.unsubscribePlayerEvents();
        super.setMediaElement(element);
        this.initPlayerEvents();
    }
    /** Unmount wavesurfer */
    destroy() {
        this.emit('destroy');
        this.plugins.forEach((plugin) => plugin.destroy());
        this.subscriptions.forEach((unsubscribe) => unsubscribe());
        this.unsubscribePlayerEvents();
        this.timer.destroy();
        this.renderer.destroy();
        super.destroy();
    }
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (WaveSurfer);


/***/ }),

/***/ "./node_modules/wavesurfer.js/dist/webaudio.js":
/*!*****************************************************!*\
  !*** ./node_modules/wavesurfer.js/dist/webaudio.js ***!
  \*****************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _event_emitter_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./event-emitter.js */ "./node_modules/wavesurfer.js/dist/event-emitter.js");
var __awaiter = (undefined && undefined.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};

/**
 * A Web Audio buffer player emulating the behavior of an HTML5 Audio element.
 */
class WebAudioPlayer extends _event_emitter_js__WEBPACK_IMPORTED_MODULE_0__["default"] {
    constructor(audioContext = new AudioContext()) {
        super();
        this.bufferNode = null;
        this.autoplay = false;
        this.playStartTime = 0;
        this.playedDuration = 0;
        this._muted = false;
        this.buffer = null;
        this.currentSrc = '';
        this.paused = true;
        this.crossOrigin = null;
        this.audioContext = audioContext;
        this.gainNode = this.audioContext.createGain();
        this.gainNode.connect(this.audioContext.destination);
    }
    load() {
        return __awaiter(this, void 0, void 0, function* () {
            return;
        });
    }
    get src() {
        return this.currentSrc;
    }
    set src(value) {
        this.currentSrc = value;
        fetch(value)
            .then((response) => response.arrayBuffer())
            .then((arrayBuffer) => this.audioContext.decodeAudioData(arrayBuffer))
            .then((audioBuffer) => {
            this.buffer = audioBuffer;
            this.emit('loadedmetadata');
            this.emit('canplay');
            if (this.autoplay)
                this.play();
        });
    }
    _play() {
        var _a;
        if (!this.paused)
            return;
        this.paused = false;
        (_a = this.bufferNode) === null || _a === void 0 ? void 0 : _a.disconnect();
        this.bufferNode = this.audioContext.createBufferSource();
        this.bufferNode.buffer = this.buffer;
        this.bufferNode.connect(this.gainNode);
        if (this.playedDuration >= this.duration) {
            this.playedDuration = 0;
        }
        this.bufferNode.start(this.audioContext.currentTime, this.playedDuration);
        this.playStartTime = this.audioContext.currentTime;
        this.bufferNode.onended = () => {
            if (this.currentTime >= this.duration) {
                this.pause();
                this.emit('ended');
            }
        };
    }
    _pause() {
        var _a;
        if (this.paused)
            return;
        this.paused = true;
        (_a = this.bufferNode) === null || _a === void 0 ? void 0 : _a.stop();
        this.playedDuration += this.audioContext.currentTime - this.playStartTime;
    }
    play() {
        return __awaiter(this, void 0, void 0, function* () {
            this._play();
            this.emit('play');
        });
    }
    pause() {
        this._pause();
        this.emit('pause');
    }
    stopAt(timeSeconds) {
        var _a, _b;
        const delay = timeSeconds - this.currentTime;
        (_a = this.bufferNode) === null || _a === void 0 ? void 0 : _a.stop(this.audioContext.currentTime + delay);
        (_b = this.bufferNode) === null || _b === void 0 ? void 0 : _b.addEventListener('ended', () => {
            this.bufferNode = null;
            this.pause();
        }, { once: true });
    }
    setSinkId(deviceId) {
        return __awaiter(this, void 0, void 0, function* () {
            const ac = this.audioContext;
            return ac.setSinkId(deviceId);
        });
    }
    get playbackRate() {
        var _a, _b;
        return (_b = (_a = this.bufferNode) === null || _a === void 0 ? void 0 : _a.playbackRate.value) !== null && _b !== void 0 ? _b : 1;
    }
    set playbackRate(value) {
        if (this.bufferNode) {
            this.bufferNode.playbackRate.value = value;
        }
    }
    get currentTime() {
        return this.paused ? this.playedDuration : this.playedDuration + this.audioContext.currentTime - this.playStartTime;
    }
    set currentTime(value) {
        this.emit('seeking');
        if (this.paused) {
            this.playedDuration = value;
        }
        else {
            this._pause();
            this.playedDuration = value;
            this._play();
        }
        this.emit('timeupdate');
    }
    get duration() {
        var _a;
        return ((_a = this.buffer) === null || _a === void 0 ? void 0 : _a.duration) || 0;
    }
    get volume() {
        return this.gainNode.gain.value;
    }
    set volume(value) {
        this.gainNode.gain.value = value;
        this.emit('volumechange');
    }
    get muted() {
        return this._muted;
    }
    set muted(value) {
        if (this._muted === value)
            return;
        this._muted = value;
        if (this._muted) {
            this.gainNode.disconnect();
        }
        else {
            this.gainNode.connect(this.audioContext.destination);
        }
    }
    /** Get the GainNode used to play the audio. Can be used to attach filters. */
    getGainNode() {
        return this.gainNode;
    }
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (WebAudioPlayer);


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/release_player": 0,
/******/ 			"css/admin": 0,
/******/ 			"css/app": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/admin","css/app"], () => (__webpack_require__("./resources/js/release_player.js")))
/******/ 	__webpack_require__.O(undefined, ["css/admin","css/app"], () => (__webpack_require__("./resources/sass/admin.scss")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/admin","css/app"], () => (__webpack_require__("./resources/sass/app.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;