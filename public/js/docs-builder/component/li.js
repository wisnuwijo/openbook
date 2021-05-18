export default function Li(props) {

    return React.createElement(
        'li',
        { className: (props.isParent ? "sidebar-dropdown " : '') + (props.active ? 'active' : '') },
        props.children
    );
}