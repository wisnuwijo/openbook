var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

import Sidebar from "./container/sidebar.js";
import Li from "./component/li.js";
import LiForm from "./component/liForm.js";
import Content from "./container/content.js";
import Api from "./api/api.js";

var token = localStorage.getItem('_token');
var initialTopicName = localStorage.getItem('initial-topic-name');
var api = new Api();

var Index = function (_React$Component) {
    _inherits(Index, _React$Component);

    function Index() {
        var _ref;

        var _temp, _this, _ret;

        _classCallCheck(this, Index);

        for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
            args[_key] = arguments[_key];
        }

        return _ret = (_temp = (_this = _possibleConstructorReturn(this, (_ref = Index.__proto__ || Object.getPrototypeOf(Index)).call.apply(_ref, [this].concat(args))), _this), _this.state = {
            activeTopicId: 0,
            activeVersionId: 0,
            activePageId: 0,
            activeBreakdownId: 0,
            versions: [],
            breakdownData: [],
            breakdownElement: []
        }, _this.getTopicIdFromUrl = function () {
            var url = window.location.href;
            var urlString = new URL(url);
            var topicId = urlString.searchParams.get("topic_id");

            return topicId;
        }, _this.getVersionIdFromUrl = function () {
            var url = window.location.href;
            var urlString = new URL(url);
            var versionId = urlString.searchParams.get("version_id");

            return versionId;
        }, _this.updateVersionUrlParam = function (versionId) {
            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("version_id", versionId);
            history.replaceState(null, null, "?" + queryParams.toString());
        }, _this.getBreakdownDataAndGenerateElement = function () {
            var topicId = _this.getTopicIdFromUrl();
            var versionId = _this.getVersionIdFromUrl();

            api.getVersion(topicId).then(function (res) {
                return api.getBreakdown(versionId, topicId).then(function (response) {
                    var versions = [].concat(_toConsumableArray(res.data.versions), [{
                        id: 'add',
                        name: '+ Add new'
                    }]);

                    _this.setState(Object.assign({}, _this.state, {
                        activeTopicId: topicId,
                        activeVersionId: versionId,
                        versions: versions,
                        breakdownData: response.data.breakdown
                    }), function () {
                        this.generateBreakdown();
                    });
                });
            });
        }, _this.dropdownChildOnclickHandler = function (id) {
            _this.setState(Object.assign({}, _this.state, {
                activePageId: id
            }), function () {
                this.generateBreakdown();
            });
        }, _this.generateBreakdown = function () {
            var prevActiveBreakdownId = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;

            var el = [];
            var currActiveBreakdown = 0;

            var _loop = function _loop(i) {
                var element = _this.state.breakdownData[i];
                var isParent = element.parent_id === null || element.parent_id === 'null';
                var isParentActive = _this.state.activeBreakdownId !== prevActiveBreakdownId ? element.id === _this.state.activeBreakdownId : false;

                var isCurrentActiveBreakdownDifferentFromPrevious = _this.state.activeBreakdownId === prevActiveBreakdownId;
                var isCurrentActiveBreakdownMatchedWithEl = element.id === _this.state.activeBreakdownId;
                if (!isCurrentActiveBreakdownDifferentFromPrevious && isCurrentActiveBreakdownMatchedWithEl) {
                    currActiveBreakdown = element.id;
                } else if (_this.state.activeBreakdownId === prevActiveBreakdownId) {
                    if (_this.state.activeBreakdownId === 0) {
                        currActiveBreakdown = element.id;
                    } else {
                        currActiveBreakdown = 0;
                    }
                }

                var newElement = React.createElement(
                    Li,
                    { key: element.id, active: isParentActive, isParent: isParent },
                    React.createElement(
                        "a",
                        { href: "#" + element.id + '-' + element.children.length, onClick: function onClick() {
                                return _this.dropdownOnclickHandler(element.id);
                            } },
                        React.createElement(
                            "span",
                            { className: "menu-text" },
                            " ",
                            element.name,
                            " "
                        )
                    ),
                    React.createElement(
                        "div",
                        { className: "sidebar-submenu", style: { display: isParentActive ? 'block' : 'none' } },
                        React.createElement(
                            "ul",
                            null,
                            element.children.map(function (each) {
                                return React.createElement(
                                    Li,
                                    { key: element.id + "-" + each.id, active: false },
                                    React.createElement(
                                        "a",
                                        { href: "#" + each.id + '-' + 0, onClick: function onClick() {
                                                return _this.dropdownChildOnclickHandler(each.id);
                                            }, style: { fontWeight: _this.state.activePageId === each.id ? 'bold' : 'normal' } },
                                        React.createElement(
                                            "span",
                                            { className: "menu-text" },
                                            " ",
                                            each.name,
                                            " "
                                        )
                                    )
                                );
                            }),
                            React.createElement(LiForm, { onSubmit: _this.handleAddHeadingSubmit, token: token, topicId: _this.state.activeTopicId, versionId: _this.state.activeVersionId, parentId: element.id })
                        )
                    )
                );

                el.push(newElement);
            };

            for (var i = 0; i < _this.state.breakdownData.length; i++) {
                _loop(i);
            }

            el.push(React.createElement(LiForm, { onSubmit: _this.handleAddHeadingSubmit, key: "main-heading-add-form", token: token, topicId: _this.state.activeTopicId, versionId: _this.state.activeVersionId, parentId: "" }));

            _this.setState(Object.assign({}, _this.state, {
                activeBreakdownId: currActiveBreakdown,
                breakdownElement: el
            }));
        }, _this.handleAddHeadingSubmit = function (formData) {
            event.preventDefault();

            api.saveDocBreakdown(formData).then(function (res) {
                if (res.status) {
                    // reload breakdown
                    _this.getBreakdownDataAndGenerateElement();
                }
            });
        }, _this.handleVersionChange = function (versionId) {
            _this.setState(Object.assign({}, _this.state, {
                activeVersionId: versionId
            }), function () {
                this.updateVersionUrlParam(versionId);
                this.getBreakdownDataAndGenerateElement();
            });
        }, _this.dropdownOnclickHandler = function (breakdownId) {
            var prevActiveBreakdownId = _this.state.activeBreakdownId;

            _this.setState(Object.assign({}, _this.state, {
                activePageId: breakdownId,
                activeBreakdownId: breakdownId
            }), function () {
                this.generateBreakdown(prevActiveBreakdownId);
            });
        }, _temp), _possibleConstructorReturn(_this, _ret);
    }

    _createClass(Index, [{
        key: "componentDidMount",
        value: function componentDidMount() {
            this.getBreakdownDataAndGenerateElement();
        }
    }, {
        key: "componentDidUpdate",
        value: function componentDidUpdate() {}
    }, {
        key: "render",
        value: function render() {
            return React.createElement(
                "div",
                { className: "page-wrapper toggled light-theme" },
                React.createElement(Sidebar, { children: this.state.breakdownElement, initialTopicName: initialTopicName }),
                React.createElement(Content, { onVersionChange: this.handleVersionChange, onBreadcrumbChange: this.getBreakdownDataAndGenerateElement, versions: this.state.versions, activePageId: this.state.activePageId })
            );
        }
    }]);

    return Index;
}(React.Component);

ReactDOM.render(React.createElement(Index), document.querySelector('#docs-builder'));