'use strict';

const docsFile = $('script[src*=docs]');
const endpoint = docsFile.attr('endpoint');
const token = docsFile.attr('token');

const e = React.createElement;

class LikeButton extends React.Component {
    constructor(props) {
        super(props);
        this.state = { 
            liked: false,
            breakdown: null
        }
    }

    generateElement = (data, parentId = null) => {
        let newList = '';
        for (let i = 0; i < data.length; i++) {
            const element = data[i];
            const hasChildren = element.children.length > 0;

            newList += `<li ${hasChildren ? ' class="sidebar-dropdown"' : ''}>
                <a href="#"><span class="menu-text">${element.name}</span> </a>
                ${hasChildren
                    ? `<div class="sidebar-submenu">
                            <ul>${this.generateElement(element.children, element.id)}</ul>
                        </div>`
                    : ``
                }
            </li>
            `;
        }

        // add heading btn
        newList += `<li>
            <form method="post" class="add-heading-form">
                <table>
                    <tr>
                        <td>
                            <input type="hidden" name="_token" value="${token}" />
                            <input type="hidden" name="parent_id" value="${parentId}" />
                            <input type="text" name="name" class="form-control underline-input" placeholder="Add New Heading" />
                        </td>
                        <td>
                            <button class="check-btn" type="submit"><i class="fa fa-check"></i></button>
                        </td>
                    </tr>
                </table>
            </form>
        </li>`;

        return newList;
    }

    componentDidMount() {
        axios.get(endpoint + '/doc-breakdown', {
            params: {
                version_id: 2,
                topic_id: 2
            }
        })
        .then(res => this.render(res.data.data))
        .catch(err => console.log(err));
    }

    render() {
        if (this.state.liked) {
            return 'You liked this.';
        }

        // return e(
        //     'button',
        //     { onClick: () => this.setState({ liked: true }) },
        //     'Like'
        // );
        return '<b>Hello</b>';
    }
}

const domContainer = document.querySelector('.sidebar-ul');
ReactDOM.render(e(LikeButton), domContainer);