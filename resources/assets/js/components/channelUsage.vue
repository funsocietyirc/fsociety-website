<template>
    <div>
        <dl>
            <dt class="primaryColorText">Total Messages:</dt>
            <dd>{{totalResults}}</dd>
            <dt class="primaryColorText">Most Active:</dt>
            <dd><span class="timeStamp">{{this.mostActive.timestamp}}</span> <span class="primaryColorText">|</span>
                <span class="timeStamp">{{mostActiveDay}}</span> <span class="primaryColorText">|</span>
                {{this.mostActive.messages}} messages
            </dd>
        </dl>
        <div class="uk-text-center uk-container-center">
            <div id="usage" style="height:180px;">
                <vue-chart
                        chart-type="Calendar"
                        :packages="chartPackages"
                        :columns="cols"
                        :rows="rows"
                        :options="calOptions"
                ></vue-chart>
            </div>
            <div id="line" style="height:640px;">
                <vue-chart
                        :columns="cols"
                        :rows="rows"
                        :options="lineOptions"
                ></vue-chart>
            </div>
        </div>
    </div>

</template>
<style>
    dt:before {
        content: "";
        display: block;
    }
    dt, dd {
        display: inline;
    }


</style>
<script>
    const _ = require('lodash');
    const moment = require('moment');
    Vue.use(require('vue-charts'));

    export default{
        created() {
            this.fetchData();
        },
        methods: {
            fetchData: function () {
                let vm = this;
                this.$http
                        .get(this.apiRoute).then(function (response) {
                    return response.json();
                }).then(function (data) {
                    vm.usageResults = data.results;
                    vm.leastActive = data.lowest;
                    vm.mostActive = data.highest;
                }).catch(e => {
                    console.log(e);
                });
            },
        },
        data(){
            return {
                chartPackages: ['corechart', 'calendar'],
                usageResults: [],
                mostActive: {
                    timestamp: '',
                },
                leastActive: {
                    timestamp: '',
                },
                cols: [{
                    'type': 'date',
                    'label': 'Date'
                }, {
                    'type': 'number',
                    'label': 'Messages'
                }],
                lineOptions: {
                    title: 'Frequency',
                    height:320,
                    width:1100,
                    colors: ['#D12026'],
                    curveType: 'function',
                    backgroundColor:'black',
                    legend: {
                        maxLines:0,
                        position:'none',
                    },
                    lineWidth:2,
                    hAxis: {
                      textStyle: {
                        color: '#666666',
                        fontName: 'Helvetica Neue',
                      },
                      titleTextStyle: {
                        color: '#666666',
                        fontName: 'Helvetica Neue',
                      },
                    },
                    vAxis: {
                      textStyle: {
                        color: '#666666',
                        fontName: 'Helvetica Neue',
                      },
                      titleTextStyle: {
                        color: '#666666',
                        fontName: 'Helvetica Neue',
                      },
                    },
                },
                calOptions: {
                    title: 'Calender',
                    width: 1098,
                    colorAxis: {minValue: 0, colors: ['#FFFFFF', '#D12026']},
                    noDataPattern: {
                        backgroundColor: '#000000',
                        color: '#000000'
                    },
                    dayOfWeekLabel: {
                        fontName: 'Helvetica Neue',
                        fontSize: 12,
                        color: '#666666',
                        bold: false,
                        italic: false
                    },
                    calendar: {
                        underYearSpace: 10, // Bottom padding for the year labels.

                        yearLabel: {
                            fontName: 'Helvetica Neue',
                            fontSize: 32,
                            color: '#D12026',
                            bold: true,
                        },
                        monthLabel: {
                            fontName: 'Helvetica Neue',
                            fontSize: 12,
                            color: '#FFFFFF',
                            bold: true,
                            italic: true
                        },
                        monthOutlineColor: {
                            stroke: '#981b48',
                            strokeOpacity: 0.8,
                            strokeWidth: 2
                        },
                        unusedMonthOutlineColor: {
                            stroke: '#bc5679',
                            strokeOpacity: 0.0,
                            strokeWidth: 0
                        },
                    }
                },

            }
        },
        computed: {
            rows: function () {
                let final = [];
                _.forEach(this.usageResults, result => {
                    final.push([moment(result.raw).toDate(), result.messages])
                });
                return final;
            },
            apiRoute: function () {
                return 'https://bot.fsociety.guru/api/usage/overtime/' + this.channelName.replaceAll('#', '%23') + (this.nickName ? `/${this.nickName}` : '');
            },
            totalResults: function () {
                return _.sumBy(this.usageResults, 'messages');
            },
            mostActiveDay: function() {
                return moment(this.mostActive.raw).fromNow();
            },
        },
        props: ['channelName', 'nickName']
    }


</script>
