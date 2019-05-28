import algoliasearch from 'algoliasearch';
import { useState, useEffect } from 'react';

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

    return [query, setQuery, hits];
}
