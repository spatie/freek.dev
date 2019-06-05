import React, { render } from 'preact-compat';
import Search from './Search';

export function mount(container) {
    const inputClassName = container.querySelector('input').className;

    render(<Search inputClassName={inputClassName} {...container.dataset} />, container);
}
