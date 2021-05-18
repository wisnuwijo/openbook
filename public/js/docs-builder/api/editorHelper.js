'use strict';

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var endpoint = localStorage.getItem('endpoint');

var EditorHelper = function EditorHelper() {
    var _this = this;

    _classCallCheck(this, EditorHelper);

    this.getData = function (activeBreadownId) {
        return axios.get(endpoint + '/builder/editor/get', {
            params: {
                'breakdown_id': activeBreadownId
            }
        });
    };

    this.save = function (editor, activeBreadownId) {
        editor.save().then(function (outputData) {
            console.log('Article data: ', outputData);
            _this.saveToDB(outputData, activeBreadownId);
        }).catch(function (error) {
            console.log('Saving failed: ', error);
        });
    };

    this.saveToDB = function (outputData, activeBreadownId) {
        // save-doc-detail
        axios.post(endpoint + '/builder/editor/save', {
            documentation_breakdown_id: activeBreadownId,
            content: JSON.stringify(outputData),
            created_by: 2
        }).then(function (res) {
            return console.log(res.data.data);
        }).catch(function (err) {
            return console.log(err);
        });
    };
};

export default EditorHelper;