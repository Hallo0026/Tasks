<template>

    <!-- Overdue Tasks -->

    <card-component v-if="groups.length" :accordionId="'accordion-overdue'" :collapseId="'collapse-overdue'" canHideContent=true>

        <template v-slot:header>
            <span>Grupos</span>
        </template>

        <template v-slot>
            <div v-for="(group, index) in groups" :key="group.id">

                <group-component :id="'overdue-' + index" status="overdue"
                :group="group"
                @task-updated="updateGroups"
                @task-deleted="updateGroups">
                </group-component>

            </div>
        </template>

        <template v-slot:footer>
        </template>

    </card-component>


    <div class="row text-center" v-if="!groupFound">
        <div class="col" style="margin: 20px 10px 10px 10px; padding-top: 4px;">

            <div class="cont-empty-page">

                <h5>Está um pouco vazio por aqui.</h5>

                <p>Que tal criar grupos para organizar suas tarefas?</p>

                <span class="acorddion-add-button p-0 ms-0" data-bs-toggle="modal" data-bs-target="#addGroupModal">
                    <PlusIcon fillColor="green" style="vertical-align: bottom;"/>
                    Adicionar Grupo
                </span>

            </div>

        </div>
    </div>


    <modal-component>

        <template v-slot:title>
            Adicionar Grupo
        </template>
        <template v-slot:body>
            <create-group-form-component @submit="handleFormSubmit" @group-created="updateGroups"></create-group-form-component>
        </template>

    </modal-component>

    <group-sidebar-component
        @task-updated="updateTasks"
        @task-deleted="updateTasks">
    </group-sidebar-component>

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
                groupFound: false,
                groups: [],
            };
        },
        mounted() {
            this.getGroups();
        },
        methods: {

            getGroups() {

                axios.get('/api/v1/groups')
                    .then(response => {

                        this.groupFound = true;
                        this.groups = response.data;

                        console.log(this.groups);
                    })
                    .catch(error => {

                        console.error('Error fetching groups:', error);
                        if ((error.response.status == 404) && (error.response.data.message == 'No groups found')) {
                            console.log("No groups found");
                            this.groupFound = false;
                        }

                    });
            },

            updateGroups() {

                this.groups = [];
                this.getGroups();

            },


        }
    };
</script>
