<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
    <div class="gallery-container">
        <div id="image-modal" class="uk-modal" data-uk-modal="{center:true}" style="position:fixed" >
            <div class="uk-modal-dialog uk-modal-dialog-lightbox  uk-modal-dialog-large uk-text-center">
                <a href="" class="uk-modal-close uk-close uk-close-alt gallery-close-alt"></a>
                <img v-bind:src="activeImage" v-bind:alt="activeImage">
            </div>
        </div>
        <div class="uk-grid">
            <div class="uk-width-large-1-6">
                <div id="options-panel" class="uk-panel uk-panel-header">
                    <h3 class="uk-panel-title">0ptions</h3>
                    <i v-on:click="refresh()" class="uk-button uk-button-success uk-width-1-1 uk-margin-small-bottom">Refresh</i>
                    <i v-on:click="toggleFullMode()" class="uk-button uk-button-success uk-width-1-1 uk-margin-small-bottom">Full Mode</i>
                </div>
            </div>

            <div v-show="fullMode" class="uk-width-large-5-6" transition="fade">
                Hello Moto
            </div>

            <div v-show="!fullMode" class="uk-width-large-5-6" data-uk-observe transition="fade">
                    <ul id="gallery" class="uk-grid uk-grid-match" data-uk-grid data-uk-grid-margin>
                        <li class="uk-width-large-6-6">
                            <i class="uk-icon-arrow-left uk-icon-large uk-icon-hover uk-width-2-6 uk-margin-small-bottom" style="text-align:right;" v-on:click="prevPage()" :disabled="page == 1"></i>
                            <div class="uk-width-2-6 uk-text-center">
                                <h1 class="uk-text-center">{{activeChannel}}</h1>
                                    <p>Page {{page}} out of {{pageCount}}</p>
                            </div>
                            <i class="uk-icon-arrow-right uk-icon-large uk-icon-hover uk-width-2-6 uk-margin-small-bottom" v-on:click="nextPage()" :disabled="page == pageCount"></i>
                        </li>
                        <li v-for="image in images" class="uk-width-large-1-6">
                            <div class="uk-thumbnail gallery-image">
                                <a href="#" v-on:click="displayImage(image.url)" style="display:block !important;margin:auto !important;">
                                    <image-loader  v-bind:src="image.url"></image-loader>
                                </a>
                            </div>
                        </li>
                    </ul>
            </div>

        </div>

    </div>
</template>
<style>
    .gallery-close-alt {
        background:black;
    }
    .gallery-container {
        margin: 20px 10px;
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
</style>
<script>
    export default{
        data(){
            return {
                images: [],
                rowCount: 0,
                pageCount: 0,
                page: 1,
                pageSize: 12,
                activeChannel: '#FSociety',
                channels: [],
                activeImage: '',
                scrollToTop:0,
                fullMode: false
            };
        },
        components: {
        },
        ready(){
            $('footer').detach(); // Remove the footer
            this.fetchImages(); // Fetch the images
            this.initModal(); // Init the modal
        },
        methods: {
            initModal: function() {
                let modal = $('#image-modal');
                window.UIkit.modal(modal, {}).on({
                    'show.uk.modal': function(){
                        this.scrollToTop = document.documentElement.scrollTop || document.body.scrollTop;
                    },
                    'hide.uk.modal': function(){
                        document.documentElement.scrollTop = document.body.scrollTop = this.scrollToTop;
                    }
                });
            },
            fetchImages: function (page) {
                page = page || this.page;
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
                    this.$set('activeImage', result.results[0].url);
                    this.$nextTick(function () {
                        $('#gallery').trigger('display.uk.check');
                    });
                });
            },
            refresh: function() {
              this.fetchImages(1);
            },
            nextPage: function() {
                if(this.page != this.pageCount) {
                    this.fetchImages(this.page + 1);
                }
            },
            prevPage: function() {
              if(this.page > 1) {
                  this.fetchImages(this.page - 1);
              }
            },
            displayImage: function(url) {
                let uikit = window.UIkit;
                let modal = uikit.modal('#image-modal');
                this.activeImage = url;
                if ( modal.isActive() ) {
                    modal.hide();
                } else {
                    modal.show();
                }
            },
            toggleFullMode: function () {
                this.$set('fullMode', !this.fullMode);
            }
        }
    }
</script>
