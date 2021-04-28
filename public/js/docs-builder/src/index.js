import Sidebar from "./container/sidebar.js";
import Li from "./component/li.js";
import LiForm from "./component/liForm.js";
import Content from "./container/content.js";
import Api from "./api/api.js";

const token = localStorage.getItem('_token');
const api = new Api();

class Index extends React.Component {

    state = {
        activeTopicId: 0,
        activeVersionId: 0,
        activePageId: 0,
        activeBreakdownId: 0,
        versions: [],
        breakdownData: [],
        breakdownElement: []
    }

    componentDidMount() {
        this.getBreakdownDataAndGenerateElement();
    }

    getTopicIdFromUrl = () => {
        const url = window.location.href;
        const urlString = new URL(url);
        const topicId = urlString.searchParams.get("topic_id");

        return topicId;
    }

    getVersionIdFromUrl = () => {
        const url = window.location.href;
        const urlString = new URL(url);
        const versionId = urlString.searchParams.get("version_id");

        return versionId;
    }

    updateVersionUrlParam = (versionId) => {
        var queryParams = new URLSearchParams(window.location.search);
        queryParams.set("version_id", versionId);
        history.replaceState(null, null, "?" + queryParams.toString());
    }

    getBreakdownDataAndGenerateElement = () => {
        const topicId = this.getTopicIdFromUrl();
        const versionId = this.getVersionIdFromUrl();

        api.getVersion(topicId)
            .then(res => api.getBreakdown(versionId, topicId)
                .then(response => {
                    const versions = [
                        ...res.data.versions,
                        {
                            id: 'add',
                            name: '+ Add new'
                        }
                    ];

                    this.setState({
                        ...this.state,
                        activeTopicId: topicId,
                        activeVersionId: versionId,
                        versions: versions,
                        breakdownData: response.data.breakdown
                    }, function () {
                        this.generateBreakdown();
                    })
                }
                )
            );
    }

    dropdownChildOnclickHandler = (id) => {
        this.setState({
            ...this.state,
            activePageId: id
        }, function () {
            this.generateBreakdown();
        })
    }

    generateBreakdown = (prevActiveBreakdownId = 0) => {
        let el = [];
        let currActiveBreakdown = 0;
        for (let i = 0; i < this.state.breakdownData.length; i++) {
            const element = this.state.breakdownData[i];
            const isParent = element.parent_id === null || element.parent_id === 'null';
            const isParentActive = this.state.activeBreakdownId !== prevActiveBreakdownId
                ? element.id === this.state.activeBreakdownId
                : false;
                
            const isCurrentActiveBreakdownDifferentFromPrevious = this.state.activeBreakdownId === prevActiveBreakdownId;
            const isCurrentActiveBreakdownMatchedWithEl = element.id === this.state.activeBreakdownId;
            if (!isCurrentActiveBreakdownDifferentFromPrevious && isCurrentActiveBreakdownMatchedWithEl) {
                currActiveBreakdown = element.id;
            } else if (this.state.activeBreakdownId === prevActiveBreakdownId) {
                if (this.state.activeBreakdownId === 0) {
                    currActiveBreakdown = element.id;
                } else {
                    currActiveBreakdown = 0;
                }
            }
                
            const newElement = <Li key={element.id} active={isParentActive} isParent={isParent}>
                <a href={"#" + element.id + '-' + element.children.length} onClick={() => this.dropdownOnclickHandler(element.id)}><span className="menu-text"> {element.name} </span></a>
                <div className="sidebar-submenu" style={{ display: isParentActive ? 'block' : 'none' }}>
                    <ul>
                        {
                            element.children.map(each => <Li key={element.id + "-" + each.id} active={false}>
                                <a href={"#" + each.id + '-' + 0} onClick={() => this.dropdownChildOnclickHandler(each.id)} style={{ fontWeight: (this.state.activePageId === each.id ? 'bold' : 'normal') }}><span className="menu-text"> {each.name} </span></a>
                                </Li>
                            )
                        }
                        <LiForm onSubmit={this.handleAddHeadingSubmit} token={token} topicId={this.state.activeTopicId} versionId={this.state.activeVersionId} parentId={element.id} />
                    </ul>
                </div>
            </Li>;

            el.push(newElement);
        }
        
        el.push(<LiForm onSubmit={this.handleAddHeadingSubmit} key="main-heading-add-form" token={token} topicId={this.state.activeTopicId} versionId={this.state.activeVersionId} parentId='' />);

        this.setState({
            ...this.state,
            activeBreakdownId: currActiveBreakdown,
            breakdownElement: el
        })
    }

    handleAddHeadingSubmit = (formData) => {
        event.preventDefault();

        api.saveDocBreakdown(formData)
            .then(res => {
                if (res.status) {
                    // reload breakdown
                    this.getBreakdownDataAndGenerateElement();
                }
            });
    }

    handleVersionChange = (versionId) => {
        this.setState({
            ...this.state,
            activeVersionId: versionId
        }, function() {
            this.updateVersionUrlParam(versionId);
            this.getBreakdownDataAndGenerateElement();
        });
    }

    dropdownOnclickHandler = (breakdownId) => {
        const prevActiveBreakdownId = this.state.activeBreakdownId;

        this.setState({
            ...this.state,
            activePageId: breakdownId,
            activeBreakdownId: breakdownId
        }, function () {
            this.generateBreakdown(prevActiveBreakdownId);
        })
    }

    componentDidUpdate() {}

    render() {        
        return <div className="page-wrapper toggled light-theme">
            <Sidebar children={this.state.breakdownElement} />
            <Content onVersionChange={this.handleVersionChange} onBreadcrumbChange={this.getBreakdownDataAndGenerateElement} versions={this.state.versions} activePageId={this.state.activePageId} />
        </div>
    }
}

ReactDOM.render(React.createElement(Index), document.querySelector('#docs-builder'));