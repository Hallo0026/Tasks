<template>

    <!-- Overdue Tasks -->

    <card-component v-if="overdueTasks.length" :accordionId="'accordion-overdue'" :collapseId="'collapse-overdue'" canHideContent=true>

        <template v-slot:header>
            <span class="text-danger">Em atraso</span>
        </template>

        <template v-slot>
            <div v-for="(task, index) in overdueTasks" :key="task.id">

                <task-component :id="'overdue-' + index" status="overdue"
                :task="task"
                @task-updated="updateTasks"
                @task-deleted="updateTasks">
                </task-component>

            </div>
        </template>

        <template v-slot:footer>
        </template>

    </card-component>


    <!-- Today Tasks -->

    <card-component v-if="todayTasks.length" :accordionId="'accordion-today'" :collapseId="'collapse-today'" canHideContent=true>

        <template v-slot:header>
            Hoje
        </template>

        <template v-slot>
            <div v-for="(task, index) in todayTasks" :key="task.id">

                <task-component :id="'today-' + index" status="uncompleted"
                    :task="task"
                    @task-updated="updateTasks"
                    @task-deleted="updateTasks">
                </task-component>

            </div>
        </template>

        <template v-slot:footer>
            <span class="acorddion-add-button" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                <PlusIcon fillColor="green" style="vertical-align: bottom;"/>
                Adicionar Tarefa
            </span>
        </template>

    </card-component>


    <!-- Upcoming Tasks -->

    <card-component v-if="upcomingTasks.length" :accordionId="'accordion-upcoming'" :collapseId="'collapse-upcoming'" canHideContent=true>

        <template v-slot:header>
            Próximos dias
        </template>

        <template v-slot>
            <div v-for="(task, index) in upcomingTasks" :key="task.id">

                <task-component :id="'upcoming-' + index" status="uncompleted"
                    :task="task"
                    @task-updated="updateTasks"
                    @task-deleted="updateTasks">
                </task-component>

            </div>
        </template>

        <template v-slot:footer>
            <span class="acorddion-add-button" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                <PlusIcon fillColor="green" style="vertical-align: bottom;"/>
                Adicionar Tarefa
            </span>
        </template>

    </card-component>


    <!-- Completed Tasks -->

    <card-component v-if="completedTasks.length" :accordionId="'accordion-completed'" :collapseId="'collapse-completed'" canHideContent=true>

        <template v-slot:header>
            Concluídas
        </template>

        <template v-slot>
            <div v-for="(task, index) in completedTasks" :key="task.id">

                <task-component :id="'completed-' + index" status="completed"
                    :task="task"
                    @task-updated="updateTasks"
                    @task-deleted="updateTasks">
                </task-component>

            </div>
        </template>

        <template v-slot:footer>
        </template>

    </card-component>


    <div class="row" v-if="!tasksfound">
        <div class="col" style="margin: 20px 10px 10px 10px; padding-top: 4px;">

            <div class="cont-empty-page">

                <h5>Quais são seus próximos objetivos?</h5>

                <span class="acorddion-add-button p-0 ms-0" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                    <PlusIcon fillColor="green" style="vertical-align: bottom;"/>
                    Adicionar Tarefa
                </span>

            </div>

        </div>
    </div>


    <modal-component modalId="addTaskModal">

        <template v-slot:title>
            Adicionar tarefa
        </template>
        <template v-slot:body>
            <create-task-form-component @submit="handleFormSubmit" @task-created="updateTasks"></create-task-form-component>
        </template>

    </modal-component>

    <task-sidebar-component
        @task-updated="updateTasks"
        @task-deleted="updateTasks">
    </task-sidebar-component>

</template>

<script>

    import PlusIcon from 'vue-material-design-icons/Plus.vue';
    import axios from 'axios';

    export default {

        components: {
            PlusIcon
        },
        data() {
            return {
                tasksfound: false,
                tasks: [],
                todayTasks: [],
                upcomingTasks: [],
                completedTasks: [],
                overdueTasks: []
            };
        },
        mounted() {
            this.getTasks();
        },
        methods: {

            getTasks() {

                axios.get('/api/v1/tasks')
                    .then(response => {

                        this.tasksfound = true;
                        this.tasks = response.data;
                        this.todayTasks = response.data.today_tasks;
                        this.upcomingTasks = response.data.upcoming_tasks;
                        this.completedTasks = response.data.completed_tasks;
                        this.overdueTasks = response.data.overdue_tasks;

                    })
                    .catch(error => {

                        console.error('Error fetching tasks:', error);
                        if ((error.response.status == 404) && (error.response.data.message == 'No tasks found')) {
                            console.log("No tasks found");
                            this.tasksfound = false;
                        }

                    });
            },

            updateTasks() {

                this.tasks = [];
                this.todayTasks = [];
                this.upcomingTasks = [];
                this.completedTasks = [];
                this.overdueTasks = [];
                this.getTasks();

            },


        }
    };
</script>
