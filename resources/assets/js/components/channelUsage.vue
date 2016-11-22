<template>
    <div>
        <vue-chart
                chart-type="Calendar"
                :packages="chartPackages"
                :columns="calCols"
                :rows="calRows"
                :options="calOptions"
        ></vue-chart>
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
        },
        methods: {
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
                chartPackages: ['corechart', 'calendar'],
                usageResults: [],
                calCols: [{
                    'type': 'date',
                    'label': 'Date'
                }, {
                    'type': 'number',
                    'label': 'Messages'
                }],
                calOptions: {
                    title:'Calender',
                    height: 360,
                    colorAxis: {minValue: 0,  colors: ['#FFFFFF','#D12026']},
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
            calRows: function () {
                let final = [];
                _.forEach(this.usageResults, result => {
                    final.push([moment(result.raw).toDate(), result.messages])
                });
                return final;
            },
            apiRoute: function () {
                return 'https://bot.fsociety.guru/api/usage/overtime/' + this.channelName.replace('#', '%23') + (this.nickName ? `/${this.nickName}` : '');
            }
        },
        props: ['channelName','nickName']
    }
</script>
