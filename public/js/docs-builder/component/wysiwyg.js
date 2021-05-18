import Version from "./version.js";

export default function Content(props) {

    return React.createElement(
        "main",
        { className: "page-content" },
        React.createElement("div", { id: "overlay", className: "overlay" }),
        React.createElement(
            "div",
            { className: "container-fluid" },
            React.createElement(
                "div",
                { className: "row d-flex align-items-center p-3 border-bottom" },
                React.createElement(
                    "div",
                    { className: "col-md-1" },
                    React.createElement(
                        "a",
                        { id: "toggle-sidebar", className: "btn rounded-0 p-3", href: "#" },
                        " ",
                        React.createElement("i", { className: "fas fa-bars" }),
                        " "
                    )
                ),
                React.createElement(
                    "div",
                    { className: "col-md-8" },
                    React.createElement(
                        "nav",
                        { "aria-label": "breadcrumb", className: "align-items-center" },
                        React.createElement("a", { href: "index.html", className: "breadcrumb-back", title: "Back" }),
                        React.createElement("ol", { className: "breadcrumb d-none d-lg-inline-flex m-0 docs-breadcrumb" })
                    )
                ),
                React.createElement(
                    "div",
                    { className: "col-md-3 text-left" },
                    React.createElement(Version, { versions: props.versions })
                )
            ),
            React.createElement(
                "div",
                { className: "row p-lg-4" },
                React.createElement(
                    "article",
                    { className: "main-content col-md-9 pr-lg-5" },
                    "Halo"
                ),
                React.createElement(
                    "aside",
                    { className: "col-md-3 d-none d-md-block border-left" },
                    "@yield('aside-right')"
                )
            )
        )
    );
}