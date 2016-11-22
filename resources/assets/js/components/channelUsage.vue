<template>
    <div class="uk-grid uk-margin-top">
            <div class="uk-width-1-1">
                <h1 class="uk-text-center">{{formattedChannel}}</h1>
                <hr>
            </div>
            <div class="uk-width-1-1">
                <vue-chart
                        chart-type="Calendar"
                        :packages="chartPackages"
                        :columns="columns"
                        :rows="rows"
                        :options="options"
                        class="test"
                ></vue-chart>
            </div>
    </div>
</template>
<style>
</style>
<script>
    const _ = require('lodash');
    const moment = require('moment');
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
                chartPackages: ['corechart','calendar'],
                usageResults: [],
                columns: [{
                    'type': 'date',
                    'label': 'Date'
                }, {
                    'type': 'number',
                    'label': 'Messages'
                }],
                options: {
                    title: ``,
                    height: 480,
                    calendar: {
                        underYearSpace: 10, // Bottom padding for the year labels.
                        yearLabel: {
                            fontName: 'Times-Roman',
                            fontSize: 32,
                            color: '#D12026',
                            bold: true,
                        }
                    }
                },

            }
        },
        computed: {
            rows: function() {
                let final = [];
               _.forEach(this.usageResults, result => {
                  final.push([moment(result.raw).toDate(), result.messages])
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
