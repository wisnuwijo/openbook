var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var LiForm = function (_React$Component) {
    _inherits(LiForm, _React$Component);

    function LiForm(props) {
        _classCallCheck(this, LiForm);

        var _this = _possibleConstructorReturn(this, (LiForm.__proto__ || Object.getPrototypeOf(LiForm)).call(this, props));

        _this.state = {
            name: '',
            topic_id: 0,
            version_id: 0,
            parent_id: null
        };


        _this.state = {
            name: '',
            topic_id: _this.props.topicId,
            version_id: _this.props.versionId,
            parent_id: _this.props.parentId
        };

        _this.handleTextFieldChange = _this.handleTextFieldChange.bind(_this);
        return _this;
    }

    // ES6 React.Component doesn't auto bind methods to itself. You need to bind them yourself in constructor
    // ref https://stackoverflow.com/questions/33973648/react-this-is-undefined-inside-a-component-function


    _createClass(LiForm, [{
        key: 'handleTextFieldChange',
        value: function handleTextFieldChange(event) {
            this.setState(Object.assign({}, this.state, {
                name: event.target.value
            }));
        }
    }, {
        key: 'render',
        value: function render() {
            var _this2 = this;

            return React.createElement(
                'li',
                null,
                React.createElement(
                    'form',
                    { method: 'post', onSubmit: function onSubmit() {
                            var prevState = Object.assign({}, _this2.state);
                            _this2.setState(Object.assign({}, _this2.state, {
                                name: ''
                            }), _this2.props.onSubmit(prevState));
                        } },
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
                                    React.createElement('input', { readOnly: true, type: 'hidden', name: '_token', value: this.props.token }),
                                    React.createElement('input', { readOnly: true, type: 'hidden', name: 'topic_id', value: this.props.topicId }),
                                    React.createElement('input', { readOnly: true, type: 'hidden', name: 'version_id', value: this.props.versionId }),
                                    React.createElement('input', { readOnly: true, type: 'hidden', name: 'parent_id', value: this.props.parentId }),
                                    React.createElement('input', { onChange: this.handleTextFieldChange, type: 'text', name: 'name', value: this.state.name, className: 'form-control underline-input', placeholder: 'Add New Heading', required: '' })
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
                )
            );
        }
    }]);

    return LiForm;
}(React.Component);

export default LiForm;