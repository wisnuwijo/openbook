export default function Sidebar(props) {

    return (
        <nav id="sidebar" className="sidebar-wrapper">
            <div className="sidebar-content">
                <div className="sidebar-item sidebar-brand font-weight-bold" style={{ backgroundColor: '#F9F9F9' }}>Firecek</div>
                <div className=" sidebar-item sidebar-menu" style={{ paddingTop: '40px' }}>
                    <ul className="sidebar-ul">
                        {props.children}
                    </ul>
                </div>
            </div>
        </nav>
    );
}