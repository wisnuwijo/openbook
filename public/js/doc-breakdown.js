const docBreakdownFile = $('script[src*=doc-breakdown]');
const endpoint = docBreakdownFile.attr('endpoint');
const token = docBreakdownFile.attr('token');

class DocBreadown {
    
    getDocBreakdownAndRenderData = () => {
        axios.get(endpoint + '/doc-breakdown', {
            params: {
                version_id: 2,
                topic_id: 2
            }
        })
        .then(res => this.render(res.data.data))
        .catch(err => console.log(err));
    }

    dropdownOnclickHandler = () => {
        $(".sidebar-dropdown > a").click(function () {
            $(".sidebar-submenu").slideUp(200);
            if ($(this).parent().hasClass("active")) {
                $(".sidebar-dropdown").removeClass("active");
                $(this).parent().removeClass("active");
            } else {
                $(".sidebar-dropdown").removeClass("active");
                $(this).next(".sidebar-submenu").slideDown(200);
                $(this).parent().addClass("active");
            }

        });
    }

    generateElement = (data, parentId = null) => {
        let newList = '';
        for (let i = 0; i < data.length; i++) {
            const element = data[i];
            const hasChildren = element.children.length > 0;

            newList += `<li ${hasChildren ? ' class="sidebar-dropdown"' : ''}>
                <a href="#"><span class="menu-text">${element.name}</span> </a>
                ${
                    hasChildren 
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

    render = (data) => {
        const el = this.generateElement(data);

        var app = document.querySelector('.sidebar-ul');
        app.innerHTML = el;
        
        this.dropdownOnclickHandler();
    }
}

const docBreakdown = new DocBreadown();
docBreakdown.getDocBreakdownAndRenderData();