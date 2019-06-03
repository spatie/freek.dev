import React, { Component } from 'preact-compat';
import Downshift from 'downshift';
import SearchIndex from './SearchIndex';

export default class Search extends Component {
    componentDidMount() {
        document.querySelector('input[type=search]').focus();
    }

    render() {
        return (
            <SearchIndex appId={this.props.appId} apiKey={this.props.apiKey} indexName={this.props.indexName}>
                {({ hits, query, setQuery }) => (
                    <Downshift isOpen={true} onChange={item => item && (window.location = item.url)}>
                        {({ getInputProps, getItemProps, getMenuProps, highlightedIndex }) => (
                            <div>
                                <input
                                    type="search"
                                    className={`${this.props.inputClassName} mb-2`}
                                    placeholder="Laravel, PHP, JavaScript,…"
                                    {...getInputProps()}
                                    value={query}
                                    onChange={e => setQuery(e.target.value)}
                                />
                                <ul {...getMenuProps()}>
                                    {hits.map((item, index) => (
                                        <li
                                            {...getItemProps({
                                                key: item.url,
                                                index,
                                                item,
                                                className: `p-2 cursor-pointer border-4 ${
                                                    highlightedIndex === index
                                                        ? 'border-yellow-400'
                                                        : 'border-transparent'
                                                }`,
                                            })}
                                        >
                                            <strong className="text-lg">
                                                <a href={item.url}>{item.title}</a>
                                            </strong>
                                            <br />
                                            <a href={item.url} className="text-sm text-gray-500">
                                                {item.emoji} {item.publish_action || 'Published'}{' '}
                                                {item.formatted_publish_date}
                                            </a>
                                        </li>
                                    ))}
                                </ul>
                                {hits.length === 0 && query && <p className="mt-2 text-gray-500">Nothing here…</p>}
                            </div>
                        )}
                    </Downshift>
                )}
            </SearchIndex>
        );
    }
}
