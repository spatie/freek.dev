import { useRef, useEffect } from 'preact/hooks';

export default function useAutofocus() {
    const inputRef = useRef();

    useEffect(() => {
        if (inputRef.current) {
            inputRef.current.focus();
        }
    }, []);

    return inputRef;
}
