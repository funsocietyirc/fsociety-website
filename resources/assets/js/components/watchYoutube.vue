<template>
    <div>
        <div id="userCount">
            <h2 class="from">
                <span href="" class="uk-icon-button uk-icon-users uk-margin-small-right from"></span>
                {{totalListeners}}
            </h2>
        </div>
        <div v-if="key" id="nowPlaying">
            <i class="uk-icon-play uk-margin-small-right from"></i> {{title}} <span class="from"><i
                class="uk-margin-small-right uk-margin-small-left uk-icon-user"></i>  {{from}}</span>
        </div>
        <div v-if="queue.length > 0" id="queue">
            <h4 class="uk-text-right">FSociety TV</h4>
            <ul class="uk-list uk-list-line">
                <li v-if="queue.length > 0">
                    <h4><i class="uk-icon-fast-forward uk-margin-small-right from"></i> Up Next
                        <div class="uk-badge uk-badge-danger uk-margin-small-left">{{queue.length}}</div>
                    </h4>
                </li>
                <li v-for="(item, index) in queue">
                    <span class="timestamp uk-margin-small-right">{{index + 1}}</span> {{item.title}}  <span
                        class="from uk-margin-small-left">{{item.from}}</span>
                </li>
            </ul>

        </div>
        <youtube v-if="key" class="fullscreen" :player-width="windowWidth" :player-height="windowHeight" :video-id="key"
                 :player-vars="playerVars" @paused="pause" @ready="ready" @playing="playing" @ended="ended"></youtube>
        <div v-if="!key || paused">
            <div class="frame">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="image-layer"></div>
        </div>
    </div>
</template>

<style scoped>
    .from {
        text-shadow: 4px 4px 7px rgba(0, 0, 0, 0.79);
    }
    body, html {
        height: 100%;
        margin: 0;
    }
    #userCount
    {
        position: fixed;
        left: 2%;
        bottom:9%;
        width: 20%;
        height: 1.1em;
        padding: 5px;
        z-index: 4;
    }
    #nowPlaying {
        position: fixed;
        left: 0;
        width: 80%;
        height: 1.1em;
        padding: 5px;
        z-index: 5;
    }

    #queue {
        position: fixed;
        top: 0;
        right: 0;
        z-index: 5;
        width: 15%;
        height: 100%;
        background: #000;
        pointer-events: none;
        opacity: 0.8;
        color: #fff;
        padding: 5px;
    }

    /*noinspection CssUnknownTarget*/
    .image-layer {
        z-index: 1;
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        color: transparent;
        background: url('/images/standby.jpg') no-repeat fixed center center;
        background-size:  cover;
        text-shadow: 0 0 30px rgba(0, 0, 0, .5);
        animation: glitch 8s linear infinite;
        pointer-events: none;
    }

    .frame {
        z-index: 3;
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(ellipse at center, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 19%, rgba(0, 0, 0, 0.9) 100%);
        pointer-events: none;
    }

    .frame div {
        position: absolute;
        left: 0;
        top: -20%;
        width: 100%;
        height: 20%;
        background-color: rgba(0, 0, 0, .12);
        box-shadow: 0 0 10px rgba(0, 0, 0, .3);
        animation: waves 12s linear infinite;
    }

    .frame div:nth-child(1) {
        animation-delay: 0s;
    }

    .frame div:nth-child(2) {
        animation-delay: 4s;
    }

    .frame div:nth-child(3) {
        animation-delay: 8s;
    }

    @keyframes waves {
        0% {
            top: -20%;
        }
        100% {
            top: 100%;
        }
    }

    @keyframes glitch {
        0% {
            opacity: .4;
        }
        10% {
            opacity: .2;
        }
        20% {
            opacity: .3;
        }
        30% {
            opacity: .1;
        }
        40% {
            opacity: .2;
        }
        50% {
            opacity: .2;
        }
        54% {
            opacity: .4;
        }
        58% {
            opacity: .2;
        }
        60% {
            opacity: .2;
        }
        65% {
            opacity: .3;
        }
        70% {
            opacity: .2;
        }
        80% {
            opacity: .2;
        }
        90% {
            opacity: .3;
        }
        93% {
            opacity: .4;
        }
        96% {
            opacity: .2;
        }
        100% {
            opacity: .3;
        }
    }

