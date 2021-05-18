import Version from "../component/version.js";
import Api from "../api/api.js";

const mainUrl = localStorage.getItem('main-url');

export default function Content(props) {

    const [breadcrumbData, setBreadcrumbData] = React.useState([]);
    const [deleteConfirmationShow, setDeleteConfirmationShow] = React.useState(false);
    const [deleteConfirmationElement, setDeleteConfirmationElement] = React.useState('');
    
    const api = new Api();
    const confirmStyle = {
        width: '100%',
        height: 'auto',
        padding: '20px',
        color: 'white',
        backgroundColor: '#17a2b8'
    };

    const handleChange = (id, index, e) => {
        let copyBreadcrumb = [...breadcrumbData];
        copyBreadcrumb[index].name = e.target.value;

        api
            .updateBreadcrumb(id, e.target.value)
            .then(res => props.onBreadcrumbChange());
            
        setBreadcrumbData(copyBreadcrumb);
    }

    const cancelDelete = () => {
        setDeleteConfirmationElement('');
        setDeleteConfirmationShow(false);
    }

    const deleteBreadcrumb = (id, name) => {
        api
            .deleteBreadcrumb(id)
            .then(res => {
                const successMsg = <div>
                    <h6>{name} has been deleted successfully</h6>
                </div>;

                props.onBreadcrumbChange();
                generateInlineBreadcrumb();

                setDeleteConfirmationElement(successMsg);
                setTimeout(() => cancelDelete(), 3000);
            })
            .catch(err => {
                const errMsg = <div>
                    <h6>Oops, something went wrong</h6>
                </div>;

                setDeleteConfirmationElement(errMsg);
                setTimeout(() => cancelDelete(), 3000);
            })
    }

    const showDeleteConfirmation = (id, name) => {
        if (!deleteConfirmationShow) setDeleteConfirmationShow(true);

        const element = <div>
                <h6>Watch out! You are going to delete {name}. Once data deleted, it can't be restored</h6>
                <table>
                    <tbody>
                        <tr>
                            <td>
                                <button className="btn btn-sm btn-danger" onClick={() => deleteBreadcrumb(id, name)}>Delete</button>
                            </td>
                            <td style={{ paddingLeft: '10px' }}>
                                <button className="btn btn-sm btn-light" onClick={cancelDelete}>Cancel</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        ;

        setDeleteConfirmationElement(element);
    }

    const generateInlineBreadcrumb = () => {
        api
            .getBreadcrumb(props.activePageId)
            .then(
                res => setBreadcrumbData(res.breadcrumb)
            );
    }

    React.useEffect(() => {
        generateInlineBreadcrumb();
    }, [props.activePageId])
    
    return (
        <main className="page-content">
            <div style={deleteConfirmationShow ? confirmStyle : {display: 'none'}}>
                {deleteConfirmationElement}
            </div>
            <div className="container-fluid">
                <div className="row d-flex align-items-center p-3 border-bottom">
                    <div className="col-md-1">
                        <a id="toggle-sidebar" className="btn rounded-0 p-3" href="#"> <i className="fas fa-bars"></i> </a>
                    </div>
                    <div className="col-md-8">
                        <nav aria-label="breadcrumb" className="align-items-center">
                            <ol className="breadcrumb d-none d-lg-inline-flex m-0 docs-breadcrumb">
                                {
                                    breadcrumbData !== undefined ? breadcrumbData.map(i => <li key={i.id} className="breadcrumb-item active">
                                        <button className="btn btn-xs btn-danger breadcrumb-delete-btn" onClick={() => showDeleteConfirmation(i.id, i.name)}>-</button>
                                        <input type="text" onChange={(e) => handleChange(i.id, breadcrumbData.indexOf(i), e)} name="name" className="breadcrumb-input-text" value={breadcrumbData[breadcrumbData.indexOf(i)].name} required="" />
                                    </li>) : []
                                }
                            </ol>
                        </nav>
                    </div>
                    <div className="col-md-3 text-left">
                        <Version onVersionChange={props.onVersionChange} versions={props.versions} />
                    </div>
                </div>
                <div className="row p-lg-4">
                    <article className="main-content col-md-9 pr-lg-5">
                        <div id="editorjs"></div>
                    </article>
                    <aside className="col-md-3 d-none d-md-block border-left">
                        <b>Navigation</b>

                        <ul>
                            <li>
                                <a href={mainUrl} className="btn" style={{ fontSize: '11pt', color:'#8e8e8e' }}>Back to main page</a>
                            </li>
                        </ul>
                    </aside>
                </div>
            </div>
        </main>
    )
}