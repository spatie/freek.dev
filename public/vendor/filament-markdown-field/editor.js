window.CodeMirror = require('codemirror/lib/codemirror');

require('codemirror/addon/mode/overlay');
require('codemirror/addon/edit/continuelist');
require('codemirror/addon/display/placeholder');
require('codemirror/addon/selection/mark-selection');
require('codemirror/addon/search/searchcursor');

require('codemirror/mode/clike/clike');
require('codemirror/mode/cmake/cmake');
require('codemirror/mode/css/css');
require('codemirror/mode/diff/diff');
require('codemirror/mode/django/django');
require('codemirror/mode/dockerfile/dockerfile');
require('codemirror/mode/gfm/gfm');
require('codemirror/mode/go/go');
require('codemirror/mode/htmlmixed/htmlmixed');
require('codemirror/mode/http/http');
require('codemirror/mode/javascript/javascript');
require('codemirror/mode/jinja2/jinja2');
require('codemirror/mode/jsx/jsx');
require('codemirror/mode/markdown/markdown');
require('codemirror/mode/nginx/nginx');
require('codemirror/mode/pascal/pascal');
require('codemirror/mode/perl/perl');
require('codemirror/mode/php/php');
require('codemirror/mode/protobuf/protobuf');
require('codemirror/mode/python/python');
require('codemirror/mode/ruby/ruby');
require('codemirror/mode/rust/rust');
require('codemirror/mode/sass/sass');
require('codemirror/mode/shell/shell');
require('codemirror/mode/sql/sql');
require('codemirror/mode/stylus/stylus');
require('codemirror/mode/swift/swift');
require('codemirror/mode/vue/vue');
require('codemirror/mode/xml/xml');
require('codemirror/mode/yaml/yaml');

require('./EasyMDE.js');

CodeMirror.commands.tabAndIndentMarkdownList = function (cm) {
    var ranges = cm.listSelections();
    var pos = ranges[0].head;
    var eolState = cm.getStateAfter(pos.line);
    var inList = eolState.list !== false;

    if (inList) {
        cm.execCommand('indentMore');
        return;
    }

    if (cm.options.indentWithTabs) {
        cm.execCommand('insertTab');
    } else {
        var spaces = Array(cm.options.tabSize + 1).join(' ');
        cm.replaceSelection(spaces);
    }
};

CodeMirror.commands.shiftTabAndUnindentMarkdownList = function (cm) {
    var ranges = cm.listSelections();
    var pos = ranges[0].head;
    var eolState = cm.getStateAfter(pos.line);
    var inList = eolState.list !== false;

    if (inList) {
        cm.execCommand('indentLess');
        return;
    }

    if (cm.options.indentWithTabs) {
        cm.execCommand('insertTab');
    } else {
        var spaces = Array(cm.options.tabSize + 1).join(' ');
        cm.replaceSelection(spaces);
    }
};
