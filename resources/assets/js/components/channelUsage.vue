<template>
    <div class="uk-grid uk-margin-top">
            <div class="uk-width-1-1">
                <h1 class="uk-text-center">{{formattedChannel}}</h1>
                <hr>
            </div>
            <div class="uk-width-1-1">
                <div class="uk-width-1-1" style="margin:0 auto;">
                    <vue-chart
                            :columns="columns"
                            :rows="rows"
                            :options="options"
                    ></vue-chart>
                </div>
            </div>
    </div>
</template>
<style>
</style>
<script>
    Vue.use(require('vue-charts'));

    export default{
        mounted(){
            this.fetchData();
            this.options.title = `Usage Stats for ${this.formattedChannel}`;
        },
        methods:{
            fetchData: function () {
                let vm = this;
                this.$http
                        .get(this.apiRoute).then(function (response) {
                    return response.json();
                }).then(function (data) {
                    vm.usageResults = data.results;
                }).catch(e => {
                    console.log(e);
                });
            },
        },
        data(){
            return {
                usageResults: [],
                columns: [{
                    'type': 'string',
                    'label': 'Channel'
                }, {
                    'type': 'number',
                    'label': 'Messages'
                }],
                options: {
                    title: ``,
                    hAxis: {
                        title: 'Date',
                        textStyle: {fontSize: 14}

                    },
                    vAxis: {
                        title: 'Total Messages',
                        gridlines: {
                            count:4
                        },
                    },
                    width: 1800,
                    height: 768,
                    curveType: 'function'
                },

            }
        },
        computed: {
            rows: function() {
                let final = [];
               _.forEach(this.usageResults, result => {
                  final.push([result.date, result.messages])
              });
                return final;
            },
            formattedChannel: function () {
                return this.channelName.toUpperCase();
            },
            apiRoute: function() {
                return 'https://bot.fsociety.guru/api/usage/overtime/' + this.channelName.replace('#','%23');
            }
        },
        props: ['channelName']
    }
</script>
