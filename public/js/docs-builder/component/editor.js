var _slicedToArray = function () { function sliceIterator(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"]) _i["return"](); } finally { if (_d) throw _e; } } return _arr; } return function (arr, i) { if (Array.isArray(arr)) { return arr; } else if (Symbol.iterator in Object(arr)) { return sliceIterator(arr, i); } else { throw new TypeError("Invalid attempt to destructure non-iterable instance"); } }; }();

import 'https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest';
import 'https://cdn.jsdelivr.net/npm/@editorjs/header@latest';
import 'https://cdn.jsdelivr.net/npm/@editorjs/simple-image@latest';
import 'https://cdn.jsdelivr.net/npm/@editorjs/code@2.7.0/dist/bundle.min.js';
import 'https://cdn.jsdelivr.net/npm/@editorjs/warning@latest';
import 'https://cdn.jsdelivr.net/npm/@editorjs/list@latest';
import 'https://cdn.jsdelivr.net/npm/@editorjs/table@latest';
import 'https://cdn.jsdelivr.net/npm/@editorjs/raw';
import EditorHelper from "../api/editorHelper.js";

var editorHelper = new EditorHelper();

export default function Editor(props) {
    var _React$useState = React.useState(0),
        _React$useState2 = _slicedToArray(_React$useState, 2),
        activePageId = _React$useState2[0],
        setActivePageId = _React$useState2[1];

    var _React$useState3 = React.useState({}),
        _React$useState4 = _slicedToArray(_React$useState3, 2),
        editorData = _React$useState4[0],
        setEditorData = _React$useState4[1];

    var _React$useState5 = React.useState(),
        _React$useState6 = _slicedToArray(_React$useState5, 2),
        editor = _React$useState6[0],
        setEditor = _React$useState6[1];

    var newEditor = void 0;

    var handleEditorChange = React.useCallback(function (editor) {
        editorHelper.save(editor, props.activePageId);
    }, [activePageId]);

    React.useEffect(function () {
        if (newEditor === undefined) {
            newEditor = new EditorJS({
                holder: 'editorjs',
                placeholder: 'Let\'s write an awesome documentation!',
                autofocus: true,
                tools: {
                    image: SimpleImage,
                    code: CodeTool,
                    warning: Warning,
                    raw: RawTool,
                    table: {
                        class: Table
                    },
                    header: {
                        class: Header,
                        inlineToolbar: true
                    },
                    list: List
                },
                // data: editorData,
                data: {},
                onChange: function onChange() {
                    console.log('props.activePageId', props.activePageId);
                    newEditor.save().then(function (outputData) {
                        console.log('outputData', outputData);
                        editorHelper.saveToDB(outputData, props.activePageId);
                    });
                }
            });
        }
    });

    React.useEffect(function () {
        editorHelper.getData(props.activePageId).then(function (res) {
            var parsedContent = {};
            try {
                parsedContent = JSON.parse(res.data.data.content);
            } catch (error) {
                console.log('error', error);
            }

            newEditor.isReady.then(function () {
                // console.log('editor', newEditor);
                newEditor.render(parsedContent);
            }).catch(function (reason) {
                console.log('Editor.js initialization failed because of ' + reason);
            });

            setEditorData(parsedContent);
        });

        setActivePageId(props.activePageId);
    }, [props.activePageId]);

    React.useEffect(function () {
        document.getElementById('editorjs').innerHTML = '';

        // newEditor.isReady
        //     .then(() => {
        //         console.log('editor ON', newEditor);
        //     })
        //     .catch((reason) => {
        //         console.log(`Editor.js initialization failed because of ${reason}`)
        //     });
    }, [editorData]);

    return React.createElement(
        'div',
        null,
        React.createElement('div', { id: 'editorjs' })
    );
}