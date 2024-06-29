<template>

    <div :class="['group', 'row', 'align-items-center']">

        <div class="col-auto">
        </div>
        <div class="col" @click="showGroupDetails()">

            <div class="row-group-title">

                <span class="group-title">
                    {{ group.name }}
                </span>


                <div class="dropdown float-end">

                    <span class="group-menu dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <StarOutline :size="22" />
                    </span>

                </div>

            </div>

            <div class="group-description">{{ group.description }}</div>

            <div :class="['group-due-time', dueTimeClass]" v-if="!isCompleted">
                {{ group.conclusion_date }} {{ group.conclusion_time }}
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
        name: 'groupComponent',
        props: {
            group: {
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
                isGroupSidebarExpanded: false
            };
        },
        computed: {

            ...mapState('groupDetails', {
                groupDetails: state => state.groupDetails
            }),

        },

        methods: {

            deletegroup(groupId) {

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

                        const url = `/api/v1/groups/${groupId}`;

                        axios.delete(url)
                            .then(response => {
                                console.log(response.data);
                                this.$emit('group-deleted', groupId);
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


            ...mapActions('groupDetails', ['setGroupDetails']),

            showGroupDetails() {

                const groupSidebar = document.getElementById('group-sidebar');
                const closeGroupSidebarIcon = document.getElementById('close-group-sidebar-icon');

                this.setGroupDetails(this.group);

                this.isSidebarExpanded = !this.isSidebarExpanded;

                groupSidebar.classList.toggle('expand');
                closeGroupSidebarIcon.classList.toggle('hide');

            },

        },

        watch: {
            group(newgroup) {
                this.setGroupDetails(newgroup);
            },
        },

    };

</script>

<style scoped>

    .group {
        min-height: 72px;
        /*border-bottom: 1px solid #e7e7e7;*/
        margin: 0;
        cursor: pointer;
    }

    .group:hover {
        background-color: #313131;
        border-radius: 8px;
    }

    .group-title {
        font-size: 1.1rem;
        font-weight: 500;
        color: #e3e3e3;
    }

    .group-description {
        font-size: .9rem;
        color: #a7a7a7
    }

    .group-due-time {
        font-size: .8rem;
        font-weight: 600;
        color: darkgreen;
    }

    .group-checkbox {
        cursor: pointer;
        width: 22px;
        height: 22px;
        margin-top: 6px;
        border-radius: 36px;
        background-color: #e3e3e3;
        border: 1px solid #2b2b2b;
    }

    .group-checkbox:checked {
        background-color: darkgreen;
    }

    .group-menu {
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

    .overdue-group {
        margin-bottom: 4px;
    }

</style>
