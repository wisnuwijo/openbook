export default function Li(props) {

    return React.createElement(
        'li',
        { className: "sidebar-dropdown " + (props.active ? 'active' : '') },
        props.children
    );
}