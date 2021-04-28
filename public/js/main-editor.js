class EditorHelper {

    getData = (activeBreadownId) => {
        return axios.get(endpoint + '/builder/editor/get', {
            params: {
                'breakdown_id': activeBreadownId
            }
        });
    }

    save = (editor, activeBreadownId) => {
        editor.save().then((outputData) => {
            // console.log('Article data: ', outputData)
            this.saveToDB(outputData, activeBreadownId);
        }).catch((error) => {
            // console.log('Saving failed: ', error)
        });
    }

    saveToDB = (outputData, activeBreadownId) => {
        // save-doc-detail
        axios.post(endpoint + '/builder/editor/save', {
            documentation_breakdown_id: activeBreadownId,
            content: JSON.stringify(outputData),
            created_by: 2
        })
            .then(res => console.log(res.data.data))
            .catch(err => console.log(err));
    }
}

const editorFile = $('script[src*=main-editor]');
const endpoint = editorFile.attr('endpoint');
const token = editorFile.attr('token');
const userId = editorFile.attr('user-id');

const editorHelper = new EditorHelper();

let activePageId = 0;
let activePageData = {};

const editor = new EditorJS({
    holder: 'editorjs',
    placeholder: 'Let`s write an awesome documentation!',
    autofocus: true,
    tools: {
        image: SimpleImage,
        code: CodeTool,
        warning: Warning,
        raw: RawTool,
        table: {
            class: Table,
        },
        header: {
            class: Header,
            inlineToolbar: true
        },
        list: List
    },
    data: activePageData,
    onChange: () => {
        editor.save().then((outputData) => {
            // console.log('currHash', activePageId);
            // console.log('Article data: ', outputData)
            editorHelper.saveToDB(outputData, activePageId);
        }).catch((error) => {
            // console.log('Saving failed: ', error)
        });
    }
});

window.addEventListener("hashchange", function () {
    let currHash = location.hash.substring(1).split('-');
    let breaddownChildren = currHash[1];

    activePageId = currHash[0];

    editorHelper.getData(activePageId)
        .then(res => {
            try {
                activePageData = JSON.parse(res.data.data.content);
            } catch (error) {
                activePageData = {
                    blocks: []
                };
            }

            if (activePageData.blocks.length <= 0) {
                activePageData = {"time":1619585697328,"blocks":[{"type":"paragraph","data":{"text":""}}],"version":"2.20.2"};
            }

            editor.isReady.then(() => {
                // only show breakdown that doesn't have children
                if (parseInt(breaddownChildren) == 0) {
                    editor.render(activePageData);
                }
            })
        })
});