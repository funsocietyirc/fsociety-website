<template>
    <div class="uk-panel root-panel">
        <div v-show="usageResults.length">
            <div id="usage" style="height:360px;">
                <vue-chart
                        chart-type="Calendar"
                        :packages="chartPackages"
                        :columns="cols"
                        :rows="rows"
                        :options="calOptions"
                ></vue-chart>
            </div>
            <hr>
            <div id="line">
                <vue-chart
                        :columns="cols"
                        :rows="rows"
                        :options="lineOptions"
                ></vue-chart>
            </div>
            <p class="uk-text-center">Drag to Zoom, Right click to Reset</p>
            <hr>
            <ul>
                <li>
                    <span class="primaryColorText">Total:</span> {{numberWithCommas(totalResults)}}
                </li>
                <li class="muted">
                    <span class="primaryColorText">Peak </span> {{numberWithCommas(this.mostActive.messages)}} - <span class="timeStamp">{{this.mostActive.timestamp}}</span> - <span class="timeStamp">{{mostActiveDay}}</span>
                </li>
            </ul>
        </div>
        <div class="uk-text-center" v-show="!usageResults.length">
            <h3>There are no results available for this channel and or nick combination</h3>
        </div>
    </div>
</template>
<style>
    .root-panel {
        background: rgba(0,0,0,0.8);
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
            numberWithCommas: function(n) {
                return (!n || !n.toString) ? '' :  n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
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
                pieCols: [{
                    'type': 'string',
                    'label': 'Date'
                },{
                    'type': 'number',
                    'label': 'Messages'
                }],
                lineOptions: {
                    title: '',
                    explorer: {
                        actions: ['dragToZoom','rightClickToReset'],
                        axis: 'horizontal',
                        keepInBounds: true,
                        maxZoomIn: 0.01,
                    },
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
                      format: 'decimal',
                      textStyle: {
                        color: '#666666',
                        fontName: 'Helvetica Neue',
                      },
                      titleTextStyle: {
                        color: '#666666',
                        fontName: 'Helvetica Neue',
                      },
                      minValue: 0,
                      viewWindow: {
                        min: 0,
                      }
                    },
                },
                calOptions: {
                    title: 'Calendar',
                    width: 1098,
                    height: 640,
                    colorAxis: {minValue: 0, colors: ['#FFFFFF', '#D12026']},
                    noDataPattern: {
                        backgroundColor: '#1a1a1a',
                        color: '#1a1a1a'
                    },
                    calendar: {
                        underYearSpace: 10, // Bottom padding for the year labels.
                        dayOfWeekLabel: {
                            fontName: 'Helvetica Neue',
                            fontSize: 12,
                            color: '#666666',
                        },
                        yearLabel: {
                            fontName: 'Helvetica Neue',
                            fontSize: 32,
                            color: '#D12026',
                        },
                        monthLabel: {
                            fontName: 'Helvetica Neue',
                            fontSize: 12,
                            color: '#a6a6a6',
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
                        focusedCellColor: {
                            stroke: 'red',
                            strokeOpacity: 0.8,
                            strokeWidth: 1,
                        },
                        cellSize:17,
                        cellColor: {
                            stroke: 'black',
                            strokeOpacity: 0.5,
                            strokeWidth: 2,
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
                return 'https://bot.fsociety.guru/api/usage/channels/overtime/' + this.channelName.replaceAll('#', '%23') + (this.nickName ? `/${this.nickName}` : '');
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
