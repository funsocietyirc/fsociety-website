<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
    <div class="uk-container uk-container-center uk-table-condensed uk-margin-top">
        <h1>IRC Links</h1>
        <div class="uk-overflow-container">
            <table class="uk-table uk-table-striped">
                <thead>
                <tr>
                    <th>To</th>
                    <th>From</th>
                    <th>URL</th>
                </tr>
                </thead>
                <tbody>
                <tr transition="fade" v-for="result in data">
                    <td class="to">{{result.to}}</td>
                    <td class="from">{{result.from}}</td>
                    <td class="url"><a target="_blank" v-bind:href="result.url">{{result.url}}</a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<style>
    .to {
        color: #D12026;
    }
    .from {
        color: #f9ff95;
    }
</style>
<script>
    const apiRoute = 'https://bot.fsociety.guru/api/urls';
    export default{
        data(){
            return{
                data: []
            }
        },
        created(){
            this.fetchData();
            this.initPusher();
        },
        methods: {
            fetchData: function() {
                this.$http.get(apiRoute).then(function (response) {
                    return response.json();
                }).then(function (data) {
                    console.log(data);
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
            },

        },
        components:{
        }
    }
</script>
