<template>
    <div>
        <iframe class="fullscreen" v-if="currentKey" id="video" :src="currentUrl" frameborder="0" allowfullscreen></iframe>
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
                currentTitle: '',
                from: '',
                to: '',
            }
        },
        computed: {
            currentUrl: function(){
                if(!this.currentKey) return false;
                return `//www.youtube.com/embed/${this.currentKey}?rel=0&autoplay=1`;
            }
        },
        watch: {
            currentTitle: function(newTitle) {
                document.title = `${newTitle} - Powered by MrNodeBot`;
            },
            from: function(newFrom) {
                UIkit.notify({
                    message : `<div class="uk-text-center"><h4>Playing ${this.currentTitle}</h4><p>Requested By ${this.from} on ${this.to}</p></div>`,
                    status  : 'info',
                    timeout : 4000,
                    pos     : 'bottom-center'
                });
            }
        },
        mounted(){
            this.initPusher();
        },
        methods: {
            initPusher: function () {
                var self = this;
                window.Fsociety.publicChannel.bind('youtube', data  => {
                  if(self.currentKey === data.youtubeKey) self.currentKey = '';
                  self.currentKey = data.youtubeKey;
                  self.currentTitle = data.videoTitle;
                  self.from = data.from;
                  self.to = data.to;
                });
            }
        }
    }
</script>
