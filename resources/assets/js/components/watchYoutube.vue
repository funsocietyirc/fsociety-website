<template>
    <div>
        <iframe class="fullscreen" v-if="key" id="video" :src="url" frameborder="0"
                allowfullscreen></iframe>
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
                index: 0,
                list: '',
            }
        },
        computed: {
            url: function(){
                if(!this.key) return false;
                let args = [];
                if(this.seekTime) args.push(`start=${this.seekTime}`);
                if(this.list && this.list != '') args.push(`list=${this.list}`);
                args.push(`autoplay=1`);
                return `//www.youtube.com/embed/${this.key}?` + args.join('&');
            }
        },
        mounted(){
            this.initSocket();
        },
        methods: {
            initSocket: function () {
                var self = this;
                window.Fsociety.socket.on('youtube', data  => {
                    // Update the key, if they video is the same, then set the current frame to nothing for a sec
                    if(self.key === data.video.key) self.key = '';
                    self.key = data.video.key;

                    self.seekTime = data.seekTime || 0;
                    self.index = data.index || 0;

                    if(data.playlist && data.playlist.key) self.list = data.playlist.key;

                    // Update title
                    document.title = `${data.video.videoTitle} - Powered by MrNodeBot`;

                    // Notify
                    UIkit.notify({
                        message : `<div class="uk-text-center"><h4>Playing ${data.video.videoTitle}</h4><p>Requested By ${data.from} on ${data.to}</p></div>`,
                        status  : 'info',
                        timeout : 4000,
                        pos     : 'bottom-center'
                    });

                });
            }
        }
    }

</script>
