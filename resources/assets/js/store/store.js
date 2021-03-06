import Vue from 'vue';
import Vuex from 'vuex';
import { origin } from '../utils/env';
import { localStorage } from '../storage';
import { coreModule } from './modules/core';
import { userModule } from './modules/user';
import { resourceModule } from './modules/resource';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        scope: "*",
        clientId: 1,
        redirectUri: `${origin()}/`,
    },
    getters: {
        /**
         * Get authorization url for this app.
         */
        getAuthUrl(state) {
            return `/oauth/authorize?client_id=${state.clientId}&redirect_uri=${state.redirectUri}&response_type=token&scope=${state.scope}`;
        }
    },
    modules: {
        core: coreModule,
        user: userModule,
        resource: resourceModule
    },
    plugins: [localStorage.plugin],
});