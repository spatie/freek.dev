import algoliasearch from 'algoliasearch';
import { useState, useEffect } from 'preact/hooks';

export default function useSearchIndex({ appId, apiKey, indexName }) {
    const [query, setQuery] = useState('');
    const [hits, setHits] = useState([]);

    const [searchIndex] = useState(() => {
        const client = algoliasearch(appId, apiKey);

        return client.initIndex(indexName);
    });

    useEffect(() => {
        if (!query) {
            if (hits.length) {
                setHits([]);
            }

            return;
        }

        searchIndex.search({ query }, (_error, results) => {
            setHits(results.hits);
        });
    }, [query, searchIndex]);

    console.log(hits);

    return [query, setQuery, hits];
}
