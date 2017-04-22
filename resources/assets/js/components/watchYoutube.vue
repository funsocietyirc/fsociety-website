<template>
    <div>
        <youtube v-if="key" class="fullscreen" :player-width="windowWidth" :player-height="windowHeight" :video-id="key" :player-vars="playerVars" @paused="paused"  @ready="ready" @playing="playing" @ended="ended"></youtube>
    </div>
</template>
<style>
body, html {
    height: 100%;
    margin: 0;
}
.fullScreen {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
}


</style>
<script>
    export default{
        data(){
            return{
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
            playerVars: function() {
                return {
                    autoplay: 1,
                    start: this.seekTime
                }
            },
        },
        mounted(){
            this.$nextTick(function() {
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
            title: function(val) {
                document.title = `${this.title} - Powered by MrNodeBot`;
            },
        },
        methods: {
            playing: function(player) {
                // Notify
                UIkit.notify({
                    message : `<div class="uk-text-center"><h4>Playing ${this.title}</h4><p>Requested By ${this.from} on ${this.to}</p></div>`,
                    status  : 'info',
                    timeout : 4000,
                    pos     : 'bottom-center'
                });
            },
            ready: function(player) {
            },
            paused: function(player) {
            },
            ended: function(player) {
                // Reset the key
                this.key = '';
                this.from = '';
                this.to = '';
                this.title = '';
                this.seekTime = 0;

                if(this.queue.length > 0) {
                    let item = this.queue.splice(0,1)[0];
                    this.key = item.key;
                    this.seekTime = item.seekTime;
                    this.title = item.title;
                    this.from = item.from;
                    this.to = item.to;
                }
            },
            queueItem: function(
                key, from, to, title, seekTime
            ) {
                title = title || '';
                return {
                    key, from, to, title, seekTime
                };
            },
            initSocket: function () {
                var self = this;
                window.Fsociety.socket.on('youtube', data  => {
                    // No Key, Same key as currently playing, bail
                    if(!data.video || !data.video.key || data.video.key === self.key) return;
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
                    if(self.key == '') {
                        let item = self.queue.splice(0,1)[0];
                        self.key = item.key;
                        self.seekTime = item.seekTime;
                        self.title = item.title;
                        self.from = item.from;
                        self.to = item.to;
                    }
                });
            }
        }
    }


</script>
