var app = new Vue(
  {
    el: "#customer-list",
    data: {
      clients: ""
    },
    mounted: function(){
      let self = this;

      $.getJSON( "https://spreadsheets.google.com/feeds/list/1r4sRWEOX74_7z-gsdVFx_qXnegnwkbcbpYA9uJ-fr-w/1/public/values?alt=json", function( data ) {
        self.clients = data.feed.entry;
      });
    }
  }
)