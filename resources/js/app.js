require('./bootstrap');

window.Vue = require('vue');
import VueResource from 'vue-resource';
Vue.use(VueResource);

Vue.component('video-upload', require('./components/VideoUpload.vue').default);
Vue.component('video-player', require('./components/VideoPlayer.vue').default);
Vue.component('video-vote', require('./components/VideoVote.vue').default);
Vue.component('video-comment', require('./components/VideoComment.vue').default);
Vue.component('subscribe-button', require('./components/SubscribeButton.vue').default);

Vue.mixin({
  data: function() {
    return {
      laratube : window.Laratube,
      csrfToken : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    }
  }
})

const app = new Vue({
    el: '#app'
});
