import SimpleMDE from 'simplemde';

let editors = document.getElementsByClassName('markdown-editor');

if (editors.length) {
    new SimpleMDE({
        element: editors[0],
        spellChecker: true,
        autosave: {
            enabled: true,
            uniqueId: window.location,
        },
    });
}
