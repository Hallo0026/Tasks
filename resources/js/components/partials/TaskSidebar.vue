<template>
    <aside id="task-sidebar" class="">

        <!--<div class="d-flex">
            <button id="toggle-btn" type="button" @click="toggleSidebar">
                <ViewGridOutlineIcon :size="30"/>
            </button>
            <div class="task-sidebar-logo">
                <a href="#" class="text-black">
                    Vinicius
                </a>
            </div>
        </div>-->

        <li class="sidebar-item">

            <span id="close-task-sidebar-icon" class="close-task-sidebar-icon hide" @click="toggleSidebar()">
                <CloseCircleOutline :size="26"/>
            </span>

            <a href="#" class="task-sidebar-link">

                <div>
                    <input
                    class="form-check-input task-checkbox"
                    type="checkbox"
                    :checked="isCompleted"
                    @click="toggleTaskCompletion">
                    <input type="text" class="input-text-task-sidebar task-title" v-model="taskTitle">
                </div>

                <div v-if="taskDescription">
                    <input type="text" class="input-text-task-sidebar task-description" v-model="taskDescription">
                </div>
                <div v-else>
                    <input type="text" class="input-text-task-sidebar task-description" v-model="taskDescription" placeholder="Adicione um comentário">
                </div>

                <div v-if="taskDueTime">
                    <input type="text" class="input-text-task-sidebar task-description" v-model="taskDueTime">
                </div>

                <span class="titulo-item-sidebar"></span>

            </a>
        </li>

        <div class="task-sidebar-footer"></div>

    </aside>
</template>

<script>

import PlusCircleOutlineIcon from 'vue-material-design-icons/PlusCircleOutline.vue';
import ViewGridOutlineIcon from 'vue-material-design-icons/ViewGridOutline.vue';
import CloseCircleOutline from 'vue-material-design-icons/CloseCircleOutline.vue';
import { mapState } from 'vuex';

export default {
    name: 'task-sidebarComponent',
    props: ['appName', 'userId'],
    components: {
        PlusCircleOutlineIcon,
        ViewGridOutlineIcon,
        CloseCircleOutline
    },
    computed: {
        ...mapState('taskDetails', {
            taskDetails: state => state.taskDetails
        }),

        taskTitle() {
            return this.taskDetails ? this.taskDetails.title : '';
        },
        taskDescription() {
            return this.taskDetails ? this.taskDetails.description : '';
        },
        taskDueTime() {
            return this.taskDetails ? this.taskDetails.conclusion_date : '';
        },
        taskStatus() {
            return this.taskDetails ? this.taskDetails.status : '';
        },
        isCompleted() {
            return this.taskDetails ? this.taskDetails.completed : '';
        }
    },
    methods: {
        toggleSidebar() {
            const taskSidebar = document.getElementById('task-sidebar');
            const taskSidebarCloseIcon = document.getElementById('close-task-sidebar-icon');

            taskSidebar.classList.toggle('expand');
            taskSidebarCloseIcon.classList.toggle('hide');
        },

        toggleTaskCompletion() {

                console.log(this.isCompleted);

                if (this.isCompleted) {
                    this.uncompleteTask(this.taskDetails.id);
                } else {
                    this.completeTask(this.taskDetails.id);
                }
            },

            completeTask(taskId) {
                const url = `/api/v1/tasks/${taskId}/complete`;

                axios.post(url)
                    .then(response => {
                        console.log(response.data);
                        this.$emit('task-updated', taskId);
                        this.toggleSidebar();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },

            uncompleteTask(taskId) {

                const url = `/api/v1/tasks/${taskId}/uncomplete`;

                axios.post(url)
                    .then(response => {
                        console.log(response.data);
                        this.isCompleted = false;
                        this.$emit('task-updated', taskId);
                        this.toggleSidebar();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },

            deleteTask(taskId) {

                Swal.fire({
                        //title: "Tem certeza que deseja deletar esta tarefa?",
                        text: "Tem certeza que deseja deletar esta tarefa?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sim, deletar!",
                        cancelButtonText: "Voltar",

                    }).then((result) => {

                    if (result.isConfirmed) {

                        const url = `/api/v1/tasks/${taskId}`;

                        axios.delete(url)
                            .then(response => {
                                console.log(response.data);
                                this.$emit('task-deleted', taskId);
                                this.closeModal();
                            })
                            .catch(error => {
                                console.log(error);
                            });

                            /*Swal.fire({
                            title: "Sucesso!",
                            text: "Sua tarefa foi deletada.",
                            icon: "success"
                            });*/

                    }
                });

            },
    }
};

</script>
<style scoped>

    .input-text-task-sidebar {
        border: none;
        background-color: transparent;
    }

    .input-text-task-sidebar:focus-visible {
        outline: none;
    }

    .task-checkbox {
        cursor: pointer;
        width: 22px;
        height: 22px;
        margin-top: 10px;
        margin-right: 10px;
        border-radius: 36px;
    }

    .close-task-sidebar-icon {
        position: relative;
        top: -15px;
        right: 10px;
        cursor: pointer;
        float: right;
    }

    .task-title {
        font-size: 1.6rem;
        font-weight: 600;
        color: #e3e3e3
    }

    .task-description {
        font-size: 1.2rem;
        color: #a7a7a7;
        margin-left: 34px;
    }

</style>
