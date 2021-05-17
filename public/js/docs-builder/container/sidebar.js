var _slicedToArray = function () { function sliceIterator(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"]) _i["return"](); } finally { if (_d) throw _e; } } return _arr; } return function (arr, i) { if (Array.isArray(arr)) { return arr; } else if (Symbol.iterator in Object(arr)) { return sliceIterator(arr, i); } else { throw new TypeError("Invalid attempt to destructure non-iterable instance"); } }; }();

import Api from '../api/api.js';
import useDebounce from '../hooks/useDebounce.js';

var queryString = window.location.search;
var urlParams = new URLSearchParams(queryString);

var api = new Api();
var topicId = urlParams.get('topic_id');

export default function Sidebar(props) {
    var _React$useState = React.useState(props.initialTopicName),
        _React$useState2 = _slicedToArray(_React$useState, 2),
        topicName = _React$useState2[0],
        setTopicName = _React$useState2[1];

    var debouncedData = useDebounce(topicName, 1000);

    React.useEffect(function () {
        if (debouncedData) {
            saveChangeToDB();
        }
    }, [debouncedData]);

    var handleTopicChange = function handleTopicChange(e) {
        setTopicName(e.target.value);
    };

    var saveChangeToDB = function saveChangeToDB() {
        api.updateTopic(topicId, topicName).then(function (res) {
            if (res.status) {
                document.title = 'Docs Builder - ' + topicName;
            }
        });
    };

    return React.createElement(
        'nav',
        { id: 'sidebar', className: 'sidebar-wrapper' },
        React.createElement(
            'div',
            { className: 'sidebar-content' },
            React.createElement(
                'div',
                { className: 'sidebar-item sidebar-brand font-weight-bold', style: { backgroundColor: '#F9F9F9' } },
                React.createElement('input', { type: 'text', name: 'name', onChange: handleTopicChange, value: topicName, className: 'form-control underline-input-title', placeholder: 'Topic name' })
            ),
            React.createElement(
                'div',
                { className: ' sidebar-item sidebar-menu', style: { paddingTop: '40px' } },
                React.createElement(
                    'ul',
                    { className: 'sidebar-ul' },
                    props.children
                )
            )
        )
    );
}