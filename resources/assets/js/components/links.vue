<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
    <div class="uk-grid uk-margin-top">
        <div class="uk-width-10-10 red-bottom">
            <div class="uk-container uk-container-center uk-text-center">
                <h2>{{searchText || 'All Links' | capitalize}}</h2>
            </div>
        </div>
        <div id="navBar" class="uk-width-large-2-10">
            <h1 class="uk-text-medium uk-margin-top">IRC Gallery</h1>
            <table class="uk-table uk-table-condensed uk-margin-top">
                <thead>
                <tr>
                    <th>Last 25 Channels</th>
                </tr>
                </thead>
                <tbody>
                <tr transition="fade" v-bind:class="{ 'currentSearch': isActiveSearch(result) }"
                    v-for="result in to">
                    <td v-bind:data-to="result" class="to clickable" @click="updateFilter(result)">{{result}}</td>
                </tr>
                </tbody>
            </table>

            <table class="uk-table uk-table-condensed">
                <thead>
                <tr>
                    <th>Last 20 Nicks</th>
                </tr>
                </thead>
                <tbody>
                <tr transition="fade" v-bind:class="{ 'currentSearch': isActiveSearch(result) }"
                    v-for="result in from">
                    <td v-bind:data-from="result" class="from clickable" @click="updateFilter(result)">{{result}}</td>
                </tr>
                </tbody>
            </table>
            <hr>
            <div class="uk-width-1-1 clear-div">
                <button transition="fadeDown" v-show="searchText" class="uk-btn uk-width-1-1" @click="updateFilter('')">
                    Clear
                </button>
            </div>
        </div>
        <div class="uk-width-large-8-10">
            <div class="uk-overflow-container">
                <table id="linkTable" class="uk-table uk-table-striped uk-table-condensed uk-margin-top uk-margin-bottom">
                    <thead>
                    <tr>
                        <th>To</th>
                        <th>From</th>
                        <th>URL</th>
                        <th>Timestamp</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-bind:data-timestamp="result.timestamp" v-for="result in resultSet | exactFilterBy searchText in 'from' 'to'">
                        <td class="to uk-width-1-6 clickable" @click="updateFilter(result.to)">{{result.to}}</td>
                        <td class="from uk-width-1-6 clickable" @click="updateFilter(result.from)">{{result.from}}</td>
                        <td class="url uk-width-3-6">

                            <a data-uk-tooltip @click="linkClicked(result, $event)" :title="result.title">
                                {{result.url}}
                            </a>
                        </td>
                        <td class="uk-width-1-6">{{result.timestamp | date "%D %R"}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<style>
    .red-bottom {
        border-bottom: 1px solid #D12026;
    }
    .clear-div {
        padding: 0 5px;
    }
    .clickable {
        cursor: pointer;
    }
    .clickable:hover, .clickable:active {
        color: white;
    }
    .currentSearch {
        background: rgba(245, 245, 245, 0.1);
    }
    .new {
        background-color: rgba(60, 210, 24, 0.2) !important;
        transition: all 1s linear;
    }
</style>
<script>
    // API route
    const apiRoute = 'https://bot.fsociety.guru/api/urls?pageSize=100';

    // Custom Filter
    Vue.filter('exactFilterBy', (array, needle, inKeyword, key, key2) => array.filter(item => needle === '' || item[key].toLowerCase() == needle.toLowerCase() || item[key2].toLowerCase() == needle.toLowerCase()));

    export default{
        data(){
            return {
                data: [],
                to: [],
                from: [],
                searchText: '',
            }
        },
        created(){
            $('footer').detach();
            this.searchText = window.activeSearch;
            this.fetchData();
            this.initPusher();
        },
        computed: {
            resultSet: function () {
                return this.data;
            }
        },
        watch: {
            data: function (val, oldVal) {
                let to = _(val).map('to').uniq().take(25).value();
                let from = _(val).map('from').uniq().take(20).value();

                this.$set('to', to);
                this.$set('from', from);
            }
        },
        methods: {
            linkClicked: function(link, event) {
                if(
                        link.url.startsWith('https://youtu.be') ||
                        link.url.startsWith('https://www.youtube.com/watch?') ||
                        link.url.endsWith('.jpg') ||
                        link.url.endsWith('.png') ||
                        link.url.endsWith('.gif') ||
                        link.url.endsWith('.jpeg') ||
                        link.url.endsWith('.webm') ||
                        link.url.endsWith('.mp4')
                ) {
                    let lb = window.UIkit.lightbox;
                    lb.create([{
                        source: link.url,
                        title: link.title,
                        keyboard: false,
                    }]).show();
                } else {
                    window.open(link.url, '_blank');
                }
            },
            isActiveSearch: function (val) {
                return val === this.searchText;
            },
            updateFilter: function (val) {
                this.searchText = this.searchText === val ? '' : val;
                this.$nextTick(function () {
                    $('#linkTable').trigger('display.uk.check');
                });
            },
            fetchData: function () {
                this.$http.get(apiRoute).then(function (response) {
                    return response.json();
                }).then(function (data) {
                    this.$set('data', data.results);
                }).catch(e => {
                    console.log(e);
                });
            },
            initPusher: function () {
                let self = this;
                let channel = socket.subscribe('public');
                channel.bind('wallops', (data)  => {
                    if(!data.message) {
                        return;
                    }
                    UIkit.notify({
                        message : data.message,
                        status  : 'info',
                        timeout : 5000,
                        pos     : 'top-center'
                    });
                });
                channel.bind('url', (data) => {
                    self.data.unshift(data);
                    self.$nextTick(function () {
                        let element = $('#linkTable').find("[data-timestamp='" + data.timestamp + "']");
                        let navBar = $('#navBar');
                        let to = navBar.find("[data-to='" + data.to + "']");
                        let from = navBar.find("[data-from='" + data.from + "']");
                        element.addClass('new');
                        to.addClass('new');
                        from.addClass('new');
                        setTimeout(function () {
                            element.removeClass('new');
                            to.removeClass('new');
                            from.removeClass('new');
                        }, 5000);
                    });
                });
            }
        }
    }
</script>
