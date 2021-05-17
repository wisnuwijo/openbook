'use strict';

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var endpoint = localStorage.getItem('endpoint');

var Api = function Api() {
    _classCallCheck(this, Api);

    this.getVersion = function (topicId) {
        return axios.get(endpoint + '/builder/version/get?', {
            params: {
                topic_id: topicId
            } }).catch(function (err) {
            return err;
        });
    };

    this.addVersion = function (topicId, name) {
        return axios.post(endpoint + '/builder/version/save?', {
            topic_id: topicId,
            name: name
        }).catch(function (err) {
            return err;
        });
    };

    this.getBreakdown = function (versionId, topicId) {
        return axios.get(endpoint + '/builder/breakdown/get', {
            params: {
                version_id: versionId,
                topic_id: topicId
            }
        }).catch(function (err) {
            return err;
        });
    };

    this.saveDocBreakdown = function (formData) {
        var isDataExist = formData === null || formData === undefined || formData === '';
        if (isDataExist) return false;

        return axios.post(endpoint + '/builder/breakdown/save', formData).then(function (res) {
            return res.data;
        }).catch(function (err) {
            return err;
        });
    };

    this.getBreadcrumb = function (breadcrumb) {
        return axios.get(endpoint + '/builder/breadcrumb/get', {
            params: {
                id: breadcrumb
            }
        }).then(function (res) {
            return res.data;
        }).catch(function (err) {
            return err;
        });
    };

    this.updateBreadcrumb = function (breadcrumbId, breadcrumbName) {
        return axios.post(endpoint + '/builder/breadcrumb/update', {
            id: breadcrumbId,
            name: breadcrumbName
        }).then(function (res) {
            return res.data;
        }).catch(function (err) {
            return err;
        });
    };

    this.deleteBreadcrumb = function (breadcrumbId) {
        return axios.post(endpoint + '/builder/breadcrumb/delete', {
            id: breadcrumbId
        }).then(function (res) {
            return res.data;
        }).catch(function (err) {
            return err;
        });
    };

    this.updateTopic = function (topicId, name) {
        return axios.post(endpoint + '/builder/topic/update', {
            topic_id: topicId,
            name: name
        }).then(function (res) {
            return res.data;
        }).catch(function (err) {
            return err;
        });
    };
};

export default Api;