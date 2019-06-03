import { Component } from 'preact';
import algoliasearch from 'algoliasearch';

export default class SearchIndex extends Component {
    constructor(props) {
        super(props);

        this.state = {
            query: '',
            hits: [],
        };

        this.searchIndex = algoliasearch(props.appId, props.apiKey).initIndex(props.indexName);
    }

    componentDidUpdate() {
        if (!this.state.query) {
            if (this.state.hits.length) {
                this.setState(state => ({ ...state, hits: [] }));
            }

            return;
        }

        this.searchIndex.search({ query: this.state.query }, (_error, results) => {
            this.setState(state => ({ ...state, hits: results.hits }));
        });
    }

    render() {
        return this.props.children[0]({
            hits: this.state.hits,
            query: this.state.query,
            setQuery: query => {
                this.setState(state => ({ ...state, query }));
            },
        });
    }
}
