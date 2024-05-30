<template>

    <div class="task row align-items-center">

        <div class="col-auto">
            <input type="hidden" :value="task.id">
            <input
                class="task-checkbox"
                type="checkbox"
                :checked="isCompleted"
                @click="toggleTaskCompletion">
        </div>
        <div class="col">
            <div class="task-title">
                {{ task.title }}
                <!--<span class="task-menu float-end">...</span>-->

                <div class="dropdown float-end">
                    <span class="task-menu dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        ...
                    </span>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Alterar</a></li>
                        <li><hr class="dropdown-divider"></hr></li>
                        <li><a class="dropdown-item" href="#">Adicionar tag</a></li>
                        <li><hr class="dropdown-divider"></hr></li>
                        <li><a class="dropdown-item" href="#">Grupo</a></li>
                        <li><hr class="dropdown-divider"></hr></li>
                        <li><a class="dropdown-item" href="#">Excluir</a></li>
                    </ul>
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

    computed: {
        isCompleted() {
            return this.status === 'completed';
        },
        dueTimeClass() {
            const today = moment();
            let conclusionDateTime;

            if (this.task.conclusion_date) {
                conclusionDateTime = moment(this.task.conclusion_date, 'DD/MM');
            } else if (this.task.conclusion_time) {
                conclusionDateTime = moment(this.task.conclusion_time, 'HH:mm');
                const todayDateStr = today.format('YYYY-MM-DD');
                conclusionDateTime = moment(`${todayDateStr} ${this.task.conclusion_time}`, 'YYYY-MM-DD HH:mm');
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
        }
    }
};

</script>

<style scoped>

    .task {
        padding: 10px;
        /*border: 1px solid #eee;
        border-radius: 4px;*/
        border-bottom: 1px solid #cdcdcd;
        margin-bottom: 10px;
    }

    .task-title {
        font-size: 1.1rem;
        font-weight: 500;
        color: #414141
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
        width: 20px;
        height: 20px;
        margin-top: 6px;
    }

    .task-menu {
        font-size: 1.6rem;
        font-weight: bold;
    }

    .dropdown-toggle::after {
        display: none;
    }

    .due-now {
        color: red;
    }

    .due-soon {
        color: orange;
    }

    .due-later {
        color: darkgreen;
    }

</style>
