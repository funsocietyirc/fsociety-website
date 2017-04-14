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
                currentKey: ''
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
                console.dir(data);
                  self.currentKey = data.youtubeKey
                });
            }
        }
    }
</script>
