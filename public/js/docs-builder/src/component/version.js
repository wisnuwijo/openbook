import Api from "../api/api.js";

var queryString = window.location.search;
var urlParams = new URLSearchParams(queryString);
const api = new Api();

export default class Version extends React.Component {
    state = {
        selectedOption: 0,
        activeTopicId: urlParams.get('topic_id'),
        newVersionName: '',
        showAddVersionForm: false
    }

    constructor(props) {
        super(props);

        this.onChangeHandler = this.onChangeHandler.bind(this);
    }

    getVersionIdFromUrl = () => {
        const url = window.location.href;
        const urlString = new URL(url);
        const versionId = urlString.searchParams.get("version_id");

        return versionId;
    }

    componentDidMount() {
        this.setState({
            ...this.state,
            selectedOption: this.getVersionIdFromUrl()
        })
    }

    onChangeHandler = (e) => {
        if (e.target.value !== 'add') {
            this.setState({
                ...this.state,
                selectedOption: e.target.value
            }, function () {
                this.props.onVersionChange(this.state.selectedOption);
            });
        } else {
            this.setState({
                ...this.state,
                showAddVersionForm: true
            });
        }
    }

    handleAddVersionSubmit = (e) => {
        e.preventDefault();
        
        api
            .addVersion(this.state.activeTopicId, this.state.newVersionName)
            .then(res => this.setState({
                ...this.state,
                showAddVersionForm: false,
                selectedOption: res.data.data.id
            }, function () {
                this.props.onVersionChange(this.state.selectedOption);
            }));
    }
    
    render() {
        if (this.state.showAddVersionForm) {
            return <form method="post" onSubmit={this.handleAddVersionSubmit}>
                <table>
                    <tbody>
                        <tr>
                            <td>
                                <input type="text" onChange={(e) => this.setState({
                                    ...this.state,
                                    newVersionName: e.target.value
                                })} className="form-control underline-input" value={this.state.newVersionName} placeholder="Add New Version" required />
                            </td>
                            <td>
                                <button className="check-btn" type="submit"><i className="fa fa-check"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>;
        }

        return (
            <table>
                <tbody>
                    <tr>
                        <td width="50px">Version</td>
                        <td>
                            <select className="form-control input-underline" onChange={this.onChangeHandler} value={this.state.selectedOption}>
                                {this.props.versions.map(i => <option key={i.id} value={i.id}>{i.name}</option>) }
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
        )
    }
}