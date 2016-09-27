<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
    <div class="gallery-container">

        <div id="image-modal" class="uk-modal" data-uk-modal="{center:true}" style="position:fixed">
            <div class="uk-modal-dialog uk-modal-dialog-lightbox  uk-modal-dialog-large uk-text-center">
                <a href="" class="uk-modal-close uk-close uk-close-alt gallery-close-alt"></a>
                <img src="#" v-bind:src="activeImage.url || ''" v-bind:alt="activeImage.url">
            </div>
        </div>

        <div class="uk-grid">

            <div class="uk-width-large-1-6">
                <div id="options-panel" class="uk-panel uk-panel-header">
                    <h3 class="uk-panel-title">0ptions</h3>
                    <form class="uk-form uk-form-stacked">
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="selectedChannel">Channel</label>
                            <select class="uk-form-controls uk-width-1-1" id="selectedChannel" v-model="selectedChannel">
                                <option value="$all" selected>All Channels</option>
                                <option v-for="channel in availableChannels" v-bind:value="channel">{{channel}}</option>
                            </select>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="selectedNick">Nick</label>
                            <select class="uk-form-controls uk-width-1-1" id="selectedNick" v-model="selectedNick">
                                <option value="$all" selected>All Nicks</option>
                                <option v-for="nick in availableNicks" v-bind:value="nick">{{nick | capitalize}}
                                </option>
                            </select>
                        </div>
                    </form>
                    <div class="uk-margin-top">
                        <hr>
                        <i v-on:click="refresh()"
                           class="uk-button uk-button-success uk-width-1-1 uk-margin-small-bottom">Refresh</i>
                        <!--<i v-on:click="toggleFullMode()" class="uk-button uk-button-success uk-width-1-1 uk-margin-small-bottom">Full Mode</i>-->
                    </div>
                </div>
            </div>

            <div v-show="fullMode" class="uk-width-large-5-6">
                Hello Moto
            </div>

            <div v-show="!fullMode" class="uk-width-large-5-6" data-uk-observe>
                <ul id="gallery" class="uk-grid uk-grid-match" data-uk-grid data-uk-grid-margin>
                    <li class="uk-width-large-6-6 ">
                        <hr class="uk-visible-small">
                        <i class="uk-icon-arrow-left uk-icon-large uk-icon-hover uk-width-2-6 uk-margin-small-bottom"
                           style="text-align:right;" v-on:click="prevPage()" :disabled="page == 1"></i>
                        <div class="uk-width-2-6 uk-text-center">
                            <h1 class="uk-text-center ">{{activeDisplay.nick || activeDisplay.channel || 'All Images'}}</h1>
                            <p>Page {{page}} out of {{pageCount}}</p>
                        </div>
                        <i class="uk-icon-arrow-right uk-icon-large uk-icon-hover uk-width-2-6 uk-margin-small-bottom"
                           v-on:click="nextPage()" :disabled="page == pageCount"></i>
                    </li>
                    <li v-for="image in images" class="uk-width-large-1-6">
                        <div class="uk-thumbnail gallery-image">
                            <a href="#" v-on:click="displayImage(image)"
                               style="display:block !important;margin:auto !important;">
                                <image-loader v-bind:src="image.url"></image-loader>
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
        background: black;
    }

    .gallery-container {
        margin: 20px 10px;
    }

    .uk-thumbnail {
        background: rgba(0, 0, 0, 0.8);
    }

    .gallery-image {
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;

        -ms-flex-align: center;
        -webkit-align-items: center;
        -webkit-box-align: center;

        align-items: center;
        padding: 10px;

    }
