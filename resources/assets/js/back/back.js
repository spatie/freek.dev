import SimpleMDE from 'simplemde';

new SimpleMDE({
    element: document.getElementsByClassName('markdown-editor'),
    spellChecker: false,
    autosave: {
        enabled: true,
        uniqueId: window.location,
    },
});