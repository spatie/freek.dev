import Vue from 'vue';
import Turbolinks from 'turbolinks';
import TurbolinksAdapter from 'vue-turbolinks';
import SearchPosts from './components/SearchPosts';

//Vue.use(TurbolinksAdapter);

//document.addEventListener('turbolinks:load', () => {
    const searchPostsEl = document.querySelector('#search-posts');

    new Vue({
        el: searchPostsEl,

        render: h => h(SearchPosts, {
            props: { ...searchPostsEl.dataset },
        }),
    });

    if (document.querySelector('pre code')) {
        import('./modules/highlight' /* webpackChunkName: "highlight" */).then(highlight => {
            highlight.start();
        });
    }
//});

//Turbolinks.start();
