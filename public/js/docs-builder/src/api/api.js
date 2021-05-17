'use strict';

const endpoint = localStorage.getItem('endpoint');

class Api {

    getVersion = (topicId) => {
        return axios.get(endpoint + '/builder/version/get?', {
            params: {
                topic_id: topicId
            }}
        )
        .catch(err => err);
    }

    addVersion = (topicId, name) => {
        return axios.post(endpoint + '/builder/version/save?', {
            topic_id: topicId,
            name: name
        })
        .catch(err => err);
    }

    getBreakdown = (versionId, topicId) => {
        return axios.get(endpoint + '/builder/breakdown/get', {
            params: {
                version_id: versionId,
                topic_id: topicId
            }
        })
        .catch(err => err);
    }

    saveDocBreakdown = (formData) => {
        const isDataExist = formData === null || formData === undefined || formData === '';
        if (isDataExist) return false;

        return axios.post(endpoint + '/builder/breakdown/save', formData)
            .then(res => res.data)
            .catch(err => err);
    }

    getBreadcrumb = (breadcrumb) => {
        return axios.get(endpoint + '/builder/breadcrumb/get', {
            params: {
                id: breadcrumb
            }
        })
            .then(res => res.data)
            .catch(err => err);
    }

    updateBreadcrumb = (breadcrumbId, breadcrumbName) => {
        return axios.post(endpoint + '/builder/breadcrumb/update', {
            id: breadcrumbId,
            name: breadcrumbName
        })
            .then(res => res.data)
            .catch(err => err);
    }

    deleteBreadcrumb = (breadcrumbId) => {
        return axios.post(endpoint + '/builder/breadcrumb/delete', {
            id: breadcrumbId
        })
            .then(res => res.data)
            .catch(err => err);
    }

    updateTopic = (topicId, name) => {
        return axios.post(endpoint + '/builder/topic/update', {
            topic_id: topicId,
            name: name
        })
            .then(res => res.data)
            .catch(err => err);
    }
}

export default Api;