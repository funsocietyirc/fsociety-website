<template>
    <div class="gallery-container">
        <div class="">
            <div class="uk-grid">
                <div class="uk-width-large-1-6">
                    <div class="uk-panel uk-panel-header">
                        <h3 class="uk-panel-title">0ptions</h3>
                    </div>
                </div>
                <div class="uk-width-large-5-6" data-uk-observe>
                        <ul id="gallery" class="uk-grid uk-grid-match" data-uk-grid data-uk-grid-margin>
                            <li class="uk-width-large-6-6">
                                <i class="uk-icon-arrow-left uk-icon-large uk-icon-hover uk-width-2-6 uk-margin-small-bottom" style="text-align:right;" v-on:click="prevPage()" :disabled="page == 1"></i>
                                <div class="uk-width-2-6 uk-text-center">
                                    <h1 class="uk-text-center">{{activeChannel}}</h1>
                                        <p>Page {{page}} out of {{pageCount}}</p>
                                </div>
                                <i class="uk-icon-arrow-right uk-icon-large uk-icon-hover uk-width-2-6 uk-margin-small-bottom" v-on:click="nextPage()" :disabled="page == pageCount"></i>
                            </li>
                            <li transition="fade" v-for="image in images" class="uk-width-large-1-6">
                                <div class="uk-thumbnail gallery-image">
                                    <a v-bind:href="image.url" style="display:block !important;margin:auto !important;">
                                        <image-loader  v-bind:src="image.url"></image-loader>
                                    </a>
                                </div>
                            </li>
                        </ul>
                </div>
            </div>
        </div>

    </div>
</template>
<style>
    .gallery-container {
        margin: 10px;
    }
    .uk-thumbnail {
        background:rgba(0,0,0,0.8);
    }
    .gallery-image {
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;

        -ms-flex-align: center;
        -webkit-align-items: center;
        -webkit-box-align: center;

        align-items: center;
        padding:10px;

    }
    .left-button {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
    .right-button {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
</style>
<script>
    export default{
        data(){
            return {
                images: [],
                rowCount: 0,
                pageCount: 0,
                page: 1,
                pageSize: 25,
                activeChannel: '#FSociety',
                channels: [],
            };
        },
        components: {
        },
        ready(){
            this.fetchImages();
        },
        methods: {
            fetchImages: function (page) {
                page = page || 1;
                this.$http.get('https://bot.fsociety.guru/api/urls', {
                    params: {
                        type: 'images',
                        channel: '%23fsociety',
                        page: page,
                        pageSize: this.pageSize
                    }
                }).then(function (response) {
                    return response.json();
                }).then(function (result) {
                    this.$set('rowCount', result.rowCount);
                    this.$set('pageCount', result.pageCount);
                    this.$set('page', result.page);
                    this.$set('pageSize', result.pageSize);
                    this.$set('images', result.results);
                    this.$nextTick(function () {
                        $('#gallery').trigger('display.uk.check');
                    });
                });
            },
            nextPage: function() {
                if(this.page <= this.pageCount) {
                    this.fetchImages(this.page + 1);
                }
            },
            prevPage: function() {
              if(this.page > 1) {
                  this.fetchImages(this.page - 1);
              }
            }
        }
    }
</script>
