export default function Sidebar(props) {

    return React.createElement(
        "nav",
        { id: "sidebar", className: "sidebar-wrapper" },
        React.createElement(
            "div",
            { className: "sidebar-content" },
            React.createElement(
                "div",
                { className: "sidebar-item sidebar-brand font-weight-bold", style: { backgroundColor: '#F9F9F9' } },
                "Firecek"
            ),
            React.createElement(
                "div",
                { className: " sidebar-item sidebar-menu", style: { paddingTop: '40px' } },
                React.createElement(
                    "ul",
                    { className: "sidebar-ul" },
                    props.children
                )
            )
        )
    );
}