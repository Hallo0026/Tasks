<template>

    <div :class="['task', 'row', 'align-items-center', overdueTask]">

        <div class="col-auto">
            <input type="hidden" :value="task.id">
            <input
                class="form-check-input task-checkbox"
                type="checkbox"
                :checked="isCompleted"
                @click="toggleTaskCompletion">
        </div>
        <div class="col" @click="showTaskDetails()">

            <div class="row-task-title">

                <span class="task-title">
                    {{ task.title }}
                </span>


                <div class="dropdown float-end">

                    <span class="task-menu dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <StarOutline :size="22" />
                    </span>

                </div>

            </div>

            <div class="task-description">{{ task.description }}</div>

            <div :class="['task-due-time', dueTimeClass]" v-if="!isCompleted">
                {{ task.conclusion_date }} {{ task.conclusion_time }}
            </div>

        </div>

    </div>

</template>

<script>

    import axios from 'axios';
    import moment from 'moment';
    import Swal from 'sweetalert2';
    import StarOutline from 'vue-material-design-icons/StarOutline.vue';
    import { mapState, mapActions } from 'vuex';

    export default {
        name: 'TaskComponent',
        props: {
            task: {
                type: Object,
                required: true
            },
            status: {
                type: String,
                required: true
            }
        },
        components: {
            StarOutline
        },
        data() {
            return {
                isTaskSidebarExpanded: false
            };
        },
        computed: {

            ...mapState('taskDetails', {
                taskDetails: state => state.taskDetails
            }),

            isCompleted() {
                return this.status === 'completed';
            },

            dueTimeClass() {

                const today = moment();
                let conclusionDateTime;

                if (this.task.conclusion_date && this.task.conclusion_time) {
                    //conclusionDateTime = moment(this.task.conclusion_date, 'YYYY-MM-DD HH:mm:ss');
                    conclusionDateTime = moment(this.task.conclusion_date + ' ' + this.task.conclusion_time);
                }

                if (!conclusionDateTime) {
                    return 'no-due-date';
                }

                const diff = conclusionDateTime.diff(today);
                const diffInMinutes = moment.duration(diff).asMinutes();

                if (diffInMinutes <= 0) {
                    return 'due-now';
                } else if (diffInMinutes <= 180) { // within 3 hours
                    return 'due-soon';
                } else {
                    return 'due-later';
                }
            },
            overdueTask() {

                if(this.status == 'overdue') {
                    return 'overdue-task';
                }

            }

        },

        methods: {

            toggleTaskCompletion() {
                if (this.isCompleted) {
                    this.uncompleteTask(this.task.id);
                } else {
                    this.completeTask(this.task.id);
                }
            },

            completeTask(taskId) {
                const url = `/api/v1/tasks/${taskId}/complete`;

                axios.post(url)
                    .then(response => {
                        console.log(response.data);
                        this.$emit('task-updated', taskId);
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
                        this.$emit('task-updated', taskId);
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

            closeModal() {
                this.$refs.closeModalBtn.click();
            },

            ...mapActions('taskDetails', ['setTaskDetails']),

            showTaskDetails() {

                const taskSidebar = document.getElementById('task-sidebar');
                const closeTaskSidebarIcon = document.getElementById('close-task-sidebar-icon');

                this.setTaskDetails(this.task);

                this.isSidebarExpanded = !this.isSidebarExpanded;

                taskSidebar.classList.toggle('expand');
                closeTaskSidebarIcon.classList.toggle('hide');

            },


        },

        watch: {
            task(newTask) {
                this.setTaskDetails(newTask);
            },
        },

    };

</script>

<style scoped>

    .task {
        min-height: 72px;
        /*border-bottom: 1px solid #e7e7e7;*/
        margin: 0;
        cursor: pointer;
    }

    .task:hover {
        background-color: #313131;
        border-radius: 8px;
    }

    .task-title {
        font-size: 1.1rem;
        font-weight: 500;
        color: #e3e3e3;
    }

    .task-description {
        font-size: .9rem;
        color: #a7a7a7
    }

    .task-due-time {
        font-size: .8rem;
        font-weight: 600;
        color: darkgreen;
    }

    .task-checkbox {
        cursor: pointer;
        width: 22px;
        height: 22px;
        margin-top: 6px;
        border-radius: 36px;
        background-color: #e3e3e3;
        border: 1px solid #2b2b2b;
    }

    .task-checkbox:checked {
        background-color: darkgreen;
    }

    .task-menu {
        margin-top: -14px;
        font-size: 1.6rem;
        font-weight: bold;
    }

    .dropdown-toggle::after {
        display: none;
    }

    .due-now {
        color: #dc3545;
    }

    .due-soon {
        color: orange;
    }

    .due-later {
        color: darkgreen;
    }

    .overdue-task {
        margin-bottom: 4px;
    }

</style>
