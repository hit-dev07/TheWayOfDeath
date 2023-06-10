import * as types from '../mutation-types';

// state
export const state = {
    singleData: null,
    multiData: null,
    qaData: null,
    statData: null,
    scoringData: null,
    postNew:false,
    postDetail:null,
    postTempData:null,
}

// getters
export const getters = {
    singleData: state => state.singleData,
    multiData: state => state.multiData,
    qaData: state => state.qaData,
    statData: state => state.statData,
    scoringData: state => state.scoringData,
    postNew: state => state.postNew,
    postDetail:state=> state.postDetail,
    postTempData:state=> state.postTempData,
}

// mutations
export const mutations = {
    [types.STORE_SINGLE_DATA] (state,  contentData ) {
        state.singleData = contentData
    },
    [types.STORE_MULTI_DATA] (state,  contentData ) {
        state.multiData = contentData
    },
    [types.STORE_QA_DATA] (state,  contentData ) {
        state.qaData = contentData
    },
    [types.STORE_STAT_DATA] (state,  contentData ) {
        state.statData = contentData
    },
    [types.STORE_SCORING_DATA] (state,  contentData ) {
        state.scoringData = contentData
    },
    [types.STORE_POST_NEW] (state, payload){
        state.postNew = payload
    },
    [types.STORE_POST_DETAIL] (state, payload){
        state.postDetail = payload
    },
    [types.STORE_POST_TEMPDATA] (state, payload){
        state.postTempData = payload
    },
    
}

// actions
export const actions = {
    storeSingleData ({ commit }, payload) {
        commit(types.STORE_SINGLE_DATA, payload)
    },
    storeMultiData ({ commit }, payload) {
        commit(types.STORE_MULTI_DATA, payload)
    },
    storeQaData ({ commit }, payload) {
        commit(types.STORE_QA_DATA, payload)
    },
    storeStatData ({ commit }, payload) {
        commit(types.STORE_STAT_DATA, payload)
    },
    storeScoringData ({ commit }, payload) {
        commit(types.STORE_SCORING_DATA, payload)
    },
    storePostNew({commit},payload) {
        commit(types.STORE_POST_NEW, payload)
    },
    storePostDetail({commit},payload) {
        commit(types.STORE_POST_DETAIL, payload)
    },
    storePostTempData({commit},payload) {
        commit(types.STORE_POST_TEMPDATA, payload)
    },
}
