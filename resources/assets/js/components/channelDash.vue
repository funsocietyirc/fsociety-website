<template xmlns:v-bind="http://www.w3.org/1999/xhtml">
    <div class="uk-grid uk-container-center">
        <header class="uk-block  uk-cover-background uk-width-1-1">
            <h1 class="uk-text-truncate uk-text-center">
                Channel Usage Statistics
            </h1>
        </header>
        <hr class="uk-width-1-1 uk-margin-bottom">
        <a v-for="(result, channel) in sortedResults" :title="getTitle(result)" :href="getActionLink(result.channel)"
           data-uk-tooltip
           class="uk-panel uk-panel-header uk-panel-box uk-panel-hover uk-width-large-1-4 uk-width-medium-1-1 uk-width-small-1-1">
            <div class="uk-panel-badge uk-badge">{{numberWithCommas(result.messages)}}</div>
            <h3 class="uk-panel-title">
                <i v-bind:class="{ watched: result.isWatching, primaryColorText: !result.isWatching }"
                   class="uk-icon-small uk-icon-eye" style="margin-right:10px;"></i><span class="to">{{result.channel}}</span>
            </h3>
            <ul class="uk-grid">
                <li class="uk-width-1-2" v-if="result.currentOps.length">
                    Ops: {{result.currentOps.length}}
                </li>
                <li class="uk-width-1-2" v-if="result.currentVoices.length">
                    Voices: {{result.currentVoices.length}}
                </li>
                <li class="uk-width-1-2" v-if="result.currentParticipants.length">
                    Users: {{result.currentParticipants.length}}
                </li>
                <li class="uk-width-1-2" v-if="result.popularityRanking">
                    Popularity: {{result.popularityRanking.meanScore}}
                </li>
            </ul>
        </a>

    </div>
</template>
<style lang="css">
      header {
        background-image: url('/images/arg/banner.png');
      }
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
