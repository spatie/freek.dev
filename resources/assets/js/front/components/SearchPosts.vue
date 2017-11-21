<template>
    <div style="position: relative">
        <div>
            <input class="search-input" placeholder="Search blogposts…" v-model="query" type="text"
                   @input="performSearch">
        </div>

        <div v-if="query.length" class="search-results">
            <div v-if="hits.length">
                <ul v-for="hit in hits">
                    <li><a :href="hit.url" v-html="hit._highlightResult.title.value"></a></li>
                </ul>
            </div>
            <div v-else>
                <div>
                    <div class="bg-blue text-white text-sm font-bold p-2" role="alert">
                        <p>No blogposts found…</p>
                    </div>
                </div>
            </div>
            <img class="pt-2" src="/images/algolia.svg"/>
        </div>
    </div>
</template>

<script>
    import algoliasearch from 'algoliasearch';

    export default {
        props: ['appId', 'apiKey', 'indexName'],


        data() {
            return {
                query: '',
                index: null,
                hits: [],
            };
        },

        created: function () {
            const client = algoliasearch(this.appId, this.apiKey);

            this.index = client.initIndex(this.indexName);
        },

        methods: {
            performSearch(event) {
                this.index.search({query: this.query}, (error, results) => {
                    console.log()
                    this.hits = results.hits;
                });
            }
        }
    }
</script>
