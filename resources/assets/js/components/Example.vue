<template>
    <div class="container">
        Hello
        <div class="imageBlock" v-for="image in images"></div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                images: []
            };
        },
        ready() {
            this.fetchImages();

        },
        methods: {
            fetchImages() {
                let images = [];
                this.$http.get('http://ra.irony.local:8084/images')
                        .success(function (images) {
                            console.log(images);
                            this.$set('images', images);
                        })
                        .error(function (err) {
                            console.log(err);
                        })
            }
        }
    }
</script>
