<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
<div class="gallery-container">
  <div class="uk-grid">
    <div class="uk-container uk-width-large-1-6">
      <div id="options-panel" class="uk-panel uk-panel-header">
        <h1 class="uk-panel-title">Images</h1>
        <div class="container container-center uk-text-justify">
          <h4>Channels</h4>
          <ul class="sort-subnav">
            <li v-for="channel in channels">
              <a v-bind:class="{ 'active': searchTo == channel }" class="to" @click="updateFilter(null,channel)">{{channel}}</a>
            </li>
          </ul>
          <h4>Nicks</h4>
          <ul class="sort-subnav">
            <li v-for="nick in nicks">
              <a v-bind:class="{ 'active': searchFrom == nick }" class="from" @click="updateFilter(nick,null)">{{nick}}</a>
            </li>
          </ul>
        </div>
        <hr>
        <ul class="uk-list uk-text-small uk-margin-bottom">
          <li>Click a Thumbnail to active the Lightbox, use the arrow keys to navigate.</li>
          <li>Scroll Down for more results.</li>
          <li>Use the Arrow keys to navigate inside the Lightbox.</li>
        </ul>
      </div>
    </div>

    <div class="uk-width-large-5-6" data-uk-observe>
      <ul id="gallery" class="uk-grid uk-margin-bottom uk-grid-small uk-grid-match" data-uk-grid data-uk-grid-margin="10">
        <li v-for="image in resultSet" class="uk-width-large-1-6 uk-width-medium-1-4 uk-width-small-1-2">
          <div class="image-border-overlay">
            <div class="uk-thumbnail gallery-image">
              <a data-uk-lightbox="{group:'images'}" class="image-link uk-container-center" :href="image.url" title="">
                <img v-lazy.container="image.url" class="image">
              </a>
            </div>
            <div class="image-overlay">
              <div class="uk-grid">
                <div class="uk-width-1-2">From</div>
                <div class="uk-width-1-2">To</div>
                <div class="uk-width-1-2 from">{{image.from}}</div>
                <div class="uk-width-1-2 to uk-text-truncate">{{image.to}}</div>
              </div>
            </div>
          </div>
        </li>
        <infinite-loading @infinite="onInfinite" ref="infiniteLoading"></infinite-loading>
      </ul>
    </div>
  </div>
</div>
</template>
<style lang="css" scoped>
    .gallery-close-alt {
        background: black;
    }

    .gallery-container {
        margin: 20px 10px;
    }

    .gallery-image {
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;

        -ms-flex-align: center;
        -webkit-align-items: center;
        -webkit-box-align: center;

        align-items: center;
        padding: 10px;
    }

    .image-overlay {
        padding: 2px 5px;
    }

    .image {
        height: 150px;
        object-fit: cover;
    }

    .uk-thumbnail {
        border: none;
        background: rgba(244, 244, 244, 0.1);
    }

    .image-border-overlay {
        border: 1px solid #D12026;
        background: rgba(0, 0, 0, 0.8);
    }

</style>
<script>
const _ = require('lodash');
const apiRoute = 'https://bot.fsociety.guru/api/';

const dataTemplate = {
  // Image data
  images: [],
  nicks: [],
  channels: [],
  pageSize: 30,
  searchFrom: '',
  searchTo: ''
};

export default {
  data() {
    return dataTemplate;
  },
  created() {
    this.fetchData();
    this.initSocket();
  },
  mounted() {
    $('footer').detach();
    window.addEventListener('resize', () => this.$refs.infiniteLoading.$emit('$InfiniteLoading:reset'), {
      passive: false
    });
  },
  computed: {
    resultSet: function() {
      let vm = this;
      return _.filter(vm.images, (image) => {
        if (!vm.searchText && !vm.searchFrom) {
          return true;
        }
        return image.from === vm.searchFrom || image.to === vm.searchTo;
      });
    },
  },
  methods: {
    // Potential Mixins
    updateFilter: function(searchFrom, searchTo) {
      if (searchFrom !== null) {
        this.searchFrom = this.searchFrom === searchFrom ? '' : searchFrom;
      }
      if (searchTo !== null) {
        this.searchTo = this.searchTo === searchTo ? '' : searchTo;
      }
      this.images = [];
      this.$nextTick(function() {
        this.$refs.infiniteLoading.$emit('$InfiniteLoading:reset');
        $('#gallery').trigger('display.uk.check');
      });
    },
    fetchData: function() {
      this.$http
        .get(apiRoute + 'sources', {
          type: 'images',
        })
        .then(function(response) {
          return response.json();
        })
        .then(function(data) {
          this.nicks = this.nicks.concat(data.results.nicks);
          this.channels = this.channels.concat(data.results.channels);
        }).catch(e => {
          console.log(e);
        });
    },
    // END
    onInfinite(state) {
      let params = {
        'type': 'images',
        page: Math.ceil(this.images.length / this.pageSize) + 1,
        pageSize: this.pageSize
      };
      if (this.searchFrom) {
        params.user = this.searchFrom;
      }
      if (this.searchTo) {
        params.channel = this.searchTo;
      }
      this.$http
        .get(apiRoute + 'urls', {
          params
        })
        .then(function(res) {
          return res.json();
        })
        .then(function(data) {
          if (data.results.length) {
            this.images = this.images.concat(data.results);
            _.forEach(data.results, item => {
              if (!_.includes(this.channels, item.to)) {
                this.channels.push(item.to);
              }
              if (!_.includes(this.nicks, item.from)) {
                this.nicks.push(item.from);
              }
            });
            state.loaded();
            if (data.page >= data.pageCount) {
                state.complete();
            }
            this.$nextTick(function() {
              $('#gallery').trigger('display.uk.check');
            });
          } else {
              state.complete();
          }
        });
    },
    initSocket: function() {
      let self = this;
      window.Fsociety.socket.on('image', data => {
        // TODO Splice in new users / channels
        self.images.unshift(data);

        if (!_.includes(this.channels, data.to)) {
          this.channels.unshift(data.to);
        } else {
          this.channels = _.filter(this.channels, channel => channel !== data.to);
          this.channels.unshift(data.to)
        }
        if (!_.includes(this.nicks, data.from)) {
          this.nicks.unshift(data.from);
        } else {
          this.nicks = _.filter(this.nicks, nick => nick !== data.from);
          this.nicks.unshift(data.from);
        }
        // Trigger Updates
        this.$nextTick(function() {
          this.$refs.infiniteLoading.$emit('$InfiniteLoading:reset');
          $('#gallery').trigger('display.uk.check');
        });
      });
    },
  }
}
</script>
