import './bootstrap';
import { createApp } from 'vue';
import { createStore } from 'vuex';
import taskDetailsStore from './store/modules/taskDetails';
import groupDetailsStore from './store/modules/groupDetails';

const store = createStore({
    modules: {
        taskDetails: taskDetailsStore,
        groupDetails: groupDetailsStore,
    },
});


const app = createApp({});

app.use(store);


import LoginComponent from './components/Login.vue';
import TaskSidebar from './components/partials/TaskSidebar.vue';
import GroupSidebar from './components/partials/GroupSidebar.vue';
import Sidebar from './components/partials/Sidebar.vue';
import TaskListComponent from './components/TaskList.vue';
import GroupListComponent from './components/GroupList.vue';
import CardComponent from './components/partials/Card.vue';
import TaskComponent from './components/partials/Task.vue';
import GroupComponent from './components/partials/Group.vue';
import ModalComponent from './components/partials/Modal.vue';
import CreateTaskModal from './components/partials/CreateTaskModal.vue';
import CreateGroupModal from './components/partials/CreateGroupModal.vue';

app.component('login-component', LoginComponent);
app.component('sidebar-component', Sidebar);
app.component('task-sidebar-component', TaskSidebar);
app.component('group-sidebar-component', GroupSidebar);
app.component('task-list-component', TaskListComponent);
app.component('group-list-component', GroupListComponent);
app.component('card-component', CardComponent);
app.component('task-component', TaskComponent);
app.component('group-component', GroupComponent);
app.component('modal-component', ModalComponent);
app.component('create-task-form-component', CreateTaskModal);
app.component('create-group-form-component', CreateGroupModal);


// Função global para formatar datas no formato BR
app.config.globalProperties.$formatDate = function(value) {
    if (value) {
        const datePart = value.split('-');
        if (datePart.length === 3) {
            return `${datePart[2]}/${datePart[1]}/${datePart[0]}`;
        }
    }
    return value;
};

app.use(store);
app.mount('#app');
