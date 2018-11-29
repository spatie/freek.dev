import Vue from 'vue';

import SearchPosts from './components/SearchPosts';

const searchPostsEl = document.querySelector('#search-posts');

new Vue({
    el: searchPostsEl,

    render: h =>
        h(SearchPosts, {
            props: { ...searchPostsEl.dataset },
        }),
});
