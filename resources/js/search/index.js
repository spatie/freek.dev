import React from 'react';
import { render } from 'react-dom';
import Downshift from 'downshift';
import useAutofocus from './useAutofocus';
import useSearchIndex from './useSearchIndex';

function Search({ appId, apiKey, indexName, inputClassName }) {
    const [query, setQuery, items] = useSearchIndex({ appId, apiKey, indexName });

    const autoFocusProps = useAutofocus();

    function navigate(item) {
        if (!item) {
            return;
        }

        window.location = item.url;
    }

    return (
        <Downshift isOpen={true} onChange={navigate}>
            {({ getInputProps, getItemProps, getMenuProps, highlightedIndex }) => (
                <div>
                    <input
                        type="search"
                        className={`${inputClassName} mb-4`}
                        placeholder="Laravel, PHP, JavaScript,…"
                        {...autoFocusProps}
                        {...getInputProps()}
                        value={query}
                        onChange={e => setQuery(e.target.value)}
                    />
                    <ul {...getMenuProps()}>
                        {items.map((item, index) => (
                            <li
                                {...getItemProps({
                                    key: item.url,
                                    index,
                                    item,
                                    className: `p-2 cursor-pointer ${
                                        highlightedIndex === index ? 'bg-indigo-100' : ''
                                    }`,
                                })}
                            >
                                <strong>
                                    <a href={item.url}>{item.title}</a>
                                </strong>
                                <br />
                                <a href={item.url} className="text-xs text-gray-500">
                                    {item.url}
                                </a>
                            </li>
                        ))}
                    </ul>
                    {items.length === 0 && query && <p className="mt-2 text-gray-500">Nothing here…</p>}
                </div>
            )}
        </Downshift>
    );
}

export function mount(container) {
    const inputClassName = container.querySelector('input').className;

    render(<Search inputClassName={inputClassName} {...container.dataset} />, container);
}
