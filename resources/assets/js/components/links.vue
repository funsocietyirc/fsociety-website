<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
    <div class="uk-grid uk-margin-top">
        <div class="uk-width-10-10 red-bottom">
            <div class="uk-container uk-container-center uk-text-center">
                <h1>{{searchText || 'All Links'}}</h1>
            </div>
        </div>
        <div id="navBar" class="uk-width-large-2-10">
                <table class="uk-table uk-table-condensed uk-margin-top">
                    <thead>
                    <tr>
                        <th>Last 25 channels</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr transition="fade" v-bind:class="{ 'currentSearch': isActiveSearch(result) }"
                        v-for="result in to">
                        <td v-bind:data-to="result" class="to clickable" @click="updateFilter(result)">
                            {{result}}
                        </td>
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
                        <td v-bind:data-from="result" class="from clickable" @click="updateFilter(result)">
                            {{result}}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <hr>
                <button transition="fadeDown" v-show="searchText" class="uk-btn uk-width-1-1" @click="updateFilter('')">
                    Clear
                </button>
        </div>
        <div class="uk-width-large-8-10">
            <table id="linkTable" class="uk-table uk-table-striped uk-table-condensed uk-margin-top uk-margin-bottom">
                <thead>
                <tr>
                    <th>To</th>
                    <th>From</th>
                    <th>URL</th>
                </tr>
                </thead>
                <tbody>
                <tr v-bind:data-url="result.url" v-for="result in resultSet | exactFilterBy searchText in 'from' 'to'">
                    <td class="to uk-width-1-6 clickable" @click="updateFilter(result.to)">{{result.to}}</td>
                    <td class="from uk-width-1-6 clickable" @click="updateFilter(result.from)">{{result.from}}</td>
                    <td class="url uk-width-4-6"><a target="_blank" v-bind:href="result.url">{{result.url}}</a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<style>
    .red-bottom {
        border-bottom: 1px solid #D12026;
    }

    .to {
        color: #D12026;
    }

    .from {
        color: #f9ff95;
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
        background-color: rgba(54, 168, 21, 0.3) !important;
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
                channel.bind('url', (data) => {
                    self.data.unshift(data);
                    self.$nextTick(function () {
                        let element = $('#linkTable').find("[data-url='" + data.url + "']");
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
        },
        components: {}
    }
</script>
