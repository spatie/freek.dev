import { render } from 'preact';
import useAutofocus from './useAutofocus';
import useSearchIndex from './useSearchIndex';

function Search({ appId, apiKey, indexName }) {
    const [query, setQuery, hits] = useSearchIndex({ appId, apiKey, indexName });

    const autoFocusProps = useAutofocus();

    const searchInput = (
        <input
            type="search"
            className="bg-gray-200 rounded px-3 py-2 w-full focus:outline-none border-gray-300 focus:border-gray-400 border-y-2 border-t-transparent"
            placeholder="Search"
            value={query}
            onInput={e => setQuery(e.target.value)}
            {...autoFocusProps}
        />
    );

    if (!query) {
        return <div>{searchInput}</div>;
    }

    return (
        <div className="search">
            {searchInput}
            {hits.length ? (
                <ul>
                    {hits.map((hit, i) => (
                        <li key={i} className="mt-6 leading-tight">
                            <a
                                href={hit.url}
                                dangerouslySetInnerHTML={{
                                    __html: hit._highlightResult.title.value,
                                }}
                            />
                            <br />
                            <a href={hit.url} className="text-xs text-gray-500">
                                {hit.url}
                            </a>
                        </li>
                    ))}
                </ul>
            ) : (
                <p className="mt-6 text-gray-500">Nothing here…</p>
            )}
        </div>
    );
}

export function mount(container) {
    container.innerHTML = '';

    render(<Search {...container.dataset} />, container);
}
