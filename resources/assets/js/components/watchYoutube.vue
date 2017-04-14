<template>
    <div>
        <iframe class="fullscreen" v-if="currentKey" id="video" :src="currentUrl" frameborder="0"
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
                currentKey: '',
            }
        },
        computed: {
            currentUrl: function(){
                if(!this.currentKey) return false;
                return `//www.youtube.com/embed/${this.currentKey}?rel=0&autoplay=1`;
            }
        },
        mounted(){
            this.initPusher();
        },
        methods: {
            initPusher: function () {
                var self = this;
                window.Fsociety.publicChannel.bind('youtube', data  => {

                    // Update the key, if they video is the same, then set the current frame to nothing for a sec
                    if(self.currentKey === data.youtubeKey) self.currentKey = '';
                    self.currentKey = data.youtubeKey;

                    // Update title
                    document.title = `${data.videoTitle} - Powered by MrNodeBot`;

                    // Notify
                    UIkit.notify({
                        message : `<div class="uk-text-center"><h4>Playing ${data.videoTitle}</h4><p>Requested By ${data.from} on ${data.to}</p></div>`,
                        status  : 'info',
                        timeout : 4000,
                        pos     : 'bottom-center'
                    });

                });
            }
        }
    }

</script>
