<template>
    <div>
        <div v-if="key" id="nowPlaying">
            <i style="color:darkred" class="uk-icon-play uk-margin-small-right"></i> {{title}} <span class="from"><i
                class="uk-margin-small-right uk-margin-small-left uk-icon-user"></i>  {{from}}</span>
        </div>
        <div v-if="queue.length > 0" id="queue">
            <h4 class="uk-text-right">FSociety TV</h4>
            <ul class="uk-list uk-list-line">
                <li v-if="queue.length > 0">
                    <h4><i style="color:darkred" class="uk-icon-fast-forward uk-margin-small-right"></i> Up Next
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
                 :player-vars="playerVars" @paused="paused" @ready="ready" @playing="playing" @ended="ended"></youtube>
        <div v-if="key == ''">
            <div class="frame">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="image-layer"></div>
        </div>
    </div>
</template>
<style>
    body, html {
        height: 100%;
        margin: 0;
    }

    #nowPlaying {
        position: fixed;
        left: 0;
        width: 80%;
        height: 1.1em;
        padding: 5px;
    }

    #queue {
        position: fixed;
        top: 0;
        right: 0;
        z-index: 50;
        width: 15%;
        height: 100%;
        background: #000;
        pointer-events: none;
        opacity: 0.8;
        color: #fff;
        padding: 5px;
    }
    .uk-list-line > li:nth-child(n+2) {
        margin-top: 5px;
        padding-top: 5px;
        border-top: 1px solid #dd212d;
    }
    .uk-badge {
        border-radius: 8px;
    }
    .image-layer {
        z-index: 1;
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: url(http://www.windowscentral.com/sites/wpcentral.com/files/styles/larger/public/field/image/2015/06/fallout-4-teaser.jpg?itok=L6Ln4CRc);
        color: transparent;
        background-size: cover;
        text-shadow: 0 0 30px rgba(0, 0, 0, .5);
        animation: glitch 8s linear infinite;
    }

    .frame {
        z-index: 3;
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(ellipse at center, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 19%, rgba(0, 0, 0, 0.9) 100%);
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
        animation-delay: 0;
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
    import _ from 'lodash';

    export default{
        data(){
            return {
                key: '',
                seekTime: 0,
                from: '',
                to: '',
                title: '',

                queue: [],

                windowHeight: 0,
                windowWidth: 0
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
                document.title = `${this.title} - Powered by MrNodeBot`;
            },
        },
        methods: {
            playing: function (player) {
                // Notify
                UIkit.notify({
                    message: `<div class="uk-text-center"><h4>Playing ${this.title}</h4><p>Requested By ${this.from} on ${this.to}</p></div>`,
                    status: 'info',
                    timeout: 4000,
                    pos: 'bottom-center'
                });
            },
            ready: function (player) {
            },
            paused: function (player) {
            },
            ended: function (player) {
                // Reset the key
                this.key = '';
                this.from = '';
                this.to = '';
                this.title = '';
                this.seekTime = 0;

                if (this.queue.length > 0) {
                    let item = this.queue.splice(0, 1)[0];
                    this.key = item.key;
                    this.seekTime = item.seekTime;
                    this.title = item.title;
                    this.from = item.from;
                    this.to = item.to;
                }
            },
            queueItem: function (key, from, to, title, seekTime) {
                title = title || '';
                return {
                    key, from, to, title, seekTime
                };
            },
            initSocket: function () {
                var self = this;
                // YouTube Control Channel
                window.Fsociety.socket.on('youtube-control', data => {
                    if (!data.command) return;
                    switch (data.command) {
                        case 'clear':
                            // Reset the key
                            self.key = '';
                            self.from = '';
                            self.to = '';
                            self.title = '';
                            self.seekTime = 0;
                            self.queue.splice(0);
                            break;
                        case 'remove':
                            if (!_.isInteger(data.index) || data.index > self.queue.length || data.index < 0) return;
                            self.queue.splice(data.index, 1);
                            break;
                    }
                });

                // YouTube Broadcast channel
                window.Fsociety.socket.on('youtube', data => {
                    // No Key, Same key as currently playing, bail
                    if (!data.video || !data.video.key || data.video.key === self.key) return;
                    // Create the item
                    let item = self.queueItem(
                        data.video.key,
                        data.from,
                        data.to,
                        data.video.videoTitle,
                        data.seekTime
                    );

                    // Add Item To queue
                    self.queue.push(item);

                    // If nothing is currently playing, process the item
                    if (self.key === '') {
                        let item = self.queue.splice(0, 1)[0];
                        self.key = item.key;
                        self.seekTime = item.seekTime;
                        self.title = item.title;
                        self.from = item.from;
                        self.to = item.to;
                    } else {
                        // Notify
                        UIkit.notify({
                            message: `<div class="uk-text-center"><h4>Added ${item.title}</h4><p>Requested By ${item.from} on ${item.to} to queue</p></div>`,
                            status: 'success',
                            timeout: 4000,
                            pos: 'top-center'
                        });
                    }
                });
            }
        }
    }


</script>
