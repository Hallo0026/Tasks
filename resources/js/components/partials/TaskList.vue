<template>
    <div>
        <card-component v-if="todayTasks.length">
            <template v-slot:header>
                Hoje
            </template>
            <template v-slot>
                <div v-for="task in todayTasks" :key="task.id">
                    <task-component :task="task"></task-component>
                </div>
            </template>
            <template v-slot:footer>
                <!-- Conteúdo do rodapé pode ser adicionado aqui -->
            </template>
        </card-component>


        <card-component v-if="upcomingTasks.length">
            <template v-slot:header>
                Próximos dias
            </template>
            <template v-slot>
                <div v-for="task in upcomingTasks" :key="task.id">
                    <task-component :task="task"></task-component>
                </div>
            </template>
            <template v-slot:footer>
                <!-- Conteúdo do rodapé pode ser adicionado aqui -->
            </template>
        </card-component>


        <card-component v-if="completedTasks.length">
            <template v-slot:header>
                Concluídas
            </template>
            <template v-slot>
                <div v-for="task in tasks" :key="task.id">
                    <task-component :task="task"></task-component>
                </div>
            </template>
            <template v-slot:footer>
                <!-- Conteúdo do rodapé pode ser adicionado aqui -->
            </template>
        </card-component>

    </div>
</template>

<script>
import axios from 'axios';

export default {

    data() {
        return {
            tasks: [],
            todayTasks: [],
            upcomingTasks: [],
            completedTasks: []
        };
    },
    mounted() {
        this.getTasks();
    },
    methods: {
        getTasks() {
            axios.get('/api/v1/tasks')
                .then(response => {
                    this.tasks = response.data;
                    this.todayTasks = response.data.today_tasks;
                    this.upcomingTasks = response.data.upcoming_tasks;
                    this.completedTasks = response.data.completed_tasks;
                })
                .catch(error => {
                    console.error('Error fetching tasks:', error);
                });
        }

    }
};
</script>