</style>
<script>
    const apiRoute = 'https://bot.fsociety.guru/api/';
    const initialPageSize = 12;

    const imageTemplate = {
        url: '',
        to: '',
        from: '',
        timeStamp: ''
    };

    const activeDisplayTemplate = {
        nick: null,
        channel: null
    };

    const dataTemplate = {
        // Image data
        images: [],

        // Pagination
        rowCount: 0,
        pageCount: 0,
        page: 1,
        pageSize: initialPageSize,
        activeDisplay: activeDisplayTemplate,

        availableChannels: [],
        availableNicks: [],

        activeImage: imageTemplate,

        selectedChannel: null,
        selectedNick: null,

        scrollToTop: 0,
        fullMode: false
    };

    export default{
        data(){
            return dataTemplate;
        },
        watch: {
            'selectedNick': function (val, oldVal) {
                if(!oldVal) {
                    return;
                }

                this.$set('activeDisplay', {
                    nick: val,
                    channel: null
                });

                this.fetchImages(1);

            },
            'selectedChannel': function (val, oldVal) {
                if(!oldVal) {
                    return;
                }
                val = val === '$all' ? null : val;

                this.$set('activeDisplay', {
                    nick: null,
                    channel: val
                });
                this.fetchImages(1);
            }
        },
        components: {},
        created(){
            $('footer').detach();
            this.fetchImages();
            this.fetchData();
            this.initModal();
            this.initPusher();
        },
        methods: {
            initPusher: function () {
                let self = this;
                let channel = socket.subscribe('public');
                channel.bind('image', (data) => {
                    if(self.activeDisplay.nick && self.activeDisplay.nick != data.from) {
                        return;
                    }
                    if(self.activeDisplay.channel && self.activeDisplay.channel != data.to) {
                        return;
                    }
                    self.images.unshift(data);
                    self.$nextTick(function () {
                        $('#gallery').trigger('display.uk.check');
                    });
                });
            },
            initModal: function () {
                let modal = $('#image-modal');
                window.UIkit.modal(modal).on({
                    'show.uk.modal': function () {
                        this.scrollToTop = document.documentElement.scrollTop || document.body.scrollTop;
                    },
                    'hide.uk.modal': function () {
                        document.documentElement.scrollTop = document.body.scrollTop = this.scrollToTop;
                    }
                });
            },
            fetchData: function () {
                this.$http.get(apiRoute + 'sources', {
                    type: 'images',
                }).then(function (response) {
                    return response.json();
                }).then(function (data) {
                    this.$set('availableNicks', data.results.nicks);
                    this.$set('availableChannels', data.results.channels);
                }).catch(e => {
                    console.log(e);
                });
            },
            fetchImages: function (page) {
                page = page || this.page;
                let params = {
                    type: 'images',
                    page: page,
                    pageSize: this.pageSize
                };

                // Filter by active Display
                if (this.activeDisplay.channel) {
                    params.channel = this.activeDisplay.channel.replace('#','%23');
                }

                if (this.activeDisplay.nick) {
                    params.user = this.activeDisplay.nick;
                }

                this.$http.get(apiRoute + 'urls', {
                    params: params
                }).then(function (response) {
                    return response.json();
                }).then(function (result) {
                    this.$set('rowCount', result.rowCount);
                    this.$set('pageCount', result.pageCount);
                    this.$set('page', result.page);
                    this.$set('pageSize', result.pageSize);
                    this.$set('images', result.results);
                    this.$set('activeImage', result.results[0]);
                    this.$nextTick(function () {
                        $('#gallery').trigger('display.uk.check');
                    });
                }).catch(e => {
                    console.log(e);
                });
            },
            refresh: function () {
                this.fetchData();
                this.fetchImages(1);
            },
            nextPage: function () {
                if (this.page != this.pageCount) {
                    this.fetchImages(this.page + 1);
                }
            },
            prevPage: function () {
                if (this.page > 1) {
                    this.fetchImages(this.page - 1);
                }
            },
            displayImage: function (image) {
                let uikit = window.UIkit;
                let modal = uikit.modal('#image-modal');
                this.activeImage = image;
                if (modal.isActive()) {
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
