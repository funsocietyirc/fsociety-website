<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
        <div class="uk-grid uk-margin-top">
            <div class="uk-width-10-10 red-bottom">
                <div class="uk-container uk-container-center uk-text-center">
                    <h1>IRC Links</h1>
                </div>
            </div>
            <div class="uk-width-2-10">
                <div class="uk-container uk-margin-top">
                    <table class="uk-table">
                        <thead>
                        <tr>
                            <th>Channels</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr transition="fade" v-bind:class="{ 'currentSearch': isActiveSearch(result) }" v-for="result in to">
                            <td class="to clickable" @click="updateFilter(result)">
                                {{result}}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="uk-table">
                        <thead>
                        <tr>
                            <th>Nicks</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr transition="fade" v-bind:class="{ 'currentSearch': isActiveSearch(result) }" v-for="result in from">
                            <td class="from clickable" @click="updateFilter(result)">
                                {{result}}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="uk-width-8-10">
                        <table id="linkTable" class="uk-table uk-table-striped uk-table-condensed uk-margin-top uk-margin-bottom">
                            <thead>
                            <tr>
                                <th>To</th>
                                <th>From</th>
                                <th>URL</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr transition="fade" :data="data" v-for="result in data | filterBy searchText in 'from' 'to'">
                                <td class="to uk-width-1-6">{{result.to}}</td>
                                <td class="from uk-width-1-6">{{result.from}}</td>
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
        color:white;
    }
    .currentSearch {
        background:rgba(245,245,245,0.1);
    }
</style>
<script>
    const apiRoute = 'https://bot.fsociety.guru/api/urls?pageSize=100';
    export default{
        data(){
            return{
                data: [],
                to: [],
                from: [],
                searchText: '',
            }
        },
        created(){
            this.searchText = window.activeSearch;

            this.fetchData();
            this.initPusher();
        },
        watch: {
          data: function (val, oldVal) {

              let to = _.map(val, 'to');
              let from = _.map(val, 'from');

              this.$set('to', _.uniq(to));
              this.$set('from', _.uniq(from));
          }
        },
        methods: {
            isActiveSearch: function(val) {
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
                });
            }
        },
        components:{
        }
    }
</script>
