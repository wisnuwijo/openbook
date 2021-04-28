export default function Li(props) {

    return <li className={(props.isParent ? "sidebar-dropdown ": '') + (props.active ? 'active': '')}>{props.children}</li>
}