const groupDetailsStore = {
    namespaced: true,
    state: () => ({
        groupDetails: {
            id: null,
            name: null,
            description: null,
        },
    }),
    mutations: {
        setGroupDetails(state, group) {
            state.groupDetails = group;
        },
    },
    actions: {
        setGroupDetails({ commit }, group) {
            commit('setGroupDetails', group);
            console.log('Group details set', group);
        },
    },
    getters: {
        groupDetails(state) {
            return state.groupDetails;
        },
    },
};

export default groupDetailsStore;
