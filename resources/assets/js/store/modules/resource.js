import { api } from "../../api/http";
import * as URLs from "../../api/resources";
import * as MUTATIONS from "../mutation-types";
import Notification from '../../utils/notification';

class Resource {
    constructor(name, listUrl, showUrl, createUrl, updateUrl, deleteUrl) {
        this.data = [];
        this.query = "";
        this.name = name.toLowerCase();
        this.listUrl = listUrl;
        this.showUrl = showUrl;
        this.createUrl = createUrl;
        this.updateUrl = updateUrl;
        this.deleteUrl = deleteUrl;
    }

    getQuery() {
        return this.query;
    }

    setQuery(value) {
        this.query = value;
    }

    getData() {
        return this.data;
    }

    setData(value) {
        this.data = value;
    }
}

const resourceList = [
    "user",
    "job",
    "schedule",
    "timesheet",
    "request",
    "activity",
    "form",
    "contact",
    "comment",
    "role"
];

export const resourceModule = {
    namespaced: true,

    state: {
        resources: initResources(),
        scheduleView: '',
    },

    getters: {
        getList: state => (resName, callback) => {
            let res = state.resources.find(item => item.name === resName);
            if (!res.data) return [];
            return callback === undefined ? res.getData() : res.getData().filter(callback);
        }
    },

    mutations: {
        [MUTATIONS.RESOURCE_QUERY](state, payload) {
            payload.resource.query = payload.query;
        },

        [MUTATIONS.RESOURCE_UPDATE](state, payload) {
            payload.resource.setData(payload.data);
        },

        [MUTATIONS.RESOURCE_CLEAR](state, payload) {
            payload.resource.setQuery('');
            payload.resource.setData([]);
        },
    },

    actions: {
        list({ state, commit, dispatch }, { resource, query }) {
            dispatch("checkResource", resource);
            let res = state.resources.find(item => item.name === resource);
            return new Promise((resolve, reject) => {
                api.get(res.listUrl, query)
                    .then(respond => {
                        let data = null;
                        if (respond.data.per_page)
                            data = respond.data.data;
                        else
                            data = respond.data;
                        commit(MUTATIONS.RESOURCE_QUERY, { resource: res, query: query });
                        commit(MUTATIONS.RESOURCE_UPDATE, { resource: res, data: data });
                        resolve(respond.data);
                    }).catch(error => {
                        console.log(error);
                        dispatch('handleError', error);
                        reject(error);
                    });
            });
        },

        create({ state, dispatch }, { resource, data }) {
            dispatch("checkResource", resource);
            let res = state.resources.find(item => item.name === resource);
            return new Promise((resolve, reject) => {
                api.post(res.createUrl, data)
                    .then(respond => {
                        resolve(respond.data);
                    }).catch(error => {
                        console.log(error);
                        dispatch('handleError', error);
                        reject(error);
                    });
            });
        },

        show({ state, dispatch }, { resource, id, query }) {
            dispatch("checkResource", resource);
            let res = state.resources.find(item => item.name === resource);
            return new Promise((resolve, reject) => {
                api.get(`${res.showUrl}/${id}`, query)
                    .then(respond => {
                        resolve(respond.data);
                    }).catch(error => {
                        console.log(error);
                        dispatch('handleError', error);
                        reject(error);
                    });
            });
        },

        update({ state, dispatch }, { resource, id, data }) {
            dispatch("checkResource", resource);
            let res = state.resources.find(item => item.name === resource);
            return new Promise((resolve, reject) => {
                api.post(`${res.updateUrl}/${id}`, data)
                    .then(respond => {
                        resolve(respond.data);
                    }).catch(error => {
                        console.log(error);
                        dispatch('handleError', error);
                        reject(error);
                    });
            });
        },

        delete({ state, dispatch }, { resource, id }) {
            dispatch("checkResource", resource);
            let res = state.resources.find(item => item.name === resource);
            return new Promise((resolve, reject) => {
                api.post(`${res.deleteUrl}/${id}`)
                    .then(respond => {
                        resolve(respond.data);
                    }).catch(error => {
                        console.log(error);
                        dispatch('handleError', error);
                        reject(error);
                    });
            });
        },

        onServerUpdate({ state, dispatch }, resource) {
            dispatch("checkResource", resource);
            let res = state.resources.find(item => item.name === resource);
            dispatch('list', { resource: res.name, query: res.query });
        },

        clearResource({ state, commit, dispatch }, resource) {
            dispatch("checkResource", resource);
            let res = state.resources.find(item => item.name === resource);
            commit(MUTATIONS.RESOURCE_CLEAR, { resource: res });
        },

        checkResource({ state }, resource) {
            if (resourceList.indexOf(resource) === -1)
                throw new Error(`Invalid resource name: ${resource}`);
        },

        handleError({ dispatch }, req) {
            let msg = '';
            let type = 'error';
            let title = 'Whoops';
            let autohide = false;
            let error = req.response.data;

            // Notify user about the error.            
            if (error.code == 1002) {                
                type = 'warning';
                title = 'Auth Error';
                msg = 'You are not logged in, please logout and login again.';
            } else if (error.code == 1003) {                
                type = 'warning';
                title = 'Permission Error';
                msg = 'You are not allowed to do this action, please check your permissions.';
            } else if (error.code == 1004) {
                autohide = true;
                msg = 'The data is invalid or in a bad format, please try again.';
            } else if (error.code == 1005) {
                msg = 'Server side error, something went wrong while processing your request, please try again later.';
            }

            dispatch('core/notify', new Notification({
                type: type,
                title: title,
                message: msg,
                autoHide: autohide
            }), { root: true });
        }
    }
}

function initResources() {
    let list = [];
    resourceList.forEach(res => {
        res = res.toUpperCase();
        list.push(new Resource(
            res,
            URLs[`${res}_LIST`],
            URLs[`${res}_SHOW`],
            URLs[`${res}_CREATE`],
            URLs[`${res}_UPDATE`],
            URLs[`${res}_DELETE`]
        ));
    });
    return list;
}