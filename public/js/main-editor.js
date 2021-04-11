const editorFile = $('script[src*=main-editor]');
const endpoint = editorFile.attr('endpoint');
const token = editorFile.attr('token');

const editor = new EditorJS({
    /** 
     * Id of Element that should contain the Editor 
     */
    holder: 'editorjs',

    placeholder: 'Let`s write an awesome documentation!',
    autofocus: true,

    /**
     * Available Tools list.
     * Pass Tool's class or Settings object for each Tool you want to use
     */
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
    data: {},

    /**
    * onChange callback
    */
    onChange: () => {
        const editorHelper = new EditorHelper();

        editorHelper.save();
    }
});

class EditorHelper {

    save = () => {
        editor.save().then((outputData) => {
            console.log('Article data: ', outputData)
            this.saveToDB(outputData);
        }).catch((error) => {
            console.log('Saving failed: ', error)
        });
    }

    saveToDB = (outputData) => {
        console.log('save to DB', [endpoint, outputData]);
        
        // save-doc-detail
        axios.post(endpoint + '/save-doc-detail', {
            documentation_breakdown_id: 2,
            content: JSON.stringify(outputData),
            created_by: 2,
            _token: token
        })
        .then(res => this.render(res.data.data))
        .catch(err => console.log(err));
    }
}