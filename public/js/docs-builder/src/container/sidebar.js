import Api from '../api/api.js';
import useDebounce from '../hooks/useDebounce.js';

var queryString = window.location.search;
var urlParams = new URLSearchParams(queryString);

const api = new Api();
const topicId = urlParams.get('topic_id');

export default function Sidebar(props) {

    const [topicName, setTopicName] = React.useState(props.initialTopicName);
    const debouncedData = useDebounce(topicName, 1000);

    React.useEffect(() => {
        if (debouncedData) {
            saveChangeToDB();
        }
    }, [debouncedData])

    const handleTopicChange = (e) => {
        setTopicName(e.target.value);
    }

    const saveChangeToDB = () => {
        api
            .updateTopic(topicId, topicName)
            .then(res => {
                if (res.status) {
                    document.title = 'Docs Builder - ' + topicName;
                }
            });
    }

    return (
        <nav id="sidebar" className="sidebar-wrapper">
            <div className="sidebar-content">
                <div className="sidebar-item sidebar-brand font-weight-bold" style={{ backgroundColor: '#F9F9F9' }}>
                    <input type="text" name="name" onChange={handleTopicChange} value={topicName} className="form-control underline-input-title" placeholder="Topic name" />
                </div>
                <div className=" sidebar-item sidebar-menu" style={{ paddingTop: '40px' }}>
                    <ul className="sidebar-ul">
                        {props.children}
                    </ul>
                </div>
            </div>
        </nav>
    );
}