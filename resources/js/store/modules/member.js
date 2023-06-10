import * as types from '../mutation-types'
// state
export const state = {
  classGroupList: null,
  teacherList:null,
  selectedTeacher:null,
  selectedGroup: null,
  selectedOne: null,
  clubMembers:[],
  clubName:'',
  specUsers:[],
  dutyUsers:[],
}

// getters
export const getters = {
  classGroupList: state => state.classGroupList,
  teacherList: state => state.teacherList,
  selectedTeacher: state => state.selectedTeacher,
  selectedGroup: state => state.selectedGroup,
  selectedOne: state => state.selectedOne,
  clubMembers:  state=>state.clubMembers,
  clubName: state=>state.clubName,
  specUsers:state=>state.specUsers,
  dutyUsers:state=>state.dutyUsers,
}

// mutations
export const mutations = {
    [types.STORE_CLASS_GROUP_LIST] (state, classGroupList ) {
        state.classGroupList = classGroupList
    },
    [types.STORE_TEACHER_LIST] (state, teacherList ) {
        state.teacherList = teacherList
    },
    [types.STORE_SELECTED_TEACHER] (state, selectedTeacher ) {
        state.selectedTeacher = selectedTeacher
    },
    [types.STORE_SELECTED_GROUP] (state, selectedGroup ) {
        state.selectedGroup = selectedGroup
    },
    [types.STORE_SELECTED_ONE] (state, selectedOne ) {
        state.selectedOne = selectedOne
    },
    [types.STORE_CLUB_MEMBERS] (state, selUsers ) {
        state.clubMembers = selUsers
    },
    [types.STORE_CLUB_NAME] (state, clubName ) {
        state.clubName = clubName
    },
    [types.STORE_SPEC_USERS] (state,selUsers){
        state.specUsers = selUsers
    },
    [types.STORE_DUTY_USERS] (state,selUsers){
        state.dutyUsers = selUsers
    }
}

// actions
export const actions = {
    storeClassGroupList ({ commit }, payload) {
        commit(types.STORE_CLASS_GROUP_LIST, payload)
    },
    storeTeacherList ({ commit }, payload) {
        commit(types.STORE_TEACHER_LIST, payload)
    },
    storeSelectedTeacher ({ commit }, payload) {
        commit(types.STORE_SELECTED_TEACHER, payload)
    },
    storeSelectedGroup ({ commit }, payload) {
        commit(types.STORE_SELECTED_GROUP, payload)
    },
    storeSelectedOne ({ commit }, payload) {
        commit(types.STORE_SELECTED_ONE, payload)
    },
    storeClubMembers ({ commit }, payload) {
        commit(types.STORE_CLUB_MEMBERS, payload)
    },
    storeClubName ({ commit }, payload) {
        commit(types.STORE_CLUB_NAME, payload)
    },
    storeSpecUsers ({ commit }, payload) {
        commit(types.STORE_SPEC_USERS, payload)
    },
    storeDutyUsers ({ commit }, payload) {
        commit(types.STORE_DUTY_USERS, payload)
    },
}
