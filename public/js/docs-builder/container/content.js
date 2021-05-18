var _slicedToArray = function () { function sliceIterator(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"]) _i["return"](); } finally { if (_d) throw _e; } } return _arr; } return function (arr, i) { if (Array.isArray(arr)) { return arr; } else if (Symbol.iterator in Object(arr)) { return sliceIterator(arr, i); } else { throw new TypeError("Invalid attempt to destructure non-iterable instance"); } }; }();

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

import Version from "../component/version.js";
import Api from "../api/api.js";

var mainUrl = localStorage.getItem('main-url');

export default function Content(props) {
    var _React$useState = React.useState([]),
        _React$useState2 = _slicedToArray(_React$useState, 2),
        breadcrumbData = _React$useState2[0],
        setBreadcrumbData = _React$useState2[1];

    var _React$useState3 = React.useState(false),
        _React$useState4 = _slicedToArray(_React$useState3, 2),
        deleteConfirmationShow = _React$useState4[0],
        setDeleteConfirmationShow = _React$useState4[1];

    var _React$useState5 = React.useState(''),
        _React$useState6 = _slicedToArray(_React$useState5, 2),
        deleteConfirmationElement = _React$useState6[0],
        setDeleteConfirmationElement = _React$useState6[1];

    var api = new Api();
    var confirmStyle = {
        width: '100%',
        height: 'auto',
        padding: '20px',
        color: 'white',
        backgroundColor: '#17a2b8'
    };

    var handleChange = function handleChange(id, index, e) {
        var copyBreadcrumb = [].concat(_toConsumableArray(breadcrumbData));
        copyBreadcrumb[index].name = e.target.value;

        api.updateBreadcrumb(id, e.target.value).then(function (res) {
            return props.onBreadcrumbChange();
        });

        setBreadcrumbData(copyBreadcrumb);
    };

    var cancelDelete = function cancelDelete() {
        setDeleteConfirmationElement('');
        setDeleteConfirmationShow(false);
    };

    var deleteBreadcrumb = function deleteBreadcrumb(id, name) {
        api.deleteBreadcrumb(id).then(function (res) {
            var successMsg = React.createElement(
                "div",
                null,
                React.createElement(
                    "h6",
                    null,
                    name,
                    " has been deleted successfully"
                )
            );

            props.onBreadcrumbChange();
            generateInlineBreadcrumb();

            setDeleteConfirmationElement(successMsg);
            setTimeout(function () {
                return cancelDelete();
            }, 3000);
        }).catch(function (err) {
            var errMsg = React.createElement(
                "div",
                null,
                React.createElement(
                    "h6",
                    null,
                    "Oops, something went wrong"
                )
            );

            setDeleteConfirmationElement(errMsg);
            setTimeout(function () {
                return cancelDelete();
            }, 3000);
        });
    };

    var showDeleteConfirmation = function showDeleteConfirmation(id, name) {
        if (!deleteConfirmationShow) setDeleteConfirmationShow(true);

        var element = React.createElement(
            "div",
            null,
            React.createElement(
                "h6",
                null,
                "Watch out! You are going to delete ",
                name,
                ". Once data deleted, it can't be restored"
            ),
            React.createElement(
                "table",
                null,
                React.createElement(
                    "tbody",
                    null,
                    React.createElement(
                        "tr",
                        null,
                        React.createElement(
                            "td",
                            null,
                            React.createElement(
                                "button",
                                { className: "btn btn-sm btn-danger", onClick: function onClick() {
                                        return deleteBreadcrumb(id, name);
                                    } },
                                "Delete"
                            )
                        ),
                        React.createElement(
                            "td",
                            { style: { paddingLeft: '10px' } },
                            React.createElement(
                                "button",
                                { className: "btn btn-sm btn-light", onClick: cancelDelete },
                                "Cancel"
                            )
                        )
                    )
                )
            )
        );

        setDeleteConfirmationElement(element);
    };

    var generateInlineBreadcrumb = function generateInlineBreadcrumb() {
        api.getBreadcrumb(props.activePageId).then(function (res) {
            return setBreadcrumbData(res.breadcrumb);
        });
    };

    React.useEffect(function () {
        generateInlineBreadcrumb();
    }, [props.activePageId]);

    return React.createElement(
        "main",
        { className: "page-content" },
        React.createElement(
            "div",
            { style: deleteConfirmationShow ? confirmStyle : { display: 'none' } },
            deleteConfirmationElement
        ),
        React.createElement(
            "div",
            { className: "container-fluid" },
            React.createElement(
                "div",
                { className: "row d-flex align-items-center p-3 border-bottom" },
                React.createElement(
                    "div",
                    { className: "col-md-1" },
                    React.createElement(
                        "a",
                        { id: "toggle-sidebar", className: "btn rounded-0 p-3", href: "#" },
                        " ",
                        React.createElement("i", { className: "fas fa-bars" }),
                        " "
                    )
                ),
                React.createElement(
                    "div",
                    { className: "col-md-8" },
                    React.createElement(
                        "nav",
                        { "aria-label": "breadcrumb", className: "align-items-center" },
                        React.createElement(
                            "ol",
                            { className: "breadcrumb d-none d-lg-inline-flex m-0 docs-breadcrumb" },
                            breadcrumbData !== undefined ? breadcrumbData.map(function (i) {
                                return React.createElement(
                                    "li",
                                    { key: i.id, className: "breadcrumb-item active" },
                                    React.createElement(
                                        "button",
                                        { className: "btn btn-xs btn-danger breadcrumb-delete-btn", onClick: function onClick() {
                                                return showDeleteConfirmation(i.id, i.name);
                                            } },
                                        "-"
                                    ),
                                    React.createElement("input", { type: "text", onChange: function onChange(e) {
                                            return handleChange(i.id, breadcrumbData.indexOf(i), e);
                                        }, name: "name", className: "breadcrumb-input-text", value: breadcrumbData[breadcrumbData.indexOf(i)].name, required: "" })
                                );
                            }) : []
                        )
                    )
                ),
                React.createElement(
                    "div",
                    { className: "col-md-3 text-left" },
                    React.createElement(Version, { onVersionChange: props.onVersionChange, versions: props.versions })
                )
            ),
            React.createElement(
                "div",
                { className: "row p-lg-4" },
                React.createElement(
                    "article",
                    { className: "main-content col-md-9 pr-lg-5" },
                    React.createElement("div", { id: "editorjs" })
                ),
                React.createElement(
                    "aside",
                    { className: "col-md-3 d-none d-md-block border-left" },
                    React.createElement(
                        "b",
                        null,
                        "Navigation"
                    ),
                    React.createElement(
                        "ul",
                        null,
                        React.createElement(
                            "li",
                            null,
                            React.createElement(
                                "a",
                                { href: mainUrl, className: "btn", style: { fontSize: '11pt', color: '#8e8e8e' } },
                                "Back to main page"
                            )
                        )
                    )
                )
            )
        )
    );
}