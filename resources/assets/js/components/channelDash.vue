<template>
    <div class="uk-margin-top uk-grid uk-container-center">
        <div class="uk-block uk-width-1-1">
            <h1 class="uk-text-center">Channel Usage Statistics</h1>
        </div>
            <a v-for="(result, channel) in sortedResults" :title="getTitle(result)" :href="getActionLink(result.channel)" class="uk-panel uk-panel-header uk-panel-box uk-panel-hover uk-width-large-1-4 uk-width-medium-1-1 uk-width-small-1-1">
                <div class="uk-panel-badge uk-badge">{{numberWithCommas(result.messages)}}</div>
                <h3 class="uk-panel-title">
                    <i v-bind:class="{ watched: result.isWatching, primaryColorText: !result.isWatching }" class="uk-icon-small uk-icon-eye" style="margin-right:10px;"></i>{{result.channel}}
                </h3>
                <ul class="uk-flex uk-flex-middle uk-flex-space-between">
                    <li v-if="result.currentOps.length">
                        Ops: {{result.currentOps.length}}
                    </li>
                    <li v-if="result.currentVoices.length">
                        Voices: {{result.currentVoices.length}}
                    </li>
                    <li v-if="result.currentParticipants.length">
                        Users: {{result.currentParticipants.length}}
                    </li>
                </ul>
            </a>

    </div>
</template>
<style>
    .watched {
        color: rgba(63, 191, 127, 0.9) !important;
    }
</style>
<script>
    export default{
        data(){
            return{
               results: {}
            }
        },
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
                    if(data.status === 'success') {
                        this.results = data.channels;
                    }
                }).catch(e => {
                    console.log(e);
                });
            },
            getTitle: function(result) {
                return !result.topic || !result.topic.topic ? '' : result.topic.topic;
            },
            getActionLink: function(channel) {
                return laroute.route('channel',{
                    channel: encodeURIComponent(channel)
                });
            }
        },
        computed: {
            apiRoute: function () {

                return 'https://bot.fsociety.guru/api/usage/channels/available';
            },
            sortedResults: function() {
                return _(this.results).mapKeys((value,key) => {
                    return value.channel = key;
                }).orderBy(['isWatching','messages'],['desc','desc']).value();
            }
        },
        components:{
        }
    }
</script>
