import { useRef, useEffect } from 'preact/hooks';

export default function useAutofocus() {
    const inputRef = useRef();

    useEffect(() => {
        if (inputRef.current) {
            const { scrollX, scrollY } = window;
            inputRef.current.focus();
            scrollTo(scrollX, scrollY);
        }
    }, []);

    return { ref: inputRef };
}