</style>
<script>
    const socketUrl = 'https://bot.fsociety.guru/youtube';
    const _ = window._ || require('lodash');

    export default{
        data(){
            return {
                key: '',            // Current Video
                seekTime: 0,        // Current Seek Time
                from: '',           // Current Video sent From Nick
                to: '',             // Current Video sent to channel
                title: '',          // Current Video title
                timestamp: null,    // Time current video was received
                hrtime: null,       // Current Hardware timestamp
                paused: false,      // Player pause status
                queue: [],          // Video Queue
                firstLoad: true,    // Has a video been loaded yet?
                activeChannel: activeChannel ? activeChannel.toLowerCase() : '', // Active channel, defaults to ''
                player: null,       // Holder for the video player
                windowHeight: 0,    // Browser Window Height
                windowWidth: 0,      // Browser Window Width
                totalListeners: 1   // Current Total Listeners, defaulted to 1
            }
        },
        computed: {
            playerVars: function () {
                return {
                    autoplay: 1,
                    start: this.seekTime
                }
            },
        },
        mounted(){
            this.$nextTick(function () {
                this.initSocket();
                this.windowWidth = window.innerWidth;
                this.windowHeight = window.innerHeight;
                window.addEventListener('resize', () => {
                    this.windowWidth = window.innerWidth;
                    this.windowHeight = window.innerHeight;
                });
            });
        },
        watch: {
            title: function (val) {
                let out = this.title === '' ? 'Fsociety TV' : this.title;
                document.title = `${out} - Powered by MrNodeBot`;
            },
        },
        methods: {
            playing: function (player) {
                this.paused = false;
            },
            ready: function (player) {
                // Hold on to the player object
                this.player = player;
                // Hack to have the first synced song seem to the appropriate time
                if(this.firstLoad) {
                    player.seekTo(parseFloat(this.seekTime), true);
                    this.firstLoad = false;
                }
            },
            pause: function (player) {
                this.paused = true;
            },
            ended: function (player) {
                // Reset the key
                this.clearNowPlaying();
                // There are still items left in the queue
                if (this.queue.length > 0) {
                    // Pop the first item off
                    let item = this.queue.splice(0, 1)[0];
                    // Play it
                    this.seekTime = item.seekTime;
                    this.key = item.key;
                    this.hrtime = item.hrtime;
                    this.timestamp = item.timestamp;
                    this.title = item.title;
                    this.from = item.from;
                    this.to = item.to;
                    // Notify
                    this.notifyPlay('Playing', this);
                }
            },
            notifyPlay: function (message, item) {
                // Notify
                UIkit.notify({
                    message: `<div class="uk-text-center"><h4>${message} ${item.title}</h4><p>Requested By ${item.from} on ${item.to}</p></div>`,
                    status: 'info',
                    timeout: 4000,
                    pos: 'bottom-center'
                });
            },
            queueItem: function (key, from, to, hrtime, timestamp, title, seekTime) {
                title = title || '';
                return {
                    key,
                    from,
                    to,
                    hrtime,
                    timestamp,
                    title,
                    seekTime
                };
            },
            clearQueue: function () {
                this.queue.splice(0);
            },
            clearNowPlaying: function () {
                this.key = '';
                this.from = '';
                this.to = '';
                this.title = '';
                this.seekTime = 0;
                this.timestamp = null;
                this.paused = false;
                this.hrtime = null;
            },
            buildState: function() {
                let currentState = {
                    key: this.key,
                    from: this.from,
                    to: this.to,
                    title: this.title,
                    seekTime: this.player.getCurrentTime(),
                    timestamp: this.timestamp,
                    hrtime: this.hrtime
                };

                // Create a copy of the current queue
                let queue = JSON.parse(JSON.stringify(this.queue));
                // Put the current state at the start
                queue.unshift(currentState);
                // Return state
                return {
                    activeChannel: this.activeChannel,
                    queue: queue,
                };
            },
            initSocket: function () {
                const self = this;

                // Establish Socket.io connection
                const channel = io.connect(socketUrl);

                // YouTube new Connection event
                channel.on('new', data => {
                    // Update the total listeners
                    // TODO Scope to channel
                    self.totalListeners = data;

                    // If we have a HR Time broadcast our state
                    if(self.hrtime) channel.emit('new-reply', self.buildState());
                });

                // Listen for Disconnects
                // TODO Scope to channel
                channel.on('left', data => self.totalListeners = data);

                // Handle Queue Sync
                channel.on('queue', data => {

                    if(self.activeChannel === data.activeChannel.toLowerCase() && (!self.hrtime || self.hrtime[1] > data.queue[0].hrtime[1])) {

                        // Clear Current State
                        self.clearNowPlaying();
                        self.clearQueue();
                        // Pop off first item
                        let item = data.queue.splice(0, 1)[0];

                        // Figure out time shift?
                        // Super magic experimental number
                        let timeshift = 1.255;

                        console.dir(timeshift);
                        // Set First Item
                        self.seekTime = item.seekTime + timeshift;
                        self.key = item.key;
                        self.hrtime = item.hrtime;
                        self.timestamp = item.timestamp;
                        self.title = item.title;
                        self.from = item.from;
                        self.to = item.to;
                        // Notify
                        self.notifyPlay('Playing (Sync)', self);
                        // Assign the rest of the queue
                        self.queue = data.queue;
                    }
                });

                // YouTube Control Channel
                channel.on('control', data => {
                    // Gate
                    if(!data.command || (data.from.toLowerCase() !== self.activeChannel)) return;
                    // Switch Control commands
                    switch (data.command) {
                        case 'clear':
                            self.clearNowPlaying();
                            self.clearQueue();
                            break;
                        case 'remove':
                            if (data.index > self.queue.length || data.index - 1 < 0) return;
                            self.queue.splice(data.index - 1, 1);
                            break;
                    }
                });

                // YouTube Broadcast channel
                channel.on('message', data => {
                    // We are not listening on the current channel
                    if(data.to.toLowerCase() !== self.activeChannel) return;

                    // No Key, Same key as currently playing, bail
                    if (!data.video || !data.video.key || data.video.key === self.key || _.find(self.queue, {key: data.video.key})) return;

                    // Create the item
                    let item = self.queueItem(
                        data.video.key,
                        data.from,
                        data.to,
                        data.hrtime,
                        data.timestamp,
                        data.video.videoTitle,
                        data.seekTime
                    );

                    // Add Item To queue
                    self.queue.push(item);

                    // If nothing is currently playing, process the item
                    if (self.key === '') {
                        // Pop the first item from the queue
                        let item = self.queue.splice(0, 1)[0];
                        self.seekTime = item.seekTime;
                        self.key = item.key;
                        self.hrtime = item.hrtime;
                        self.timestamp = item.timestamp;
                        self.title = item.title;
                        self.from = item.from;
                        self.to = item.to;
                        self.notifyPlay('Playing', self);
                    }

                    // Otherwise Notify we are adding it
                    else self.notifyPlay('Adding', item);
                });
            }
        }
    }


</script>
