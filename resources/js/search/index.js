import { render } from 'preact';
import useAutofocus from './useAutofocus';
import useSearchIndex from './useSearchIndex';

function SearchApp({ appId, apiKey, indexName }) {
    const [query, setQuery, hits] = useSearchIndex({ appId, apiKey, indexName });

    const autoFocusProps = useAutofocus();

    const searchInput = (
        <input
            type="search"
            className="border-b py-1 w-full focus:outline-none focus:border-gray-600"
            placeholder="Laravel, PHP, JavaScript, …"
            value={query}
            onInput={e => setQuery(e.target.value)}
            {...autoFocusProps}
        />
    );

    if (!query) {
        return <div>{searchInput}</div>;
    }

    return (
        <div>
            {searchInput}
            {hits.length ? (
                <ul>
                    {hits.map((hit, i) => (
                        <li key={i}>
                            <a
                                href={hit.url}
                                dangerouslySetInnerHTML={{
                                    __html: hit._highlightResult.title.value,
                                }}
                            />
                        </li>
                    ))}
                </ul>
            ) : (
                <p>Nothing found…</p>
            )}
        </div>
    );
}

export function mount(container) {
    container.innerHTML = '';

    render(<SearchApp {...container.dataset} />, container);
}
