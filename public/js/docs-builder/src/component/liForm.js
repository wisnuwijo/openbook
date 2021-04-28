export default class LiForm extends React.Component {
    state = {
        name: '',
        topic_id: 0,
        version_id: 0,
        parent_id: null
    }

    constructor(props) {
        super(props);

        this.state = {
            name: '',
            topic_id: this.props.topicId,
            version_id: this.props.versionId,
            parent_id: this.props.parentId
        };

        this.handleTextFieldChange = this.handleTextFieldChange.bind(this);
    }

    // ES6 React.Component doesn't auto bind methods to itself. You need to bind them yourself in constructor
    // ref https://stackoverflow.com/questions/33973648/react-this-is-undefined-inside-a-component-function
    handleTextFieldChange(event) {
        this.setState({
            ...this.state,
            name: event.target.value
        });
    }

    render() {
        return (
            <li>
                <form method="post" onSubmit={() => {
                    const prevState = {...this.state};
                    this.setState({
                        ...this.state,
                        name: ''
                    }, this.props.onSubmit(prevState))
                }}>
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <input readOnly type="hidden" name="_token" value={this.props.token} />
                                    <input readOnly type="hidden" name="topic_id" value={this.props.topicId} />
                                    <input readOnly type="hidden" name="version_id" value={this.props.versionId} />
                                    <input readOnly type="hidden" name="parent_id" value={this.props.parentId} />
                                    <input onChange={this.handleTextFieldChange} type="text" name="name" value={this.state.name} className="form-control underline-input" placeholder="Add New Heading" required="" />
                                </td>
                                <td>
                                    <button className="check-btn" type="submit"><i className="fa fa-check"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </li>
        )
    }
}