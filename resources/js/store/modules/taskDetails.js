const taskDetailsStore = {
    namespaced: true,
    state: () => ({
        taskDetails: {
            id: null,
            name: null,
            description: null,
            status: null,
            task_group_id: null,
            user_id: null,
            task_group: {},
            due_date: null,
            created_at: null,
            updated_at: null,
        },
    }),
    mutations: {
        setTaskDetails(state, task) {
            state.taskDetails = task;
        },
    },
    actions: {
        setTaskDetails({ commit }, task) {
            commit('setTaskDetails', task);
            //console.log('Task details set', task);
        },
    },
    getters: {
        taskDetails(state) {
            return state.taskDetails;
        },
    },
};

export default taskDetailsStore;
