var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

import Api from "../api/api.js";

var queryString = window.location.search;
var urlParams = new URLSearchParams(queryString);
var api = new Api();

var Version = function (_React$Component) {
    _inherits(Version, _React$Component);

    function Version(props) {
        _classCallCheck(this, Version);

        var _this = _possibleConstructorReturn(this, (Version.__proto__ || Object.getPrototypeOf(Version)).call(this, props));

        _this.state = {
            selectedOption: 0,
            activeTopicId: urlParams.get('topic_id'),
            newVersionName: '',
            showAddVersionForm: false
        };

        _this.getVersionIdFromUrl = function () {
            var url = window.location.href;
            var urlString = new URL(url);
            var versionId = urlString.searchParams.get("version_id");

            return versionId;
        };

        _this.onChangeHandler = function (e) {
            if (e.target.value !== 'add') {
                _this.setState(Object.assign({}, _this.state, {
                    selectedOption: e.target.value
                }), function () {
                    this.props.onVersionChange(this.state.selectedOption);
                });
            } else {
                _this.setState(Object.assign({}, _this.state, {
                    showAddVersionForm: true
                }));
            }
        };

        _this.handleAddVersionSubmit = function (e) {
            e.preventDefault();

            api.addVersion(_this.state.activeTopicId, _this.state.newVersionName).then(function (res) {
                return _this.setState(Object.assign({}, _this.state, {
                    showAddVersionForm: false,
                    selectedOption: res.data.data.id
                }), function () {
                    this.props.onVersionChange(this.state.selectedOption);
                });
            });
        };

        _this.onChangeHandler = _this.onChangeHandler.bind(_this);
        return _this;
    }

    _createClass(Version, [{
        key: 'componentDidMount',
        value: function componentDidMount() {
            this.setState(Object.assign({}, this.state, {
                selectedOption: this.getVersionIdFromUrl()
            }));
        }
    }, {
        key: 'render',
        value: function render() {
            var _this2 = this;

            if (this.state.showAddVersionForm) {
                return React.createElement(
                    'form',
                    { method: 'post', onSubmit: this.handleAddVersionSubmit },
                    React.createElement(
                        'table',
                        null,
                        React.createElement(
                            'tbody',
                            null,
                            React.createElement(
                                'tr',
                                null,
                                React.createElement(
                                    'td',
                                    null,
                                    React.createElement('input', { type: 'text', onChange: function onChange(e) {
                                            return _this2.setState(Object.assign({}, _this2.state, {
                                                newVersionName: e.target.value
                                            }));
                                        }, className: 'form-control underline-input', value: this.state.newVersionName, placeholder: 'Add New Version', required: true })
                                ),
                                React.createElement(
                                    'td',
                                    null,
                                    React.createElement(
                                        'button',
                                        { className: 'check-btn', type: 'submit' },
                                        React.createElement('i', { className: 'fa fa-check' })
                                    )
                                )
                            )
                        )
                    )
                );
            }

            return React.createElement(
                'table',
                null,
                React.createElement(
                    'tbody',
                    null,
                    React.createElement(
                        'tr',
                        null,
                        React.createElement(
                            'td',
                            { width: '50px' },
                            'Version'
                        ),
                        React.createElement(
                            'td',
                            null,
                            React.createElement(
                                'select',
                                { className: 'form-control input-underline', onChange: this.onChangeHandler, value: this.state.selectedOption },
                                this.props.versions.map(function (i) {
                                    return React.createElement(
                                        'option',
                                        { key: i.id, value: i.id },
                                        i.name
                                    );
                                })
                            )
                        )
                    )
                )
            );
        }
    }]);

    return Version;
}(React.Component);

export default Version;